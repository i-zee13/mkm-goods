<?php

namespace App\Http\Controllers;

use App\Brands as B;
use App\Customer as Cust;
use App\Http\Controllers\Core\AccessRightsAuth;
use App\OrderContents;
use App\Performa;
use App\Performa as O;
use App\PerformaContents as OC;
use App\Payments as P;
use App\ProductItems as PI;
use App\BrandProducts as BP;
use Auth;
use DB;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use URL;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Config;
use App\ItemUnits;
use File;
use App\Mail\OrderInvoice;
use App\Ports;
use App\LOS;
use App\PerformaContents;
use App\Supplier as S;
//use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\PDF as PDF ;
//use PDF;

class Performas extends AccessRightsAuth
{

    public $controllerName = "Performas";

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('performas.create', ['brands' => B::all(), 'customers' => Cust::selectRaw('id, company_name')->get(), 'types' => DB::table('customer_types')->get(), 'units' => DB::table('item_units')->get(), 'variants' => DB::table('item_variants')->get(), 'ports' => Ports::all(), 'shipping_companies' => \App\ShippingCompany::all(), 'doc_type' => DB::table('document_types')->get(), 'products' => BP::all(), 'services' => DB::table('main_services')->get(), 'acquisition' => DB::table('acquisition_source')->get()]);
    }

    public function get_customers_products(Request $request){

        $allProducts = BP::where('brand_id', '>',0)->get()->toArray();
        $allItems = PI::selectRaw('`id`,`custom_id`, `name`, `description`, `unit_id`, `unit_weight`, `variant_id`, variant_id_2, variant_quantity_2, variant_id_3, variant_quantity_3, `unit_quantity`, `unit_variant_quantity`, `length`, `width`, `height`, `cbm_value`, `product_id`, `variant_1_packiging_weigth`, `variant_2_packiging_weigth`, `variant_3_packiging_weigth`, `variant_unit_price`, `master_carton_packiging_weigth`, `net_weight`, `gross_weight`, (SELECT unit_name from item_units where id = product_related_items.unit_id) as unit_name,(SELECT price from fix_prices_for_customers where item_id = product_related_items.id AND product_id=product_related_items.product_id AND customer_id='.$request->customer_id.') as fix_price_for_customer, (SELECT variant_name from item_variants where id = product_related_items.variant_id) as variant_name, (CASE WHEN variant_id IS NOT NULL THEN (SELECT variant_name from item_variants where id = product_related_items.variant_id_2) END) as variant_2_name, (CASE WHEN variant_id IS NOT NULL THEN (SELECT variant_name from item_variants where id = product_related_items.variant_id_3) END) as variant_3_name, standrad_unit_price')->get()->toArray();
        foreach ($allProducts as $key => $value) {
            $allProducts[$key]['items'] = array_values(array_filter($allItems, function($item) use($value){
                return $item['product_id'] == $value["id"];
            }));
        }

        echo json_encode(['products' => $allProducts]);

    }

    public function GetProductsList()
    {
        $allProducts = BP::where('brand_id', 2)->get()->toArray();
        $allItems = PI::selectRaw('`id`, `name`, `description`, `unit_id`, `unit_weight`, `variant_id`, variant_id_2, variant_quantity_2, variant_id_3, variant_quantity_3, `unit_quantity`, `unit_variant_quantity`, `length`, `width`, `height`, `cbm_value`, `product_id`, (SELECT unit_name from item_units where id = product_related_items.unit_id) as unit_name, (SELECT variant_name from item_variants where id = product_related_items.variant_id) as variant_name, (CASE WHEN variant_id IS NOT NULL THEN (SELECT variant_name from item_variants where id = product_related_items.variant_id_2) END) as variant_2_name, (CASE WHEN variant_id IS NOT NULL THEN (SELECT variant_name from item_variants where id = product_related_items.variant_id_3) END) as variant_3_name, standrad_unit_price')->get()->toArray();
        foreach ($allProducts as $key => $value) {
            $allProducts[$key]['items'] = array_values(array_filter($allItems, function($item) use($value){
                return $item['product_id'] == $value["id"];
            }));
        }

        $contents = \App\OrderContents::selectRaw('item_id, (SELECT customer_id from orders where id = order_contents.order_id) as customer_id, unit_price')->orderBy('id', 'desc')->get()->toArray();
        return ['products' => $allProducts, 'items' => $contents];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = ["order_info" => json_decode($request->performa, true)];

        $o = new O;
        try {

            $o->customer_id = ($data["order_info"]["customer_id"] ? $data["order_info"]["customer_id"] : null);
            $o->employee_id = Auth::user()->id;
            $o->issue_date = ($data["order_info"]["issue_date"] ? $data["order_info"]["issue_date"] : null);
            $o->po_num = ($data["order_info"]["po_number"] ? $data["order_info"]["po_number"] : null);
            $o->total_amount = $data["order_info"]["totalAmount"]; /// without discount
            $o->overall_amount = $data["order_info"]["completePrice"]; /// with all charges and discount
            $o->total_ctn = $data["order_info"]["total_ctn"]; /// complete total item ctn
            $o->currency = str_replace(".", "", $data["order_info"]["currency"]);
            $o->currency_symbol = $data["order_info"]["currency_symbol"];
            $o->notes = $data["order_info"]["notes"];
            $o->terms = $data["order_info"]["terms"];
            //$o->net_weight = ($data["order_info"]["net_weight"] ? $data["order_info"]["net_weight"] : null);
            //$o->actual_weight = ($data["order_info"]["actual_net_weight"] ? $data["order_info"]["actual_net_weight"] : null);
            //$o->additional_weight = ($data["order_info"]["additional_weight_ctn"] ? $data["order_info"]["additional_weight_ctn"] : null);
            $o->order_type = ($data['order_info']['order_type'] ? $data['order_info']['order_type'] : null);
            $o->country_of_origin = $data['order_info']['country_of_origin'];
            $o->expected_delivery_date = ($data['order_info']['expected_delivery_date'] ? $data['order_info']['expected_delivery_date'] : null);
            $o->port_of_loading = ($data['order_info']['port_of_loading'] ? $data['order_info']['port_of_loading'] : null);
            $o->port_of_discharge = ($data['order_info']['port_of_discharge'] ? $data['order_info']['port_of_discharge'] : null);
            $o->mode_of_shipment = $data['order_info']['mode_of_shipment'];
            $o->shipment_route = implode(",", $data['order_info']['shipment_route']);
            $o->shipment_company = ($data['order_info']['shipment_company'] ? $data['order_info']['shipment_company'] : null);
            $o->actual_freight_charges = ($data['order_info']['totalFreight'] ? $data['order_info']['totalFreight'] : null);
            $o->totalGenset = ($data['order_info']['totalGenset'] ? $data['order_info']['totalGenset'] : null);
            //$o->quoted_freight_charges = ($data['order_info']['quoted_freight_charges'] ? $data['order_info']['quoted_freight_charges'] : null);
            $o->insurance_charges = ($data['order_info']['totalInsurance'] ? $data['order_info']['totalInsurance'] : null);
            $o->current_status = 'draft';
            $o->order_discount = $data["order_info"]['discount'];
            //$o->discount_value = ($data["order_info"]['order_discount'] ? (($data["order_info"]['order_discount'] / 100) * array_sum(array_column($data["contents"], "total_amount"))): 0);
            $o->created_at = date('Y-m-d H:i:s');
            //$o->advance = $data['order_info']['advance'] ? $data['order_info']['advance'] : 0;
            //$o->payment_type = $data['order_info']['payment_type'];

            $status = $o->save();


        } catch (\Illuminate\Database\QueryException $ex) {
            return json_encode(['code' => 101, 'message' => $ex]);
        }

        $faultyData = [];
        $leftOverStock = $request->leftOverStock;

        foreach ($data['order_info']['content'] as $cont) {
            try {
                $oc = new OC;
                $oc->product_id = $cont["pro_id"] ? $cont["pro_id"] : null;
                $oc->item_id = $cont["item_id"] ? $cont["item_id"] : null;
                $oc->qty = $cont["itemQty"] ? trim($cont["itemQty"]) : null;
                //$oc->product_desc = $cont["custom_desc"] ? $cont["custom_desc"] : null;
                $oc->weight_per_unit = $cont["weight_piece"] ? trim($cont["weight_piece"]) : null;
                //$oc->weight_per_ctn = $cont["weight_per_ctn"] ? trim($cont["weight_per_ctn"]) : null;
                $oc->total_ctn = $cont["total_ctn"] ? trim($cont["total_ctn"]) : null;
                $oc->net_weight = $cont["net_weight"] ? (trim($cont["net_weight"])) : null;
                //$oc->cbm = $cont["cbm"] ? $cont["cbm"] : null;
                //$oc->total_cbm = $cont["total_cbm"] ? $cont["total_cbm"] : null;
                $oc->unit_price = $cont["itemUnitPrice"] ? trim($cont["itemUnitPrice"]) : null;
                $oc->amount = $cont["total"] ? trim($cont["total"]) : null;
                $oc->gross_weight = $cont["gross_weight"] ? trim($cont["gross_weight"]) : null;

                $oc->performa_id = $o->id;
                $oc->created_at = date('Y-m-d H:i:s');
                $oc->save();
            } catch (\Illuminate\Database\QueryException $ex) {
                $faultyData[] = ['code' => 102, 'message' => $ex];
            }
        }
        if (!sizeof($faultyData)) {
            DB::table('notifications_list')->insert(['code' => config('constants.options._ORDER_NOTIFICATION_CODE'), 'message' => 'has been added', 'performa_id' => $o->id, 'created_by' => Auth::user()->id]);
            return json_encode(['code' => 200]);
        } else {
            return json_encode(['code' => 103, 'message' => $faultyData]);
        }

    }

    public function approve_performa(Request $request){

        $invoiceLastId = \App\Orders::select('id')->orderBy('id', 'desc')->limit(1)->first();
        $invoiceLastId = $invoiceLastId ? $invoiceLastId->toArray() : 0;
        $invoiceLastId = $invoiceLastId ? $invoiceLastId['id']+1 : 1;
        $invoiceLastId = 'E-'.sprintf("%04s", $invoiceLastId);
        
        
        $performa = o::where('id',$request->performa_id)->first();
        $order = $performa->replicate();
        $order->current_status ='pending';
        $order->invoice_num =$invoiceLastId;
        $order->performa_id =$request->performa_id;
        $order->created_at = date('Y-m-d H:i:s');
        $order->created_by = Auth::user()->id;
        $order->setTable('orders');
        $order->save();

        //////
        $performa_c = oc::query()->where('performa_id','=', $request->performa_id)->get();

        foreach($performa_c as $i => $content)
        {
            $POProduct[$i] = new OrderContents();
            $POProduct[$i]->product_id = $content->product_id;
            $POProduct[$i]->item_id = $content->item_id;
            $POProduct[$i]->qty = $content->qty;
            $POProduct[$i]->weight_per_unit = $content->weight_per_unit;
            $POProduct[$i]->net_weight = $content->net_weight;
            $POProduct[$i]->gross_weight = $content->gross_weight;
            $POProduct[$i]->total_ctn = $content->total_ctn;
            $POProduct[$i]->unit_price = $content->unit_price;
            $POProduct[$i]->amount = $content->amount;
            $POProduct[$i]->order_id = $order->id;
            $POProduct[$i]->save();
        }

        o::where('id',$request->performa_id)->update(['current_status'=>'approved','invoice_num'=>$invoiceLastId]);

        return 'success';


    }

    public function dis_approve_performa(Request $request){


        o::where('id',$request->performa_id)->update(['current_status'=>'disapproved']);

        return 'success';


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

    public function getSaveProducts(Request $request){
        $id = $request->id;

        $ordersData = [];
        $orders = O::find($id);

        $ordersData["performa_id"] = $orders->id;
        $ordersData["customer_id"] = $orders->customer_id;
        $ordersData["issue_date"] = $orders->issue_date ? $orders->issue_date : date('Y-m-d', strtotime($orders->created_at));
        $ordersData["po_num"] = $orders->po_num;
        //$ordersData["invoice_num"] = $orders->invoice_num;
        $ordersData["total_amount"] = $orders->total_amount ?? 0;
        $ordersData["overall_amount"] = $orders->overall_amount ?? 0;
        $ordersData["status"] = $orders->current_status;
        $ordersData["totalGenset"] = $orders->totalGenset ?? 0;
        $ordersData["currency"] = $orders->currency;
        $ordersData["notes"] = $orders->notes;
        //$ordersData["additional_weight"] = $orders->additional_weight;
        //$ordersData["net_weight"] = $orders->net_weight;
        //$ordersData["actual_weight"] = $orders->actual_weight;
        $ordersData["order_discount"] = $orders->order_discount;
        //$ordersData["discount_value"] = $orders->discount_value;
        $ordersData['order_type'] = $orders->order_type;
        $ordersData['country_of_origin'] = $orders->country_of_origin;
        $ordersData['expected_delivery_date'] = $orders->expected_delivery_date;
        $ordersData['port_of_loading'] = $orders->port_of_loading;
        $ordersData['port_of_discharge'] = $orders->port_of_discharge;
        $ordersData['mode_of_shipment'] = $orders->mode_of_shipment;
        $ordersData['shipment_route'] = explode(",", $orders->shipment_route);
        $ordersData['shipment_company'] = $orders->shipment_company;
        $ordersData['quoted_freight_charges'] = $orders->quoted_freight_charges ?? 0;
        $ordersData['actual_freight_charges'] = $orders->actual_freight_charges ?? 0;
        $ordersData['insurance_charges'] = $orders->insurance_charges ?? 0;
        $ordersData['total_ctn'] = $orders->total_ctn;
        //$ordersData['payment_type'] = $orders->payment_type;
        $ordersData["terms"] = $orders->terms;

        $contents = OC::selectRaw('`id`, `item_id`, product_id, (SELECT name from product_related_items where id = performa_contents.`item_id`) as item_name, `qty`, `product_desc`, `weight_per_unit`, `unit_price`, `amount`, `performa_id`,`net_weight`,`total_ctn`,`gross_weight`,`performa_id`, `created_at`, `updated_at`, `updated_by`, (SELECT unit_name from item_units where id = (SELECT unit_id from product_related_items where id = performa_contents.item_id)) as unit_name, (SELECT variant_name from item_variants where id = (SELECT variant_id from product_related_items where id = performa_contents.item_id)) as variant_name, (SELECT unit_quantity from product_related_items where id = performa_contents.item_id) as unit_quantity, (SELECT unit_variant_quantity from product_related_items where id = performa_contents.item_id) as unit_variant_quantity')->where('performa_id', $orders->id)->get();
        $contents = $contents ? $contents->toArray() : [];
        return ['products' => $ordersData, 'proItems' => $contents];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ordersData = [];
        $orders = O::find($id);

        $ordersData["performa_id"] = $orders->id;
        $ordersData["customer_id"] = $orders->customer_id;
        $ordersData["issue_date"] = $orders->issue_date ? $orders->issue_date : date('Y-m-d', strtotime($orders->created_at));
        $ordersData["po_num"] = $orders->po_num;
        //$ordersData["invoice_num"] = $orders->invoice_num;
        $ordersData["total_amount"] = $orders->total_amount;
        $ordersData["overall_amount"] = $orders->overall_amount;
        $ordersData["status"] = $orders->current_status;
        $ordersData["totalGenset"] = $orders->totalGenset;
        $ordersData["currency"] = $orders->currency;
        $ordersData["notes"] = $orders->notes;
        //$ordersData["additional_weight"] = $orders->additional_weight;
        //$ordersData["net_weight"] = $orders->net_weight;
        //$ordersData["actual_weight"] = $orders->actual_weight;
        $ordersData["order_discount"] = $orders->order_discount;
		//$ordersData["discount_value"] = $orders->discount_value;
        $ordersData['order_type'] = $orders->order_type;
        $ordersData['country_of_origin'] = $orders->country_of_origin;
        $ordersData['expected_delivery_date'] = $orders->expected_delivery_date;
        $ordersData['port_of_loading'] = $orders->port_of_loading;
        $ordersData['port_of_discharge'] = $orders->port_of_discharge;
        $ordersData['mode_of_shipment'] = $orders->mode_of_shipment;
        $ordersData['shipment_route'] = explode(",", $orders->shipment_route);
        $ordersData['shipment_company'] = $orders->shipment_company;
        $ordersData['quoted_freight_charges'] = $orders->quoted_freight_charges;
        $ordersData['actual_freight_charges'] = $orders->actual_freight_charges;
        $ordersData['insurance_charges'] = $orders->insurance_charges;
        $ordersData['total_ctn'] = $orders->total_ctn;
        //$ordersData['payment_type'] = $orders->payment_type;
        $ordersData["terms"] = $orders->terms;

        $contents = OC::selectRaw('`id`, `item_id`, product_id, (SELECT name from product_related_items where id = performa_contents.`item_id`) as item_name, `qty`, `product_desc`, `weight_per_unit`, `unit_price`, `amount`, `performa_id`,`net_weight`,`total_ctn`,`gross_weight`,`performa_id`, `created_at`, `updated_at`, `updated_by`, (SELECT unit_name from item_units where id = (SELECT unit_id from product_related_items where id = performa_contents.item_id)) as unit_name, (SELECT variant_name from item_variants where id = (SELECT variant_id from product_related_items where id = performa_contents.item_id)) as variant_name, (SELECT unit_quantity from product_related_items where id = performa_contents.item_id) as unit_quantity, (SELECT unit_variant_quantity from product_related_items where id = performa_contents.item_id) as unit_variant_quantity')->where('performa_id', $orders->id)->get();
         $contents = $contents ? $contents->toArray() : [];
        //return $contents;
        return view('performas.edit', ['customers' => Cust::selectRaw('id, company_name')->get(), 'types' => DB::table('customer_types')->get(), 'units' => DB::table('item_units')->get(), 'variants' => DB::table('item_variants')->get(), 'orderInfo' => $ordersData, 'ports' => Ports::all(), 'shipping_companies' => \App\ShippingCompany::all(), 'doc_type' => DB::table('document_types')->get(), 'products' => BP::where('brand_id', '>', '0')->get(), 'services' => DB::table('main_services')->get(), 'acquisition' => DB::table('acquisition_source')->get(),'contents' => $contents ]);
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

        $data = ["order_info" => json_decode($request->performa, true)];

        $o = O::find($id);
        try {

            $o->customer_id = ($data["order_info"]["customer_id"] ? $data["order_info"]["customer_id"] : null);
            $o->employee_id = Auth::user()->id;
            $o->issue_date = ($data["order_info"]["issue_date"] ? $data["order_info"]["issue_date"] : null);
            $o->po_num = ($data["order_info"]["po_number"] ? $data["order_info"]["po_number"] : null);
            $o->total_amount = $data["order_info"]["totalAmount"]; /// without discount
            $o->overall_amount = $data["order_info"]["completePrice"]; /// with all charges and discount
            $o->total_ctn = $data["order_info"]["total_ctn"]; /// complete total item ctn
            $o->currency = str_replace(".", "", $data["order_info"]["currency"]);
            $o->currency_symbol = $data["order_info"]["currency_symbol"];
            $o->notes = $data["order_info"]["notes"];
            $o->terms = $data["order_info"]["terms"];
            //$o->net_weight = ($data["order_info"]["net_weight"] ? $data["order_info"]["net_weight"] : null);
            //$o->actual_weight = ($data["order_info"]["actual_net_weight"] ? $data["order_info"]["actual_net_weight"] : null);
            //$o->additional_weight = ($data["order_info"]["additional_weight_ctn"] ? $data["order_info"]["additional_weight_ctn"] : null);
            $o->order_type = ($data['order_info']['order_type'] ? $data['order_info']['order_type'] : null);
            $o->country_of_origin = $data['order_info']['country_of_origin'];
            $o->expected_delivery_date = ($data['order_info']['expected_delivery_date'] ? $data['order_info']['expected_delivery_date'] : null);
            $o->port_of_loading = ($data['order_info']['port_of_loading'] ? $data['order_info']['port_of_loading'] : null);
            $o->port_of_discharge = ($data['order_info']['port_of_discharge'] ? $data['order_info']['port_of_discharge'] : null);
            $o->mode_of_shipment = $data['order_info']['mode_of_shipment'];
            $o->shipment_route = implode(",", $data['order_info']['shipment_route']);
            $o->shipment_company = ($data['order_info']['shipment_company'] ? $data['order_info']['shipment_company'] : null);
            $o->actual_freight_charges = ($data['order_info']['totalFreight'] ? $data['order_info']['totalFreight'] : null);
            $o->totalGenset = ($data['order_info']['totalGenset'] ? $data['order_info']['totalGenset'] : null);
            //$o->quoted_freight_charges = ($data['order_info']['quoted_freight_charges'] ? $data['order_info']['quoted_freight_charges'] : null);
            $o->insurance_charges = ($data['order_info']['totalInsurance'] ? $data['order_info']['totalInsurance'] : null);
            $o->current_status = 'draft';
            $o->order_discount = $data["order_info"]['discount'];
            //$o->discount_value = ($data["order_info"]['order_discount'] ? (($data["order_info"]['order_discount'] / 100) * array_sum(array_column($data["contents"], "total_amount"))): 0);
            $o->created_at = date('Y-m-d H:i:s');
            //$o->advance = $data['order_info']['advance'] ? $data['order_info']['advance'] : 0;
            //$o->payment_type = $data['order_info']['payment_type'];

            $status = $o->save();
        } catch (\Illuminate\Database\QueryException $ex) {
            return json_encode(['code' => 101, 'message' => $ex]);
        }
        if (!$status) {
            return json_encode(['code' => 100, 'message' => $status]);
        }

        OC::where('performa_id', $id)->delete();

        foreach ($data['order_info']['content'] as $cont) {
            try {
                $oc = new OC;
                $oc->product_id = $cont["pro_id"] ? $cont["pro_id"] : null;
                $oc->item_id = $cont["item_id"] ? $cont["item_id"] : null;
                $oc->qty = $cont["itemQty"] ? trim($cont["itemQty"]) : null;
                //$oc->product_desc = $cont["custom_desc"] ? $cont["custom_desc"] : null;
                $oc->weight_per_unit = $cont["weight_piece"] ? trim($cont["weight_piece"]) : null;
                //$oc->weight_per_ctn = $cont["weight_per_ctn"] ? trim($cont["weight_per_ctn"]) : null;
                $oc->total_ctn = $cont["total_ctn"] ? trim($cont["total_ctn"]) : null;
                $oc->net_weight = $cont["net_weight"] ? (trim($cont["net_weight"])) : null;
                //$oc->cbm = $cont["cbm"] ? $cont["cbm"] : null;
                //$oc->total_cbm = $cont["total_cbm"] ? $cont["total_cbm"] : null;
                $oc->unit_price = $cont["itemUnitPrice"] ? trim($cont["itemUnitPrice"]) : null;
                $oc->amount = $cont["total"] ? trim($cont["total"]) : null;
                $oc->gross_weight = $cont["gross_weight"] ? trim($cont["gross_weight"]) : null;

                $oc->performa_id = $o->id;
                $oc->created_at = date('Y-m-d H:i:s');
                $oc->save();
            } catch (\Illuminate\Database\QueryException $ex) {
                $faultyData[] = ['code' => 102, 'message' => $ex];
            }
        }

        $faultyData = [];

        if (!sizeof($faultyData)) {
            DB::table('notifications_list')->insert(['code' => config('constants.options._ORDER_NOTIFICATION_CODE'), 'message' => 'has been updated', 'performa_id' => $o->id, 'created_by' => Auth::user()->id]);
            return json_encode(['code' => 200]);
        } else {
            return json_encode(['code' => 103, 'message' => $faultyData]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $o = O::find($id);
        $o->delete();
        OC::where('order_id', $id)->delete();
        P::where('order_id', $id)->delete();
        echo json_encode("success");
    }

    public function performa_pdf($id,$logo){

        set_time_limit(100);
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 180);

        $performa_data = O::with('customer')->where('id',$id)->first();
        $customer_data = json_decode($performa_data->customer->address);
        if($customer_data){
            $customer_data = $customer_data[0];
        }   
        if(!$performa_data->customer->address){
            $customer_data = null;
        }
        $port_loading = $performa_data->port_of_loading;
        $port_discharge = $performa_data->port_of_discharge;

        $port_load_name = Ports::where('id',$port_loading)->pluck('port_name')->first();
        $port_discharge_name = Ports::where('id',$port_discharge)->pluck('port_name')->first();



        $performa_content = DB::select("SELECT
                            *,
                            performa_contents.*,
                            brand_related_products.`name` as product_name,
                            brand_related_products.`sku` as product_sku,
                            product_related_items.*,
                            product_brands.brand_name
                        FROM
                            performa_contents
                            INNER JOIN
                            brand_related_products
                            ON
                                performa_contents.product_id = brand_related_products.id
                            INNER JOIN
                            product_related_items
                            ON
                                performa_contents.item_id = product_related_items.id
                            INNER JOIN
                            item_units
                            ON
                                product_related_items.unit_id = item_units.id
                                INNER JOIN
                            item_variants
                            ON
                                product_related_items.variant_id = item_variants.id
                            INNER JOIN
                            product_brands
                            ON
                                brand_related_products.brand_id = product_brands.id
                        WHERE
                            performa_contents.performa_id = $id");
            $total_carotns = 0;
            foreach($performa_content as $p_content){
                $total_carotns += $p_content->qty;
            }
          $html = view('pdf/performa_pdf',compact('performa_data','port_load_name','port_discharge_name','performa_content','logo','customer_data','total_carotns'));



        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set(array('isHtml5ParserEnabled' => true,'isRemoteEnabled' => true));
        $dompdf->setOptions($options);

        $dompdf->loadHTML($html);
        $dompdf->render();
        $pdf = $dompdf->output();
        $invnoabc = 'Performa_'.$performa_data->id.'.pdf';
        //return $dompdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView($html)->stream();
        return $dompdf->stream($invnoabc);

    }



    public function viewPerforma($performaId)
    {
        $orders = O::selectRaw('id, po_num, total_amount, issue_date, invoice_num, currency, notes, terms, (SELECT company_name from customers where id = orders.customer_id) as company, IFNULL((SELECT CONCAT(first_name, " ", IFNULL(last_name, "")) from customers where id = orders.customer_id), "NA") as poc, (SELECT country from customers where id = orders.customer_id) as country, IFNULL((SELECT city from customers where id = orders.customer_id), "NA") as city')->where('id', $performaId)->first();
        $contents = OC::selectRaw('qty, product_desc, weight_per_unit, weight_per_ctn, cbm, total_cbm, unit_price, amount, (SELECT name from product_related_items where id = order_contents.item_id) as product, (SELECT description from product_related_items where id = order_contents.item_id) as product_description')->where('order_id', $performaId)->get();
        echo json_encode(['basic_info' => $orders, 'contents' => $contents]);
    }

    public function performaEmail($performaId){
        $customer = Cust::where('id', O::find($performaId)->customer_id)->first();
        $url = '/invoice-pdf/?performa='.$performaId;
        $final_url = URL::to('/').$url;
        $file_name = "performa-".rand().'-'.time().".pdf";
        file_put_contents($file_name, fopen($final_url, 'r'));
        if($customer->email){
            $message = "Dear ".($customer->first_name." ".($customer->last_name ? $customer->last_name : "")).",<p>Your order invoice has been generated. Please find the attachment.</p>";
            Mail::to($customer->email)->send(new OrderInvoice(["message" => $message, "subject" => "Invoice: Generated by ".Auth::user()->name, "attachment" => URL::to('/').'/'.$file_name]));
        }
        $path = public_path()."/". $file_name;
        if(file_exists($path)) {
            unlink($path);
        }
    }

    public function ListPerformas(){
        return view('performas.list', ['data' => DB::table('performa')->selectRaw('id, total_cost, payment_received, (SELECT company_name from supplier where id = performa.supplier_assigned) as supplier, (SELECT company_name from customers where id = performa.customer_id) as customer, issue_date, po_num, current_status, total_amount')->get() ]);
    }

    public function assignSupplier($supplierId, $orderId){
        $order = O::find($orderId);
        $order->supplier_assigned = $supplierId;
        $status = $order->save();
        if($status){
            echo json_encode("success");
        }else{
            echo json_encode("failed");
        }
    }

    public function pending_orders(){
        return view('orders-management.seperate_orders_list');
    }

    public function completed_orders(){
        return view('orders-management.seperate_orders_list');
    }

    public function processed_orders(){
        return view('orders-management.seperate_orders_list');
    }

    public function GetOrdersListing($status){
        echo json_encode(DB::table('orders as o')->selectRaw('id, (Select company_name from customers where id = o.customer_id) as customer_name, Date(issue_date) as issue_date, total_amount, discount_value, po_num, payment_received')->where('current_status', $status)->get());
    }

    public function supplier_follow_up($id){
        $today = date('Y-m-d');
        $supplier_data = DB::table('supplier')->where('id', $id)->first();
        $supplier_assignments = DB::select("SELECT id, supplier_id, item_quantity, follow_up_date, expected_delivery_date, production_quantity, assigned_employees, order_id, batch, production_completed, (Select company_name from supplier where id = sp.supplier_id) as supplier_name, (Select name from product_related_items where id = sp.item_id) as item_name, (Select name from brand_related_products where sku = (Select product_sku from product_related_items where id = sp.item_id)) as product_name, (Select Date(created_at) from orders where id = sp.order_id) as order_date, (Select company_name from customers where id = (Select customer_id from orders where id = sp.order_id)) as customer_name from `supplier_product_assignment` as `sp` where Date(follow_up_date) = '$today' AND production_completed = 0 AND supplier_id = $id group by `batch`");

        return view('orders-management.supplier_follow_up', ['supplier_data' => $supplier_data, 'assignments' => $supplier_assignments, 'employees' => DB::table('users')->get()]);
    }


    public function orders_bulk_upload(){
        return view('orders-management.bulk_orders');
    }

    //Download Order Sample
    public function download_sample_order(){
        return redirect('/sample_order.xlsx?v=2.0');
    }

    public function download_sample_order_items(){
        return redirect('/sample_order_items.xlsx?v=2.0');
    }

    public function upload_orders_bulk(Request $request){
        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                $path = $request->file->getRealPath();
                $data = Excel::load($path, function($reader) {
                })->get();

                if(!empty($data) && $data->count()){
                    $counter = 0;
                    $not_upload_able = [];
                    $data_uploaded = [];
                    $allOrders = array_column(O::all()->toArray(), 'order_custom_id');
                    $allCusts = Cust::all()->toArray();

                    foreach ($data as $key => $value) {

                        if(!$value['order_id'])
                            break;

                        $indFnd = array_search($value['customer_id'], array_column($allCusts, 'company_id'));
                        if($indFnd === false){
                            $not_upload_able[] = ['order_id' => $value['order_id'], 'customer_id' => $value['customer_id'], 'reason' => "Customer Id does not exist"];
                            $data_uploaded[] = false;
                            continue;
                        }

                        if(in_array($value['order_id'], $allOrders)){
                            $not_upload_able[] = ['order_id' => $value['order_id'], 'customer_id' => $value['customer_id'], 'reason' => "Duplicate"];
                            $data_uploaded[] = false;
                        }else{
                            $o = new O;
                            $o->customer_id = $allCusts[$indFnd]['id'];
                            $o->customer_custom_id = $value['customer_id'];
                            $o->order_custom_id = $value['order_id'];
                            $o->employee_id = Auth::user()->id;
                            $o->expected_delivery_date = $value['required_date'];
                            $o->ship_date = $value['ship_date'];
                            $o->ship_city = $value['ship_city'];
                            $o->ship_country = $value['ship_country'];
                            $o->ship_address = $value['ship_address'];

                            // $o->port_of_discharge = DB::table('delivery_ports')->select('id')->where('port_code', $value['ship_port'])->first()->id;

                            $o->port_of_discharge = $value['ship_port'];
                            $o->bulk_upload_date = date('Y-m-d H:i:s');
                            $o->current_status = '`Completed`';
                            $o->completed_at = date('Y-m-d H:i:s');
                            $o->completed_by = Auth::user()->id;

                            $o->currency = $request->currency;
                            $o->currency_symbol = $request->currency_symbol;

                            $o->quoted_freight_charges = $value['freight_paid'];
                            $o->order_type = $value['order_type'];
                            $o->total_amount = $value['total_value'];
                            $o->issue_date = $value['order_date'];
                            $o->created_at = date('Y-m-d H:i:s');
                            $o->invoice_num = $value['e_invoice'];
                            $o->order_type = $value['order_type'];
                            $o->bulk_upload = 1;

                            if($o->save()){
                                $allOrders[] = $value['order_id'];
                                $data_uploaded[] = true;
                            }else{
                                $data_uploaded[] = false;
                            }
                        }

                    }
                    if(in_array(true, $data_uploaded)){
                        echo json_encode(array('status' => 'success', 'not_upload_able' => $not_upload_able));
                    }else{
                        echo json_encode(array('status' => 'failed', 'not_upload_able' => $not_upload_able));
                    }
                }
            }else {
                echo json_encode(array('status' => 'failed', 'not_upload_able' => ''));
            }
        }
    }

    public function upload_ordersItems_bulk(Request $request){
        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                $path = $request->file->getRealPath();
                $data = Excel::load($path, function($reader) {
                })->get();

                if(!empty($data) && $data->count()){
                    $counter = 0;
                    $not_upload_able = [];
                    $data_uploaded = [];

                    foreach ($data as $key => $value) {

                        if(!$value['order_custom_id'])
                            break;

                        $oc = new OC;
                        $ids = DB::table('product_related_items')->selectRaw('id, product_id, standrad_unit_price, COALESCE(actual_cbm, cbm_value) as cbm, unit_weight, unit_quantity, unit_variant_quantity')->where('custom_id', $value['item_custom_id'])->first();
                        $order_data = DB::table('orders')->where('order_custom_id', $value['order_custom_id'])->first();

                        $cbm = $value["cbm"] ? $value["cbm"] : ($ids ? $ids->cbm : null);

                        $oc->product_id = $ids ? $ids->product_id : null;
                        $oc->item_id = $ids ? $ids->id : null;
                        $oc->qty = $value['qty'];
                        $oc->item_custom_id = $value['item_custom_id'];
                        $oc->product_desc = $value['product_desc'];
                        $oc->net_weight = (($ids->unit_weight * $ids->unit_quantity * $ids->unit_variant_quantity) / 1000) * $value['qty'];
                        $oc->gross_weight = $value['gross_weight'];
                        $oc->weight_per_unit = $ids->unit_weight;
                        $oc->weight_per_ctn = (($ids->unit_weight * $ids->unit_quantity * $ids->unit_variant_quantity) / 1000);
                        $oc->cbm = $cbm;
                        $oc->total_cbm = $cbm * $value['qty'];

                        $oc->unit_price = $value['unit_price'];
                        $oc->amount = $value['unit_price'] * $value['qty'];

                        $oc->order_id = $order_data->id;
                        $oc->created_at = date('Y-m-d H:i:s');

                        DB::table('orders')->where('id', $order_data->id)->update(['net_weight' => ($order_data ? $order_data->net_weight + (($ids->unit_weight * $ids->unit_quantity * $ids->unit_variant_quantity) / 1000) * $value['qty'] : (($ids->unit_weight * $ids->unit_quantity * $ids->unit_variant_quantity) / 1000) * $value['qty'])]);

                        if($oc->save()){
                            $data_uploaded[] = true;
                        }else{
                            $data_uploaded[] = false;
                        }

                    }
                    if(in_array(true, $data_uploaded)){
                        echo json_encode(array('status' => 'success', 'not_upload_able' => ''));
                    }else{
                        echo json_encode(array('status' => 'failed', 'not_upload_able' => ''));
                    }
                }
            }else {
                echo json_encode(array('status' => 'failed', 'not_upload_able' => ''));
            }
        }
    }

    function GetAssignmentsAgainstBatch(Request $request){
        echo json_encode(DB::table('supplier_product_assignment as sp')->selectRaw('id, item_id, item_quantity, batch, follow_up_date, expected_delivery_date, assigned_employees, production_quantity, (Select name from product_related_items where id = sp.item_id) as item_name, (Select name from brand_related_products where sku = (Select product_sku from product_related_items where id = sp.item_id)) as product_name')->where('batch', $request->batch)->get());
    }
    function getCbm($performa_id){
        $performa = Performa::select('invoice_num','customer_id','po_num')->where('id',$performa_id)->first();
        $performaItems = PerformaContents::select('id',
        'product_id',
        'item_id',
        'qty',
        'weight_per_unit',
        'weight_per_ctn',
        'net_weight',
        'gross_weight',
        'total_ctn',
        'net_weight')->where('performa_id',$performa_id)->get();
        $total_ctns = 0;
        $total_pkts = 0;
        $total_net_weight = 0;
        $total_gross_weight = 0;
        foreach($performaItems as $performaItem){
            $performaItem->product_name = $performaItem->product->name;
            $performaItem->packaging = "";
            $performaItem->lenght = $performaItem->item->lenght;
            $performaItem->width = $performaItem->item->width;
            $performaItem->height = $performaItem->item->height;
            $performaItem->pkts = 0;
            $cu_mt = '';
            //for cu_mt 
            $denominator  = 60998.4;
            $numirator = ($performaItem->lenght ? $performaItem->lenght : 1) * ($performaItem->width ? $performaItem->width : 1) *($performaItem->height ? $performaItem->height : 1);
            //in case if somehow all the values are zero(by chance)
            if($performaItem->lenght == 0 && $performaItem->width == 0 && $performaItem->height == 0  ){
                dd("indide if");
                $numirator = 0;
            }
           
            //for cu_mt 
            $performaItem->cu_mt =  $numirator  / $denominator;
            $performaItem->t_cu =  $performaItem->cu_mt* 12;
            $performaItem->pkt_wt =  $performaItem->gross_weight -  $performaItem->net_weight;
            // for packaging
            $item = $performaItem->item ? $performaItem->item:"";
            $getUnitName = ItemUnits::find($item->unit_id);
            $getUnitName2 = ItemUnits::find($item->variant_id_2);
            $getUnitName3 = ItemUnits::find($item->variant_id_3);
            if($item){
                $performaItem->pkts =  $item->unit_variant_quantity; 
                $finalVariant = '';
                if($item->variant_id){
                    $finalVariant = $item->packingVariant->unit_name;
                }
                if($item->variant_id_2){
                    $finalVariant = $item->packingVariant2->unit_name;
                }
                if($item->variant_id_3){
                    $finalVariant = $item->packingVariant3->unit_name;
                }
                $performaItem->packaging = $item->unit_weight .'Gm/'. $getUnitName->unit_name.','
                .($item->unit_quantity ? ($item->unit_quantity. $getUnitName->unit_name . 's/' . $item->packingVariant->unit_name. ',') : '')
                .($item->variant_quantity_2 ? ($item->variant_quantity_2 . ' ' . $getUnitName2->unit_name . 's/' . $item->packingVariant2->unit_name. ',') : '')
                .($item->variant_quantity_3 ? ($item->variant_quantity_3 . ' ' . $getUnitName3->unit_name . 's/' . $item->packingVariant3->unit_name. ',') : '')
                .($item->unit_variant_quantity ? $item->unit_variant_quantity:"").$finalVariant.'s/Carton';
            }
           $total_ctns +=  $performaItem->total_ctn;
           $total_pkts +=  $performaItem->pkts;
           $total_net_weight +=  $performaItem->net_weight;
           $total_gross_weight +=  $performaItem->gross_weight;

        }
        // return view('performas.cbm_calculation',compact('performaItems','total_ctns','total_gross_weight','total_pkts','total_net_weight','performa'));
        $html = view('performas.cbm_calculation',compact('performaItems','total_ctns','total_gross_weight','total_pkts','total_net_weight','performa'));
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set(array('isHtml5ParserEnabled' => true,'isRemoteEnabled' => true));
        $dompdf->setOptions($options);
        $dompdf->set_paper('a4', 'landscape');
        $dompdf->loadHTML($html);
        $dompdf->render();
        $pdf = $dompdf->output();
        $invnoabc = 'CBM'.$performa->id.'.pdf';
        return $dompdf->stream($invnoabc);
    }
    
}
