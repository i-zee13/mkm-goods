<?php

namespace App\Http\Controllers;

use App\PurchasedItemsUtilizationDetail;
use App\PurchasedItemsUtilizationSummary;
use App\PurchaseOrder;
use App\PurchaseOrderContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    
    public function index()
    {
        $purhased_orders = PurchaseOrder::all();
        return view('purchase_order.index', compact('purhased_orders'));
    }
    public function add_purchase_order()
    {
        $ingredients = DB::select("SELECT * FROM item_ingredients");
        return view('purchase_order.new_purchase_order', compact('ingredients'));
    }
    public function view_purchased_order($id)
    {
        $purchase_order             =   PurchaseOrder::find($id);
        $purchase_order_content     =   PurchaseOrderContent::where('purchase_order_id', $id)->get();

        if (collect($purchase_order_content)->count() > 0) {
            foreach ($purchase_order_content as $content) {
                $content->item_name = "";
                $item_name = DB::select("SELECT ingredients_name FROM item_ingredients WHERE id='$content->item_id'");
                $first      = collect($item_name)->first();
                $content->item_name =  $first->ingredients_name;
            }
        }

        return view('purchase_order.purchase_order', compact('purchase_order', 'purchase_order_content'));
    }
    public function  store_purchase_order(Request $request)
    {
        $purchase_order                     =       new PurchaseOrder();
        $purchase_order->purchase_date      =       date("Y-m-d", strtotime($request->date));
        $purchase_order->order_type         =       $request->order_type;
        $purchase_order->gd_challan_number  =       $request->gd_challan;
        $purchase_order->ttl_value          =       0;
        if (collect($request->inputs)->count() > 0) {
            foreach ($request->inputs as $input) {
                $purchase_order->ttl_value  +=  $input;
            }
        }
        $purchase_order->ttl_items = 0;
        if (collect($request->inputs)->count() > 0) {
            foreach ($request->items as $input) {
                $purchase_order->ttl_items  +=  1;
            }
        }
        $purchase_order->created_at         =   Carbon::now();
        $purchase_order->created_by         =   Auth::user()->id;
        $purchase_order->updated_at         =   Carbon::now();
        $purchase_order->updated_by         =   Auth::user()->id;
        // $purchase_order_content = new PurchaseOrderContent();
        $purchase_order->save();
        $purchase_order_id = $purchase_order->id;
        foreach ($request->items as $key => $value) {
            if ($value != 0) {
                $purchase_order_content                         =   new PurchaseOrderContent();
                $purchase_order_content->purchase_order_id      =   $purchase_order_id;
                $purchase_order_content->purchase_order_type    =   $request->order_type;
                $purchase_order_content->gd_challan_number      =   $request->gd_challan_number;
                $purchase_order_content->item_id                =   $value;
                $purchase_order_content->item_value             =   $request->inputs[$key];
                $purchase_order_content->created_at             =   Carbon::now();
                $purchase_order_content->created_by             =   Auth::user()->id;
                $purchase_order_content->updated_at             =   Carbon::now();
                $purchase_order_content->updated_by             =   Auth::user()->id;
                $purchase_order_content->save();
                // to maintain the stock of the item of purchase order item 
                $item_utlization_detail                         =   new PurchasedItemsUtilizationDetail();
                $item_utlization_detail->purchase_order_id      =   $purchase_order_id;
                $item_utlization_detail->purchase_order_type    =   $request->order_type;
                $item_utlization_detail->gd_challan_number      =   $request->gd_challan_number;
                $item_utlization_detail->item_id                =   $value;
                $item_utlization_detail->Item_value             =   $request->inputs[$key];
                $item_utlization_detail->transaction_type       =   1;
                $item_utlization_detail->status                 =   1;
                $item_utlization_detail->value                  =   $request->inputs[$key];
                $item_utlization_detail->balance                =   $request->inputs[$key];
                $to_check_previous_balance                      =   PurchasedItemsUtilizationDetail::where('item_id', $value)->where('gd_challan_number',$request->gd_challan_number)->where('transaction_type', 1)->where('purchase_order_type', $request->order_type)->latest()->first();
                if ($to_check_previous_balance) {
                    $item_utlization_detail->balance            =       $request->inputs[$key] + $to_check_previous_balance->balance;
                }
                $balance_for_summry                             =    $item_utlization_detail->balance;
                $item_utlization_detail->created_at             =    Carbon::now();
                $item_utlization_detail->updated_at             =    Carbon::now();
                $item_utlization_detail->save();
                // to maintain the summary of the utilization of the item
                $item_utilization_summary                       =   PurchasedItemsUtilizationSummary::where('item_id', $value)->where('purchase_order_type', $request->order_type)->first();
                if (!$item_utilization_summary) {
                    $item_utilization_summary_new                           =           new PurchasedItemsUtilizationSummary();
                    $item_utilization_summary_new->item_id                  =           $value;
                    $item_utilization_summary_new->last_transcation_date    =           Carbon::now();
                    $item_utilization_summary_new->purchase_order_type      =           $request->order_type;
                    $item_utilization_summary_new->balance                  =           $balance_for_summry;
                    $item_utilization_summary_new->created_at               =           Carbon::now();
                    $item_utilization_summary_new->updated_at               =           Carbon::now();
                    $item_utilization_summary_new->save();
                }
                if ($item_utilization_summary) {
                    $item_utilization_summary->balance                      =    $balance_for_summry;
                    $item_utilization_summary->last_transcation_date        =    $item_utilization_summary->updated_at;
                    $item_utilization_summary->save();
                }
            }
        }
        return redirect('/purchase-order');
    }
    
}
