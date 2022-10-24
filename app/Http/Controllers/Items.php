<?php

namespace App\Http\Controllers;

use App\ItemRecipe;
use App\ItemRecipeIngredient;
use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use DB;

class Items extends AccessRightsAuth
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('items.list');
    }

    public function GetItems()
    {

        echo json_encode(DB::table('item_recipe')->get());
    }
    public function fetchItemsIng($id)
    {
        $recipeData = DB::select("SELECT
                        item_ingredients.id AS ing_id,
                        item_ingredients.ingredients_name,
                        item_recipe_ingredients.ingredients_value
                        FROM
                        item_ingredients
                        INNER JOIN
                        item_recipe_ingredients
                        ON
                            item_ingredients.id = item_recipe_ingredients.ingredients_id
                        INNER JOIN
                        item_recipe
                        ON
                            item_recipe.id = item_recipe_ingredients.item_recipe_id
                        WHERE
                        item_recipe.id =".$id);
        echo json_encode($recipeData);

    }
    public function AddItems()
    {

        $recipes = DB::table('item_ingredients')->where('id','>', '0')->get();
        return view('items.form', compact('recipes'));
    }
    public function saveItemsData(Request $request)
    {
        $request->data;
        $request->recipeName;

        $recipe = new ItemRecipe();
        $recipe->item_recipe_name = $request->recipeName;
        $recipe->save();
        $insertedId = $recipe->id;

        foreach($request->data as $key) {

            $data = array('item_recipe_id' => $insertedId, 'ingredients_id' => $key['ingId'], 'ingredients_value' => $key['value']);
            ItemRecipeIngredient::insert($data);
        }
        return 1;


    }

    public function editItemsData(Request $request)
    {
        $request->data;
        $request->recipeName;
        $request->r_id;
        if($request->r_id){
            DB::table('item_recipe_ingredients')->where('item_recipe_id', '=', $request->r_id)->delete();

        }

        DB::table('item_recipe')->where('id', $request->r_id)->update(['item_recipe_name' => $request->recipeName]);

        foreach($request->data as $key) {

            $data = array('item_recipe_id' => $request->r_id, 'ingredients_id' => $key['ingId'], 'ingredients_value' => $key['value']);
            ItemRecipeIngredient::insert($data);
        }
        return 1;


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
        $recipeData = DB::select("SELECT
                        item_ingredients.id AS ing_id,
                        item_ingredients.ingredients_name,
                        item_recipe_ingredients.ingredients_value
                        FROM
                        item_ingredients
                        INNER JOIN
                        item_recipe_ingredients
                        ON
                            item_ingredients.id = item_recipe_ingredients.ingredients_id
                        INNER JOIN
                        item_recipe
                        ON
                            item_recipe.id = item_recipe_ingredients.item_recipe_id
                        WHERE
                        item_recipe.id =".$id);
        $r_name = ItemRecipe::where('id',$id)->pluck('item_recipe_name')->first();
        $recipes = DB::table('item_ingredients')->where('id','>', '0')->get();
            return view('items.edit', compact('recipes','recipeData','r_name'));
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
        if(DB::table('item_recipe')->where('id', $id)->delete()){
            DB::table('item_recipe_ingredients')->where('item_recipe_id', '=', $id)->delete();
            echo json_encode("success");die;
        }
        echo json_encode("failed");
    }
}
