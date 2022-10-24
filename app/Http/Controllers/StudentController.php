<?php

namespace App\Http\Controllers;

use App\City;
use App\Student;
use App\ClientAddress;
use App\ClientDocument;
use App\ClientEmployment;
use App\Country;
use App\AcquisitionSource;
use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use App\PostalCode;
use App\State;
use App\Gender;
use App\Relative;
use URL;
use DB;
use File;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class StudentController extends AccessRightsAuth
{
    protected   $duplicate      = [];
    public function index()
    {
        return view("student.list");
    }

    public function studentList()
    {
        $students = Student::leftjoin('countries', 'students.country_id', '=', 'countries.id')
                            ->leftjoin('cities', 'students.city_id', '=', 'cities.id')
                            ->leftjoin('states', 'students.state_id', '=', 'states.id')
                            ->leftjoin('postal_codes', 'students.postal_code_id', '=', 'postal_codes.id')
                            ->select('students.*', 'countries.name as country', 'cities.name as city', 'states.name as state', 'postal_codes.postal_code as postal_code')
                            ->get();
        // $clients = Student::all();
        // echo json_encode(array('client' => $clients));
        return response()->json([
            'msg'       =>  'Students has Fetched',
            'status'    =>  'success',
            'client'    =>  $students
        ]);
    }


    public function create()
    {
        // $customer_types         =   DB::table('customer_types')->get();
        $acquisition_sources    =   DB::table('acquisition_source')->get();
        // $residence_status       =   DB::table('residence_status')->get();
        return view("student.create", compact('acquisition_sources'));
    }

    public function edit($id)
    {
        // $customer_types         =   DB::table('customer_types')->get();
        $acquisition_sources    =   DB::table('acquisition_source')->get();
        // $residence_status       =   DB::table('residence_status')->get();
        $countries              =    Country::all();
        // $states                 =    State::all();
        // $cities                 =    City::all();
        // $PostalCode             =    PostalCode::all();

        $client = Student::where('students.id', $id)
                    ->leftjoin('countries', 'students.country_id', '=', 'countries.id')
                    ->leftjoin('cities', 'students.city_id', '=', 'cities.id')
                    ->leftjoin('states', 'students.state_id', '=', 'states.id')
                    ->leftjoin('postal_codes', 'students.postal_code_id', '=', 'postal_codes.id')
                    ->leftjoin('contact_types', 'students.client_type', '=', 'contact_types.id')
                    ->leftjoin('acquisition_source', 'acquisition_source.id', '=', 'students.acquisition_source')
                    ->leftjoin('residence_status', 'students.residence_status', 'residence_status.id')
                    ->leftjoin('genders', 'students.gender_id', 'genders.id')
                    ->select('students.*', 'countries.name as country', 'cities.name as city', 'states.name as state', 'postal_codes.postal_code as postal_code', 'contact_types.contact_name as client_type_name', 'acquisition_source.name as acquisition_source_name', 'residence_status.residence_name as residence', 'genders.gender_name as gender')
                    ->first();

        // $acquisition_sources    =   DB::table('acquisition_source')->get();
        // $client = Student::where('students.id', $id)
        //     ->leftjoin('acquisition_source', 'acquisition_source.id', '=', 'students.acquisition_source')
        //     ->leftjoin('genders', 'students.gender_id', 'genders.id')
        //     ->select('students.*', 'acquisition_source.name as acquisition_source_name',  'genders.gender_name as gender')
        //     ->first();
        return view("student.edit", compact('client', 'acquisition_sources'));
    }
    public function geographical_data()
    {

        $genders        =    Gender::all();
        $countries      =    Country::all();
        $states         =    State::all();
        $PostalCode     =    PostalCode::all();

        $result                 = [];
        $result['genders']      = $genders;
        $result['countries']    = $countries;
        $result['states']       = $states;
        $result['PostalCode']   = $PostalCode;

        return response()->json([
            'status'    =>  'success',
            'msg'       =>  "Geographyical Data Fetched Successfully",
            'result'    =>   $result
        ]);
    }
    ///Get All Countries
    public function get_all_countries()
    {
        $countries = Country::all();

        return response()->json([
            'status'     =>  'success',
            'msg'        =>  "Countries Fetched Successfully",
            'countries'  =>  $countries
        ]);
    }
    public function getStateAgainst_Country($id)
    {
        $states = State::where('states.country_id', $id)->get();

        return response()->json([
            'status'  =>  'success',
            'msg'     =>  "States Fetched Successfully",
            'states'  =>  $states
        ]);
    }

    public function getCityAgainst_States($id)
    {

        $cities = City::where('cities.state_id', $id)->get();
        return response()->json([
            'status' =>  'success',
            'msg'    =>  "Cities Fetched Successfully",
            'cities' =>  $cities
        ]);
    }
    public function getPostalcodeAgainst_City($id)
    {

        $PostalCode = PostalCode::where('postal_codes.city_id', $id)->get();
        return response()->json([
            'status'     =>  'success',
            'msg'        =>  "Postal Codes Fetched Successfully",
            'PostalCode' => $PostalCode
        ]);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        /*   *** Validation OF Form***    */
        $validate = $this->validate($request, [
            'acquisition_source'     =>    'required',
            'first_name'             =>    'required',
            'last_name'              =>    'required',
            'dob'                    =>    'required',
            'gender_id'              =>    'required',
            'email'                  =>    'required',
            'whatsapp_no'            =>    'required',
            'secondary_phone'        =>    'required',
            'primary_cellphone'      =>    'required',
            'password'               =>    'required',
            'student_code'           =>    'required',
            'account_type'           =>    'required',
            'password_created_by'    =>    'required',
            'added_via'              =>    'required',
            'status'                 =>    'required',
            'primary_address'        =>    'required',
            'country_id'             =>    'required|not_in:0',
            'state_id'               =>    'required|not_in:0',
            'city_id'                =>    'required|not_in:0',
            // 'postal_code_id'         =>    'required|not_in:0',
        ]);
        $age = Carbon::parse($request->dob)->diff(Carbon::now())->y;
        if ($request->hasFile('profile_img')) {
                $profile_img           =   $request->profile_img->store('student', 'public');
                }else{
                $profile_img           =   $request->hidden_profile_img;
                }
              
        if ($request->relationship_type) {
            $relationship_type           =   $request->relationship_type;
            }else{
            $relationship_type           =   0;
            }  
        if($request->id){
             $query  =   Student::whereRaw('(student_code = "'.$request->student_code.'" OR email = "'.$request->email.'" ) AND id != '.$request->id.'')
                                  ->first();
            // $query  =   Select::("SELECT * FROM `students` WHERE (student_code = '$request->student_code' OR email = '$request->student_code') AND id != '$request->id'")
            if($query){
                return response()->json([
                    'msg'       =>  'duplicate Entry',
                    'status'    =>  'duplicate'
                ]);
            }else{
                  Student::where('id', $request->id)->update([
                   'acquisition_source'      =>   $request->acquisition_source,
                   'student_code'            =>   $request->student_code,
                   'account_type'            =>   $request->account_type,
                   'added_via'               =>   $request->added_via,
                   'status'                  =>   $request->status,
                   'relationship_type'       =>   $relationship_type,

                     //Basic Info
                    'first_name'             =>   $request->first_name,
                    'middle_name'            =>   $request->middle_name,
                    'last_name'              =>   $request->last_name,
                    'dob'                    =>   $request->dob,
                    'age'                    =>   $age,
                    'gender_id'              =>   $request->gender_id,
                     //user Registration
                    'email'                  =>   $request->email,  
                    // 'password'               =>   Hash::make($request->password),
                    'password'               =>   $request->password,
                    'profile_img'            =>   $profile_img,
                    'password_created_by'    =>   $request->password_created_by,
                     //Contact Detail
                    'whatsapp_no'            =>   $request->whatsapp_no,
                    'secondary_phone'        =>   $request->secondary_phone,
                    'primary_cellphone'      =>   $request->primary_cellphone,
                    'house_no'               =>   $request->house_no,
                    'primary_address'        =>   $request->primary_address,
                    'country_id'             =>   $request->country_id,
                    'state_id'               =>   $request->state_id,
                    'city_id'                =>   $request->city_id,
                    'postal_code_id'         =>   $request->postal_code_id,
                    'updated_at'             =>   date('Y-m-d H:i:s'),
                    'updated_by'             =>   Auth::user()->id,
                    // 'employment_status'      =>   $request->employment_status,
                     // 'marital_status'         =>   $request->marital_status,
                    // 'residence_status'       =>   $request->residence_status,
                    // 'primary_landline'       =>   $request->primary_landline,

                ]);
                ClientAddress::where('student_id', $request->id)->update([ 
                    'primary_cellphone'      =>   $request->primary_cellphone,
                    'house_no'               =>   $request->house_no,
                    'primary_address'        =>   $request->primary_address,
                    'country_id'             =>   $request->country_id,
                    'state_id'               =>   $request->state_id,
                    'city_id'                =>   $request->city_id,
                    'postal_code_id'         =>   $request->postal_code_id,
                    'updated_at'             =>   date('Y-m-d H:i:s'),
                    'updated_by'             =>   Auth::user()->id,
                ]);
                return response()->json([
                'msg'       =>  'Student Has been Updated',
                'status'    =>  'success',
                ]);
            }
    }else{
            $query  =   Student::where('student_code',$request->student_code)
                                ->orwhere('email',$request->email)
                                ->first();
            if($query){
                return response()->json([
                'msg'       =>  'duplicate Entry',
                'status'    =>  'duplicate'
                ]);
            }else{
                $student = new Student(); 
                $student->student_code               =    $request->student_code;
                $student->acquisition_source         =    $request->acquisition_source;
                $student->account_type               =    $request->account_type;
                $student->added_via                  =    $request->added_via;
                $student->status                     =    $request->status;
                $student->relationship_type          =    $relationship_type;

                //Basic Info
                $student->first_name                 =    $request->first_name;
                $student->last_name                  =    $request->last_name;
                $student->middle_name                =    $request->middle_name;
                $student->dob                        =    $request->dob;
                $student->gender_id                  =    $request->gender_id;
                //user Registration
                $student->email                      =    $request->email;
                $student->password                   =    Hash::make($request->password);
                $student->profile_img                =    $profile_img;
                $student->password_created_by        =    $request->password_created_by;
                //Contact Detail
                $student->whatsapp_no                =    $request->whatsapp_no;
                $student->secondary_phone            =    $request->secondary_phone;
                $student->primary_cellphone          =    $request->primary_cellphone;
                $student->house_no                   =    $request->house_no;
                $student->primary_address            =    $request->primary_address;
                $student->country_id                 =    $request->country_id;
                $student->state_id                   =    $request->state_id;
                $student->city_id                    =    $request->city_id;
                $student->postal_code_id             =    $request->postal_code_id;
                $student->created_at                 =    date('Y-m-d H:i:s');
                $student->created_by                 =    Auth::user()->id;
                $student->updated_by                 =    Auth::user()->id;
                $student->updated_at                 =    date('Y-m-d H:i:s');
                $student->age                        =   $age;
                $student->save();

                // Inserting Address As Primary 
                $insert                          =    new  ClientAddress();
                $insert->primary_address         =   $student->primary_address;
                $insert->student_id  =   $student->id;
                $insert->house_no                =   $student->house_no;
                $insert->primary_landline        =   $student->primary_landline;
                $insert->primary_cellphone       =   $student->primary_cellphone;
                $insert->country_id              =   $student->country_id;
                $insert->state_id                =   $student->state_id;
                $insert->city_id                 =   $student->city_id;
                $insert->postal_code_id          =   $student->postal_code_id;
                $insert->created_at              =    date('Y-m-d H:i:s');
                $insert->created_by              =    Auth::user()->id;
                $insert->updated_by              =    Auth::user()->id;
                $insert->updated_at              =    date('Y-m-d H:i:s');
                $insert->save();
                // $current_id = $student->id;

                return response()->json([
                    'msg'       =>  'Student Added',
                    'status'    =>  'success'
                ]);
            }
        }
    }
    // public function Update(Request $request)
    // {

    //     /*   *** Validation OF Form***    */
    //   $validate = $this->validate($request, [

    //         'acquisition_source'     =>    'required',
    //         'first_name'             =>    'required',
    //         'last_name'              =>    'required',
    //         'dob'                    =>    'required',
    //         'gender_id'              =>    'required',
    //         'email'                  =>    'required',
    //         'whatsapp_no'            =>    'required',
    //         'secondary_phone'        =>    'required',
    //         'primary_cellphone'      =>    'required',
    //         'password'               =>    'required',
    //         'student_code'           =>    'required',
    //         'account_type'           =>    'required',
    //         'password_created_by'    =>    'required',
    //         'added_via'              =>    'required',
    //         'status'                 =>    'required',
    //         // 'primary_address'        =>    'required',
    //         // 'country_id'             =>    'required|not_in:0',
    //         // 'state_id'               =>    'required|not_in:0',
    //         // 'city_id'                =>    'required|not_in:0',
    //         // 'postal_code_id'         =>    'required|not_in:0',

    //     ]);
       
    // }
    public function show($id)
    {
        $documents = DB::table('document_verifications')->get();
        // $client = Client::find($id);
        //  $clients=Client::all();
        $client = Student::where('students.id', $id)
            ->leftjoin('countries', 'students.country_id', '=', 'countries.id')
            ->leftjoin('cities', 'students.city_id', '=', 'cities.id')
            ->leftjoin('states', 'students.state_id', '=', 'states.id')
            ->leftjoin('postal_codes', 'students.postal_code_id', '=', 'postal_codes.id')
            ->leftjoin('residence_status', 'students.residence_status', 'residence_status.id')
            ->leftjoin('genders', 'genders.id', 'students.gender_id')
            ->leftjoin('acquisition_source', 'acquisition_source.id', 'students.acquisition_source')
            ->leftjoin('customer_types', 'customer_types.id', 'students.client_type')
            ->select(
                'students.*',
                'countries.name as country',
                'cities.name as city',
                'states.name as state',
                'postal_codes.postal_code as postal_code',
                'residence_status.residence_name as residence',
                'genders.gender_name as gender',
                'acquisition_source.name as acquisition_source',
                'customer_types.type_name as client_type'
            )
            ->first();

        return view("student.index", compact('client', 'documents'));
    }
    public function edit_client($id)
    {
        $client = Student::where('id', $id)->first();
        return response()->json([
            'status'    =>  'success',
            'msg'      =>  "Data Successfully Updated",
            'client'   =>  $client
        ]);
    }

    /*** save_client Functions Saving  As a Whole Data From MODULES **/


    // public function save_address(Request $request)
    // {
    //     $already_exist   = false;
    //     $insert          = null;
    //     $update         = null;
    //     if ($request->operation == 'add') {
    //         if (ClientAddress::where('student_id', $request->client_id)->where('primary_address', $request->primary_address)->first()) {
    //             $already_exist = true;
    //         } else {

    //             /* START  *** Validation OF Address Form***    */

    //             $validate = $this->validate($request, [
    //                 'house_no'           =>    'required',
    //                 'primary_landline'   =>    'required|numeric',
    //                 'primary_cellphone'  =>    'required|numeric',
    //                 'primary_address'    =>    'required',
    //                 'country_id'         =>    'required|not_in:0',
    //                 'state_id'           =>    'required|not_in:0',
    //                 'city_id'            =>    'required|not_in:0',
    //                 'postal_code_id'     =>    'required|not_in:0',

    //             ]);


    //             /*  END  *** Validation OF Address Form***    */

    //             $insert                          =    new  ClientAddress();
    //             $insert->address_type            =    $request->address_type;
    //             $insert->primary_address         =    $request->primary_address;
    //             $insert->student_id  =    $request->client_id;
    //             $insert->house_no                =    $request->house_no;
    //             $insert->primary_landline        =    $request->primary_landline;
    //             $insert->primary_cellphone       =    $request->primary_cellphone;
    //             $insert->country_id              =    $request->country_id;
    //             $insert->state_id                =    $request->state_id;
    //             $insert->city_id                 =    $request->city_id;
    //             $insert->postal_code_id          =    $request->postal_code_id;
    //             $insert->created_at              =    date('Y-m-d H:i:s');
    //             $insert->created_by              =    Auth::user()->id;
    //             $insert->updated_by              =    Auth::user()->id;
    //             $insert->updated_at              =    date('Y-m-d H:i:s');
    //             //  $insert->client()->sync([]);
    //             $insert->save();
    //         }

    //         if ($insert) {
    //             return response()->json([
    //                 'status'        =>  'success',
    //                 'msg'          =>  "Data Successfully Added",

    //             ]);
    //         } else if ($already_exist) {
    //             return response()->json([
    //                 'status' =>  'already_exist',
    //                 'msg'    =>  "Please provide valid Information."
    //             ]);
    //         } else {
    //             return response()->json([

    //                 'status' =>  'error',
    //                 'msg'    =>  "Failed."
    //             ]);
    //         }
    //     } else {

    //         if (ClientAddress::where('student_id', $request->client_id)->whereRaw('primary_address = "' . $request->primary_address . '" And id NOT IN (' . $request->opp_id . ')')->first()) {
    //             $already_exist = true;
    //         } else {
    //             try {

    //                 /* START  *** Validation OF Address Form***    */

    //                 $validate = $this->validate(
    //                     $request,
    //                     [
    //                         'house_no'           =>    'required',
    //                         'primary_landline'   =>    'required',
    //                         'primary_cellphone'  =>    'required',
    //                         'primary_address'    =>    'required',
    //                         'country_id'         =>    'required|not_in:0',
    //                         'state_id'           =>    'required|not_in:0',
    //                         'city_id'            =>    'required|not_in:0',
    //                         'postal_code_id'      =>    'required|not_in:0',

    //                     ]
    //                 );

    //                 /*  END  *** Validation OF Address Form***    */

    //                 $update = ClientAddress::where('id', $request->opp_id)->update([
    //                     'address_type'           => $request->address_type,
    //                     'primary_address'        => $request->primary_address,
    //                     'house_no'               => $request->house_no,
    //                     'primary_landline'       => $request->primary_landline,
    //                     'primary_cellphone'      => $request->primary_cellphone,
    //                     'country_id'             => $request->country_id,
    //                     'state_id'               => $request->state_id,
    //                     'city_id'                => $request->city_id,
    //                     'postal_code_id'         => $request->postal_code_id,
    //                     'updated_at'             => date('Y-m-d H:i:s'),
    //                     'updated_by'             => Auth::user()->id
    //                 ]);
    //             } catch (\Illuminate\Database\QueryException $ex) {
    //                 return $ex;
    //             }
    //         }
    //         if ($update) {
    //             return response()->json([
    //                 'status'  =>  'success',
    //                 'msg'    =>  "Data Successfully Updated"
    //             ]);
    //         } else if ($already_exist) {
    //             return response()->json([
    //                 'status' =>  'already_exist',
    //                 'msg'    =>  "Please provide valid Information."
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' =>  'error',
    //                 'msg'    =>  "Failed."
    //             ]);
    //         }
    //     }
    // }
    // public function save_employment(Request $request)
    // {
    //     // dd($request->all());
    //     $already_exist = false;
    //     $insert = null;
    //     $update = null;
    //     if ($request->operation == 'add') {
    //         if (ClientEmployment::where('student_id', $request->client_id)->where('company_name', $request->company_name)->first()) {

    //             $already_exist = true;
    //         } else {

    //             /* START  *** Validation OF Employee Form***    */

    //             $validate = $this->validate($request, [

    //                 'company_name'              =>    'required',
    //                 'company_contact_number'    =>    'required',
    //                 'job_title'                 =>    'required',
    //                 'office_no'                 =>    'required',
    //                 'street_address'            =>    'required',
    //                 'employment_status'         =>    'required',
    //                 'country_id2'               =>    'required|not_in:0',
    //                 'state_id2'                 =>    'required|not_in:0',
    //                 'city_id2'                  =>    'required|not_in:0',
    //                 'postal_code_id2'           =>    'required|not_in:0'

    //             ]);

    //             /*  END  *** Validation OF Employee Form***    */

    //             $insert                          =    new  ClientEmployment(); // 
    //             $insert->company_name            =    $request->company_name;
    //             $insert->student_id  =    $request->client_id;
    //             $insert->company_contact_number  =    $request->company_contact_number;
    //             $insert->job_title               =    $request->job_title;
    //             $insert->office_no               =    $request->office_no;
    //             $insert->street_address          =    $request->street_address;
    //             $insert->employment_status       =    $request->employment_status;
    //             $insert->country_id2             =    $request->country_id2;
    //             $insert->state_id2               =    $request->state_id2;
    //             $insert->city_id2                =    $request->city_id2;
    //             $insert->postal_code_id2         =    $request->postal_code_id2;
    //             $insert->created_at              =    date('Y-m-d H:i:s');
    //             $insert->created_by              =    Auth::user()->id;
    //             $insert->updated_by              =    Auth::user()->id;
    //             $insert->updated_at              =    date('Y-m-d H:i:s');
    //             //  $insert->client()->sync([]);
    //             $insert->save();
    //         }
    //         if ($insert) {
    //             return response()->json([
    //                 'status'        =>  'success',
    //                 'msg'          =>  "Data Successfully Added",

    //             ]);
    //         } else if ($already_exist) {
    //             return response()->json([
    //                 'status' =>  'already_exist',
    //                 'msg'    =>  "Please provide valid Information."
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' =>  'error',
    //                 'msg'    =>  "Failed."
    //             ]);
    //         }
    //     } else {

    //         if (ClientEmployment::where('student_id', $request->client_id)->whereRaw('company_name = "' . $request->company_name . '" And id NOT IN (' . $request->opp_id . ')')->first()) {

    //             $already_exist = true;
    //         } else {
    //             try {

    //                 /* START  *** Validation OF Employee Form***    */

    //                 $validate = $this->validate($request, [

    //                     'company_name'              =>    'required',
    //                     'company_contact_number'    =>    'required',
    //                     'job_title'                 =>    'required',
    //                     'office_no'                 =>    'required',
    //                     'street_address'            =>    'required',
    //                     'employment_status'         =>    'required',
    //                     'country_id2'               =>    'required|not_in:0',
    //                     'state_id2'                 =>    'required|not_in:0',
    //                     'city_id2'                  =>    'required|not_in:0',
    //                     'postal_code_id2'           =>    'required|not_in:0'
    //                 ]);

    //                 /*  END  *** Validation OF Employee Form***    */
    //                 $update = ClientEmployment::where('id', $request->opp_id)->update([
    //                     'company_name'             => $request->company_name,
    //                     'company_contact_number'   => $request->company_contact_number,
    //                     'job_title'                => $request->job_title,
    //                     'office_no'                => $request->office_no,
    //                     'street_address'           => $request->street_address,
    //                     'employment_status'        => $request->employment_status,
    //                     'country_id2'              => $request->country_id2,
    //                     'state_id2'                => $request->state_id2,
    //                     'city_id2'                 => $request->city_id2,
    //                     'postal_code_id2'          => $request->postal_code_id2,
    //                     'updated_at'               => date('Y-m-d H:i:s'),
    //                     'updated_by'               => Auth::user()->id
    //                 ]);
    //             } catch (\Illuminate\Database\QueryException $ex) {
    //                 return $ex;
    //             }
    //         }
    //         if ($update) {
    //             return response()->json([
    //                 'status'  =>  'success',
    //                 'msg'    =>  "Data Successfully Updated"
    //             ]);
    //         } else if ($already_exist) {
    //             return response()->json([
    //                 'status' =>  'already_exist',
    //                 'msg'    =>  "Please provide valid Information."
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' =>  'error',
    //                 'msg'    =>  "Failed."
    //             ]);
    //         }
    //     }
    // }
    // public function save_document(Request $request)
    // {

    //     if ($request->operation == 'add') {
    //         if (ClientDocument::where('student_id', $request->client_id)->where('document_number', $request->document_number)->first()) {
    //             $already_exist = true;
    //         } else {


    //             /* START  *** Validation OF Document Form***    */

    //             $validate = $this->validate($request, [
    //                 'doc_front_image'  =>    'required | mimes:jpeg,jpg,png,PNG,JPEG',
    //                 'doc_back_image'   =>    'required | mimes:jpeg,jpg,png,PNG,JPEG',
    //                 'document_number'  =>    'required',
    //                 'document_type'    =>    'required',
    //                 'issuance_date'    =>    'required',
    //                 'expiry_date'      =>    'required'
    //             ]);

    //             /*  END  *** Validation OF Document Form***    */

    //             $insert  = new  ClientDocument();

    //             if ($request->hasFile('doc_front_image')) {

    //                 $front_image    =   $request->doc_front_image->store('images', 'public');
    //                 $back_image     =   $request->doc_back_image->store('images', 'public');

    //                 $insert->doc_front_image    =   $front_image;
    //                 $insert->doc_back_image     =   $back_image;
    //             }

    //             $insert->document_number         =    $request->document_number;
    //             $insert->student_id  =    $request->client_id;
    //             $insert->document_type           =    $request->document_type;
    //             $insert->issuance_date           =    $request->issuance_date;
    //             $insert->expiry_date             =    $request->expiry_date;
    //             $insert->created_at              =    date('Y-m-d H:i:s');
    //             $insert->created_by              =    Auth::user()->id;
    //             $insert->updated_by              =    Auth::user()->id;
    //             $insert->updated_at              =    date('Y-m-d H:i:s');
    //             //  $insert->client()->sync([]);
    //             $insert->save();
    //         }

    //         if ($insert) {
    //             return response()->json([
    //                 'status'        =>  'success',
    //                 'msg'          =>  "Data Successfully Added",

    //             ]);
    //         } else if ($already_exist) {
    //             return response()->json([
    //                 'status' =>  'already_exist',
    //                 'msg'    =>  "Please provide valid Information."
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' =>  'error',
    //                 'msg'    =>  "Failed."
    //             ]);
    //         }
    //     } else {

    //         if (ClientDocument::whereRaw('document_number = "' . $request->document_number . '" And id NOT IN (' . $request->opp_id . ')')->first()) {
    //             $already_exist = true;
    //         } else {
    //             try {

    //                 /* START  *** Validation OF Document Form***    */

    //                 $validate = $this->validate($request, [

    //                     'document_number'  =>    'required',
    //                     'document_type'    =>    'required',
    //                     'issuance_date'    =>    'required',
    //                     'expiry_date'      =>    'required'
    //                 ]);
    //                 $data                  =     [
    //                     'document_number'          => $request->document_number,
    //                     'document_type'            => $request->document_type,
    //                     'issuance_date'            => $request->issuance_date,
    //                     'expiry_date'              => $request->expiry_date,
    //                     'updated_at'               => date('Y-m-d H:i:s'),
    //                     'updated_by'               => Auth::user()->id
    //                 ];
    //                 /*  END  *** Validation OF Document Form***    */

    //                 if ($request->hasFile('doc_front_image')) {
    //                     $data['doc_front_image']    =  $request->doc_front_image->store('images', 'public');
    //                 } else {
    //                     if (empty($request->doc_front_image_hidden)) {

    //                         return response()->json([
    //                             'status'  =>  'validate',
    //                             'msg'    =>  "Front Image Should not empty"
    //                         ]);
    //                     }
    //                 }
    //                 if ($request->hasFile('doc_back_image')) {
    //                     $data['doc_back_image']    =   $request->doc_back_image->store('images', 'public');
    //                 } else {
    //                     if (empty($request->doc_back_image_hidden)) {

    //                         return response()->json([
    //                             'status'  =>  'validate',
    //                             'msg'    =>  "Back Image Should not empty"
    //                         ]);
    //                     }
    //                 }
    //                 $update = ClientDocument::where('id', $request->opp_id)->update($data);
    //             } catch (\Illuminate\Database\QueryException $ex) {
    //                 return $ex;
    //             }
    //         }

    //         if ($update) {
    //             return response()->json([
    //                 'status'  =>  'success',
    //                 'msg'    =>  "Data Successfully Updated"
    //             ]);
    //         } else if ($already_exist) {
    //             return response()->json([
    //                 'status' =>  'already_exist',
    //                 'msg'    =>  "Please provide valid Information."
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' =>  'error',
    //                 'msg'    =>  "Failed."
    //             ]);
    //         }
    //     }
    // }
    // public function save_relation(Request $request)
    // {
    //     $already_exist = false;
    //     $insert = null;
    //     $update = null;
    //     if ($request->operation == 'add') {

    //         if ((Client::where('first_name', $request->first_name)->first()) && (Relative::where('relationship_type', $request->relationship_type)->first())) {

    //             $already_exist = true;
    //         } else {


    //             /*  START *** Validation OF Relatation Form***    */

    //             $validate = $this->validate($request, [
    //                 'first_name'             =>    'required',
    //                 'last_name'              =>    'required',
    //                 'relationship_type'      =>    'required',
    //                 're_gender_id'           =>    'required',
    //                 'email'                  =>    'required',
    //                 'home_phone_no'          =>    'required',
    //                 'cell_phone_no'          =>    'required',

    //             ]);

    //             /*  END  *** Validation OF Relatation Form***    */
    //             $client = new Client();

    //             $client->first_name                 =    $request->first_name;
    //             $client->last_name                  =    $request->last_name;
    //             $client->middle_name                =    $request->middle_name;
    //             $client->gender_id                  =    $request->re_gender_id;
    //             $client->email                      =    $request->email;
    //             $client->primary_cellphone          =    $request->cell_phone_no;
    //             $client->primary_landline           =    $request->home_phone_no;
    //             $client->save();

    //             $new_client_id = $client->id;


    //             //Secondary Client

    //             $insert  = new  Relative();
    //             $insert->secondary_contact_id    =    $new_client_id;
    //             $insert->student_id  =    $request->client_id;
    //             $insert->relationship_type       =    $request->relationship_type;
    //             $insert->created_at              =    date('Y-m-d H:i:s');
    //             $insert->created_by              =    Auth::user()->id;
    //             $insert->updated_by              =    Auth::user()->id;
    //             $insert->updated_at              =    date('Y-m-d H:i:s');
    //             //  $insert->client()->sync([]);
    //             $insert->save();
    //             $relative_type_invers = $insert->relationship_type;


    //             if ($request->gender_id == 1 && $relative_type_invers == 1) {
    //                 //Male and Father will return Son
    //                 $request->relationship_type = 3;
    //             } else if ($request->gender_id == 1 && $relative_type_invers == 3) {
    //                 //Male and Son will return Father
    //                 $request->relationship_type = 1;
    //             } else if ($request->gender_id == 1 && $relative_type_invers == 4) {
    //                 //Male and Daughter will return Father
    //                 $request->relationship_type = 1;
    //             } else if ($request->gender_id == 2 && $relative_type_invers == 3) {
    //                 //Female and Son will return Mother
    //                 $request->relationship_type = 2;
    //             } else if ($request->gender_id == 2 && $relative_type_invers == 4) {
    //                 //Female and Son will return Mother
    //                 $request->relationship_type = 2;
    //             } else if ($request->gender_id == 1 && $relative_type_invers == 2) {
    //                 //Male and Mother will return Son
    //                 $request->relationship_type = 3;
    //             } else if ($request->gender_id == 2 && $relative_type_invers == 1) {
    //                 //Female and Father will return Daughter
    //                 $request->relationship_type = 4;
    //             } else if ($request->gender_id == 2 && $relative_type_invers == 2) {
    //                 //Female and Mother will return Daughter
    //                 $request->relationship_type = 4;
    //             } else if ($request->gender_id == 2 && $relative_type_invers == 5) {
    //                 //Female and Brother will return Sister
    //                 $request->relationship_type = 6;
    //             } else if ($request->gender_id == 2 && $relative_type_invers == 6) {
    //                 //Female and Sister will return Sister
    //                 $request->relationship_type = 6;
    //             } else if ($request->gender_id == 1 && $relative_type_invers == 6) {
    //                 //Male and Sister will return Brother
    //                 $request->relationship_type = 5;
    //             } else if ($request->gender_id == 1 && $relative_type_invers == 5) {
    //                 //Male and Brother will return Brother
    //                 $request->relationship_type = 5;
    //             } else if ($request->gender_id == 2 && $relative_type_invers == 7) {
    //                 //Female and Spouse will return Spouse
    //                 $request->relationship_type = 7;
    //             } else if ($request->gender_id == 1 && $relative_type_invers == 8) {
    //                 //Male and Legal Partner will return Legal Partner
    //                 $request->relationship_type = 8;
    //             } else if ($request->gender_id == 2 && $relative_type_invers == 8) {
    //                 //Femle and Legal Partner will return Legal Partner
    //                 $request->relationship_type = 8;
    //             } else if ($request->gender_id == 1 && $relative_type_invers == 9) {
    //                 //Male and Relative will return Relative
    //                 $request->relationship_type = 9;
    //             } else if ($request->gender_id == 2 && $relative_type_invers == 9) {
    //                 //Femle and Relative will return Relative
    //                 $request->relationship_type = 9;
    //             } else if ($request->gender_id == 1 && $relative_type_invers == 10) {
    //                 //Male and Friend will return Friend
    //                 $request->relationship_type = 10;
    //             } else if ($request->gender_id == 2 && $relative_type_invers == 10) {
    //                 //Femle and Friend will return Friend
    //                 $request->relationship_type = 10;
    //             } else if ($request->gender_id == 1 && $relative_type_invers == 11) {
    //                 //Male and Bussines Partner will return Bussines Partner
    //                 $request->relationship_type = 11;
    //             } else if ($request->gender_id == 2 && $relative_type_invers == 11) {
    //                 //Femle and Bussines Partner will return Bussines Partner
    //                 $request->relationship_type = 11;
    //             }

    //             //Primary Client 
    //             $new = new Relative();

    //             $new->secondary_contact_id    =    $request->client_id;
    //             $new->student_id  =    $new_client_id;
    //             $new->relationship_type       =    $request->relationship_type;
    //             $new->created_at              =    date('Y-m-d H:i:s');
    //             $new->created_by              =    Auth::user()->id;
    //             $new->updated_by              =    Auth::user()->id;
    //             $new->updated_at              =    date('Y-m-d H:i:s');
    //             $new->save();

    //             // $secondary_id1 =  $new_client_id;           // this Client id is from New CLient Register id  while making relation As Secondary.
    //             // $secondary_id2 =  $request->client_id;       // this Client id is from old CLient  id  while making relation As Primary.

    //         }
    //         if ($insert) {
    //             return response()->json([
    //                 'status'        =>  'success',
    //                 'msg'          =>  "Data Successfully Added",

    //             ]);
    //         } else if ($already_exist) {
    //             return response()->json([
    //                 'status' =>  'already_exist',
    //                 'msg'    =>  "Already Exist."
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' =>  'error',
    //                 'msg'    =>  "Failed."
    //             ]);
    //         }
    //     } else {


    //         // if (Relation::where('secondary_contact_id','!=', $request->secondary_id)->where('relationship_type','! =' ,$request->relationship_type )->first())
    //         //      {                                                                                                                     
    //         //     $already_exist = true;
    //         // } else {

    //         $update = CLient::where('id', $request->secondary_id)->update([
    //             'first_name'           =>  $request->first_name,
    //             'middle_name'          =>  $request->middle_name,
    //             'last_name'            =>  $request->last_name,
    //             'gender_id'            =>  $request->re_gender_id,
    //             'email'                =>  $request->email,
    //             'primary_landline'     =>  $request->home_phone_no,
    //             'primary_cellphone'    =>  $request->cell_phone_no

    //         ]);

    //         /**   Updating Relation Type of Primary  */
    //         $update  = Relative::where('id', $request->opp_id)
    //             ->update([
    //                 'relationship_type' => $request->relationship_type,
    //             ]);
    //         /** END */

    //         $relative_type_invers = $request->relationship_type;


    //         if ($request->gender_id == 1 && $relative_type_invers == 1) {
    //             //Male and Father will return Son
    //             $request->relationship_type = 3;
    //         } else if ($request->gender_id == 1 && $relative_type_invers == 3) {
    //             //Male and Son will return Father
    //             $request->relationship_type = 1;
    //         } else if ($request->gender_id == 1 && $relative_type_invers == 4) {
    //             //Male and Daughter will return Father
    //             $request->relationship_type = 1;
    //         } else if ($request->gender_id == 2 && $relative_type_invers == 3) {
    //             //Female and Son will return Mother
    //             $request->relationship_type = 2;
    //         } else if ($request->gender_id == 2 && $relative_type_invers == 4) {
    //             //Female and Son will return Mother
    //             $request->relationship_type = 2;
    //         } else if ($request->gender_id == 1 && $relative_type_invers == 2) {
    //             //Male and Mother will return Son
    //             $request->relationship_type = 3;
    //         } else if ($request->gender_id == 2 && $relative_type_invers == 1) {
    //             //Female and Father will return Daughter
    //             $request->relationship_type = 4;
    //         } else if ($request->gender_id == 2 && $relative_type_invers == 2) {
    //             //Female and Mother will return Daughter
    //             $request->relationship_type = 4;
    //         } else if ($request->gender_id == 2 && $relative_type_invers == 5) {
    //             //Female and Brother will return Sister
    //             $request->relationship_type = 6;
    //         } else if ($request->gender_id == 2 && $relative_type_invers == 6) {
    //             //Female and Sister will return Sister
    //             $request->relationship_type = 6;
    //         } else if ($request->gender_id == 1 && $relative_type_invers == 6) {
    //             //Male and Sister will return Brother
    //             $request->relationship_type = 5;
    //         } else if ($request->gender_id == 1 && $relative_type_invers == 5) {
    //             //Male and Brother will return Brother
    //             $request->relationship_type = 5;
    //         } else if ($request->gender_id == 2 && $relative_type_invers == 7) {
    //             //Female and Spouse will return Spouse
    //             $request->relationship_type = 7;
    //         } else if ($request->gender_id == 1 && $relative_type_invers == 8) {
    //             //Male and Legal Partner will return Legal Partner
    //             $request->relationship_type = 8;
    //         } else if ($request->gender_id == 2 && $relative_type_invers == 8) {
    //             //Femle and Legal Partner will return Legal Partner
    //             $request->relationship_type = 8;
    //         } else if ($request->gender_id == 1 && $relative_type_invers == 9) {
    //             //Male and Relative will return Relative
    //             $request->relationship_type = 9;
    //         } else if ($request->gender_id == 2 && $relative_type_invers == 9) {
    //             //Femle and Relative will return Relative
    //             $request->relationship_type = 9;
    //         } else if ($request->gender_id == 1 && $relative_type_invers == 10) {
    //             //Male and Friend will return Friend
    //             $request->relationship_type = 10;
    //         } else if ($request->gender_id == 2 && $relative_type_invers == 10) {
    //             //Femle and Friend will return Friend
    //             $request->relationship_type = 10;
    //         } else if ($request->gender_id == 1 && $relative_type_invers == 11) {
    //             //Male and Bussines Partner will return Bussines Partner
    //             $request->relationship_type = 11;
    //         } else if ($request->gender_id == 2 && $relative_type_invers == 11) {
    //             //Femle and Bussines Partner will return Bussines Partner
    //             $request->relationship_type = 11;
    //         }

    //         $update  = Relative::where('secondary_contact_id', $request->client_id)
    //             ->where('student_id', $request->secondary_id)
    //             ->update([
    //                 'relationship_type' => $request->relationship_type,
    //             ]);


    //         if ($update) {
    //             return response()->json([
    //                 'status'  =>  'success',
    //                 'msg'    =>  "Data Successfully Updated"
    //             ]);
    //         } else if ($already_exist) {
    //             return response()->json([
    //                 'status' =>  'already_exist',
    //                 'msg'    =>  "Already Exit."
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' =>  'error',
    //                 'msg'    =>  "Failed."
    //             ]);
    //         }
    //     }
    // }

    /*** Save_client Function END  **/
    public function GetClient_AllData($id)
    {

        $client_address = ClientAddress::where('client_address.student_id', $id)
            ->leftjoin('countries', 'client_address.country_id', '=', 'countries.id')
            ->leftjoin('cities', 'client_address.city_id', '=', 'cities.id')
            ->leftjoin('states', 'client_address.state_id', '=', 'states.id')
            ->leftjoin('postal_codes', 'client_address.postal_code_id', '=', 'postal_codes.id')
            ->select('client_address.*', 'countries.name as country', 'cities.name as city', 'states.name as state', 'postal_codes.postal_code as postal_code')
            ->get();



        // $client_employment_info = ClientEmployment::where('client_employment_info.student_id', $id)
        //     ->leftjoin('countries', 'client_employment_info.country_id2', '=', 'countries.id')
        //     ->leftjoin('cities', 'client_employment_info.city_id2', '=', 'cities.id')
        //     ->leftjoin('states', 'client_employment_info.state_id2', '=', 'states.id')
        //     ->leftjoin('postal_codes', 'client_employment_info.postal_code_id2', '=', 'postal_codes.id')
        //     ->select('client_employment_info.*', 'countries.name as country', 'cities.name as city', 'states.name as state', 'postal_codes.postal_code as postal_code')
        //     ->get();

        // $client_document = ClientDocument::where('client_documents.student_id', $id)
        //     ->leftjoin('document_verifications', 'document_verifications.id', '=', 'client_documents.document_type')
        //     ->select('client_documents.*', 'document_verifications.document_verification_name as name')
        //     ->get();

        // $client_relatives = Relative::where('client_relationships.student_id', $id)
        //     ->join('students', 'students.id', '=', 'client_relationships.secondary_contact_id')
        //     ->selectRaw("client_relationships.id as client_relationships_id,student_id,relationship_type,secondary_contact_id")
        //     ->selectRaw(" students.*")
        //     ->selectRaw("(SELECT CONCAT(pri.first_name,' ',pri.middle_name ,' ',pri.last_name) from students pri WHERE pri.id = client_relationships.student_id) as primary_name  ")
        //     ->get();


        // $count_document     =   COUNT($client_document);
        // $count_employment   =   COUNT($client_employment_info);
        $count_address      =   COUNT($client_address);
        // $count_relatives    =   COUNT($client_relatives);

        return response()->json([
            'client_address'         => $client_address,
            // 'client_employment_info' => $client_employment_info,
            // 'client_document'        => $client_document,
            // 'client_relatives'       => $client_relatives,
            // 'count_relatives'        => $count_relatives,
            // 'count_document'         => $count_document,
            // 'count_employment'       => $count_employment,
            'count_address'          => $count_address
        ]);
        //echo json_encode(array('client_address' => $client_address, 'client_employment_info' => $client_employment_info, 'client_document' => $client_document, 'client_relatives' => $client_relatives, 'count_relatives' => $count_relatives, 'count_document' => $count_document, 'count_employment' => $count_employment, 'count_address' => $count_address));
    }


    /*** Client Module Functions Start **/

    public function GetClientAddress($id)
    {

        $client_address = ClientAddress::where('client_address.id', $id)
            ->leftjoin('countries', 'client_address.country_id', '=', 'countries.id')
            ->leftjoin('cities', 'client_address.city_id', '=', 'cities.id')
            ->leftjoin('states', 'client_address.state_id', '=', 'states.id')
            ->leftjoin('postal_codes', 'client_address.postal_code_id', '=', 'postal_codes.id')
            ->select('client_address.*', 'countries.name as country', 'cities.name as city', 'states.name as state', 'postal_codes.postal_code as postal_code')
            ->first();

        return response()->json($client_address);
    }
    public function GetClientEmplomentInfo($id)
    {
        $employment     =    ClientEmployment::where('id', $id)->first();
        return response()->json([
            'status'      =>  'success',
            'msg'         =>  "Please provide valid section.",
            'employment'  =>  $employment
        ]);
    }


    public function GetClientDocument($id)
    {
        $document = ClientDocument::where('id', $id)->first();
        $base_url = URL::to('/') . '/storage' . '/';
        return response()->json([
            'base_url' => $base_url,
            'document' => $document

        ]);
    }
    public function GetClientRelative($id)
    {
        $relative = Relative::where('id', $id)->first();
        return response()->json([
            'status'    =>  'success',
            'msg'       =>  "Success.",
            'relative'  =>  $relative

        ]);
    }


    /*** Client Module Functions END  **/

    public function remove_doc_images($id, Request $request)
    {
        // dd($request->all());
        $image_name   =   $request->image;

        $image = ClientDocument::where('id', $id)->update([
            "$image_name" => '',
        ]);

        return response()->json([
            'status'    =>  'success',
            'msg'       =>  "Image has Deleted",
            'image'  =>  $image

        ]);
    }
    public function DownloadSampleCLients()
    {

        $filePath   =   public_path("sample_client.xlsx?v=1.0");
        return redirect('/sample_client.xlsx?v=1.0');
    }
  
    public function UploadExcelFile(Request $request)
    {
        $extension = File::extension($request->file->getClientOriginalName());
        //    dd($extension);

        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {


            $the_file = $request->file('file');
            $spreadsheet  = IOFactory::load($the_file->getRealPath());

            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range(2, $row_limit);
            $column_range = range('v', $column_limit);
            // $counter = 2;
            $data = array();
            $flag = true;
            // dd($row_limit);

            if ($row_limit > 1) {
                $counter = 0;
                $not_uploaded = [];
                foreach ($row_range as $data) {
                    $data_student_code            =      $sheet->getCell('a' . $data)->getValue();
                    $data_student_type            =      $sheet->getCell('b' . $data)->getValue();
                    $data_first_name              =      $sheet->getCell('e' . $data)->getValue();
                    $data_email                   =      $sheet->getCell('s' . $data)->getValue();
                    $data_user_name               =      $sheet->getCell('t' . $data)->getValue();
                    $counter++;     


                    if(!in_array($data_student_code,$this->duplicate)){
                        $this->duplicate[]  =   $data_student_code;
                    }else{
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "Student Code is Duplicated in following line"
                        ];
                    }
                    if($data_student_type == 'primary' && in_array($data_email,$this->duplicate)){
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "Email is Duplicate in following line"
                        ];
                      }else{
                        $this->duplicate[]       =   $data_email;
                      }
                      if($data_student_type == 'secondary' && in_array($data_user_name,$this->duplicate)){
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "User Name is Duplicate in following line"
                        ];
                      }else{
                        $this->duplicate[]       =   $data_user_name;
                      }

                   
                      if(empty($data_student_code)){
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "Student Code is Missing in following line"
                        ];
                      }
                      if(empty($data_student_type)){
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "Student Type is Missing in following line"
                        ];
                      }
                      if(empty($data_first_name)){
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "First Name is Missing in following line"
                        ];
                      }
                      if($data_student_type == 'primary' && empty($data_email)){
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "Email Missing in following line"
                        ];
                      }
                      if($data_student_type == 'secondary' && empty($data_user_name)){
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "User Name Missing in following line"
                        ];
                      }
                    }
                      if($flag == false){
                        return response()->json([
                            'status'           =>   'empty',
                            'uploading_error'  =>    $not_uploaded
                        ]);
                      }
                      else{
                         foreach ($row_range as $data) {
                            $data_student_code            =      $sheet->getCell('a' . $data)->getValue();
                            $data_student_type            =      $sheet->getCell('b' . $data)->getValue();
                            $data_primary_student_code    =      $sheet->getCell('c' . $data)->getValue();
                            $data_acquisition_source      =      $sheet->getCell('d' . $data)->getValue();
                            $data_first_name              =      $sheet->getCell('e' . $data)->getValue();
                            $data_middle_name             =      $sheet->getCell('f' . $data)->getValue();
                            $data_last_name               =      $sheet->getCell('g' . $data)->getValue();
                            $data_gender                  =      $sheet->getCell('h' . $data)->getValue();
                            $data_dob                     =      $sheet->getCell('i' . $data)->getValue();
                            $data_house_no                =      $sheet->getCell('j' . $data)->getValue();
                            $data_primary_address         =      $sheet->getCell('k' . $data)->getValue();
                            $data_primary_cellphone       =      $sheet->getCell('l' . $data)->getValue();
                            $data_secondary_phone         =      $sheet->getCell('m' . $data)->getValue();
                            $data_whatsapp_no             =      $sheet->getCell('n' . $data)->getValue();
                            $data_postal_code             =      $sheet->getCell('o' . $data)->getValue();
                            $data_city                    =      $sheet->getCell('p' . $data)->getValue();
                            $data_state                   =      $sheet->getCell('q' . $data)->getValue();
                            $data_country                 =      $sheet->getCell('r' . $data)->getValue();
                            $data_email                   =      $sheet->getCell('s' . $data)->getValue();
                            $data_user_name               =      $sheet->getCell('t' . $data)->getValue();
                            $data_password                =      $sheet->getCell('u' . $data)->getValue();
                            // $data_profile_img             =      $sheet->getCell('v' . $data)->getValue();
                            $counter++;  
                        //  WHERE (student_code = 'zee-1231' OR email = 'new@email.com' OR user_name = 'asdasd')
                        if (DB::table('students')->whereRaw('(student_code = "'.$data_student_code.'" OR email ="'.$data_email.'" OR user_name ="'.$data_user_name.'")')->first()) {
                            $not_uploaded[] = [
                                'count'              =>   $counter,
                                'student_code'       =>   $data_student_code,
                                'email'              =>   $data_email,
                                'user_name'          =>   $data_user_name,
                                'reason'             =>   "Duplicate"
                            ];
                            // dump( $not_uploaded, $errors);
                            // $data_uploaded[] = false;
                            return response()->json([
                                'status'           =>   'failed',
                                'uploading_error'  =>    $not_uploaded
                            ]);
                        } else {
                                $client = new Student();
                                // Checking Acquisition  Source
                                $acquisition_source                 =    AcquisitionSource::where('name', $data_acquisition_source)->first();
                                if ($acquisition_source == true) {
                                    $acquisition_source                 =   $acquisition_source->id;
                                    $client->acquisition_source         =   $acquisition_source;
                                } else {
                                    // inserting new AQ-source
                                    $add_acquisition_src                =    new AcquisitionSource();
                                    $add_acquisition_src->name          =    $data_acquisition_source;
                                    $add_acquisition_src->created_by    =    Auth::user()->id;
                                    $add_acquisition_src->updated_by    =    Auth::user()->id;
                                    $add_acquisition_src->save();

                                    //  this Below id is getting From new Entered Aq-src
                                    $client->acquisition_source         =   $add_acquisition_src->id;
                                }
                                // $client_type                =    CustomerType::where('type_name', $data_client_type)->first();
                                // if ($client_type == true) {
                                //     $client_type_id             =     $client_type->id;
                                //     $client->client_type        =     $client_type_id;
                                // } else {

                                //     $add_clientType                 =    new CustomerType();
                                //     $add_clientType->type_name      =    $data_client_type;
                                //     $add_clientType->save();

                                //     //  this Below id is getting From new Entered Client-type
                                //     $client->client_type            =   $add_clientType->id;
                                // }

                                // $client->life_cycle_stage           =    $data_life_cycle_stage;
                                // Getting Gender id from  
                                $gender                             =    Gender::where('gender_name', $data_gender)->first();
                                if ($gender == true) {
                                    $gender_id                      =    $gender->id;
                                    $client->gender_id              =    $gender_id;
                                } else {
                                    $add_gender                     =    new Gender();
                                    $add_gender->gender_name        =    $data_gender;
                                    $add_gender->save();

                                    //  This Below id is getting From new Entered Gender.
                                    $client->gender_id              =   $add_gender->id;
                                }
                                $country           =   Country::where('name', $data_country)->first();
                                //Checking Country Exsist or Not
                                if ($country == true) {
                                    $country_id                    =    $country->id;
                                    $client->country_id            =    $country_id;
                                } else {
                                    //Adding New Country
                                    $add_country                   =    new Country();
                                    $add_country->name             =    $data_country;
                                    $add_country->created_at       =    date('Y-m-d H:i:s');
                                    $add_country->created_by       =    Auth::user()->id;
                                    $add_country->updated_by       =    Auth::user()->id;
                                    $add_country->updated_at       =    date('Y-m-d H:i:s');
                                    $add_country->save();
                                    //  This Below id is getting From new Entered Country.
                                    $client->country_id            =    $add_country->id;
                                }
                                    $state              =   State::where('name', $data_state)->first();
                                //Checking State Exsist or Not
                                if ($state == true) {
                                    $state_id           =   $state->id;
                                    // State_id Coming from Above City QUERY
                                    $client->state_id   =    $state_id;
                                } else {
                                    $add_state                   =      new State();
                                    $add_state->name             =    $data_state;
                                    $add_state->country_id       =    $client->country_id;
                                    $add_state->created_at       =    date('Y-m-d H:i:s');
                                    $add_state->created_by       =    Auth::user()->id;
                                    $add_state->updated_by       =    Auth::user()->id;
                                    $add_state->updated_at       =    date('Y-m-d H:i:s');
                                    $add_state->save();
                                    // State_id Coming from Above New STATE Detail 
                                    $client->state_id            =    $add_state->id;
                                }
                                //Checking Cities 
                                $city                       =   City::where('name', $data_city)->first();
                                if ($city == true) {
                                    $city_id                    =   $city->id;
                                    // City_id Coming from Above City QUERY
                                    $client->city_id            =  $city_id;
                                } else {
                                    $add_city                   =      new City();
                                    $add_city->country_id       =    $client->country_id;
                                    $add_city->state_id         =    $client->state_id;
                                    $add_city->name             =    $data_city;
                                    $add_city->created_at       =    date('Y-m-d H:i:s');
                                    $add_city->created_by       =    Auth::user()->id;
                                    $add_city->updated_by       =    Auth::user()->id;
                                    $add_city->updated_at       =    date('Y-m-d H:i:s');
                                    $add_city->save();

                                    // City_id Coming from Above New City Detail 
                                    $client->city_id            =   $add_city->id;
                                }
                                //Checking Postal Codes 
                                    $postal_code                =    DB::table("postal_codes")->where('postal_code', $data_postal_code)->first();
                                if ($postal_code == true) {
                                    $postal_code_id             =    $postal_code->id;
                                    // Postal_id Coming from Above POSTAL QUERY
                                    $client->postal_code_id     =    $postal_code_id;
                                } else {
                                    $add_postal_code                          =    new PostalCode();
                                    $add_postal_code->postal_code             =    $data_postal_code;
                                    $add_postal_code->country_id              =    $client->country_id;
                                    $add_postal_code->state_id                =    $client->state_id;
                                    $add_postal_code->city_id                 =    $client->city_id;
                                    $add_postal_code->created_at              =    date('Y-m-d H:i:s');
                                    $add_postal_code->created_by              =    Auth::user()->id;
                                    $add_postal_code->updated_by              =    Auth::user()->id;
                                    $add_postal_code->updated_at              =    date('Y-m-d H:i:s');
                                    $add_postal_code->save();
                                    // Postal_id Coming from Above New Postal Detail 
                                    $client->postal_code_id      =      $add_postal_code->id;
                                }
                            
                                $client->student_code               =    $data_student_code;
                                $client->primary_student_code       =    $data_primary_student_code;
                                $client->first_name                 =    $data_first_name;
                                $client->last_name                  =    $data_last_name;
                                $client->middle_name                =    $data_middle_name;
                                $client->dob                        =    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data_dob);
                            
                                $age                                =    Carbon::parse($client->dob)->diff(Carbon::now())->y;
                                $client->age                        =    $age;
                                $client->email                      =    $data_email;
                                $client->password                   =    $data_password;
                                $client->password_created_by        =    1; //admin
                                $data_student_type == 'primary'? $client->account_type = 1 : $client->account_type=2;
                                $client->status                     =    2;
                                $client->added_via                  =    1;
                                $client->primary_cellphone          =    $data_primary_cellphone;
                                $client->primary_address            =    $data_primary_address;
                                $client->created_at                 =    date('Y-m-d H:i:s');
                                $client->created_by                 =    Auth::user()->id;
                                $client->updated_by                 =    Auth::user()->id;
                                $client->updated_at                 =    date('Y-m-d H:i:s');
                                    $client->save();
                                $array_primary_std_code[]   =   [
                                    'student_id'            =>  $client->id,
                                    'primary_student_code'  =>  $client->primary_student_code
                                ];
                                
                                if($client->primary_student_code != ''){
                                    Student::where('primary_student_code',$client->primary_student_code)->update([
                                        'user_name'     =>  $data_user_name,
                                    ]);
                                    
                                }

                                // Inserting Address As Primary 
                                $insert                          =    new  ClientAddress();
                                $insert->primary_address         =   $client->primary_address;
                                $insert->student_id  =   $client->id;
                                $insert->house_no                =   $client->house_no;
                                $insert->primary_cellphone       =   $client->primary_cellphone;
                                $insert->country_id              =   $client->country_id;
                                $insert->state_id                =   $client->state_id;
                                $insert->city_id                 =   $client->city_id;
                                $insert->postal_code_id          =   $client->postal_code_id;
                                $insert->created_at              =    date('Y-m-d H:i:s');
                                $insert->created_by              =    Auth::user()->id;
                                $insert->updated_by              =    Auth::user()->id;
                                $insert->updated_at              =    date('Y-m-d H:i:s');
                                $insert->save();
                                if ($client->save()) {
                                    $data_uploaded[]  = true;
                                } else {
                                    $data_uploaded[]  = false;
                                }
                        
                        }
                }
                
               
                }
               
                if (in_array(true, $data_uploaded)) {
                    return response()->json([
                        'status'        =>   'success',
                        'not_uploaded'  =>    $not_uploaded
                    ]);
                } else {
                    return response()->json([
                        'status'        =>   'failed',
                        'not_uploaded'  =>    $not_uploaded
                    ]);
                }
            }
        } else {
            return response()->json([
                'status'       => 'failed',
                'not_uploaded' => ''
            ]);
        }
    }
}
