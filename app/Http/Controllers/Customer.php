<?php

namespace App\Http\Controllers;

use App\City;
use App\ContactEcontactDetail;
use App\ContactMainDetails;
use App\Country;
use App\Customer as Cust;
use App\Gender;
use App\Http\Controllers\Config;
use App\Http\Controllers\Core\AccessRightsAuth;
use App\PostalCode;
use App\State;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use URL;

class Customer extends AccessRightsAuth
{
    public $controllerName = "Customer";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Client Form Functions
    
    public function getclient()
    {
        return view("client.client");
    }


    // End- Client Form Functions 




    public function index()
    {
        return view('customer.customer', [
            'customers' => Cust::selectRaw('id, company_name')->get()   
        ]);
    }

    ///Get All Countries
    public function get_all_countries(){
        $countries = Country::all();
        return $countries;
    }
    /// Get Postal Code Against City
    public function get_postal_code_against_cities($id){
        $postal_codes    =   PostalCode::WHERE('postal_codes.city_id', $id)->get();
                            return response()->JSON([
                                'msg'           =>  'success',
                                'postalcodes'   =>  $postal_codes
                            ]);
    }
    ///Get Contact Types
    public function get_all_contact_types(){
        $contact_types  =   DB::table('contact_types')->get();
        return $contact_types;
    }
    ///Get Genders
    public function get_all_genders(){
        $genders = DB::table('genders')->get();
        return $genders;
    }
    //Ajax Call from list-customers.js

    public function CustomersList(Request $request)
    {
        $customer = DB::table('agencies_list as cust')->selectRaw('id,business_type, email as agency_email, business_phone as agency_business_phone,IFNULL((SELECT name FROM countries WHERE id=cust.country_id), "NA") as country, IFNULL((SELECT name FROM cities WHERE id=cust.city_id), "NA") as city, city_id, company_name, (Select first_name from contact_main_details where agency_id = cust.id order by id desc limit 1) as poc_name')->get();
            echo json_encode(array('customer' => $customer
        ));
        
    }

