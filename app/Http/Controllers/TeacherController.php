<?php

namespace App\Http\Controllers;

use App\City;
use App\Student;
use App\Models\Teacher;
use App\ClientAddress;

use App\Country;
use App\AcquisitionSource;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use App\PostalCode;
use App\State;
use App\Gender;
use App\Models\TeacherAddress;

use URL;
use DB;
use File;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\Relation;
use Svg\Tag\Rect;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    protected   $duplicate      = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("teacher.list");
    }

    public function teacherList()
    {
        $teachers = Teacher::leftjoin('countries', 'teachers.country_id', '=', 'countries.id')
                            ->leftjoin('cities', 'teachers.city_id', '=', 'cities.id')
                            ->leftjoin('states', 'teachers.state_id', '=', 'states.id')
                            ->leftjoin('postal_codes', 'teachers.postal_code_id', '=', 'postal_codes.id')
                            ->select('teachers.*', 'countries.name as country', 'cities.name as city', 'states.name as state', 'postal_codes.postal_code as postal_code')
                            ->get();
                            // dd($teachers);
        // $clients = Student::all();
        echo json_encode(array('client' => $teachers));
    }
    public function create()
    {
        // $customer_types         =   DB::table('customer_types')->get();
        $acquisition_sources    =   DB::table('acquisition_source')->get();
        $genders                =   DB::table('genders')->get();
        // $residence_status       =   DB::table('residence_status')->get();
        return view("teacher.create", compact('acquisition_sources','genders'));
    }

    // public function store(Request $request)
    // {

    //     // dd($request->id);
    //     /*   *** Validation OF Form***    */
    //     $validate = $this->validate($request, [
    //         'acquisition_source'     =>    'required',
    //         'first_name'             =>    'required',
    //         'last_name'              =>    'required',
    //         'dob'                    =>    'required',
    //         'date_of_joining'        =>    'required',
    //         'gender_id'              =>    'required',
    //         'email'                  =>    'required',
    //         'whatsapp_no'            =>    'required',
    //         'secondary_phone'        =>    'required',
    //         'primary_cellphone'      =>    'required',
    //         'password'               =>    'required',
    //         'instructor_code'        =>    'required',
    //         'password_created_by'    =>    'required',
    //         'added_via'              =>    'required',
    //         'status'                 =>    'required',
    //         'primary_address'        =>    'required',
    //         'country_id'             =>    'required|not_in:0',
    //         'state_id'               =>    'required|not_in:0',
    //         'city_id'                =>    'required|not_in:0',
    //         // 'postal_code_id'         =>    'required|not_in:0',
    //     ]);
    //     $age = Carbon::parse($request->dob)->diff(Carbon::now())->y;
    //     if ($request->hasFile('profile_img')) {
    //             $profile_img           =   $request->profile_img->store('student', 'public');
    //             }else{
    //             $profile_img           =   $request->hidden_profile_img;
    //             }

    //     if($request->id){
    //             $query                 =   Teacher::whereRaw('(instructor_code = "'.$request->instructor_code.'" OR email = "'.$request->email.'" ) AND id != '.$request->id.'')
    //                                          ->first();
    //         // $query  =   Select::("SELECT * FROM `students` WHERE (instructor_code = '$request->instructor_code' OR email = '$request->instructor_code') AND id != '$request->id'")
    //         if($query){
    //             return response()->json([
    //                 'msg'       =>  'duplicate Entry',
    //                 'status'    =>  'duplicate'
    //             ]);
    //         }else{
    //              $teacher =  Teacher::where('id', $request->id);
                
    //         }
    //         }else{
    //         $query  =   Teacher::where('instructor_code',$request->instructor_code)
    //                             ->orwhere('email',$request->email)
    //                             ->first();
    //         if($query){
    //             return response()->json([
    //             'msg'       =>  'duplicate Entry',
    //             'status'    =>  'duplicate'
    //             ]);
    //         }else{
    //            $teacher = new Teacher(); 
    //         }
         
    //            $teacher->instructor_code            =    $request->instructor_code;
    //            $teacher->acquisition_source         =    $request->acquisition_source;
             
    //            $teacher->added_via                  =    $request->added_via;
    //            $teacher->status                     =    $request->status;
    //             //Basic Info
    //            $teacher->first_name                 =    $request->first_name;
    //            $teacher->last_name                  =    $request->last_name;
    //            $teacher->middle_name                =    $request->middle_name;
    //            $teacher->dob                        =    $request->dob;
    //            $teacher->date_of_joining            =    $request->date_of_joining;
    //            $teacher->gender_id                  =    $request->gender_id;
    //             //user Registration
    //            $teacher->email                      =    $request->email;
    //            $teacher->password                   =    Hash::make($request->password);
    //            $teacher->profile_img                =    $profile_img;
    //            $teacher->password_created_by        =    $request->password_created_by;
    //             //Contact Detail
    //            $teacher->whatsapp_no                =    $request->whatsapp_no;
    //            $teacher->secondary_phone            =    $request->secondary_phone;
    //            $teacher->primary_cellphone          =    $request->primary_cellphone;
    //            $teacher->house_no                   =    $request->house_no;
    //            $teacher->primary_address            =    $request->primary_address;
    //            $teacher->country_id                 =    $request->country_id;
    //            $teacher->state_id                   =    $request->state_id;
    //            $teacher->city_id                    =    $request->city_id;
    //            $teacher->postal_code_id             =    $request->postal_code_id;
    //            $teacher->created_at                 =    date('Y-m-d H:i:s');
    //            $teacher->created_by                 =    Auth::user()->id;
    //            $teacher->updated_by                 =    Auth::user()->id;
    //            $teacher->updated_at                 =    date('Y-m-d H:i:s');
    //            $teacher->age                        =   $age;
    //            $teacher->save();

    //             // Inserting Address As Primary 
    //             $insert                          =    new  TeacherAddress();
    //             $insert->primary_address         =  $teacher->primary_address;
    //             $insert->teacher_id  =  $teacher->id;
    //             $insert->house_no                =  $teacher->house_no;
    //             $insert->primary_landline        =  $teacher->primary_landline;
    //             $insert->primary_cellphone       =  $teacher->primary_cellphone;
    //             $insert->country_id              =  $teacher->country_id;
    //             $insert->state_id                =  $teacher->state_id;
    //             $insert->city_id                 =  $teacher->city_id;
    //             $insert->postal_code_id          =  $teacher->postal_code_id;
    //             $insert->created_at              =    date('Y-m-d H:i:s');
    //             $insert->created_by              =    Auth::user()->id;
    //             $insert->updated_by              =    Auth::user()->id;
    //             $insert->updated_at              =    date('Y-m-d H:i:s');
    //             $insert->save();
    //             // $current_id =$teacher->id;

    //             return response()->json([
    //                 'msg'       =>  'Teacher Added',
    //                 'status'    =>  'success'
    //             ]);
    //         }
        
    // } 
    public function store(Request $request)
    {
        /*   *** Validation OF Form***    */
        $validate = $this->validate($request, [
            'acquisition_source'     =>    'required',
            'first_name'             =>    'required',
            'last_name'              =>    'required',
            'dob'                    =>    'required',
            'date_of_joining'        =>    'required',
            'gender_id'              =>    'required',
            'email'                  =>    'required',
            'whatsapp_no'            =>    'required',
            'secondary_phone'        =>    'required',
            'primary_cellphone'      =>    'required',
            'password'               =>    'required',
            'instructor_code'        =>    'required',
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
                $profile_img           =   $request->profile_img->store('teacher', 'public');
                }else{
                $profile_img           =   $request->hidden_profile_img;
                }
        if($request->id){
                $query                 =   Teacher::whereRaw('(instructor_code = "'.$request->instructor_code.'" OR email = "'.$request->email.'" ) AND id != '.$request->id.'')
                                            ->first();
            if($query){
                return response()->json([
                    'msg'       =>  'duplicate Entry',
                    'status'    =>  'duplicate'
                ]);
            }else{
                  Teacher::where('id', $request->id)->update([
                            'acquisition_source'      =>   $request->acquisition_source,
                            'instructor_code'         =>   $request->instructor_code,
                            'added_via'               =>   $request->added_via,
                            'status'                  =>   $request->status,
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
                                'date_of_joining'        =>   $request->date_of_joining,
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
              
                ]);
                    TeacherAddress::where('teacher_id', $request->id)->update([ 
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
                'msg'       =>  'Teacher Has been Updated',
                'status'    =>  'success',
                ]);
            }
            }else{
                 $query          =   Teacher::where('instructor_code',$request->instructor_code)
                                            ->orwhere('email',$request->email)
                                            ->first();
                if($query){
                    return response()->json([
                    'msg'       =>  'duplicate Entry',
                    'status'    =>  'duplicate'
                    ]);
                }else{
                $teacher = new Teacher(); 
                $teacher->instructor_code            =    $request->instructor_code;
                $teacher->acquisition_source         =    $request->acquisition_source;
                $teacher->added_via                  =    $request->added_via;
                $teacher->status                     =    $request->status;
                    //Basic Info
                $teacher->first_name                 =    $request->first_name;
                $teacher->last_name                  =    $request->last_name;
                $teacher->middle_name                =    $request->middle_name;
                $teacher->dob                        =    $request->dob;
                $teacher->date_of_joining            =    $request->date_of_joining;
                $teacher->gender_id                  =    $request->gender_id;
                    //user Registration
                $teacher->email                      =    $request->email;
                $teacher->password                   =    Hash::make($request->password);
                $teacher->profile_img                =    $profile_img;
                $teacher->password_created_by        =    $request->password_created_by;
                    //Contact Detail
                $teacher->whatsapp_no                =    $request->whatsapp_no;
                $teacher->secondary_phone            =    $request->secondary_phone;
                $teacher->primary_cellphone          =    $request->primary_cellphone;
                $teacher->house_no                   =    $request->house_no;
                $teacher->primary_address            =    $request->primary_address;
                $teacher->country_id                 =    $request->country_id;
                $teacher->state_id                   =    $request->state_id;
                $teacher->city_id                    =    $request->city_id;
                $teacher->postal_code_id             =    $request->postal_code_id;
                $teacher->created_at                 =    date('Y-m-d H:i:s');
                $teacher->created_by                 =    Auth::user()->id;
                $teacher->updated_by                 =    Auth::user()->id;
                $teacher->updated_at                 =    date('Y-m-d H:i:s');
                $teacher->age                        =   $age;
                $teacher->save();

                    // Inserting Address As Primary 
                    $insert                          =    new  TeacherAddress();
                    $insert->primary_address         =  $teacher->primary_address;
                    $insert->teacher_id  =  $teacher->id;
                    $insert->house_no                =  $teacher->house_no;
                    $insert->primary_landline        =  $teacher->primary_landline;
                    $insert->primary_cellphone       =  $teacher->primary_cellphone;
                    $insert->country_id              =  $teacher->country_id;
                    $insert->state_id                =  $teacher->state_id;
                    $insert->city_id                 =  $teacher->city_id;
                    $insert->postal_code_id          =  $teacher->postal_code_id;
                    $insert->created_at              =    date('Y-m-d H:i:s');
                    $insert->created_by              =    Auth::user()->id;
                    $insert->updated_by              =    Auth::user()->id;
                    $insert->updated_at              =    date('Y-m-d H:i:s');
                    $insert->save();
                    // $current_id =$teacher->id;

                    return response()->json([
                        'msg'       =>  'Teacher Added',
                        'status'    =>  'success'
                    ]);
                }
        }
    } 
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
       
        $acquisition_sources    =   DB::table('acquisition_source')->get();
    
        $countries              =    Country::all();
        

        $client = Teacher::where('teachers.id', $id)
                            ->leftjoin('countries', 'teachers.country_id', '=', 'countries.id')
                            ->leftjoin('cities', 'teachers.city_id', '=', 'cities.id')
                            ->leftjoin('states', 'teachers.state_id', '=', 'states.id')
                            ->leftjoin('postal_codes', 'teachers.postal_code_id', '=', 'postal_codes.id')
                            ->leftjoin('contact_types', 'teachers.client_type', '=', 'contact_types.id')
                            ->leftjoin('acquisition_source', 'acquisition_source.id', '=', 'teachers.acquisition_source')
                            ->leftjoin('residence_status', 'teachers.residence_status', 'residence_status.id')
                            ->leftjoin('genders', 'teachers.gender_id', 'genders.id')
                            ->select('teachers.*', 'countries.name as country', 'cities.name as city', 'states.name as state', 'postal_codes.postal_code as postal_code', 'contact_types.contact_name as client_type_name', 'acquisition_source.name as acquisition_source_name', 'residence_status.residence_name as residence', 'genders.gender_name as gender')
                            ->first();
        // $password   =   Crypt::decrypt($client->password);
        // dd(Hash::check($client->password));
        return view("teacher.edit", compact('client', 'acquisition_sources'));
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function DownloadSampleCLients()
    {
       
        $filePath   =   public_path("sample_teacher.xlsx?v=1.0");
        return redirect('/sample_teacher.xlsx?v=1.0');
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

            if ($row_limit > 1) {
                $counter = 0;
                $not_uploaded   = [];
              
                foreach ($row_range as $data) {
                    $data_instructor_code         =      $sheet->getCell('a' . $data)->getValue();
                    $data_first_name              =      $sheet->getCell('d' . $data)->getValue();
                    $data_email                   =      $sheet->getCell('r' . $data)->getValue();
                    $counter++;

                    if(!in_array($data_instructor_code,$this->duplicate)){
                        $this->duplicate[]  =   $data_instructor_code;
                    }else{
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "Instructor Code is Duplicated in following line"
                        ];
                    }
                    if(!in_array($data_email,$this->duplicate)){
                        $this->duplicate[]  =   $data_email;
                    }else{
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "Email is Duplicated in following line"
                        ];
                    }
                      if(empty($data_instructor_code)){
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "Instructor Code is Missing in following line"
                        ];
                      }
                      if(empty($data_first_name)){
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "First Name is Missing in following line"
                        ];
                      }
                      if(empty($data_email)){
                        $flag = false;
                        $not_uploaded[] = [
                            'count'              =>   $counter,
                            'reason'             =>   "Email Missing in following line"
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
                            $data_instructor_code         =      $sheet->getCell('a' . $data)->getValue();
                            $data_date_of_joining         =      $sheet->getCell('b' . $data)->getValue();
                            $data_acquisition_source      =      $sheet->getCell('c' . $data)->getValue();
                            $data_first_name              =      $sheet->getCell('d' . $data)->getValue();
                            $data_middle_name             =      $sheet->getCell('e' . $data)->getValue();
                            $data_last_name               =      $sheet->getCell('f' . $data)->getValue();
                            $data_gender                  =      $sheet->getCell('g' . $data)->getValue();
                            $data_dob                     =      $sheet->getCell('h' . $data)->getValue();
                            $data_house_no                =      $sheet->getCell('i' . $data)->getValue();
                            $data_primary_address         =      $sheet->getCell('j' . $data)->getValue();
                            $data_primary_cellphone       =      $sheet->getCell('k' . $data)->getValue();
                            $data_secondary_phone         =      $sheet->getCell('l' . $data)->getValue();
                            $data_whatsapp_no             =      $sheet->getCell('m' . $data)->getValue();
                            $data_postal_code             =      $sheet->getCell('n' . $data)->getValue();
                            $data_city                    =      $sheet->getCell('o' . $data)->getValue();
                            $data_state                   =      $sheet->getCell('p' . $data)->getValue();
                            $data_country                 =      $sheet->getCell('q' . $data)->getValue();
                            $data_email                   =      $sheet->getCell('r' . $data)->getValue();
                            $data_password                =      $sheet->getCell('s' . $data)->getValue();
                            $counter++;
                        //  WHERE (instructor_code = 'zee-1231' OR email = 'new@email.com' OR user_name = 'asdasd')
                        if (DB::table('teachers')->whereRaw('(instructor_code = "'.$data_instructor_code.'" OR email ="'.$data_email.'")')->first()) {
                            $not_uploaded[] = [
                                'count'              =>   $counter,
                                'instructor_code'    =>   $data_instructor_code,
                                'email'              =>   $data_email,
                                'reason'             =>   "Duplicate"
                            ];
                            return response()->json([
                                'status'           =>   'failed',
                                'uploading_error'  =>    $not_uploaded
                            ]);
                        } else {
                                $client = new Teacher();
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
                                    $add_state                   =    new State();
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
                            
                                $client->instructor_code            =    $data_instructor_code;
                                $client->first_name                 =    $data_first_name;
                                $client->last_name                  =    $data_last_name;
                                $client->middle_name                =    $data_middle_name;
                                $client->dob                        =    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data_dob);
                                $age                                =    Carbon::parse($client->dob)->diff(Carbon::now())->y;
                                $client->age                        =    $age;
                                $client->date_of_joining            =    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data_date_of_joining);
                                $client->email                      =    $data_email;
                                $client->password                   =    $data_password;
                                $client->password_created_by        =    1; //admin
                                $client->status                     =    2;
                                $client->added_via                  =    1;
                                $client->house_no                   =    $data_house_no;
                                $client->primary_cellphone          =    $data_primary_cellphone;
                                $client->primary_address            =    $data_primary_address;
                                $client->created_at                 =    date('Y-m-d H:i:s');
                                $client->created_by                 =    Auth::user()->id;
                                $client->updated_by                 =    Auth::user()->id;
                                $client->updated_at                 =    date('Y-m-d H:i:s');
                                    $client->save();

                                // Inserting Address As Primary 
                                $insert                          =    new  TeacherAddress();
                                $insert->primary_address         =   $client->primary_address;
                                $insert->teacher_id              =   $client->id;
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
