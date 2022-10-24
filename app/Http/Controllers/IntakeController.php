<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\AccessRightsAuth;
use App\IntakeFormType;
use App\Integrations;
use App\Mail\IntakeFormMail;
use Illuminate\Http\Request;
use App\Client;
use App\ClientDocument;
use App\ClientIntakeForm;
use App\IntakeForm;
use App\Relative;
use Exception;
use App\ClientEmployment;
use App\ClientProperty;
use App\IntakePoanWills;

use App\ResidenceStatus;
use DB;
use File;
use Auth;
use App\Gender;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class IntakeController extends AccessRightsAuth
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        return view('intake.index');
    }
    public function getForms(){
        $forms   =   DB::table('client_intake_form')->leftjoin('students','students.id','=','client_intake_form.client_id')
                                                    ->leftjoin('intake_forms','intake_forms.id','=','client_intake_form.intake_form_id') 
                                                    ->select('client_intake_form.*','intake_forms.form_status','students.first_name as first_name',
                                                            'students.last_name as last_name','intake_forms.intake_form_type as form_type')
                                                    ->get();
        echo json_encode(array('client' => $forms));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        error_reporting(0);
       $intakeformtypes     =    IntakeFormType::all();
       $property_type       =   DB::table('property_types')->get();
       $clients             =   Client::all();
       $residence_status    =   ResidenceStatus::all();
       return view('intake.create',compact('clients','residence_status','property_type','intakeformtypes'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     { 
        // dd($request->all());
            $intake_form        =   IntakeForm::create([
                                        'intake_form_type'       =>  $request->intake_form_type,
                                        'form_status'            =>  0,//$request->form_status,
                                        'created_by'             =>  $request->created_by,
                                        ]);
             if($request->mulitple_clients){     
                    foreach($request->mulitple_clients as  $data)
                        {
                                $new_client     =   Client::create([
                                                        'first_name'                 =>     $data['new_first_name'],
                                                        'last_name'                  =>     $data['new_last_name'],
                                                        'middle_name'                =>     $data['new_middle_name'],
                                                        // 'primary_cellphone'       =>     $data['new_primary_cellphone'],
                                                        'email'                      =>     $data['new_email'],
                                                        // 'dob'                     =>     $data['new_dob'],
                                                        // 'gender_id'               =>     $data['new_gender_id'],
                                                        // 'marital_status'          =>     $data['marital_status'],
                                                        // 'residence_status'        =>     $data['residence_status'],
                                                        // 'employment_status'       =>     $data['employment_status'],
                                                        'created_at'                 =>     date('Y-m-d H:i:s'),
                                                        'created_by'                 =>     Auth::user()->id,
                                                        'updated_by'                 =>     Auth::user()->id,
                                                        'updated_at'                 =>     date('Y-m-d H:i:s'),
                                                                    ]);
                                $unique_key    =   $this->generateUniqKey();
                                $intake_form->clients()->attach($new_client->id, ['status' => 1,'intake_form_type'=>$request->intake_form_type,'unique_key'=>$unique_key]);
                                $this->sendIntakeEmail($new_client->id,$unique_key);
                        }
                }
                if($request->new_first_name != null){
                        $new_client              =   Client::create([
                                                        'first_name'                 =>    $request->new_first_name,
                                                        'last_name'                  =>    $request->new_last_name,
                                                        'middle_name'                =>    $request->new_middle_name,
                                                        // 'primary_cellphone'       =>    $request->new_primary_cellphone,
                                                        'email'                      =>    $request->new_email,
                                                        'dob'                        =>    $request->new_dob,
                                                        // 'gender_id'               =>    $request->new_gender_id,
                                                        // 'marital_status'          =>    $request->new_marital_status,
                                                        // 'residence_status'        =>    $request->new_residence_status,
                                                        // 'employment_status'       =>    $request->new_employment_status,
                                                        'created_at'                 =>    date('Y-m-d H:i:s'),
                                                        'created_by'                 =>    Auth::user()->id,
                                                        'updated_by'                 =>    Auth::user()->id,
                                                        'updated_at'                 =>    date('Y-m-d H:i:s'),
                                                            ]);
                        $unique_key =   $this->generateUniqKey();
                        $intake_form->clients()->attach($new_client->id, ['status' => 1,'intake_form_type'=>$request->intake_form_type,'unique_key'=>$unique_key]);
                        $this->sendIntakeEmail($new_client->id,$unique_key);
                }
                if($request->current_client_array){
                    $data = $request->current_client_array;
                    foreach($data as $client_id)
                    {
                        $unique_key =   $this->generateUniqKey();
                        $intake_form->clients()->attach($client_id,  ['status' => 1,'intake_form_type'=>$request->intake_form_type,'unique_key'=>$unique_key]);
                        $this->sendIntakeEmail($client_id['existing_client_id'],$unique_key);
                    }
              
                }
    if($request->unit != null) {

          $property_info      =      DB::table('client_property_info')->insert([
                                            'unit'                      =>  $request->unit,
                                            'intake_forms_id'           =>  $intake_form->id,
                                            'property_type_id'          =>  $request->property_type_id,
                                            'street_address'            =>  $request->street_address,
                                            'country_id'                =>  $request->country_id,
                                            'state_id'                  =>  $request->state_id,
                                            'city_id'                   =>  $request->city_id,
                                            'postal_code_id'            =>  $request->postal_code_id,
                                        ]);
                }
      
       return response()->json([
            'status'        =>  'success',
            'msg'           =>  'Form Created',
           
       ]);

    
    }
    public function sendIntakeFormEmail($client_id,$unique_key){
        if($this->sendIntakeEmail($client_id,$unique_key)){
            return response()->json([
                'status'    =>  'success',
                'msg'       =>  'Email sent successfully'
            ]);
        }else{
            return response()->json([
                'status'    =>  'error',
                'msg'       =>  'Email Fialed.'
            ]);
        }
    }
    public function sendIntakeEmail($client_id,$unique_key){
        $isActive               =   Integrations::where('type','mailchimp')->where('status','active')->count();
        if($isActive == 1){
            $data['client']     =   Client::find($client_id);
            $intake_form_type   =   DB::table('client_intake_form')->where('unique_key',$unique_key)->first()->intake_form_type;
            $data['form_type']  =   IntakeFormType::where('id',$intake_form_type)->first()->name;
            $data['subject']    =   "Hi {$data['client']->first_name}, Welcome to Khan Law";
            $data['url']        =   route('intake.form',['key'=>$unique_key]);
          try{  Mail::to($data['client']->email)->send(new IntakeFormMail($data));
            return true;}
            catch(Exception $ex){
               return false;   
            }
        }else{
            return false;
        }
    }
    public function generateUniqKey(){
        $unique_key   =     Str::random(60);
        $isExist      =     DB::table('client_intake_form')->where('unique_key',$unique_key)->count(); 
       if($isExist == 0){
          return $unique_key;
       }
       $this->generateUniqKey();
    }
    // public function edit($id)
    // {
    //     $form            =   ClientIntakeForm::where('client_intake_form.id',$id)
    //                             ->leftjoin('students','students.id','=','client_intake_form.client_id')
    //                             ->leftjoin('countries', 'countries.id','=','students.country_id')
    //                             ->leftjoin('residence_status','residence_status.id','=','students.residence_status')
    //                             ->leftjoin('states', 'states.id','=','students.state_id')
    //                             ->leftjoin('cities', 'cities.id','=','students.city_id')
    //                             ->leftjoin('postal_codes', 'postal_codes.id','=','students.postal_code_id')
    //                             ->leftjoin('genders','genders.id','=','students.gender_id') 
    //                             ->select('client_intake_form.*','students.*','residence_status.residence_name as residence',
    //                                     'countries.name as country','cities.name as city','states.name as state',
    //                                     'postal_codes.postal_code as postal_code','genders.gender_name as gender')
    //                             ->first();
    //     $genders          =       Gender::all();
    //     $residences       =   DB::table('residence_status')->get();
                              
    //         return view("intake.edit",compact('form','genders','residences'));
    // }
   
    public function GetClient($id){
    $client   =   Client::find($id);
      return response()->json([
            'status'    =>  "success",
            'msg'       =>  "Client Finded",
            'client'    =>  $client,
      ]);
    }
    public function detail($id){
        $form           =   ClientIntakeForm::where('client_intake_form.id',$id)
                                    ->leftjoin('students','students.id','=','client_intake_form.client_id')
                                    ->leftjoin('countries', 'countries.id','=','students.country_id')
                                    ->leftjoin('residence_status','residence_status.id','=','students.residence_status')
                                    ->leftjoin('states', 'states.id','=','students.state_id')
                                    ->leftjoin('cities', 'cities.id','=','students.city_id')
                                    ->leftjoin('postal_codes', 'postal_codes.id','=','students.postal_code_id')
                                    ->leftjoin('genders','genders.id','=','students.gender_id') 
                                    ->select('client_intake_form.*','students.*','residence_status.residence_name as residence',
                                            'countries.name as country','cities.name as city','states.name as state',
                                            'postal_codes.postal_code as postal_code','genders.gender_name as gender')
                                    ->first();
                              
        if($form->status == '1'){
            return redirect()->back()->with('error','Form should be submitted to view details.');
        }
        $form_id        =      $id;
        $documents      =   ClientDocument::where('client_documents.student_id', $form->client_id)
                                    ->where('client_documents.client_intake_form_id',$form_id)
                                    ->leftjoin('document_verifications','document_verifications.id','=','client_documents.document_type')
                                    ->select('client_documents.*','document_verifications.document_verification_name as document_type')
                                    ->get();
        $nominees       =   IntakePoanWills::where('intake_poanwills.intake_form_id' , $form_id)
                                    ->where('intake_poanwills.client_id' , $form->client_id)
                                    ->where('intake_poanwills.secondary_relationship_type','!=',12)
                                    ->leftjoin('students','students.id','=','intake_poanwills.secondary_client_id')
                                    ->leftjoin('genders','genders.id','=','students.gender_id')
                                    ->get();
   
        //for Gaurdian
        $gaurdian       =   IntakePoanWills::where('intake_poanwills.intake_form_id' , $form_id)
                                    ->where('intake_poanwills.client_id' , $form->client_id)
                                    ->where('intake_poanwills.secondary_relationship_type',12)
                                    ->leftjoin('students','students.id','=','intake_poanwills.secondary_client_id')
                                    ->leftjoin('genders','genders.id','=','students.gender_id')
                                    ->first();                                                          
        $employment     =   ClientEmployment::where('client_employment_info.student_id', $form->client_id)
                                    ->leftjoin('countries', 'countries.id','=','client_employment_info.country_id2')
                                    ->leftjoin('states', 'states.id','=','client_employment_info.state_id2')
                                    ->leftjoin('cities', 'cities.id','=','client_employment_info.city_id2')
                                    ->leftjoin('postal_codes', 'postal_codes.id','=','client_employment_info.postal_code_id2')
                                    ->select('client_employment_info.*',
                                    'countries.name as country','cities.name as city','states.name as state',
                                    'postal_codes.postal_code as postal_code')
                                    ->first();
        $property_info  =   ClientProperty::where('client_property_info.intake_forms_id',$form->intake_form_id)
                                    ->leftjoin('property_types','property_types.id','=','client_property_info.property_type_id')
                                    ->leftjoin('countries', 'countries.id','=','client_property_info.country_id')
                                    ->leftjoin('states', 'states.id','=','client_property_info.state_id')
                                    ->leftjoin('cities', 'cities.id','=','client_property_info.city_id')
                                    ->leftjoin('postal_codes', 'postal_codes.id','=','client_property_info.postal_code_id')
                                    ->select('client_property_info.*','property_types.property_name as property',
                                            'countries.name as country','cities.name as city','states.name as state',
                                            'postal_codes.postal_code as postal_code')
                                    ->first();
                                $void_cheque_extention = '';
                                $mortgage_instructions_docextention =   '';
                               
                                if($property_info != '' && $property_info->void_cheque != '')
                                {
                                $path                   =   pathinfo(storage_path().$property_info->void_cheque);
                                $void_cheque_extention  =   $path['extension'];                                                          
                                }
                            
            return view("intake.detail",compact('form','documents','nominees','employment','property_info','form_id'
                                            ,'void_cheque_extention','mortgage_instructions_docextention','gaurdian'));      
    }
    public function GetResidence(){
        $residence_status       =   ResidenceStatus::all();
        return response()->json([
            'status'            =>    'Success',
            'msg'               =>    'Residences Fetched',
            'residence'         => $residence_status
        ]);
        }
        public function approve($id){
            $update             =   ClientIntakeForm::where('client_intake_form.id',$id)
                                    ->update([
                                        'status'    =>   2
                                    ]);
            return response()->json([
                'status'            =>    'Success',
                'msg'               =>    'Form Accepted',
            ]);
        }
    
}