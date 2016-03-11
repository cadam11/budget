<?php

namespace Budget\Services;

use DB;
use Budget\Transaction;
use Budget\Budget;
use Carbon\Carbon;

class OverviewService {

	/**
	 * Gets a list of the overview budget lines for a given month
	 * @param  Carbon|null $basedate [description]
	 * @return [type]           [description]
	 */
	public function get(Carbon $basedate = null) {
		if ($basedate == null) $basedate = Carbon::now();

		$actuals = Transaction::month($basedate)
					->selectRaw('coalesce(category,'.rand().') as category, sum(amount) as actual')
					->groupBy('category')
					->get()
					->keyBy('category');
		

		$budgets = Budget::month($basedate)
			->orderBy('variable', 'desc')
			->orderBy('category', 'asc')			
			->get();


		$budgets->transform(function($budget, $key) use ($actuals) {
			$row = $actuals->pull($budget->category);
			$budget->actual = $row == null ? 0 : $row->actual;

			if ($budget->type == 'Income') $budget->actual *= -1;

			if ($budget->amount == 0) 
				$budget->used = 100;
			else
				$budget->used = (int)($budget->actual / $budget->amount * 100);

			$budget->left = $budget->amount - $budget->actual;

			if ($budget->type == 'Income') {
				if ($budget->used < 80) $budget->status = 'danger';
				else if ($budget->used < 97) $budget->status = 'warning';
				else $budget->status = 'success';
			}
			else {
				if ($budget->used < 90) $budget->status = 'success';
				else if ($budget->used > 103) $budget->status = 'danger';
				else $budget->status = 'warning';
			}

			return $budget;

		});

		
		$ignored = Budget::ignored($basedate)->get()->pluck('category')->all();
		foreach ($ignored as $category)
			$actuals->pull($category);


		$unbudgeted = new Budget([
				'category' => 'Unbudgeted',
				'amount' => 0.0,	// TODO: could be based on what's left of income
				'variable' => 1,
				'type' => 'Expense',
			]);

		$unbudgeted->actual = $actuals->sum('actual');


        $budgetedIncome = $budgets
        	->filter(function($b) { return $b->type == 'Income'; })
        	->sum('amount');

        $fixedBudgetedExpenses = $budgets
        	->filter(function($b) { return $b->type == 'Expense' && !$b->variable; })
        	->sum('amount');

        $variableActualExpenses = $budgets
        	->filter(function($b) { return $b->type == 'Expense' && $b->variable; })
        	->sum('actual');


		$unbudgeted->left = $budgetedIncome
			- $fixedBudgetedExpenses
			- $variableActualExpenses
			- $unbudgeted->actual;
        
		if ($unbudgeted->actual + $unbudgeted->left != 0)
			$unbudgeted->used = (int)($unbudgeted->actual / ($unbudgeted->actual + $unbudgeted->left) * 100);

		$unbudgeted->status = ($unbudgeted->used < 90 ? 'success' : ($unbudgeted->used > 103 ? 'danger' : 'warning'));



		$budgets->prepend($unbudgeted);


		return $budgets;
	}

}