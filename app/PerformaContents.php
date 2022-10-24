<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerformaContents extends Model
{
    protected $table = "performa_contents";
    public function product(){
        return $this->belongsTo('App\BrandProducts','product_id','id');
    }
    public function item(){
        return $this->belongsTo('App\ProductItems','item_id','id');
    }
}
