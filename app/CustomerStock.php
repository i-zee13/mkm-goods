<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerStock extends Model
{
    protected $guarded = [];
    protected $table = 'customer_stock';

    public function item(){
        return $this->belongsTo('App\ProductItems','item_id','id');
    }
    public function batch(){
        return $this->belongsTo('App\Batch','batch_id','id');
    }
}
