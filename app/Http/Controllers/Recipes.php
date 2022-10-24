<?php

namespace App\Http\Controllers;

use App\ItemRecipe;
use App\ItemRecipeIngredient;
use App\Recipe;
use App\RecipeItem;
use App\RecipeProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use DB;

class Recipes extends AccessRightsAuth
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('recipes.list');
    }

    public function GetRecipes()
    {

        echo json_encode(DB::table('recipe')->get());
    }
    public function fetchRecipesItems($id)
    {
        $recipeData = DB::select("SELECT
            recipe.id,
            recipe_item.item_id,
            item_recipe.item_recipe_name
            FROM
            recipe
            INNER JOIN
            recipe_item
            ON
                recipe.id = recipe_item.recipe_id
            INNER JOIN
            item_recipe
            ON
                recipe_item.item_id = item_recipe.id
            WHERE
            recipe.id =".$id);
        echo json_encode($recipeData);

    }
    public function AddRecipes()
    {

        $recipes = DB::table('item_recipe')->where('id','>', '0')->get();
        return view('recipes.form', compact('recipes'));
    }
    public function saveRecipesData(Request $request)
    {
        $request->data;
        $request->recipeName;

        $recipe = new Recipe();
        $recipe->recipe_name = $request->recipeName;
        $recipe->save();
        $insertedId = $recipe->id;

        foreach($request->data as $key) {

            $data = array('recipe_id' => $insertedId, 'item_id' => $key['ingId']);
            RecipeItem::insert($data);
        }
        return 1;


    }

    public function editRecipesData(Request $request)
    {
        $request->data;
        $request->recipeName;
        $request->r_id;
        if($request->r_id){
            DB::table('recipe_item')->where('recipe_id', '=', $request->r_id)->delete();
        }

        DB::table('recipe')->where('id', $request->r_id)->update(['recipe_name' => $request->recipeName]);

        foreach($request->data as $key) {

            $data = array('recipe_id' => $request->r_id, 'item_id' => $key['ingId']);
            RecipeItem::insert($data);
        }
        return 1;


    }

    public function assignToRecipe(Request $request)
    {

            $data = array('recipe_id' => $request->recipe_id, 'product_id' => $request->product_id,'item_id' => $request->item_id);
            RecipeProduct::insert($data);
        return 1;


    }

    public function RemoveAssignToRecipe(Request $request)
    {


        DB::table('recipe_products')->where('recipe_id', '=', $request->recipe_id)
            ->where('item_id', '=', $request->item_id)
            ->where('product_id', '=', $request->product_id)
            ->delete();

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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
            recipe.id,
            recipe_item.item_id,
            item_recipe.item_recipe_name
            FROM
            recipe
            INNER JOIN
            recipe_item
            ON
                recipe.id = recipe_item.recipe_id
            INNER JOIN
            item_recipe
            ON
                recipe_item.item_id = item_recipe.id
            WHERE
            recipe.id =".$id);
        $r_name = Recipe::where('id',$id)->pluck('recipe_name')->first();
        $recipes = DB::table('item_recipe')->where('id','>', '0')->get();
            return view('recipes.edit', compact('recipes','recipeData','r_name'));
    }

    public function assignProducts($id)
    {

        $proData = DB::select("SELECT
            brand_related_products.`name` AS product_name,
            product_related_items.`name`,
            product_related_items.description,
            brand_related_products.sku,
            brand_related_products.id AS pro_product_id,
            product_related_items.id AS item_item_id,
            recipe_products.*
            FROM
            brand_related_products
            INNER JOIN
            product_related_items
            ON
                brand_related_products.id = product_related_items.product_id
            LEFT JOIN
            recipe_products
            ON
                product_related_items.id = recipe_products.item_id");
        $assignPro = RecipeProduct::get();

        return view('recipes.assign_products', compact('proData','id','assignPro'));
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(DB::table('recipe')->where('id', $id)->delete()){
            DB::table('recipe_item')->where('recipe_id', '=', $id)->delete();
            echo json_encode("success");die;
        }
        echo json_encode("failed");
    }
}
