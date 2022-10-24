<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    protected $guarded = [];
    protected $table = 'client_address';

    public function client()
    {
        return $this->hasMany(Client::class);
    }
}
