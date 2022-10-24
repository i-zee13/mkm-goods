<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as EMP;
use App\Http\Controllers\Core\AccessRightsAuth;
use DB;
use Auth;
use URL;

class ViewAllNotifications extends AccessRightsAuth
{
    private $controllerName = "ViewAllNotifications";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('notifications.viewAll');
    }

    function fetchAllNotifications(Request $request){
        $yesterday = date("j", strtotime("yesterday"));
        $current_month = date('m');
        $last_month = (date('m') == 1 ? 12 : date('m') - 1);
        $current_year = date('Y');
        $today = date('d');

        $queryString = ($request->date == 0 ? 'AND id > 0' : ($request->date == 1 ? "AND Day(created_at) = $yesterday AND Month(created_at) = $current_month AND Year(created_at) = $current_year" : ($request->date == 2 ? "AND Day(created_at) = $today AND Month(created_at) = $current_month AND Year(created_at) = $current_year" : ($request->date == 3 ? "AND Month(created_at) = $current_month AND Year(created_at) = $current_year" : ($request->date == 4 ? "AND Month(created_at) = $last_month AND Year(created_at) = $current_year" : "AND DATE(created_at) BETWEEN '$request->start_date' AND '$request->end_date'")))));

        //( case WHEN customer_id IS NOT NULL THEN (Select company_name from customers where id = nlist.customer_id) WHEN supplier_id IS NOT NULL THEN (Select company_name from supplier where id = nlist.supplier_id) WHEN product_id IS NOT NULL THEN (Select name from product_related_items where id = nlist.product_id) WHEN order_id IS NOT NULL THEN nlist.order_id ELSE (Select company_name from prospect_customers where id = nlist.prospect_customer_id) END )

        $all_notification = DB::table('notifications_list as nlist')->selectRaw('id, code, message, order_id, customer_id, supplier_id, prospect_customer_id, product_id, created_at,  (Select name from users where id = nlist.created_by) as _name, ( case WHEN customer_id IS NOT NULL THEN (Select IFNULL(picture, "no-image.png") from customers where id = nlist.customer_id) ELSE "no-image.png" END ) as picture, (case WHEN customer_id IS NOT NULL THEN (Select name from users where id = (Select COALESCE(updated_by, created_by) from customers where id = nlist.customer_id)) WHEN supplier_id IS NOT NULL THEN (Select name from users where id = (Select COALESCE(updated_by, created_by) from supplier where id = nlist.supplier_id)) WHEN product_id IS NOT NULL THEN (Select name from users where id = (Select COALESCE(updated_by, created_by) from product_related_items where id = nlist.product_id))   WHEN order_id IS NOT NULL THEN (Select name from users where id = (Select COALESCE(updated_by, employee_id) from orders where id = nlist.order_id)) ELSE (Select name from users where id = (Select COALESCE(updated_by, created_by) from prospect_customers where id = nlist.prospect_customer_id)) END ) as created_by')->whereRaw('code IN ('.DB::table('subscribed_notifications as sn')->selectRaw('GROUP_CONCAT(notification_code_id) as notifications_codes')->whereRaw('web = 1 AND emp_id = '. Auth::user()->id)->first()->notifications_codes.') '.$queryString)->orderBy('id','DESC')->get();

        $base_url = URL::to('/storage/company');

        echo json_encode(array('url' => $base_url, 'notifications' => $all_notification));
    }

}
