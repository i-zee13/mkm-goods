<?php

namespace App\Http\Controllers;

use App\BrandProducts;
use App\Brands as B;
use App\Customer as Cust;
use App\Http\Controllers\Core\AccessRightsAuth;
use App\OrderContents as OC;
use App\Orders as O;
use App\Payments as P;
use App\ProductItems as PI;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use URL;
use Mail;
use App\Mail\OrderInvoice;
use App\Supplier as S;
use App\DispatchOrderDocs as DOD;
use App\SupplierProductAssignment as SPA;
use App\CustomInvoices as CI;
use App\DispatchDetail;
use App\DispatchShippingInformation;
use App\Http\Controllers\API\Order;
use App\SupplierDispatch as SD;
use App\LOS as LOS;
use App\OrderContents;
use App\OrderDispatch;
use App\Orders;
use App\StockMangment;
use Carbon\Carbon;
use Dotenv\Regex\Success;

class OrderManagement extends AccessRightsAuth
{
    public $controllerName = "OrderManagement";
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = json_decode(json_encode(\App\CustomerAssignment::where('employee_id', Auth::user()->id)->get()), TRUE);
        $query = $query ? implode(",", array_column($query, "customer_id")) : null;
        $query = $query ? "customer_id IN ($query)" : "customer_id > 0";

        $orders = DB::select("SELECT
            o.id,
            o.invoice_num,
            o.total_cost,
            o.payment_received,
            o.currency_symbol,
            o.issue_date,
            o.po_num,
            o.current_status,
            o.total_amount,
            LOWER(o.current_status) as status,
            o.order_discount,
            o.discount_value,
            o.created_at,
            c.company_name as customer,
            c.id as customer_id,
            c.address as customer_address,
            c.state as customer_state,
            c.country as customer_country,
            c.city as customer_city,
            u.name as created_by
        FROM orders o
        JOIN customers c ON c.id = o.customer_id
        JOIN users u ON u.id = o.employee_id
        WHERE $query");

        $pending_orders = array_filter($orders, function($x){
            return $x->status == 'pending';
        });

        $processed_orders = array_filter($orders, function($x){
            return $x->status == 'processed';
        });

        $completed_orders = array_filter($orders, function($x){
            return $x->status == 'completed';
        });
        
        return view('orders-management.list', ['pending_orders' => $pending_orders, 'processed_orders' => $processed_orders, 'completed_orders' => $completed_orders]);
    }

    public function historicOrders()
    {
        $orders = DB::select("SELECT id, DATE(created_at) as created_at, total_cost, payment_received, currency_symbol, (SELECT company_name from supplier where id = orders.supplier_assigned) as supplier, (SELECT company_name from customers where id = orders.customer_id) as customer, issue_date, po_num, current_status, total_amount, LOWER(current_status) as status, (Select SUM(amount) from payments where order_id = orders.id) as paid_amt, order_discount, invoice_num, discount_value FROM orders WHERE bulk_upload = 1");

        return view('orders-management.historic-orders', ['orders' => $orders]);
    }
    
    public function OrderDetails($id)
    {
        
        $query = json_decode(json_encode(\App\CustomerAssignment::where('employee_id', Auth::user()->id)->get()), TRUE);

        $orderData = $this->orderData($id);
        if(sizeof($query)){
            if(!in_array($orderData['customer_id'], array_column($query, "customer_id")))
                return abort('403');
        }
        $suppliers = S::all()->toArray();
        $assignments = $this->assignmentsData($id);
        $actiTlines = $assignments ? call_user_func_array("array_merge", array_column($assignments, 'activity_timeline')) : [];
        array_multisort(array_column($actiTlines, 'at'), SORT_DESC, $actiTlines);
        foreach($actiTlines as $key => $item){
            if($item['activity_type'] == "reassignment"){
                $indFnd = array_search($item['data']['before_updated']['new_supplier_id'], array_column($suppliers, 'id'));
                $actiTlines[$key]['data']['before_updated']['new_supplier_id'] = ($indFnd !== false && $indFnd >= 0 ? $suppliers[$indFnd]['company_name'] : "NA");
            }

            if($item['activity_type'] == "assignment"){
                $indFnd = array_search($item['data']['supplier'], array_column($suppliers, 'id'));
                $actiTlines[$key]['data']['supplier'] = ($indFnd !== false && $indFnd >= 0 ? $suppliers[$indFnd]['company_name'] : "NA");
            }
        }

        $dispatchInProgress = SD::whereRaw("order_id = '".$id."' and dispatch_done = 0")->orderBy('id', 'desc')->first();
        $dispatchInProgress = $dispatchInProgress ? $dispatchInProgress->dispatch_batch : substr(str_shuffle("0123456789-ABCDEFGHI-03123XYZZZ"), 0, 30);

        return view('orders-management.details', ['orderInfo' => $orderData, 'customer' => Cust::where('id', $orderData['customer_id'])->first(), 'payments' => P::where('order_id', $id)->get(), 'ports' => \App\Ports::all(), 'suppliers' => $suppliers, 'shipping_companies' => \App\ShippingCompany::all(), 'doc_type' => DB::table('document_types')->get(), 'products' => \App\BrandProducts::all(), 'services' => DB::table('main_services')->get(), 'acquisition' => DB::table('acquisition_source')->get(), 'assignments' => $assignments, 'employees' => \App\Models\User::select('id', 'name')->get(), 'activity' => $actiTlines, 'dispatchInProgress' => $dispatchInProgress ]);
    }

    public function GetOrderDetailsData(Request $req){
        $allProducts = \App\BrandProducts::where('brand_id', 2)->get()->toArray();
        $allItems = \App\ProductItems::selectRaw('`id`, `name`, `description`, `unit_id`, `unit_weight`, `variant_id`, variant_id_2, variant_quantity_2, variant_id_3, variant_quantity_3, `unit_quantity`, `unit_variant_quantity`, `length`, `width`, `height`, `cbm_value`, `product_id`, (SELECT unit_name from item_units where id = product_related_items.unit_id) as unit_name, (SELECT variant_name from item_variants where id = product_related_items.variant_id) as variant_name, (CASE WHEN variant_id IS NOT NULL THEN (SELECT variant_name from item_variants where id = product_related_items.variant_id_2) END) as variant_2_name, (CASE WHEN variant_id IS NOT NULL THEN (SELECT variant_name from item_variants where id = product_related_items.variant_id_3) END) as variant_3_name, standrad_unit_price')->get()->toArray();
        foreach ($allProducts as $key => $value) {
            $allProducts[$key]['items'] = array_values(array_filter($allItems, function($item) use($value){
                return $item['product_id'] == $value["id"];
            }));
        }

        $contents = \App\OrderContents::selectRaw('item_id, (SELECT customer_id from orders where id = order_contents.order_id) as customer_id, unit_price')->orderBy('id', 'desc')->get()->toArray();
        return ['order' => $this->orderData($req->order_id), 'assignments' => $this->assignmentsData($req->order_id), 'products' => $allProducts, 'items' => $contents];
    }

