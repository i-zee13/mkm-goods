<?php

namespace App\Http\Controllers;

use App\Models\BatchSession;
use App\Models\BatchSlots;
use App\Models\Course;
use App\Models\CourseBatch;
use App\Models\SessionDay;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Auth;
use DB;

use function GuzzleHttp\json_decode;

class BatchSessionController extends Controller
{

    public function index()
    {
        $courses        =   Course::all();
        $teachers       =   Teacher::all();
       
        return view('course.session',compact('courses','teachers'));
    }
   
    public function store(Request $request)
    {       
       
         $request->validate([
            'course_id'           =>    'required',
            'batch_id'            =>    'required',
            'session_code'        =>    'required',
            'max_students'        =>    'required',
            'start_time'          =>    'required',
            'end_time'            =>    'required',
            'primary_teacher_id'  =>    'required',
         ]);
        //     $data = serialize($request->days);
        //  dd(unserialize($data));
         
         if(BatchSession::where('session_code',$request->session_code)->where('id','!=',$request->hidden_session_id)->first()){
                return response()->json([
                     'msg'   => 'duplicate',
                     'status'=>  'duplicate',
                ]);
         }
        if($request->hidden_session_id){
            $session                     =       BatchSession::where('id',$request->hidden_session_id)->first();
        }else{
            $session                     =       new BatchSession();
        }
         $session->course_id             =       $request->course_id;
         $session->batch_id              =       $request->batch_id;
         $session->session_code          =       $request->session_code;
         $session->max_students          =       $request->max_students;
         $session->start_time            =       $request->start_time;
         $session->end_time              =       $request->end_time;
         $session->primary_teacher_id    =       $request->primary_teacher_id;
         $session->sub_teacher_id        =       $request->sub_teacher_id; 
         $session->delete_status         =       1; 
         $session->created_by            =       Auth::user()->id;  
         $session->updated_by            =       Auth::user()->id;
         if($session->save()){
            if($request->hidden_session_day_id) {
                $session_day             =      SessionDay::where('id',$request->hidden_session_day_id)->first();
            }else{
                $session_day             =       new SessionDay();
            }
            $session_day->course_id      =       $request->course_id;
            $session_day->batch_id       =       $request->batch_id;
            $session_day->session_code   =       $request->session_code;
            $session_day->day            =       json_encode($request->days);
         $session_day->batch_session_id  =       $session->id;
            $session_day->created_by     =       Auth::user()->id;
            $session_day->updated_by     =       Auth::user()->id;
            $session_day->save();
         }
         if($session->id >0){
            return response()->json([
                'msg'       =>  'Session has Created',
                'status'    =>  'success'
            ]);
         }else{
            return response()->json([
                'msg'       =>  'failed',
                'status'    =>  'failed'
            ]);
         }
    }
    public function sessionList()
    {
        $days         =     DB::table('week_days')->get();
        $sessions     =     BatchSession::selectRaw('*,(SELECT course_code FROM course WHERE id = batch_sessions.course_id) as course_code,
                                                        (SELECT day FROM session_days WHERE batch_session_id = batch_sessions.id ) as session_days,
                                                        (SELECT batch_code FROM course_batch  WHERE id = batch_sessions.batch_id ) as batch_code')
                                                        ->get();
        // $sessions          =   collect($sessions)->map(function($x) use($days) {
        //                         $session_id       =   $x->session_days;
        //                         $x->days          =   collect($days)->whereIn('id',explode(',',$session_id))->pluck('day')->implode(',');
        //                         return $x;
        //                         });
         $sessions          =   collect($sessions)->map(function($x) use($days) {
                                    $session_id       =   $x->session_days;
                                    $x->days             =    $session_id;
                                    // $x->days          =   collect($days)->whereIn('id',explode(',',$session_id))->pluck('day')->implode(',');
                                    return $x;
                                    });
        //  $day =  unserialize($sessions->days);

            return response()->json([
                    'msg'       =>  'Sessions list fetched',
                    'status'    =>  'success',
                    'sessions'  =>   $sessions,
                  
            ]);
    }
    public function edit($id)
    {
        $session    =   BatchSession::where('batch_sessions.id',$id)
                                    ->leftjoin('session_days','session_days.batch_session_id','=','batch_sessions.id')
                                    ->select('batch_sessions.*','session_days.day as days','session_days.id as session_day_id')->first();
                                    if($session->days){
                                        $day        =  json_decode($session->days);
                                    }else{
                                        $day =$session->days;
                                    }
        return response()->json([
            'msg'       =>  'Session Fetched',
            'status'    =>  'success',
            'session'   =>   $session,
            'day'   =>   $day

        ]);  
    }
    public function getBatchAgainstCourse($id)
    {  
       $batch       =   CourseBatch::where('course_id',$id)->where('delete_status',1)->get();
       return response()->json([
        'msg'       =>  'Batch has fetched against Course',
        'status'    =>  'success',
        'batch'     =>  $batch
       ]);
    }
    public function getSlotsAgainstBatch($id)
    {  
       $batch_Slots       =   BatchSlots::where('batch_id',$id)->get();
       return response()->json([
        'msg'       =>  'Batch has fetched against Course',
        'status'    =>  'success',
        'batch'     =>  $batch_Slots
       ]);
    }
    public function destroy(Request $request)
    {
        BatchSession::where('id',$request->id)->update([
            'delete_status'            =>  $request->delete_status,
            ]);
        return response()->JSON([
                'status'    =>   'success',
                'msg'       =>   'Batch add to Trash'
        ]);
    }
}
