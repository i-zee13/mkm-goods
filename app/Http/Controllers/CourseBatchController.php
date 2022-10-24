<?php

namespace App\Http\Controllers;

use App\Models\BatchSlots;
use App\Models\Course;
use App\Models\CourseBatch;
use Illuminate\Http\Request;
use Auth;

class CourseBatchController extends Controller
{
    public function index(){
        $courses    =   Course::all();
        return view('course.batch',compact('courses'));
    }
    public function addBatch(){
        $courses    =   Course::all();
        return view('course.add-batch',compact('courses'));
    }
    public function store(Request $request){
        $request->validate([
            'batch_code'            =>  'required',
            'batch_title'           =>  'required',
            'batch_start_date'      =>  'required',
            'batch_end_date'        =>  'required',
        ]);
        if(CourseBatch::where('batch_code',$request->batch_code)->where('course_id',$request->course_id)->Where('id','!=',$request->hidden_batch_id)->first()){
            return response()->json([
                'msg'       =>  'Batch has Already Exist',
                'status'    =>  'duplicate'
            ]);
        }else{
       
        if($request->hidden_batch_id != '' || $request->hidden_batch_id != null){
            $batch                   =  CourseBatch::where('id',$request->hidden_batch_id)->first();
        }else{
            $batch                   =  new CourseBatch();
        }
       $batch->course_id             =  $request->course_id;
       $batch->batch_code            =  $request->batch_code;
       $batch->batch_title           =  $request->batch_title;
       $batch->grace_period          =  $request->grace_period;
       $batch->batch_start_date      =  Date($request->batch_start_date);
       $batch->batch_end_date        =  Date($request->batch_end_date);
       $batch->enr_start_date        =  Date($request->enrollment_start_date);
       $batch->enr_end_date          =  Date($request->enrollment_end_date);
       $batch->grace_period          =  $request->grace_period;
       $batch->eb_discount           =  $request->eb_discount;
       $batch->eb_max_days           =  $request->eb_max_days;
       $batch->status                =  $request->batch_status;
       $batch->batch_price           =  $request->batch_price;
       $batch->total_sessions        =  $request->total_sessions;
       $batch->created_by            =  Auth::user()->id;
       $batch->updated_by            =  Auth::user()->id;
       $batch->delete_status         =  1;
       $batch->batch_description           =  $request->batch_description;
       $batch->batch_duration_in_months    =  $request->batch_duration;
       $batch->session_duration_in_minutes   =  $request->session_duration;
       if($batch->save()){
        if ($request->multiple_slots){
            foreach ($request->multiple_slots as $slot) {
              
                if($slot['slot_id'] > 0){
                    $batch_slot            =    BatchSlots::where('id',$slot['slot_id'])->first();
                }else{
                     $batch_slot           =    new BatchSlots();
                }
                   $batch_slot->start_time =     date("H:i", strtotime($slot['start_time']));
                   $batch_slot->end_time   =     date("H:i", strtotime($slot['end_time']));
                   $batch_slot->batch_id   =     $batch->id;
                   $batch_slot->created_by =     Auth::user()->id;
                   $batch_slot->updated_by =     Auth::user()->id;
                   $batch_slot->save();
                   $batch_slot_ids[]       =     $batch_slot->id;
                  
            }
          
            BatchSlots::where('batch_id',$request->hidden_batch_id)
                       ->whereNotIn('batch_slots.id',$batch_slot_ids)->delete();
        }

        return response()->json([
            'msg'       =>  'Batch has been added',
            'status'    =>  'success'
        ]);
       }else{
        return response()->json([
            'msg'       =>  'failed',
            'status'    =>  'failed'
        ]);
       }
            
    }
            
    }
    public function batchList(){
        $batches    =   CourseBatch::leftjoin('course','course.id','=','course_batch.course_id')
                                    ->select('course_batch.*','course.course_code as course_code')
                                    ->get();
        return  response()->json([
            'msg'       =>  'Batches Fetched',
            'status'    =>  'success',
            'batches'   =>  $batches,
        ]);
    }
    public function batchStatusChange(Request $request){
           CourseBatch::where('id',$request->id)->update([
                'status'            =>  $request->batch_status,
                ]);
        return response()->JSON([
            'status'            =>   'success',
            'msg'               =>   'status_change'
        ]);
    }
    public function edit($id){
        $batch        =   CourseBatch::where('course_batch.id',$id)
                                    ->leftjoin('course','course.id','=','course_batch.course_id')
                                    ->select('course_batch.*','course.course_code as course_code')
                                    ->first();
        $batch_slots  =   BatchSlots::where('batch_id',$id)->get();
        $courses      =   Course::all();

        return view('course.edit-batch',compact('courses','batch','batch_slots'));
    }
    public function getBatch($id){
        $batch     =    CourseBatch::where('course_batch.id',$id)
                        ->leftjoin('course','course.id','=','course_batch.course_id')
                        ->select('course_batch.*','course.course_code as course_code')
                        ->first();
        // $batch_slots = BatchSlots::where('batch_id',$id)->get();
        
            return response()->json([
                'msg'       =>  'Batch fetch for edit',
                'status'    =>  'success',
                'batch'     =>  $batch,   
            ]);
    }
    public function getBatchSlots($id){
         
        $batch_slots = BatchSlots::where('batch_id',$id)->get();
        // $start_time   = date('h:i a', strtotime($batch_slots->start_time));
       
            return response()->json([
                'msg'           =>  'Batch Slots fetch for edit',
                'status'        =>  'success',
                'batch_slots'   =>  $batch_slots,   
              
            ]);
    }
    public function delteBatch(Request $request)
    {
        CourseBatch::where('id',$request->id)->update([
            'delete_status'            =>  $request->delete_status,
            ]);
        return response()->JSON([
                'status'    =>   'success',
                'msg'       =>   'Batch add to Trash'
        ]);
    }
}
