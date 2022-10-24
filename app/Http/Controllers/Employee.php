<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use URL;
use Auth;
use DB;
use App\Http\Controllers\Core\AccessRightsAuth;

class Employee extends AccessRightsAuth
{
    public $controllerName = "Employee";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetEmployeeInfo($id)
    {
        
        echo json_encode(array('employee' => User::find($id), 'base_url' => URL::to('/').'/'));
    }

    public function UpdateEmployee(Request $request, $id)
    {
    
        
        $employee = User::find($id);
        
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->sin = $request->sin;
        $employee->city = $request->city;
        $employee->state = $request->state;
        $employee->country = $request->country;
        $employee->address = $request->address;
        $employee->username = $request->username;
        if($request->password){
            $password = bcrypt($request->password);
            $employee->password = $password;
        }
        $employee->hiring = $request->hiring;
        $employee->salary = $request->salary;
        $employee->designation = $request->designation;
        $employee->reporting_to = $request->reporting;
        $employee->department_id = $request->department;
        $employee->updated_by = Auth::user()->id;
        
        if($request->hasFile('employeePicture')){
            $completeFileName = $request->file('employeePicture')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('employeePicture')->getClientOriginalExtension();
            $empPicture = str_replace(' ', '_', $fileNameOnly).'_'.time().'.'.$extension;
            $path = $request->file('employeePicture')->storeAs('public/employees', $empPicture);
            if(Storage::exists('public/employees/'.str_replace('./storage/employees/', '', $employee->picture))){
                Storage::delete('public/employees/'.str_replace('./storage/employees/', '', $employee->picture));
            }
            $employee->picture = './storage/employees/'.$empPicture;
        }

        echo json_encode($employee->save());
    }


    public function update_user_password(Request $request){
        $employee = User::find($request->user_id);
        $hashedPassword = $employee->password;

        if($request->current_password){
            if (Hash::check($request->current_password, $hashedPassword)) {
                $employee->password = bcrypt($request->confirm_password);
                if($employee->save()){
                    echo json_encode("success");
                    die;
                }else{
                    echo json_encode("failed");
                    die;
                }
            }else{
                echo json_encode('not_match');
                die;
            }
        }
        else {
            echo json_encode("empty"); 
            die;
        }

        
    }


    public function update_user_profile_pic(Request $request){
        $employee = User::find($request->user_id);
        if($request->hasFile('employeePicture')){
            $completeFileName = $request->file('employeePicture')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('employeePicture')->getClientOriginalExtension();
            $empPicture = str_replace(' ', '_', $fileNameOnly).'_'.time().'.'.$extension;
            $path = $request->file('employeePicture')->storeAs('public/employees', $empPicture);
            if(Storage::exists('public/employees/'.str_replace('./storage/employees/', '', $employee->picture))){
                Storage::delete('public/employees/'.str_replace('./storage/employees/', '', $employee->picture));
            }
            $employee->picture = './storage/employees/'.$empPicture;
            if($employee->save()){
                echo json_encode("success");
            }else{
                echo json_encode("failed");
            }
        }else{
            echo json_encode('empty');
        }
    }

    public function device_logs(){
        return view('includes.device_logs', ['users' => DB::table('users')->selectRaw('id, name, email, country, city, phone, device_id, (Select count(*) from login_device_logs where user_id = users.id) as device_counts')->get()]);
    }

    public function GetDeviceLogs($id){
        echo json_encode(DB::table('login_device_logs')->where('user_id', $id)->get());
    }

    public function update_device_activation(Request $request){
        try{
            // if($request->current_status == 0){
            //     DB::table('login_device_logs')->where('user_id', $request->user)->update(['is_active' => 0]);
            // }
            $update = DB::table('login_device_logs')->whereRaw("device_id = '$request->device_id' AND user_id = $request->user")->update([
                'is_active' => ($request->current_status == 1 ? 0 : 1)
            ]);
            $deviceIdsFromUser = DB::table('users')->where('id', $request->user)->first();

            $saved_ids = null;
            if($deviceIdsFromUser->device_id){
                $explode = explode(',', $deviceIdsFromUser->device_id);
                if($request->current_status == 1){
                    $current_device = $request->device_id;
                    $saved_ids = array_filter($explode, function($x) use($current_device){
                        return $x != $current_device;
                    });
                }else{
                    $saved_ids = $deviceIdsFromUser->device_id ? $deviceIdsFromUser->device_id.','.$request->device_id : $request->device_id;
                }
            }

            if($request->current_status == 1){
                DB::table('users')->where('id', $request->user)->update([
                    'device_id' => $saved_ids ? implode(',', $saved_ids) : null,
                    'force_logout' => 1
                    ]);
            }else{
                DB::table('users')->where('id', $request->user)->update([
                    'device_id' => $saved_ids ? $saved_ids : $request->device_id,
                    'force_logout' => 1
                ]);
            }
            
            echo json_encode('success');
        }catch(\Illuminate\Database\QueryException $ex){ 
            echo json_encode('failed'); 
        }
    }

}
