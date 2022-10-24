<?php

namespace Modules\Imports\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;



class StudentImports implements ToModel, WithHeadingRow

{
    
    private $verified       =   false;
    private $rows           =   0;
    private $rowdata        =   [];
    private $student_codes  =   [];
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
        // $this->rowdata[]        =   $row;
        ++$this->rows;
        $student_code           =   $row['student_code'];
        $student_type           =   mb_strtolower($row['student_type']);
        $primary_student_code   =   $row['primary_student_code'];
        $acquisition_source     =   $row['acquisition_source'];
        $acquisition_type       =   mb_strtolower($row['acquisition_type']);
        $relation               =   $row['relation'];
        $first_name             =   $row['first_name'];
        $middle_name            =   $row['middle_name'];
        $last_name              =   $row['last_name'];
        $gender                 =   $row['gender'];
        $dob                    =   $row['dob'];
        $houseunit_number       =   $row['houseunit_number'];
        $address                =   $row['address'];
        $primary_cell_phone     =   $row['primary_cell_phone'];   
        $secondary_phone        =   $row['secondary_phone'];
        $whatsapp_number        =   $row['whatsapp_number'];
        $postal_code            =   $row['postal_code'];
        $city                   =   $row['city'];
        $state_province         =   $row['state_province'];
        $country                =   $row['country'];
        $email                  =   $row['email'];
        $user_name              =   $row['user_name'];
        $password               =   $row['password'];

        if($this->rows == 1){
            $this->header = array_keys($row);
        }
        $flag       = true;
        $error      = [];
        
        // Student Code Duplicate Check
        if(!in_array($student_code,$this->student_codes)){
            $this->student_codes[]      =   $student_code;
        }else{
            $flag   =   false;
            $error['student_code']      =   'Student Code duplicate.';
        }
        // if (empty($password)) {
        //     $flag   = false;
        //     $error['password']          =   'Password is missing.';
        // }

        // Student Code Missing Check
        if (empty($student_code)) {
            $flag   = false;
            $error['student_code']      =   'Student Code is missing.';
        }else{
            $check_student_code         =   Student::whereRaw("lower(student_code) = lower('{$student_code}')")->first();
            if($check_student_code){
                // $flag = false;
                // $error['student_code']  = 'Student Code already exists'; 
            }else{
                $this->rowdata[]        =   $row;
            }
        }

        // Student Type
        if(empty($student_type)){
            $flag   = false;
            $error['student_type']      =   'Student Type is missing.';
        }else{
            $student_type_error = 'inn';
            if($student_type    ==   'primary'){
                $student_type_error = 'primary';
            }
            if($student_type    == 'secondary'){
                $student_type_error   =   'secondary';
            }
            if($student_type_error == 'inn'){
                $flag = false;
                $error['student_type']   =   'Student Type not found.'; 
            }
        }

        // Acquisition Source 
        if (empty($acquisition_source)) {
            $flag   = false;
            $error['acquisition_source']    =   'Acquisition Source is missing.';
        }

        // Acquisition type 
        if (empty($acquisition_type)) {
            $flag   = false;
            $error['acquisition_type']      =   'Acquisition Type is missing.';
        }else{
            
            $acquisition_type_error = 'inn';
            if($acquisition_type    ==   'online'){
                $acquisition_type_error = 'online';
            }
            if($acquisition_type    == 'referral'){
                $acquisition_type_error   =   'referral';
            }
            if($acquisition_type    == 'walk in'){
                $acquisition_type_error   =   'walk in';
            }
            if($acquisition_type    == 'print media'){
                $acquisition_type_error   =   'print media';
            }
            if($acquisition_type    == 'other'){
                $acquisition_type_error   =   'other';
            }
            if($acquisition_type_error == 'inn'){
                $flag = false;
                $error['acquisition_type']      =   'Acquisition Type not found.'; 
            }
        }

        // Relationship Check if Student Type is Secondary 
         if($student_type == 'secondary' && ($relation == '' || $relation == null)){
            $flag   = false;
            $error['relation']  =   'Relation is missing.';
        }

        // Primary Student Code Check if Student Type is Secondary 
        if($student_type == 'secondary' && ($primary_student_code == '' || $primary_student_code == null)){
            $flag   = false;
            $error['primary_student_code']  =   'Primary Student Code is missing.';
        }

        // Email Check against if Student Type is Primary
        if($student_type == 'primary' && ($email == '' || $email == null)){
            $flag   = false;
            $error['email']             =   'Email is missing.';
        }

        // Email Duplicate check if Student Type is Primary
        if($student_type == 'primary' && ($email != null || $email != '')){
            if(!in_array($email,$this->primary_emails)){
                $this->primary_emails[] =   $email;
            }else{
                $flag   =   false;
                $error['email']         =   'Email duplicate.';
            }
        }

        // Username Check if Student Type is Secondary 
        if($student_type == 'secondary' && ($user_name == '' || $user_name == null)){
            $flag   = false;
            $error['user_name']         =   'Username is missing.';
        }
        
        // First Name 
        if (empty($first_name)) {
            $flag   = false;
            $error['first_name']        =   'First Name is missing.';
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
