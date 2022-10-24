<?php

namespace App\Http\Controllers;

use App\CompanyCurrentStock;
use App\CustomerStock;
use App\Orders;
use App\Http\Controllers\API\Order;
use App\OrderContents;
use App\OrderSheet;
use App\OrderSheetContent;
use App\StockMangment;
use App\Supplier;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class OrderSheetController extends Controller


{
    public function index($order_id, $customer_id)
    {
        $order_content = OrderContents::where('order_id', $order_id)->get();
        foreach($order_content as $content){
                $content->product_name = $content->item->name;
                $content->description = $content->item->description;
        }
        $customer_stock = [];
        $company_stock = [];
        foreach ($order_content as $item) {
            $stock = CustomerStock::where('item_id', $item->item_id)->where('balance', '>', 0)->where('product_id', $item->product_id)->where('customer_id', $customer_id)->latest()->first();
            if ($stock) {
                $stock->ordered_qty = $item->qty;
                $stock->product_name = $stock->item->description;
                $stock->description = $stock->item->name;
                $customer_stock[] = $stock;
            }
            $company_stock_item = CompanyCurrentStock::where('item_id', $item->item_id)->where('balance', '>', 0)->where('product_id', $item->product_id)->latest()->first();
            if ($company_stock_item) {
                $company_stock_item->ordered_qty = $item->qty;
                $company_stock[] = $company_stock_item;
                $company_stock_item->product_name = $stock->item->description;
                $company_stock_item->description = $stock->item->name;
            }
        }
        $suppliers = Supplier::all();
        return view('order_sheet_views.index', compact('customer_stock', 'company_stock', 'order_content', 'suppliers', 'order_id', 'customer_id'));
    }
    public function saveOrderSheet(Request $req)
    {
        // update company stock
        // move stock from company to customer stock
        // update company current stock
        // update customer stock 
        // dd($req->company_stock);
     
        if (collect($req->company_stock)->count() > 0) {
          
            $company_stock = $req->company_stock;
            foreach ($company_stock as $key => $stock) {
                // move stock from company to customer stock
                $company_stock = new StockMangment($stock);
                $company_stock->created_at = Carbon::now();
                $company_stock->updated_at = Carbon::now();
                $company_stock->created_by = Auth::user()->id;
                $company_stock->transaction_type = "customer_stock_transfer";
                $company_stock->state = "out";
                $company_stock->customer_id = $req->customer_id;
                $company_stock->quantity = $stock["quantity"];
                // to update company current stock
                $current_stock_qty = $stock["quantity"];
                // to update company current stock
                unset($company_stock->id);
                unset($company_stock->stock_type);
                unset($company_stock->supplier_id);
                unset($company_stock->updated_by);
                unset($company_stock->ordered_qty);
                unset($company_stock->assigned_qty);
                unset($company_stock->description);
                unset($company_stock->item);
                $company_stock->save();
                $stock_managment_id = $company_stock->id;
                // update company current stock
                $item_current_stock = CompanyCurrentStock::where('item_id', $stock["item_id"])->where('product_id', $stock["product_id"])->where('batch_id', $stock["batch_id"])->latest()->first();
                if ($item_current_stock) {
                    $item_current_stock->balance =   $item_current_stock->balance - $current_stock_qty;
                    $item_current_stock->save();
                }
                // update customer stock
                $customer_previous_stock =  CustomerStock::where('item_id', $stock["item_id"])->where('product_id', $stock["product_id"])->where('batch_id', $stock["batch_id"])->where('customer_id', $req->customer_id)->latest()->first();
                if ($customer_previous_stock) {
                    $customer_previous_stock->refrence_id = $req->order_id;
                    $customer_previous_stock->state = "in";
                    $customer_previous_stock->transaction_type = "assigned_to_order_sheet";
                    $customer_previous_stock->balance  =   $customer_previous_stock->balance  +   $current_stock_qty;
                    unset($customer_previous_stock->id);
                    $update_customer_stock = new CustomerStock($customer_previous_stock->toArray());
                    $update_customer_stock->save();
                }
            }
         
        }
        // // update customer stock
        if (collect($req->customer_stock)->count() > 0) {
            $customer_stock = $req->customer_stock;
            foreach ($customer_stock as $key => $stock) {
                $customer_stock = new CustomerStock($stock);
                $customer_stock->transaction_type = "order_sheet_assignment";
                $customer_stock->state = "in";
                $customer_stock->quantity = $customer_stock->assigned_qty;
                $customer_stock->balance = $customer_stock->balance;
                $customer_stock->refrence_id = $req->order_id;
                $customer_stock->created_at = Carbon::now();
                $customer_stock->updated_at = Carbon::now();
                $customer_stock->created_by = Auth::user()->id;
                $customer_stock->updated_by = Auth::user()->id;
                unset($customer_stock->id);
                unset($customer_stock->ordered_qty);
                unset($customer_stock->assigned_qty);
                unset($customer_stock->required);
                unset($customer_stock->description);
                unset($customer_stock->item);
                $customer_stock->save();
            }
        }
        // create order sheet 
        if (collect($req->order_sheet)->count() > 0) {
            $total_qty_of_order = OrderContents::where('order_id', $req->order_id)->sum('qty');
            $total_qty_of_order_ctn = OrderContents::where('order_id', $req->order_id)->sum('total_ctn');
            $order = Orders::find($req->order_id);
            $order_sheet = new OrderSheet();
            $order_sheet->order_id = $req->order_id;
            $order_sheet->customer_id = $req->customer_id;
            $order_sheet->total_order_qty_boxes = $total_qty_of_order;
            $order_sheet->total_order_qty_ctn = $total_qty_of_order;
            $order_sheet->total_order_qty_ctn = $total_qty_of_order_ctn;
            $order_sheet->p_invoice_no = $order->invoice_num;
            $order_sheet->finish_goods_stock_boxes = $req->total_of_order_sheet["total_finish_goods_stock_box"];
            $order_sheet->finish_goods_stock_ctn = 0;
            $order_sheet->created_at = Carbon::now();
            $order_sheet->updated_at = Carbon::now();
            $order_sheet->created_by = Auth::user()->id;
            $order_sheet->updated_by = Auth::user()->id;
            $order_sheet->save();
            $order_sheet_id = $order_sheet->id;
            $status = "faild";
            // create order sheet content
            foreach ($req->order_sheet as $key => $orders_sheet_item) {
                $order_sheet_content = new OrderSheetContent();
                $order_sheet_content->order_sheet_id =   $order_sheet_id;
                $order_sheet_content->item_id = $orders_sheet_item["item_id"];
                $order_sheet_content->product_id = $orders_sheet_item["product_id"];
                $order_sheet_content->order_qty_boxes = isset($orders_sheet_item["ordered_qty"]) ? $orders_sheet_item["ordered_qty"] :$orders_sheet_item["qty"];
                $order_sheet_content->batch_id = isset($orders_sheet_item["batch_id"]) ? $orders_sheet_item["batch_id"] : 0 ;
                $order_sheet_content->finish_goods_stock_boxes = isset($orders_sheet_item["assigned_qty"]) ? isset($orders_sheet_item["assigned_qty"]) : 0;
                $order_sheet_content->required_stock_boxes = 0;
                $order_sheet_content->from_customer = 1;
                $order_sheet_content->ctns_stock = $orders_sheet_item["ctns_stock"];
                $order_sheet_content->bag_box = $orders_sheet_item["bag_box"];
                $order_sheet_content->sticker_tray_stock = $orders_sheet_item["sticker_tray_stock"];
                $order_sheet_content->ppb_stock = $orders_sheet_item["ppb_stock"];
                $order_sheet_content->avg_pieces_packet = $orders_sheet_item["avg_pieces_packet"];
                $order_sheet_content->batches_to_make_stock = $orders_sheet_item["batches_to_make_stock"];
                $order_sheet_content->remarks = $orders_sheet_item["remarks"];
                if ($req->supplier_assignment) {
                    $mathcing_obj = array_filter($req->supplier_assignment,  function ($x) use ($orders_sheet_item) {
                        if ($x["item_id"] ==  $orders_sheet_item["item_id"]) {
                            return $x;
                        }
                    });
                    if (collect($mathcing_obj)->count() > 0) {
                        foreach ($mathcing_obj as $match) {
                            $order_sheet_content->required_stock_boxes = $match["required_qty"];
                            $order_sheet_content->supplier_id = $match["supplier"];
                        }
                    }
                }
                $order_sheet_content->created_at = Carbon::now();
                $order_sheet_content->updated_at = Carbon::now();
                $order_sheet_content->updated_by = Auth::user()->id;
                $order_sheet_content->created_by = Auth::user()->id;
                if ($order_sheet_content->save()) {
                    $status = "success";
                } else {
                    $status = "failed";
                }
            }
            if ($status == "success") {
                return response(["message" => "success", 'order_sheet_id' => $order_sheet_id]);
            } else {
                return response(["message" => "error"]);
            }
        }
    }
    public function downloadPdf($order_sheet_id)
    {

        $order_sheet = OrderSheet::find($order_sheet_id);
        $order_sheet_contents = OrderSheetContent::where('order_sheet_id', $order_sheet_id)->get();
        $supplierwiseContent = [];
        foreach ($order_sheet_contents as $key => $order_sheet_content) {
            if ($order_sheet_content->supplier_id != 0) {
                $supplier_id = Supplier::find($order_sheet_content->supplier_id);
                $supplier_id =  $supplier_id->company_name;
                $supplierwiseContent[$supplier_id][$key] = $order_sheet_content;
            }
        }
        if(collect($supplierwiseContent)->count() > 0){
            $order_sheet_contents =   $supplierwiseContent;
        }
        // dd($order_sheet_contents['Multifood Factory'][0]->supplier_id);
        $order = Orders::where('id', $order_sheet->order_id)->first();
        $total_required = 0;
        foreach ($order_sheet_contents as $content) {
            foreach ($content as $$order_sheet_content) {
                $total_required += $order_sheet_content->required_stock_boxes;
            }
        }
        $html = view('order_sheet_views.order_sheet_pdf', compact('order_sheet', 'order_sheet_contents', 'order', 'total_required'));
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set(array('isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true));
        $dompdf->set_paper('a4', 'landscape');
        $dompdf->setOptions($options);
        $dompdf->loadHTML($html);
        $dompdf->render();
        $pdf = $dompdf->output();
        $invnoabc = 'Order_sheet_' . $order_sheet_id . '.pdf';
        return $dompdf->stream($invnoabc);
    }
}
