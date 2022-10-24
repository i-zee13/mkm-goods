<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemRecipeIngredient extends Model
{
    protected $table = "item_recipe_ingredients";
    public $timestamps = false;
    protected $guarded = [];
}
