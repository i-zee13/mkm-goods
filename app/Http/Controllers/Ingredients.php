<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use DB;

class Ingredients extends AccessRightsAuth
{
    private $controllerName = "Units";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('ingredients.list');
    }

    public function GetIngredients()
    {


        echo json_encode(DB::table('item_ingredients')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(DB::table('item_ingredients')->insert(['ingredients_name' => $request->ingredients_name])){
            echo json_encode("success");die;
        }
        echo json_encode("failed");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo json_encode(DB::table('item_ingredients')->where('id', $id)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try{
            DB::table('item_ingredients')->where('id', $id)->update(['ingredients_name' => $request->ingredients_name]);
            echo json_encode("success");
        }catch(\Illuminate\Database\QueryException $ex){
            echo json_encode('failed');
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
        if(DB::table('item_ingredients')->where('id', $id)->delete()){
            echo json_encode("success");die;
        }
        echo json_encode("failed");
    }
}
