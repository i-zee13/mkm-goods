<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\ProspectCustomer as PC;
use App\Poc;
use App\Http\Controllers\Core\AccessRightsAuth;

class ProspectCustomers extends AccessRightsAuth
{
    public $controllerName = "ProspectCustomers";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('customer.prospect_customer');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function CustomersList(){
        
        echo json_encode(PC::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new PC;
        $customer->company_name = $request['compName'];
        $customer->client_name = $request['clientName'];
        $customer->address = $request['address'];
        $customer->country = $request['country'];
        $customer->region = $request['region'];
        $customer->meeting_minutes = $request['meeting_mins'];
        $customer->remarks = $request['remarks'];

        if($customer->save()){
            for($i = 0; $i <= $request->total_pocs; $i++){
                if(!isset($request['poc-'.$i])){
                    continue;
                }
                $poc = new Poc;
                $poc->poc_name = $request['poc-'.$i];
                $poc->business = $request['business-'.$i];
                $poc->whatsapp = $request['whatsapp-'.$i];
                $poc->mobile = $request['mobile-'.$i];
                $poc->email = $request['email'];
                $poc->prospect_customer_id = $customer->id;
                if($request->hasFile('card_front-'.$i)){
                    $completeFileName = $request->file('card_front-'.$i)->getClientOriginalName();
                    $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                    $extension = $request->file('card_front-'.$i)->getClientOriginalExtension();
                    $compPic = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
                    $path = $request->file('card_front-'.$i)->storeAs('public/prospect_customers', $compPic);
                    $poc->card_front = $compPic;
                }
                
                if($request->hasFile('card_back-'.$i)){
                    $completeFileName = $request->file('card_back-'.$i)->getClientOriginalName();
                    $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                    $extension = $request->file('card_back-'.$i)->getClientOriginalExtension();
                    $compPic = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
                    $path = $request->file('card_back-'.$i)->storeAs('public/prospect_customers', $compPic);
                    $poc->card_back = $compPic;
                }
                $poc->save();
            }
            DB::table('notifications_list')->insert(['code' => config('constants.options._PROSPECT_NOTIFICATION_CODE'), 'message' => 'has been added as a Prospect Customer', 'prospect_customer_id' => $customer->id, 'created_at' => Auth::user()->id]);
            echo json_encode('success');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        echo json_encode(array('info' => PC::find($id), 'base_url' => URL::to('/')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        
        $this->validate($request, [
            'poc' => 'required|max:100',
            'clientName' => 'required|max:200',
            'compName' => 'required|max:200'
        ]);

        $customer = PC::find($id);
        $customer->company_name = $request->compName;
        $customer->company_poc = $request->poc;
        $customer->client_name = $request->clientName;
        $customer->mobile_phone = $request->mobile;
        $customer->address = $request->address;
        $customer->country = $request->country;
        $customer->region = $request->region;
        $customer->email = $request->email;
        $customer->webpage = $request->website;
        $customer->meeting_minutes = $request->meeting_mins;
        $customer->correspondence = $request->correspondence;
        $customer->remarks = $request->remarks;
        
        if($request->hasFile('card_front')){
            $existingImg = $customer->card_front;
            if(Storage::exists('public/prospect_customers/'.$existingImg)){
                Storage::delete('public/prospect_customers/'.$existingImg);
            }
            $completeFileName = $request->file('card_front')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('card_front')->getClientOriginalExtension();
            $compPic = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
            $path = $request->file('card_front')->storeAs('public/prospect_customers', $compPic);
            $customer->card_front = $compPic;
        }
        
        if($request->hasFile('card_back')){
            $existingImg = $customer->card_back;
            if(Storage::exists('public/prospect_customers/'.$existingImg)){
                Storage::delete('public/prospect_customers/'.$existingImg);
            }
            $completeFileName = $request->file('card_back')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('card_back')->getClientOriginalExtension();
            $compPic = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
            $path = $request->file('card_back')->storeAs('public/prospect_customers', $compPic);
            $customer->card_back = $compPic;
        }

        if($customer->save()){
            DB::table('notifications_list')->insert(['code' => config('constants.options._PROSPECT_NOTIFICATION_CODE'), 'message' => 'has been updated as a Prospect Customer', 'prospect_customer_id' => $customer->id, 'created_at' => Auth::user()->id]);
            echo json_encode('success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        if(Storage::exists('public/prospect_customers/'.PC::find($id)->card_front)){
            Storage::delete('public/prospect_customers/'.PC::find($id)->card_front);
        }
        if(Storage::exists('public/prospect_customers/'.PC::find($id)->card_back)){
            Storage::delete('public/prospect_customers/'.PC::find($id)->card_back);
        }
        $status = PC::find($id)->delete();
        echo json_encode($status);
    }

    public function download_sample(){
        return redirect('/sample.xlsx');
    }

    public function upload_excel(Request $request){
        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
         
                $path = $request->file->getRealPath();
                $data = Excel::load($path, function($reader) {
                })->get();
                $data_uploaded = false;
                if(!empty($data) && $data->count()){
                    $counter = 0;
                    $not_upload_able = [];
                    foreach ($data as $key => $value) {
                        //$test = $value->sub_cat;
                        //if(is_numeric($value->sub_cat)){
                            $insert = DB::table('prospect_customers')->insert([
                                'company_name' => $value->company_name,
                                'company_poc' => $value->company_poc,
                                'client_name' => $value->client_name,
                                'mobile_phone' => $value->mobile_phone,
                                'address' => $value->address,
                                'region' => $value->region,
                                'country' => $value->country,
                                'email' => $value->email,
                                'webpage' => $value->webpage,
                                'meeting_minutes' => $value->meeting_minutes,
                                'correspondence' => $value->correspondence,
                                'remarks' => $value->remarks,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                            $data_uploaded = true;
                        // }else{
                        //     $not_upload_able[$counter] = [ 'company_name' => $value->company_name, 'client_name' => $value->client_name, 'company_poc' => $value->company_poc, 'country' => $value->country ];
                        // }
                        $counter ++;
                    }
                    if($data_uploaded){
                        echo json_encode(array('status' => 'success', 'not_upload_able' => $not_upload_able));
                        //return redirect('/products')->with('status', 'Products Added Successfully!');
                    }else{
                        echo json_encode(array('status' => 'failed', 'not_upload_able' => ''));
                        //return redirect('/products')->with('status', 'Failed to add products!');
                    }
                }
            }else {
                echo json_encode(array('status' => 'failed', 'not_upload_able' => ''));
                //return redirect('/products')->with('status', 'Failed to add products!');
            }
        }
    }
}
