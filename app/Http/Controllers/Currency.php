<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use DB;
use Auth;
class Currency extends AccessRightsAuth
{
    public function currency(){
        return view('payment.currency');
    }

    public function save_currency(Request $request){
        if($request->operation == 'add'){
            $check = DB::table('currencies')->whereRaw('title = "'.$request->title.'" AND symbol = "'.$request->symbol.'"')->first();
            if($check){
                echo json_encode('already_exist');
            }else{
                $insert = DB::table('currencies')->insert([
                    'title' => $request->title,
                    'symbol' => $request->symbol,
                    'details' => $request->details,
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                if($insert){
                    echo json_encode('success');
                }else{
                    echo json_encode('failed');
                }
            }
        }else{
            try{
                if(DB::table('currencies')->whereRaw('title = "'.$request->title.'" AND symbol = "'.$request->symbol.'" AND id Not IN ('.$request->hidden_currency_id.')')->first()){
                    echo json_encode('already_exist');
                }else{
                    $update = DB::table('currencies')->where('id', $request->hidden_currency_id)->update([
                        'title' => $request->title,
                        'symbol' => $request->symbol,
                        'details' => $request->details,
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    echo json_encode('success');
                }
            }catch(\Illuminate\Database\QueryException $ex){ 
                echo json_encode('failed'); 
            }
        }
    }

    public function GetCurrency(){
        echo json_encode(DB::table('currencies')->get());
    }

    public function GetSelectedCurrency($id){
        echo json_encode(DB::table('currencies')->where('id', $id)->first());
    }

    public function delete_currency($id){
        $delete = DB::table('currencies')->where('id', $id)->delete();
        if($delete){
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }
    }
}
