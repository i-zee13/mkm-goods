<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = "orders";
    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id','id');
    }
}
