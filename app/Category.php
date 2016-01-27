<?php

namespace Budget;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category','variable'];

    public function transactions() {
    	return $this->hasMany('Budget\Transaction', 'category', 'category');
    }
}
