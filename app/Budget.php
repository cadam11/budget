<?php

namespace Budget;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
	protected $dates = ['month'];
    protected $fillable = ['category','amount', 'month', 'variable'];
}
