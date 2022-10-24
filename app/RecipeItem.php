<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeItem extends Model
{
    protected $table = "recipe_item";
    public $timestamps = false;
    protected $guarded = [];
}
