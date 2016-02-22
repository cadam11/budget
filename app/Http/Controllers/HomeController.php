<?php

namespace Budget\Http\Controllers;

use Carbon\Carbon;
use Budget\Services\OverviewService;
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
    public function index(OverviewService $overview, Request $request)
    {
        $month = (new Carbon($request->get('basedate')))->startOfMonth();

        return view('home', [
            'budgets' => $overview->get($month)->groupBy('type'),
            'basedate' => $month,
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



    /**
     * A view on current system info/status
     * 
     * @return \Illuminate\Http\Response
     */
    public function info()
    {
        return view('info',[
                'git' => shell_exec("git log -1 --pretty=format:'%h - %s (%ci)' --abbrev-commit"),
            ]);
    }




    
}
