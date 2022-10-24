<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // protected $fillable = [
    //     'acquisition_source',
    //     'referredby_client_id',
    //     'client_type',
    //     'life_cycle_stage',
    //     'first_name',
    //     'middle_name',
    //     'last_name',
    //     'gender_id',
    //     'dob',
    //     'email',
    //     'marital_status',
    //     'employment_status' ,   
    //     'client_address_id',
    //     'residence_status',
    //     'house_no',
    //     'primary_landline',
    //     'primary_cellphone',
    //     'primary_address',
    //     'country_id' ,   
    //     'state_id',
    //     'city_id',
    //     'postal_code_id',
    //     'created_by',
    // ];

    protected $table = 'students';
    protected $gaurded  =   [];

    public function addreses()
    {
        return $this->hasMany(ClientAddress::class);
    }

    public function intakeforms(){
        return $this->belongsToMany(IntakeForm::class)->withPivot('status','intake_form_type','unique_key');
    }
}
