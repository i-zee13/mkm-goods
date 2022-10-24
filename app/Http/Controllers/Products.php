<?php

namespace App\Http\Controllers;

use App\BrandImages as BI;
use App\BrandProducts as BP;
use App\Brands as B;
use App\Http\Controllers\Core\AccessRightsAuth;
use App\ProductItems as PI;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use URL;
use stdClass;

class Products extends AccessRightsAuth
{
    public $controllerName = "Products";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function calculateNetWeigth($request)
    {
        $netWeigthOfItem = [];
        $netWeigth = $request["unit_weight"] ? 1 : 0;

        $netWeigthOfItem["unit_variant_quantity"] = $request["unit_variant_quantity"] ? $request["unit_variant_quantity"] : 1;
        $netWeigthOfItem["variant_quantity_3"] = $request["variant_quantity_3"] ? $request["variant_quantity_3"] : 1;
        $netWeigthOfItem["variant_quantity_2"] = $request["variant_quantity_2"] ? $request["variant_quantity_2"] : 1;
        $netWeigthOfItem["unit_quantity"] = $request["unit_quantity"] ? $request["unit_quantity"] : 1;
        $netWeigthOfItem["primary_unit_weigth"] = $request["unit_weight"];
        foreach ($netWeigthOfItem as $value) {
            if ($value != null) {
                $netWeigth *= $value;
            }
        }

        // $packigingWeights = [];
        // $packigingWeights["master_carton_packiging_weigth"] =   $request["master_carton_packiging_weigth"] ;
        // $packigingWeights["variant_3_packiging_weigth"] =   $request["variant_3_packiging_weigth"] ;
        // $packigingWeights["variant_2_packiging_weigth"] =   $request["variant_2_packiging_weigth"] ;
        // $packigingWeights["variant_1_packiging_weigth"] =   $request["variant_1_packiging_weigth"] ;

        $weigthOfMasterCaron = $request["master_carton_packiging_weigth"];

        $weigthOfVariantQuantity3 = $request["unit_variant_quantity"] * $request["variant_3_packiging_weigth"];
        $weigthOfVariantQuantity2 =   $request["unit_variant_quantity"] *   ($request["variant_quantity_3"] ? $request["variant_quantity_3"] : 1)  * $request["variant_2_packiging_weigth"];
        $weigthOfVariantQuantity1 = $request["unit_variant_quantity"]  *   ($request["variant_quantity_3"] ? $request["variant_quantity_3"] : 1)  *  ($request["variant_quantity_2"] ? $request["variant_quantity_2"] : 1)  *  $request["variant_1_packiging_weigth"];
        $grossWeight = $netWeigth + $weigthOfMasterCaron +  $weigthOfVariantQuantity3 + $weigthOfVariantQuantity2 +   $weigthOfVariantQuantity1;
        $result["net_weigth"] =  $netWeigth;
        $result["gross_weigth"] = $grossWeight;
        return $result;
    }
    public function index()
    {

        return view('inventory.brandsList', ['brands' => B::selectRaw('id, brand_custom_id, brand_name, sub_category_id, (SELECT count(*) from brand_related_products where brand_id = product_brands.id) as totalProducts')->get()]);
    }

    public function getSubCats($mainCatId)
    {
        echo json_encode(DB::table('secondary_services')->where('primary_service_id', $mainCatId)->get());
    }

    public function addProduct()
    {
        
        return view('inventory.product', ['brands' => B::all(), 'units' => DB::table('item_units')->get(), 'variants' => DB::table('item_variants')->get(), 'main' => DB::table('main_services')->get(), 'product_sku' => ""]);
    }

    public function viewBrandProducts($brandId = null)
    {
        if ($brandId) {
            return view('inventory.productsList', ['products' => BP::selectRaw('id, sku, name, (SELECT count(*) from product_related_items where product_id = brand_related_products.id) as totalItems')->whereRaw('brand_id = ' . $brandId)->get(), 'main' => DB::table('main_services')->get(), 'sub' => DB::table('secondary_services')->get()]);
        }

        return view('inventory.productsList', ['products' => BP::selectRaw('id, sku, name, CONCAT("' . URL::to('/') . '", "/storage/products/", picture) as picture, CONCAT("' . URL::to('/') . '", "/storage/products/", picture) as picture, (SELECT count(*) from product_related_items where product_id = brand_related_products.id) as totalItems, primary_service_id, sub_category_id, description')->get(), 'main' => DB::table('main_services')->get(), 'sub' => DB::table('secondary_services')->get()]);
    }

    public function viewProductItems($sku)
    {
        return view('inventory.itemsList', ['variants' => DB::table('item_variants')->get(), 'units' => DB::table('item_units')->get(), 'product_sku' => $sku]);
    }

