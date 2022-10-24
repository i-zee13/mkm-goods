<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderSheetContent extends Model
{
    
    public function supplier(){
        return $this->belongsTo('App\Supplier','supplier_id','id');
    }
    public function item(){
        return $this->belongsTo('App\ProductItems','item_id','id');
    }
    public function batch(){
        return $this->belongsTo('App\Batch','batch_id','id');
    }

}
