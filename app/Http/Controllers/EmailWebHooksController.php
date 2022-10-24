<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailWebHooksController extends Controller
{
    //
    public function sendinblue(Request $request){
        $json = file_get_contents('php://input');
        $action = json_decode($json, true);
        Log::info("WebHook:".$json);
    }
}