    public function FetchItems($sku)
    {
        return json_encode(PI::selectRaw('
        id,
        name,
        length,
        width,
        height,
        unit_weight,
        unit_id,variant_1_packiging_weigth,
        variant_2_packiging_weigth, variant_3_packiging_weigth,
        variant_unit_price, master_carton_packiging_weigth,
        (SELECT unit_name from item_units where id = product_related_items.unit_id) as unit_name,
        (SELECT variant_name from item_variants where id = product_related_items.variant_id) as variant_name,
        (CASE WHEN variant_id IS NOT NULL THEN (SELECT variant_name from item_variants where id = product_related_items.variant_id_2) END) as variant_2_name,
        (CASE WHEN variant_id IS NOT NULL THEN (SELECT variant_name from item_variants where id = product_related_items.variant_id_3) END) as variant_3_name,
        variant_id, variant_id_2, variant_id_3, unit_quantity, variant_quantity_2, variant_quantity_3, unit_variant_quantity, cbm_value, standrad_unit_price,
        description, actual_cbm,
        (SELECT variant_name from item_variants where id = product_related_items.variant_id) as variant,
        (SELECT unit_name from item_units where id = product_related_items.unit_id) as unit')->where('product_sku', $sku)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getBrandProducts($brandId)
    {

        echo json_encode(BP::where('brand_id', $brandId)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function FetchProducts($brandId = null)
    {
        if ($brandId) {
            return json_encode(BP::selectRaw('id, sku, name, CONCAT("' . URL::to('/') . '", "/storage/products/", picture) as picture, CONCAT("' . URL::to('/') . '", "/storage/products/", detailed_picture) as detailed_picture, (SELECT count(*) from product_related_items where product_sku = brand_related_products.sku) as totalItems, primary_service_id, sub_category_id, description')->where('brand_id', $brandId)->get());
        }

        return json_encode(BP::selectRaw('id, sku, name, CONCAT("' . URL::to('/') . '", "/storage/products/", picture) as picture, CONCAT("' . URL::to('/') . '", "/storage/products/", detailed_picture) as detailed_picture, (SELECT count(*) from product_related_items where product_sku = brand_related_products.sku) as totalItems, primary_service_id, sub_category_id, description')->get());
    }

    public function SaveProduct(Request $request)
    {
        $bp = BP::find($request->product_id);
        $bp->sku = $request->sku;
        $bp->name = $request->name;
        $bp->description = $request->description;
        $bp->primary_service_id = $request->primary_service_id;
        $bp->sub_category_id = $request->sub_category_id;
        $bp->updated_by = Auth::user()->id;

        if ($request->hasFile('thumbnail')) {
            $completeFileName = $request->file('thumbnail')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $randVal = rand();
            $brandImage = 'brandproduct-' . $randVal . '_' . time() . '.' . $extension;
            $path = $request->file('thumbnail')->storeAs('public/products', $brandImage);
            $bp->picture = $brandImage;
        }

        if ($request->hasFile('picture')) {
            $completeFileName = $request->file('picture')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $randVal = rand();
            $brandImage = 'brandproduct-' . $randVal . '_' . time() . '.' . $extension;
            $path = $request->file('picture')->storeAs('public/products', $brandImage);
            $bp->detailed_picture = $brandImage;
        }

        $status = $bp->save();
        if ($status) {
            return json_encode(['code' => 200]);
        }

        return json_encode(['code' => 100]);
    }

    public function SaveItem(Request $request)
    {
        // dd($request->all());
        $weightInKG = ($request->cbm_value ? $request->cbm_value : $request->actual_cbm);
        //CBM CALCULATION:
        $cbm_20 = ($weightInKG > 0 ? (($request->cbm_value || $request->actual_cbm) ? 29.25077203 / $weightInKG : 0) : 0);
        $cbm_40 = ($weightInKG > 0 ? (($request->cbm_value || $request->actual_cbm) ? 57.66580772 / $weightInKG : 0) : 0);
        $cbm_40_hc = ($weightInKG > 0 ? (($request->cbm_value || $request->actual_cbm) ? 73.54479825 / $weightInKG : 0) : 0);

        //WEIGHT CALCUATION:
        $weightCalc = 28000 / (($request->unit_weight * ($request->unit_quantity ? $request->unit_quantity : 1)) * ($request->variant_quantity_2 && $request->variant_id_2 ? $request->variant_quantity_2 : 1) * ($request->variant_quantity_3 && $request->variant_id_3 ? $request->variant_quantity_3 : 1) * $request->unit_variant_quantity);

        $pi = PI::find($request->item_id);
        if (!$pi) {
            $pi = new PI();
            $pi->product_sku = $request->product_sku;
            $product = BP::where('sku', $request->product_sku)->first();
            $pi->product_id =   $product->id;
        }

        $pi->name = $request->name;
        $pi->unit_id = $request->unit_id;
        $pi->unit_weight = $request->unit_weight;
        $pi->unit_variant_quantity = $request->unit_variant_quantity;
        $pi->actual_cbm = $request->actual_cbm;
        $pi->length = $request->length;
        $pi->width = $request->width;
        $pi->height = $request->height;
        $pi->cbm_value = $request->cbm_value_label;
        $pi->standrad_unit_price = $request->master_carton_unit_price;
        $pi->description = $request->description;
        $pi->ft20 = $cbm_20 >= $weightCalc ? $cbm_20 : $weightCalc;
        $pi->ft40 = $cbm_40 >= $weightCalc ? $cbm_40 : $weightCalc;
        $pi->ftHC = $cbm_40_hc >= $weightCalc ? $cbm_40_hc : $weightCalc;
        //fields added on 17-11 by khalil from here
        $pi->variant_1_packiging_weigth = $request->variant_1_packiging_weigth ? $request->variant_1_packiging_weigth : null;
        $pi->variant_2_packiging_weigth = $request->variant_2_packiging_weigth ? $request->variant_2_packiging_weigth : null;
        $pi->variant_3_packiging_weigth = $request->variant_3_packiging_weigth ? $request->variant_3_packiging_weigth : null;
        $pi->variant_unit_price = $request->variant_unit_price ? $request->variant_unit_price : null;
        $pi->master_carton_packiging_weigth = $request->master_carton_packiging_weigth ? $request->master_carton_packiging_weigth : null;

        // to here

        if ($request->variant_id) {
            $pi->variant_id = $request->variant_id;
            $pi->unit_quantity = $request->unit_quantity;
        } else {
            $pi->variant_id = null;
            $pi->unit_quantity = null;
        }

        if ($request->variant_id_2) {
            $pi->variant_id_2 = $request->variant_id_2;
            $pi->variant_quantity_2 = $request->variant_quantity_2;
        }

        if ($request->variant_id_2) {
            $pi->variant_id_3 = $request->variant_id_3;
            $pi->variant_quantity_3 = $request->variant_quantity_3;
        }

        $pi->updated_by = Auth::user()->id;
        // to calculate net weigth and gross weigth
        $req = $request->all();
        $weight = $this->calculateNetWeigth($req);
        $pi->net_weight =   $weight["net_weigth"];
        $pi->gross_weight =   $weight["gross_weigth"];
        // to calculate net weigth and gross weigth
        $status = $pi->save();
        if ($status) {
            return json_encode(['code' => 200]);
        }

        return json_encode(['code' => 100]);
    }

    public function SaveProductRevamp(Request $request)
    {
        $brandProduct = new BP;
        $status;
        try {
            $brandProduct->sku = $request->sku;
            $brandProduct->name = $request->name;
            $brandProduct->description = $request->description;
            $brandProduct->brand_id = $request->brand_id;
            $brandProduct->primary_service_id = $request->main_category;
            $brandProduct->sub_category_id = $request->sub_category_id;
            $brandProduct->short_name = $request->short_name;
            $brandProduct->hs_code = $request->hs_code;
            $brandProduct->created_by = Auth::user()->id;
            

            if ($request->hasFile('product_picture')) {
                $completeFileName = $request->file('product_picture')->getClientOriginalName();
                $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                $extension = $request->file('product_picture')->getClientOriginalExtension();
                $randVal = rand();
                $prodImg = 'brandproduct-' . $randVal . '_' . time() . '.' . $extension;
                $path = $request->file('product_picture')->storeAs('public/products', $prodImg);
                $brandProduct->picture = $prodImg;
            }
            $status = $brandProduct->save();
            $productId = $brandProduct->id;
        } catch (\Illuminate\Database\QueryException $ex) {
            return ['code' => 101, 'message' => $ex];
        }
        if (!$status) {
            return ['code' => 100, 'message' => $status];
        }

        $faultyData = [];

        foreach ($request->items as $key => $i) {
            try {
                $weightInKG = ($i['cbm'] ? $i['cbm'] : $i['actual_cbm']);
                //CBM CALCULATION:
                $cbm_20 = ($weightInKG > 0 ? ($i['cbm'] || $i['actual_cbm']) ? 29.25077203 / $weightInKG : 0 : 0);
                $cbm_40 = ($weightInKG > 0 ? ($i['cbm'] || $i['actual_cbm']) ? 57.66580772 / $weightInKG : 0 : 0);
                $cbm_40_hc = ($weightInKG > 0 ? ($i['cbm'] || $i['actual_cbm']) ? 73.54479825 / $weightInKG : 0 : 0);

                //WEIGHT CALCUATION:
                $weightCalc = 28000 / (($i['unit']['weight'] * ($i['variant_1']['unit_qty'] ? $i['variant_1']['unit_qty'] : 1)) * ($i['variant_2']['var_1_qty'] && $i['variant_2']['id'] ? $i['variant_2']['var_1_qty'] : 1) * ($i['variant_3']['var_2_qty'] && $i['variant_3']['var_2_qty'] ? $i['variant_3']['var_2_qty'] : 1) * $i['ctn_size']);

                $productItems = new PI;
                $productItems->name = $i['alias'];
                if (isset($i['description'])) {
                    $productItems->description = $i['description'] ? $i['description'] : "";
                }

                $productItems->unit_id = $i['unit']['id'];
                $productItems->product_sku = $brandProduct->sku;
                $productItems->unit_weight = $i['unit']['weight'];

                if ($i['variant_1']['id']) {
                    $productItems->variant_id = $i['variant_1']['id'];
                    $productItems->unit_quantity = $i['variant_1']['unit_qty'];
                    $productItems->variant_1_packiging_weigth = $i['variant_1']['variant_1_packiging_weigth'];
                }

                if ($i['variant_2']['id']) {
                    $productItems->variant_id_2 = $i['variant_2']['id'];
                    $productItems->variant_quantity_2 = $i['variant_2']['var_1_qty'];
                    $productItems->variant_2_packiging_weigth = $i['variant_2']['variant_2_packiging_weigth'];
                }

                if ($i['variant_3']['id']) {
                    $productItems->variant_id_3 = $i['variant_3']['id'];
                    $productItems->variant_quantity_3 = $i['variant_3']['var_2_qty'];
                    $productItems->variant_3_packiging_weigth = $i['variant_3']['variant_3_packiging_weigth'];
                }

                $productItems->unit_variant_quantity = $i['ctn_size'];
                $productItems->length = $i['length'];
                $productItems->width = $i['width'];
                $productItems->height = $i['height'];
                $productItems->cbm_value = $i['cbm'];
                $productItems->actual_cbm = $i['actual_cbm'];
                $productItems->master_carton_packiging_weigth = $i['master_carton_packiging_weigth'] ? $i['master_carton_packiging_weigth'] : null;
                $productItems->variant_unit_price = $i['variant_unit_price'] ?  $i['variant_unit_price'] : null;
                $productItems->standrad_unit_price = $i['master_carton_unit_price'];
                $productItems->ft20 = $cbm_20 >= $weightCalc ? $cbm_20 : $weightCalc;
                $productItems->ft40 = $cbm_40 >= $weightCalc ? $cbm_40 : $weightCalc;
                $productItems->ftHC = $cbm_40_hc >= $weightCalc ? $cbm_40_hc : $weightCalc;
                $productItems->product_id = $productId;

                $productItems->created_by = Auth::user()->id;
                $weight = $this->calculateNetWeigth($i);
                $productItems->net_weight =   $weight["net_weigth"];
                $productItems->gross_weight =   $weight["gross_weigth"];
                $productItems->save();

                DB::table('notifications_list')->insert(['code' => config('constants.options._PRODUCT_NOTIFICATION_CODE'), 'message' => 'Product has been added', 'product_id' => $productItems->id, 'created_by' => Auth::user()->id]);
            } catch (\Illuminate\Database\QueryException $ex) {
                $faultyData[] = ['code' => 102, 'message' => $ex];
            }
        }
        if (!sizeof($faultyData)) {
            return ['code' => 200];
        } else {
            return ['code' => 103, 'message' => $faultyData];
        }
    }

    public function SaveBrand(Request $request)
    {
        $brand = new B;
        $brand->brand_custom_id = $request->brand_custom_id;
        $brand->brand_name = $request->brand_name;
        $brand->description = $request->brand_description;

        if ($request->hasFile('brand_thumbnail')) {
            $completeFileName = $request->file('brand_thumbnail')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('brand_thumbnail')->getClientOriginalExtension();
            $randVal = rand();
            $brandImage = 'brandproduct-' . $randVal . '_' . time() . '.' . $extension;
            $path = $request->file('brand_thumbnail')->storeAs('public/products', $brandImage);
            $brand->thumbnail = $brandImage;
        }

        $brand->save();
        $brandId = $brand->id;
        BI::where('token', $request->img_token)->update(['brand_tbl_id' => $brandId, 'token' => null]);
        return ['code' => 200, 'name' => $brand->brand_name, 'id' => $brandId];
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $brandId = $request->existing_brand_id;
        // dd($request->all());
        if ($request->brandType == "new") {
            $brand = new B;
            $brand->brand_custom_id = $request->brand_custom_id;
            $brand->brand_name = $request->brand_name;
            $brand->description = $request->brand_description;
            $brand->save();
            $brandId = $brand->id;
            BI::where('token', $request->img_token)->update(['brand_tbl_id' => $brandId, 'token' => null]);
        }

        $productId = $request->existing_product_id;
        // dd( $request->existing_product_id);
        if ($request->productType == "new") {
            $brandProduct = new BP;
            $brandProduct->sku = $request->sku;
            $brandProduct->name = $request->product_name;
            $brandProduct->description = $request->product_description;
            $brandProduct->brand_id = $brandId;
            $brandProduct->primary_service_id = $request->primary_service_id;
            $brandProduct->sub_category_id = $request->sub_category_id;
            $brandProduct->created_by = Auth::user()->id;
            $brandProduct->save();
            $productId = $brandProduct->id;
        }

        $weightInKG = ($request->cbm_value ? $request->cbm_value : $request->actual_cbm);
        //CBM CALCULATION:
        $cbm_20 = ($weightInKG > 0 ? (($request->cbm_value || $request->actual_cbm) ? 29.25077203 / $weightInKG : 0) : 0);
        $cbm_40 = ($weightInKG > 0 ? (($request->cbm_value || $request->actual_cbm) ? 57.66580772 / $weightInKG : 0) : 0);
        $cbm_40_hc = ($weightInKG > 0 ? (($request->cbm_value || $request->actual_cbm) ? 73.54479825 / $weightInKG : 0) : 0);

        //WEIGHT CALCUATION:
        $weightCalc = 28000 / (($request->unit_weight * ($request->unit_quantity ? $request->unit_quantity : 1)) * ($request->variant_quantity_2 && $request->variant_id_2 ? $request->variant_quantity_2 : 1) * ($request->variant_quantity_3 && $request->variant_id_3 ? $request->variant_quantity_3 : 1) * $request->unit_variant_quantity);

        $productItems = new PI;
        $productItems->name = $request->unit_weight . "gmx" . ($request->unit_quantity ? $request->unit_quantity . 'x' : '') . ($request->variant_quantity_2 && $request->variant_id_2 ? $request->variant_quantity_2 . "x" : "") . ($request->variant_quantity_3 && $request->variant_id_3 ? $request->variant_quantity_3 . "x" : "") . $request->unit_variant_quantity;
        $productItems->description = $request->item_description;
        $productItems->unit_id = $request->unit_id;
        $productItems->product_sku = BP::find($productId)->sku;
        $productItems->unit_weight = $request->unit_weight;

        if ($request->unit_quantity) {
            $productItems->variant_id = $request->variant_id;
            $productItems->unit_quantity = $request->unit_quantity;
        }

        if ($request->variant_id_2) {
            $productItems->variant_id_2 = $request->variant_id_2;
            $productItems->variant_quantity_2 = $request->variant_quantity_2;
        }

        if ($request->variant_id_2) {
            $productItems->variant_id_3 = $request->variant_id_3;
            $productItems->variant_quantity_3 = $request->variant_quantity_3;
        }

        $productItems->unit_variant_quantity = $request->unit_variant_quantity;
        $productItems->length = $request->length;
        $productItems->width = $request->width;
        $productItems->height = $request->height;
        $productItems->cbm_value = $request->cbm_value;
        $productItems->actual_cbm = $request->actual_cbm;
        $productItems->standrad_unit_price = $request->standrad_unit_price;
        $productItems->ft20 = $cbm_20 >= $weightCalc ? $cbm_20 : $weightCalc;
        $productItems->ft40 = $cbm_40 >= $weightCalc ? $cbm_40 : $weightCalc;
        $productItems->ftHC = $cbm_40_hc >= $weightCalc ? $cbm_40_hc : $weightCalc;
        $productItems->product_id = $productId;
        // new fields added on 17-11 by khalil from here
        $productItems->variant_1_packiging_weigth = $request->variant_1_packiging_weigth;
        $productItems->variant_2_packiging_weigth = $request->variant_2_packiging_weigth;
        $productItems->variant_3_packiging_weigth = $request->variant_3_packiging_weigth;
        $productItems->variant_unit_price = $request->variant_unit_price;
        $productItems->master_carton_packiging_weigth = $request->unit_weight;
        // till here on 17-11
        $productItems->created_by = Auth::user()->id;
        $weight = $this->calculateNetWeigth($request);
        $productItems->net_weight =   $weight["net_weigth"];
        $productItems->gross_weight =   $weight["gross_weigth"];
        $productItems->save();

        DB::table('notifications_list')->insert(['code' => config('constants.options._PRODUCT_NOTIFICATION_CODE'), 'message' => 'Product has been added', 'product_id' => $productItems->id, 'created_by' => Auth::user()->id]);

        echo json_encode(["status" => "success", "brand_id" => $brandId, "product_id" => $productId, "data" => ['name' => $productItems->name, 'id' => $productItems->id]]);
    }

    public function saveItemOnly(Request $request)
    {
        $brandId = $request->existing_brand_id;
        if ($request->brandType == "new") {
            $brand = new B;
            $brand->brand_custom_id = $request->brand_custom_id;
            $brand->brand_name = $request->brand_name;
            $brand->sub_category_id = $request->sub_category_id;
            $brand->description = $request->brand_description;
            $brand->save();
            $brandId = $brand->id;
            BI::where('token', $request->img_token)->update(['brand_tbl_id' => $brandId, 'token' => null]);
        }

        $productId = $request->existing_product_id;
        if ($request->productType == "new") {
            $brandProduct = new BP;
            $brandProduct->sku = $request->sku;
            $brandProduct->name = $request->product_name;
            $brandProduct->description = $request->product_description;
            $brandProduct->brand_id = $brandId;
            $brandProduct->save();
            $productId = $brandProduct->id;
        }

        $productItems = new PI;
        $productItems->name = $request->item_name;
        $productItems->description = $request->product_item_description;
        $productItems->unit_id = $request->unit_id;
        $productItems->unit_weight = $request->unit_weight;
        $productItems->variant_id = $request->variant_id;
        $productItems->product_sku = BP::find($productId)->sku;
        $productItems->unit_quantity = $request->unit_quantity;
        $productItems->unit_variant_quantity = $request->unit_variant_quantity;
        $productItems->length = $request->length;
        $productItems->width = $request->width;
        $productItems->height = $request->height;
        $productItems->cbm_value = $request->cbm_value;
        $productItems->standrad_unit_price = $request->standrad_unit_price;
        $productItems->product_id = $productId;
        $productItems->save();

        echo json_encode(["status" => "success", "brand_id" => $brandId, "product_id" => $productId]);
    }

    public function UploadBrandImages(Request $request)
    {
        $file = $request->file('file');
        $completeFileName = $file->getClientOriginalName();
        $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $randomized = rand();
        $brand_images = 'brandimgs' . '-' . $randomized . '_' . time() . '.' . $extension;
        $path = $file->storeAs('public/products', $brand_images);
        BI::insert(array('token' => $request->img_token, 'image' => $brand_images));
        echo json_encode($brand_images);
    }

    public function UploadProdImg(Request $request)
    {
        if ($request->hasFile('picture')) {
            $completeFileName = $request->file('picture')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $randVal = rand();
            $brandImage = 'brandproduct-' . $randVal . '_' . time() . '.' . $extension;
            $path = $request->file('picture')->storeAs('public/products', $brandImage);
            $bp = BP::find($request->product_id);
            $bp->picture = $brandImage;
            $bp->save();
            echo "success";
        }
    }

    public function RemoveBrandImgs(Request $request)
    {
        if (Storage::exists('public/products/' . $request->fileName)) {
            Storage::delete('public/products/' . $request->fileName);
        }
        BI::where('image', $request->fileName)->delete();
    }

    public function DeleteProduct(Request $request)
    {
        $bp = BP::find($request->id);
        if (Storage::exists('public/products/' . $bp->picture)) {
            Storage::delete('public/products/' . $bp->picture);
        }
        if (Storage::exists('public/products/' . $bp->thumbnail)) {
            Storage::delete('public/products/' . $bp->thumbnail);
        }

        $bp->items = PI::where('product_sku', $bp->sku)->get()->toArray();
        DB::table('delete_logs')->insert([
            'product_id' => $bp->id,
            'deleted_by' => Auth::user()->id,
            'verbose' => json_encode($bp->toArray())
        ]);

        DB::select("UPDATE orders o
        JOIN
        (SELECT product_id, SUM(amount) as amount, order_id from order_contents WHERE product_id = $bp->id GROUP BY order_id) oc ON o.id = oc.order_id AND oc.product_id = $bp->id
        set o.total_amount = (o.total_amount-oc.amount)");

        DB::select("DELETE from order_contents WHERE product_id = $bp->id");

        PI::where('product_sku', $bp->sku)->delete();
        BP::find($request->id)->delete();
        echo json_encode(['code' => 200]);
    }

    public function DeleteItem(Request $request)
    {
        DB::table('delete_logs')->insert([
            'item_id' => $request->id,
            'deleted_by' => Auth::user()->id,
            'verbose' => json_encode(PI::find($request->id)->first()->toArray())
        ]);

        DB::select("UPDATE orders o
        JOIN
            (SELECT item_id, SUM(amount) as amount, order_id from order_contents WHERE item_id = $request->id GROUP BY order_id) oc
            ON o.id = oc.order_id AND oc.item_id = $request->id
        set o.total_amount = (o.total_amount-oc.amount)");

        DB::select("DELETE from order_contents WHERE item_id = $request->id");

        PI::find($request->id)->delete();
        echo json_encode(['code' => 200]);
    }

    public function UploadBrandThumbnail(Request $req)
    {
        if ($req->hasFile('thumbnail')) {
            $completeFileName = $req->file('thumbnail')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $req->file('thumbnail')->getClientOriginalExtension();
            $randVal = rand();
            $brandImage = 'brand-' . $randVal . '_' . time() . '.' . $extension;
            $path = $req->file('thumbnail')->storeAs('public/products', $brandImage);
            $brand = B::find($req->brand_id);
            $brand->thumbnail = $brandImage;
            $brand->save();
            echo "success";
        }
    }

    public function openGallery()
    {
        // $products = BP::selectRaw('id, sku, name, description, picture')->paginate(18);
        // foreach ($products as $key => $value) {
        //     if(!Storage::exists('public/products/' . $value->picture) || !$value->picture){
        //         $value->picture = '/images/thumb-placeholder.jpg';
        //     }else{
        //         $value->picture = '/storage/products/'.$value->picture;
        //     }
        // }
        //, ['products' => $products]
        return view('inventory.gallery');
    }

    public function FetchprodctsForGallery()
    {
        $products = BP::selectRaw('id, sku, name, description, picture,brand_id, (Select service_name from main_services where id = brand_related_products.primary_service_id) as main_category,(Select brand_name from product_brands where id = brand_id) as pro_brand_name, (Select service_name from secondary_services where id = brand_related_products.sub_category_id) as sub_category')->whereRaw('brand_id > 0')->get();
        foreach ($products as $key => $value) {
            if (!Storage::exists('public/products/' . $value->picture) || !$value->picture) {
                $value->picture = '/images/thumb-placeholder.jpg';
            } else {
                $value->picture = '/storage/products/' . $value->picture;
            }
        }
        echo json_encode($products);
    }

    public function searchProduct($searchQ)
    {
        $products = BP::selectRaw('sku, name, description, picture as thumbnail')->whereRaw('LOWER(name) LIKE "%' . strtolower($searchQ) . '%" OR LOWER(description) LIKE "%' . strtolower($searchQ) . '%" OR LOWER(sku) LIKE "%' . strtolower($searchQ) . '%"')->get();
        foreach ($products as $key => $value) {
            if (!Storage::exists('public/products/' . $value->thumbnail) || !$value->thumbnail) {
                $value->thumbnail = '/images/thumb-placeholder.jpg';
            } else {
                $value->thumbnail = '/storage/products/' . $value->thumbnail;
            }
        }
        return json_encode($products);
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
    }

    //View
    public function upload_bluk()
    {
        return view('inventory.bulk_product', ['brands' => DB::table('product_brands')->get(), 'products' => DB::table('brand_related_products')->get()]);
    }

    //Download Sample
    public function download_brandwise_sample()
    {
        return redirect('/sample_products_brandwise.xlsx?v=4.0');
    }

    //Save Products BrandWise From Excel
    public function upload_products_brandwise(Request $request)
    {
        if ($request->hasFile('file_productwise')) {
            $extension = File::extension($request->file_productwise->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                $path = $request->file_productwise->getRealPath();
                $data = Excel::load($path, function ($reader) {
                })->get();
                $data_uploaded = false;
                if (!empty($data) && $data->count()) {
                    $counter = 0;
                    $not_upload_able = [];
                    foreach ($data as $key => $value) {
                        $insert = DB::table('brand_related_products')->insert([
                            'sku' => $value->sku,
                            'name' => $value->product_name,
                            'description' => $value->description,
                            'brand_id' => $request->brand,
                            'picture' => $value->thumbnail ? $value->thumbnail : null,
                            'detailed_picture' => $value->image ? $value->image : null,
                            'bulk_upload' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                        ]);
                        $data_uploaded = true;
                        $counter++;
                    }
                    if ($data_uploaded) {
                        echo json_encode(array('status' => 'success', 'not_upload_able' => $not_upload_able));
                    } else {
                        echo json_encode(array('status' => 'failed', 'not_upload_able' => $not_upload_able));
                    }
                }
            } else {
                echo json_encode(array('status' => 'failed', 'not_upload_able' => ''));
            }
        }
    }

    //Download Item Sample
    public function download_productItem_sample()
    {
        return redirect('/sample_items.xlsx?v=4.1');
    }

    public function download_product_items()
    {

        $data = DB::table('product_related_items as pri')->selectRaw('id, product_sku, (Select name from brand_related_products where id = pri.product_id) as product_name, name, (Select unit_name from item_units where id = pri.unit_id) as unit_name, unit_weight, (Select variant_name from item_variants where id = pri.variant_id) as variant_name, unit_quantity,variant_1_packiging_weigth, (Select variant_name from item_variants where id = pri.variant_id_2) as variant_2_name, variant_quantity_2, variant_2_packiging_weigth, (Select variant_name from item_variants where id = pri.variant_id_3) as variant_3_name, variant_quantity_3, variant_3_packiging_weigth, unit_variant_quantity, variant_unit_price, length, width, height, actual_cbm, standrad_unit_price, master_carton_packiging_weigth, (Select service_name from main_services where id = (Select primary_service_id from brand_related_products where id = pri.product_id)) as main_category, (Select service_name from secondary_services where id = (Select sub_category_id from brand_related_products where id = pri.product_id)) as sub_category , (Select short_name from brand_related_products where id = pri.product_id) as short_name , (Select hs_code from brand_related_products where id = pri.product_id) as hs_code')->whereRaw('pri.product_id IN (SELECT id from brand_related_products WHERE brand_id > 0)')->orderBy('product_sku', 'ASC')->get();
        $data = json_decode(json_encode($data), TRUE);
        $headers[] = ['ID', 'Product Sku', 'Product Name', 'Item Name', 'Unit', 'Unit Weight', 'Variant', 'Unit Qty', 'Variant 1 Packiging Weight', 'Variant 2', 'Variant 2 Qty', 'Variant 2 Packiging Weight', 'Variant 3', 'Variant 3 Qty', 'Variant 3 Packiging Weight', 'Master Ctn Qty', 'Master Carton Packiging Weight', 'Variant 1 Unit Price', 'Length', 'Width', 'Height', 'Actual CBM', 'Standard Unit Price', 'Primary Service', 'Sub Service','Short Name','HS Code'];
        $data = array_merge($headers, $data);
        // dd($data);
        $fname = 'Products';
        Excel::create($fname, function ($excel) use ($data) {
            $excel->setTitle('Customer Data');
            $excel->sheet('Customer Data Sheet', function ($sheet) use ($data) {
                $sheet->fromArray($data, null, 'A1', false, false);
            });
        })->store('xlsx', base_path('public'));
        $fileName = "$fname";
        echo URL::to('/') . '/' . $fileName . '.xlsx';
    }

    //Save Product Items From Excel
    public function upload_product_items(Request $request)
    {
        //    dd($request->all());
        if ($request->hasFile('file_productItems')) {
            $extension = File::extension($request->file_productItems->getClientOriginalName());

            $mainCats = json_decode(json_encode(DB::table('main_services')->get()), true);
            $subCats = json_decode(json_encode(DB::table('secondary_services')->get()), true);
            $allProducts = BP::all()->toArray();
            $allItems = PI::all()->toArray();

            $insertData = [];

            foreach ($mainCats as $key => $mainCat) {
                $mainCats[$key]['secondary_services'] = array_values(array_filter($subCats, function ($subCat) use ($mainCat) {
                    return $subCat['primary_service_id'] == $mainCat['id'];
                }));
            }

            $skusUpdated = [];

            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                $path = $request->file_productItems->getRealPath();

                $data = Excel::load($path, function ($reader) {
                })->get();
                // dd($data);
                $variants = json_decode(json_encode(DB::table('item_variants')->get()), true);


                $data_uploaded = [];
                if (!empty($data) && $data->count()) {
                    $counter = 0;
                    $not_upload_able = [];
                    foreach ($data as $key => $value) {
                        $units = json_decode(json_encode(DB::table('item_units')->get()), true);
                        $var_id_found = false;
                        $uni_id_found = false;

                        // Break is necessary to know that WHEN id is null then it means that this is the end of sheet, from here on, it is empty rows
                        if ($request->op == 'add') {
                            if (!$value->custom_id)
                                break;
                        } else {
                            if (!$value->id)
                                break;
                        }

                        $variant_id = 0;
                        $variant_id_2 = 0;
                        $variant_quantity_2 = 0;
                        $variant_id_3 = 0;
                        $variant_quantity_3 = 0;


                        if (isset($value->variant) && $value->variant && isset($value->unit_qty) && $value->unit_qty) {
                            $variantFnd = array_search(strtolower($value->variant), array_map('strtolower', array_column($variants, "variant_name")));
                            if ($variantFnd >= 0 && $variantFnd !== false) {
                                $variant_id = $variants[$variantFnd]["id"];
                            } else {
                                $variant_id = DB::table('item_variants')->insertGetId([
                                    'variant_name' => $value->variant,
                                ]);
                                $variants[] = ['id' => $variant_id, 'variant_name' => $value->variant];
                            }
                        }

                        if (isset($value->variant_2) && $value->variant_2 && isset($value->variant_2_qty) && $value->variant_2_qty) {
                            $variantFnd = array_search(strtolower($value->variant_2), array_map('strtolower', array_column($variants, "variant_name")));
                            if ($variantFnd >= 0 && $variantFnd !== false) {
                                $variant_id_2 = $variants[$variantFnd]["id"];
                            } else {
                                $variant_id_2 = DB::table('item_variants')->insertGetId([
                                    'variant_name' => $value->variant_2,
                                ]);
                                $variants[] = ['id' => $variant_id_2, 'variant_name' => $value->variant_2];
                            }
                        }

                        if (isset($value->variant_3) && $value->variant_3 && isset($value->variant_3_qty) && $value->variant_3_qty) {
                            $variantFnd = array_search(strtolower($value->variant_3), array_map('strtolower', array_column($variants, "variant_name")));
                            if ($variantFnd >= 0 && $variantFnd !== false) {
                                $variant_id_3 = $variants[$variantFnd]["id"];
                            } else {
                                $variant_id_3 = DB::table('item_variants')->insertGetId([
                                    'variant_name' => $value->variant_3,
                                ]);
                                $variants[] = ['id' => $variant_id_3, 'variant_name' => $value->variant_3];
                            }
                        }

                        if(isset($value->unit)){
                            $unit = $value->unit;
                        }else{
                            $unit = $value->unit_name;
                        }
                        $unitFnd = array_search(strtolower($unit), array_map('strtolower', array_column($units, "unit_name")));
                        if ($unitFnd >= 0 && $unitFnd !== false) {
                            $unit_id = $units[$unitFnd]["id"];
                        } else {
                            $unit_id = DB::table('item_units')->insertGetId([
                                'unit_name' => $unit,
                            ]);
                            $units[] = ['id' => $unit_id, 'unit_name' => $value->unit_name];
                        }

                        if (!in_array($value->product_sku, $skusUpdated)) {
                            if (isset($value->main_category) && isset($value->sub_category)) {

                                $mainCatName = strtolower($value->main_category);
                                $mainCatList = array_map('strtolower', array_column($mainCats, "service_name"));

                                $mainIndFnd = array_search(strtolower($value->main_category), array_map('strtolower', array_column($mainCats, "service_name")));
                                $mainCatId = 0;
                                $subCatId = 0;
                                if ($mainIndFnd !== false && $mainIndFnd >= 0) {
                                    $mainCatId = $mainCats[$mainIndFnd]['id'];
                                    $subCatName = strtolower($value->sub_category);
                                    $subCatList = array_map('strtolower', array_column($mainCats[$mainIndFnd]['secondary_services'], "service_name"));
                                    $subIndFnd = array_search(strtolower($value->sub_category), array_map('strtolower', array_column($mainCats[$mainIndFnd]['secondary_services'], "service_name")));
                                    if ($subIndFnd !== false && $subIndFnd >= 0) {
                                        $subCatId = $mainCats[$mainIndFnd]['secondary_services'][$subIndFnd]['id'];
                                    } else {
                                        $subCatId = DB::table('secondary_services')->insertGetId([
                                            'service_name' => $value->sub_category,
                                            'primary_service_id' => $mainCatId,
                                        ]);
                                        $mainCats[$mainIndFnd]['secondary_services'][] = ['id' => $subCatId, 'service_name' => $value->sub_category, 'primary_service_id' => $mainCatId];
                                    }
                                } else {
                                    $mainCatId = DB::table('main_services')->insertGetId([
                                        'service_name' => $value->main_category,
                                    ]);
                                    $subCatId = DB::table('secondary_services')->insertGetId([
                                        'service_name' => $value->sub_category,
                                        'primary_service_id' => $mainCatId,
                                    ]);
                                    $mainCats[] = ['id' => $mainCatId, 'service_name' => $value->main_category, 'secondary_services' => [['id' => $subCatId, 'service_name' => $value->sub_category, 'primary_service_id' => $mainCatId]]];
                                }
                               
                                DB::table('brand_related_products')->whereRaw('sku = "' . $value->product_sku . '"')->update(['primary_service_id' => $mainCatId, 'sub_category_id' => $subCatId , 'hs_code' => $value->hs_code ,'short_name' => $value->short_name ]);
                                $skusUpdated[] = $value->product_sku;
                            }
                        }

                        $indFnd = array_search($value->product_sku, array_column($allProducts, 'sku'));

                        $cal_cbm = ($value->length && $value->width && $value->height ? (($value->length * $value->width * $value->height * 16.39) / 1000000) : 0);

                        $weightInKG = ($cal_cbm ? $cal_cbm : $value->actual_cbm);
                        //CBM CALCULATION:
                        $cbm_20 = ($weightInKG > 0 ? (($cal_cbm || $value->actual_cbm) ? 29.25077203 / $weightInKG : 0) : 0);
                        $cbm_40 = ($weightInKG > 0 ? (($cal_cbm || $value->actual_cbm) ? 57.66580772 / $weightInKG : 0) : 0);
                        $cbm_40_hc = ($weightInKG > 0 ? (($cal_cbm || $value->actual_cbm) ? 73.54479825 / $weightInKG : 0) : 0);

                        //WEIGHT CALCUATION:
                        $res = (($value->unit_weight * ($value->unit_qty ? $value->unit_qty : 1)) * ($variant_id_2 !== 0 ? $value->variant_2_qty : 1) * ($variant_id_3 !== 0 ? $value->variant_3_qty : 1) * $value->master_ctn_qty);

                        $weightCalc = $res ? 28000 / $res : 0;

                        $alreadyExist = true;
                        if (isset($value->custom_id))
                            $alreadyExist = array_search($value->custom_id, array_column($allItems, "custom_id"));
                        $pi = ($request->op == 'add' ? new PI : PI::where('id', $value->id)->first());
                        if ($alreadyExist !== false) {
                            if ($request->op == 'add') {
                                $not_upload_able[] = ['custom_id' => $value->custom_id, 'name' => $value->unit_weight . "gmx" . $value->unit_qty . 'x' . $value->master_ctn_qty, 'reason' => "Duplicate"];
                                $data_uploaded[] = false;
                            } else {
                                $pi->name = $value->unit_weight . "gmx" . ($value->unit_qty ? $value->unit_qty . 'x' : '') . ($value->variant_2_qty && $variant_id_2 ? $value->variant_2_qty . "x" : "") . ($value->variant_3_qty && $variant_id_3 ? $value->variant_3_qty . "x" : "") . $value->master_ctn_qty;
                                $pi->unit_id = $unit_id;
                                $pi->unit_weight = $value->unit_weight;
                                $pi->variant_id = $variant_id;
                                $pi->unit_quantity = $value->unit_qty;
                                $pi->variant_1_packiging_weigth = isset($value["variant_1_packiging_weight"]) ? $value["variant_1_packiging_weight"] : $value["variant_1_packiging_weigth"];

                                $pi->unit_variant_quantity = $value->master_ctn_qty;
                                $pi->variant_id_2 = $variant_id_2 !== 0 ? $variant_id_2 : null;
                                $pi->variant_quantity_2 = $variant_id_2 !== 0 ? $value->variant_2_qty : null;
                                $pi->variant_2_packiging_weigth = isset($value["variant_2_packiging_weight"]) ? $value["variant_2_packiging_weight"] : $value["variant_2_packiging_weigth"];
                                $pi->variant_id_3 = $variant_id_3 !== 0 ? $variant_id_3 : null;
                                $pi->variant_quantity_3 = $variant_id_3 !== 0 ? $value->variant_3_qty : null;
                                $pi->variant_3_packiging_weigth = isset($value["variant_3_packiging_weight"]) ? $value["variant_3_packiging_weight"] : $value["variant_3_packiging_weigth"];
                                $pi->length = $value->length;
                                $pi->width = $value->width;
                                $pi->height = $value->height;
                                $pi->standrad_unit_price = ($value->standard_unit_price ? $value->standard_unit_price : 0);
                                $pi->master_carton_packiging_weigth = isset($value["master_carton_packiging_weight"]) ? $value["master_carton_packiging_weight"] : $value["master_carton_packiging_weigth"];
                                $pi->variant_unit_price = $value->variant_1_unit_price ? $value->variant_1_unit_price : null;
                                $pi->cbm_value = ($value->length && $value->width && $value->height ? (($value->length * $value->width * $value->height * 16.39) / 1000000) : null);
                                $pi->actual_cbm = $value->actual_cbm;
                                $pi->product_sku = $value->product_sku;
                                $pi->ft20 = $cbm_20 >= $weightCalc ? $cbm_20 : $weightCalc;
                                $pi->ft40 = $cbm_40 >= $weightCalc ? $cbm_40 : $weightCalc;
                                $pi->ftHC = $cbm_40_hc >= $weightCalc ? $cbm_40_hc : $weightCalc;
                                $pi->bulk_upload = 1;
                                $pi->product_id = ($indFnd !== false && $indFnd >= 0 ? $allProducts[$indFnd]['id'] : null);
                                //section(adding net and gross weight) start
                                // making clone to make the object as per the need of function calculateNetWeigth()
                                // $tempValue = new stdClass();
                                $tempValue = $value;
                                $tempValue["unit_variant_quantity"] = $tempValue->master_ctn_qty;
                                $tempValue["variant_quantity_3"] = $tempValue->variant_3_qty;
                                $tempValue["variant_quantity_2"] = $tempValue->variant_2_qty;
                                $tempValue["unit_quantity"] = $tempValue->unit_qty;

                                //chepi to avoid spelling mistake
                                $tempValue["variant_1_packiging_weigth"] = isset($value["variant_1_packiging_weight"]) ? $value["variant_1_packiging_weight"] : $value["variant_1_packiging_weigth"];
                                $tempValue["variant_3_packiging_weigth"] = isset($value["variant_3_packiging_weight"]) ? $value["variant_3_packiging_weight"] : $value["variant_3_packiging_weigth"];
                                $tempValue["variant_2_packiging_weigth"] = isset($value["variant_2_packiging_weight"]) ? $value["variant_2_packiging_weight"] : $value["variant_2_packiging_weigth"];
                                $tempValue["master_carton_packiging_weigth"] = isset($value["master_carton_packiging_weight"]) ? $value["master_carton_packiging_weight"] : $value["master_carton_packiging_weigth"];
                                //chepi to avoid spelling mistake
                                $accumilatedWeight = $this->calculateNetWeigth($tempValue);
                                $pi->net_weight = $accumilatedWeight["net_weigth"];
                                $pi->gross_weight = $accumilatedWeight["gross_weigth"];

                                //section(adding net and gross weight) end
                                if ($request->op == 'add') {
                                    $pi->created_at = date('Y-m-d H:i:s');
                                    $pi->created_by = Auth::user()->id;
                                } else {
                                    $pi->updated_at = date('Y-m-d H:i:s');
                                    $pi->updated_by = Auth::user()->id;
                                }

                                $pi->save();
                                $data_uploaded[] = true;
                                $counter++;
                            }
                        } else {

                            //$pi = ($request->op == 'add' ? new PI : PI::where('custom_id', $pi->custom_id)->first() );
                            $pi->custom_id = $value->custom_id;
                            $pi->name = $value->unit_weight . "gmx" . ($value->unit_qty ? $value->unit_qty . 'x' : '') . ($value->variant_2_qty && $variant_id_2 ? $value->variant_2_qty . "x" : "") . ($value->variant_3_qty && $variant_id_3 ? $value->variant_3_qty . "x" : "") . $value->master_ctn_qty;
                            $pi->description = $value->description;
                            $pi->unit_id = $unit_id;
                            $pi->unit_weight = $value->unit_weight;
                            $pi->variant_id = $variant_id;
                            $pi->unit_quantity = $value->unit_qty;
                            $pi->variant_1_packiging_weigth = isset($value["variant_1_packiging_weight"]) ? $value["variant_1_packiging_weight"] : $value["variant_1_packiging_weigth"];
                            $pi->unit_variant_quantity = $value->master_ctn_qty;
                            $pi->variant_id_2 = $variant_id_2 !== 0 ? $variant_id_2 : null;
                            $pi->variant_quantity_2 = $variant_id_2 !== 0 ? $value->variant_2_qty : null;
                            $pi->variant_2_packiging_weigth = isset($value["variant_2_packiging_weight"]) ? $value["variant_2_packiging_weight"] : $value["variant_2_packiging_weigth"];
                            $pi->variant_id_3 = $variant_id_3 !== 0 ? $variant_id_3 : null;
                            $pi->variant_quantity_3 = $variant_id_3 !== 0 ? $value->variant_3_qty : null;
                            $pi->variant_3_packiging_weigth = isset($value["variant_3_packiging_weight"]) ? $value["variant_3_packiging_weight"] : $value["variant_3_packiging_weigth"];
                            $pi->length = $value->length;
                            $pi->width = $value->width;
                            $pi->height = $value->height;
                            $pi->standrad_unit_price = ($value->standrad_unit_price ? $value->standrad_unit_price : 0);
                            $pi->master_carton_packiging_weigth = isset($value["master_carton_packiging_weight"]) ? $value["master_carton_packiging_weight"] : $value["master_carton_packiging_weigth"];
                            $pi->variant_unit_price = $value->variant_1_unit_price ? $value->variant_1_unit_price : null;
                            $pi->cbm_value = ($value->length && $value->width && $value->height ? (($value->length * $value->width * $value->height * 16.39) / 1000000) : null);
                            $pi->actual_cbm = $value->actual_cbm;
                            $pi->product_sku = $value->product_sku;
                            $pi->ft20 = $cbm_20 >= $weightCalc ? $cbm_20 : $weightCalc;
                            $pi->ft40 = $cbm_40 >= $weightCalc ? $cbm_40 : $weightCalc;
                            $pi->ftHC = $cbm_40_hc >= $weightCalc ? $cbm_40_hc : $weightCalc;
                            $pi->bulk_upload = 1;
                            $pi->product_id = ($indFnd !== false && $indFnd >= 0 ? $allProducts[$indFnd]['id'] : null);
                            //section(adding net and gross weight) start
                            // making clone to make the object as per the need of function calculateNetWeigth()
                            $tempValue = new stdClass();
                            $tempValue = clone $value;

                            $tempValue["unit_variant_quantity"] = $tempValue->master_ctn_qty;
                            $tempValue["variant_quantity_3"] = $tempValue->variant_3_qty;
                            $tempValue["variant_quantity_2"] = $tempValue->variant_2_qty;
                            $tempValue["unit_quantity"] = $tempValue->unit_qty;

                            //chepi to avoid spelling mistake
                            $tempValue["variant_1_packiging_weigth"] = isset($value["variant_1_packiging_weight"]) ? $value["variant_1_packiging_weight"] : $value["variant_1_packiging_weigth"];
                            $tempValue["variant_3_packiging_weigth"] = isset($value["variant_3_packiging_weight"]) ? $value["variant_3_packiging_weight"] : $value["variant_3_packiging_weigth"];
                            $tempValue["variant_2_packiging_weigth"] = isset($value["variant_2_packiging_weight"]) ? $value["variant_2_packiging_weight"] : $value["variant_2_packiging_weigth"];
                            $tempValue["master_carton_packiging_weigth"] = isset($value["master_carton_packiging_weight"]) ? $value["master_carton_packiging_weight"] : $value["master_carton_packiging_weigth"];



                            //chepi to avoid spelling mistake
                            $accumilatedWeight = $this->calculateNetWeigth($tempValue);
                            $pi->net_weight = $accumilatedWeight["net_weigth"];
                            $pi->gross_weight = $accumilatedWeight["gross_weigth"];
                            //section(adding net and gross weight) end
                            if ($request->op == 'add') {
                                $pi->created_at = date('Y-m-d H:i:s');
                                $pi->created_by = Auth::user()->id;
                            } else {
                                $pi->updated_at = date('Y-m-d H:i:s');
                                $pi->updated_by = Auth::user()->id;
                            }

                            $pi->save();

                            // $insert = DB::table('product_related_items')->insert([
                            //     'custom_id' => $value->custom_id,
                            //     'name' => $value->unit_weight . "gmx" . $value->unit_quantity . 'x' . ($variant_id_2 !== 0 ? $value->variant_quantity_2 . "x" : "") . ($variant_id_3 !== 0 ? $value->variant_quantity_3 . "x" : "") . $value->unit_variant_quantity,
                            //     'description' => $value->description,
                            //     'unit_id' => $unit_id,
                            //     'unit_weight' => $value->unit_weight,
                            //     'variant_id' => $variant_id,
                            //     'unit_quantity' => $value->unit_quantity,
                            //     'unit_variant_quantity' => $value->unit_variant_quantity,
                            //     'variant_id_2' => $variant_id_2 !== 0 ? $variant_id_2 : null,
                            //     'variant_quantity_2' => $variant_id_2 !== 0 ? $value->variant_2_quantity : null,
                            //     'variant_id_3' => $variant_id_3 !== 0 ? $variant_id_3 : null,
                            //     'variant_quantity_3' => $variant_id_3 !== 0 ? $value->variant_3_quantity : null,
                            //     'length' => $value->length,
                            //     'width' => $value->width,
                            //     'height' => $value->height,
                            //     'standrad_unit_price' => ($value->standrad_unit_price ? $value->standrad_unit_price : 0),
                            //     'cbm_value' => ($value->length && $value->width && $value->height ? (($value->length * $value->width * $value->height * 16.39) / 1000000) : null),
                            //     'actual_cbm' => $value->actual_cbm,
                            //     'product_sku' => $value->sku,
                            //     'ft20' => $cbm_20 >= $weightCalc ? $cbm_20 : $weightCalc,
                            //     'ft40' => $cbm_40 >= $weightCalc ? $cbm_40 : $weightCalc,
                            //     'ftHC' => $cbm_40_hc >= $weightCalc ? $cbm_40_hc : $weightCalc,
                            //     'bulk_upload' => 1,
                            //     'product_id' => ($indFnd !== false && $indFnd >= 0 ? $allProducts[$indFnd]['id'] : null),
                            //     'created_at' => date('Y-m-d H:i:s'),
                            //     'created_by' => Auth::user()->id,
                            // ]);
                            $data_uploaded[] = true;
                            $counter++;
                        }
                    }
                    if (in_array(true, $data_uploaded)) {
                        echo json_encode(array('status' => 'success', 'not_upload_able' => $not_upload_able));
                    } else {
                        echo json_encode(array('status' => 'failed', 'not_upload_able' => $not_upload_able));
                    }
                }
            } else {
                echo json_encode(array('status' => 'failed', 'not_upload_able' => ''));
            }
        }
    }

    public function ProductDetail($pro_id)
    {
        return view('inventory.product_detail', ['product_sku' => "", 'variants' => DB::table('item_variants')->get(), 'units' => DB::table('item_units')->get(), 'product' => DB::table('brand_related_products as brp')->selectRaw('id, name, sku, picture, description, (Select service_name from main_services where id = brp.primary_service_id) as main_category, (Select service_name from secondary_services where id = brp.sub_category_id) as sub_category')->where('id', $pro_id)->first()]);
    }

    public function GetProItems($id)
    {
        echo json_encode(DB::table('product_related_items as pri')->selectRaw('id, cbm_value, variant_id_2, variant_id_3, variant_quantity_2, variant_quantity_3, (SELECT unit_name from item_units where id = pri.unit_id) as unit_name, (SELECT variant_name from item_variants where id = pri.variant_id) as variant_name, (CASE WHEN variant_id IS NOT NULL THEN (SELECT variant_name from item_variants where id = pri.variant_id_2) END) as variant_2_name, (CASE WHEN variant_id IS NOT NULL THEN (SELECT variant_name from item_variants where id = pri.variant_id_3) END) as variant_3_name, unit_weight, name, description, unit_weight, variant_id, unit_quantity, unit_variant_quantity, (Select variant_name from item_variants where id = pri.variant_id) as variant_name, (Select variant_name from item_variants where id = pri.variant_id_2) as variant_name_2, (Select variant_name from item_variants where id = pri.variant_id_3) as variant_name_3')->where('product_id', $id)->get());
    }

    public function items()
    {
        $brands = DB::table('product_brands')->get();
        return view('inventory.all_items', ['brands' => $brands]);
    }

    public function FetchAllItems()
    {
        echo json_encode(DB::table('product_related_items as pri')->selectRaw('id, name, product_id, variant_unit_price, (SELECT name from brand_related_products where id = pri.product_id) as product_name, length, width, height, unit_weight, unit_id, variant_id, unit_quantity, unit_variant_quantity, cbm_value, standrad_unit_price, description, actual_cbm, (SELECT variant_name from item_variants where id = pri.variant_id) as variant, (SELECT unit_name from item_units where id = pri.unit_id) as unit, standrad_unit_price, (Select brand_id from brand_related_products where id = pri.product_id) as brand')->get());
    }

    public function update_item_price(Request $request, $id)
    {
        $item = PI::find($id);
        $historic_prices = $item->historic_prices ? json_decode($item->historic_prices, true) : [];

        $historic_prices[] = ['at' => date('Y-m-d H:i:s'), 'employee_id' => Auth::user()->id, 'employee' => Auth::user()->name, 'old_price' => $item->standrad_unit_price, 'new_price' => $request->new_price];

        $item->historic_prices = json_encode($historic_prices);
        $item->variant_unit_price = $request->new_price;

        $status = $item->save();
        if ($status) {
            return json_encode(['code' => 200]);
        }

        return json_encode(['code' => 100]);
    }

    public function send_excel_through_mail(Request $request)
    {

        $data = DB::table('product_related_items as pri')->selectRaw('id, name, standrad_unit_price, (Select picture from brand_related_products where id = pri.product_id) as picture, (Select name from brand_related_products where id = pri.product_id) as product_name')->get();
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'S.No');
        $sheet->setCellValue('B1', 'Product Name');
        $sheet->setCellValue('C1', 'Item Name');
        $sheet->setCellValue('D1', 'Standard Price');
        $sheet->setCellValue('E1', 'Picture');
        $rowCount = 2;

        foreach ($data as $item) {
            $path = "";
            if (Storage::exists('public/products/' . $item->picture)) {
                $path = URL::asset('public/products/' . $item->picture);
            } else {
                $path = base_path() . '\public\images\thumb-placeholder.jpg';
            }
            $sheet->setCellValue('A' . $rowCount, $item->id);
            $sheet->setCellValue('B' . $rowCount, $item->product_name);
            $sheet->setCellValue('C' . $rowCount, $item->name);
            $sheet->setCellValue('D' . $rowCount, $item->standrad_unit_price);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $spreadsheet->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(65);

            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setPath(base_path() . '/public/images/thumb-placeholder.jpg');
            $drawing->setCoordinates('E' . $rowCount);
            $drawing->setHeight(85);
            $drawing->setWorksheet($spreadsheet->getActiveSheet());

            $rowCount++;
        }

        $fileName = '/public/excel-sheets/download.xlsx';
        $spreadsheet->getSecurity()->setLockWindows(true);
        $spreadsheet->getSecurity()->setLockStructure(true);
        $spreadsheet->getSecurity()->setWorkbookPassword("PhpSpreadsheet");
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filePath = base_path('/public/excel-sheets/price-list.xlsx');
        $writer->save($filePath);
        $spreadsheet->disconnectWorksheets();

        unset($spreadsheet);
        return '/excel-sheets/price-list.xlsx';
    }

    public function ProductOrderOccurence()
    {
        return view('inventory.productOccurence', ['variants' => DB::table('item_variants')->get(), 'units' => DB::table('item_units')->get()]);
    }

    public function fetchAllOccurences()
    {
        return DB::table('product_related_items as pri')->selectRaw('id, name, (SELECT count(*) from order_contents WHERE item_id = pri.id) as occurences, product_id, (SELECT name from brand_related_products where id = pri.product_id) as product_name, length, width, height, unit_weight, unit_id, variant_id, unit_quantity, unit_variant_quantity, cbm_value, standrad_unit_price, description, actual_cbm, (SELECT variant_name from item_variants where id = pri.variant_id) as variant, (SELECT unit_name from item_units where id = pri.unit_id) as unit, standrad_unit_price, (Select brand_id from brand_related_products where id = pri.product_id) as brand')->OrderBy('occurences', 'desc')->get();
    }

    public function GetOccurencies(Request $r)
    {
        return DB::select("SELECT item_id, order_id, (SELECT invoice_num from orders WHERE id = oc.order_id) as invoice, (SELECT current_status from orders WHERE id = oc.order_id) as status FROM order_contents as oc WHERE item_id = $r->item_id GROUP BY order_id");
    }
    public function checkTheAvailablityOfProductsku($sku){
        $isAvailble = BP::where('sku',$sku)->first();
        if($isAvailble != null){
            return 1;
        }else{
            return 0;
        }
    }
}
