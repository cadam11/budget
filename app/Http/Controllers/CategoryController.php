<?php

namespace Budget\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Budget\Http\Requests;
use Budget\Http\Controllers\Controller;

class CategoryController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $budgetCategories = DB::table('budgets')->select('category')->distinct();
        $categories = collect(DB::table("transactions")
            ->select('category')
            ->distinct()
            ->union($budgetCategories)
            ->get())->keyBy('category');

        
        return response()->json(array_keys($categories->all()));
    }


}
