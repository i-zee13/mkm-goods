<?php
namespace App\Http\Controllers;

use App\Ports as P;
use Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class ImportPortsExcel implements ToModel
{
    /**
     * @param array $row
     *
     */
    public function model(array $row)
    {
        if($row[0] !== "Port Code"){
            $data = array(
                array('port_code'=>trim($row[0]), 'port_name'=>trim($row[1]))
            );
            P::insert($data);
        }
    }
}
