<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use DB;
use Auth;

class PaymentController extends AccessRightsAuth
{
    public function accounts(){
        return view('payment.accounts');
    }

    public function save_account(Request $request){
        if($request->operation == 'add'){
            $check = DB::table('accounts')->whereRaw('bank_name = "'.$request->bank_name.'" AND account_name = "'.$request->account_name.'" AND account_num = "'.$request->account_num.'"')->first();
            if($check){
                echo json_encode('alreadt_exist');
            }else{
                $insert = DB::table('accounts')->insert([
                    'bank_name' => $request->bank_name,
                    'account_name' => $request->account_name,
                    'account_num' => $request->account_num,
                    'opening_bal' => $request->opening_bal,
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
                if(DB::table('accounts')->whereRaw('bank_name = "'.$request->bank_name.'" AND account_num = "'.$request->account_num.'" AND id Not IN ('.$request->hidden_account_id.')')->first()){
                    echo json_encode('already_exist');
                }else{
                    $update = DB::table('accounts')->where('id', $request->hidden_account_id)->update([
                        'bank_name' => $request->bank_name,
                        'account_name' => $request->account_name,
                        'account_num' => $request->account_num,
                        'opening_bal' => $request->opening_bal,
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

    public function GetBankAccounts(){
        echo json_encode(DB::table('accounts')->get());
    }

    public function GetSelectedAccount($id){
        echo json_encode(DB::table('accounts')->where('id', $id)->first());
    }

    public function delete_account($id){
        $delete = DB::table('accounts')->where('id', $id)->delete();
        if($delete){
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }
    }
}
