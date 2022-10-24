<?php

namespace App\Http\Controllers;


use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use Auth;

class DashboardController extends AccessRightsAuth
{
    
    public function dashboard(){ 
        return view('dashboard.dashboard');
    }

    function unique_multidim_array($array, $key) { 
        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
        
        foreach($array as $val) { 
            if (!in_array($val[$key], $key_array)) { 
                $key_array[$i] = $val[$key]; 
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
        return $temp_array; 
    }
}