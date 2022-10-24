<?php

namespace Modules\Imports\Http\Controllers;

use App\Models\BatchSession;
use App\Models\Course;
use App\Models\CourseBatch;
use App\Models\Enrollment;
use App\Models\Invoice;
use App\Student;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Imports\Imports\EnrollmentImports;
use Illuminate\Support\Str;

class EnrollmentImportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $page['page_header']    =   'Enrollments';
        $page['url']            =   '/import-enrollments';
        $page['sample-url']     =   'enrollment_sample.xlsx';
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
        $import     =   new EnrollmentImports();
        Excel::import($import,$request->file);
        if($import->getRowCount() > 0) {
            if (@count($import->getErrors()) > 0) {
                return Response()->json([
                    'status'    => 'error',
                    'msg'       => 'Invalid Data',
                    'errors'    =>  $import->getErrors(),
                    'header'    =>  $import->getHeader()
                ]);
            }else{
                foreach($import->getData() as $row){
                    $student_code            =   $row['student_code'];
                    $course_code             =   $row['course_code'];
                    $batch_code              =   $row['batch_code'];
                    $session_code            =   $row['session_code'];
                    $enrollment_date         =   Date::excelToDateTimeObject($row['enrollment_date']);
                    $total_amount            =   $row['total_amount'];
                    $net_payable             =   $row['net_payable'];

                    //Get student ID
                    $student                 =    Student::where('student_code',$student_code)->first();
                    $student_id              =    $student->id;
                    //Get Course ID
                    $course                  =   Course::where('course_code',$course_code)->first();
                    $course_id               =   $course->id;
                    $course_duration         =   $course->course_duration;
                    //Get Batch ID 
                    $batch                   =   CourseBatch::whereRaw("course_id =". $course_id." AND lower(batch_code) = lower('{$batch_code}')")->first();
                    $batch_id                =   $batch->id;
                    $batch_start_date        =   $batch->batch_start_date;
                    $batch_end_date          =   $batch->batch_end_date;
                  
                    //Get Session ID
                    $session                 =   BatchSession::whereRaw("course_id =". $course_id." AND batch_id =". $batch_id." AND lower(session_code) = lower('{$session_code}')")->first();
                    $session_id              =   $session->id;

                    $enrollment                   =  new Enrollment();
                    $enrollment->student_id       =  $student_id;
                    $enrollment->course_id        =  $course_id;
                    $enrollment->batch_id         =  $batch_id;
                    $enrollment->session_id       =  $session_id;
                    $enrollment->course_duration  =  $course_duration;
                    $enrollment->batch_start_date =  $batch_start_date;
                    $enrollment->batch_end_date   =  $batch_end_date;
                    // dd( $enrollment->batch_end_date,  $enrollment->batch_start_date);
                    $enrollment->enrollment_date  =  $enrollment_date;
                    $enrollment->created_method   =  3; //Bulk
                    $enrollment->created_by       =  Auth::user()->id;                    
                    $enrollment->updated_by       =  Auth::user()->id;                    
                    $enrollment->save();
                    // $invoice_id   =     'SCA-'.str::random(9);
                    // $invoice                      =     new Invoice();
                    // $invoice->invoice_id          =      $invoice_id;
                    // $invoice->invoice_id          =      $invoice_id;

                    // dd($unique_key);
                    // $enrollment->total_amount     =  $total_amount;
                    // $enrollment->net_payable      =  $net_payable;
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
