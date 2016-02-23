<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Budget\Transaction;

/**
 * Tests login functions
 */
class TransactionTest extends TestCase
{

    public function test_it_navigates()
    {
        $lastMonth = $month = Carbon\Carbon::now()->subMonth()->format('F Y');
        $nextMonth = $month = Carbon\Carbon::now()->addMonth()->format('F Y');
        $thisMonth = Carbon\Carbon::now()->format('F Y');

        $this
            ->actingAs($this->validUser)
            ->visit('/transactions')
            ->click('Next Month')
            ->see($nextMonth)
            ->click('Previous Month')
            ->see($thisMonth)
            ->click('Previous Month')
            ->see($lastMonth)
            ;


    }

    public function test_it_creates_new_transcations()
    {     
        $transaction = factory(Transaction::class)->make();

        $this
            ->actingAs($this->validUser)
            ->visit('/transactions/create')
            ->type($transaction->account, "account")
            ->type($transaction->date, "date")
            ->type($transaction->description, "description")
            ->type($transaction->category, "category")
        	->type($transaction->amount, "amount")
        	->press('Save');

        $this
            ->see('transaction saved')
            ->seeInDatabase('transactions',[
                    'account' => $transaction->account,
                    'date' => $transaction->date,
                    'description' => $transaction->description,
                    'category' => $transaction->category,
                    'amount' => $transaction->amount,
                ]);
    }

    public function test_it_deletes_transactions()
    {
        $transaction = factory(Transaction::class)->create();

        $this
            ->actingAs($this->validUser)
            ->visit('/transactions/'.$transaction->id.'/delete');

        $this
            ->notSeeInDatabase('transactions',['id' => $transaction->id])
            ->assertResponseOk();
    }

}
