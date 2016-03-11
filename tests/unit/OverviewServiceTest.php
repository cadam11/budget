<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OverviewServiceTest extends TestCase
{

	protected $overview;


    public function setUp()
    {
        parent::setUp();
        $this->overview = $this->app->make('Budget\Services\OverviewService');
    }

	
	public function test_it_gets_budgets()
	{

		factory(Budget\Budget::class)->create();

		$budgets = $this->overview->get();

		$this->assertGreaterThan(0, $budgets->count());

	}


	public function test_it_adds_up_basic_unbudgeted()
	{
		$transactionCount = 4;
		$transactionTotal = 40;

		$budget = factory(Budget\Budget::class, 'Expense')->create();

		$transactions = factory(Budget\Transaction::class, $transactionCount)->make();
		$category = $transactions[0]->category;
		Budget\Budget::where('category', $category)->delete();

		foreach ($transactions as $t){
			$t->category = $category;
			$t->amount = $transactionTotal / $transactionCount;
			$t->save();	
		} 

		$budgets = $this->overview->get();
		$unbudgeted = $budgets[0];

		$this->assertEquals('Unbudgeted', $unbudgeted->category);
		$this->assertEquals($transactionTotal, $unbudgeted->actual);

	}

	public function test_it_calculates_unbudgeted_left()
	{
		$unbudgetedActualExpenses = 40;
		$variableActualExpenses = 80;
		$fixedBudgetedExpenses = 60;
		$budgetedIncome = 500;

		$expectedLeft = $budgetedIncome
			- $fixedBudgetedExpenses
			- $variableActualExpenses
			- $unbudgetedActualExpenses;

		// set up budgets
		
		Budget\Budget::truncate();
		$variableBudget = factory(Budget\Budget::class, 'Expense')->make();
		$variableBudget->variable = 1;
		$variableBudget->save();

		$fixedBudget = factory(Budget\Budget::class, 'Expense')->make();
		$fixedBudget->variable = 0;
		$fixedBudget->amount = $fixedBudgetedExpenses;
		$fixedBudget->save();

		$incomeBudget = factory(Budget\Budget::class, 'Income')->make();
		$incomeBudget->amount = $budgetedIncome;
		$incomeBudget->save();


		// set up transactions

		$transaction = factory(Budget\Transaction::class)->make();
		$transaction->category = '0123456789';
		$transaction->amount = $unbudgetedActualExpenses;
		$transaction->save();

		$transaction = factory(Budget\Transaction::class)->make();
		$transaction->category = $variableBudget->category;
		$transaction->amount = $variableActualExpenses;
		$transaction->save();
		
		$transaction = factory(Budget\Transaction::class)->make();
		$transaction->category = $fixedBudget->category;
		$transaction->amount = $fixedBudgetedExpenses / 10;	// arbitrary
		$transaction->save();
		
		$transaction = factory(Budget\Transaction::class)->make();
		$transaction->category = $incomeBudget->category;
		$transaction->amount = $budgetedIncome / 2;	// arbitrary
		$transaction->save();



		$budgets = $this->overview->get();
		$unbudgeted = $budgets[0];		


		$this->assertEquals('Unbudgeted', $unbudgeted->category);
		$this->assertEquals($unbudgetedActualExpenses, $unbudgeted->actual);
		$this->assertEquals($expectedLeft, $unbudgeted->left);

	}



}
