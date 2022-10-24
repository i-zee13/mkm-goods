<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Illuminate\Support\Facades\Storage;
use App\Ports as P;
use App\Http\Controllers\Core\AccessRightsAuth;
use File;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ImportPortsExcel;

class DeliveryPorts extends AccessRightsAuth
{
    public $controllerName = "DeliveryPorts";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shipping.ports');
    }

    public function getAllPorts(){
        echo json_encode(P::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function uploadCsvPorts(Request $request){
        //Excel::import(new ImportPortsExcel, request()->file('bulk_upload'));
        //echo json_encode("success");
        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
         
                $path = $request->file->getRealPath();
                $data = Excel::load($path, function($reader) {
                })->get();
                //$data_uploaded = false;
                if(!empty($data) && $data->count()){
                    $counter = 0;
                    $not_upload_able = [];
                    foreach ($data as $key => $value) {
                            if($value['port_code'] == '')
                                break;
                            $insert = DB::table('delivery_ports')->insert([
                                'port_code' => trim($value['port_code']),
                                'port_name'=>trim($value['port_name'])
                            ]);
                            //$data_uploaded = true;
                        $counter ++;
                    }
                   // if($data_uploaded){
                        echo json_encode('success');
                    // }else{
                    //     echo json_encode(array('status' => 'failed', 'not_upload_able' => ''));
                    // }
                }
            }else {
                echo json_encode('failed');
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $port = new P;
        $port->port_code = $request->port_code;
        $port->port_name = $request->port_name;
        if($port->save()){
            echo json_encode("success");die;
        }
        echo json_encode("failed");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo json_encode(DB::table('delivery_ports')->where('id', $id)->first());
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
        $port = P::find($id);
        $port->port_code = $request->port_code;
        $port->port_name = $request->port_name;
        if($port->save()){
            echo json_encode("success");die;
        }
        echo json_encode("failed");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(P::find($id)->delete()){
            echo json_encode("success");die;
        }
        echo json_encode("failed");
    }
}
