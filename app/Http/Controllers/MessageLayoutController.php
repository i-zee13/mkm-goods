<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageLayoutController extends Controller
{
    public function message(){
        return view('organization.message'); 
    }
}
