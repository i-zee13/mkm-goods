<?php

namespace App\Http\Controllers;

use App\City;
use App\Client;
use App\ClientDocument;
use App\ClientEmployment;
use App\ClientIntakeForm;
use App\ClientProperty;
use App\ContactMainDetails;
use App\Country;
use App\Customer;
use App\DocumentVerification;
use App\Gender;
use App\IntakePoanWills;
use App\PostalCode;
use App\Relative;
use App\ResidenceStatus;
use App\State;
use DB;
use Illuminate\Http\Request;
class IntakeFormFrontendController extends Controller
{
    public function __construct()
    {
        error_reporting(0);
    }
    public function index()
    {

    }
    public function show(Request $request, $key)
    {
        $client_intake_form         =  ClientIntakeForm::where('unique_key',$key)->first();
        $client_id                  =  $client_intake_form->client_id;
        $intake_form_type           =  $client_intake_form->intake_form_type;
        $intake_form_status         =  $client_intake_form->status;
        $intake_form_id             =  $client_intake_form->id;
        $intake_form_idd            =  $client_intake_form->intake_form_id;
        $guardian_status            =  $client_intake_form->have_guardian;
        $guradian_details           =  ClientIntakeForm::where('client_intake_form.id',$intake_form_id)
                                       ->where('have_guardian', 1)
                                       ->Leftjoin('students', 'client_intake_form.guardian_id', '=', 'students.id')
                                       ->first();
        $guardian_postal_code       =  PostalCode::WHERE('id', $guradian_details->postal_code_id)->first('postal_code');
        $clients                    =  Client::find($client_id);
        $client_postal_code         =  PostalCode::WHERE('id', $clients->postal_code_id)->first('postal_code');
        $client_property            =  DB::table('client_property_info')->where('intake_forms_id',$intake_form_idd)->first();
        $realtor_info               =  ContactMainDetails::where('contact_main_details.id',$client_property->realtor_id)
                                       ->leftjoin('agencies_list' , 'contact_main_details.agency_id', '=' , 'agencies_list.id')
                                       ->select('contact_main_details.*','agencies_list.company_name as agency_name')
                                       ->first();
        $mortgage_info              =  ContactMainDetails::where('contact_main_details.id',$client_property->mortgage_agent_id)
                                       ->leftjoin('agencies_list' , 'contact_main_details.agency_id', '=' , 'agencies_list.id')
                                       ->select('contact_main_details.*','agencies_list.company_name as agency_name')
                                       ->first();      
        // dd($realtor_info);
        $client_documents           =  ClientDocument::where('student_id',$client_id)->where('client_intake_form_id',$intake_form_id)->get();
        $client_employment          =  ClientEmployment::where('student_id',$client_id)->first();
        $genders                    =  Gender::all();
        $residence_status           =  ResidenceStatus::all();
        $documents                  =  DocumentVerification::all();
        $countries                  =  Country::where('default_status', '1')->first();
        if(in_array($intake_form_status,[1,3])){
            return view('intake-form-frontend.form',compact(['client_intake_form','intake_form_id','intake_form_idd','guardian_postal_code','client_postal_code','countries','guradian_details','client_property','realtor_info','mortgage_info','clients','client_employment','client_documents','genders','residence_status','documents']));
        }else{
            return redirect(route('thankyou'));
        }
    }
    public function save_client(Request $request)
    {
        $validate = $this->validate($request, [ 
            'first_name'            =>  'required',
            'last_name'             =>  'required',
            'dob'                   =>  'required',
            'gender_id'             =>  'required',
            'email'                 =>  'required',
            'residence_status'      =>  'required',
            'primary_address'       =>  'required',
            'primary_landline'      =>  'required',
            'primary_cellphone'     =>  'required',
        ]);
        // $client                  =   new Client();
        /////////Check Document Number Can't Repeat
        if (Client::WHERE('email', $request->email)->WHERE('id', '!=', $request->client_id)->first()) {
            return response()->JSON([
                                'status'    =>      'error',
                                'msg'       =>      'already_exists',
            ]);
        }
        $current_year   =   date('Y');
        $request_year   =   date('Y',strtotime($request->dob));
        $min_dob        =   $current_year - $request_year;
        if($min_dob < 18){
            return response()->JSON([
                'status'    =>      'error',
                'msg'       =>      'dob_not_18',
            ]);
        }
        ///PostalCode Check if not exists add new PostalCode
        $postal_codes = PostalCode::WHERE('postal_code',$request->postal_code)->first();
        if($postal_codes){
            $postal_code                      =   $postal_codes->id;
        }else{
            $new_postal_code                  =   new PostalCode();
            $new_postal_code->postal_code     =   $request->postal_code;
            $new_postal_code->city_id         =   $request->city_id;
            $new_postal_code->state_id        =   $request->state_id;
            $new_postal_code->country_id      =   $request->country_id;
            $new_postal_code->created_by      =   $request->client_id;
            if ($new_postal_code->save()) {
                $postal_code                  =   $new_postal_code->id;
            } else {
                return response()->JSON([
                    'msg'   =>  'Error Postal Code Added'
                ]);
            }
        }
        $client                     =   Client::find($request->client_id);     
        $client->first_name         =   $request->first_name;
        $client->last_name          =   $request->last_name;
        $client->middle_name        =   $request->middle_name;
        $client->dob                =   $request->dob;
        $client->gender_id          =   $request->gender_id;
        $client->email              =   $request->email;
        $client->residence_status   =   $request->residence_status;
        $client->primary_address    =   $request->primary_address;
        $client->primary_landline   =   $request->primary_landline;
        $client->primary_cellphone  =   $request->primary_cellphone;
        $client->country_id         =   $request->country_id;
        $client->state_id           =   $request->state_id;
        $client->city_id            =   $request->city_id;
        $client->postal_code_id     =   $postal_code;
        $client->updated_by         =   $request->client_id;   
        $client->save();
        return response()->JSON([
                        'msg'       =>  'success',
                        'client'    =>   $client
        ]);
    }
    //Clint Employee Info
    public function save_client_employee_info(Request $request)
    {
        /////////Employement Status of Primary client update
        ///
        ///
        $update_employee_status             =       Client::WHERE('id', $request->client_id)->update([
                    'employment_status'     =>      $request->employment_status   
        ]);
        $insert_employee                    =       '';
        $update_employee_status             =       "Employee Occupation Status Update";
        if($request->employment_status == 1 OR $request->employment_status == 3){ 
            
            $validate = $this->validate($request, [ 
                'company_name'                 =>  'required',
                'company_contact_number'       =>  'required',
                'job_title'                    =>  'required',
                'office_no'                    =>  'required',
                'street_address'               =>  'required',
                'country_id2'                  =>  'required',
                'state_id2'                    =>  'required',
                'city_id2'                     =>  'required',
                'postal_code_id2'              =>  'required',
            ]);
            ///PostalCode Check if not exists add new PostalCode
            $postal_codes = PostalCode::WHERE('postal_code',$request->postal_code_id2)->first();
            if($postal_codes){
                $postal_code                      =   $postal_codes->id;
            }else{
                $new_postal_code                  =   new PostalCode();
                $new_postal_code->postal_code     =   $request->postal_code_id2;
                $new_postal_code->city_id         =   $request->city_id;
                $new_postal_code->state_id        =   $request->state_id;
                $new_postal_code->country_id      =   $request->country_id;
                $new_postal_code->created_by      =   $request->client_id;
                if ($new_postal_code->save()) {
                    $postal_code                  =   $new_postal_code->id;
                } else {
                    return response()->JSON([
                        'msg'   =>  'Error Postal Code Added'
                    ]);
                }
            }
            if($request->employment_id != ''){
                $employment                         =   ClientEmployment::find($request->employment_id);
            }else{
                $employment                         =   new ClientEmployment; 
            }
            $employment->student_id     =   $request->client_id;
            $employment->company_name               =   $request->company_name;
            $employment->company_contact_number     =   $request->company_contact_number;
            $employment->job_title                  =   $request->job_title;
            $employment->office_no                  =   $request->office_no;
            $employment->street_address             =   $request->street_address;
            $employment->country_id2                =   $request->country_id2;
            $employment->state_id2                  =   $request->state_id2;
            $employment->city_id2                   =   $request->city_id2;
            $employment->postal_code_id2            =   $postal_code;
            $employment->employment_status          =   '1';
            $employment->created_by                 =   $request->client_id;
            $employment->save();
            $insert_employee                        =   "Employment Info Added";
        }
            return response()->JSON([
                            'msg'               =>  'success',
                            'insert_employee'   =>   $insert_employee,
                            'update_employee'   =>   $update_employee_status
            ]);
    }
    ///Save Client Marital
    public function save_client_marital_info(Request $request){
         /////////Marital Status of Primary client update
            $update_marital_status      =       Client::WHERE('id', $request->client_id)->update([
            'marital_status'            =>      $request->marital_status   
        ]);
         $update_marital_status_msg      =      "Client Marital Status Update";
        $insert_marital                  =      '';
        if($request->marital_status == 1 OR $request->marital_status == 3){ 
            $validate = $this->validate($request, [ 
                'first_name'                 =>  'required',
                'last_name'                  =>  'required',
                're_gender_id'               =>  'required',
                'email'                      =>  'required',
                'home_phone_no'              =>  'required',
                'cell_phone_no'              =>  'required',
            ]);
            ///PostalCode Check if not exists add new PostalCode
        $postal_codes = PostalCode::WHERE('postal_code',$request->postal_code_marital)->first();
        if($postal_codes){
            $postal_code                      =   $postal_codes->id;
        }else{
            $new_postal_code                  =   new PostalCode();
            $new_postal_code->postal_code     =   $request->postal_code_marital;
            $new_postal_code->city_id         =   $request->city_id;
            $new_postal_code->state_id        =   $request->state_id;
            $new_postal_code->country_id      =   $request->country_id;
            $new_postal_code->created_by      =   $request->client_id;
            if ($new_postal_code->save()) {
                $postal_code                  =   $new_postal_code->id;
            } else {
                return response()->JSON([
                    'msg'   =>  'Error Postal Code Added'
                ]);
            }
        }
        if($request->sec_id != ''){
            $marital                         =    Client::find($request->sec_id); 
        }else{
            $marital                         =    new Client();
        }
            $marital->first_name             =    $request->first_name;
            $marital->last_name              =    $request->last_name;
            $marital->middle_name            =    $request->middle_name;
            $marital->gender_id              =    $request->re_gender_id;
            $marital->email                  =    $request->email;
            $marital->marital_status         =    $request->marital_status;
            $marital->primary_cellphone      =    $request->cell_phone_no;
            $marital->primary_landline       =    $request->home_phone_no;
            $marital->country_id             =    $request->country_id_marital;
            $marital->state_id               =    $request->state_id_marital;
            $marital->city_id                =    $request->city_id_marital;
            $marital->postal_code_id         =    $postal_code;
            $marital->created_by             =    $request->client_id;
            $marital->save();
            $insert_marital                  =     "Spouse Info Added";
            $new_client_id                   =      $marital->id;
            
            //Secondary Client
        if($request->client_id !='' && $request->sec_id != '' && $request->relationship_type !=''){
            $insert_relation                          =    Relative::find($request->relationship_id);
        }else{
            $insert_relation                          =    new  Relative();
        }
            $insert_relation->secondary_contact_id    =    $new_client_id;
            $insert_relation->student_id  =    $request->client_id;
            if($request->marital_status == 1){
                $relationship_type                    =     '7';
            }
            if($request->marital_status == 3){
                $relationship_type                    =     '8';
            }
            $insert_relation->relationship_type       =    $relationship_type;
            $insert_relation->created_by              =    $request->client_id;
            $insert_relation->save();

            $second_relationship_id=$request->relationship_id+1;
            //Primary Client
            if($request->client_id !='' && $request->sec_id != '' && $request->relationship_type !=''){
                $new_relation                         =    Relative::find($second_relationship_id);
            }else{
                $new_relation                         =    new  Relative(); 
            }

            $new_relation->secondary_contact_id       =    $request->client_id;
            $new_relation->student_id     =    $new_client_id;
            $new_relation->relationship_type          =    $relationship_type;
            $new_relation->created_by                 =    $request->client_id;
            $new_relation->save();
            ///Data Added in IntakePOAnWills Table
                if($request->intake_form_id !='' && $request->client_id != '' && $request->sec_id !=''){
                $new_spouse                               =    IntakePoanWills::WHERE('intake_form_id', $request->intake_form_id)
                                                               ->WHERE('client_id', $request->client_id)
                                                               ->WHERE('secondary_client_id', $request->sec_id)->first();
                    
                    if(empty($new_spouse)){
                        $new_spouse                       =    new IntakePoanWills();
                    }
                }else{
                $new_spouse                               =    new IntakePoanWills();
                }
                $new_spouse->intake_form_id               =    $request->intake_form_id;
                $new_spouse->client_id                    =    $request->client_id;
                $new_spouse->intake_form_type             =    $request->intake_form_type;
                $new_spouse->secondary_client_id          =    $new_client_id;
                $new_spouse->secondary_relationship_type  =    $relationship_type;
                $new_spouse->created_by                   =    $request->client_id;
                $new_spouse->save();
        }
            return response()->JSON([
                            'msg'               =>  'success',
                            'insert_marital'    =>   $insert_marital,
                            'update_marital'    =>   $update_marital_status_msg
            ]);
    }
    //Save Capacity
    public function save_client_capacity(Request $request){
        if($request->tenancy_type OR $request->property_status > 0){
            $validate = $this->validate($request, [ 
                'tenancy_type'               =>  'required',
                'property_status'            =>  'required'
            ]);
            $capacity                        =   DB::table('client_property_info')->WHERE('intake_forms_id', $request->intake_form_id)->update([
                'tenancy_type'               =>  $request->tenancy_type,
                'property_status'            =>  $request->property_status,
            ]);
        }
        if($request->home_buyer OR $request->spouse_owned_home >= 0){
            $validate = $this->validate($request, [ 
                'home_buyer'                 =>  'required',
                'spouse_owned_home'          =>  'required',
            ]);
            $capacity                        =   ClientIntakeForm::WHERE('id', $request->client_intake_form_id)->update([
                'first_time_buyer'           =>  $request->home_buyer,
                'spouse_owned_home'          =>  $request->spouse_owned_home,
                'updated_by'                 =>  $request->client_id
            ]);
        }
        return response()->json([
            'status'                     =>  'Success',
            'msg'                        =>  'Capacity_Added',
        ]);
    }
    //Save Guardian Info
    public function save_guardian_info(Request $request){
        if($request->guardian_status == '1'){
            $validate = $this->validate($request, [ 
                'guardian_status'       =>  'required',
                'first_name'            =>  'required',
                'last_name'             =>  'required',
                'dob'                   =>  'required',
                'relationship_type'     =>  'required', 
                'gender_id'             =>  'required',
                'email'                 =>  'required',
                'home_phone_no'         =>  'required',
                'cell_phone_no'         =>  'required'
            ]);
        }
        // Guardian status update in client intake form table
        $update_status              =   ClientIntakeForm::where('id', $request->intake_form_id)->update([
            'have_guardian'         =>  $request->guardian_status
        ]);
        // Add Guardian as a new client
        if($request->guardian_status == '1'){
            $current_year   =   date('Y');
            $request_year   =   date('Y',strtotime($request->dob));
            $min_dob        =   $current_year - $request_year;
            if($min_dob < 18){
                return response()->JSON([
                    'status'    =>      'error',
                    'msg'       =>      'dob_not_18',
                ]);
            }
            ///PostalCode Check if not exists add new PostalCode
            $postal_codes = PostalCode::WHERE('postal_code',$request->postal_code_guar)->first();
            if($postal_codes){
                $postal_code                      =   $postal_codes->id;
            }else{
                $new_postal_code                  =   new PostalCode();
                $new_postal_code->postal_code     =   $request->postal_code_guar;
                $new_postal_code->city_id         =   $request->city_id_guar;
                $new_postal_code->state_id        =   $request->state_id_guar;
                $new_postal_code->country_id      =   $request->country_id_guar;
                $new_postal_code->created_by      =   $request->client_id;
                if ($new_postal_code->save()) {
                    $postal_code                  =   $new_postal_code->id;
                } else {
                    return response()->JSON([
                        'msg'   =>  'Error Postal Code Added'
                    ]);
                }
            }
            if($request->guradian_details_id !=''){
            $guardian                       =    Client::find($request->guradian_details_id);
            }else{
            $guardian                       =    new Client();
            }
            $guardian->first_name           =    $request->first_name;
            $guardian->last_name            =    $request->last_name;
            $guardian->dob                  =    $request->dob;
            $guardian->middle_name          =    $request->middle_name;
            $guardian->gender_id            =    $request->re_gender_id;
            $guardian->email                =    $request->email;
            $guardian->primary_cellphone    =    $request->cell_phone_no;
            $guardian->primary_landline     =    $request->home_phone_no;
            $guardian->country_id           =    $request->country_id_guar;
            $guardian->state_id             =    $request->state_id_guar;
            $guardian->city_id              =    $request->city_id_guar;
            $guardian->postal_code_id       =    $postal_code;
            $guardian->created_by           =    $request->client_id;
            $guardian->save();
            $new_guardian_id                =    $guardian->id;
            //Guardian Id Added in Client Intake Form table
            $update_guardian_id             =    ClientIntakeForm::where('id', $request->intake_form_id)->update([
                'guardian_id'               =>   $new_guardian_id
            ]);
            ///Data Added in IntakePOAnWills Table
            if($request->guradian_details_id != $new_guardian_id ){
                $new_will                               =    new IntakePoanWills();
                $new_will->intake_form_id               =    $request->intake_form_id;
                $new_will->client_id                    =    $request->client_id;
                $new_will->intake_form_type             =    $request->intake_form_type;
                $new_will->secondary_client_id          =    $new_guardian_id;
                $new_will->secondary_relationship_type  =    $request->relationship_type;
                $new_will->created_by                   =    $request->client_id;
                $new_will->save();
            }
        }else{
            $new_guardian_id = 0 ;
        }
        return response()->JSON([
            'status'                                =>  'success',
            'msg'                                   =>  'guardian_added',
            'guardian_id'                           =>   $new_guardian_id,
            'pre_guardian_id'                       =>   $request->guradian_details_id,
        ]);
    }
    // Save Will Assets
    public function save_will_assets(Request $request){
        $validate = $this->validate($request, [ 
            'will_move_immove_property'     =>  'required',
            'will_bank_account'             =>  'required',
            'will_insurance'                =>  'required',
            'will_rrsp'                     =>  'required',
            'will_shares'                   =>  'required', 
            'will_valuables'                =>  'required'
        ]);
        $insert_will                        =    ClientIntakeForm::WHERE('id', $request->intake_form_id)->update([
            'will_move_immove_property'     =>   $request->will_move_immove_property,
            'will_bank_account'             =>   $request->will_bank_account,
            'will_insurance'                =>   $request->will_insurance,
            'will_rrsp'                     =>   $request->will_rrsp,
            'will_shares'                   =>   $request->will_shares,
            'will_valuables'                =>   $request->will_valuables,
            'updated_by'                    =>   $request->client_id
        ]);
        return response()->json([
            'status'                        =>  'success',
            'msg'                           =>  'will_assets_added'
        ]);
    }
    // Save Will Estate Distributed
    public function save_will_estate_distributed(Request $request){
        $validate = $this->validate($request, [ 
            'will_estate_distributed'       =>  'required',
        ]);
        $insert_will                        =    ClientIntakeForm::WHERE('id', $request->intake_form_id)->update([
            'will_estate_distributed'       =>   $request->will_estate_distributed,
            'updated_by'                    =>   $request->client_id
        ]);
        return response()->json([
            'status'                        =>  'success',
            'msg'                           =>  'will_estate_distributed_added'
        ]); 
    }
    //Save Consent
    public function save_client_consent(Request $request){
        $validate = $this->validate($request, [ 
            // 'consent_one'                =>  'required',
            // 'consent_two'                =>  'required',
            'canada_183_days'            =>  'required',
            // 'client_signature'           =>  'required'
        ]);
        $consent                         =    ClientIntakeForm::WHERE('id', $request->client_intake_form_id)->update([
            'consent_one'                =>   $request->consent_one,
            'consent_two'                =>   $request->consent_two,
            'canada_183_days'            =>   $request->canada_183_days,
            'client_signature'           =>   $request->client_signature,
            'updated_by'                 =>   $request->client_id
        ]);
        return response()->json([
            'status'                     =>  'Success',
            'msg'                        =>  'Consent_Added',
        ]);
    }
    public function save_documents(Request $request){
        $validate = $this->validate($request, [
            'document_type'                 =>    'required',
            'document_number'               =>    'required',
            'document_expiry_date'          =>    'required',
            // 'document_front_image'          =>    'required | mimes:jpeg,jpg,png,PNG,JPEG',
            // 'document_back_image'           =>    'required | mimes:jpeg,jpg,png,PNG,JPEG',
        ]);
        
        if($request->client_document_id != ''){
            if($found_doc=ClientDocument::WHERE('student_id', $request->client_id)
                                        ->WHERE('document_type',$request->document_type)
                                        ->WHERE('client_intake_form_id',$request->intake_form_id)
                                        ->WHERE('id', '!=', $request->client_document_id)
                                        ->first())
            {
                return response()->JSON([
                                'status'    =>      'error',
                                'msg'       =>      'already_exists',
                ]);
            }
            $documents                      =      ClientDocument::find($request->client_document_id);
        }else{
            if($found_doc=ClientDocument::WHERE('student_id', $request->client_id)
                                        ->WHERE('client_intake_form_id',$request->intake_form_id)
                                        ->WHERE('document_type',$request->document_type)
                                        ->first())
            {
                return response()->JSON([
                                'status'    =>      'error',
                                'msg'       =>      'already_exists',
                ]);
            }
            $documents                      =      new ClientDocument();
        }
        
        if ($request->hasFile('document_front_image')) {
            $front_image                    =      $request->document_front_image->store('images', 'public');
            $documents->doc_front_image     =      $front_image;
        }else{
            if (empty($request->hidden_doc_front_image)) {
                return response()->json([
                                'status'    =>     'front_image_error',
                                'msg'       =>     "Front Image Should not empty"
                ]);
            }
        }
        if ($request->hasFile('document_back_image')) {
            $back_image                     =      $request->document_back_image->store('images', 'public');
            $documents->doc_back_image      =      $back_image;
        } else {
            if (empty($request->hidden_doc_back_image)) {
                return response()->json([
                                'status'    =>     'back_image_error',
                                'msg'       =>     "Back Image Should not empty"
                ]);
            }
        }

        $documents->student_id  =    $request->client_id;
        $documents->client_intake_form_id   =    $request->intake_form_id;
        $documents->document_type           =    $request->document_type;
        $documents->document_number         =    $request->document_number;
        $documents->issuance_date           =    $request->document_issuance_date;
        $documents->expiry_date             =    $request->document_expiry_date;
        if($request->client_document_id != ''){
            $documents->updated_by          =   $request->client_id;
        }else{
            $documents->created_by          =   $request->client_id;
        }
        $documents->save();
        return response()->JSON([
                                'msg'       =>  'success',
                                'documents' =>   $documents
        ]);
    }
    public function save_client_relation(Request $request){
        $validate = $this->validate($request, [
            'first_name'                =>   'required',
            'last_name'                 =>   'required',
            'relationship_type'         =>   'required',
            're_gender_id'              =>   'required',
        ]);
        if($request->operation == 'add'){
            // dd($request);
            if(($found=Client::WHERE('first_name', $request->first_name)
            ->WHERE('middle_name',$request->middle_name)
            ->WHERE('last_name',$request->last_name)
            ->WHERE('id','!=',$request->client_id)
            ->first()) && (Relative::WHERE('secondary_contact_id',$found->id)
            ->WHERE('relationship_type', $request->relationship_type)->first()))
            {
                return response()->JSON([
                                'status'    =>      'error',
                                'msg'       =>      'already_exists',
                ]);
            }
            if($request->intake_form_type > 5){
                $current_year               =   date('Y');
                $request_year               =   date('Y',strtotime($request->dob));
                $min_dob                    =   $current_year - $request_year;
                if($min_dob < 18){
                    return response()->JSON([
                        'status'            =>  'error',
                        'msg'               =>  'dob_not_18',
                    ]);
                }
            }
            $client                         =    new Client();
            $client->first_name             =    $request->first_name;
            $client->last_name              =    $request->last_name;
            $client->dob                    =    $request->dob;
            $client->middle_name            =    $request->middle_name;
            $client->gender_id              =    $request->re_gender_id;
            $client->created_by             =    $request->client_id;
            $client->save();
            $new_client_id = $client->id;
            
            //Secondary Client
            
            $insert                          =    new  Relative();
            $insert->secondary_contact_id    =    $new_client_id;
            $insert->student_id  =    $request->client_id;
            $insert->relationship_type       =    $request->relationship_type;
            $insert->created_by              =    $request->client_id;
            $insert->save();
            $relative_type_invers            =    $insert->relationship_type;

            if ($request->gender_id == 1 && $relative_type_invers == 1) {
                //Male and Father will return Son
                $request->relationship_type = 3;
            } else if ($request->gender_id == 1 && $relative_type_invers == 3) {
                //Male and Son will return Father
                $request->relationship_type = 1;
            } else if ($request->gender_id == 1 && $relative_type_invers == 4) {
                //Male and Daughter will return Father
                $request->relationship_type = 1;
            } else if ($request->gender_id == 2 && $relative_type_invers == 3) {
                //Female and Son will return Mother
                $request->relationship_type = 2;
            } else if ($request->gender_id == 2 && $relative_type_invers == 4) {
                //Female and Son will return Mother
                $request->relationship_type = 2;
            } else if ($request->gender_id == 1 && $relative_type_invers == 2) {
                //Male and Mother will return Son
                $request->relationship_type = 3;
            } else if ($request->gender_id == 2 && $relative_type_invers == 1) {
                //Female and Father will return Daughter
                $request->relationship_type = 4;
            } else if ($request->gender_id == 2 && $relative_type_invers == 2) {
                //Female and Mother will return Daughter
                $request->relationship_type = 4;
            } else if ($request->gender_id == 2 && $relative_type_invers == 5) {
                //Female and Brother will return Sister
                $request->relationship_type = 6;
            } else if ($request->gender_id == 2 && $relative_type_invers == 6) {
                //Female and Sister will return Sister
                $request->relationship_type = 6;
            } else if ($request->gender_id == 1 && $relative_type_invers == 6) {
                //Male and Sister will return Brother
                $request->relationship_type = 5;
            } else if ($request->gender_id == 1 && $relative_type_invers == 5) {
                //Male and Brother will return Brother
                $request->relationship_type = 5;
            } else if ($request->gender_id == 2 && $relative_type_invers == 7) {
                //Female and Spouse will return Spouse
                $request->relationship_type = 7;
            } else if ($request->gender_id == 1 && $relative_type_invers == 8) {
                //Male and Legal Partner will return Legal Partner
                $request->relationship_type = 8;
            } else if ($request->gender_id == 2 && $relative_type_invers == 8) {
                //Femle and Legal Partner will return Legal Partner
                $request->relationship_type = 8;
            } else if ($request->gender_id == 1 && $relative_type_invers == 9) {
                //Male and Relative will return Relative
                $request->relationship_type = 9;
            } else if ($request->gender_id == 2 && $relative_type_invers == 9) {
                //Femle and Relative will return Relative
                $request->relationship_type = 9;
            } else if ($request->gender_id == 1 && $relative_type_invers == 10) {
                //Male and Friend will return Friend
                $request->relationship_type = 10;
            } else if ($request->gender_id == 2 && $relative_type_invers == 10) {
                //Femle and Friend will return Friend
                $request->relationship_type = 10;
            } else if ($request->gender_id == 1 && $relative_type_invers == 11) {
                //Male and Bussines Partner will return Bussines Partner
                $request->relationship_type = 11;
            } else if ($request->gender_id == 2 && $relative_type_invers == 11) {
                //Femle and Bussines Partner will return Bussines Partner
                $request->relationship_type = 11;
            }

            //Primary Client 
            $new = new Relative();

            $new->secondary_contact_id    =    $request->client_id;
            $new->student_id  =    $new_client_id;
            $new->relationship_type       =    $request->relationship_type;
            $new->created_by              =    $request->client_id;
            $new->save();
            ///Save intake_poanwills
            $new_intake                             =   DB::table('intake_poanwills')->insert([
                    'intake_form_id'                =>  $request->intake_form_id,
                    'client_id'                     =>  $request->client_id,
                    'intake_form_type'              =>  $request->intake_form_type,
                    'secondary_client_id'           =>  $new_client_id,
                    'secondary_client_type'         =>  $request->beneficiary_type,
                    'secondary_relationship_type'   =>  $relative_type_invers,
                    'created_by'                    =>  $request->client_id
            ]);

            // $secondary_id1 =  $new_client_id;           // this Client id is from New CLient Register id  while making relation As Secondary.
            // $secondary_id2 =  $request->client_id;       // this Client id is from old CLient  id  while making relation As Primary.
            return response()->JSON([
                                'status'  =>    'success',
                                'msg'     =>    'relation_added',
            ]);

        }else{
            if($request->intake_form_type > 5){
                $current_year               =   date('Y');
                $request_year               =   date('Y',strtotime($request->dob));
                $min_dob                    =   $current_year - $request_year;
                if($min_dob < 18){
                    return response()->JSON([
                        'status'            =>  'error',
                        'msg'               =>  'dob_not_18',
                    ]);
                }
            }
            $update = CLient::where('id', $request->secondary_id)->update([
                'first_name'           =>  $request->first_name,
                'middle_name'          =>  $request->middle_name,
                'last_name'            =>  $request->last_name,
                'dob'                  =>  $request->dob,
                'gender_id'            =>  $request->re_gender_id,
                
            ]);
            ///Update intake_poanwills
            $update                             =   IntakePoanWills::WHERE('id', $request->intake_poanwills_id)->update([
                'secondary_client_type'         =>  $request->beneficiary_type,
                'secondary_relationship_type'   =>  $request->relationship_type
        ]);    
            /**   Updating Relation Type of Primary */
            $update  = Relative::where('student_id', $request->client_id)
                                ->where('secondary_contact_id', $request->secondary_id)
            ->update([
                'relationship_type' => $request->relationship_type,
                'updated_by'        => $request->client_id
                ]);
            /** END */

            $relative_type_invers = $request->relationship_type;


            if ($request->gender_id == 1 && $relative_type_invers == 1) {
                //Male and Father will return Son
                $request->relationship_type = 3;
            } else if ($request->gender_id == 1 && $relative_type_invers == 3) {
                //Male and Son will return Father
                $request->relationship_type = 1;
            } else if ($request->gender_id == 1 && $relative_type_invers == 4) {
                //Male and Daughter will return Father
                $request->relationship_type = 1;
            } else if ($request->gender_id == 2 && $relative_type_invers == 3) {
                //Female and Son will return Mother
                $request->relationship_type = 2;
            } else if ($request->gender_id == 2 && $relative_type_invers == 4) {
                //Female and Son will return Mother
                $request->relationship_type = 2;
            } else if ($request->gender_id == 1 && $relative_type_invers == 2) {
                //Male and Mother will return Son
                $request->relationship_type = 3;
            } else if ($request->gender_id == 2 && $relative_type_invers == 1) {
                //Female and Father will return Daughter
                $request->relationship_type = 4;
            } else if ($request->gender_id == 2 && $relative_type_invers == 2) {
                //Female and Mother will return Daughter
                $request->relationship_type = 4;
            } else if ($request->gender_id == 2 && $relative_type_invers == 5) {
                //Female and Brother will return Sister
                $request->relationship_type = 6;
            } else if ($request->gender_id == 2 && $relative_type_invers == 6) {
                //Female and Sister will return Sister
                $request->relationship_type = 6;
            } else if ($request->gender_id == 1 && $relative_type_invers == 6) {
                //Male and Sister will return Brother
                $request->relationship_type = 5;
            } else if ($request->gender_id == 1 && $relative_type_invers == 5) {
                //Male and Brother will return Brother
                $request->relationship_type = 5;
            } else if ($request->gender_id == 2 && $relative_type_invers == 7) {
                //Female and Spouse will return Spouse
                $request->relationship_type = 7;
            } else if ($request->gender_id == 1 && $relative_type_invers == 8) {
                //Male and Legal Partner will return Legal Partner
                $request->relationship_type = 8;
            } else if ($request->gender_id == 2 && $relative_type_invers == 8) {
                //Femle and Legal Partner will return Legal Partner
                $request->relationship_type = 8;
            } else if ($request->gender_id == 1 && $relative_type_invers == 9) {
                //Male and Relative will return Relative
                $request->relationship_type = 9;
            } else if ($request->gender_id == 2 && $relative_type_invers == 9) {
                //Femle and Relative will return Relative
                $request->relationship_type = 9;
            } else if ($request->gender_id == 1 && $relative_type_invers == 10) {
                //Male and Friend will return Friend
                $request->relationship_type = 10;
            } else if ($request->gender_id == 2 && $relative_type_invers == 10) {
                //Femle and Friend will return Friend
                $request->relationship_type = 10;
            } else if ($request->gender_id == 1 && $relative_type_invers == 11) {
                //Male and Bussines Partner will return Bussines Partner
                $request->relationship_type = 11;
            } else if ($request->gender_id == 2 && $relative_type_invers == 11) {
                //Femle and Bussines Partner will return Bussines Partner
                $request->relationship_type = 11;
            }

            $update  = Relative::where('secondary_contact_id', $request->client_id)
                ->where('student_id', $request->secondary_id)
                ->update([
                    'relationship_type' => $request->relationship_type,
                    'updated_by'        => $request->client_id
                ]);
            if ($update) {
                return response()->json([
                    'status'  =>  'success',
                    'msg'     =>  "relation_added"
                ]);
            } else {
                return response()->json([
                    'status' =>  'error',
                    'msg'    =>  "Failed"
                ]);
            }
        }
    }
    public function clients_employment_info($client_id){
        $client_employment      =   ClientEmployment::where('student_id',$client_id)
                                    ->join('students', 'students.id', '=', 'client_employment_info.student_id')
                                    ->selectRaw("client_employment_info.*,students.id as client_id   ,students.employment_status as client_occupation, IFNULL((SELECT postal_code From postal_codes WHERE id=client_employment_info.postal_code_id2), '') as postal_code")
                                    ->get();
        return response()->JSON([
            'msg'               => 'success',
            'client_employment' =>  $client_employment
        ]);
    }
    public function client_marital_details($client_id){
        $client_marital_details =   Relative::WHERE('client_relationships.student_id', $client_id)
                                    ->WHERE('client_relationships.relationship_type','7')
                                    ->orWHERE('client_relationships.relationship_type','8')
                                    ->join('students', 'students.id', '=', 'client_relationships.secondary_contact_id')
                                    ->selectRaw("students.*,IFNULL((SELECT postal_code From postal_codes WHERE id=students.postal_code_id), 'NA') as postal_code")
                                    ->selectRaw("client_relationships.*,client_relationships.id as relationship_id")
                                    ->selectRaw("(select marital_status From students WHERE students.id = $client_id) as primary_marital_status")
                                    ->first();
        return response()->JSON([
            'msg'               => 'success',
            'client_marital'    =>  $client_marital_details
        ]);
    }
    public function clients_all_documents(Request $request, $client_id){
        $client_documents       =   DB::table('client_documents')->selectRaw('*,document_type,IFNULL((SELECT document_verification_name FROM document_verifications WHERE id=client_documents.document_type), "NA") as document_type_name')
                                    ->where('student_id',$client_id)
                                    ->where('client_intake_form_id',$request->intake_form_id)
                                    ->get();
        $documents              =  DocumentVerification::all();
        return response()->JSON([
            'msg'               => 'success',
            'client_documents'  =>  $client_documents,
            'all_documents'     =>  $documents,
            'fetch_rows_doc'    =>  $client_documents->count()
        ]);
    }
    public function clients_all_relations($intake_form_id){
        $client_relations       =   IntakePoanWills::where('intake_poanwills.intake_form_id', $intake_form_id)
                                    ->Where('secondary_relationship_type', '!=', '12')
                                    ->join('students', 'students.id', '=', 'intake_poanwills.secondary_client_id')
                                    ->selectRaw("(SELECT gender_id from students WHERE id = intake_poanwills.client_id) as primary_gender_id")
                                    ->selectRaw("intake_poanwills.*,intake_poanwills.id as intake_poanwills_id")
                                    ->selectRaw("students.*,
                                        IFNULL((SELECT name From countries WHERE id=students.country_id), 'NA') as country,
                                        IFNULL((SELECT name From states WHERE id=students.state_id), 'NA') as state,
                                        IFNULL((SELECT name From cities WHERE id=students.city_id), 'NA') as city,
                                        IFNULL((SELECT postal_code From postal_codes WHERE id=students.postal_code_id), 'NA') as postal_code,
                                        IFNULL((SELECT gender_name From genders WHERE id=students.gender_id), 'NA') as gender_name")
                                    ->orderByRaw('students.dob ASC')
                                    ->get();
        $genders                =   Gender::all();
        return response()->JSON([
            'msg'               => 'success',
            'client_relations'  =>  $client_relations,
            'genders'           =>  $genders,
            'fetch_rows_rel'    =>  $client_relations->count()
        ]);
    }
    /////Deleted
    public function delete_documents_relations(Request $request){
        if($request->type == 'delete_document'){
            $delete_documents   =   ClientDocument::where('id',$request->id)->delete();
            return response()->JSON([
                    'status'    =>   'success',
                    'msg'       =>   'document_deleted'
            ]);
        }
        if($request->type == 'delete_relation'){
            $relations              =   IntakePoanWills::WHERE('id',$request->id)->delete();
            $delete_main_reocrds    =   Client::WHERE('id',$request->secondary_id)->delete();
                return response()->JSON([
                        'status'     =>      'success',
                        'msg'        =>      'relation_deleted'
                ]);                 
        }
    }
    ///Thank You
    public function intake_form_status_update(Request $request){
        $msg_update = "";
        if($request->funeral_form == 'funeral_finish'){
            $validate = $this->validate($request, [ 
                'will_funeral_burial_rites'     =>  'required',
            ]);
            $insert_will_funeral_rites          =    ClientIntakeForm::WHERE('id', $request->intake_form_id)->update([
                'will_funeral_burial_rites'     =>   $request->will_funeral_burial_rites,
                'updated_by'                    =>   $request->client_id
            ]);
            $msg_update                         =    "funeral_rites_added";
        }
        if($request->void_form == 'void_finish'){
            // if ($request->hasFile('mortgage_doc')) {
            //     $mortgage_doc       =   $request->mortgage_doc->store('email-templates', 'public');
            // }else{
            //     $mortgage_doc       =   $request->hidden_mortgage_doc;
            //     if ($request->hidden_mortgage_doc == '') {
            //         return response()->json([
            //             'status'    =>     'mortgage_doc_error',
            //             'msg'       =>     "Kindly Uplaod Mortgage Instrcution"
            //         ]);
            //     }
            // }
            if ($request->hasFile('void_doc')) {
                $void_doc           =   $request->void_doc->store('email-templates', 'public');
            }else{
                $void_doc           =   $request->hidden_void_doc;
                if ($request->hidden_void_doc == '') {
                    return response()->json([
                        'status'    =>     'void_doc_error',
                        'msg'       =>     "Kindly Uplaod Void Cheque"
                    ]);
                }
            }
            $update_email_template  =   DB::table('client_property_info')->WHERE('intake_forms_id', $request->intake_form_id)->update([
                // 'mortgage_instructions_doc'      =>  $mortgage_doc,    
                'void_cheque'                    =>  $void_doc,     
                // 'property_insurance'             =>  $request->property_insurance,     
            ]);
            $msg_update                          = "Upload Email Templates";
        }
        $update_status      = ClientIntakeForm::WHERE('unique_key',$request->intake_key)->update([
            'status'        => '4',
            'submitted_at'  => date('Y-m-d H:i:s')
        ]);
        return response()->json([
            'status'    => 'success',
            'msg'       => 'update_status',
            'msgEmail'  =>  $msg_update
        ]);
    }
    public function thankyou_form(){
        return view('intake-form-frontend.thankyou');
    }


    ///Get All Countries
    public function get_all_countries(){
        $countries                  = Country::all();
                return response()->JSON([
                    'msg'           =>  'success',
                    'countries'     =>  $countries
                ]);
    }
    /// Get State Against Country
    public function get_states_against_country($id){
        $states                     =   State::WHERE('country_id', $id)->get();
                return response()->JSON([
                    'msg'           =>  'success',
                    'states'        =>  $states
                ]);
    }
    /// Get Cities Against State
    public function get_city_against_states($id){
        $cities                     =   City::WHERE('state_id', $id)->get();
                return response()->JSON([
                    'msg'           =>  'success',
                    'cities'        =>  $cities
                ]);
    }
    /// Get Postal Code Against City
    public function get_postal_code_against_cities($id){
        $postal_codes               =   PostalCode::WHERE('city_id', $id)
                                        ->leftjoin('countries'  ,   'postal_codes.country_id', '=' , 'countries.id')
                                        ->leftjoin('states'     ,   'postal_codes.state_id'  , '=' , 'states.id')
                                        ->leftjoin('cities'     ,   'postal_codes.city_id'   , '=' , 'cities.id')
                                        ->select('postal_codes.*','countries.name as country_name','cities.name as city_name','states.name as state_name')
                                        ->get();       
                return response()->JSON([
                    'msg'           =>  'success',
                    'postalcodes'   =>  $postal_codes
                ]);
    }

    ///Save Realtor Form
    public function save_realtor_info(Request $request){
        $validate = $this->validate($request, [ 
            'first_name'            =>  'required',
            'last_name'             =>  'required',
            'official_email'        =>  'required',
            'contact_cellphone'     =>  'required',
            'agency_name'           =>  'required'
        ]);
            // Agency exists or not
            $agency                              =  Customer::where('company_name',$request->agency_name)
                                                    ->where('business_type','1')
                                                    ->first();
                if($agency){
                    $agency                      =   $agency->id;
                }else{
                    $new_agency                  =   new Customer();
                    $new_agency->company_name    =   $request->agency_name;
                    $new_agency->business_type   =  '1';
                    $new_agency->created_by      =   $request->client_id;
                    if ($new_agency->save()) {
                        $agency                  =   $new_agency->id;
                    } else {
                        return response()->JSON([
                            'msg'   =>  'Error Agency Added'
                        ]);
                    }
                }
            // Contact against agency exists or not
            $contact                                =   ContactMainDetails::where('official_email',$request->official_email)->
                                                        where('contact_cellphone',$request->contact_cellphone)->
                                                        first();
            $contact_type                           =   DB::table('contact_types')->where('contact_type_flag','2')->first();
            $contact_type_id                        =   $contact_type->id;
                if($contact){
                    $contact                        =   $contact->id;
                    $contact_update                 =   ContactMainDetails::where('id',$contact)->update([
                        'agency_id'                 =>  $agency,
                        'contact_type'              =>  $contact_type_id,
                        'contact_type_flag'         =>  '2'
                    ]);
                }else{
                    $new_contact                    =   new ContactMainDetails();
                    $new_contact->contact_type      =   $contact_type_id;
                    $new_contact->contact_type_flag =   '2';
                    $new_contact->first_name        =   $request->first_name;
                    $new_contact->middle_name       =   $request->middle_name;
                    $new_contact->last_name         =   $request->last_name;
                    $new_contact->official_email    =   $request->official_email;
                    $new_contact->contact_cellphone =   $request->contact_cellphone;
                    $new_contact->agency_id         =   $request->agency;
                    $new_contact->created_by        =   $request->client_id;
                    if ($new_contact->save()) {
                        $contact                    =   $new_contact->id;
                    } else {
                        return response()->JSON([
                            'msg'   =>  'Error contact Added'
                        ]);
                    }
                }
            if($request->intake_form_id != ''){
                $realtor                         =   ClientProperty::where('intake_forms_id',$request->intake_form_id)->update([
                    'realtor_id'                 =>   $contact,
                    'realestate_agency_id'       =>   $agency,
                    'updated_by'                 =>   $request->client_id,
                ]);
                return response()->JSON([
                                'msg'               =>  'success',
                                'insert_realtor'    =>  'Realtor Added'
                ]);
            }
    }
    ///Save Mortgage Form
    public function save_mortgage_info(Request $request){
        $validate = $this->validate($request, [ 
            'first_name'            =>  'required',
            'last_name'             =>  'required',
            'official_email'        =>  'required',
            'contact_cellphone'     =>  'required',
            'agency_name'           =>  'required'
        ]);
            // Agency exists or not
            $agency                              =  Customer::where('company_name',$request->agency_name)
                                                    ->where('business_type','2')
                                                    ->first();
                if($agency){
                    $agency                      =   $agency->id;
                }else{
                    $new_agency                  =   new Customer();
                    $new_agency->company_name    =   $request->agency_name;
                    $new_agency->business_type   =  '2';
                    $new_agency->created_by      =   $request->client_id;
                    if ($new_agency->save()) {
                        $agency                  =   $new_agency->id;
                    } else {
                        return response()->JSON([
                            'msg'   =>  'Error Agency Added'
                        ]);
                    }
                }
            // Contact against agency exists or not
            $contact                                =   ContactMainDetails::where('official_email',$request->official_email)->
                                                        where('contact_cellphone',$request->contact_cellphone)->
                                                        first();
            $contact_type                           =   DB::table('contact_types')->where('contact_type_flag','3')->first();
            $contact_type_id                        =   $contact_type->id;
                if($contact){
                    $contact                        =   $contact->id;
                    $contact_update                 =   ContactMainDetails::where('id',$contact)->update([
                        'agency_id'                 =>  $agency,
                        'contact_type_flag'         =>  '3',
                        'contact_type'              =>  $contact_type_id
                    ]);
                }else{
                    $new_contact                    =   new ContactMainDetails();
                    $new_contact->contact_type      =   $contact_type_id;
                    $new_contact->contact_type_flag =   '3';
                    $new_contact->first_name        =   $request->first_name;
                    $new_contact->middle_name       =   $request->middle_name;
                    $new_contact->last_name         =   $request->last_name;
                    $new_contact->official_email    =   $request->official_email;
                    $new_contact->contact_cellphone =   $request->contact_cellphone;
                    $new_contact->agency_id         =   $request->agency;
                    $new_contact->created_by        =   $request->client_id;
                    if ($new_contact->save()) {
                        $contact                    =   $new_contact->id;
                    } else {
                        return response()->JSON([
                            'msg'   =>  'Error contact Added'
                        ]);
                    }
                }
            if($request->intake_form_id != ''){
                $mortgage                        =   ClientProperty::where('intake_forms_id',$request->intake_form_id)->update([
                    'mortgage_agent_id'          =>   $contact,
                    'mortgage_agency_id'         =>   $agency,
                    'updated_by'                 =>   $request->client_id,
                ]);
                return response()->JSON([
                                'msg'               =>  'success',
                                'insert_mortgage'   =>  'Mortgage Added'
                ]);
            }
    }
       
}
