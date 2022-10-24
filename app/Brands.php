<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $fillable = ['brand_name','description','thumbnail','brand_custom_id'];
    protected $table = "product_brands";
}
