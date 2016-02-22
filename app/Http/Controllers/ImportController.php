<?php

namespace Budget\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use Excel;
use Carbon\Carbon;
use Budget\Transaction;
use Budget\Services\ImportService;
use Budget\Http\Requests;
use Budget\Http\Controllers\Controller;

class ImportController extends Controller
{


    
    /**
     * The ImportService instance
     * @var Budget\Services\ImportService
     */
    protected $import;


    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ImportService $import)
    {
        $this->import = $import;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transactions.import');
    }

	/**
     * Store an uploaded csv file in the Session as an Excel object
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$file = $request->file('file');

    	if ($file == null || $file->getMimeType() != "text/plain")
    		return response()->json('error: '.$file->getMimeType(), 400);

        $csv = $this->import->readFile($file);
        $request->session()->put('file', $csv);
        

        return response()->json(['status' => 'success'], 200);
    }


    /**
     * Parses the file stored in Session and displays results
     * 
     * @return \Illuminate\Http\Response
     */
    public function parse(Request $request){
        if (!$request->session()->has('file')) return $this->index();

    	$csv = $request->session()->pull('file');
        $importCount = $this->import->importRows($csv);
        
        $imported = Transaction::orderby('created_at', 'desc')->limit($importCount)->get();

        return view('transactions.index', [
                'transactions'  => $imported,
                'title'         => 'Imported Transactions',
            ]);
    }

    /**
     * A streamlined file input specifically for receiving import files by api
     * 
     * @param  Request $request The http request (DI)
     * @param  ImportService $import DI
     * @return \Illuminate\Http\Response
     */
    public function apiImport(Request $request) {

        $csv = $this->import->readFile($request->file('file'));
        $importCount = $this->import->importRows($csv);

        return response()->json(['success', "$importCount rows imported"], 200);
    }

}
