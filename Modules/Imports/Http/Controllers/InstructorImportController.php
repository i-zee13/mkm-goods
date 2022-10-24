<?php

namespace Modules\Imports\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Imports\Imports\InstructorImports;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Core\AccessRightsAuth;
use App\AcquisitionSource;
use App\City;
use App\Country;
use App\Gender;
use App\Models\Teacher;
use App\Models\TeacherAddress;
use App\PostalCode;
use App\State;

class InstructorImportController extends AccessRightsAuth
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $page['page_header']    =   'Instructors';
        $page['url']            =   '/import-instructors';
        $page['sample-url']     =   'instructors_details_sample.xlsx';
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
        $import     =   new InstructorImports();
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
                    $instructor_code        =   $row['instructor_code'];
                    $date_of_joining        =   Date::excelToDateTimeObject($row['date_of_joining']);
                    $acquisition_source     =   $row['acquisition_source'];
                    $acquisition_type       =   $row['acquisition_type'];
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
                    $password               =   $row['password'];

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
                    if ($states)  {
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
                    if ($cities)  {
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
                    if ($psotal_codes)  {
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

                    // Instructor Save
                    $save_instructor                             =    new Teacher();
                    $save_instructor->acquisition_source         =    $acquisition_source_id;
                    $save_instructor->first_name                 =    $first_name;
                    $save_instructor->middle_name                =    $middle_name;
                    $save_instructor->last_name                  =    $last_name;
                    $save_instructor->gender_id                  =    $gender_id;
                    $save_instructor->date_of_joining            =    $date_of_joining;
                    $save_instructor->dob                        =    $dob;
                    $save_instructor->age                        =    $age;
                    $save_instructor->email                      =    $email;
                    $save_instructor->instructor_code            =    $instructor_code;
                    $save_instructor->added_via                  =    '1';
                    $save_instructor->status                     =    '2';
                    if($password != '' || $password != null){
                        $save_instructor->password               =    bcrypt($password);
                    }else{
                        $save_instructor->password               =    '';
                    }
                    $save_instructor->password_created_by        =    '1';
                    $save_instructor->secondary_phone            =    $secondary_phone;
                    $save_instructor->whatsapp_no                =    $whatsapp_number;
                    $save_instructor->house_no                   =    $houseunit_number;
                    $save_instructor->primary_cellphone          =    $primary_cell_phone;
                    $save_instructor->primary_address            =    $address;
                    $save_instructor->country_id                 =    $country_id;
                    $save_instructor->state_id                   =    $state_id;
                    $save_instructor->city_id                    =    $city_id;
                    $save_instructor->postal_code_id             =    $postal_code_id;
                    $save_instructor->created_by                 =    Auth::user()->id;
                    $save_instructor->save();

                    //Isntr Address Save
                    $save_address                                =    new TeacherAddress();
                    $save_address->primary_address               =    $address;
                    $save_address->teacher_id                    =    $save_instructor->id;
                    $save_address->house_no                      =    $houseunit_number;
                    $save_address->primary_cellphone             =    $primary_cell_phone;
                    $save_address->country_id                    =    $country_id;
                    $save_address->state_id                      =    $state_id;
                    $save_address->city_id                       =    $city_id;
                    $save_address->postal_code_id                =    $postal_code_id;
                    $save_address->created_by                    =    Auth::user()->id;
                    $save_address->save();
                    
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
