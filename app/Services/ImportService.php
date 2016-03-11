<?php

namespace Budget\Services;

use Excel;
use Searchy;
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
     * Deletes tentative transactions
     * 
     * @param  Maatwebsite\Excel\Collections\RowCollection $csv The raw csv parsed into a collection of rows
     * @return int      A count of the number of transactions actually imported
     */
    public function importRows($csv) {

        $accounts = ['MasterCard', 'Chequing'];
        $transactions = $csv->filter(function($item) use ($accounts) {
            return in_array($item->account_type, $accounts);
        });

        Transaction::tentative()->delete();
        $importCount = 0;

        foreach($transactions as $item){
            $record = [
                'date'                  => new Carbon($item->transaction_date),
                'account'               => $item->account_type,
                'imported_description1' => $item->description_1,
                'imported_description2' => $item->description_2,
                'amount'                => $item->cad * -1,
                'description'           => ucwords(strtolower($item->description_1)),
            ];

            if (isset($item->tentative)) $record['tentative'] = $item->tentative;

            $matches = collect(Searchy::transactions('description')
                ->query($record['description'])
                ->getQuery()
                ->having('amount', '=', $record['amount'])
                ->having('date', '=', $record['date'])
                ->having('account', '=', $record['account'])
                ->get()
                );

            if ($matches->count() == 0){
                $t = new Transaction($record);
                $t->category = $this->categories->getCategory($record);
                $t->save();
                $importCount++;
            }

        }

        return $importCount;
    }
}