    public function orderData($id){
        $orderData = O::selectRaw('`id`, `payment_type`, `customer_id`, (SELECT name from users where id = orders.employee_id) as employee, (SELECT picture from users where id = orders.employee_id) as picture, (SELECT company_name from customers where id = orders.customer_id) as customer_name, `employee_id`, `issue_date`, `po_num`, `invoice_num`, `eform_num`, `total_amount`, `total_commercial_amount`, `total_cost`, `currency`, `currency_symbol`, `notes`, `terms`, `additional_weight`, `net_weight`, `actual_weight`, `current_status`, `supplier_assigned`, `order_type`, `country_of_origin`, `expected_delivery_date`, `date_of_shipment`, `port_of_loading`, `port_of_discharge`, `mode_of_shipment`, `shipment_route`, `shipment_company`, `quoted_freight_charges`, `forwarder`, `vessel_number`, `actual_freight_charges`, `discharge_date`, `shipping_documents`, `eform_documents`, `bank_name`, `all_documents`, `container_types`, `processed_at`, `processed_by`, `completed_at`, `completed_by`, `payment_received`, `order_discount`, `discount_value`, `created_at`, `updated_at`, `updated_by`')->where('id', $id)->first()->toArray();
        $orderData['all_documents'] = json_decode($orderData['all_documents']);
        $orderData['shipment_route'] = explode(",", $orderData['shipment_route']);
        $contents = OC::selectRaw('`id`, `item_id`, product_id, net_weight, IFNULL((SELECT SUM(item_quantity) from supplier_product_assignment where delete_reason IS NULL and item_id = order_contents.item_id and order_id = order_contents.order_id), 0) as assigned_qty, IFNULL((SELECT SUM(production_quantity) from supplier_product_assignment where delete_reason IS NULL and item_id = order_contents.item_id and order_id = order_contents.order_id), 0) as production, IFNULL((SELECT SUM(dispatched_quantity) from supplier_product_assignment where delete_reason IS NULL and item_id = order_contents.item_id and order_id = order_contents.order_id), 0) as dispatched, (SELECT name from product_related_items where id = order_contents.`item_id`) as item_name, (SELECT name from brand_related_products where id = order_contents.`product_id`) as product_name, (SELECT picture from brand_related_products where id = order_contents.`product_id`) as thumbnail, `qty`, `product_desc`, `weight_per_unit`, `weight_per_ctn`, `cbm`, `total_cbm`, `unit_price`, ROUND(amount, 2) as amount , `order_id`, `created_at`, `updated_at`, `updated_by`, (SELECT unit_name from item_units where id = (SELECT unit_id from product_related_items where id = order_contents.item_id)) as unit_name, (SELECT variant_name from item_variants where id = (SELECT variant_id from product_related_items where id = order_contents.item_id)) as variant_name, (SELECT unit_quantity from product_related_items where id = order_contents.item_id) as unit_quantity, (SELECT unit_variant_quantity from product_related_items where id = order_contents.item_id) as unit_variant_quantity')->where('order_id', $id)->get()->toArray();

        $totalCbmValue = 0;
        $orderData["contents"] = array_values(array_map(function ($item) use (&$totalCbmValue) {
            $totalCbmValue += $item["total_cbm"];
            if($item['thumbnail'] && Storage::exists('public/products/'.$item['thumbnail']))
                $item['thumbnail'] = '/storage/products/'.$item['thumbnail'];
            else
                $item['thumbnail'] = '/images/thumb-placeholder.jpg';
            
            return $item;
        }, $contents));
        $conts = $orderData['contents'];
        $orderData["total_cbm"] = $totalCbmValue;
        return $orderData;
    }

    public function assignmentsData($id){
        $assignments = SPA::selectRaw('id, item_id, item_quantity as assigned_qty, production_quantity, dispatched_quantity, assigned_employees, (SELECT qty from order_contents where id = supplier_product_assignment.content_id) as total_qty, (SELECT name from product_related_items where id = supplier_product_assignment.item_id) as item, (SELECT name from brand_related_products where id = (SELECT product_id from order_contents where id = supplier_product_assignment.content_id)) as product, supplier_id, (SELECT company_name from supplier where id = supplier_product_assignment.supplier_id) as supplier, batch, expected_delivery_date, follow_up_date, created_at, remarks, production_remarks, special_note, delay_reason, production_completed, activity_timeline')->whereRaw('delete_reason IS NULL and order_id = '.$id)->orderBy('id', 'desc')->get()->toArray();

        $data = [];

        $allBatches = array_values($this->unique_multidim_array($assignments, 'batch'));
        foreach ($allBatches as $key => $value) {
            $data[$key]['id'] = $value['id'];
            $data[$key]['batch'] = $value['batch'];
            $data[$key]['items'] = array_values(array_filter($assignments, function($item) use($value){
                return $item['batch'] == $value['batch'];
            }));
            $data[$key]['production_quantity'] = array_sum(array_column($data[$key]['items'], 'production_quantity'));
            $data[$key]['dispatched_quantity'] = array_sum(array_column($data[$key]['items'], 'dispatched_quantity'));
            $data[$key]['supplier_id'] = $data[$key]['items'][0]['supplier_id'];
            $data[$key]['supplier'] = $data[$key]['items'][0]['supplier'];
            $data[$key]['expected_delivery_date'] = $data[$key]['items'][0]['expected_delivery_date'];
            $data[$key]['follow_up_date'] = $data[$key]['items'][0]['follow_up_date'];
            $data[$key]['created_at'] = $data[$key]['items'][0]['created_at'];
            $data[$key]['assigned_employees'] = explode(",", $data[$key]['items'][0]['assigned_employees']);
            $data[$key]['remarks'] = $data[$key]['items'][0]['remarks'];
            $data[$key]['production_remarks'] = $data[$key]['items'][0]['production_remarks'];
            $data[$key]['special_note'] = $data[$key]['items'][0]['special_note'];
            $data[$key]['activity_timeline'] = json_decode($data[$key]['items'][0]['activity_timeline'], TRUE);
            $dispatchInProgress = SD::whereRaw("assignment_batch = '".$value['batch']."' and dispatch_done = 0")->orderBy('id', 'desc')->first();
            $data[$key]['dispatch_in_progress'] = $dispatchInProgress ? $dispatchInProgress->dispatch_batch : substr(str_shuffle("0123456789-ABCDEFGHI-03123XYZZZ"), 0, 30);
        }
        return $data;
    }
    
    public function SaveCbmCalcOnly(Request $request)
    {
        $o = O::find($request["order_id"]);
        $o->additional_weight = $request['additional_weight_ctn'];
        $o->actual_weight = $request['actual_net_weight'];
        $o->net_weight = $request['net_weight'];
        $o->updated_at = date('Y-m-d H:i:s');
        $o->updated_by = Auth::user()->id;
        $status = $o->save();
        return ['code' => 200];
    }
    
    public function SaveShipmentInfoOnly(Request $request)
    {
        $o = O::find($request["order_id"]);
        $o->expected_delivery_date = ($request['expected_delivery_date'] ? $request['expected_delivery_date'] : null);
        $o->port_of_loading = ($request['port_of_loading'] ? $request['port_of_loading'] : null);
        $o->port_of_discharge = ($request['port_of_discharge'] ? $request['port_of_discharge'] : null);
        $o->mode_of_shipment = ($request['mode_of_shipment'] ? $request['mode_of_shipment'] : null);
        $o->shipment_route = ($request['shipment_route'] ? implode(",", $request['shipment_route']) : null);
        $o->shipment_company = ($request['shipment_company'] ? $request['shipment_company'] : null);
        $o->quoted_freight_charges = ($request['quoted_freight_charges'] ? $request['quoted_freight_charges'] : null);
        $o->updated_at = date('Y-m-d H:i:s');
        $o->updated_by = Auth::user()->id;
        $status = $o->save();
        return ['code' => 200];
    }
    
