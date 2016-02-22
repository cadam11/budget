<?php

namespace Budget\Http\Controllers;

use Carbon\Carbon;
use Budget\Services\OverviewService;
use Budget\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OverviewService $overview, Request $request)
    {
        $month = (new Carbon($request->get('basedate')))->startOfMonth();

        return view('home', [
            'budgets' => $overview->get($month)->groupBy('type'),
            'basedate' => $month,
            ]);
    }





    
}
