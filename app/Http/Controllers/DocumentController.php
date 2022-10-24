<?php

namespace App\Http\Controllers;

use App\ClientIntakeForm;
use App\Gender;
use App\Http\Controllers\Core\AccessRightsAuth;
use App\IntakeForm;
use App\IntakeFormType;
use App\Client;
use App\IntakePoanWills;
use App\Relative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class DocumentController extends AccessRightsAuth
{
    //
    public function index(){

    }

    public function show(Request $request,$id){
        error_reporting(0);
        $intakeformtype    =  IntakeFormType::selectRaw("client_intake_form.*,intake_form_types.name,intake_form_types.document ")
                                                ->join('client_intake_form', function ($join) use ($id) {
                                                    $join->on('client_intake_form.intake_form_type', '=', 'intake_form_types.id')
                                                        ->where('client_intake_form.id',$id);
                                                })->first();
        if(!in_array($intakeformtype->intake_form_type,[5,6,7])){
            return redirect(route('intake-forms'))->with('error','Document is not availble for this Intake form type.');
        }
        if(!$intakeformtype){
            redirect(route('intake-forms'))->with('error','Invalid Client and intake form assignments.');
        }
        if($intakeformtype->status == '1'){
            redirect(route('intake-forms'))->with('error','Form should be submitted to view document.');
        }
        $relationshiptypes  =   config('relationshiptypes');
        $client             =   Client::leftjoin("genders","genders.id","=","students.gender_id")
                                        ->selectRaw("students.*,genders.gender_name")
                                        ->selectRaw(" IF(students.country_id>0,(SELECT name FROM countries WHERE countries.id = students.country_id),'NA') as country_name ")
                                        ->selectRaw(" IF(students.state_id>0,  (SELECT name FROM states WHERE states.id = students.state_id),'NA') as state_name ")
                                        ->selectRaw(" IF(students.city_id>0,   (SELECT name FROM cities WHERE cities.id = students.city_id),'NA') as city_name ")
                                        ->where('students.id',$intakeformtype->client_id)
                                        ->first();
        $clint_list         =   [
                                    '<p>' => '<p style="font-size:12px;font-family:Times">',
                                    '[FULL_NAME]' => $client->first_name . ' ' . $client->middle_name . ' ' . $client->last_name,
                                    '[CITY_NAME]' => $client->city_name,
                                    '[DOB]' => dateFormat($client->dob),
                                    '[PROVINCE_NAME]' => $client->state_name,
                                    '[STATE_NAME]' => $client->state_name,
                                    '[HIS_HER]' => $client->gender_id == 1 ? 'his' : 'her'
                                ];
        if(in_array($intakeformtype->intake_form_type,[6,7])) { //POA HEALTH/PROPERTIES
            $nominiees = IntakePoanWills::join("students", "students.id", "=", "intake_poanwills.secondary_client_id")
                                            ->selectRaw("students.*,intake_poanwills.secondary_relationship_type")
                                            ->selectRaw(" IF(students.country_id>0,(SELECT name FROM countries WHERE countries.id = students.country_id),'NA') as country_name ")
                                            ->selectRaw(" IF(students.state_id>0,  (SELECT name FROM states WHERE states.id = students.state_id),'NA') as state_name ")
                                            ->selectRaw(" IF(students.city_id>0,   (SELECT name FROM cities WHERE cities.id = students.city_id),'NA') as city_name ")
                                            ->where('intake_poanwills.client_id', $intakeformtype->client_id)
                                            ->take(2)
                                            ->get();

            $list = [
                        '[NOMINEE_1_RELATIONSHIP]' => $relationshiptypes[$nominiees[0]->relationship_type],
                        '[NOMINEE_1_FULLNAME]' => $nominiees[0]->first_name . ' ' . $nominiees[0]->middle_name . ' ' . $nominiees[0]->last_name,
                        '[NOMINEE_1_DOB]' => dateFormat($nominiees[0]->dob),
                        '[NOMINEE_1_HE_SHE]' => $nominiees[0]->gender_id == 1 ? 'He' : 'She',
                        '[NOMINEE_2_RELATIONSHIP]' => $relationshiptypes[$nominiees[0]->relationship_type],
                        '[NOMINEE_2_FULLNAME]' => $nominiees[1]->first_name . ' ' . $nominiees[1]->middle_name . ' ' . $nominiees[1]->last_name,
                        '[NOMINEE_2_DOB]' => dateFormat($nominiees[1]->dob)
                    ];
        }
        elseif(in_array($intakeformtype->intake_form_type,[5])) { //WIlls
            $executors      = IntakePoanWills::join("students", "students.id", "=", "intake_poanwills.secondary_client_id")
                                            ->selectRaw("students.*,intake_poanwills.secondary_relationship_type")
                                            ->selectRaw(" IF(students.country_id>0,(SELECT name FROM countries WHERE countries.id = students.country_id),'NA') as country_name ")
                                            ->selectRaw(" IF(students.state_id>0,  (SELECT name FROM states WHERE states.id = students.state_id),'NA') as state_name ")
                                            ->selectRaw(" IF(students.city_id>0,   (SELECT name FROM cities WHERE cities.id = students.city_id),'NA') as city_name ")
                                            ->where('intake_poanwills.client_id', $intakeformtype->client_id)
                                            ->whereIn('intake_poanwills.secondary_client_type',[3,5])
                                            ->take(2)
                                            ->get();
            $beneficaries   = IntakePoanWills::join("students", "students.id", "=", "intake_poanwills.secondary_client_id")
                                            ->selectRaw("students.*,intake_poanwills.secondary_relationship_type")
                                            ->selectRaw(" IF(students.country_id>0,(SELECT name FROM countries WHERE countries.id = students.country_id),'NA') as country_name ")
                                            ->selectRaw(" IF(students.state_id>0,  (SELECT name FROM states WHERE states.id = students.state_id),'NA') as state_name ")
                                            ->selectRaw(" IF(students.city_id>0,   (SELECT name FROM cities WHERE cities.id = students.city_id),'NA') as city_name ")
                                            ->where('intake_poanwills.client_id', $intakeformtype->client_id)
                                            ->whereIn('intake_poanwills.secondary_client_type',[3,4])
                                            ->take(1)
                                            ->get();


            $list = [
                        '[EXECUTOR_1_RELATIONSHIP]' =>  $relationshiptypes[$executors[0]->relationship_type],
                        '[EXECUTOR_1_FULLNAME]'     =>  $executors[0]->first_name . ' ' . $executors[0]->middle_name . ' ' . $executors[0]->last_name,
                        '[EXECUTOR_1_DOB]'          =>  dateFormat($executors[0]->dob),
                        '[EXECUTOR_EXECUTRIX_1]'    =>  $executors[0]->gender_id == 1 ? 'executor' : 'executorix',
                        '[EXECUTOR_1_HIS_HER]'      =>  $executors[0]->gender_id == 1 ? 'his' : 'her',



                        '[EXECUTOR_2_RELATIONSHIP]' =>  $relationshiptypes[$executors[1]->relationship_type],
                        '[EXECUTOR_2_FULLNAME]'     =>  $executors[1]->first_name . ' ' . $executors[1]->middle_name . ' ' . $executors[1]->last_name,
                        '[EXECUTOR_2_DOB]'          =>  dateFormat($executors[1]->dob),
                        '[EXECUTOR_EXECUTRIX_2]'    =>  $executors[1]->gender_id == 1 ? 'executor' : 'executorix',
                        '[EXECUTOR_2_HIS_HER]'      =>  $executors[1]->gender_id == 1 ? 'his' : 'her',

                        '[BENEFICARY_1_FULLNAME]'   =>  $beneficaries[0]->first_name . ' ' . $beneficaries[0]->middle_name . ' ' . $beneficaries[0]->last_name,
                        '[BENEFICARY_HIS_HER]'      =>  $beneficaries[0]->gender_id == 1 ? 'his' : 'her',


                        '[PROPERTY_INFO]'           =>  $intakeformtype->will_move_immove_property,
                        '[BANK_ACCOUNT_INFO]'       =>  $intakeformtype->will_bank_account,
                        '[INSURANCE_INFO]'          =>  $intakeformtype->will_insurance,
                        '[RRSPs_INFO]'              =>  $intakeformtype->will_rrsp,
                        '[SHARES_INFO]'             =>  $intakeformtype->will_shares,
                        '[VALUEABLEs_INFO]'         =>  $intakeformtype->will_valuables,

                        '[DISPOSITION_OF_ASSETS]'   =>  $intakeformtype->will_estate_distributed,
                        '[FUNERAL_BURIAL_RITES]'    =>  $intakeformtype->will_funeral_burial_rites,
                    ];
        }
        $replaces   =   [];
        $replaces   =   array_merge($replaces,$clint_list,$list);
        $document   =   replaceDocumentByKeyWords($replaces,$intakeformtype->document);
        return view('documents.view',compact('intakeformtype','client','genders','document'));
    }
    public function print(Request $request,$id){

        error_reporting(0);
        $intakeformtype    =  IntakeFormType::selectRaw("client_intake_form.*,intake_form_types.name,intake_form_types.document ")
                                            ->join('client_intake_form', function ($join) use ($id) {
                                                $join->on('client_intake_form.intake_form_type', '=', 'intake_form_types.id')
                                                    ->where('client_intake_form.id',$id);
                                            })->first();
        if(!in_array($intakeformtype->intake_form_type,[5,6,7])){
            return redirect()->back()->with('error','Document is not availble for this Intake form type.');
        }
        $document   =   $request->document;
        $witness    =   '';
        if(empty($request->witness_name) || count($request->witness_name) == 0 ){
            return redirect()->back()->with('error', 'Witnesses are required.');
        }
        if(!empty($request->witness_name))
        {
            foreach ($request->witness_name as $key=>$val){
                $witness .= "   <br><p><strong>___________________________</strong></p>
                            <p>Witness</p>
                            <p>Name: {$request->witness_name[$key]}</p>
                            <p>Address: {$request->witness_address[$key]}</p>";
            }
        }
        $list              =   [
                                    '[WITNESS]'          =>   $witness
                               ];
        $document   =   replaceDocumentByKeyWords($list,$document);

        ClientIntakeForm::where('id',$intakeformtype->id)->update(['document'=>$document]);

        $pdf = PDF::loadView('documents.print', compact('document'));
        return $pdf->stream('Document.pdf');
    }

    public function pdf($id){
        error_reporting(0);
        $data       =   ClientIntakeForm::where('id',$id)->first();
        if(!in_array($data->intake_form_type,[5,6,7])){
            return redirect()->back()->with('error','Document is not availble for this Intake form type.');
        }
        $document   =   $data->document;
        $pdf = PDF::loadView('documents.print', compact('document'));
        return $pdf->stream('Document.pdf');
    }


}
