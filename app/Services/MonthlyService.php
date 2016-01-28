<?php

namespace Budget\Services;

use DB;
use Budget\Transaction;
use Budget\Budget;
use Carbon\Carbon;

class MonthlyService {

	/**
	 * Gets a list of the overview budget lines for a given month
	 * @param  Carbon|null $basedate [description]
	 * @return [type]           [description]
	 */
	public function getOverview(Carbon $basedate = null) {
		if ($basedate == null) $basedate = Carbon::now();

		$actuals = Transaction::for($basedate)
					->selectRaw('category, sum(amount) as actual')
					->groupBy('category')
					->get();
		

		$budgets = Budget::where('month', $basedate->startOfMonth()->toDateTimeString())
			->orderBy('variable')
			->orderBy('category')
			->get();



		$budgets->transform(function($budget, $key) use ($actuals) {
			$row = $actuals->where('category', $budget->category)->first();
			$budget->actual = $row == null ? 0 : $row->actual;

			if ($budget->amount == 0) 
				$budget->used = 100;
			else
				$budget->used = (int)($budget->actual / $budget->amount * 100);

			$budget->left = $budget->amount - $budget->actual;

			if ($budget->used < 90) $budget->status = 'success';
			else if ($budget->used > 103) $budget->status = 'danger';
			else $budget->status = 'warning';

			return $budget;

		});

		

		$unbudgeted = new Budget([
				'category' => 'Unbudgeted',
				'amount' => 0.0,	// TODO: could be based on what's left of income
				'variable' => 1,

			]);

		$unbudgeted->actual = 0.0;
		$unbudgeted->used = 100;
		$unbudgeted->status = 'info';

		
		foreach ($actuals as $row) {
			if (!$budgets->contains('category', $row->category)) {
				$unbudgeted->actual += $row->actual;
			}
		}
		$unbudgeted->left = 0 - $unbudgeted->actual;

		$budgets->push($unbudgeted);

		return $budgets;		
	}

}