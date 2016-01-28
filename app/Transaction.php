<?php

namespace Budget;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $dates = ['date'];
    protected $guarded = ['id'];

     /**
     * Scope a query to only include transactions from a given month
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFor($query, $month)
    {
        return $query->whereBetween('date', [
	        	$month->startOfMonth()->toDateTimeString(),
	        	$month->endOfMonth()->toDateTimeString(),
        	])->orderBy('date', 'asc');
    }

}
