<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BrandProducts as BP;


class Performa extends Model
{
    protected $table = "performa";

    public function customer(){
        return $this->belongsTo('App\Customer','customer_id','id');

    }
}