    public function DeleteSuppAssignment(Request $request){
        SPA::where('batch', $request->batch)->update([
            'delete_reason' => $request->reason
        ]);
        return ['code' => 200];
    }

    public function AssignSupplier(Request $request){
        $batch = substr(str_shuffle("0123456789-ABCDEFGHIJkL"), 0, 20).'-'.time();
        foreach ($request->contents as $key => $value) {
            $spa = new SPA;
            $spa->content_id = $value['content_id'];
            $spa->item_id = $value['item_id'];
            $spa->item_quantity = $value['item_quantity'];
            $spa->follow_up_date = $value['follow_up_date'];
            $spa->expected_delivery_date = $value['expected_delivery_date'];
            $spa->assigned_employees = implode(",", $value['assigned_employees']);
            $spa->special_note = $value['special_notes'];
            $spa->remarks = $value['remarks'];
            $spa->order_id = $value['order_id'];
            $spa->batch = $batch;
            $spa->supplier_id = $value['supplier_id'];
            $spa->save();
        }
        SPA::where('batch', $batch)->update(['activity_timeline' => json_encode([ [ 'at' => date('Y-m-d H:i:s'), 'picture' => Auth::user()->picture, 'employee_id' => Auth::user()->id, 'employee' => Auth::user()->name, 'activity_type' => 'assignment', 'data' => [ 'supplier' => $request->contents[0]['supplier_id'], 'edt' => $request->contents[0]['expected_delivery_date'], 'remarks' => $request->contents[0]['remarks'] ] ] ]) ]);
        return ['code' => 200];
    }
    
    public function ReportDelay(Request $request){
        $spa = SPA::where('batch', $request->batch)->first();

        $activity_timeline = $spa->activity_timeline ? json_decode($spa->activity_timeline, TRUE) : [];
        $activity_timeline[] = [ 'at' => date('Y-m-d H:i:s'), 'picture' => Auth::user()->picture, 'employee_id' => Auth::user()->id, 'employee' => Auth::user()->name, 'activity_type' => 'delay', 'before_updated' => [ 'old_expected_delivery_date' => $spa->expected_delivery_date, 'old_reason' => $spa->delay_reason ? $spa->delay_reason : '' ], 'new_edt' => $request->expected_delivery_date, 'new_reason' => $request->delay_reason ];

        $data = [
            'activity_timeline' => json_encode($activity_timeline)
        ];

        SPA::where('batch', $request->batch)->update($data);
        
        return ['code' => 200];
    }
    
    public function MarkComplete(Request $request){
        $spa = SPA::where('batch', $request->batch)->first();

        $activity_timeline = $spa->activity_timeline ? json_decode($spa->activity_timeline, TRUE) : [];
        $activity_timeline[] = [ 'at' => date('Y-m-d H:i:s'), 'picture' => Auth::user()->picture, 'employee_id' => Auth::user()->id, 'employee' => Auth::user()->name, 'activity_type' => 'completed' ];

        $activity_timeline = json_encode($activity_timeline);
        $batch = $request->batch;

        $query = "UPDATE supplier_product_assignment as spa SET spa.production_completed = 1, spa.activity_timeline = '$activity_timeline', spa.production_quantity = spa.item_quantity where batch = '$batch'";

        DB::statement($query);
        return ['code' => 200];
    }

    public function SaveProductionQty(Request $request){
        $batch = null;
        $produced_qty = 0;
        foreach ($request->data as $key => $value) {
            $spa = SPA::find($value['assignment_id']);
            $batch = $spa->batch;
            $spa->production_quantity = $value['production_quantity'];
            $spa->production_remarks = $request['remarks'];
            $spa->follow_up_date = $request['follow_up_date'];
            $spa->save();
            $produced_qty += $value['production_quantity'];
        }

        $total_qty = DB::table('supplier_product_assignment')->selectRaw('SUM(item_quantity) as total_quantity')->where('batch', $batch)->first();

        DB::table('supplier_product_assignment')->where('batch', $batch)->update([
            'production_completed' => ($total_qty->total_quantity == $produced_qty ? 1 : 0)
        ]); 

        $actiTline = SPA::where('batch', $batch)->first()->activity_timeline;
        $activity_timeline = $actiTline ? json_decode($actiTline, TRUE) : [];
        $activity_timeline[] = [ 'at' => date('Y-m-d H:i:s'), 'picture' => Auth::user()->picture, 'employee_id' => Auth::user()->id, 'employee' => Auth::user()->name, 'activity_type' => 'production', 'data' => [ 'remarks' => $request['remarks'] ] ];

        SPA::where('batch', $batch)->update([ 'activity_timeline' => json_encode($activity_timeline) ]);

        return ['code' => 200];
    }

    public function UpdateSupplierAssignment(Request $request){
        $oldSupplierId = SPA::where('batch', $request->contents[0]['batch'])->first();
        foreach ($request->contents as $key => $value) {
            $spa = new SPA;
            $reassigned = [];
            if($value['assignment_id']){
                $spa = SPA::find($value['assignment_id']);
                $revisions = $spa->revisions ? json_decode($spa->revisions) : [];
                unset($spa['revisions']);
                $revisions[] = [ 'at' => date('Y-m-d H:i:s'), 'picture' => Auth::user()->picture, 'employee_id' => Auth::user()->id, 'employee' => Auth::user()->name, 'before_updated' => $spa->toArray() ];
                $spa->revisions = json_encode($revisions);
            }

            $spa->content_id = $value['content_id'];
            $spa->item_id = $value['item_id'];
            $spa->item_quantity = $value['item_quantity'];
            $spa->follow_up_date = $value['follow_up_date'];
            $spa->expected_delivery_date = $value['expected_delivery_date'];
            $spa->assigned_employees = implode(",", $value['assigned_employees']);
            $spa->special_note = $value['special_notes'];
            $spa->remarks = $value['remarks'];
            $spa->order_id = $value['order_id'];
            $spa->batch = $value['batch'];
            $spa->supplier_id = $value['supplier_id'];
            $spa->activity_timeline = $oldSupplierId->activity_timeline;
            $spa->save();
        }

        //Reassigned Data
        $reassignedData = SPA::where('batch', $request->batch)->first();
        if($reassignedData->supplier_id != $oldSupplierId->supplier_id){
            $activity_timeline = $reassignedData->activity_timeline ? json_decode($reassignedData->activity_timeline, TRUE) : [];
            $activity_timeline[] = [ 'at' => date('Y-m-d H:i:s'), 'picture' => Auth::user()->picture, 'employee_id' => Auth::user()->id, 'employee' => Auth::user()->name, 'activity_type' => 'reassignment', 'data' => [ 'batch' => $reassignedData->batch, 'updated_by' => Auth::user()->id, 'before_updated' => [ 'old_supplier_id' => $oldSupplierId->supplier_id, 'new_supplier_id' => $reassignedData->supplier_id, 'old_edt' => $oldSupplierId->expected_delivery_date, 'new_edt' => $reassignedData->expected_delivery_date, 'new_remarks' => $reassignedData->remarks ] ] ];
            SPA::where('batch', $request->batch)->update([ 'activity_timeline' => json_encode($activity_timeline) ]);
        }

        if(!$request->removed || !sizeof($request->removed))
            return ['code' => 200];
    
        foreach ($request->removed as $key => $value) {
            SPA::find($value)->delete();
        }
        return ['code' => 200];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $dispatchBatch = null)
    {
      
        if(SD::whereRaw('dispatch_batch = "'.$dispatchBatch.'" and dispatch_done = 1')->first())
            return redirect('/OrderDetails/'.$id);
            
        $customer_name = DB::table('orders')->selectRaw("id, (Select company_name from customers where id = orders.customer_id) as customer_name, (Select address from customers where id = orders.customer_id) as customer_address")->where('id', $id)->first();
        
        $custCities = Cust::selectRaw('city')->whereRaw('city IS NOT NULL')->get();
        $custCities = $custCities ? json_decode(json_encode($custCities), TRUE) : [ 'Karachi' ];
        $allCities = array_map('strtolower', array_column($custCities, 'city'));
        $allCities = array_unique($allCities);
        $certificates = DB::table('certificates_detail')->where('order_id', $id)->get();

        
        return view('orders-management.dispatch-order', ['order' => $this->getOrdersDataForDispatch($id, $dispatchBatch), 'ports' => \App\Ports::all(), 'shippers' => \App\ShippingCompany::all(), 'forwarders' => DB::table('forwarder')->get(), 'customer_name' => $customer_name, 'all_cities' => $allCities, 'certificates' => $certificates]);
    }

