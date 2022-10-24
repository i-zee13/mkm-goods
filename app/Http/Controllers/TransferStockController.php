<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransferStockController extends Controller
{
    public function transferStock(){
        return view('stocks.transfer_stock');
    }
}
