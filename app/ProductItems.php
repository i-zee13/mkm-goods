<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductItems extends Model
{
    protected $table = "product_related_items";

    public function product(){
        return $this->belongsTo('App\BrandProducts','product_id');
    }
    public function packingVariant(){
        return $this->hasOne('App\ItemUnits','id','variant_id');
    }
    public function packingVariant2(){
        return $this->hasOne('App\ItemUnits','id','variant_id_2');
    }
    public function packingVariant3(){
        return $this->hasOne('App\ItemUnits','id','variant_id_3');
    }
    public function unit_name(){
        return $this->belongsTo('App\ItemUnits','id','unit_id');
    }
}
