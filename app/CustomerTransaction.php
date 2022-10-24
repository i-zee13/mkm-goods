<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerTransaction extends Model
{
    protected $table = "customer_transaction_history";
    public $timestamps = false;
}
