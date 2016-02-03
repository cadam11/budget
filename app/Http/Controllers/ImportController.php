<?php

namespace Budget\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use Excel;
use Carbon\Carbon;
use Budget\Transaction;
use Budget\Services\CategoryService;
use Budget\Http\Requests;
use Budget\Http\Controllers\Controller;

class ImportController extends Controller
{

    /**
     * The CategoryService instance
     * @var Budget\Services\CategoryService
     */
    protected $categories;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CategoryService $categories)
    {
        $this->middleware('auth');
        $this->categories = $categories;
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

    	if ($file == null || $file->getMimeType() != "text/plain")
    		return response()->json('error: '.$file->getMimeType(), 400);

        $csv = $this->readFile($file);
        $request->session()->put('file', $csv);

        return response()->json('success', 200);
    }


    /**
     * Parses the file stored in Session and displays results
     * 
     * @return \Illuminate\Http\Response
     */
    public function parse(Request $request){
        if (!$request->session()->has('file')) return $this->index();

    	$csv = $request->session()->pull('file');
        $importCount = $this->importRows($csv);
        
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
     * @return \Illuminate\Http\Response
     */
    public function apiImport(Request $request) {

        $csv = $this->readFile($request->file('file'));
        $importCount = $this->importRows($csv);

        return response()->json(['success', "$importCount rows imported"], 200);
    }

    /**
     * Read raw csv and create a usable collection of rows
     * 
     * @param  Symfony\Component\HttpFoundation\File\UploadedFile $file The uploaded file containing raw csv
     * @return Maatwebsite\Excel\Collections\RowCollection       A collection of rows
     */
    protected function readFile($file) {
        $csv = Excel::load($file->getRealPath(), function($reader) {})->get();
        return $csv;
    }

    /**
     * Parses the csv object into transctions
     * 
     * @param  Maatwebsite\Excel\Collections\RowCollection $csv The raw csv parsed into a collection of rows
     * @return int      A count of the number of transactions actually imported
     */
    protected function importRows($csv) {

        $accounts = ['MasterCard', 'Chequing'];
        $transactions = $csv->filter(function($item) use ($accounts) {
            return in_array($item->account_type, $accounts);
        });

        $importCount = 0;

        foreach($transactions as $item){
            $record = [
                'date'                  => new Carbon($item->transaction_date),
                'account'               => $item->account_type,
                'imported_description1' => $item->description_1,
                'imported_description2' => $item->description_2,
                'amount'                => $item->cad * -1,
            ];

            $t = Transaction::firstOrNew($record);
            if (!$t->exists) {
                $record['description'] = ucwords(strtolower($record['imported_description1']));
                $t->description = $record['description'];
                $t->category = $this->categories->getCategory($record);
                $t->save();
                $importCount++;
            }            
        }

        return $importCount;
    }
}
