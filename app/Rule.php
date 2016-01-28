<?php

namespace Budget;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = ['category','pattern','amount'];
}
