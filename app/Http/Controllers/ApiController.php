<?php

namespace Budget\Http\Controllers;

use Illuminate\Http\Request;

use Budget\Http\Requests;
use Budget\Http\Controllers\Controller;
use Budget\Http\Controllers\ImportController;

class ApiController extends Controller
{

    /**
     * A streamlined file input specifically for receiving import files by api
     * 
     * @param  Request $request The http request (DI)
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request, ImportController $import) {

        $csv = $import->readFile($request->file('file'));
        $importCount = $import->importRows($csv);

        return response()->json(['success', "$importCount rows imported"], 200);
    }


}
