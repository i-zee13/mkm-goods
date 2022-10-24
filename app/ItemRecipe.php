<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemRecipe extends Model
{
    protected $table = "item_recipe";
    public $timestamps = false;
    protected $guarded = [];

}
