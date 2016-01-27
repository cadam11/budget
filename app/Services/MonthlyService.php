<?php

namespace Budget\Services;

use DB;
use Carbon\Carbon;

class MonthlyService {

	/**
	 * Gets a list of the budget lines for a given month
	 * @param  Carbon $basedate [description]
	 * @return [type]           [description]
	 */
	public function getBudgets(Carbon $basedate = null) {
		if ($basedate == null) $basedate = Carbon::now();

		$actuals = DB::table('transactions')
					->selectRaw('category, sum(amount) as actual')
					->whereBetween('date', [
							$basedate->startOfMonth()->toDateTimeString(),
							$basedate->endOfMonth()->toDateTimeString(),
						])
					->groupBy('category')
					->get();
		
		// also need:
		//  	pct of budget
		//  	variance from budget: under (over)
		


		return $actuals;		
	}


}