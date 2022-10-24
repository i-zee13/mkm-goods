<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = "recipe";
    public $timestamps = false;
    protected $guarded = [];

}
