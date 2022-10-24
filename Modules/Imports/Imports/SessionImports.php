<?php

namespace Modules\Imports\Imports;

use App\Models\BatchSession;
use App\Models\Course;
use App\Models\CourseBatch;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class SessionImports implements ToModel, WithHeadingRow

{

    private $verified       =   false;
    private $rows           =   0;
    private $rowdata        =   [];
    private $session_codes  =   [];
    private $primary_emails =   [];
    private $header         =   [];
    private $errors         =   [];
    /**

     * @param array $row

     *

     * @return \Illuminate\Database\Eloquent\Model|null

     */

    public function model(array $row)
    {
        // dd($row);
        $this->rowdata[]        =   $row;
        ++$this->rows;
        $course_code             =   $row['course_code'];

        $batch_code              =   $row['batch_code'];
        $session_code            =   $row['session_code'];
        // $student_type           =   mb_strtolower($row['student_type']);
        $primary_instructor_code =   $row['primary_instructor_code'];
        $max_students            =   $row['max_students'];
        $sub_instructor_code     =   $row['sub_instructor_code'];
        $start_time              =   $row['start_time'];
        $end_time                =   $row['end_time'];
        $days                    =   $row['days'];
        if ($this->rows == 1) {
            $this->header = array_keys($row);
        }
        $flag       = true;
        $error      = [];


        // Course Code Missing Check
        if (empty($course_code)) {
            $flag   = false;
            $error['course_code']      =   'Course  Code is missing.';
        } else {
            //Check Course Code
            $get_course                    =   Course::whereRaw("lower(course_code) = lower('{$course_code}')")->first();
            if (empty($get_course)) {
                $flag   = false;
                $error['course_code']      =   'Course  Code Not  Found !.';
            }
        }
        // Batch Code Missing Check
        if (empty($batch_code)) {
            $flag   = false;
            $error['batch_code']     =   'Batch  Code is missing.';
        } else {
            $get_course              =   Course::whereRaw("lower(course_code) = lower('{$course_code}')")->first();
            if ($get_course) {
                $get_course_id                 =   $get_course->id;
                $check_batch_code              =   CourseBatch::whereRaw("course_id =" . $get_course_id . " AND lower(batch_code) = lower('{$batch_code}')")->first();
                if (empty($check_batch_code)) {
                    $flag   = false;
                    $error['batch_code']       =   'Batch Code Not  Found !.';
                } else {
                    $get_batch_id              =   $check_batch_code->id;
                    $check_session_code        =   BatchSession::whereRaw("batch_id = '{$get_batch_id}' AND lower(session_code) = lower('{$session_code}')")->first();
                    if ($check_session_code) {
                        $flag   = false;
                        $error['session_code']     =   'Session  Code already exists.';
                    }
                }
            }
        }
        // Session Code Duplicate Check
        // if(!in_array($session_code,$this->session_codes)){
        //     $this->session_codes[]     =   $session_code;
        // }else{
        //     $flag   =   false;
        //     $error['session_code']     =   'Session Code duplicate.';
        // }
        // Session Code Missing Check
        if (empty($session_code)) {
            $flag   = false;
            $error['session_code']     =   'Session  Code is missing.';
        } 

        // Primary Instructor  Missing Check
        if (empty($primary_instructor_code)) {
            $flag   = false;
            $error['primary_instructor_code']  =   'Primary Instructor Code  is missing.';
        } else {
            //Check Primary Code
            $get_instructor_code                    =   Teacher::whereRaw("lower(instructor_code) = lower('{$primary_instructor_code}')")->first();
            if (empty($get_instructor_code)) {
                $flag   = false;
                $error['primary_instructor_code']   =   'Primary Instructor Code Not  Found !.';
            }
        }
        // SUB Instructor  Missing Check
        if (!empty($sub_instructor_code)) {
            //Check SUB Instrcutor
            $get_instructor_code            =   Teacher::whereRaw("lower(instructor_code) = lower('{$sub_instructor_code}')")->first();
            if (empty($get_instructor_code)) {
                $flag   = false;
                $error['sub_instructor_code']   =   'Sub Instructor Code Not  Found !.';
            }
        }

        if ($sub_instructor_code == $primary_instructor_code) {
            $flag   = false;
            $error['sub_instructor_code']   =   'Inustructor Code Already in Primary instrutor List';
        }
        // Max Studes  Missing Check
        if (empty($max_students)) {
            $flag   = false;
            $error['max_students']          =   'Max Students are missing.';
        }
        // Start Time  Missing Check
        if (empty($start_time)) {
            $flag   = false;
            $error['start_time']            =   'Start Time is missing.';
        }
        // End Time  Missing Check
        if (empty($end_time)) {
            $flag   = false;
            $error['end_time']              =   'End Time is missing.';
        }
        // Days Time  Missing Check
        if (empty($days)) {
            $flag   = false;
            $error['days']                  =   'Days Time are missing.';
        }

        if ($flag == false) {
            $this->errors[]  =  [
                'row_no'            =>  $this->rows + 1,
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
