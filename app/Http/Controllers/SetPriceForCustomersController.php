<?php

namespace App\Http\Controllers;

use App\BrandProducts;
use App\Customer;
use App\FixPricesForCustomer;
use App\ItemPriceHistory;
use App\ProductItems;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetPriceForCustomersController extends Controller
{
    public function customersProducts($id)
    {
        $itemsCustomerPrices = [];
        $fixedPricesForCustomer = FixPricesForCustomer::where('customer_id', $id)->get();
        // to check if the customer has already a fix price for an item or not.
        $fixedPricesForCustomerIds = array_column($fixedPricesForCustomer->toArray(), 'item_id');
        foreach ($fixedPricesForCustomer as $value) {
            $itemsCustomerPrices[$value->item_id] = $value->price;
        }
        $items = ProductItems::all();
        return view('pricing_for_customers.index', compact('items', 'id', 'fixedPricesForCustomerIds', 'itemsCustomerPrices'));
    }
    public function customersList()
    {
        $check = FixPricesForCustomer::select('customer_id')->distinct()->get();
        $checkIds = [];
        foreach ($check as $key => $value) {
            $checkIds[$key] = $value->customer_id;
        }
        $customers = Customer::select('id', 'company_id', 'company_name', 'is_active')->get();
        return view('pricing_for_customers.customers-list', compact('customers', 'checkIds'));
    }
    public function savePricesForSpecificCustomer(Request $req)
    {
        if ($req['item_id'] && $req['customer_id'] && $req['price']) {
            //check if the customer is already assigned a custom price for the item came inside the request
            $customPrice = FixPricesForCustomer::where('customer_id', $req['customer_id'])->where('item_id', $req['item_id'])->first();
            if (!$customPrice) {
                $item = ProductItems::find($req['item_id']);
                $newPriceForCustomer = new FixPricesForCustomer();
                $newPriceForCustomer->product_id =  $item->product_id;
                $newPriceForCustomer->item_id =  $item->id;
                $newPriceForCustomer->price =  $req['price'];
                $newPriceForCustomer->customer_id =  $req['customer_id'];
                $newPriceForCustomer->standard_price = $item->standrad_unit_price;
                $newPriceForCustomer->created_by = Auth::user()->id;
                $newPriceForCustomer->created_at = Carbon::now()->format('Y-m-d H:i:s');
                $newPriceForCustomer->updated_at = Carbon::now()->format('Y-m-d H:i:s');
                if ($newPriceForCustomer->save()) {
                    return "success";
                } else {
                    return "error";
                }
            } else {
                // maintain a history for the change in price
                $historyOfTheItem = new ItemPriceHistory();
                $historyOfTheItem->product_id = $customPrice->product_id;
                $historyOfTheItem->item_id = $customPrice->item_id;
                $historyOfTheItem->price = $customPrice->price;
                $historyOfTheItem->customer_id = $customPrice->customer_id;
                $historyOfTheItem->starting_date_of_price = $customPrice->updated_at;
                $historyOfTheItem->ending_date_of_price = Carbon::now()->format('Y-m-d H:i:s');
                $historyOfTheItem->created_at = Carbon::now()->format('Y-m-d H:i:s');
                $historyOfTheItem->created_by = Auth::user()->id;
                $historyOfTheItem->fix_price_for_customer_id = $customPrice->id;
                $historyOfTheItem->save();
                //update the previous record in the fix_price_for_customers table
                $customPrice->price = $req['price'];
                $customPrice->updated_at = Carbon::now()->format('Y-m-d H:i:s');
                if ($customPrice->save()) {
                    return 'updated';
                } else {
                    return "error";
                }
            }
        } else {
            return "Incomplete Information";
        }
    }
}
