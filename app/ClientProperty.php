<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientProperty extends Model
{
    protected $gaurded = [];

    protected $table = 'client_property_info';
}
