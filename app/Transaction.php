<?php

namespace Budget;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $dates = ['date'];
    protected $guarded = ['id'];
}