    public function SaveLeftoverStock(Request $req, $oid){
        LOS::where('order_id', $oid)->delete();
        $order = O::find($oid);
        $stock = $req->data;
        $itmIds = implode(",", array_column($stock, "item_id"));
        $contents = OC::whereRaw("order_id = $oid AND item_id IN ($itmIds)")->get()->toArray();
        foreach ($stock as $key => $s) {
            $indFnd = array_search($s['item_id'], array_column($contents, 'item_id'));
            $uPrice = $indFnd !== false ? $contents[$indFnd]['unit_price'] : 0;
            $cbm = $indFnd !== false ? $contents[$indFnd]['cbm'] : 0;
            $los = new LOS;
            $itemExistForThisCustomer = LOS::whereRaw('customer_id = '.$order->customer_id.' AND item_id = '.$s['item_id'])->first();
            if($itemExistForThisCustomer)
                $los = $itemExistForThisCustomer;
            $los->item_id = $s['item_id'];
            $los->stock_qty = $itemExistForThisCustomer ? $itemExistForThisCustomer->stock_qty+$s['stock_qty'] : $s['stock_qty'];
            $los->left_over_qty = $itemExistForThisCustomer ? $itemExistForThisCustomer->left_over_qty+$s['left_over_qty'] : $s['left_over_qty'];
            $los->stock_price = ROUND($uPrice*$los->left_over_qty, 2);
            $los->stock_unit_price = $uPrice;
            $los->expiry_date = $s['expiry'];
            $los->order_id = $oid;
            $los->customer_id = $order->customer_id;
            $los->save();
        }
        $order->current_status = "processed";
        $order->save();
        return ['code' => 200]; 
    }

