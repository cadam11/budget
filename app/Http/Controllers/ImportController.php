<?php

namespace Budget\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use Budget\Http\Requests;
use Budget\Http\Controllers\Controller;

class ImportController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('import');
    }

	/**
     * Store an uploaded csv file in the Session as an Excel object
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$file = $request->file('file');

    	if ($file->getMimeType() != "text/plain")
    		return response()->json('error: '.$file->getMimeType(), 400);

    	$csv = Excel::load($file->getRealPath(), function($reader) {})->get();
    	$request->session()->put('file', $csv);

        return response()->json('success', 200);
    }


    /**
     * Parses the file stored in Session and displays results
     * 
     * @return \Illuminate\Http\Response
     */
    public function parse(Request $request){

    	$csv = $request->session()->pull('file');
    	if (!$csv) return $this->index();

    	$grouped = $csv->groupBy('account_type');
    	dd($grouped);


    }
}
