<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use DB;
use App\ShippingCompany as SC;
use File;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class Shipping extends AccessRightsAuth
{
    private $controllerName = "Shipping";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shipping.list');
    }
    
    public function getShippingCompanies()
    {
        

        echo json_encode(SC::all());
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sc = new SC;
        $sc->company_name = $request->company_name;
        $sc->poc = $request->poc;
        $sc->address = $request->address;
        $sc->city = $request->city;
        $sc->phone = $request->phone;
        $sc->fax = $request->fax;
        $sc->email = $request->email;
        $sc->website = $request->website;
        $sc->country = $request->country;
        $sc->created_by = Auth::user()->id;
        if($sc->save()){
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
        echo json_encode(SC::find($id));
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
        $sc = SC::find($id);
        $sc->company_name = $request->company_name;
        $sc->poc = $request->poc;
        $sc->address = $request->address;
        $sc->city = $request->city;
        $sc->phone = $request->phone;
        $sc->fax = $request->fax;
        $sc->email = $request->email;
        $sc->website = $request->website;
        $sc->country = $request->country;
        $sc->updated_by = Auth::user()->id;
        if($sc->save()){
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
        if(SC::find($id)->delete()){
            echo json_encode("success");die;
        }
        echo json_encode("failed");
    }

    public function download_sample_shipper(){
        return redirect('/sample_shipping.xlsx');
    }

    public function upload_excel_shipping(Request $request){
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
                            $insert = DB::table('shipping_company')->insert([
                                'company_name' => $value->company_name,
                                'poc' => $value->poc,
                                'city' => $value->city,
                                'address' => $value->address,
                                'phone' => $value->phone,
                                'country' => $value->country,
                                'email' => $value->email,
                                'website' => $value->website,
                                'fax' => $value->fax,
                                'bulk_upload' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => Auth::user()->id
                            ]);
                            $data_uploaded = true;
                        // }else{
                        //     $not_upload_able[$counter] = [ 'company_name' => $value->company_name, 'poc' => $value->poc, 'email' => $value->email, 'country' => $value->country ];
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