    public function getOrdersDataForDispatch($id, $dispatchBatch = null){
        //Show dispatch order page
        $order = O::find($id)->toArray();
        $dispatch = SD::selectRaw('count(id), id, invoice_num, eform_num, currency, currency_symbol, net_weight, actual_weight, order_type, country_of_origin, expected_delivery_date, date_of_shipment, port_of_loading, port_of_discharge, mode_of_shipment, shipment_route, shipment_company, quoted_freight_charges, insurance_charges, forwarder, vessel_number, actual_freight_charges, discharge_date, shipping_documents, eform_documents, bank_name, all_documents, container_types, eta_date, issue_date, voyage_number, vessel_name, omi_number, quoted_charges_currency, actual_freight_currency, insurance_charges_currency, contents, assignment_batch, dispatch_batch, order_id, dispatch_done, created_at, created_by, updated_at, updated_by')->whereRaw("dispatch_batch = '$dispatchBatch' and dispatch_done = 0")->first()->toArray();
        $ordersData = $dispatch;
        $ordersData["order_id"] = $order['id'];
        $ordersData["invoice_num"] = $order['invoice_num'];
        $ordersData["payment_type"] = $order['payment_type'];
        $customerInfo = DB::table('customers')->selectRaw('country, city')->whereRaw('id = (SELECT customer_id from orders where id = '.$id.')')->first();
        $ordersData["customer_country"] = $customerInfo->country;
        $ordersData['order_type'] = $order['order_type'];
        $ordersData['currency'] = $ordersData['currency'] ? $ordersData['currency'] : $order['currency'];
        $ordersData['currency_symbol'] = $ordersData['currency_symbol'] ? $ordersData['currency_symbol'] : $order['currency_symbol'];
        $ordersData['expected_delivery_date'] = $ordersData['expected_delivery_date'] ? $ordersData['expected_delivery_date'] : $order['expected_delivery_date'];
        $ordersData['port_of_discharge'] = $ordersData['port_of_discharge'] ? $ordersData['port_of_discharge'] : $order['port_of_discharge'];
        $ordersData['shipment_company'] = $ordersData['shipment_company'] ? $ordersData['shipment_company'] : $order['shipment_company'];
        $ordersData['forwarder'] = $ordersData['forwarder'] ? $ordersData['forwarder'] : $order['forwarder'];
        $ordersData['actual_freight_charges'] = $ordersData['actual_freight_charges'] ? $ordersData['actual_freight_charges'] : $order['actual_freight_charges'];
        $ordersData['quoted_freight_charges'] = $ordersData['quoted_freight_charges'] ? $ordersData['quoted_freight_charges'] : $order['quoted_freight_charges'];
        $ordersData["customer_city"] = $customerInfo->city;
        $ordersData["issue_date"] = $dispatch['issue_date'] ? $dispatch['issue_date'] : $order['issue_date'];
        $ordersData["total_amount"] = number_format($order['total_amount']);
        $ordersData['shipment_route'] = $dispatch['shipment_route'] ? explode(",", $dispatch['shipment_route']) : explode(",", $order['shipment_route']);
        $ordersData['container_types'] = $dispatch['container_types'] ? json_decode($dispatch['container_types']) : [];
        $ordersData['eform_num'] = ($dispatch['eform_num'] ? $dispatch['eform_num'] : 'E-'.substr(str_shuffle("0123456789ABCUVWXYZ"), 0, 10));
        
        $ordersData['shipping_documents'] = json_decode($dispatch['shipping_documents']);
        $ordersData['eform_documents'] = json_decode($dispatch['eform_documents']);
        $ordersData['all_documents'] = json_decode($dispatch['all_documents']);
        $ordersData["custom_invoice"] = [];
        
        if($dispatch && $dispatch['id']){
            $data = CI::where('supplier_dispatch_id', $dispatch['id'])->first();

            $data = $data ? $data->toArray() : [];

            foreach ($data as $key => $value) {
                if($key == "contents")
                    $value = json_decode($value, TRUE);
                $key = $key == "id" ? "custom_invoice_id" : $key;
                $ordersData["custom_invoice"][$key] = $value;
            }
        }

        if(!sizeof($ordersData['custom_invoice'])){
            $ordersData['custom_invoice']['fob_value'] = $order['total_amount'];
            $ordersData['custom_invoice']['discount'] = $order['order_discount'];
            $ordersData['custom_invoice']['fob_currency'] = $order['currency'];
            $ordersData['custom_invoice']['discount_currency'] = $order['currency'];
        }

        $query = "order_id = ".$id." and id IN (SELECT content_id from (SELECT content_id, SUM(production_quantity) as produced, SUM(dispatched_quantity) as dispatched FROM `supplier_product_assignment` where order_id = 1 GROUP by content_id) as res_set where res_set.produced > 0 and res_set.dispatched != res_set.produced)";
        
        $contents = json_decode(json_encode(DB::table('supplier_product_assignment as spa')->selectRaw("id, batch, item_id, supplier_id, (SELECT company_name from supplier where id = spa.supplier_id) as supplier, (SELECT name from brand_related_products where id = (SELECT product_id from order_contents where id = spa.content_id)) as product_name, (SELECT name from product_related_items where id = spa.item_id) as item_name, (SELECT qty from order_contents where id = spa.content_id) as qty, (SELECT gross_weight from order_contents where id = spa.content_id) as gross_weight, (SELECT from_ctn_no from order_contents where id = spa.content_id) as from_ctn_no, (SELECT commercial_amount from order_contents where id = spa.content_id) as commercial_amount, (SELECT weight_per_ctn from order_contents where id = spa.content_id) as weight_per_ctn, (SELECT to_ctn_no from order_contents where id = spa.content_id) as to_ctn_no, (SELECT total_cbm from order_contents where id = spa.content_id) as total_cbm, (SELECT commercial_unit_price from order_contents where id = spa.content_id) as commercial_unit_price, (SELECT dispatch_actual_NW from order_contents where id = spa.content_id) as dispatch_actual_NW, item_quantity as assigned_qty, production_quantity, dispatched_quantity, batch, production_completed, content_id, (SELECT unit_weight from product_related_items where id = spa.item_id) as unit_weight, (SELECT unit_quantity from product_related_items where id = spa.item_id) as unit_quantity")->whereRaw("order_id = $id and production_quantity > 0 AND delete_reason IS NULL AND production_quantity != dispatched_quantity")->get()), TRUE);

        $ordersData['products_selection'] = false;
        $sd = SD::where('dispatch_batch', $dispatchBatch)->first();
        if($sd && $sd->contents){
            if($sd->contents){
                $contentsList = json_decode($sd->contents, TRUE);
                if(isset($contentsList['dispatch_products_selected'])){
                    foreach($contents as $key => $value){
                        $indFnd = array_search($value['id'], array_column($contentsList['dispatch_products_selected'], 'assignment-id'));
                        if($indFnd !== false){
                            $contents[$key]['shipped_quantity'] = $contents[$key]['dispatched_quantity'];
                            $contents[$key]['dispatched_quantity'] = $contentsList['dispatch_products_selected'][$indFnd]['qty'];
                        }else{
                            $contents[$key]['not_assigned_for_dispatch'] = 1;
                            $contents[$key]['shipped_quantity'] = 0;
                        }
                    }
                    $ordersData['products_selection'] = true;
                }
                if(isset($contentsList['packing_list']) && sizeof($contentsList['packing_list'])){
                    foreach($contents as $key => $value){
                        $indFnd = array_search($value['id'], array_column($contentsList['packing_list'], 'assignment-id'));
                        if($indFnd !== false){
                            $contents[$key]['from_ctn_no'] = $contentsList['packing_list'][$indFnd]['from_ctn_no'];
                            $contents[$key]['to_ctn_no'] = $contentsList['packing_list'][$indFnd]['to_ctn_no'];
                            $contents[$key]['gross_weight'] = $contentsList['packing_list'][$indFnd]['gross_weight'];
                            $contents[$key]['dispatch_actual_NW'] = $contentsList['packing_list'][$indFnd]['dispatch_actual_NW'];
                        }
                    }
                }
                if(isset($contentsList['commercial']) && sizeof($contentsList['commercial'])){
                    foreach($contents as $key => $value){
                        $indFnd = array_search($value['id'], array_column($contentsList['commercial'], 'assignment-id'));
                        if($indFnd !== false){
                            $contents[$key]['commercial_unit_price'] = $contentsList['commercial'][$indFnd]['commercial_unit_price'];
                            $contents[$key]['commercial_amount'] = $contentsList['commercial'][$indFnd]['commercial_amount'];
                        }
                    }
                }
            }
        }

        $ordersData["contents"] = $contents;

        //echo '<pre>'; print_r($ordersData["contents"]); die;

        $ordersData["total_cbm"] = array_sum(array_column($contents, 'total_cbm'));
        // $ordersData['batch'] = $batch;
        $ordersData['dispatch_batch'] = $dispatchBatch;
        return $ordersData;
    }

    public function DispatchOrderDocumentsUpload(Request $request, $type, $id, $dispatchBatch=null)
    {
        $file = $request->file('file');
        $completeFileName = $file->getClientOriginalName();
        $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $randomized = rand();
        $storedAs = $type . '-' . $randomized . '_' . time() . '.' . $extension;
        if($type == "all" && !$request->document_type_selected){
            return ['code' => 101];
        }
        $path = $file->storeAs('public/orders', $storedAs);
        DOD::insert([
            'file' => $storedAs,
            'ext' => $extension,
            'filename' => $completeFileName,
            'document_type' => ($request->document_type_selected ? $request->document_type_selected : $type),
            'order_id' => $id,
            'dispatch_batch' => $dispatchBatch
        ]);
        if($type == "all"){
            return ['code' => 200, 'data' => [
                'file' => $storedAs,
                'ext' => $extension,
                'filename' => $completeFileName,
                'document_type' => ($request->document_type_selected ? $request->document_type_selected : $type),
                'order_id' => $id,
                'dispatch_batch' => $dispatchBatch
            ] ];
        }
        return ['code' => 200, 'name' => $storedAs];
    }

    public function DeleteDispatchOrderDocuments(Request $request, $type, $orderId, $dispatchBatch=null)
    {
        if(Storage::exists('public/orders/'.$request->file)){
            Storage::delete('public/orders/'.$request->file);
        }
        $type = ($type == "Shipment" ? "shipping_documents" : ($type == "Eform" ? "eform_documents" : "all_documents"));
        $order = SD::whereRaw('dispatch_batch = "'.$dispatchBatch.'"')->first();
        $documents = json_decode($order[$type]);
        if($documents && is_array($documents)){
            $documents = array_values(array_filter($documents, function($item) use($request){
                return $request->file !== $item->stored_as;
            }));
            $order[$type] = json_encode($documents);
            $order->save();
        }
        DOD::where('file', $request->file)->delete();
    }

