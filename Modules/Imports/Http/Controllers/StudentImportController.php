<?php

namespace Modules\Imports\Http\Controllers;

use App\AcquisitionSource;
use App\City;
use App\ClientAddress;
use App\Country;
use App\Gender;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Core\AccessRightsAuth;
use App\PostalCode;
use App\State;
use App\Student;
use Carbon\Carbon;
use DB;
use Auth;
use Modules\Imports\Imports\StudentImports;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentImportController extends AccessRightsAuth
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $page['page_header']    =   'Students';
        $page['url']            =   '/import-students';
        $page['sample-url']     =   'students_details_sample.xlsx';
        return view('imports::index',compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('imports::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        ini_set('memory_limit', '3000M');
        ini_set('max_execution_time', '0');

        $this->validate($request, [
            'file'  => 'required|file|mimes:xls,xlsx'
        ]);
        $import     =   new StudentImports();
        Excel::import($import,$request->file);
        if($import->getRowCount() > 0) {
            if (@count($import->getErrors()) > 0) {
                return Response()->json([
                    'status'    => 'error',
                    'msg'       => 'Invalid Data',
                    'errors'    =>  $import->getErrors(),
                    'header'    =>  $import->getHeader()
                ]);
            }else {
                foreach ($import->getData() as $row){
                    $student_code           =   $row['student_code'];
                    $student_type           =   mb_strtolower($row['student_type']);
                    $primary_student_code   =   $row['primary_student_code'];
                    $acquisition_source     =   $row['acquisition_source'];
                    $acquisition_type       =   $row['acquisition_type'];
                    $relation               =   $row['relation'];
                    $first_name             =   $row['first_name'];
                    $middle_name            =   $row['middle_name'];
                    $last_name              =   $row['last_name'];
                    $gender                 =   $row['gender'];
                    $dob                    =   Date::excelToDateTimeObject($row['dob']);
                    $houseunit_number       =   $row['houseunit_number'];
                    $address                =   $row['address'];
                    $primary_cell_phone     =   $row['primary_cell_phone'];   
                    $secondary_phone        =   $row['secondary_phone'];
                    $whatsapp_number        =   $row['whatsapp_number'];
                    $postal_code            =   $row['postal_code'];
                    $city                   =   $row['city'];
                    $state_province         =   $row['state_province'];
                    $country                =   $row['country'];
                    $email                  =   $row['email'];
                    $user_name              =   $row['user_name'];
                    $password               =   $row['password'];
                    // Student Type
                    if ($student_type   == 'primary'){
                        $account_type   =   '1';
                    }
                    if($student_type    == 'secondary'){
                        $account_type   =   '2';
                    }
                    // Acquisition Source if not exists add new
                    $acquisition_sources                =   AcquisitionSource::whereRaw("lower(name) = lower('{$acquisition_source}') AND lower(type) = lower('{$acquisition_type}')")->first();
                    if ($acquisition_sources) {
                        $acquisition_source_id          =   $acquisition_sources->id;
                    } else {
                        $add_acquisition                =   new AcquisitionSource();
                        $add_acquisition->name          =   $acquisition_source;
                        $add_acquisition->type          =   $acquisition_type;
                        $add_acquisition->created_by    =   Auth::user()->id;
                        $add_acquisition->save();
                        $acquisition_source_id          =   $add_acquisition->id;
                    }
                    // Gender
                    $gender_ids            =   Gender::whereRaw("lower(gender_name) = lower('{$gender}')")->first();
                    if($gender_ids){
                        $gender_id         =   $gender_ids->id;
                    }
                    // Relatonship
                    $relationship_id = '0';
                    if($relation != '' || $relation != null){
                        $relation_ids            =  DB::table('relationship_types')->whereRaw("lower(relation_name) = lower('{$relation}')")->first();
                        if($relation_ids){
                            $relationship_id     =  $relation_ids->id;
                        }else{
                            $add_relationship    =  DB::table('relationship_types')->insertGetId([
                                'relation_name'  => $relation,
                                'created_at'     => date('Y-m-d H:i:s')
                            ]);
                            $relationship_id     =  $add_relationship;
                        }
                    }
                    // Country check if not exists add new
                    $countries             =   Country::whereRaw("lower(name) = lower('{$country}')")->first();
                    if ($countries) {
                        $country_id                     =    $countries->id;
                    } else {
                        $add_country                    =    new Country();
                        $add_country->name              =    $country;
                        $add_country->created_by        =    Auth::user()->id;
                        $add_country->save();
                        $country_id                     =    $add_country->id;
                    }
                    // State Check if not exists add new
                    $states                =   State::whereRaw("lower(name) = lower('{$state_province}')")->first();
                    if ($states) {
                        $state_id                       =    $states->id;
                    } else {
                        $add_state                      =    new State();
                        $add_state->name                =    $state_province;
                        $add_state->country_id          =    $country_id;
                        $add_state->created_by          =    Auth::user()->id;
                        $add_state->save();
                        $state_id                       =    $add_state->id;
                    }
                    // City Check if not exists add new
                    $cities                =   City::whereRaw("lower(name) = lower('{$city}')")->first();
                    if ($cities) {
                        $city_id                        =    $cities->id;
                    } else {
                        $add_city                       =    new City();
                        $add_city->name                 =    $city;
                        $add_city->state_id             =    $state_id;
                        $add_city->country_id           =    $country_id;
                        $add_city->created_by           =    Auth::user()->id;
                        $add_city->save();
                        $city_id                        =    $add_city->id;
                    }
                    // Postal Code Check if not exists add new
                    $psotal_codes                =   PostalCode::whereRaw("lower(postal_code) = lower('{$postal_code}')")->first();
                    if ($psotal_codes) {
                        $postal_code_id                 =    $psotal_codes->id;
                    } else {
                        $add_postal_code                =    new PostalCode();
                        $add_postal_code->postal_code   =    $postal_code;
                        $add_postal_code->city_id       =    $city_id;
                        $add_postal_code->state_id      =    $state_id;
                        $add_postal_code->country_id    =    $country_id;
                        $add_postal_code->created_by    =    Auth::user()->id;
                        $add_postal_code->save();
                        $postal_code_id                 =    $add_postal_code->id;
                    }
                    // Calculate Age
                    $age                                      =    Carbon::parse($dob)->diff(Carbon::now())->y;
                    // Student Save
                    $save_student                             =    new Student();
                    $save_student->student_code               =    $student_code;
                    $save_student->primary_student_code       =    $primary_student_code;
                    $save_student->relationship_type          =    $relationship_id;
                    $save_student->account_type               =    $account_type;
                    if($account_type == '1'){
                        $save_student->email                  =    $email;
                    }
                    if($account_type == '2'){
                        $save_student->user_name              =    $user_name;
                    }
                    $save_student->acquisition_source         =    $acquisition_source_id;
                    $save_student->first_name                 =    $first_name;
                    $save_student->middle_name                =    $middle_name;
                    $save_student->last_name                  =    $last_name;
                    $save_student->gender_id                  =    $gender_id;
                    $save_student->dob                        =    $dob;
                    $save_student->age                        =    $age;
                    $save_student->added_via                  =    '1';
                    $save_student->status                     =    '2';
                    if($password != '' || $password != null){
                        $save_student->password               =    bcrypt($password);
                    }else{
                        $save_student->password               =    '';
                    }
                    $save_student->password_created_by        =    '1';
                    $save_student->secondary_phone            =    $secondary_phone;
                    $save_student->whatsapp_no                =    $whatsapp_number;
                    $save_student->primary_cellphone          =    $primary_cell_phone;
                    $save_student->primary_address            =    $address;
                    $save_student->country_id                 =    $country_id;
                    $save_student->state_id                   =    $state_id;
                    $save_student->city_id                    =    $city_id;
                    $save_student->postal_code_id             =    $postal_code_id;
                    $save_student->created_by                 =    Auth::user()->id;
                    $save_student->save();

                    if($account_type == '2'){
                        $primary_code[]   =   [
                            'student_id'                      =>    $save_student->id,
                            'p_st_code'                       =>    $primary_student_code,
                        ];
                    }
                    //Student Address Save
                    $save_address                             =    new ClientAddress();
                    $save_address->primary_address            =    $address;
                    $save_address->student_id                 =    $save_student->id;
                    $save_address->house_no                   =    $houseunit_number;
                    $save_address->primary_cellphone          =    $primary_cell_phone;
                    $save_address->country_id                 =    $country_id;
                    $save_address->state_id                   =    $state_id;
                    $save_address->city_id                    =    $city_id;
                    $save_address->postal_code_id             =    $postal_code_id;
                    $save_address->created_by                 =    Auth::user()->id;
                    $save_address->save();
                    
                }
                foreach($primary_code as $p_code){
                    Student::where('id',$p_code['student_id'])->update(['primary_student_code'=>$p_code['p_st_code']]);
                }
                return Response()->json([
                    'status' => 'success',
                    'msg'    => 'Uploaded Successfully',
                    'rows'   =>  $import->getRowCount()
                ]);
            }
        }else{
            return Response()->json([
                'status' => 'error',
                'msg' => 'Empty file.'
            ]);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('imports::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('imports::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
