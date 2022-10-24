<?php

namespace App\Providers;

use App\ControllersList as CL;
// use App\Correspondence as C;
use Auth;
use DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        Schema::defaultStringLength('191');
        app('view')->composer('layouts.master', function ($view) {
            $action = app('request')->route()->getAction();
            $controller = class_basename($action['controller']);
            list($controller, $action) = explode('@', $controller);
            $userPermissions = array();
            $allControllers = CL::orderBy('parent_module_priority')->get();

            $notif_data = array();
            $all_notifications = array();

            // $this->get_notif_data($notif_data, $all_notifications);

            if (Auth::check()) {
                if (Auth::user()->super) {
                    foreach (CL::all() as $controllers) {
                        $userPermissions[] = $controllers->controller;
                    }
                } else {
                    foreach (DB::table('access_rights')->select('controller_right')->where('employee_id', Auth::user()->id)->get() as $object) {
                        $userPermissions[] = $object->controller_right;
                    }
                }
            }
            // $tasks = C::where('assigned_to', Auth::user()->id)->get();
            $customersFromProvider = [];//\App\Customer::all();
            $empsForCentralizedTask = \App\User::all();
            $designation = DB::table('designations')->where("id", Auth::user()->designation)->first();
            $view->with(compact('controller', 'action', 'userPermissions', 'notif_data', 'all_notifications', 'allControllers','customersFromProvider', 'empsForCentralizedTask', 'designation'));
        });

        // app('view')->composer('home', function ($view) {
        //     $notif_data = array();
        //     $all_notifications = array();
        //     $this->get_notif_data($notif_data, $all_notifications);
        //     $view->with(compact('notif_data'));
        // });

        // app('view')->composer('notifications.viewAll', function ($view) {
        //     $notif_data = array();
        //     $all_notifications = array();
        //     $this->get_notif_data($notif_data, $all_notifications);
        //     $view->with(compact('all_notifications'));
        // });
    }

    // public function get_notif_data(&$notif_data, &$all_notification)
    // {
    //     $check = DB::table('subscribed_notifications as sn')->selectRaw('GROUP_CONCAT(notification_code_id) as notifications_codes')->whereRaw('web = 1 AND emp_id = ' . Auth::user()->id)->first();
    //     //echo $check; die;
    //     if ($check->notifications_codes) {
    //         //Show only four notifications
    //         $notif_data = DB::table('notifications_list as nlist')->selectRaw('id, code, message, customer_id, order_id, supplier_id, prospect_customer_id, created_at, ( case WHEN customer_id IS NOT NULL THEN (Select company_name from customers where id = nlist.customer_id) WHEN supplier_id IS NOT NULL THEN (Select company_name from supplier where id = nlist.supplier_id) ELSE (Select company_name from prospect_customers where id = nlist.prospect_customer_id) END ) as customer, ( case WHEN customer_id IS NOT NULL THEN (Select IFNULL(picture, "no-image.png") from customers where id = nlist.customer_id) ELSE "no-image.png" END ) as picture')->whereRaw('code IN (' . DB::table('subscribed_notifications as sn')->selectRaw('GROUP_CONCAT(notification_code_id) as notifications_codes')->whereRaw('web = 1 AND emp_id = ' . Auth::user()->id)->first()->notifications_codes . ') AND id NOT IN (Select notif_id from notification_read_status where emp_id = "' . Auth::user()->id . '")')->orderBy('id', 'DESC')->take(5)->get();
    //         //Show all notifications
    //         $all_notification = DB::table('notifications_list as nlist')->selectRaw('id, code, message, order_id, customer_id, supplier_id, prospect_customer_id, product_id, created_at, ( case WHEN customer_id IS NOT NULL THEN (Select company_name from customers where id = nlist.customer_id) WHEN supplier_id IS NOT NULL THEN (Select company_name from supplier where id = nlist.supplier_id) WHEN product_id IS NOT NULL THEN (Select name from product_related_items where id = nlist.product_id) WHEN order_id IS NOT NULL THEN (Select company_name from customers where id = (Select customer_id from orders where id = nlist.customer_id)) ELSE (Select company_name from prospect_customers where id = nlist.prospect_customer_id) END ) as _name, ( case WHEN customer_id IS NOT NULL THEN (Select IFNULL(picture, "no-image.png") from customers where id = nlist.customer_id) ELSE "no-image.png" END ) as picture')->whereRaw('code IN (' . DB::table('subscribed_notifications as sn')->selectRaw('GROUP_CONCAT(notification_code_id) as notifications_codes')->whereRaw('web = 1 AND emp_id = ' . Auth::user()->id)->first()->notifications_codes . ')')->orderBy('id', 'DESC')->get();
    //     } else {
    //         $this->notif_data = array();
    //         $this->all_notification = array();
    //     }
    // }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