    public function SaveDispatchQty(Request $req, $orderId){
        $dispatchBatch = $req->dispatch_batch;
        $data = $req->data;

        $contentsList = [];
            
        $sd = SD::where('dispatch_batch', $dispatchBatch)->first();
        if(!$sd){
            $sd = new SD;
            $sd->created_at = date('Y-m-d H:i:s');
            $sd->assignment_batch = $req->data[0]['batch'];
            $sd->dispatch_batch = $dispatchBatch;
            $sd->order_id = $orderId;
            $sd->save();
        }
        if($sd && $sd->contents)
            $contentsList = json_decode($sd->contents, TRUE);
        $contentsList['dispatch_products_selected'] = isset($contentsList['dispatch_products_selected']) && sizeof($contentsList['dispatch_products_selected']) ? $contentsList['dispatch_products_selected'] : [];
        $contentsList['packing_list'] = [];
        $contentsList['commercial'] = [];
        foreach ($req->data as $key => $value) {
            if($value['qty'] > 0){
                $indFnd = array_search($value['assignment-id'], array_column($contentsList['dispatch_products_selected'], "assignment-id"));
                if($indFnd !== false)
                    $contentsList['dispatch_products_selected'][$indFnd] = ['item-id' => $value['item-id'], 'batch' => $value['batch'], 'content-id' => $value['content-id'], 'assignment-id' => $value['assignment-id'], 'supplier-id' => $value['supplier-id'], 'qty' => $value['qty'], 'already_dispatched' => $value['already_dispatched']];
                else
                    $contentsList['dispatch_products_selected'][] = ['item-id' => $value['item-id'], 'batch' => $value['batch'], 'content-id' => $value['content-id'], 'assignment-id' => $value['assignment-id'], 'supplier-id' => $value['supplier-id'], 'qty' => $value['qty'], 'already_dispatched' => $value['already_dispatched']];
            }
        }
        $sd->contents = json_encode($contentsList);
        $sd->save();
        return ['code' => 200, 'data' => $this->getOrdersDataForDispatch($orderId, $dispatchBatch)];
    }

    public function SaveOrderDispatchInfo(Request $request, $type, $orderId, $dispatchBatch=null){
        $sd = SD::whereRaw('dispatch_batch = "'.$dispatchBatch.'"')->first();
        if(!$sd){   
            $sd = new SD;
            $sd->order_id = $orderId;
            $sd->dispatch_batch = $dispatchBatch;
            $sd->assignment_batch = $assignmentBatch;
        }
        $docType = '';
        if($type == "Shipment"){
            $sd->order_type = $request->order_type;
            $sd->expected_delivery_date = $request->expected_delivery_date;
            $sd->eta_date = $request->eta_date;
            if($sd->order_type !== "FOB"){
                $sd->date_of_shipment = $request->date_of_shipment;
                $sd->port_of_discharge = $request->port_of_discharge;
                $sd->shipment_route = implode(",", $request->shipment_route);
                $sd->forwarder = $request->forwarder;
                $sd->shipment_company = $request->shipment_company;
                $sd->vessel_number = $request->vessel_number;
                $sd->quoted_freight_charges = $request->quoted_freight_charges;
                $sd->actual_freight_charges = $request->actual_freight_charges;
                $sd->discharge_date = $request->discharge_date;
                $sd->voyage_number = $request->voyage_number;
                $sd->vessel_name = $request->vessel_name;
                $sd->omi_number = $request->omi_number;
                $sd->quoted_charges_currency = $request->quoted_charges_currency;
                $sd->actual_freight_currency = $request->actual_freight_currency;
                $sd->insurance_charges_currency = $request->insurance_charges_currency;
                $sd->container_types = json_encode($request->container_types);
                if($sd->order_type == "CFI")
                    $sd->insurance_charges = $request->insurance_charges;
            }
            $docType = "shipping_documents";
        }else if($type == "Eform"){
            $sd->bank_name = $request->bank_name;
            $sd->eform_num = $request->eform_num;
            $sd->currency = $request->currency;
            $sd->currency_symbol = $request->currency_symbol;
            $sd->issue_date = $request->issue_date;
            $docType = "eform_documents";
        }else if($type == "PackingList"){
            $contentsList = [];
            if($sd && $sd->contents)
                $contentsList = json_decode($sd->contents, TRUE);
            $contentsList['packing_list'] = [];
            foreach ($request->data as $key => $item) {
                $contentsList['packing_list'][] = ['from_ctn_no' => $item['from_ctn_no'], 'to_ctn_no' => $item['to_ctn_no'], 'gross_weight' => $item['gross_weight'], 'batch' => $item['batch'], 'item-id' => $item['item_id'], 'assignment-id' => $item['assignment_id'], 'dispatch_actual_NW' => $item['dispatch_actual_NW'] ];
            }
            $sd->contents = json_encode($contentsList);
        }else if($type == "Commercial"){
            $contentsList = [];
            if($sd && $sd->contents)
                $contentsList = json_decode($sd->contents, TRUE);
            $contentsList['commercial'] = [];
            foreach ($request->data as $key => $item) {
                $contentsList['commercial'][] = ['commercial_unit_price' => $item['commercial_unit_price'], 'commercial_amount' => $item['commercial_amount'], 'batch' => $item['batch'], 'item-id' => $item['item_id'], 'assignment-id' => $item['assignment_id'] ];
            }
            $sd->contents = json_encode($contentsList);
        }else{
            $docType = 'all_documents';
        }

        $tmpDocsToDelete = [];
        if($type !== "PackingList" && $type !== 'Commercial'){
            $documents = json_decode($sd[$docType], TRUE);
            if($type !== "Commercial" && $type !== "PackingList" && $type !== "Eform" && $type !== "Shipment"){
                $docs = DOD::whereRaw('document_type NOT IN ("Commercial", "PackingList", "Eform", "Shipment")')->get()->toArray();
                $uniqueTypes = array_column($this->unique_multidim_array($docs, 'document_type'), "document_type");
                foreach ($uniqueTypes as $value) {
                    array_values(array_filter($docs, function($doc) use($value, &$documents, &$tmpDocsToDelete){
                        if($doc['document_type'] == $value){
                            $documents[$value][] = $doc;
                            $tmpDocsToDelete[] = $doc['id'];
                        }
                    }));
                }
            }else{
                $docs = DOD::whereRaw('dispatch_batch = "'.$dispatchBatch.'" and document_type = "'.$type.'"')->get();
                foreach($docs as $doc){
                    $documents[] = [ 'filename' => $doc->filename, 'ext' => $doc->ext, 'stored_as' => $doc->file ];
                    $tmpDocsToDelete[] = $doc->id;
                }
            }
            $sd[$docType] = json_encode($documents);
        }
        $sd->save();
        if(sizeof($tmpDocsToDelete))
            DOD::whereRaw('id IN ('.implode(",", $tmpDocsToDelete).')')->delete();

        return ['code' => 200, 'data' => $this->getOrdersDataForDispatch($orderId, $dispatchBatch)];
    }

    public function SaveCustomInvoice(Request $request, $orderId, $dispatchBatch=null){
        $sd = SD::where('dispatch_batch', $dispatchBatch)->first();
        if(!$sd){
            $sd = new SD;
            $sd->created_at = date('Y-m-d H:i:s');
            $sd->dispatch_batch = $dispatchBatch;
            $sd->order_id = $orderId;
            $sd->assignment_batch = $batch;
            $sd->save();
        }
        $ci = new CI;
        $data = $request->data ? $request->data : [];
        if(isset($data['custom_invoice_id']) && $data['custom_invoice_id']){
            $ci = CI::find($data['custom_invoice_id']);
            $ci['updated_at'] = date('Y-m-d H:i:s');
            $ci['updated_by'] = Auth::user()->id;
            unset($data['custom_invoice_id']);
        }
        foreach ($data as $key => $value) {
            if($key !== 'custom_invoice_id')
                $ci[$key] = $value;
        }
        $ci['contents'] = json_encode($request->items);
        $ci['order_id'] = $orderId;
        $ci['supplier_dispatch_id'] = $sd->id;
        $ci['dispatch_batch'] = $dispatchBatch;
        $ci['order_id'] = $orderId;
        $ci['created_by'] = Auth::user()->id;
        $ci->save();
        return ['code' => 200, 'data' => $this->getOrdersDataForDispatch($orderId, $dispatchBatch)];
    }

