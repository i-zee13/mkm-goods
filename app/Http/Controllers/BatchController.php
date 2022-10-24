<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Supplier;
use Illuminate\Http\Request;
use Auth;

class BatchController extends Controller
{
    public function index(){
        $suppliers = Supplier::all();
        return view('batch-managment' , compact('suppliers'));
    }
    public function batchList(){
        $batches = Batch::all();
        return $batches;
    }
    public function store( Request $req){
        $batch = new Batch();
        $batch->batch_id = $req->batch_id;
        $batch->batch_manufacturing_date = $req->manufacturing_date;
        $batch->batch_expiry_date = $req->expiry_date;
        $batch->batch_type = $req->batch_type;
        $batch->remarks = $req->remarks;
        $batch->batch_status = $req->batch_status;
        $batch->supplier_id = $req->supplier;
        $batch->created_by = Auth::user()->id;
        $batch->updated_by = Auth::user()->id;
        if($batch->save()){
            return 'success';
        }else{
            return 'failed';
        }
    }
    public function getBatch($id){
        $batch = Batch::find($id);
        return $batch;
    }
    public function updateBatch(Request $req)
    {
        $batch =Batch::find($req->employee_updating_id);
        $batch->batch_id = $req->batch_id;
        $batch->batch_manufacturing_date = $req->manufacturing_date;
        $batch->batch_expiry_date = $req->expiry_date;
        $batch->batch_type = $req->batch_type;
        $batch->remarks = $req->remarks;
        $batch->batch_status = $req->batch_status;
        $batch->supplier_id = $req->supplier;
        $batch->updated_by = Auth::user()->id;
        if(  $batch->save()){
            return 'success';
        }else{
            return 'failed';
        }
    }
    public function deleteBatch($id)
    {
        // delete_status
        $batch = Batch::find($id);
        if($batch->delete()){
            return 'success';
        }else{
            return 'failed';
        }
    }
}
