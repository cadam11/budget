<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Budget\Transaction;

/**
 * Tests login functions
 */
class TransactionTest extends TestCase
{
    protected $validUser;

    public function setUp()
    {
        parent::setUp();
        $this->validUser = factory(Budget\User::class)->create();
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



    public function tearDown()
    {
        $this->validUser->delete();
        parent::tearDown();
    }
}
