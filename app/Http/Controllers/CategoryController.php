<?php

namespace Budget\Http\Controllers;

use Illuminate\Http\Request;
use Budget\Http\Requests;
use Budget\Http\Controllers\Controller;
use Budget\Services\CategoryService;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryService $categories)
    {
        
        return response()->json($categories->getAll()->keys());
    }


}
