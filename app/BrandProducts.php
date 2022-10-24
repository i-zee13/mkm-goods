<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\ProductItems;
class BrandProducts extends Model
{
    protected $table = "brand_related_products";

    public function items(){
        return $this->hasMany('App\ProductItems', 'product_id');
    }
}
