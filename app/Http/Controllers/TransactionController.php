<?php

namespace Budget\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Budget\Transaction;
use Budget\Http\Requests;
use Budget\Http\Controllers\Controller;

class TransactionController extends Controller
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
     * A view to list all tranasactions
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transactions.index', ['transactions'=>Transaction::all()]);
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
            if ($request->input('name') == 'category' && $request->input('value') == '')
                $request->input('value') = null;
            $t->setAttribute($request->input('name'), $request->input('value'));
            $t->save();
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
