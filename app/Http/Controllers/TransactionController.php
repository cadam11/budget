<?php

namespace Budget\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Budget\Transaction;
use Budget\Http\Requests;
use Budget\Http\Controllers\Controller;
use Budget\Exceptions\JsonException;

class TransactionController extends Controller
{

    protected $month;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');

        $this->month = (new Carbon($request->get('basedate')))->startOfMonth();
    }

    /**
     * A view to list all tranasactions
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transactions.index', [
                'transactions'=>Transaction::month($this->month)->get(),
                'basedate' => $this->month,
            ]);
    }

    /**
     * Add a new transaction form
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('transactions.create');
    }

    /**
     * Create a new transcation record
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$fields = ['account', 'date', 'amount', 'description', 'category'];
    	$t = Transaction::create(array_only($request->all(), $fields));
    	$t->save();

    	$request->session()->flash('alert-success', 'New transaction saved.');

    	return $this->index();
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
            $t = Transaction::findOrFail($id);
            $t->delete();
            return response()->json(['status'=>'success'], 200);
        } catch (\Exception $e) {
            throw new JsonException($e);
        }
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
            $t = Transaction::findOrFail($id);
            if (!$t->isFillable($request->input('name')))
                throw new \Exception('Invalid field name');
            $value = $request->input('value');
            if ($request->input('name') == 'category' && $value == '')
                $value = null;
            $t->setAttribute($request->input('name'), $value);
            $t->save();
        } catch (\Exception $e) {
            throw new JsonException($e);
        }
        
    }

}
