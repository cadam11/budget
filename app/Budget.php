<?php

namespace Budget;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
	protected $dates = ['month'];
    protected $fillable = ['category','amount', 'month', 'variable'];


     /**
     * Scope a query to only include transactions from a given month
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMonth($query, $month)
    {
        return $query->where('month', $month->startOfMonth()->toDateTimeString());
    }    
}
