<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Illuminate\Support\Facades\Storage;
use App\Supplier as S;
use App\Brands as B;
use Auth;
use App\Http\Controllers\Core\AccessRightsAuth;

class Suppliers extends AccessRightsAuth
{
    public $controllerName = "Suppliers";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('supplier.list');
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

    public function SuppliersList(){
        
        echo json_encode(S::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'supplier_custom_id' => 'required|max:100|unique:supplier',
            'compName' => 'required|max:200',
            'businessPh' => 'required|max:30',
            'poc' => 'required|max:100'
        ]);
        $supplier = new S;
        $supplier->supplier_custom_id = $request->supplier_custom_id;
        $supplier->company_name = $request->compName;
        $supplier->company_poc = $request->poc;
        $supplier->company_job_title = $request->job_title;
        $supplier->business_phone = $request->businessPh;
        $supplier->home_phone = $request->homePh;
        $supplier->mobile_phone = $request->mobPh;
        $supplier->whatsapp_number = $request->whatsappPh;
        $supplier->fax_number = $request->faxPh;
        $supplier->address = $request->address;
        $supplier->city = $request->city;
        $supplier->state = $request->state;
        $supplier->zip = $request->postal;
        $supplier->country = $request->country;
        $supplier->region = $request->region;
        $supplier->email = $request->email;
        $supplier->web_page = $request->webpage;
        $supplier->remarks = $request->remarks;
        $supplier->created_by = Auth::user()->id;
        $test = $request->keyForDocs;

        if($supplier->save()){

            DB::table('notifications_list')->insert(['code' => config('constants.options._SUPPLIER_NOTIFICATION_CODE'), 'message' => 'has been added as a supplier', 'supplier_id' => $supplier->id, 'created_by' => Auth::user()->id]);

            DB::table('supplier_prefs')->where('supplier_key_for_docs', $request->keyForDocs)->update(['supplier_id' => $supplier->id]);

            DB::table('supplier_prefs')->where('supplier_id', $supplier->id)->update(['supplier_key_for_docs' => null]);

            $prodtypes = $request->product_types ? explode(",", $request->product_types) : array();
            foreach($prodtypes as $type){
                DB::table('supplier_prefs')->insert(array('supplier_id' => $supplier->id, 'product_type' => $type));
            }
            echo json_encode('success');
        }
    }

    public function UploadSupplierDocs(Request $request){
        
        $documents = "";
        $key = $request->docRefKey;
        if($request->hasFile('file')){
            $file = $request->file('file');
            $completeFileName = $file->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $randomized = rand();
            $documents = str_replace(' ', '_', $fileNameOnly).'-'.$randomized.'_'.time().'.'.$extension;
            $path = $file->storeAs('public/supplier', $documents);
            !$request->supplier_id ? DB::table('supplier_prefs')->insert(array('supplier_key_for_docs' => $key, 'documents' => $documents)) : DB::table('supplier_prefs')->insert(array('supplier_id' => $request->supplier_id, 'documents' => $documents));
        }
        echo $documents;
    }

    public function RemoveSupplierDoc(Request $request){
        
        $op = $request->op;
        $docKey = $request->docKey;
        if(Storage::exists('public/supplier/'.$request->fileName)){
            Storage::delete('public/supplier/'.$request->fileName);
        }
        DB::table('supplier_prefs')->where('documents', $request->fileName)->delete();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        echo json_encode(array('info' => S::find($id), 'product_types' => DB::table('supplier_prefs')->whereRaw('supplier_id = '.$id.' and product_type IS NOT NULL and product_type != ""')->get(), 'documents' => DB::table('supplier_prefs')->whereRaw('supplier_id = '.$id.' and documents IS NOT NULL and documents != ""')->get(), 'base_url' => URL::to('/')));
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

    public function DeleteDocument($id){

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
            'compName' => 'required|max:200',
            'businessPh' => 'required|max:30',
            'poc' => 'required|max:100'
        ]);
        $supplier = S::find($id);
        $supplier->supplier_custom_id = $request->supplier_custom_id;
        $supplier->company_name = $request->compName;
        $supplier->company_poc = $request->poc;
        $supplier->company_job_title = $request->job_title;
        $supplier->business_phone = $request->businessPh;
        $supplier->home_phone = $request->homePh;
        $supplier->mobile_phone = $request->mobPh;
        $supplier->whatsapp_number = $request->whatsappPh;
        $supplier->fax_number = $request->faxPh;
        $supplier->address = $request->address;
        $supplier->city = $request->city;
        $supplier->state = $request->state;
        $supplier->zip = $request->postal;
        $supplier->country = $request->country;
        $supplier->region = $request->region;
        $supplier->email = $request->email;
        $supplier->web_page = $request->webpage;
        $supplier->remarks = $request->remarks;
        $supplier->updated_by = Auth::user()->id;

        if($supplier->save()){

            DB::table('notifications_list')->insert(['code' => config('constants.options._SUPPLIER_NOTIFICATION_CODE'), 'message' => 'has been updated as a supplier', 'supplier_id' => $supplier->id, 'created_by' => Auth::user()->id]);

            $docs = array();
            DB::table('supplier_prefs')->whereRaw('supplier_id = ' . $id . ' and product_type IS NOT NULL')->delete();
            $prodtypes = $request->product_types ? explode(",", $request->product_types) : array();
            foreach($prodtypes as $type){
                DB::table('supplier_prefs')->insert(array('supplier_id' => $supplier->id, 'product_type' => $type));
            }
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
        
        DB::table('supplier_prefs')->whereRaw('supplier_id = '.$id.' and product_type IS NOT NULL and product_type != ""')->delete();
        
        $imgs = DB::table('supplier_prefs')->select('documents')->whereRaw('supplier_id = '.$id.' and documents IS NOT NULL and documents != ""')->get();
        
        foreach($imgs as $img){
            if(Storage::exists('public/supplier/'.$img->documents)){
                Storage::delete('public/supplier/'.$img->documents);
            }
        }
        DB::table('supplier_prefs')->whereRaw('supplier_id = '.$id.' and documents IS NOT NULL and documents != ""')->delete();
        DB::table('supplier')->where('id', $id)->delete();
        echo json_encode('success');
    }

    public function ProductsAssignment(){
        
        return view('supplier.product_assignment', [ 'suppliers' => S::all() ]);
    }

    public function GetProductBrands($supplierId){
        
        echo json_encode(DB::table('product_brands as pb')->select('id', 'brand_custom_id', 'brand_name', DB::raw('(SELECT count(*) from supplier_brand_assignment where supplier_id = '.$supplierId.' and brand_id = pb.id) as assigned'))->get());
    }

    public function AssignProduct($supplierId, $brandId){
        
        echo json_encode(['status' => DB::table('supplier_brand_assignment')->insert(['supplier_id' => $supplierId, 'brand_id' => $brandId]), 'data' => B::find($brandId)]);
    }

    public function RemoveProductAssignment($supplierId, $brandId){
        
        echo json_encode(DB::table('supplier_brand_assignment')->whereRaw('supplier_id = '.$supplierId.' and brand_id ='. $brandId)->delete());
    }

}
