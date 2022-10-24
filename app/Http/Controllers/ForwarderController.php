<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use DB;
use File;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class ForwarderController extends AccessRightsAuth
{

    public function forwarder(){
        return view('forwarder.forwarder_list');
    }

    public function GetForwarderList(){
        echo json_encode(DB::table('forwarder')->get());
    }

    public function GetForwarder($id){
        echo json_encode(DB::table('forwarder')->where('id', $id)->first());
    }

    public function save_forwarder(Request $request){
        if($request->operation == 'add'){
            $insert = DB::table('forwarder')->insert([
                'company_name' => $request->company_name,
                'poc' => $request->poc,
                'address' => $request->address,
                'city' => $request->city,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'email' => $request->email,
                'website' => $request->website,
                'country' => $request->country,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id
            ]);
            if($insert){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }else{
            $update = DB::table('forwarder')->where('id', $request->forwarder_id)->update([
                'company_name' => $request->company_name,
                'poc' => $request->poc,
                'address' => $request->address,
                'city' => $request->city,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'email' => $request->email,
                'website' => $request->website,
                'country' => $request->country,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id
            ]);
            if($update){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }
    }

    public function deleteForwarder(Request $request, $id){
        $delete = DB::table('forwarder')->where('id', $id)->delete();
        if($delete){
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }
    }

    public function download_sample_forwarder(){
        return redirect('/sample_forwarder.xlsx');
    }

    public function upload_excel_forwarder(Request $request){
        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
         
                $path = $request->file->getRealPath();
                $data = Excel::load($path, function($reader) {
                })->get();
                $data_uploaded = false;
                if(!empty($data) && $data->count()){
                    $counter = 0;
                    $not_upload_able = [];
                    foreach ($data as $key => $value) {
                            $insert = DB::table('forwarder')->insert([
                                'company_name' => $value->company_name,
                                'poc' => $value->poc,
                                'city' => $value->city,
                                'address' => $value->address,
                                'phone' => $value->phone,
                                'country' => $value->country,
                                'email' => $value->email,
                                'website' => $value->website,
                                'fax' => $value->fax,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => Auth::user()->id
                            ]);
                            $data_uploaded = true;
                        $counter ++;
                    }
                    if($data_uploaded){
                        echo json_encode(array('status' => 'success', 'not_upload_able' => $not_upload_able));
                        //return redirect('/products')->with('status', 'Products Added Successfully!');
                    }else{
                        echo json_encode(array('status' => 'failed', 'not_upload_able' => ''));
                        //return redirect('/products')->with('status', 'Failed to add products!');
                    }
                }
            }else {
                echo json_encode(array('status' => 'failed', 'not_upload_able' => ''));
                //return redirect('/products')->with('status', 'Failed to add products!');
            }
        }
    }
}
