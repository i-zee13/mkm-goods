<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{

    public function index(){
      
        return view('enrollment.index');
    }
    public function enrollmentList(){
        $enrollment    = Enrollment::leftjoin('course','course.id','=','enrollments.course_id')
                                        ->leftjoin('students','students.id','=','enrollments.student_id')
                                        ->leftjoin('course_batch','course_batch.id','=','enrollments.batch_id')
                                        ->leftjoin('batch_sessions','batch_sessions.id','=','enrollments.session_id')
                                        ->select('enrollments.*','students.student_code','course_batch.batch_code','batch_sessions.session_code','course.course_code')
                                        ->get();
        return response()->json([
            'msg'           =>  'Enollments Fetched',
            'status'        =>  'success',
            'enrollment'    =>  $enrollment,
        ]);

    }
}
