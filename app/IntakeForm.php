<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntakeForm extends Model
{
    protected $guarded = [];
    public function clients(){
        return $this->belongsToMany(Client::class)->withPivot('status','intake_form_type','unique_key');
    }
}
