<?php

namespace App\Http\Controllers;

use App\Batch;
use App\CompanyCurrentStock;
use App\Customer;
use App\CustomerStock;
use App\ItemUnits;
use App\ItemVariants;
use App\ProductItems;
use App\StockMangment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Svg\Tag\UseTag;

class StockManagmentController extends Controller
{
    // NOTE :- if you find repetition of the same comment that indicates the starting and ending point of the code for a specific purpose.
    public function indexForOpeningStock()
    {
        $item_variants = ItemVariants::all()->toArray();
        $keys = array_keys($item_variants);
        $variant_names = [];
        foreach ($item_variants as $key => $value) {
            $variant_names[$value["id"]] = $value["variant_name"];
        }
        $items = ProductItems::all();
        // items whose stock is already added
        $added_items = StockMangment::select('item_id')->where('transaction_type', 'opening_stock')->get();
        if (collect($added_items)->count() > 0) {
            $added_items = collect($added_items)->map(function ($x) {
                return $x->item_id;
            })->toArray();
            $items = $items->filter(function ($x) use ($added_items) {
                if (!in_array($x->id,  $added_items)) {
                    return $x;
                }
            });
        }
        // items whose stock is already added
        // $batches = Batch::all();
        return view('stocks.add_stock', compact('items', 'variant_names', 'keys'));
    }
    public function indexForProductionStock()
    {
        $item_variants = ItemVariants::all()->toArray();
        $keys = array_keys($item_variants);
        $variant_names = [];
        foreach ($item_variants as $key => $value) {
            $variant_names[$value["id"]] = $value["variant_name"];
        }
        $items = ProductItems::all();
        // items whose stock is already added
        $added_items = StockMangment::select('item_id')->where('transaction_type', 'opening_stock')->get();
        if (collect($added_items)->count() > 0) {
            $added_items = collect($added_items)->map(function ($x) {
                return $x->item_id;
            })->toArray();
            $items = $items->filter(function ($x) use ($added_items) {
                if (!in_array($x->id,  $added_items)) {
                    return $x;
                }
            });
        }
        // items whose stock is already added
        $batches = Batch::all();
        $customers = Customer::all();

        return view('stocks.add_production_stock', compact('items', 'variant_names', 'keys', 'batches', 'customers'));
    }
    public function addStock(Request $req)
    {
        if ($req->transaction_type == 'opening_stock') {
            $checkOpeningStock = StockMangment::where('Item_id', $req->item_id)->where('transaction_type', 'opening_stock')->where('product_id', $req->product_id)->first();
            if ($checkOpeningStock) {
                return 2;
            }
        }
        $ids    =   Session()->has('ids_of_recent_inserted_records') ? Session('ids_of_recent_inserted_records') : [];
        $stock = new StockMangment();
        $stock["customer_id"] =  0;
        if ($req->customer_id && $req->customer_id != 0) {
            $stock["customer_id"] =  $req->customer_id;
        }
        $stock["Item_id"] = $req->item_id;
        $stock["manufacturing_date"] = $req->manufaturing_date;
        $stock["expiry_date"] = $req->expiry_date;
        $stock["batch_id"] = $req->batch_id;
        $stock["quantity"] = str_replace(',', '', $req->item_in_pieces);
        $stock["product_id"] = $req->product_id;
        $stock["unit_id"] = $req->unit_id;
        $stock["product_name"] = $req->product_name;
        $stock["unit_name"] = $req->unit_name;
        $stock["transaction_type"] = $req->transaction_type ? $req->transaction_type : "";
        $stock["state"] = "in";
        $stock["unit_name"] =  $req->unit_name;
        $stock["remarks"] =  $req->remarks;
        // need to work on it (possibly)
        $stock["damage"] =  0;
        $stock["table_name"] =  '';
        $stock["refrence_id"] =  0;
        // need to work on it (possibly)
        $stock["created_at"] =  Carbon::now();
        $stock["created_by"] =  Auth::user()->id;
        $stock["updated_at"] =  Carbon::now();
        $stock["balance"] = str_replace(',', '', $req->item_in_pieces);
        if ($req->transaction_type == 'production') {
            $lastRecord = StockMangment::where('Item_id', $req->item_id)->where('batch_id', $req->batch_id)->where('state', 'in')->where('product_id', $req->product_id)->latest()->first();
            if ($lastRecord) {
                $stock["balance"] =  $lastRecord['balance'] + str_replace(',', '', $req->item_in_pieces);
                $production_id =  $lastRecord['production_id'];
                if ($production_id) {
                    $value = explode('-', $production_id);
                    $value[1] = intval($value[1]);
                    $value[1] = $value[1] + 1;
                    $value[1] = strval($value[1]);
                    $value[1] = str_pad($value[1], 3, '0', STR_PAD_LEFT);
                    $value = implode('-', $value);
                    $stock["production_id"] = $value;
                }
                if (!$production_id) {
                    $stock["production_id"] =  $req->batch_id . '-' . '001';
                }
            }
            if (!$lastRecord) {
                $stock["production_id"] =  $req->batch_id . '-' . '001';
            }
            $companyStock = new CompanyCurrentStock($stock->toArray());
            unset($companyStock->remarks);
            unset($companyStock->production_id);
            $companyStock->save();
        }
        if ($req->transaction_type == 'customer_specific') {
            $lastRecord = StockMangment::where('Item_id', $req->item_id)->where('batch_id', $req->batch_id)->where('state', 'out')->where('product_id', $req->product_id)->where('customer_id', $req->customer_id)->latest()->first();
            if ($lastRecord) {
                $stock["balance"] =  $lastRecord['balance'] + str_replace(',', '', $req->item_in_pieces);
                $production_id =  $lastRecord['production_id'];
                if ($production_id) {
                    $value = explode('-', $production_id);
                    $value[1] = intval($value[1]);
                    $value[1] = $value[1] + 1;
                    $value[1] = strval($value[1]);
                    $value[1] = str_pad($value[1], 3, '0', STR_PAD_LEFT);
                    $value = implode('-', $value);
                    $stock["production_id"] = $value;
                }
                if (!$production_id) {
                    $stock["production_id"] =  $req->batch_id . '-' . '001';
                }
            }
            if (!$lastRecord) {
                $stock["production_id"] =  $req->batch_id . '-' . '001';
            }
            // another entry to deduct the customer stock from the stock_managment
            $updatedStockForCustomer = new StockMangment($stock->toArray());
            $updatedStockForCustomer["state"] = 'out';
            $updatedStockForCustomer["transaction_type"] = 'customer_stock_transfer';
            if ($stock->save()) {
                $ids[] = $stock->id;
                session(['ids_of_recent_inserted_records' => $ids]);
            }
            $id = $stock->id;
            // to maintain the balance 
            $recentStock = StockMangment::find($id);
            $updatedStockForCustomer["balance"] = $recentStock["balance"] - str_replace(',', '', $req->item_in_pieces);
            // to maintain the balance 
            // to update customer stock table
            $customerStock =    $updatedStockForCustomer;
            if ($updatedStockForCustomer->save()) {
                $ids[] = $updatedStockForCustomer->id;
                session(['ids_of_recent_inserted_records' => $ids]);
                $newCustomerStock = new CustomerStock($customerStock->toArray());
                $newCustomerStock["transaction_type"] = 'production';
                $newCustomerStock["state"] = 'in';
                $newCustomerStock["balance"] = str_replace(',', '', $req->item_in_pieces);
                $newCustomerStock["quantity"] = str_replace(',', '', $req->item_in_pieces);
                $newCustomerStock["stock_type"] = 'company';
                // check if the quantity of same batch is already assigned to the customer or not
                $check = CustomerStock::where('Item_id', $req->item_id)->where('batch_id', $req->batch_id)->where('state', 'in')->where('product_id', $req->product_id)->where('customer_id', $req->customer_id)->latest()->first();
                if ($check) {
                    $newCustomerStock["balance"] =  $newCustomerStock["balance"] + $check["balance"];
                }
                unset($newCustomerStock->remarks);
                unset($newCustomerStock->production_id);
                $newCustomerStock->save();
                return "success";
            } else {
                return "error";
            }
        }
        if ($stock->save()) {
            $ids[] = $stock->id;
            session(['ids_of_recent_inserted_records' => $ids]);
            return "success";
        } else {
            return "error";
        }
    }
    public function removeRecentlyAddedRecords()
    {
        $ids = session()->get('ids_of_recent_inserted_records');
        if ($ids && count($ids) > 0) {
            foreach ($ids as $id) {
                $enteredStock = StockMangment::find($id);
                if ($enteredStock) {
                    $enteredStock->delete();
                }
            }
            session()->forget('ids_of_recent_inserted_records');
            return 1;
        } else {
            return 0;
        }
    }
    public function checkIfThereAreAnyRecentEntries()
    {
        $ids = session()->get('ids_of_recent_inserted_records');
        if ($ids && count($ids) > 0) {
            return 1;
        }
        return 0;
    }
    public function saveStocks()
    {
        $ids = session()->get('ids_of_recent_inserted_records');
        if ($ids && count($ids) > 0) {
            session()->forget('ids_of_recent_inserted_records');
            return 1;
        }
        return 0;
    }
    public function transferStock()
    {
        $batches = Batch::all();
        $customers = Customer::all();
        return view('stocks.transfer_stock', compact('batches', 'customers'));
    }
    public function getItemsOfBatch($batch_id)
    {
        $items = DB::select('
        SELECT brp.sku, ccs.*
        FROM   company_current_stock ccs
        LEFT JOIN company_current_stock ccs2
           ON (ccs.item_id = ccs2.item_id AND ccs.id < ccs2.id) 
   		JOIN brand_related_products brp ON brp.id = ccs.product_id
        WHERE  ccs2.id IS NULL AND ccs.balance > 0 AND ccs.batch_id = ' . $batch_id);
        return $items;
    }
    public function transferStockToCustomer(Request $req)
    {
        if (isset($req->stock_for_customer)) {
            $stocks = json_decode($req->stock_for_customer);
            $result = '';
            if (collect($stocks)->count() > 0) {
                foreach ($stocks as $key => $stock) {
                    // update balance of the item in the company current stock
                    $existing_stock = CompanyCurrentStock::find($stock->id);
                    $existing_stock->balance =  $existing_stock->balance - intval($stock->quantity);
                    $existing_stock->quantity =  intval($stock->quantity);
                    $existing_stock->state = 'out';
                    $existing_stock->transaction_type = 'customer_stock_transfer';
                    $existing_stock->created_at = Carbon::now();
                    $existing_stock->created_by = Auth::user()->id;
                    unset($existing_stock->id);
                    $updatedCompanyStock = new CompanyCurrentStock($existing_stock->toArray());
                    if ($updatedCompanyStock->save()) {
                        // update balance of the item in the company current stock
                        // assign the stock to the customer
                        $customerNewStock = new CustomerStock($updatedCompanyStock->toArray());
                        unset($customerNewStock->id);
                        $customerNewStock->customer_id = $req->customer_id;
                        $customerNewStock->balance = $customerNewStock->quantity;
                        $customerNewStock->state = 'in';
                        $customerNewStock->created_at = Carbon::now();
                        $customerNewStock->created_by = Auth::user()->id;
                        // if the customer is assigned some of the stock already from the same batch maintain the balance accordingly
                        $customerOldStock = CustomerStock::where('item_id', $stock->item_id)->where('batch_id', $stock->batch_id)->where('product_id', $stock->product_id)->where('customer_id', $req->customer_id)->latest()->first();
                        if ($customerOldStock) {
                            $customerNewStock->balance =  $customerOldStock->balance + $customerNewStock->quantity;
                        }
                        // if the customer is assigned some of the stock already from the same batch maintain the balance accordingly
                        if ($customerNewStock->save()) {
                            $result =  "success";
                        } else {
                            $result =  "failed";
                        }
                        // assign the stock to the customer
                    }
                }
                return $result;
            }
        }
    }
}
