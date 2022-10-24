<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DispatchOrderDocs extends Model
{
    protected $table = "dispatched_orders_temp_documents";
    public $timestamps = false;
}
