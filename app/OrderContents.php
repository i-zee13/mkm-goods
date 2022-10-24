<?php

namespace App;

use App\Http\Controllers\Items;
use Illuminate\Database\Eloquent\Model;

class OrderContents extends Model
{
    protected $table = "order_contents";
    public function item(){
        return $this->belongsTo('App\ProductItems','item_id','id');
    }
}
