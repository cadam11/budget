<?php

namespace Budget\Services;

use Excel;
use Carbon\Carbon;
use Budget\Transaction;
use Budget\Services\CategoryService;


class ImportService {

    /**
     * The CategoryService instance
     * @var Budget\Services\CategoryService
     */
    protected $categories;

	/**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(CategoryService $categories)
    {
        $this->categories = $categories;
    }


    /**
     * Read raw csv and create a usable collection of rows
     * 
     * @param  Symfony\Component\HttpFoundation\File\UploadedFile $file The uploaded file containing raw csv
     * @return Maatwebsite\Excel\Collections\RowCollection       A collection of rows
     */
    public function readFile($file) {
        $csv = Excel::load($file->getRealPath(), function($reader) {})->get();
        return $csv;
    }

    /**
     * Parses the csv object into transctions
     * 
     * @param  Maatwebsite\Excel\Collections\RowCollection $csv The raw csv parsed into a collection of rows
     * @return int      A count of the number of transactions actually imported
     */
    public function importRows($csv) {

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