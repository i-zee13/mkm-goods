<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Correspondence as C;
use App\CorrespondenceConcerns as CC;
use App\CorrespondenceUpdateLogs as CLog;
use App\ProspectCustomer as PC;
use App\Mediums;
use App\Stages;
use App\Orders as O;
use App\User;
use DB;
use Auth;
use URL;
use App\Http\Controllers\Core\AccessRightsAuth;

class Correspondence extends AccessRightsAuth
{
    private $controllerName = "Correspondence";

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // 15 mins = 900 seconds.
        $increment = 900;

        // All possible 15 minute periods in a day up to 23:45.
        $day_in_increments = range( 0, (86400 - $increment), $increment );

        // Output as options.
        $options = '';
        array_walk( $day_in_increments, function( $time ) use(&$options) {
            $options .= '<option value="'.date( 'g:i A', $time ).'">'.date( 'g:i A', $time ).'</option>';
        } );

        $data = DB::table('customers as cust')->selectRaw('business_type,website_url ,email,office_no,postal_code,street_address,company_name, id, business_phone, IFNULL((SELECT name from cities WHERE id = cust.city_id), "NA") as city,  IFNULL((SELECT name from states WHERE id = cust.state_id), "NA") as state,  IFNULL((SELECT name from countries WHERE id = cust.country_id), "NA") as country,created_at, updated_at')->where('id', $id)->first();

        $pocs = DB::table('contact_main_details')->selectRaw('*,IFNULL((SELECT name from cities WHERE id = contact_main_details.city_id), "NA") as city,  IFNULL((SELECT name from states WHERE id = contact_main_details.state_id), "NA") as state,  IFNULL((SELECT name from countries WHERE id = contact_main_details.country_id), "NA") as country,IFNULL((Select contact_name From contact_types where id=contact_main_details.contact_type), "NA") as contact_type_name')->where('agency_id', $id)->get();
        $orders = DB::table('orders as oc')->selectRaw('id, total_cost, payment_received, (SELECT company_name from supplier where id = oc.supplier_assigned) as supplier, (SELECT company_name from customers where id = oc.customer_id) as customer, issue_date, po_num, current_status, total_amount, LOWER(current_status) as status, (Select SUM(amount) from payments where order_id = oc.id) as paid_amt, DATE(created_at) as created_at, Time(created_at) as created_time, invoice_num, (Select name from users where id = oc.employee_id) as created_by, (Select picture from users where id = oc.employee_id) as emp_picture, order_type, eform_num, currency_symbol')->where('customer_id', $id)->get();

