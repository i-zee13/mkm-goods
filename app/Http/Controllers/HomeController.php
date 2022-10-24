<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;

use Auth;

class HomeController extends AccessRightsAuth
{
    public $controllerName = "HomeController";

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
       error_reporting(0);
        return view('home');//->with('data', $data)->with('activities', $activities)->with('my_designation_rights', $my_designation_rights);
    }

    public function view_all_activities(){
        return view('includes.view_all_activities', ['users' => DB::table('users')->get()]);
    }

    public function GetActivities(Request $request){
        $yesterday = date("j", strtotime("yesterday"));
        $current_month = date('m');
        $last_month = (date('m') == 1 ? 12 : date('m') - 1);
        $current_year = date('Y');
        $today = date('d');

        $query_for_order = ($request->date == 0 ? 'id > 0' : ($request->date == 1 ? "Day(created_at) = $yesterday AND Month(created_at) = $current_month AND Year(created_at) = $current_year OR Day(updated_at) = $yesterday AND Month(updated_at) = $current_month AND Year(updated_at) = $current_year OR Day(completed_at) = $yesterday AND Month(completed_at) = $current_month AND Year(completed_at) = $current_year OR Day(processed_at) = $yesterday AND Month(processed_at) = $current_month AND Year(processed_at) = $current_year" : ($request->date == 2 ? "Day(created_at) = $today AND Month(created_at) = $current_month AND Year(created_at) = $current_year OR Day(updated_at) = $today AND Month(updated_at) = $current_month AND Year(updated_at) = $current_year OR Day(completed_at) = $today AND Month(completed_at) = $current_month AND Year(completed_at) = $current_year OR Day(processed_at) = $today AND Month(processed_at) = $current_month AND Year(processed_at) = $current_year" : ($request->date == 3 ? "Month(created_at) = $current_month AND Year(created_at) = $current_year OR Month(updated_at) = $current_month AND Year(updated_at) = $current_year OR Month(completed_at) = $current_month AND Year(completed_at) = $current_year OR Month(processed_at) = $current_month AND Year(processed_at) = $current_year" : ($request->date == 4 ? "Month(created_at) = $last_month AND Year(created_at) = $current_year OR Month(updated_at) = $last_month AND Year(updated_at) = $current_year OR Month(completed_at) = $last_month AND Year(completed_at) = $current_year OR Month(processed_at) = $last_month AND Year(processed_at) = $current_year" : "DATE(created_at) BETWEEN '$request->start_date' AND '$request->end_date' OR DATE(updated_at) BETWEEN '$request->start_date' AND '$request->end_date' OR DATE(completed_at) BETWEEN '$request->start_date' AND '$request->end_date' OR DATE(processed_at) BETWEEN '$request->start_date' AND '$request->end_date'")))));

        $query_date = ($request->date == 0 ? 'id > 0' : ($request->date == 1 ? "Day(created_at) = $yesterday AND Month(created_at) = $current_month AND Year(created_at) = $current_year OR Day(updated_at) = $yesterday AND Month(updated_at) = $current_month AND Year(updated_at) = $current_year" : ($request->date == 2 ? "Day(created_at) = $today AND Month(created_at) = $current_month AND Year(created_at) = $current_year OR Day(updated_at) = $today AND Month(updated_at) = $current_month AND Year(updated_at) = $current_year" : ($request->date == 3 ? "Month(created_at) = $current_month AND Year(created_at) = $current_year OR Month(updated_at) = $current_month AND Year(updated_at) = $current_year" : ($request->date == 4 ? "Month(created_at) = $last_month AND Year(created_at) = $current_year OR Month(updated_at) = $last_month AND Year(updated_at) = $current_year" : "DATE(created_at) BETWEEN '$request->start_date' AND '$request->end_date' OR DATE(updated_at) BETWEEN '$request->start_date' AND '$request->end_date'")))));

        
        $activities = [
            'orders' => DB::table('orders as o')->selectRaw('id, (Select company_name from customers where id = o.customer_id) as customer_name, total_amount, currency, employee_id as created_by_id, updated_by as updated_by_id, completed_by as completed_by_id, processed_by as processed_by_id, Date(created_at) as created_at, Date(updated_at) as updated_at, Date(completed_at) as completed_at, Date(processed_at) as processed_at, (Select name from users where id = o.employee_id) as created_by, (Select name from users where id = o.updated_by) as updated_by, (Select name from users where id = o.processed_by) as processed_by, (Select name from users where id = o.completed_by) as completed_by ')->whereRaw($query_for_order)->get(),

            'items' => DB::table('product_related_items as pi')->selectRaw('id, name, product_sku, (Select name from brand_related_products where sku = pi.product_sku) as product_name, created_by as created_by_id, updated_by as updated_by_id, Date(created_at) as created_at, Date(updated_at) as updated_at, (Select name from users where id = pi.created_by) as created_by, (Select name from users where id = pi.updated_by) as updated_by ')->whereRaw($query_date)->get(),

            'products' => DB::table('brand_related_products as bp')->selectRaw('name, id, sku, brand_id, created_by as created_by_id, updated_by as updated_by_id, Date(created_at) as created_at, Date(updated_at) as updated_at, (Select name from users where id = bp.created_by) as created_by, (Select name from users where id = bp.updated_by) as updated_by ')->whereRaw($query_date)->get(),

            'customers' => DB::table('customers as cust')->selectRaw('id, company_name, country_id as    country, created_by as created_by_id, updated_by as updated_by_id, Date(created_at) as created_at, Date(updated_at) as updated_at, (Select name from users where id = cust.created_by) as created_by, (Select name from users where id = cust.updated_by) as updated_by ')->whereRaw($query_date)->get(),

            'pocs' => DB::table('company_poc_list as poc')->selectRaw('customer_id, first_name, (Select company_name from customers where id = poc.customer_id) as customer_name, (Select country_id as country from customers where id = poc.customer_id) as cust_country, created_by as created_by_id, updated_by as updated_by_id, Date(created_at) as created_at, Date(updated_at) as updated_at, (Select name from users where id = poc.created_by) as created_by, (Select name from users where id = poc.updated_by) as updated_by ')->whereRaw($query_date)->get(),

            'suppliers' => DB::table('supplier as sp')->selectRaw('company_name, created_by as created_by_id, updated_by as updated_by_id, Date(created_at) as created_at, Date(updated_at) as updated_at, (Select name from users where id = sp.created_by) as created_by, (Select name from users where id = sp.updated_by) as updated_by ')->whereRaw($query_date)->get(),

            'forwarders' => DB::table('forwarder as fwd')->selectRaw('company_name, created_by as created_by_id, updated_by as updated_by_id, Date(created_at) as created_at, Date(updated_at) as updated_at, (Select name from users where id = fwd.created_by) as created_by, (Select name from users where id = fwd.updated_by) as updated_by ')->whereRaw($query_date)->get(),

            'shippers' => DB::table('shipping_company as sc')->selectRaw('company_name, created_by as created_by_id, updated_by as updated_by_id, Date(created_at) as created_at, Date(updated_at) as updated_at, (Select name from users where id = sc.created_by) as created_by, (Select name from users where id = sc.updated_by) as updated_by ')->whereRaw($query_date)->get(), 

            'employees' => DB::table('users as u')->selectRaw('name, created_by as created_by_id, updated_by as updated_by_id, Date(created_at) as created_at, Date(updated_at) as updated_at, (Select name from users where id = u.created_by) as created_by, (Select name from users where id = u.updated_by) as updated_by ')->whereRaw($query_date)->get(),

            'payments' => DB::table('payments as p')->selectRaw('created_by as created_by_id, updated_by as updated_by_id,Date(created_at) as created_at, Date(updated_at) as updated_at, (Select name from users where id = p.created_by) as created_by, (Select name from users where id = p.updated_by) as updated_by ')->whereRaw($query_date)->get(),

            'tasks' => DB::table('correspondences as cor')->selectRaw('created_by as created_by_id, updated_by as updated_by_id, Date(created_at) as created_at, Date(updated_at) as updated_at, Date(completed_at) as completed_at, (Select name from users where id = (Select completed_by from completed_tasks where task_id = cor.id)) as completed_by, (Select completed_by from completed_tasks where task_id = cor.id) as completed_by_id, (Select name from users where id = cor.created_by) as created_by, (Select name from users where id = cor.updated_by) as updated_by')->whereRaw('type = "task" AND '.$query_date)->get()
        ];

        
        echo json_encode($activities);
    }

    public function GetSiteSearchResult($str)
    {
         $clients   = DB::table('students')->whereRaw('first_name like "' . '%' . $str . '%' . '" OR middle_name like "' . '%' . $str . '%' . '" OR last_name like "' . '%' . $str . '%' . '" OR email like "' . '%' . $str . '%' . '" OR primary_cellphone like "' . '%' . $str . '%' . '"')->get();
         $data      = array('data' => array('Clients' => $clients));

        echo json_encode($data);
    }

    function get_time_ago( $time )
    {
        $time_difference = time() - $time;

        if( $time_difference < 1 ) { return 'less than 1 second ago'; }
        $condition = array(
                                        12 * 30 * 24 * 60 * 60  =>  'year',
                                        30 * 24 * 60 * 60       =>  'month',
                                        24 * 60 * 60            =>  'day',
                                        60 * 60                 =>  'hour',
                                        60                      =>  'minute',
                                        1                       =>  'second'
                            );

        foreach( $condition as $secs => $str )
        {
            $d = $time_difference / $secs;

            if( $d >= 1 )
            {
                $t = round( $d );
                return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }



    function unique_multidim_array($array, $key) { 
        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
        
        foreach($array as $val) { 
            if (!in_array($val[$key], $key_array)) { 
                $key_array[$i] = $val[$key]; 
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
        return $temp_array; 
    }
}
