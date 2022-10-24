<?php

namespace Modules\Imports\Imports;

use App\Models\BatchSession;
use App\Models\Course;
use App\Models\CourseBatch;
use App\Models\Enrollment;
use App\Models\Teacher;
use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class EnrollmentImports implements ToModel, WithHeadingRow

{
    
    private $rows           =   0;
    private $rowdata        =   [];
    private $uniq_string    =   [];
    private $header         =   [];
    private $errors         =   [];
    /**

     * @param array $row

     *

     * @return \Illuminate\Database\Eloquent\Model|null

     */

    public function model(array $row)
    {
        //   dd($row);
        $this->rowdata[]        =   $row;
      
        ++$this->rows;
        $student_code            =   $row['student_code'];
        $course_code             =   $row['course_code'];
        $batch_code              =   $row['batch_code'];
        $session_code            =   $row['session_code'];
        $enrollment_date         =   $row['enrollment_date'];
        $total_amount            =   $row['total_amount'];
        $net_payable             =   $row['net_payable'];
        if($this->rows == 1){
            $this->header = array_keys($row);
        }
       
        $flag       = true;
        $error      = [];
        $get_course_id = 0;
        $student_id = 0;

        $get_course                  =   Course::whereRaw("lower(course_code) = lower('{$course_code}')")->first();
         // Course Code Missing Check
         if (empty($course_code)) {
            $flag   = false;
            $error['course_code']      =   'Course  Code is missing.';
        }else{
            //Check Course Code
            if($get_course == ''){
                $flag   = false;
                $error['course_code']  =   'Course  Code Not  Found !.';
            }else{
               $get_course_id               =   $get_course->id;                       
            }
        }
         // Enrollment Code Missing Check
         if (empty($session_code)) {
            $flag   = false;
            $error['session_code']     =   'Session Code is missing.';
        }
        // Batch Code Missing Check
        if (empty($batch_code)) {
            $flag   = false;
            $error['batch_code']       =   'Batch  Code is missing.';
        }
         // Max Studes  Missing Check
         if (empty($student_code)) {
            $flag   = false;
            $error['student_code']          =   'Student Code is missing.';
        }
         // Start Time  Missing Check
         if (empty($enrollment_date)) {
            $flag   = false;
            $error['enrollment_date']           =   'Enrollment date is missing.';
        }
         // End Time  Missing Check
         if (empty($total_amount)) {
            $flag   = false;
            $error['total_amount']              =   'Amount is missing.';
        }
         // Days Time  Missing Check
         if (empty($net_payable)) {
            $flag   = false;
            $error['net_payable']               =   'Net Payables  are missing.';
        }
       if($get_course_id > 0){ 
            $batch_id = 0;
            $check_batch_code            =   CourseBatch::whereRaw("course_id =". $get_course_id." AND lower(batch_code) = lower('{$batch_code}')")->first();
            if($check_batch_code == ''){
                $flag   = false;
                $error['batch_code']    =   'Batch  Code Not  Found !.';
            }else{
                $batch_id                =   $check_batch_code->id;                  
            }
            if($batch_id > 0){
                $check_sessinon_code     =   BatchSession::whereRaw("course_id =". $get_course_id." AND batch_id =". $batch_id." AND lower(session_code) = lower('{$session_code}')")->first();
                if($check_sessinon_code == ''){
                    $flag   = false;
                    $error['session_code']    =   'Session  Code Not  Found !.';
                }else{
                    $sessinon_code_id          =   $check_sessinon_code->id;
                    $get_student               =   Student::whereRaw("lower(student_code) = lower('{$student_code}')")->first();
                    if(empty($get_student)){
                        $flag   = false;
                        $error['student_code']   =   'Student Code Not  Found !.';
                    }else{
                        $student_id            =    $get_student->id;
                    }
                    $check_student             =   Enrollment::whereRaw("session_id = '{$sessinon_code_id}' AND student_id = '{$student_id}'")->first();
                    if($check_student){
                        $flag   = false;
                        $error['student_code']     =   'Student  already exists.';
                    }
                }           
             } 
        }
        $str            =   '';
        $str            =  $student_code.$session_code.$course_code.$batch_code ;
        
            // Enrollment Code Duplicate Check
        if(in_array($str,$this->uniq_string) ){
            $flag   =   false;
            $error['student_code']     =   'Student Already Enrolled in this Session.';
        }else{
             // dump($session_code,$student_code);
             $this->uniq_string[]    =  $student_code.$session_code.$course_code.$batch_code ;
        }
       
        
        
        

        if($flag == false){
            $this->errors[]  =  [
                                    'row_no'            =>  $this->rows+1,
                                    'row_data'          =>  $row,
                                    'row_errors'        =>  $error,
                                ];
        }

    }

    public function getRowCount(): int
    {
        
        return $this->rows;
    }
    public function getHeader(): array
    {
        return $this->header;
    }
    public function getData(): array
    {
        return $this->rowdata;
    }
    public function getErrors(): array
    {
        return $this->errors;
    }

}
