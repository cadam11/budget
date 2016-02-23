<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BudgetTest extends TestCase
{

    public function test_it_navigates()
    {
    	$lastMonth = $month = Carbon\Carbon::now()->subMonth()->format('F Y');
    	$nextMonth = $month = Carbon\Carbon::now()->addMonth()->format('F Y');
    	$thisMonth = Carbon\Carbon::now()->format('F Y');

    	$this
            ->actingAs($this->validUser)
            ->visit('/budgets')
            ->click('Next Month')
            ->see($nextMonth)
            ->click('Previous Month')
            ->see($thisMonth)
            ->click('Previous Month')
            ->see($lastMonth)
            ;

    }


}
