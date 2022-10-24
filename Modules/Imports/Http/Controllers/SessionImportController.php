<?php

namespace Modules\Imports\Http\Controllers;

use App\Models\BatchSession;
use App\Models\Course;
use App\Models\CourseBatch;
use App\Models\SessionDay;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Imports\Imports\SessionImports;
use PhpOffice\PhpSpreadsheet\Shared\Date;
 


class SessionImportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $page['page_header']    =   'Sessions';
        $page['url']            =   '/import-sessions';
        $page['sample-url']     =   'session_sample.xlsx';
        return view('imports::index',compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('imports::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        ini_set('memory_limit', '3000M');
        ini_set('max_execution_time', '0');
        $request->validate([
            'file'  => 'required|file|mimes:xls,xlsx'
        ]);
        $import     =   new SessionImports();
      
        Excel::import($import,$request->file);
        if($import->getRowCount() > 0) {
            if ($import->getErrors()) {
                return Response()->json([
                    'status'    => 'error',
                    'msg'       => 'Invalid Data',
                    'errors'    =>  $import->getErrors(),
                    'header'    =>  $import->getHeader()
                ]);
            }else{  
                foreach($import->getData() as $row){
                    
                    $course_code             =   $row['course_code'];
                    $batch_code              =   $row['batch_code'];
                    $session_code            =   $row['session_code'];
                    $primary_instructor_code =   $row['primary_instructor_code'];
                    $max_students            =   $row['max_students'];
                    $sub_instructor_code     =   $row['sub_instructor_code'];
                    $start_time              =   Date::excelToDateTimeObject($row['start_time']);
                    $end_time                =   Date::excelToDateTimeObject($row['end_time']);
                    $days                    =   $row['days'];
                  

                    //Checking Batch iF Exisit on Behalf Courses
                    $get_course              =   Course::whereRaw("lower(course_code) = lower('{$course_code}')")->first();
                    $get_course_id           =   $get_course->id;                       
                    $check_batch_code        =   CourseBatch::whereRaw("course_id =". $get_course_id." AND lower(batch_code) = lower('{$batch_code}')")->first();
                    if($check_batch_code){
                        $batch_id            =   $check_batch_code->id;
                    }
                    // }else{
                    //     $batch               =     new CourseBatch();
                    //     $batch->course_id    =     $get_course_id;
                    //     $batch->batch_code   =     $batch_code;
                    //     $batch->batch_title  =     $session_code;
                    //     $batch->created_by   =     Auth::user()->id;
                    //     $batch->updated_by   =     Auth::user()->id;
                    //     if($batch->save()){
                    //         $batch_id        =      $batch->id;
                    //     }
                    // }
                    //Converting Days into Number Array
                    $days = explode(',', $days);  
                    $day_array    =   [];
                    foreach($days as $day){
                    
                       $day_id = DB::table('week_days')->orWhere('day', 'like', '%' .$day . '%')->first();
                       $day_array[] =   $day_id->id;
                    }
                    // $day = implode(',', $day_array);
                    $day = json_encode($day_array);
                    // $days = json_decode($day);
                    $primary_instructor           =      Teacher::where('instructor_code',$primary_instructor_code)->first();
                    $primary_instructor_id        =      $primary_instructor->id;

                    $sub_instructor               =      Teacher::where('instructor_code',$sub_instructor_code)->first();
                    $sub_instructor_id            =      $sub_instructor->id;

                    $session                      =      new  BatchSession();
                    $session->course_id           =      $get_course_id;
                    $session->batch_id            =      $batch_id;
                    $session->primary_teacher_id  =      $primary_instructor_id;
                    $session->sub_teacher_id      =      $sub_instructor_id;
                    $session->session_code        =      $session_code;
                  
                    $session->max_students        =      $max_students;
                    $session->start_time          =      $start_time;
                    $session->end_time            =      $end_time;
                    $session->delete_status       =      1;
                    $session->created_by          =      Auth::user()->id;

                    if($session->save()){
                        $session_day                      =      new SessionDay();
                        $session_day->day                 =      $day;  
                        $session_day->course_id           =      $get_course_id;
                        $session_day->batch_id            =      $batch_id;
                     
                        $session_day->batch_session_id    =      $session->id;
                        $session_day->session_code        =      $session_code;
                        $session_day->created_by          =      Auth::user()->id;
                        $session_day->save();
                        }
                }
                return Response()->json([
                    'status' => 'success',
                    'msg'    => 'Uploaded Successfully',
                    'rows'   =>  $import->getRowCount()
                ]);
            }
    }else{
        return Response()->json([
            'status' => 'error',
            'msg' => 'Empty file.'
        ]);
    }
}

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('imports::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('imports::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