    public function updateOrderStatus(Request $req){
        $sd = SD::where('dispatch_batch', $req->dispatch_batch)->first();
        $contentsList = json_decode($sd->contents, TRUE)['dispatch_products_selected'];
        foreach($contentsList as $key => $value){
            $assignment = SPA::where('id', $value['assignment-id'])->first();
            $assignment->dispatched_quantity = $assignment->dispatched_quantity + $value['qty'];
            $assignment->save();
        }
        $sd->dispatch_done = 1;
        $sd->dispatched_at = date('Y-m-d H:i:s');
        $sd->save();
        echo true;
        die;
        $o = O::find($req->id);
        $o->current_status = $req->status;
        if(strtolower($req->status) == "completed"){
            $o->completed_at = date('Y-m-d H:i:s');
            $o->completed_by = Auth::user()->id;
        }else{
            $o->processed_at = date('Y-m-d H:i:s');
            $o->processed_by = Auth::user()->id;
        }
        if($o->save()){
            echo true;
        }else{
            echo false;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }

    public function viewPerforma($performaId, $supplierAssignedBatch = null)
    {
        $orders = O::selectRaw('id, po_num, total_amount, issue_date, invoice_num, currency, notes, terms, 
        (SELECT company_name from customers where id = orders.customer_id) as company, 
        (SELECT CONCAT(first_name, " ", IFNULL(last_name, "")) from customers where id = orders.customer_id) as poc,
         (SELECT country from customers where id = orders.customer_id) as country, 
         (SELECT city from customers where id = orders.customer_id) as city
         , order_discount, discount_value')
         ->where('id', $performaId)->first();
        $query = $supplierAssignedBatch ? "(SELECT special_note from supplier_product_assignment where batch = '$supplierAssignedBatch' and item_id = order_contents.item_id) as product_desc" : "product_desc";
        $contents = OC::selectRaw('item_id, qty, '.$query.', weight_per_unit, weight_per_ctn, cbm, total_cbm, unit_price, amount, (SELECT name from product_related_items where id = order_contents.item_id) as product, (SELECT description from product_related_items where id = order_contents.item_id) as product_description')->where('order_id', $performaId)->get();
        
        $items = PI::selectRaw('`id`, `name`, `description`, `unit_id`, `unit_weight`, `variant_id`, variant_id_2, variant_quantity_2, variant_id_3, variant_quantity_3, `unit_quantity`, `unit_variant_quantity`, `length`, `width`, `height`, `cbm_value`, `product_id`, (SELECT unit_name from item_units where id = product_related_items.unit_id) as unit_name, (SELECT variant_name from item_variants where id = product_related_items.variant_id) as variant_name, (CASE WHEN variant_id IS NOT NULL THEN (SELECT variant_name from item_variants where id = product_related_items.variant_id_2) END) as variant_2_name, (CASE WHEN variant_id IS NOT NULL THEN (SELECT variant_name from item_variants where id = product_related_items.variant_id_3) END) as variant_3_name, standrad_unit_price')->whereRaw("id IN (".implode(',', array_column(json_decode(json_encode($contents), TRUE), 'item_id')).")")->get()->toArray();

        echo json_encode(['basic_info' => $orders, 'contents' => $contents, 'items' => $items]);
    }

    public function GetBankAccounts(){
        echo json_encode(DB::table('accounts')->get());
    }

    public function save_payment_from_OrderListing(Request $request){
        $insert = DB::table('payments')->insert([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'bank_name' => $request->bank_name,
            'cheque_num' => $request->cheque_num,
            'cheque_date' => $request->cheque_date ? $request->cheque_date : $request->transaction_date_cash,
            'account_num' => $request->account_num,
            'exchange_rate' => $request->exchange_rate,
            'currency' => $request->currency,
            'currency_symbol' => $request->currency_symbol,
            'advance_paid' => $request->advance_paid,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id
        ]);
		
		if($insert){
            if(isset($request->customer_balance) && $request->customer_balance != 0){
                $cust = \App\CustomerBalance::where('customer_id', O::find($request->order_id)->customer_id)->first();
                if($cust){
                    $cust->amount -= $request->customer_balance;
                    $cust->save();
                    $ct = new \App\CustomerTransaction;
                    $ct->balance_id = $cust->id;
                    $ct->amount = $request->customer_balance;
                    $ct->order_id = $request->order_id;
                    $ct->save();
                }
            }
            if($request->all_payment_paid == 1){
                DB::table('orders')->where('id', $request->order_id)->update([
                    'payment_received' => 1
                ]);
            }
            echo json_encode('success');
        }else{
            echo json_encode('failed');
        }
       
    }

    public function save_certificate_detail(Request $request){
        if(DB::table('certificates_detail')->whereRaw("order_id = $request->order_id AND batch = '$request->batch' AND type = '$request->type'")->first()){
            try{
                DB::table('certificates_detail')->whereRaw("order_id = $request->order_id AND batch = '$request->batch' AND type = '$request->type'")->update([
                    'text' => $request->paragraph,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                echo json_encode('success'); 
            }catch(\Illuminate\Database\QueryException $ex){ 
                echo json_encode('failed'); 
            }
        }else{
            $insert = DB::table('certificates_detail')->insert([
                'order_id' => $request->order_id,
                'type' => $request->type,
                'batch' => $request->batch,
                'text' => $request->paragraph,
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            if($insert){
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }
        
    }

    public function CompletedOrderDetail($id){
        $order_core = DB::table('orders as oc')->selectRaw('id, expected_delivery_date, discharge_date, Date(created_at) as created_at, Date(completed_at) as completed_at, IFNULL(po_num, "-") as po_num, IFNULL(order_type, "-") as order_type, date_of_shipment, invoice_num as eform_num, currency_symbol, total_amount, (Select company_name from customers where id = oc.customer_id) as customer_name, (Select company_name from shipping_company where id = oc.shipment_company) as shipment_company, (Select company_name from forwarder where id = oc.forwarder) as forwarder, (Select port_name from delivery_ports where id = oc.port_of_discharge) as port_of_discharge, (Select all_documents from supplier_dispatches where order_id = oc.id) as documents')->where('id', $id)->first();
        $order_content = DB::table('order_contents as oc')->selectRaw('id, product_id, (Select name from brand_related_products where id = oc.product_id) as product_name, (Select name from product_related_items where id = oc.item_id) as item_name, order_id, qty, FORMAT(unit_price, 2) as unit_price, ROUND(weight_per_unit, 2) as weight_per_unit, ROUND(weight_per_ctn, 2) as weight_per_ctn, FORMAT(amount, 2) as amount, cbm, total_cbm')->where('order_id', $id)->get();
        $payments = DB::table('payments')->selectRaw('id, Date(created_at) as created_at, type, amount, currency_symbol')->where('order_id', $id)->get();
        
        $assigned_suppliers = DB::table('supplier_product_assignment as spa')->selectRaw('id, (Select company_name from supplier where id = spa.supplier_id) as supplier, (Select name from product_related_items where id = spa.item_id) as item_name, (Select name from brand_related_products where id = (Select product_id from product_related_items where id = spa.item_id)) as product_name, item_quantity')->where('order_id', $id)->get();

        return view('orders-management.completed_order_detail', ['order_core' => $order_core, 'order_content' => $order_content, 'payments' => $payments, 'assigned_suppliers' => $assigned_suppliers, 'ship_doc_url' => URL::to('/').'/storage/orders'.'/']);
    }

    function saveAdvPmt(Request $r){
        $cb = new \App\CustomerBalance;

        $exist = \App\CustomerBalance::where('customer_id', $r->customer_id)->first();
        if($exist)
            $cb = $exist;

        $oldData = $cb->toArray();
        unset($oldData['advance_history']);
        $advHistory = $cb->advance_history ? json_decode($cb->advance_history, TRUE) : [];
        $advHistory[] = [ 'oldData' => $oldData, 'updated_at' => date('Y-m-d H:i:s') ];
        $cb->customer_id = $r->customer_id;
        $cb->transaction_date = $r->transDate;
        $cb->transaction_type = $r->transType;
        $cb->employee_id = Auth::user()->id;
        if($r->transType == 2){
            $cb->bank_name = $r->bank;
            $cb->transaction_num = $r->transNum;
            $cb->account = $r->account;
        }
        $cb->amount = $cb->amount ? $cb->amount+$r->amount : $r->amount;
        $cb->advance_history = json_encode($advHistory);

        return ($cb->save() ? 200 : 201);
    }

    function PendingPayments(){
        return view('orders-management.pending-payments', [ 'orders' => DB::table('orders as o')->selectRaw('o.id, c.company_name, o.issue_date, o.po_num, o.payment_received, u.name, o.total_amount, IFNULL(o.advance,0) as advance, LOWER(o.current_status) as current_status, o.discount_value, o.currency_symbol, IFNULL((Select SUM(p.amount) from payments p where p.order_id = o.id), 0) as paid_amt, IFNULL((SELECT amount from customer_balance where customer_id = c.id), 0) as balance')
        ->join('customers as c', 'o.customer_id', '=', 'c.id')
        ->join('users as u', 'o.employee_id', '=', 'u.id')->get()]);
    }

    function unique_multidim_array($array, $key) {
        $temp_array     =   array();
        $i              =   0;
        $key_array      =   array();
       
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i]      =   $val[$key];
                $temp_array[$i]     =   $val;
            }
            $i++;
        }
        return $temp_array;
    }
    public function order_listing($id)
    {
        $order                  =       Orders::find($id);
        $customer_id            =       $order->customer_id;
        $order_contents         =       OrderContents::where('order_id',$id)->get();
        foreach($order_contents as $content){
            $item = PI::find($content->item_id);
            $content->name                  =       $item->description;
            $stock_available                =       StockMangment::where('customer_id', $customer_id)->where('item_id',$content->item_id)->latest()->first();
            $content->available_stock = 0;
            if($stock_available){
                $content->available_stock   =       $stock_available->balance;
                $content->customer_id       =       $customer_id;
            }
            
        }
        $shipping_companies             =       DB::table('shipping_company')->get();
        $delivery_ports                 =       DB::table('delivery_ports')->get();
        $forwarders                     =       DB::table('forwarder')->get();
        $customer                       =       DB::select("SELECT * FROM customers WHERE id =  $order->customer_id");
        $customer                       =       collect($customer)->first();
        if($customer){
            $customer_address           =       "";
            $temp                       =       json_decode($customer->address);
            dd($temp);
        }
        return view('orders.order-dispatch',compact('order_contents','shipping_companies','delivery_ports','order','forwarders','customer'));
    }
    public function dispatch_order(Request $request){
        $customer_id            =       $request->customer_id;
        $order_id               =       $request->order_id;
        $ordered_qty            =       $request->ordered_qty;
        $dispatch_qty           =       $request->dispatch_qty;
        $ttl_products           =       0;
        if(collect($ordered_qty)->count() > 0 ){
            foreach ($dispatch_qty as $qty){
                $ttl_products += $qty;
            }
        }
        $dispatch                               =   new OrderDispatch();
        $dispatch->customer_id                  =   $customer_id;
        $dispatch->order_id                     =   $order_id;
        $dispatch->ttl_products                 =   $ttl_products;
        $dispatch->created_by                   =   Carbon::now();
        $dispatch->updated_by                   =   Carbon::now();
        $dispatch->save();
        $dispatch_id                            =   $dispatch->id;
        foreach($dispatch_qty as $item_id=>$value){
            $dispatch_detail                    =   new DispatchDetail();
            $dispatch_detail->dispatch_id       =   $dispatch_id;
            $dispatch_detail->order_id          =   $order_id;
            $dispatch_detail->customer_id       =   $customer_id;
            // $brand_related_product = BrandProducts::find();
            $product_related_item               =   PI::find($item_id);
            $dispatch_detail->product_id        =   $product_related_item ? $product_related_item->product_id : 0 ;
            $brand_related_product              =   BrandProducts::find($dispatch_detail->product_id);
            $dispatch_detail->brand_id          =   $brand_related_product  ? $brand_related_product ->brand_id : 0 ;
            $dispatch_detail->item_piece_qty    =   $value;
            $dispatch_detail->save();
            $stock = StockMangment::where('customer_id',$customer_id)->where('item_id',$item_id)->latest()->first();
            $stock->quantity                =   $value;
            $stock->balance                 =   $stock->balance - $value ;
            $stock->state = "out";
            $stock->transaction_type        =   "dispatch";
            unset($stock->id);
            $update_stock = new StockMangment($stock->toArray());
            $update_stock->save();
        }   
        return "success";
        

    }
    public function dispatch_shipping_information(Request $request){
        
       // this submission is not complete consult with boss and complete it.
        $dispatch_shipping_info = new DispatchShippingInformation();
        $dispatch_shipping_info->date_of_shipment           =   $request->date_of_shippment;
        $dispatch_shipping_info->shipping_company           =   $request->shipping_company;
        $dispatch_shipping_info->frieght_forwardar          =   $request->freight_forwarder;
        $dispatch_shipping_info->eta                        =   $request->eta;
        $dispatch_shipping_info->etd                        =   $request->etd;
        $dispatch_shipping_info->discharge_date             =   $request->discharge_date;
        $dispatch_shipping_info->voyage_number              =   $request->voyage_number;
        $dispatch_shipping_info->vessel_name                =   $request->vessel_name;
        $dispatch_shipping_info->vessel_number              =   $request->vessel_number;
        $dispatch_shipping_info->omi_number                 =   $request->omi_number;
        $dispatch_shipping_info->qouted_charges_currency    =   $request->quoted_charges_currency;
        $dispatch_shipping_info->qouted_charges_amount      =   $request->qouted_charges;
        $dispatch_shipping_info->actual_charges_currency    =   $request->actual_charges_currency;
        $dispatch_shipping_info->actual_charges_amount      =   $request->actual_charges;
        $dispatch_shipping_info->save();
        return "success";
      
    }

}
