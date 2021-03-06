<?php

namespace Budget\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Budget\Budget;
use Budget\Http\Requests;
use Budget\Http\Controllers\Controller;
use Budget\Exceptions\JsonException;

class BudgetController extends Controller
{
    /**
     * Holds the basedate month from the Request
     * @var Carbon\Carbon
     */
    protected $month;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->month = (new Carbon($request->get('basedate')))->startOfMonth();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $incomePct = 0;
        $expensePct = 0;
        $net = 0;

        $budgets = Budget::month($this->month)->get()->groupBy('type');

        if (isset($budgets['Income']) && isset($budgets['Expense'])){
            $totalIncome = $budgets['Income']->sum('amount');
            $totalExpense = $budgets['Expense']->sum('amount');
            $max = max($totalIncome, $totalExpense);
            $incomePct = $totalIncome / $max * 100;
            $expensePct = $totalExpense / $max * 100;
            $net = $totalIncome - $totalExpense;
        }
        
        return view('budgets.index', [
            'budgets' => $budgets,
            'basedate' => $this->month,
            'incomePct' => $incomePct,
            'expensePct' => $expensePct,
            'net' => $net,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('budgets.create', [
            'basedate' => $this->month,
            ]);
    }


    /**
     * Create a new transcation record
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $post['month'] = $this->month->toDateTimeString();

        $b = Budget::create($post);
        $b->save();

        $request->session()->flash('alert-success', "New $b->type budget saved for $b->category in ".$this->month->format('F Y'));

        return $this->index($request);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $b = Budget::findOrFail($id);
            if (!$b->isFillable($request->input('name')))
                throw new \Exception('Invalid field name');
            $b->setAttribute($request->input('name'), $request->input('value'));
            $b->save();
        } catch (\Exception $e) {
            throw new JsonException($e);
        }
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $b = Budget::findOrFail($id);
            $b->delete();
            return response()->json(['status'=>'success']);
        } catch (\Exception $e) {
            throw new JsonException($e);
        }
    }


    /**
     * Copies budgets from the previous month
     * 
     */
    public function copy() {

        $budgets = Budget::month($this->month->subMonth())->get();

        $month = $this->month->addMonth();

        $budgets->each(function($item, $key) use ($month) {
            $b = new Budget([
                    'category'  => $item->category,
                    'amount'    => $item->amount,
                    'variable'  => $item->variable,
                    'type'      => $item->type,
                    'month'     => $month,
                ]);

            try {
                $b->save();
            } catch (\Exception $ignored) {}
        });

        return $this->index();
    }


}
