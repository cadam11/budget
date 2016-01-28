<?php

namespace Budget\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Budget\Budget;
use Budget\Http\Requests;
use Budget\Http\Controllers\Controller;

class BudgetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $month = (new Carbon($request->get('basedate')))->startOfMonth();

        $budgets = Budget::where('month', $month->toDateTimeString())
            ->orderBy('variable')
            ->orderBy('category')
            ->get();
        
        return view('budgets.index', [
            'budgets' => $budgets,
            'basedate' => $month,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $month = (new Carbon($request->get('basedate')))->startOfMonth();
        return view('budgets.create', [
            'basedate' => $month,
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
        $month = (new Carbon($request->get('basedate')))->startOfMonth();
        $post['month'] = $month->toDateTimeString();

        $fields = ['amount', 'category', 'month', 'variable'];
        $b = Budget::create(array_only($post, $fields));
        $b->save();

        $request->session()->flash('alert-success', "New budget saved for $b->category in ".$month->format('F Y'));

        return $this->index($request);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            return $this->handleError($e);
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
            return $this->handleError($e);
        }
    }


    /**
     * Creates a JSON response for when exceptions happen
     * @param  \Exception $e [description]
     * @return [type]        [description]
     */
    public function handleError(\Exception $e) {
        // TODO: Make this into a provider
        return response()->json([
                'status'=>'error', 
                'message'=>$e->getMessage()
            ]);
    }
}