    public function GetSearchedCustomersList($str)
    {
        echo json_encode(DB::table('agencies_list as cust')->selectRaw('id, email as agency_email, business_phone as agency_business_phone,IFNULL((SELECT name FROM countries WHERE id=cust.country_id), "NA") as country, IFNULL((SELECT name FROM cities WHERE id=cust.city_id), "NA") as city, city_id, company_name, (Select first_name from contact_main_details where agency_id = cust.id order by id desc limit 1) as poc_name')->whereRaw('company_name like "' . '%' . $str . '%' . '"')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate_agency=$request->validate([
            'business_type'             =>  'required',
            'company_name'              =>  'required',
            'company_contact_number'    =>  'required',
            'business_phone_no'         =>  'required',
            'email'                     =>  'required',
            'website_url'               =>  'required',
            'office_no'                 =>  'required',
            'street_address'            =>  'required',
            'country_id'                =>  'required',
            'state_id'                  =>  'required',
            'city_id'                   =>  'required',
            'state_id'                  =>  'required',
            'postal_code'               =>  'required'
        ]);

        if(Cust::where('company_name', '=', $request->company_name)->first()){
                    return response()->JSON([
                        'msg'           =>  'already_exist'
                    ]);
        }else{
            $customer                           = new Cust;
            $customer->business_type            = $request->business_type;
            $customer->company_name             = $request->company_name;
            $customer->company_contact_number   = $request->company_contact_number;
            $customer->email                    = $request->email;
            $customer->business_phone           = $request->business_phone_no;
            $customer->website_url              = $request->website_url;
            $customer->office_no                = $request->office_no;
            $customer->street_address           = $request->street_address;
            $customer->country_id               = $request->country_id;
            $customer->state_id                 = $request->state_id;
            $customer->city_id                  = $request->city_id;
            $customer->postal_code              = $request->postal_code;
            $customer->created_by               = Auth::user()->id;
            if ($customer->save()) {
                DB::table('notifications_list')->insert(['code' => config('constants.options._CUSTOMER_NOTIFICATION_CODE'), 'message' => 'has been added as a customer', 'customer_id' => $customer->id, 'created_by' => Auth::user()->id]);
                return json_encode(['code' => 200, 'customer_id' => $customer->id]);
            }
        }
        return json_encode(['code' => 100]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = DB::table('agencies_list as cust')->where('id', $id)->first();
            echo json_encode(array('info' => $info)
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate_update_agency=$request->validate([
            'business_type'                 =>  'required',
            'company_name'                  =>  'required',
            'company_contact_number'        =>  'required',
            'business_phone_no'             =>  'required',
            'email'                         =>  'required',
            'website_url'                   =>  'required',
            'office_no'                     =>  'required',
            'street_address'                =>  'required',
            'country_id'                    =>  'required',
            'state_id'                      =>  'required',
            'city_id'                       =>  'required',
            'state_id'                      =>  'required',
            'postal_code'                   =>  'required'
        ]);
        
        if(Cust::where('id','!=',$id)->where('company_name',$request->company_name)->first()){
            return response()->JSON([
                'msg'           =>  'already_exist'
            ]);
        }else{
            $customer                           =   Cust::find($id);
            $customer->business_type            =   $request->business_type;
            $customer->company_name             =   $request->company_name;
            $customer->company_contact_number   =   $request->company_contact_number;
            $customer->email                    =   $request->email;
            $customer->business_phone           =   $request->business_phone_no;
            $customer->website_url              =   $request->website_url;
            $customer->office_no                =   $request->office_no;
            $customer->street_address           =   $request->street_address;
            $customer->country_id               =   $request->country_id;
            $customer->state_id                 =   $request->state_id;
            $customer->city_id                  =   $request->city_id;
            $customer->postal_code              =   $request->postal_code;
            $customer->updated_by               =   Auth::user()->id;

            if ($customer->save()) {
                DB::table('notifications_list')->insert(['code' => config('constants.options._CUSTOMER_NOTIFICATION_CODE'), 'message' => 'has been updated as a customer', 'customer_id' => $customer->id, 'created_by' => Auth::user()->id]);
                return json_encode(['code' => 200]);
            }
        }
        return json_encode(['code' => 100]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Download Sample Excel Sheet
    public function download_sample_agency()
    {
        return redirect('/sample_agency.xlsx');
    }
    public function download_sample_contact()
    {
        return redirect('/sample_contact.xlsx');
    }

    //Save Agency in Bluk from excel
    public function upload_agency_bulk(Request $request)
    {   
        $agency_file            =   $request->file('file');
        if ($request->hasFile('file')) {
            $extension          =   File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                $spreadsheet    =   IOFactory::load($agency_file->getRealPath());
                $sheet          =   $spreadsheet->getActiveSheet();
                $row_limit      =   $sheet->getHighestDataRow();
                $column_limit   =   $sheet->getHighestDataColumn();
                $row_range      =   range( 2, $row_limit );
                $excel_val      =   array();
                if ($row_limit > 1) {
                    $duplicate_data  = [];
                    $count      =   0;
                    foreach ($row_range as $excel_val) {
                        $data_business_type             =   $sheet->getCell( 'a' . $excel_val )->getValue();
                        $data_company_name              =   $sheet->getCell( 'b' . $excel_val )->getValue();
                        $data_company_contact_number    =   $sheet->getCell( 'c' . $excel_val )->getValue();
                        $data_business_phone            =   $sheet->getCell( 'd' . $excel_val )->getValue();
                        $data_email                     =   $sheet->getCell( 'e' . $excel_val )->getValue();
                        $data_website_url               =   $sheet->getCell( 'f' . $excel_val )->getValue();
                        $data_office_no                 =   $sheet->getCell( 'g' . $excel_val )->getValue();
                        $data_street_address            =   $sheet->getCell( 'h' . $excel_val )->getValue();
                        $data_country                   =   $sheet->getCell( 'i' . $excel_val )->getValue();
                        $data_state                     =   $sheet->getCell( 'j' . $excel_val )->getValue();
                        $data_city                      =   $sheet->getCell( 'k' . $excel_val )->getValue();
                        $data_postal_code               =   $sheet->getCell( 'l' . $excel_val )->getValue();
                        $count++;
                        if ($duplicate=DB::table('agencies_list')->WHERE('company_name', $data_company_name)->first()) {
                            $reason_type            =   'Duplicate';
                            if($data_business_type == 1){
                                $business_type      =   'Real Estate Agency';
                            }elseif($data_business_type == 2){
                                $business_type      =   'Mortgage Broker';
                            }elseif($data_business_type == 3){
                                $business_type      =   'Lender';
                            }else{
                                $business_type      =   'Bank';
                            }
                            $duplicate_data[]       =   [
                                'count'             =>  $count,
                                'business_type'     =>  $business_type,
                                'company_name'      =>  $data_company_name,
                                'reason'            =>  $reason_type
                            ];
                            $add_data[]             =   false;
                            // return response()->JSON([
                            //     'duplicate_data'    => $duplicate_data
                            // ]);
                        } else if($data_business_type <= 4){
                                ///Country name Check if not exists add new country
                                $countries = Country::WHERE('name',$data_country)->first();
                                    if($countries){
                                        $country_id                 =   $countries->id;
                                    }else{
                                        $new_country                =   new Country;
                                        $new_country->name          =   $data_country;
                                        $new_country->created_by    =   Auth::user()->id;
                                        if ($new_country->save()) {
                                            $country_id             =   $new_country->id;
                                        } else {
                                            return response()->JSON([
                                                'msg'   =>  'Error Country Added'
                                            ]);
                                        }
                                    }
                                ///State name Check if not exists add new State
                                $states = State::WHERE('name',$data_state)->first();
                                if($states){   
                                    $state_id                   =   $states->id;
                                }else{
                                    $new_state                  =   new State();
                                    $new_state->name            =   $data_state;
                                    $new_state->country_id      =   $country_id;
                                    $new_state->created_by      =   Auth::user()->id;
                                    if ($new_state->save()) {
                                        $state_id               =   $new_state->id;
                                    } else {
                                        return response()->JSON([
                                            'msg'   =>  'Error State Added'
                                        ]);
                                    }
                                }
                                ///City name Check if not exists add new City
                                $cities = City::WHERE('name',$data_city)->first();
                                if($states){
                                    $city_id                   =   $cities->id;
                                }else{
                                    $new_city                  =   new City();
                                    $new_city->name            =   $data_city;
                                    $new_city->state_id        =   $state_id;
                                    $new_city->country_id      =   $country_id;
                                    $new_city->created_by      =   Auth::user()->id;
                                    if ($new_city->save()) {
                                        $city_id               =   $new_city->id;
                                    } else {
                                        return response()->JSON([
                                            'msg'   =>  'Error City Added'
                                        ]);
                                    }
                                }
                                ///PostalCode Check if not exists add new PostalCode
                                $postal_codes = PostalCode::WHERE('postal_code',$data_postal_code)->first();
                                if($postal_codes){
                                    $postal_code                      =   $postal_codes->postal_code;
                                }else{
                                    $new_postal_code                  =   new PostalCode();
                                    $new_postal_code->postal_code     =   $data_postal_code;
                                    $new_postal_code->city_id         =   $city_id;
                                    $new_postal_code->state_id        =   $state_id;
                                    $new_postal_code->country_id      =   $country_id;
                                    $new_postal_code->created_by      =   Auth::user()->id;
                                    if ($new_postal_code->save()) {
                                        $postal_code                  =   $new_postal_code->postal_code;
                                    } else {
                                        return response()->JSON([
                                            'msg'   =>  'Error City Added'
                                        ]);
                                    }
                                }
                                $customer = new Cust;
                                $customer->business_type            =   $data_business_type;
                                $customer->company_name             =   $data_company_name;
                                $customer->company_contact_number   =   $data_company_contact_number;
                                $customer->email                    =   $data_email;
                                $customer->business_phone           =   $data_business_phone;
                                $customer->website_url              =   $data_website_url;
                                $customer->office_no                =   $data_office_no;
                                $customer->street_address           =   $data_street_address;
                                $customer->country_id               =   $country_id;
                                $customer->state_id                 =   $state_id;
                                $customer->city_id                  =   $city_id;
                                $customer->postal_code              =   $postal_code;
                                $customer->created_by               =   Auth::user()->id;
                                if ($customer->save()) {
                                    $add_data[] = true;
                                } else {
                                    $add_data[] = false;
                                }
                            } else {
                                $reason_type_not_found  =   'Business Type Not Found';
                                $duplicate_data[]       =   [
                                    'count'             =>  $count,
                                    'business_type'     =>  $data_business_type,
                                    'company_name'      =>  $data_company_name,
                                    'reason'            =>  $reason_type_not_found
                                ];
                                $add_data[]             =   false;
                            }
                    }
                    if (in_array(true, $add_data)) {
                        return response()->JSON([
                            'status'            =>  'success',
                            'duplicate_data'    =>  $duplicate_data
                        ]);
                    } else {
                        return response()->JSON([
                            'status'            =>  'failed',
                            'duplicate_data'    =>  $duplicate_data
                        ]);
                    }
                }
            } else {
                return response()->JSON([
                    'status'            =>  'success',
                    'duplicate_data'    =>  ''
                ]);
            }
        }
    }
    // Save Contacts In Bulk From Excel
    public function upload_contacts_bulk(Request $request)
    {   
        $contact_file           =   $request->file('file');
        if ($request->hasFile('file')) {
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                $spreadsheet    =   IOFactory::load($contact_file->getRealPath());
                $sheet          =   $spreadsheet->getActiveSheet();
                $row_limit      =   $sheet->getHighestDataRow();
                $column_limit   =   $sheet->getHighestDataColumn();
                $row_range      =   range( 2, $row_limit );
                $excel_val      =   array();
                if ($row_limit  >   1) {
                    $duplicate_data  = [];
                    $count      =   0;
                    foreach ($row_range as $excel_val) {
                        $data_contact_type          =   $sheet->getCell( 'a' . $excel_val )->getValue();
                        $data_first_name            =   $sheet->getCell( 'b' . $excel_val )->getValue();
                        $data_middle_name           =   $sheet->getCell( 'c' . $excel_val )->getValue();
                        $data_last_name             =   $sheet->getCell( 'd' . $excel_val )->getValue();
                        $data_dob                   =   Date::excelToDateTimeObject($sheet->getCell( 'e' . $excel_val )->getValue());
                        $data_gender                =   $sheet->getCell( 'f' . $excel_val )->getValue();
                        $data_employment_status     =   $sheet->getCell( 'g' . $excel_val )->getValue();
                        $data_agency                =   $sheet->getCell( 'h' . $excel_val )->getValue();
                        $data_contact_no            =   $sheet->getCell( 'i' . $excel_val )->getValue();
                        $data_official_email        =   $sheet->getCell( 'j' . $excel_val )->getValue();
                        $data_personal_email        =   $sheet->getCell( 'k' . $excel_val )->getValue();
                        $data_office_no             =   $sheet->getCell( 'l' . $excel_val )->getValue();
                        $data_address               =   $sheet->getCell( 'm' . $excel_val )->getValue();
                        $data_country               =   $sheet->getCell( 'n' . $excel_val )->getValue();
                        $data_state                 =   $sheet->getCell( 'o' . $excel_val )->getValue();
                        $data_city                  =   $sheet->getCell( 'p' . $excel_val )->getValue();
                        $data_postal_code           =   $sheet->getCell( 'q' . $excel_val )->getValue();
                        $data_contact_no_type       =   $sheet->getCell( 'r' . $excel_val )->getValue();
                        $data_contact_number        =   $sheet->getCell( 's' . $excel_val )->getValue();
                        // dd($data_dob);
                        $count++;
                        if ($duplicate=DB::table('contact_main_details')->WHERE('contact_cellphone', $data_contact_no)->first()) {
                            $contact_main_details_id=   $duplicate->id;
                            $econtact_details       =   ContactEcontactDetail::WHERE('contact_id',$contact_main_details_id)
                                                                            ->WHERE('contact_value',$data_contact_number)
                                                                            ->WHERE('econtact_type',$data_contact_no_type)
                                                                            ->first();
                            if($econtact_details){
                                $econtact_id                 =   $econtact_details->id;
                            }else{
                                $new_econtact                =   new ContactEcontactDetail();
                                $new_econtact->contact_id    =   $contact_main_details_id;
                                $new_econtact->econtact_type =   $data_contact_no_type;
                                $new_econtact->contact_value =   $data_contact_number;
                                $new_econtact->created_by    =   Auth::user()->id;
                                $new_econtact->save();
                            }
                            if($data_employment_status == 2){
                                $employee_status    =   'Employeed';
                            }else{
                                $employee_status    =   'Freelance';
                            }
                            $reason_type            =   'Duplicate';
                            $duplicate_data[]       =   [
                                'count'             =>  $count,
                                'employee_status'   =>  $employee_status,
                                'name'              =>  $data_first_name.' '.$data_middle_name.' '.$data_last_name,
                                'contact_no'        =>  $data_contact_no,
                                'reason'            =>  $reason_type
                            ];
                            $add_data[]             =   false;
                            // return response()->JSON([
                            //     'duplicate_data'    => $duplicate_data
                            // ]);
                        } else if($data_employment_status <= 2){

                            ///Contact Type Check if not exists add new contact_type
                            $contact_types = DB::table('contact_types')->WHERE('contact_name', $data_contact_type)->first();
                            if($contact_types){
                                $contact_type_id        =   $contact_types->id;
                            }else{
                                $new_contact_type       =   DB::table('contact_types')->insert([
                                    'contact_name'      =>  $data_contact_type,
                                    'created_by'        =>  Auth::user()->id,
                                    'created_at'        =>  date('Y-m-d H:i:s')
                                ]);
                                if ($new_contact_type) {
                                    $co_type_id         =  DB::getPdo()->lastInsertId();
                                    $contact_type_id    =   $co_type_id;
                                } else {
                                    return response()->JSON([
                                        'msg'           =>  'Error Contact Type Added'
                                    ]);
                                }
                            }
                            ///Gender Check if not exists add new Gender
                            $genders = Gender::WHERE('gender_name', $data_gender)->first();
                            if($genders){
                                $genders_id                =   $genders->id;
                            }else{
                                $new_gender                =   new Gender;
                                $new_gender->gender_name   =   $data_gender;
                                $new_gender->created_by    =   Auth::user()->id;
                                if ($new_gender->save()) {
                                    $gender_id             =  DB::getPdo()->lastInsertId();
                                    $genders_id            =   $gender_id;
                                } else {
                                    return response()->JSON([
                                        'msg'   =>  'Error Gender Added'
                                    ]);
                                }
                            }
                            ///Agency Check if not exists add new Agency
                            $agency_name = DB::table('agencies_list')->WHERE('company_name', $data_agency)->first();
                            if($agency_name){
                                $agency_id                     =   $agency_name->id;
                            }else{
                                if($data_employment_status != '1' && $data_agency != ''){
                                    $insert_agency = DB::table('agencies_list')->insert([
                                        'company_name'         => $data_agency,
                                        'created_at'           => date('Y-m-d H:i:s')
                                    ]);
                                    if ($insert_agency) {
                                        $ag_id                 =  DB::getPdo()->lastInsertId();
                                        $agency_id             =  $ag_id;
                                    } else {
                                        return response()->JSON([
                                            'msg'   =>  'Error Agency Added'
                                        ]);
                                    }
                                }else{
                                    $agency_id = '0';
                                }
                            }
                            ///Country name Check if not exists add new country
                            $countries = Country::WHERE('name',$data_country)->first();
                            if($countries){
                                $country_id                 =   $countries->id;
                            }else{
                                $new_country                =   new Country;
                                $new_country->name          =   $data_country;
                                $new_country->created_by    =   Auth::user()->id;
                                if ($new_country->save()) {
                                    $country_id             =   $new_country->id;
                                } else {
                                    return response()->JSON([
                                        'msg'   =>  'Error Country Added'
                                    ]);
                                }
                            }
                            ///State name Check if not exists add new State
                            $states = State::WHERE('name',$data_state)->first();
                            if($states){   
                                $state_id                   =   $states->id;
                            }else{
                                $new_state                  =   new State();
                                $new_state->name            =   $data_state;
                                $new_state->country_id      =   $country_id;
                                $new_state->created_by      =   Auth::user()->id;
                                if ($new_state->save()) {
                                    $state_id               =   $new_state->id;
                                } else {
                                    return response()->JSON([
                                        'msg'   =>  'Error State Added'
                                    ]);
                                }
                            }
                            ///City name Check if not exists add new City
                            $cities = City::WHERE('name',$data_city)->first();
                            if($states){
                                $city_id                   =   $cities->id;
                            }else{
                                $new_city                  =   new City();
                                $new_city->name            =   $data_city;
                                $new_city->state_id        =   $state_id;
                                $new_city->country_id      =   $country_id;
                                $new_city->created_by      =   Auth::user()->id;
                                if ($new_city->save()) {
                                    $city_id               =   $new_city->id;
                                } else {
                                    return response()->JSON([
                                        'msg'   =>  'Error City Added'
                                    ]);
                                }
                            }
                            ///PostalCode Check if not exists add new PostalCode
                            $postal_codes = PostalCode::WHERE('postal_code',$data_postal_code)->first();
                            if($postal_codes){
                                $postal_code                      =   $postal_codes->postal_code;
                            }else{
                                $new_postal_code                  =   new PostalCode();
                                $new_postal_code->postal_code     =   $data_postal_code;
                                $new_postal_code->city_id         =   $city_id;
                                $new_postal_code->state_id        =   $state_id;
                                $new_postal_code->country_id      =   $country_id;
                                $new_postal_code->created_by      =   Auth::user()->id;
                                if ($new_postal_code->save()) {
                                    $postal_code                  =   $new_postal_code->postal_code;
                                } else {
                                    return response()->JSON([
                                        'msg'   =>  'Error Postal Code Added'
                                    ]);
                                }
                            }
                            $contact = new ContactMainDetails();
                            $contact->contact_type             =   $contact_type_id;
                            $contact->first_name               =   $data_first_name;
                            $contact->middle_name              =   $data_middle_name;
                            $contact->last_name                =   $data_last_name;
                            $contact->dob                      =   $data_dob;
                            $contact->gender_id                =   $genders_id;
                            $contact->employment_status        =   $data_employment_status;
                            $contact->agency_id                =   $agency_id;
                            $contact->contact_cellphone        =   $data_contact_no;
                            $contact->official_email           =   $data_official_email;
                            $contact->email                    =   $data_personal_email;
                            $contact->office_no                =   $data_office_no;
                            $contact->business_address         =   $data_address;
                            $contact->country_id               =   $country_id;
                            $contact->state_id                 =   $state_id;
                            $contact->city_id                  =   $city_id;
                            $contact->postal_code              =   $postal_code;
                            $contact->created_by               =   Auth::user()->id;
                            if ($contact->save()) {
                                $add_data[] = true;
                            } else {
                                $add_data[] = false;
                            }
                        } else {
                                $reason_status_not_found    =   'Employment Status Not Found';
                                    $duplicate_data[]       =   [
                                        'count'             =>  $count,
                                        'employee_status'   =>  $data_employment_status,
                                        'name'              =>  $data_first_name.' '.$data_middle_name.' '.$data_last_name,
                                        'contact_no'        =>  $data_contact_no,
                                        'reason'            =>  $reason_status_not_found
                                    ];
                                    $add_data[]             =   false;
                            }
                    }
                    if (in_array(true, $add_data)) {
                        return response()->JSON([
                            'status'            =>  'success',
                            'duplicate_data'    =>  $duplicate_data
                        ]);
                    } else {
                        return response()->JSON([
                            'status'            =>  'failed',
                            'duplicate_data'    =>  $duplicate_data
                        ]);
                    }
                }
            } else {
                return response()->JSON([
                    'status'            =>  'success',
                    'duplicate_data'    =>  ''
                ]);
            }
        }
    }

    //Save Sample
    //Save Price Quotation

    public function fetchCustomersPOC()
    {
        $poc    =   DB::table('contact_main_details')
                        ->selectRaw('
                                    id,
                                    employment_status, 
                                    country_id,
                                    state_id,
                                    IFNULL((SELECT name from cities WHERE id=contact_main_details.city_id LIMIT 1), "NA") as city, 
                                    city_id,
                                    postal_code, 
                                    IFNULL(email, "NA") as email, first_name,IFNULL(middle_name, "") as middle_name, 
                                    IFNULL(last_name, "") as last_name, 
                                    (Select company_name from agencies_list where id = contact_main_details.agency_id LIMIT 1) as company_name, 
                                    IFNULL(contact_cellphone, "NA") as contact_cellphone
                                    ')->get();
        echo json_encode(array('base_url' => URL::to('/') . '/storage/company' . '/', 'poc' =>$poc));
    }

    public function get_selected_POC($id)
    {
        echo json_encode(array('base_url' => URL::to('/') . '/storage/company' . '/', 'poc' => DB::table('contact_main_details')->where('id', $id)->first(), 'poc_econtact'=> DB::table('contact_econtact_details')->where('contact_id', $id)->get()));
    }

    public function save_company_poc(Request $request)
    {
        if ($request->operation == 'add') {
            $card_front = null;
            $card_back = null;
            $profile = null;


            if ($request->hasFile('card_front')) {
                $completeFileName = $request->file('card_front')->getClientOriginalName();
                $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                $extension = $request->file('card_front')->getClientOriginalExtension();
                $compPic = str_replace(' ', '_', $fileNameOnly) . '-' . rand() . '_' . time() . '.' . $extension;
                $path = $request->file('card_front')->storeAs('public/company', $compPic);
                $card_front = $compPic;
            }

            if ($request->hasFile('card_back')) {
                $completeFileName = $request->file('card_back')->getClientOriginalName();
                $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                $extension = $request->file('card_back')->getClientOriginalExtension();
                $compPic = str_replace(' ', '_', $fileNameOnly) . '-' . rand() . '_' . time() . '.' . $extension;
                $path = $request->file('card_back')->storeAs('public/company', $compPic);
                $card_back = $compPic;
            }

            if ($request->hasFile('profile_pic')) {
                $completeFileName = $request->file('profile_pic')->getClientOriginalName();
                $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                $extension = $request->file('profile_pic')->getClientOriginalExtension();
                $compPic = str_replace(' ', '_', $fileNameOnly) . '-' . rand() . '_' . time() . '.' . $extension;
                $path = $request->file('profile_pic')->storeAs('public/company', $compPic);
                $profile = $compPic;
            }

            $insert = DB::table('contact_main_details')->insert([
                'contact_type'          =>  $request->contact_type,
                'first_name'            =>  $request->first_name,
                'middle_name'           =>  $request->middle_name,
                'last_name'             =>  $request->last_name,
                'dob'                   =>  $request->dob,
                'gender_id'             =>  $request->gender_id,
                'employment_status'     =>  $request->employment_status,
                'agency_id'             =>  $request->customer_id,
                'email'                 =>  $request->personal_email,
                'official_email'        =>  $request->official_email,
                'contact_cellphone'     =>  $request->contact_cellphone,
                'office_no'             =>  $request->office_no,
                'business_address'      =>  $request->business_address,
                'country_id'            =>  $request->country_id,
                'state_id'              =>  $request->state_id,
                'city_id'               =>  $request->city_id,
                'postal_code'           =>  $request->postal_code,  
                // 'card_front' => $card_front,
                // 'card_back' => $card_back,
                // 'customer_id' => $request->customer_id,
                // 'profile_image' => $profile,
                'created_by' => Auth::user()->id,
            ]);
            if ($insert) {
                $id = DB::getPdo()->lastInsertId();
                $phone_new = null;
                $cell_phone = null;
                $landline = null;
                $office = null;
                $econtact_types= null;
                foreach ($request->multiple_phone_nums as $key => $data) {
                    if ($data['type'] == 'Cell Phone') {
                        if ($cell_phone != '') {
                            $phone_new = $cell_phone . ',' . $data['number'];
                            $econtact_types = 'Cell Phone';
                        } else {
                            $phone_new = $data['number'];
                            $econtact_types = 'Cell Phone';
                        }
                    } else if ($data['type'] == 'Landline') {
                        if ($landline != '') {
                            $phone_new = $landline . ',' . $data['number'];
                            $econtact_types = 'Landline';
                        } else {
                            $phone_new = $data['number'];
                            $econtact_types = 'Landline';
                        }
                    } else if ($data['type'] == 'Office') {
                        if ($office != '') {
                            $phone_new = $office . ',' . $data['number'];
                            $econtact_types = 'Office';
                        } else {
                            $phone_new = $data['number'];
                            $econtact_types = 'Office';
                        }
                    }
                    //Query for insert contact no in contact_econtact_details table
                    $query_for_econtact = DB::table('contact_econtact_details')->insert([
                        'contact_id'    => $id,
                        'econtact_type' => $econtact_types,
                        'contact_value' => $phone_new,
                        'created_by'    => Auth::user()->id
                    ]);
                }
                echo json_encode('success');
            } else {
                echo json_encode('failed');
            }
        } else {
            $phone_new = null;
            $cell_phone = null;
            $landline = null;
            $office = null;
            $econtact_types= null;
            foreach ($request->multiple_phone_nums as $key => $data) { 
                if ($data['type'] == 'Cell Phone') {
                    if ($cell_phone != '') {
                        $phone_new = $cell_phone . ',' . $data['number'];
                        $econtact_types = 'Cell Phone';
                    } else {
                        $phone_new = $data['number'];
                        $econtact_types = 'Cell Phone';
                    }
                } else if ($data['type'] == 'Landline') {
                    if ($landline != '') {
                        $phone_new = $landline . ',' . $data['number'];
                        $econtact_types = 'Landline';
                    } else {
                        $phone_new = $data['number'];
                        $econtact_types = 'Landline';
                    }
                } else if ($data['type'] == 'Office') {
                    if ($office != '') {
                        $phone_new = $office . ',' . $data['number'];
                        $econtact_types = 'Office';
                    } else {
                        $phone_new = $data['number'];
                        $econtact_types = 'Office';
                    }
                }
                if($data['phone_id']    !='0'){
                    $econtact_id        = $data['phone_id'];
                    $update_econtact    = DB::table('contact_econtact_details')->where('id', $econtact_id)->update([
                        // 'contact_id'    => $id,
                        'econtact_type' => $econtact_types,
                        'contact_value' => $phone_new,
                        'updated_by'    => Auth::user()->id
                    ]);
                }else{ 
                    
                    $query_for_econtact = DB::table('contact_econtact_details')->insert([
                        'contact_id'    => $request->poc_update_id,
                        'econtact_type' => $econtact_types,
                        'contact_value' => $phone_new,
                        'created_by'    => Auth::user()->id
                    ]);
                }
            }

            try {
                $card_front = null;
                $card_back = null;
                $profile = null;

                if ($request->hasFile('card_front')) {
                    $completeFileName = $request->file('card_front')->getClientOriginalName();
                    $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                    $extension = $request->file('card_front')->getClientOriginalExtension();
                    $compPic = str_replace(' ', '_', $fileNameOnly) . '-' . rand() . '_' . time() . '.' . $extension;
                    $path = $request->file('card_front')->storeAs('public/company', $compPic);
                    $card_front = $compPic;
                    if (Storage::exists('public/company/' . $request->ext_card_front)) {
                        Storage::delete('public/company/' . $request->ext_card_front);
                    }
                } else {
                    $card_front = $request->ext_card_front;
                }

                if ($request->hasFile('card_back')) {
                    $completeFileName = $request->file('card_back')->getClientOriginalName();
                    $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                    $extension = $request->file('card_back')->getClientOriginalExtension();
                    $compPic = str_replace(' ', '_', $fileNameOnly) . '-' . rand() . '_' . time() . '.' . $extension;
                    $path = $request->file('card_back')->storeAs('public/company', $compPic);
                    $card_back = $compPic;
                    if (Storage::exists('public/company/' . $request->ext_card_back)) {
                        Storage::delete('public/company/' . $request->ext_card_back);
                    }
                } else {
                    $card_back = $request->ext_card_back;
                }

                if ($request->hasFile('profile_pic')) {
                    $completeFileName = $request->file('profile_pic')->getClientOriginalName();
                    $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                    $extension = $request->file('profile_pic')->getClientOriginalExtension();
                    $compPic = str_replace(' ', '_', $fileNameOnly) . '-' . rand() . '_' . time() . '.' . $extension;
                    $path = $request->file('profile_pic')->storeAs('public/company', $compPic);
                    $profile = $compPic;
                    if (Storage::exists('public/company/' . $request->ext_profile)) {
                        Storage::delete('public/company/' . $request->ext_profile);
                    }
                } else {
                    $profile = $request->ext_profile;
                }

                $update = DB::table('contact_main_details')->where('id', $request->poc_update_id)->update([
                    'contact_type'          =>  $request->contact_type,
                    'first_name'            =>  $request->first_name,
                    'middle_name'           =>  $request->middle_name,
                    'last_name'             =>  $request->last_name,
                    'dob'                   =>  $request->dob,
                    'gender_id'             =>  $request->gender_id,
                    'employment_status'     =>  $request->employment_status,
                    'agency_id'             =>  $request->customer_id,
                    'email'                 =>  $request->personal_email,
                    'official_email'        =>  $request->official_email,
                    'contact_cellphone'     =>  $request->contact_cellphone,
                    'office_no'             =>  $request->office_no,
                    'business_address'      =>  $request->business_address,
                    'country_id'            =>  $request->country_id,
                    'state_id'              =>  $request->state_id,
                    'city_id'               =>  $request->city_id,
                    'postal_code'           =>  $request->postal_code,
                    'updated_by'            =>  Auth::user()->id,
                ]);
                echo json_encode("success");
            } catch (\Illuminate\Database\QueryException $ex) {
                echo json_encode('failed');
            }
        }
    }
    /*
    to take mime type as a parameter and return the equivalent extension
     */

    public function randomKey($length)
    {
        $pool = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $key = '';

        for ($i = 0; $i < $length; $i++) {
            $key .= $pool[mt_rand(0, count($pool) - 1)];
        }
        return $key;
    }
    public function delete_econtact_number(Request $request){
        $econtact_details= ContactEcontactDetail::find($request->id)->delete($request->id);
                    return response()->JSON([
                        'msg'               =>  "success",
                        'econtact_details'  =>  $econtact_details
                    ]);
    }

    /////////////////////
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    /// //////////////////




    public function agencyList()
    {
        return view('customer.agency-list', [
            'customers' => Cust::selectRaw('id, company_name')->get(),
            'types' => DB::table('customer_types')->get(), 
        ]);
    }
    public function contactList()
    {
        return view('customer.contact-list', [
            'customers' => Cust::selectRaw('id, company_name')->get(), 
            'types' => DB::table('customer_types')->get()
        ]);
    }




    public function saveAcquisitionSource(Request $request)
    {
        if ($request->operation == 'add') {
            if (DB::table('acquisition_source')->whereRaw('type = "' . $request->type . '" && name = "' . $request->name . '" && year = "' . $request->year . '" && cost = "' . $request->cost . '"')->first()) {
                echo json_encode('already_exist');
            } else {
                $insert = DB::table('acquisition_source')->insert([
                    'type' => $request->type,
                    'name' => $request->name,
                    'year' => $request->year,
                    'cost' => $request->cost,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => Auth::user()->id,
                ]);
                if ($insert) {
                    echo json_encode('success');
                } else {
                    echo json_encode('failed');
                }
            }
        } else {
            if (DB::table('acquisition_source')->whereRaw('type = "' . $request->type . '" && name = "' . $request->name . '" && year = "' . $request->year . '" && cost = "' . $request->cost . '" && id NOT IN (' . $request->hidden_AcquisitionSource . ')')->first()) {
                echo json_encode('already_exist');
            } else {
                try {
                    $update = DB::table('acquisition_source')->where('id', $request->hidden_AcquisitionSource)->update([
                        'type' => $request->type,
                        'name' => $request->name,
                        'year' => $request->year,
                        'cost' => $request->cost,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => Auth::user()->id,
                    ]);
                    echo json_encode('success');
                } catch (\Illuminate\Database\QueryException $ex) {
                    echo json_encode('failed');
                }
            }
        }
    }
    public function AcquisitionSource()
    {
        return view('customer.acquistion_source');
    }
    public function GetAcquisitionTypeList()
    {
        echo json_encode(DB::table('acquisition_source')->get());
    }
    public function get_selected_AcquisitionSource($id)
    {
        echo json_encode(DB::table('acquisition_source')->where('id', $id)->first());
    }

    public function deleteAcquisition($id)
    {
        $delete = DB::table('acquisition_source')->where('id', $id)->delete();
        if ($delete) {
            echo json_encode('success');
        } else {
            echo json_encode('failed');
        }
    }
}