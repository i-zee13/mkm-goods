<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use Auth;
use DB;

class SettingsController extends AccessRightsAuth
{

    public function manage_settings(){
        return view('settings.settings');
    }

    public function GetSettingsData(){
        $designations = DB::table('designations')->get();
        $departments = DB::table('departments')->get();
        $assets = DB::table('assets_types')->get();
        $cust_type = DB::table('customer_types')->get();
        $rates = [];//DB::table('exchange_rates')->get();
        $company_info =   DB::table('company_information')->get();
        $pallets_info =   [];//DB::table('pallets')->get();
        $contact_types = DB::table('contact_types')->get();
        $genders = DB::table('genders')->get();
        $relationship_types = DB::table('relationship_types')->get();
        $property_types = DB::table('property_types')->get();
        $document_verifications = DB::table('document_verifications')->get();
        $residence_status = DB::table('residence_status')->get();

        echo json_encode(array('designations' => $designations, 'departments' => $departments, 'assets' => $assets, 'cust_type' => $cust_type, 'rates' => $rates, 'company_info' => $company_info , 'pallets_info' => $pallets_info , 'genders' => $genders, 'relationship_types' => $relationship_types, 'property_types' => $property_types, 'document_verifications' => $document_verifications,'contact_types' => $contact_types,'residence_status' => $residence_status));
    }

    public function GetDesignation($id){
        echo json_encode(DB::table('designations')->where('id', $id)->first());
    }

    public function GetDepartment($id){
        echo json_encode(DB::table('departments')->where('id', $id)->first());
    }

    public function GetAssets($id){
        echo json_encode(DB::table('assets_types')->where('id', $id)->first());
    }

    public function GetCustType($id){
        echo json_encode(DB::table('customer_types')->where('id', $id)->first());
    }

    public function GetRate($id){
        echo json_encode(DB::table('exchange_rates')->where('id', $id)->first());
    }

    public function GetCompanyInfor($id){
        echo json_encode(DB::table('company_information')->where('id', $id)->first());
    }
    public function GetPallet($id){
        echo json_encode(DB::table('pallets')->where('id', $id)->first());
    }
    public function GetGender($id){
    
        echo json_encode(DB::table('genders')->where('id', $id)->first());
    }
    public function GetRelation($id){
        echo json_encode(DB::table('relationship_types')->where('id', $id)->first());
    }

    public function GetProperty($id){
        echo json_encode(DB::table('property_types')->where('id', $id)->first());
    }

    public function GetDocumentVerification($id){
        echo json_encode(DB::table('document_verifications')->where('id', $id)->first());
    }
    public function GetContact_types($id){
        echo json_encode(DB::table('contact_types')->where('id', $id)->first());
    }
    public function GetResidenceStatus($id){
        echo json_encode(DB::table('residence_status')->where('id', $id)->first());
    }



