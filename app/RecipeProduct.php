<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeProduct extends Model
{
    protected $table = "recipe_products";
    public $timestamps = false;
    protected $guarded = [];

}
