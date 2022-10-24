<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\AccessRightsAuth;
use App\Integrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class IntegrationController extends AccessRightsAuth
{
    //
    public function index(){
        $integrations   =   Integrations::all();
        return view("integrations.index",compact("integrations"));
    }


    public function show($id){
        $integration   =   Integrations::find($id);
        return view("integrations.view",compact("integration"));
    }


    public function edit($id){
        //return view("integrations.edit");
    }


    public function update(Request $request ,$id){
            if(in_array(strtolower($request->status),['active','inactive']) && in_array(strtolower($request->mode),['live','demo'])){
                $mode       =   strtolower($request->mode);
                $inputs     =   $request->all();
                if(strtolower($request->status) == 'active'){
                    if(strtolower($request->section) == 'email'){
                        if(empty($inputs[$mode]['api_key'])){
                            return response()->json([
                                'status' =>  'error',
                                'msg'    =>  ucfirst($mode)." API key is missing ."
                            ]);
                        }
                        if(empty($inputs[$mode]['sender_name'])){
                            return response()->json([
                                'status' =>  'error',
                                'msg'    =>  ucfirst($mode)." sender name is missing ."
                            ]);
                        }
                        if(empty($inputs[$mode]['sender_email'])){
                            return response()->json([
                                'status' =>  'error',
                                'msg'    =>  ucfirst($mode)." sender email is missing ."
                            ]);
                        }
                    }elseif(strtolower($request->section) == 'payment'){
                        return response()->json([
                            'status' =>  'error',
                            'msg'    =>  "payment integartion is not developed yet."
                        ]);

                    }else{
                        return response()->json([
                            'status' =>  'error',
                            'msg'    =>  "Please provide valid section."
                        ]);
                    }
                }else{ //in active
                    if(strtolower($request->section) == 'payment'){
                        return response()->json([
                            'status' =>  'error',
                            'msg'    =>  "payment integartion is not developed yet."
                        ]);

                    }
                }
                //after validation update script
                $integration    =   Integrations::find($id);
                //dd($request->status,$inputs['live']['api_key']);
                if($integration){
                    try {
                        $integration->status        =   strtolower($request->status);
                        $integration->mode          =   strtolower($request->mode);
                        $integration->setting       =   json_encode(['live' => $inputs['live'], 'demo' => $inputs['demo']]);
                        $integration->updated_by    =   Auth::user()->id;
                        $integration->updated_at    =   date('Y-m-d H:i:s');
                        $integration->save();
                        if($integration->status == 'active'){
                            $api_key    =   $integration->status == 'active' ? ($request->mode == 'live' ?    $inputs['live']['api_key'] : $inputs['demo']['api_key']) : '';
                            $path = base_path('.env');
                            if (file_exists($path)) {
                                file_put_contents($path, str_replace(
                                    'SES_SECRET='.env('SES_SECRET'), 'SES_SECRET='.$api_key, file_get_contents($path)
                                ));
                                Artisan::call('config:clear');
                                Artisan::call('cache:clear');
                            }
                        }
                        return response()->json([
                            'status' => 'success',
                            'msg' => ucfirst($integration->type) . " integration has been updated successfully."
                        ]);
                    }catch (\Illuminate\Database\QueryException $ex) {
                        return response()->json([
                            'status' => 'error',
                            'msg' => $ex
                        ]);
                    }

                }else{
                    return response()->json([
                        'status' =>  'error',
                        'msg'    =>  "Something went wrong.Please refresh your page."
                    ]);
                }

            }else{
                return response()->json([
                            'status' =>  'error',
                            'msg'    =>  "Please provide all the Required information."
                        ]);
            }
    }
}
