<?php 

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Paste;

class PasteController extends BaseController 
{
    /**
     * Send back all comments as JSON
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(Paste::get());
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        return response()->json(Paste::create($request->all()));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return response()->json(Paste::destroy($id));
    }   
}