    public function save_settings(Request $request){
        $already_exist = false;
        $insert = null;
        $update = null;
        if($request->operation == 'add'){
            if($request->opp_name_input == 'designation'){
                if(DB::table('designations')->where('designation', $request->designation_name)->first()){
                    $already_exist = true;
                }else{
                    $insert = DB::table('designations')->insert([
                        'designation' => $request->designation_name,
                        'designation_rights' => ($request->designation_rights ? json_encode($request->designation_rights) : null),
                        'pnl_access' => $request->pnl_access,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => Auth::user()->id
                    ]);
                }
            }else if($request->opp_name_input == 'department'){
                if(DB::table('departments')->where('department', $request->department_name)->first()){
                    $already_exist = true;
                }else{
                    $insert = DB::table('departments')->insert([
                        'department' => $request->department_name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => Auth::user()->id
                    ]);
                }
            }else if($request->opp_name_input == 'assets'){
                if(DB::table('assets_types')->where('asset_name', $request->asset_name)->first()){
                    $already_exist = true;
                }else{
                    $insert = DB::table('assets_types')->insert([
                        'asset_name' => $request->asset_name,
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }else if($request->opp_name_input == 'gender'){
                
                if(DB::table('genders')->where('gender_name', $request->gender_name)->first()){
                    $already_exist = true;
                }else{
                    $insert = DB::table('genders')->insert([
                        'gender_name' => $request->gender_name,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            else if($request->opp_name_input == 'relation'){
                
                if(DB::table('relationship_types')->where('relation_name', $request->relation_name)->first()){
                    $already_exist = true;
                }else{
                    $insert = DB::table('relationship_types')->insert([
                        'relation_name' => $request->relation_name,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            else if($request->opp_name_input == 'contact_types'){
                if(DB::table('contact_types')->where('contact_name', $request->contact_name)->first()){
                    $already_exist = true;
                }else{
                    $insert = DB::table('contact_types')->insert([
                        'contact_name'      => $request->contact_name,
                        'contact_type_flag' => $request->contact_type_flag,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => Auth::user()->id
                    ]);
                }
            }else if($request->opp_name_input == 'residence'){
                if(DB::table('residence_status')->where('residence_name', $request->residence_name)->first()){
                    $already_exist = true;
                }else{
                    $insert = DB::table('residence_status')->insert([
                        'residence_name' => $request->residence_name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => Auth::user()->id
                    ]);
                }
            }

            else if($request->opp_name_input == 'property'){
                
                if(DB::table('property_types')->where('property_name', $request->property_name)->first()){
                    $already_exist = true;
                }else{
                    $insert = DB::table('property_types')->insert([
                        'property_name' => $request->property_name,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            } 
            else if($request->opp_name_input == 'document_verification_name'){
                
                if(DB::table('document_verifications')->where('document_verification_name', $request->document_verification_name)->first()){
                    $already_exist = true;
                }else{
                    $insert = DB::table('document_verifications')->insert([
                        'document_verification_name' => $request->document_verification_name,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            else if($request->opp_name_input == 'cust_type'){
                if(DB::table('customer_types')->whereRaw('type_name = "'.$request->customer_type.'" AND discount = '.$request->discount)->first()){
                    $already_exist = true;
                }else{
                    $insert = DB::table('customer_types')->insert([
                        'type_name' => $request->customer_type,
                        'discount' => $request->discount
                    ]);
                }
            }
            else if($request->opp_name_input == 'company_info'){
                if(DB::table('company_information')->whereRaw('business_email = "'.$request->business_email.'"')->first()){
                    $email_already_exist = true;
                }else{
                    $insert = DB::table('company_information')->insert([
                        'business_title' => $request->business_title,
                        'business_number' => $request->business_number,
                        'business_email' => $request->business_email,
                        'postal_code' => $request->postal_code,
                        'business_address' => $request->business_address,
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);  
                }
            }
            else if($request->opp_name_input == 'pallet'){ 
                $insert = DB::table('pallets')->insert([
                    'name' => $request->pallet_name,
                    'empty_pallet_weight' => $request->empty_pallet_weight,
                    'length' => $request->pallet_length,
                    'width' => $request->pallet_width
                ]);
            }
            else{
                $insert = DB::table('exchange_rates')->insert([
                    'exchange_rate' => $request->exchange_rate,
                    'date_from' => $request->date_from,
                    'date_till' => $request->date_till,
                    'currency' => $request->currency
                ]);
            }

            if($insert){
                echo json_encode('success');
            }else if($already_exist){
                echo json_encode('already_exist');
            }else if($email_already_exist){
                echo json_encode('email_already_exist');
            }else{
                echo json_encode('failed');
            }
        }else{
            if($request->opp_name_input == 'designation'){
                if(DB::table('designations')->whereRaw('designation = "'.$request->designation_name.'" And id NOT IN ('.$request->opp_id.')')->first()){
                    $already_exist = true;
                }else{
                    try{
                        $update = DB::table('designations')->where('id', $request->opp_id)->update([
                            'designation' => $request->designation_name,
                            'designation_rights' => ($request->designation_rights ? json_encode($request->designation_rights) : null),
                            'pnl_access' => $request->pnl_access,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                    }catch(\Illuminate\Database\QueryException $ex){ 
                       $insert = null;
                    }
                }
            }else if($request->opp_name_input == 'department'){
                if(DB::table('departments')->whereRaw('department = "'.$request->department_name.'" And id NOT IN ('.$request->opp_id.')')->first()){
                    $already_exist = true;
                }else{
                    try{
                        $update = DB::table('departments')->where('id', $request->opp_id)->update([
                            'department' => $request->department_name,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                    }catch(\Illuminate\Database\QueryException $ex){ 
                       $insert = null;
                    }
                }
            }else if($request->opp_name_input == 'assets'){
                if(DB::table('assets_types')->whereRaw('asset_name = "'.$request->asset_name.'" And id NOT IN ('.$request->opp_id.')')->first()){
                    $already_exist = true;
                }else{
                    try{
                        $update = DB::table('assets_types')->where('id', $request->opp_id)->update([
                            'asset_name' => $request->asset_name,
                            'updated_by' => Auth::user()->id,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }catch(\Illuminate\Database\QueryException $ex){ 
                       $insert = null;
                    }
                }
            }else if($request->opp_name_input == 'cust_type'){
                if(DB::table('customer_types')->whereRaw('type_name = "'.$request->customer_type.'" AND discount = '.$request->discount.' AND id NOT IN ('.$request->opp_id.')')->first()){
                    $already_exist = true;
                }else{
                    try{
                        $update = DB::table('customer_types')->where('id', $request->opp_id)->update([
                            'type_name' => $request->customer_type,
                            'discount' => $request->discount
                        ]);
                    }catch(\Illuminate\Database\QueryException $ex){ 
                       $insert = null;
                    }
                }
            }else if($request->opp_name_input == 'company_info'){
                if(DB::table('company_information')->where('business_email', '=', $request->business_email)->where('id', '!=', $request->opp_id)->first()){
                    $email_already_exist = true;
                }else{
                    try{
                        $update = DB::table('company_information')->where('id', $request->opp_id)->update([
                            'business_title' => $request->business_title,
                            'business_number' => $request->business_number,
                            'business_email' => $request->business_email,
                            'postal_code' => $request->postal_code,
                            'business_address' => $request->business_address,
                            'updated_by' => Auth::user()->id,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }catch(\Illuminate\Database\QueryException $ex){ 
                        $insert = null;
                    }
                }
            }else if($request->opp_name_input == 'pallet'){
                try{
                    $update = DB::table('pallets')->where('id', $request->opp_id)->update([
                        'name' => $request->pallet_name,
                        'empty_pallet_weight' => $request->empty_pallet_weight,
                        'length' => $request->pallet_length,
                        'width' => $request->pallet_width
                    ]);
                }catch(\Illuminate\Database\QueryException $ex){ 
                   $insert = null;
                }
            } else if($request->opp_name_input == 'gender'){
                if(DB::table('genders')->whereRaw('gender_name = "'.$request->gender_name.'" And id NOT IN ('.$request->opp_id.')')->first()){
                    $already_exist = true;
                }else{
                    try{
                        $update = DB::table('genders')->where('id', $request->opp_id)->update([
                            'gender_name' => $request->gender_name,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }catch(\Illuminate\Database\QueryException $ex){ 
                       $insert = null;
                    }
                }
            }  else if($request->opp_name_input == 'property'){
                if(DB::table('property_types')->whereRaw('property_name = "'.$request->property_name.'" And id NOT IN ('.$request->opp_id.')')->first()){
                    $already_exist = true;
                }else{
                    try{
                        $update = DB::table('property_types')->where('id', $request->opp_id)->update([
                            'property_name' => $request->property_name,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }catch(\Illuminate\Database\QueryException $ex){ 
                       $insert = null;
                    }
                }
            }else if($request->opp_name_input == 'contact_types'){
                if(DB::table('contact_types')->whereRaw('contact_name = "'.$request->contact_name.'" And id NOT IN ('.$request->opp_id.')')->first()){
                    $already_exist = true;
                }else{
                    try{
                        $update = DB::table('contact_types')->where('id', $request->opp_id)->update([
                            'contact_name'      => $request->contact_name,
                            'contact_type_flag' => $request->contact_type_flag,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => Auth::user()->id
                        ]);
                    }catch(\Illuminate\Database\QueryException $ex){ 
                       $insert = null;
                    }
                }
            } else if($request->opp_name_input == 'relation'){
                if(DB::table('relationship_types')->whereRaw('relation_name = "'.$request->relation_name.'" And id NOT IN ('.$request->opp_id.')')->first()){
                    $already_exist = true;
                }else{
                    try{
                        $update = DB::table('relationship_types')->where('id', $request->opp_id)->update([
                            'relation_name' => $request->relation_name,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }catch(\Illuminate\Database\QueryException $ex){ 
                       $insert = null;
                    }
                }
            } else if($request->opp_name_input == 'document_verification_name'){
                if(DB::table('document_verifications')->whereRaw('document_verification_name = "'.$request->document_verification_name.'" And id NOT IN ('.$request->opp_id.')')->first()){
                    $already_exist = true;
                }else{
                    try{
                        $update = DB::table('document_verifications')->where('id', $request->opp_id)->update([
                            'document_verification_name' => $request->document_verification_name,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }catch(\Illuminate\Database\QueryException $ex){ 
                       $insert = null;
                    }
                }
            } else if($request->opp_name_input == 'residence'){
                if(DB::table('residence_status')->whereRaw('residence_name = "'.$request->residence_name.'" And id NOT IN ('.$request->opp_id.')')->first()){
                    $already_exist = true;
                }else{
                    try{
                        $update = DB::table('residence_status')->where('id', $request->opp_id)->update([
                            'residence_name' => $request->residence_name,
                            'updated_by'     =>   Auth::user()->id,
                            'updated_at'     => date('Y-m-d H:i:s')
                        ]);
                    }catch(\Illuminate\Database\QueryException $ex){ 
                       $insert = null;
                    }
                }
            }else{
                try{
                    $update = DB::table('exchange_rates')->where('id', $request->opp_id)->update([
                        'exchange_rate' => $request->exchange_rate,
                        'date_from' => $request->date_from,
                        'date_till' => $request->date_till,
                        'currency' => $request->currency
                    ]);
                }catch(\Illuminate\Database\QueryException $ex){ 
                   $insert = null;
                }
            }

            if($update){
                echo json_encode('success');
            }else if($already_exist){
                echo json_encode('already_exist');
            }else if($email_already_exist){
                echo json_encode('email_already_exist');
            }else{
                echo json_encode('failed');
            }
        }
    }

    public function delete_from_settings(Request $request){
        if($request->type == 'rates'){
            $delete = DB::table('exchange_rates')->where('id', $request->id)->delete();
        }
        if($request->type == 'pallets'){
            $delete = DB::table('pallets')->where('id', $request->id)->delete();
        }
        if($delete){
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }
    }
}
