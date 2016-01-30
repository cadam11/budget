<?php

namespace Budget\Http\Controllers;

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
        if (!$request->session()->has('file')) return $this->index();

    	$csv = $request->session()->pull('file');

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

        
        $import = Transaction::orderby('created_at', 'desc')->limit($importCount)->get();

        return view('transactions.index', [
                'transactions'  => $import,
                'title'         => 'Imported Transactions',
            ]);
    }
}
