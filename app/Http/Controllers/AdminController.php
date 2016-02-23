<?php

namespace Budget\Http\Controllers;

use Illuminate\Http\Request;

use Budget\Http\Requests;
use Budget\Http\Controllers\Controller;

class AdminController extends Controller
{
    

    /**
     * A view to keep track of work to be done
     * 
     * @return \Illuminate\Http\Response
     */
    public function todo()
    {
        return view('admin.todo');
    }



    /**
     * A view on current system info/status
     * 
     * @return \Illuminate\Http\Response
     */
    public function info()
    {
    	$c = collect();
    	foreach (explode("\n", shell_exec("git status --porcelain")) as $line) {
    		$parts = explode(" ", trim($line), 2);
    		if (count($parts)==2){
    			$l = new \stdClass();
    			$l->change = $parts[0];
    			$l->item =$parts[1];
    			$c->push($l);
    		}
    	}

        return view('admin.info',[
                'git' => shell_exec("git log -1 --pretty=format:'%h - %s (%ci)' --abbrev-commit --no-merges"),
                'changes' => $c,
            ]);
    }

    /**
     * An editable view of system settings
     * 
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
    	// TODO: load settings

    	return view('admin.settings');
    }

    /**
     * Stores the edited settings
     * 
     * @return \Illuminate\Http\Response
     */
    public function storeSettings()
    {
    	// TODO: store settings

    	return $this->settings();
    }

}
