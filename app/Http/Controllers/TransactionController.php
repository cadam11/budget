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
        return view('transactions', ['transactions'=>Transaction::all()]);
    }

    /**
     * Add a new transaction form
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('transactions-new');
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

    	$request->session()->flash('status', 'Task was successful!');

    	return $this->index();
    }


}
