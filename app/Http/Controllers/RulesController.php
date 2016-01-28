<?php

namespace Budget\Http\Controllers;

use Illuminate\Http\Request;
use Budget\Rule;
use Budget\Http\Requests;
use Budget\Http\Controllers\Controller;

class RulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rules.index',[
                'rules'     => Rule::all(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $fields = ['amount', 'category', 'pattern'];
        foreach ($fields as $field){
            if (isset($post[$field]) && $post[$field] == '')
                $post[$field] = null;
        }

        try {
            $r = Rule::create(array_only($post, $fields));
            $r->save();

            $request->session()->flash('alert-success', "New rule saved for $r->category.");
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', "Error: $e->getMessage()");
        }

        return $this->index($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $r = Rule::findOrFail($id);
            if (!$r->isFillable($request->input('name')))
                throw new \Exception('Invalid field name');
            $value = $request->input('value');
            if ($value == '') $value = null;
            $r->setAttribute($request->input('name'), $value);
            $r->save();
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $r = Rule::findOrFail($id);
            $r->delete();
            return response()->json(['status'=>'success'], 200);
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Creates a JSON response for when exceptions happen
     * @param  \Exception $e [description]
     * @return [type]        [description]
     */
    public function handleError(\Exception $e) {
        // TODO: Make this into a provider
        return response()->json([
                'status'=>'error', 
                'message'=>$e->getMessage()
            ], 400);
    }    
}
