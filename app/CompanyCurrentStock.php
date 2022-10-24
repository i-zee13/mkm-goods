<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyCurrentStock extends Model
{
    protected $guarded = [];
    protected $table = 'company_current_stock';
    public function item(){
        return $this->belongsTo('App\ProductItems','item_id','id');
    }
    public function batch(){
        return $this->belongsTo('App\Batch','batch_id','id');
    }
}
