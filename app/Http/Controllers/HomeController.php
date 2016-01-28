<?php

namespace Budget\Http\Controllers;

use Budget\Services\MonthlyService;
use Budget\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MonthlyService $monthly)
    {
        return view('home', [
            'budgets' => $monthly->getOverview()
            ]);
    }


    /**
     * A view to keep track of work to be done
     * 
     * @return \Illuminate\Http\Response
     */
    public function todo()
    {
        return view('todo');
    }


    
}