        return view('customer.customer-correspondence', [ 'data' => $data, 'employees' => User::all(), 'time_options' => $options, 'pocs' => $pocs, 'base_url' => URL::to('/').'/storage/company'.'/', 'emp_url' =>URL::to('/').'/', 'orders' => $orders]);
    }

    public function GetPaymentHistory(Request $request){
        return DB::table('payments')->where('order_id', $request->order_id)->get();
    }

    public function SaveCorrespondenceChanges(Request $request){
        $c = C::find($request->id);
        if($request->change_type == 'text'){
            $c->mom = $request->mom;
            $c->title = $request->title;
        }else if($request->change_type == 'date'){
            $c[$request->date_type] = date("Y-m-d", strtotime(str_replace('/', '-', $request->date)));
        }else if($request->change_type == 'time'){
            $c[$request->time_type] = date("H:i", strtotime($request->time));
        }
        $c->updated_by = Auth::user()->id;
        $c->save();
    }

    public function GetCorrespondences($id){
        // 15 mins = 900 seconds.
        $increment = 900;

        // All possible 15 minute periods in a day up to 23:45.
        $day_in_increments = range( 0, (86400 - $increment), $increment );

        // Output as options.
        $options = [];
        array_walk( $day_in_increments, function( $time ) use(&$options) {
            $options[] = date( 'g:i A', $time );
        } );

        $corresspondences = C::selectRaw('id, task_priority, pinned, completed_at, task_status, assigned_to as assigned_ids, type, title, reminder_date, reminder_time, mom, due_date, due_time, (SELECT name from users where id = correspondences.assigned_to) as assigned_to, (SELECT name from users where id = correspondences.created_by) as created_by, created_at, MONTHNAME(created_at) as month_name, files, task_comments, (Select picture from users where id = correspondences.created_by) as user_picture')->where('customer_id', $id)->orderBy('id', 'desc')->get();

        $multiple_pocs = DB::table('poc_assignments as pa')->selectRaw('id, correspondence_id, (Select Case When independence = 0 Then (Select first_name from customers where id = pa.poc) Else (Select first_name from company_poc_list where id = pa.poc) End) as poc_name')->whereRaw('correspondence_id IN (Select id from correspondences where customer_id = '.$id.')')->get();

        $completed_tasks = DB::table('completed_tasks')->where('completed_by', Auth::user()->id)->get();

        $orders = json_decode(json_encode(DB::table('orders as oc')->selectRaw('id, total_cost, payment_received, (SELECT company_name from supplier where id = oc.supplier_assigned) as supplier, (SELECT company_name from customers where id = oc.customer_id) as customer, issue_date, po_num, current_status, total_amount, LOWER(current_status) as status, (Select SUM(amount) from payments where order_id = oc.id) as paid_amt, DATE(created_at) as created_at, Time(created_at) as created_time, invoice_num, (Select name from users where id = oc.employee_id) as created_by, (Select picture from users where id = oc.employee_id) as emp_picture, order_type, eform_num, currency_symbol')->where('customer_id', $id)->get()), true);

        $order_content = json_decode(json_encode(DB::table('order_contents as oc')->selectRaw('id, product_id, (Select name from brand_related_products where id = oc.product_id) as product_name, (Select name from product_related_items where id = oc.item_id) as item_name, order_id, qty, unit_price, amount')->whereRaw("order_id IN (Select id from orders where customer_id = $id)")->get()), true);

        $supplier_assignment = json_decode(json_encode(DB::table('supplier_product_assignment as spa')->selectRaw('id, order_id, (Select company_name from supplier where id = spa.supplier_id) as supplier')->get()), true);

        foreach($orders as $key => $value){
            $orders[$key]['content'] = array_values(array_filter($order_content, function($item) use($value){
                return $item['order_id'] == $value['id'];
            }));
            $orders[$key]['suppliers'] = array_values(array_filter($supplier_assignment, function($item) use($value){
                return $item['order_id'] == $value['id'];
            }));
        }

        $products = DB::table('brand_related_products')->get();
        $secondary_services = DB::table('secondary_services')->get();
        $items = DB::table('product_related_items')->get();
        return ['correspondences' => $corresspondences, 'time_options' => $options, 'employees' => User::all(), 'completed_tasks' => $completed_tasks, 'multiple_pocs' => $multiple_pocs, 'products' => $products, 'items' => $items, 'secondary_services' => $secondary_services, 'base_url' => URL::to('/'), 'orders' => $orders];
    }

    public function UpdatePinStatus(Request $request){
        $c = C::find($request->id);
        $c->pinned = $request->pin;
        $c->save();
    }

    public function TaskCompleted(Request $request){
        $insert = DB::table('completed_tasks')->insert([
            'comment' => $request->comment,
            'task_id' => $request->id,
            'completed_by' => Auth::user()->id,
            'completed_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function GetAllTasks(Request $request){
        echo json_encode(array('tasks' => $this->getTasks(), 'files_url' => URL::to('/').'/'));
    }

    public function getTasks(){
        return C::selectRaw('id, due_date, IFNULL(task_status, "not-started") as task_status, due_time, reminder_date, reminder_time, title,  Date(created_at) as created_at, mom, type, pinned, assigned_to, customer_id, comment, task_comments, task_priority, created_at, created_by as created_by_id, (Select name from users where id = correspondences.created_by) as created_by, completed_at, updated_at, updated_by, files')->whereRaw('type = "task"')->get();
    }

    public function UpdateTaskStatus(Request $request){
        $c = C::find($request->id);
        $c->task_status = $request->status;
        $c->save();
    }

    public function GetCommentsForTask($taskId){
        echo json_encode(['comments' => C::find($taskId)->toArray(), 'typing_status' => DB::table('task_comment_typing_status')->whereRaw('employee_id != '.Auth::user()->id.' and task_id = '.$taskId)->first() ]);
    }

    public function PostTaskComment(Request $request){
        DB::table('task_comment_typing_status')->whereRaw('employee_id = '.Auth::user()->id.' OR created_at <= DATE_SUB(NOW(), INTERVAL 3 MINUTE)')->delete();
        $task = C::find($request->task_id);
        $comments = $task->task_comments ? json_decode($task->task_comments, TRUE) : [];
        $comments[] = [ 'at' => date('Y-m-d H:i:s'), 'employee_id' => Auth::user()->id, 'name' => Auth::user()->name, 'picture' => Auth::user()->picture, 'comment' => $request->comment ];
        $task->task_comments = json_encode($comments);
        $task->save();
    }

    public function TypingStatusOnTask(Request $request){
        DB::table('task_comment_typing_status')->whereRaw('employee_id = '.Auth::user()->id.' OR created_at <= DATE_SUB(NOW(), INTERVAL 3 MINUTE)')->delete();
        if(!$request->comment)
            return;
        DB::table('task_comment_typing_status')->insert([
            'employee_id' => Auth::user()->id,
            'employee_name' => Auth::user()->name,
            'task_id' => $request->task_id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $correspondence = new C;
        $voiceNote = null;
        $data_array = [];
        $fileData = null;

        $filesData = [ 'voice_note' => [], 'multiple_documents' => [], 'multiple_images' => [] ];

        if(isset($request->attachments['voice'])){
            foreach($request->attachments['voice'] as $key => $value){
                $status = $this->upload_file($value['base64'], "company", "voice_notes");
                $fileData['voice_note'][] = ['name' => $value['name'], 'extension' => $status['data']['extension'], 'type' => 'Voice Notes', 'link' => $status['data']['link']];
            }
        }else{
            $fileData['voice_note'] = [];
        }


        if(isset($request->attachments['docs'])){
            foreach($request->attachments['docs'] as $key => $value){
                $status = $this->upload_file($value['base64'], "company", "docs");
                $fileData['multiple_documents'][] = ['name' => $value['name'], 'extension' => $status['data']['extension'], 'type' => 'Document', 'link' => $status['data']['link']];
            }
        }else{
            $fileData['multiple_documents'] = [];
        }

        if(isset($request->attachments['images'])){
            foreach($request->attachments['images'] as $key => $value){
                $status = $this->upload_file($value['base64'], "company", "images");
                $fileData['multiple_images'][] = ['name' => $value['name'], 'extension' => $status['data']['extension'], 'type' => 'Images', 'link' => $status['data']['link']];
            }
        }else{
            $fileData['multiple_images'] = [];
        }




        // if($request->hasFile('multiple_documents')){
        //     foreach($request->file("multiple_documents") as $key=> $data){
        //         $completeFileName = $data->getClientOriginalName();
        //         $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
        //         $extension = $data->getClientOriginalExtension();
        //         $iconPath = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
        //         $path = $data->storeAs('public/company', $iconPath);
        //         $fileData['multiple_documents'][] = ['name' => $fileNameOnly, 'extension' => $extension, 'type' => 'Document', 'link' => 'storage/company'.'/'.$iconPath];
        //     }

        // }

        // if($request->hasFile('voice_note')){
        //     foreach($request->file("voice_note") as $key=> $data){
        //         $completeFileName = $data->getClientOriginalName();
        //         $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
        //         $extension = $data->getClientOriginalExtension();
        //         $iconPath = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
        //         $path = $data->storeAs('public/company', $iconPath);
        //         $fileData['voice_note'][] = ['name' => $fileNameOnly, 'extension' => $extension, 'type' => 'Voice Notes', 'link' => 'storage/company'.'/'.$iconPath];
        //     }

        // }

        // if($request->hasFile('multiple_images')){
        //     foreach($request->file("multiple_images") as $key=> $data){
        //         $completeFileName = $data->getClientOriginalName();
        //         $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
        //         $extension = $data->getClientOriginalExtension();
        //         $iconPath = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
        //         $path = $data->storeAs('public/company', $iconPath);
        //         $fileData['multiple_images'][] = ['name' => $fileNameOnly, 'extension' => $extension, 'type' => 'Images', 'link' => 'storage/company'.'/'.$iconPath];
        //     }

        // }

        if($request->type == 'task'){
            $correspondence->due_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->due_date)));
            $correspondence->due_time = date("H:i", strtotime($request->due_time));
            $correspondence->reminder_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->reminder_date)));
            $correspondence->reminder_time = date("H:i", strtotime($request->reminder_time));
            $correspondence->title = $request->title;
            $correspondence->mom = $request->mom;
            $correspondence->type = $request->type;
            $correspondence->assigned_to = implode(',',$request->assigned_to);
            $correspondence->customer_id = $request->customer_id;
            $correspondence->task_priority = $request->priority;
            $correspondence->created_by = Auth::user()->id;
            $correspondence->task_status = "not-started";
        }else if($request->type == 'note'){
            $correspondence->mom = $request->mom;
            $correspondence->type = $request->type;
            $correspondence->customer_id = $request->customer_id;
            $correspondence->created_by = Auth::user()->id;
        }else{
            $correspondence->mom = $request->mom;
            $correspondence->type = $request->type;
            $correspondence->due_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->due_date)));
            $correspondence->due_time = date("H:i", strtotime($request->due_time));
            $correspondence->customer_id = $request->customer_id;
            $correspondence->created_by = Auth::user()->id;
            $correspondence->interested_in_products = json_encode(['sub_category' => $request->sub_category ? implode(', ', $request->sub_category) : '', 'product' => $request->product ? implode(', ', $request->product) : '']);
        }

        $correspondence->files = $fileData ? json_encode($fileData,JSON_UNESCAPED_UNICODE) : null;
        $correspondence->competition = $request->competition_company ? json_encode(['company' => $request->competition_company, 'country' => $request->competition_country]) : null;



        $correspondence->save();
        if($request->type != 'task' && $request->type != 'note'){
            foreach($request->poc as $data){
                DB::table('poc_assignments')->insert([
                    'independence' => $data['independence'],
                    'poc' => $data['poc'],
                    'correspondence_id' => $correspondence->id
                ]);
            }
        }
        return json_encode(['code' => 200, 'data' => $this->getTasks()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        C::find($request->id)->delete();
    }

	public function reporting($id, Request $request){

        $currMonth = date('m');
        $currYear = date('Y');
        $lastMonth = date('m')-1;

        $query_month = ($request->filter == 2 ? "AND Month(created_at) = $currMonth And Year(created_at) = $currYear" : ( $request->filter == 3 ?  "AND Month(created_at) = $lastMonth And Year(created_at) = $currYear" : ($request->filter == 4 ? "AND DATE(created_at) BETWEEN '$request->start_date' AND '$request->end_date'" : "")));

       // echo $query_month;die;

        $reports = DB::table('orders')->selectRaw('SUM(total_amount) as total_revenue,  Count(*) as total_orders, AVG(total_amount) as overall_avg_revenue, (SELECT SUM(total_amount) FROM `orders` where customer_id = '.$id.' And Month(created_at) = '.date('m').' AND Year(created_at) = "'.date('Y').'") as current_month_revenue, (SELECT SUM(amount) FROM `payments` where order_id IN (Select id from orders where customer_id = '.$id.' '.$query_month.')) as total_paid_amount, (Select AVG(total_amount) from orders where customer_id = '.$id.' And Month(created_at) IN (1,2,3) And Year(created_at) = "'.date('Y').'") as q1, (Select AVG(total_amount) from orders where customer_id = '.$id.' And Month(created_at) IN (4,5,6) And Year(created_at) = "'.date('Y').'") as q2, (Select AVG(total_amount) from orders where customer_id = '.$id.' And Month(created_at) IN (7,8,9) And Year(created_at) = "'.date('Y').'") as q3, (Select AVG(total_amount) from orders where customer_id = '.$id.' And Month(created_at) IN (10,11,12) And Year(created_at) = "'.date('Y').'") as q4, (Select datediff("'.date('Y-m-d').'", Date(created_at)) from orders where customer_id = '.$id.' order by id ASC limit 1) as days_till_first_order, (Select Date(created_at) from payments where order_id IN (Select id from orders where customer_id = '.$id.') order by id DESC limit 1) as last_payment_date, (Select amount from payments where order_id IN (Select id from orders where customer_id = '.$id.') order by id DESC limit 1) as last_payment, (Select Count(*) from orders where current_status NOT IN ("completed") and customer_id = '.$id.' '.$query_month.') as pending_orders, (Select Count(*) from orders where current_status = "completed" and customer_id = '.$id.' '.$query_month.') as completed_orders, (Select Count(*) from order_contents where order_id IN (Select id from orders where customer_id = '.$id.' '.$query_month.')) as total_products, (Select SUM(qty) from order_contents where order_id IN (Select id from orders where customer_id = '.$id.' '.$query_month.')) as total_qty, (Select Count(*) from orders where customer_id = '.$id.' and Month(created_at) = "'. date('m').'" AND Year(created_at) = "'.date('Y').'") current_month_orders, (Select Count(*) from orders where customer_id = '.$id.' and payment_received = 1 '.$query_month.') as paid_orders, (Select Count(*) from orders where current_status = "dispatched" and customer_id = '.$id.' '.$query_month.') as dispatched_orders, (Select Count(*) from payments where order_id IN (Select id from orders where customer_id = '.$id.') And type = 1 '.$query_month.') as cash_payments, (Select Count(*) from payments where order_id IN (Select id from orders where customer_id = '.$id.') And type = 2 '.$query_month.') as cheque_payments')->whereRaw('customer_id = '.$id.' '.$query_month)->first();
        //Average Payment Per Day
        $current_date = date('Y-m-d');
        $avg_payment_per_day = 0;
        $total_payment_days = 0;
        $payment_per_day = DB::select('SELECT id, Date(created_at) as order_date, (Select IFNULL((Select Date(created_at) from payments where order_id = o.id), "'.$current_date.'")) as payment_date, (Select datediff(payment_date, order_date)) as difference from orders as o where customer_id = '.$id.' '.$query_month);

        array_map(function($item) use(&$total_payment_days){
            $total_payment_days += $item->difference;
        }, $payment_per_day);
        $avg_payment_per_day = sizeof($payment_per_day) ? $total_payment_days / sizeof($payment_per_day) : 0;

        $top_products = DB::table('order_contents as oc')->selectRaw('product_id, Count(*) as count, (Select name from brand_related_products where id = oc.product_id) as product_name')->whereRaw("order_id in (Select id from orders WHERE customer_id = $id $query_month)")->groupBy('product_id')->orderBy('count', 'DESC')->get(10);

        $top_categories = DB::table('order_contents as oc')->selectRaw('product_id, Count(product_id) as counts, (Select service_name from main_services where id = (Select primary_service_id from brand_related_products where id = oc.product_id)) as service_name')->whereRaw('order_id IN (Select id from orders where customer_id = '.$id.' '.$query_month.')')->groupBy('product_id')->orderBy(DB::raw('Count(product_id)'), 'DESC')->get(6);


        echo json_encode(array('customer_report' => $reports, 'avg_payment_per_day' => $avg_payment_per_day, 'top_products' => $top_products, 'top_categories' => $top_categories));
        die;

        // $reports->cash_payments = $reports->cash_payments ? $reports->cash_payments : 0;
        // $reports->cheque_payments = $reports->cheque_payments ? $reports->cheque_payments : 0;
        // $reports->completed_orders = $reports->completed_orders ? $reports->completed_orders : 0;
        // $reports->current_month_orders = $reports->current_month_orders ? $reports->current_month_orders : 0;
        // $reports->current_month_revenue = $reports->current_month_revenue ? $reports->current_month_revenue : 0;
        // $reports->days_till_first_order = $reports->days_till_first_order ? $reports->days_till_first_order : 0;
        // $reports->dispatched_orders = $reports->dispatched_orders ? $reports->dispatched_orders : 0;
        // $reports->last_payment = $reports->last_payment ? $reports->last_payment : 0;
        // $reports->last_payment_date = $reports->last_payment_date ? $reports->last_payment_date : "";
        // $reports->overall_avg_revenue = $reports->overall_avg_revenue ? $reports->overall_avg_revenue : 0;
        // $reports->paid_orders = $reports->paid_orders ? $reports->paid_orders : 0;
        // $reports->pending_orders = $reports->pending_orders ? $reports->pending_orders : 0;
        // $reports->q1 = $reports->q1 ? $reports->q1 : 0;
        // $reports->q2 = $reports->q2 ? $reports->q2 : 0;
        // $reports->q3 = $reports->q3 ? $reports->q3 : 0;
        // $reports->q4 = $reports->q4 ? $reports->q4 : 0;
        // $reports->total_orders = $reports->total_orders ? $reports->total_orders : 0;
        // $reports->total_paid_amount = $reports->total_paid_amount ? $reports->total_paid_amount : 0;
        // $reports->total_products = $reports->total_products ? $reports->total_products : 0;
        // $reports->total_qty = $reports->total_qty ? $reports->total_qty : 0;
        // $reports->total_revenue = $reports->total_revenue ? $reports->total_revenue : 0;



        //echo '<pre>'; print_r($reports); die;

        //$top_products = DB::table('order_contents')->selectRaw('product_id, Count(product_id) as counts')->whereRaw('order_id IN (Select id from orders where customer_id = '.$id.')')->groupBy('product_id')->orderBy(DB::raw('Count(product_id)'), 'DESC')->get();

        $top_categories = DB::table('order_contents as oc')->selectRaw('product_id, Count(product_id) as counts, (Select service_name from main_services where id = (Select primary_service_id from brand_related_products where id = oc.product_id)) as service_name')->whereRaw('order_id IN (Select id from orders where customer_id = '.$id.')')->groupBy('product_id')->orderBy(DB::raw('Count(product_id)'), 'DESC')->get();

        $month_wise_products = DB::select("SELECT MONTHNAME(created_at) as mname, (SELECT count(*) from order_contents where order_id IN (SELECT id from orders where customer_id = $id and MONTHNAME(created_at) = mname)) as total from orders as o where customer_id = $id group by MONTHNAME(created_at) order by total desc");

        $top_products = DB::table('order_contents')->selectRaw('product_id, Count(*) as count')->whereRaw("order_id in (Select id from orders WHERE customer_id = $id)")->groupBy('product_id')->orderBy('count', 'DESC')->get();

        $month_wise_top_products = json_decode(json_encode(DB::table('orders as o')->selectRaw('MonthName(created_at) as month, (SELECT product_id from order_contents where order_id = o.id) as product_id, (SELECT name from brand_related_products where id = ((SELECT product_id from order_contents where order_id = o.id))) as product_name')->where('customer_id', $id)->get()), true);

        $uniqueMonths = $this->unique_multidim_array($month_wise_top_products, 'month');
        $top_products_month_wise = [];
        foreach ($uniqueMonths as $key => $value) {
            $top_products_month_wise[$key]['month'] = $value['month'];
            $items = array_values(array_filter($month_wise_top_products, function($item) use($value){
                return $item['month'] == $value['month'];
            }));
            $counter = 0;
            $loopedItems = [];
            array_map(function($item) use(&$items, &$counter, &$loopedItems){
                $itmFnd = array_search($item['product_id'], array_column($loopedItems, 'product_id'));
                if($itmFnd !== false && $itmFnd >= 0){
                    $loopedItems[$itmFnd]['total']++;
                    // $loopedItems[$itmFnd]['total'] = $loopedItems[$itmFnd]['total']++;
                }else{
                    $loopedItems[] = [ 'product_id' => $item['product_id'], 'product_name' => $item['product_name'], 'total' => 1 ];
                }
                $counter++;
            }, $items);
            $top_products_month_wise[$key]['data'] = $loopedItems;
        }








        //Customer Reports
        $customer_reports = DB::table('customers')->selectRaw('Count(*) as total_customers, (Select Count(*) from customers where life_cycle_stage = "prospect") as prospect_customers, (Select Count(*) from customers where life_cycle_stage = "lead") as sale_lead_customers, (Select Count(*) from customers where is_active = 1) as active_customers, (Select Count(*) from customers where is_active = 0) as inactive_customers, (Select Count(*) from correspondences where type = "task") as total_task_assigned')->first();



        //Completed Tasks
        $tasks_data = $payment_per_day = DB::select('SELECT id, Date(created_at) as task_date, Date(due_date) as due_date, (Select IFNULL(Date(completed_at), "'.$current_date.'")) as completed_task_date, (Select datediff(completed_task_date, due_date)) as difference from correspondences where type = "task"');

        $completed_on_time_tasks = 0;
        array_map(function($item) use(&$completed_on_time_tasks){
            if($item->difference <= 0){
                $completed_on_time_tasks +=1;
            }
        }, $tasks_data);




        //Over-ALL Reporting
        $reporting_over_all = DB::table('orders')->selectRaw('SUM(total_amount) as total_revenue,  Count(*) as total_orders, AVG(total_amount) as overall_avg_order_value, (SELECT SUM(total_amount) FROM `orders` where Month(created_at) = '.date('m').') as current_month_revenue, (SELECT SUM(amount) FROM `payments`) as total_paid_amount, (Select Count(*) from order_contents) as total_products, (Select SUM(qty) from order_contents) as total_products_qty, (Select Count(*) from orders where Month(created_at) = '.date('m').') as new_orders_thisMonth, (Select Count(*) from orders where current_status NOT IN ("completed")) as in_process_orders, (Select SUM(amount) from payments) as total_payment_received')->first();

        $top_products_over_all = DB::table('order_contents')->selectRaw('product_id, Count(*) as count')->whereRaw("order_id in (Select id from orders WHERE Month(created_at) = ".date('m').")")->groupBy('product_id')->orderBy('count', 'DESC')->get();



    }

    public function DownloadMultipleDocs($id){
        $docs = DB::table('correspondences')->where('id', $id)->first();
        if($docs){
            $files = json_decode($docs->files, true);
            if($files['multiple_documents']){
                foreach($files['multiple_documents'] as $data){
                    redirect(URL::to('/').$data['link']);
                }
            }
            if($files['voice_note']){
                foreach($files['voice_note'] as $data){
                    redirect(URL::to('/').$data['link']);
                }
            }
            if($files['multiple_images']){
                foreach($files['multiple_images'] as $data){
                    redirect(URL::to('/').$data['link']);
                }
            }
        }
    }

    function upload_file($encoded_string, $path, $module = null){
        $target_dir = storage_path('app/public/'.$path); // add the specific path to save the file
        $decoded_file = base64_decode($encoded_string); // decode the file
        $mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE); // extract mime type

        $mime2type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_NONE);

        $fileNameOnly = pathinfo($decoded_file, PATHINFO_FILENAME);

        $extension = $this->mime2ext($mime_type); // extract extension from mime type
        $file = time().'-'.uniqid() .'.'. $extension; // rename file as a unique name
        $file_dir = $target_dir . '/' . $file;



        try {
            file_put_contents($file_dir, $decoded_file); // save
            if(!$module){
                return array("status" => "success", "name" => $file);
            }else{
                return array("status" => "success", "data" =>  ['name' => $file, 'extension' => $extension, 'type' => $module, 'file_name' => $fileNameOnly, 'link' => '/storage/company/'.$file]);
            }

        } catch (Exception $e) {
            return array("status" => "failed", "error" => $e->getMessage());
        }

    }
    /*
    to take mime type as a parameter and return the equivalent extension
    */
    function mime2ext($mime){
        $all_mimes = '{"png":["image\/png","image\/x-png"],"bmp":["image\/bmp","image\/x-bmp",
        "image\/x-bitmap","image\/x-xbitmap","image\/x-win-bitmap","image\/x-windows-bmp",
        "image\/ms-bmp","image\/x-ms-bmp","application\/bmp","application\/x-bmp",
        "application\/x-win-bitmap"],"gif":["image\/gif"],"jpeg":["image\/jpeg",
        "image\/pjpeg"],"xspf":["application\/xspf+xml"],"vlc":["application\/videolan"],
        "wmv":["video\/x-ms-wmv","video\/x-ms-asf"],"au":["audio\/x-au"],
        "ac3":["audio\/ac3"],"flac":["audio\/x-flac"],"ogg":["audio\/ogg",
        "video\/ogg","application\/ogg"],"kmz":["application\/vnd.google-earth.kmz"],
        "kml":["application\/vnd.google-earth.kml+xml"],"rtx":["text\/richtext"],
        "rtf":["text\/rtf"],"jar":["application\/java-archive","application\/x-java-application",
        "application\/x-jar"],"zip":["application\/x-zip","application\/zip",
        "application\/x-zip-compressed","application\/s-compressed","multipart\/x-zip"],
        "7zip":["application\/x-compressed"],"xml":["application\/xml","text\/xml"],
        "svg":["image\/svg+xml"],"3g2":["video\/3gpp2"],"3gp":["video\/3gp","video\/3gpp"],
        "mp4":["video\/mp4"],"m4a":["audio\/x-m4a"],"f4v":["video\/x-f4v"],"flv":["video\/x-flv"],
        "webm":["video\/webm"],"aac":["audio\/x-acc"],"m4u":["application\/vnd.mpegurl"],
        "pdf":["application\/pdf","application\/octet-stream"],
        "pptx":["application\/vnd.openxmlformats-officedocument.presentationml.presentation"],
        "ppt":["application\/powerpoint","application\/vnd.ms-powerpoint","application\/vnd.ms-office",
        "application\/msword"],"docx":["application\/vnd.openxmlformats-officedocument.wordprocessingml.document"],
        "xlsx":["application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application\/vnd.ms-excel"],
        "xl":["application\/excel"],"xls":["application\/msexcel","application\/x-msexcel","application\/x-ms-excel",
        "application\/x-excel","application\/x-dos_ms_excel","application\/xls","application\/x-xls"],
        "xsl":["text\/xsl"],"mpeg":["video\/mpeg"],"mov":["video\/quicktime"],"avi":["video\/x-msvideo",
        "video\/msvideo","video\/avi","application\/x-troff-msvideo"],"movie":["video\/x-sgi-movie"],
        "log":["text\/x-log"],"txt":["text\/plain"],"css":["text\/css"],"html":["text\/html"],
        "wav":["audio\/x-wav","audio\/wave","audio\/wav"],"xhtml":["application\/xhtml+xml"],
        "tar":["application\/x-tar"],"tgz":["application\/x-gzip-compressed"],"psd":["application\/x-photoshop",
        "image\/vnd.adobe.photoshop"],"exe":["application\/x-msdownload"],"js":["application\/x-javascript"],
        "mp3":["audio\/mpeg","audio\/mpg","audio\/mpeg3","audio\/mp3"],"rar":["application\/x-rar","application\/rar",
        "application\/x-rar-compressed"],"gzip":["application\/x-gzip"],"hqx":["application\/mac-binhex40",
        "application\/mac-binhex","application\/x-binhex40","application\/x-mac-binhex40"],
        "cpt":["application\/mac-compactpro"],"bin":["application\/macbinary","application\/mac-binary",
        "application\/x-binary","application\/x-macbinary"],"oda":["application\/oda"],
        "ai":["application\/postscript"],"smil":["application\/smil"],"mif":["application\/vnd.mif"],
        "wbxml":["application\/wbxml"],"wmlc":["application\/wmlc"],"dcr":["application\/x-director"],
        "dvi":["application\/x-dvi"],"gtar":["application\/x-gtar"],"php":["application\/x-httpd-php",
        "application\/php","application\/x-php","text\/php","text\/x-php","application\/x-httpd-php-source"],
        "swf":["application\/x-shockwave-flash"],"sit":["application\/x-stuffit"],"z":["application\/x-compress"],
        "mid":["audio\/midi"],"aif":["audio\/x-aiff","audio\/aiff"],"ram":["audio\/x-pn-realaudio"],
        "rpm":["audio\/x-pn-realaudio-plugin"],"ra":["audio\/x-realaudio"],"rv":["video\/vnd.rn-realvideo"],
        "jp2":["image\/jp2","video\/mj2","image\/jpx","image\/jpm"],"tiff":["image\/tiff"],
        "eml":["message\/rfc822"],"pem":["application\/x-x509-user-cert","application\/x-pem-file"],
        "p10":["application\/x-pkcs10","application\/pkcs10"],"p12":["application\/x-pkcs12"],
        "p7a":["application\/x-pkcs7-signature"],"p7c":["application\/pkcs7-mime","application\/x-pkcs7-mime"],"p7r":["application\/x-pkcs7-certreqresp"],"p7s":["application\/pkcs7-signature"],"crt":["application\/x-x509-ca-cert","application\/pkix-cert"],"crl":["application\/pkix-crl","application\/pkcs-crl"],"pgp":["application\/pgp"],"gpg":["application\/gpg-keys"],"rsa":["application\/x-pkcs7"],"ics":["text\/calendar"],"zsh":["text\/x-scriptzsh"],"cdr":["application\/cdr","application\/coreldraw","application\/x-cdr","application\/x-coreldraw","image\/cdr","image\/x-cdr","zz-application\/zz-winassoc-cdr"],"wma":["audio\/x-ms-wma"],"vcf":["text\/x-vcard"],"srt":["text\/srt"],"vtt":["text\/vtt"],"ico":["image\/x-icon","image\/x-ico","image\/vnd.microsoft.icon"],"csv":["text\/x-comma-separated-values","text\/comma-separated-values","application\/vnd.msexcel"],"json":["application\/json","text\/json"]}';
        $all_mimes = json_decode($all_mimes,true);
        foreach ($all_mimes as $key => $value) {
            if(array_search($mime,$value) !== false) return $key;
        }
        return false;
    }
}
