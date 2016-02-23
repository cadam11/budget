<?php

namespace Budget\Services;

use DB;
use Budget\Rule;

class CategoryService {

	protected $rules;

	/**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->rules = Rule::all();
    }

    /**
     * Gets a list of all categories
     * 
     * @return Array
     */
    public function getAll(){

        return collect(DB::table("transactions")
            ->select('category')
            ->distinct()
            ->union(DB::table('budgets')->select('category')->distinct())
            ->get())->keyBy('category');

    }

	/**
	 * Gets the category based on the row supplied (and the rules)
	 * 
	 * @param  Array $row An array of values for a candiate Transcation
	 * @return String|null     The matched category, or null if no match
	 */
	public function getCategory($row) {
		$c = $this->matchesBoth($row);
		if (!$c) {
			$c = $this->matchesPatternOnly($row);
			if (!$c) {
				$c = $this->matchesAmountOnly($row);
			}
		}
		return $c;
	}

	/**
	 * Attempts to find a rule where the amount matches
	 * @param  Array $row An array of values for a candiate Transcation
	 * @return String|null     The matched category, or null if no match
	 */
	protected function matchesAmountOnly($row){ 
		$rule = $this->rules->first(function($key, $value) use ($row) {
			return ($value->pattern == null && $row['amount'] == $value->amount);
		});
		if ($rule) return $rule->category;
		else return null;
	}

	/**
	 * Attempts to find a rule where the pattern matches
	 * @param  Array $row An array of values for a candiate Transcation
	 * @return String|null     The matched category, or null if no match
	 */
	protected function matchesPatternOnly($row){ 
		$rule = $this->rules->first(function($key, $value) use ($row) {
			return ($value->amount == null && strpos($row['description'], ucwords(strtolower($value->pattern))) !== false);
		});
		if ($rule) return $rule->category;
		else return null;
	}


	/**
	 * Attempts to find a rule where both the amount and pattern match
	 * @param  Array $row An array of values for a candiate Transcation
	 * @return String|null     The matched category, or null if no match
	 */
	protected function matchesBoth($row){ 
		$rule = $this->rules->first(function($key, $value) use ($row) {
			return (strpos($row['description'], ucwords(strtolower($value->pattern))) !== false)
				&& ($row['amount'] == $value->amount);
		});
		if ($rule) return $rule->category;
		else return null;
	}

}