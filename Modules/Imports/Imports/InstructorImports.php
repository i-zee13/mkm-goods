<?php

namespace Modules\Imports\Imports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;



class InstructorImports implements ToModel, WithHeadingRow

{
    
    private $verified           =   false;
    private $rows               =   0;
    private $rowdata            =   [];
    private $instructor_codes   =   [];
    private $primary_emails     =   [];
    private $header             =   [];
    private $errors             =   [];
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
        $instructor_code        =   $row['instructor_code'];
        $date_of_joining        =   $row['date_of_joining'];
        $acquisition_source     =   $row['acquisition_source'];
        $acquisition_type       =   mb_strtolower($row['acquisition_type']);
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
        $password               =   $row['password'];

        if($this->rows == 1){
            $this->header = array_keys($row);
        }
        $flag       = true;
        $error      = [];
        
        // Instructor Code Duplicate Check
        if(!in_array($instructor_code,$this->instructor_codes)){
            $this->instructor_codes[]      =   $instructor_code;
        }else{
            $flag   =   false;
            $error['instructor_code']      =   'Instructor Code duplicate.';
        }

        // Instructor Code Missing Check
        if (empty($instructor_code)) {
            $flag   = false;
            $error['instructor_code']      =   'Instructor Code is missing.';
        }else{
            $check_instructor_code         =   Teacher::whereRaw("lower(instructor_code) = lower('{$instructor_code}')")->first();
            if($check_instructor_code){
                // $flag = false;
                // $error['student_code']  = 'Instructor Code already exists'; 
            }else{
                $this->rowdata[]        =   $row;
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

        // Email Check
        if($email == '' || $email == null){
            $flag   = false;
            $error['email']             =   'Email is missing.';
        }else{
            // Email Duplicate Check
            if(!in_array($email,$this->primary_emails)){
                $this->primary_emails[] =   $email;
            }else{
                $flag   =   false;
                $error['email']         =   'Email is duplicate.';
            }
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
