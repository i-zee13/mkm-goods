<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use DB;
use Auth;

class PNLController extends AccessRightsAuth
{

    public function index(){
        return view('pnl.pnl');
    }

    public function GetPendingOrders(){
        $query = json_decode(json_encode(\App\CustomerAssignment::where('employee_id', Auth::user()->id)->get()), TRUE);
        $query = $query ? implode(",", array_column($query, "customer_id")) : null;
        $query = $query ? "customer_id IN ($query)" : "customer_id > 0";

        $orders = DB::table('orders as o')->selectRaw('id, issue_date, invoice_num, (Select company_name from customers where id = o.customer_id) as customer_name, current_status')->whereRaw('LOWER(current_status) = "completed" AND total_cost IS NULL')->whereRaw($query)->get();

        $entered_orders = DB::table('orders as o')->selectRaw('id, issue_date, invoice_num, (Select company_name from customers where id = o.customer_id) as customer_name, current_status, FORMAT(total_cost, 0) as total_cost')->whereRaw('LOWER(current_status) = "completed" AND total_cost IS NOT NULL')->get();

        //Completed Orders
        $stat = DB::table('orders')->selectRaw('(Select count(*) from orders where LOWER(current_status) = "completed" AND total_cost IS NOT NULL) as total_invoices, SUM(total_amount) as total_amount, SUM(total_cost) as total_cost')->whereRaw('LOWER(current_status) = "completed" AND total_cost IS NOT NULL')->first();

        echo json_encode(array('orders' => $orders, 'entered_orders' => $entered_orders, 'stat' => $stat));
    }

    public function getInvoiceForPnl($id){
        $core = DB::table('orders as o')->selectRaw('id, issue_date, currency_symbol, invoice_num, (Select company_name from customers where id = o.customer_id) as customer_name, current_status, (Select SUM(amount) from order_contents where order_id = o.id) as order_value, currency')->where('id', $id)->first();

        $content = DB::table('order_contents as oc')->selectRaw('id, (Select name from brand_related_products where id = oc.product_id) as pro_name, qty, unit_price')->where('order_id', $id)->get();
        echo json_encode(array('core' => $core, 'content' => $content));
    }


    //Single Item
    //Removed
    public function add_cost_price($id, Request $request){
        try{
            DB::table('order_contents')->where('id', $id)->update([
                'pkr_unit_price' => $request->price,
                'cost' => $request->quantity * $request->cost_price,
                'exchange_rate' => $request->exchange_rate,
                'profit_loss' => $request->quantity * $request->profit_loss
            ]);

            $check = DB::table('order_contents as oc')->whereRaw('order_id = (Select order_id from order_contents where id = '.$id.') AND cost IS NULL')->first();
            $sum = DB::table('order_contents')->selectRaw('SUM(cost) as sum')->whereRaw('order_id IN (Select order_id from order_contents where id = '.$id.')')->first();
            if($check){
                //200 success but some coloumns are null
                echo json_encode('200');
            }else{
                DB::table('orders')->whereRaw('id = (Select order_id from order_contents where id = '.$id.')')->update([
                    'total_cost' => $sum->sum
                ]);
                //201 success (this invoice is entered)
                echo json_encode('201');
            } 
        }catch(\Illuminate\Database\QueryException $ex){ 
            echo json_encode('400'); 
        }
    }

    public function add_bulk_cost_price(Request $request){
        $total_cost = 0;
        $for_core_id = 0;
        $test = $request->data;
        try{
            foreach($request->data as $data){
                DB::table('order_contents')->where('id', $data['id'])->update([
                    'pkr_unit_price' => $data['price'],
                    'cost' => $data['quantity'] * $data['cost_price'],
                    'exchange_rate' => $data['exchange_rate'],
                    'profit_loss' => $data['profit_loss']
                ]);
                $total_cost += ($data['quantity'] * $data['cost_price']);
                $for_core_id = $data['id'];
            }
            DB::table('orders')->whereRaw('id = (Select order_id from order_contents where id = '.$for_core_id.')')->update([
                'total_cost' => $total_cost
            ]);
            echo json_encode('201');
        }catch(\Illuminate\Database\QueryException $ex){ 
            echo json_encode('400'); 
        }
    }

    public function save_pnl(Request $request){
        $check = DB::table('pnl_history')->whereRaw('YEAR(created_at) = '.date('Y').' And MONTH(created_at) = '.date('m'))->first();
        if($check){
            try{
                $update = DB::table('pnl_history')->where('id', $check->id)->update([
                    'total_invoices' => $request->ttl_inv,
                    'total_revenue' => $request->ttl_rev,
                    'total_cost' => $request->ttl_cost,
                    'gross_profit' => $request->gp,
                    'net_profit' => $request->np,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
                echo json_encode('success');
            }catch(\Illuminate\Database\QueryException $ex){ 
                echo json_encode('failed'); 
            }
        }else{
            $insert = DB::table('pnl_history')->insert([
                'total_invoices' => $request->ttl_inv,
                'total_revenue' => $request->ttl_rev,
                'total_cost' => $request->ttl_cost,
                'gross_profit' => $request->gp,
                'net_profit' => $request->np,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id
            ]);
            if($insert){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }
    }


    public function reports(){
        return view('pnl.reports');
    }

    public function GetPNLRepports(){
        $year = date('Y');
       // echo json_encode(DB::table('pnl_history')->selectRaw('id, total_invoices, total_revenue, total_cost, gross_profit, net_profit, MONTHNAME(created_at) as month_name, Year(created_at) as year, Month(created_at) as month')->get());
        echo json_encode(DB::select("SELECT MONTH(created_at) as month, MONTHNAME(created_at) as month_name, Year(created_at) as year, count(*) as total_invoices, SUM(total_amount) as total_amount, SUM(total_cost) as total_cost, (SELECT SUM(profit_loss) from order_contents where order_id = orders.id) as profit_loss FROM orders
        where total_cost IS NOT NULL AND Year(created_at) = $year
        group by MONTH(created_at)"));



    }

    public function pnl_history(){
        echo 'history';
    }
}
