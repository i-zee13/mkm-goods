@extends('layouts.master')
@section('data-sidebar')
<style>
    #pills-tab {
        border-bottom: 2px solid #174ecd;
        width: 100%;
        padding-bottom: 0px !important;
        margin-bottom: 15px !important;
        justify-content: left !important;
    }
</style>
<div id="product-add">
    <a class="close-sidebar" class="close-btn-pl"></a>
    <div class="pro-header-text ml-0">Add <span>Item</span></div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter pt-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">

                                <input type="text" name="existing_product_id" value="{{ Request::segment(2) }}" hidden>
                                <form style="display: flex;" id="saveItemForm">
                                    <div id="floating-label" class="card top_border mb-3">
                                        <div class="col-md-12" id="addItemSidebarDiv">
                                            <div class="form-wrap PT-10 PB-20">
                                                <div class="row">
                                                    <div class="col-md-12 pt-10">
                                                        <h3 class="_head03">Add New <span> Item</span></h3>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="PT-10 font12">Description</label>
                                                        <div class="form-group">
                                                            <textarea name="item_description" rows="8"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 pt-10">
                                                        <h3 class="_head03">Basic <span>Unit*</span></h3>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-s2">
                                                            <label class="font11 mb-0">Weight/Unit*</label>
                                                            <select class="form-control formselect required" name="unit_id" placeholder="Select Unit Type">
                                                                <option value="0" selected disabled>Select Unit Type
                                                                    *</option>
                                                                @foreach ($units as $item)
                                                                <option value="{{ $item->id }}">{{ $item->unit_name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 PT-5">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Unit Weight*</label>
                                                            <input type="number" name="unit_weight" style="font-size: 13px" class="form-control required positive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 pt-10">
                                                        <h3 class="_head03">Packaging <span>Option*</span></h3>
                                                    </div>
                                                    <div class="col-md-4 pr-0 pt-0">
                                                        <div class="form-s2">
                                                            <label class="font12 mb-0">Select Variant</label>
                                                            <select class="form-control formselect" id="variantDDSidebar" name="variant_id" placeholder="Select Variants Type">
                                                                <option value="0" selected>Select Variant Type
                                                                </option>
                                                                @foreach ($variants as $item)
                                                                <option value="{{ $item->id }}">{{ $item->variant_name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 pr-0 pt-1">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Packaging Weight*</label>
                                                            <input name="variant_1_packiging_weigth" type="number" class="form-control required positive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 pr-0 pt-1">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Unit Quantity*</label>
                                                            <input type="number" name="unit_quantity" class="form-control required positive" style="font-size: 13px">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 pr-0 pt-0 mt-4">
                                                        <div class="form-s2 pt-0">
                                                        <label class="font12 mb-0">Select Variant<small>(Optional)</small></label>
                                                            <select class="form-control formselect" name="variant_id_2" placeholder="Select Variants Type">
                                                                <option value="0" selected>Select Variant Type
                                                                </option>
                                                                @foreach ($variants as $item)
                                                                <option value="{{ $item->id }}">{{ $item->variant_name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 pr-0 pt-1 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Packaging Weight*</label>
                                                            <input name="variant_2_packiging_weigth" type="number" class="form-control positive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 pr-0 pt-1 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Variant Quantity*</label>
                                                            <input type="number" name="variant_quantity_2" class="form-control positive" style="font-size: 13px">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 pr-0 pt-18 mt-4">
                                                        <div class="form-s2 pt-0">
                                                        <label class="font12 mb-0">Select Variant<small>(Optional)<small</label>
                                                            <select class="form-control formselect" name="variant_id_3" placeholder="Select Variants Type">
                                                                <option value="0" selected>Select Variant Type
                                                                </option>
                                                                @foreach ($variants as $item)
                                                                <option value="{{ $item->id }}">{{ $item->variant_name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 pr-0 pt-1 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Packaging Weight*</label>
                                                            <input name="variant_3_packiging_weigth" type="number" class="form-control positive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 pr-0 pt-1 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Variant Quantity*</label>
                                                            <input type="number" name="variant_quantity_3" class="form-control positive" style="font-size: 13px">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 pt-10">
                                                        <h3 class="_head03">Master <span> Carton*</span></h3>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Carton Size*</label>
                                                            <input type="number" name="unit_variant_quantity" style="font-size: 13px" class="form-control required positive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Master Carton Packiging Weight*</label>
                                                            <input type="number" name="master_carton_packiging_weigth" class="form-control required positive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Length</label>
                                                            <input type="number" name="length" style="font-size: 13px" class="form-control required positive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Width</label>
                                                            <input type="number" name="width" style="font-size: 13px" class="form-control required positive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Height</label>
                                                            <input type="number" name="height" style="font-size: 13px" class="form-control required positive">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 CBM_val">
                                                        <label>CBM Value</label>
                                                        <div class="form-group p-0 m-0 h-auto">
                                                            <input type="number" name="cbm_value_label" style="font-size: 13px" class="form-control positive">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 CBM_val">
                                                        <label>Actual CBM</label>
                                                        <div class="form-group p-0 m-0 h-auto">
                                                            <input type="text" name="actual_cbm" disabled style="font-size: 13px" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <hr class="mt-10 mb-10">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="font12">Master Carton Unit Price</label>
                                                        <input type="number" name="master_carton_unit_price" class="form-control required positive" placeholder="">
                                                    </div>
                                                    <div class="col-md-6">

                                                        <label class="font12">Variant Price</label>
                                                        <input type="number" name="variant_unit_price" class="form-control required positive">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="cbmCalcSidebarDiv">
                                            <div class="form-wrap PT-10 PB-20">
                                                <div class="row">
                                                    <div class="col-md-12 pt-10">
                                                        <h3 class="_head03">CBM <span> Calculation</span></h3>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Total Quantity*</label>
                                                            <input type="number" id="ttlQtyCbmCalc" style="font-size: 13px" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Additional Weight/CTN</label>
                                                            <input type="number" id="additionalWeightPerCtnCbmCalc" style="font-size: 13px" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">CBM Value</label>
                                                            <input type="number" id="cbmValForCalc" style="font-size: 13px" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Unit Weight</label>
                                                            <input type="number" id="unitWeightForCalc" style="font-size: 13px" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Net Weight</label>
                                                            <input type="number" id="netWeightCbmCalc" style="font-size: 13px" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Total Cbm</label>
                                                            <input type="number" id="toatlCbmCalc" style="font-size: 13px" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <ul class="nav nav-pills float-left" id="pills-tab" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="pill-20-tab" style="border: 0 !important; padding: 7px 15px 5px 15px !important;" data-toggle="pill" href="#pill-20" role="tab" aria-controls="pill-20" aria-selected="true">20 FT</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="pills-40-tab" data-toggle="pill" style="border: 0 !important; padding: 7px 15px 5px 15px !important;" href="#pills-40" role="tab" aria-controls="pills-40" aria-selected="false">40 FT</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="pills-hc-tab" data-toggle="pill" style="border: 0 !important; padding: 7px 15px 5px 15px !important;" href="#pills-hc" role="tab" aria-controls="pills-hc" aria-selected="false">40 FT HC</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="tab-content" id="pills-tabContent">
                                                            <div class="tab-pane fade show active" id="pill-20" role="tabpanel" aria-labelledby="pill-20-tab">
                                                                <div class="contDiv">
                                                                    <div class="contProgress" style="width: 0%"></div>
                                                                    <div class="ProgNO"></div>
                                                                </div>
                                                                <div id="extra20Ft">
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="pills-40" role="tabpanel" aria-labelledby="pills-40-tab">
                                                                <div class="contDiv">
                                                                    <div class="contProgress" style="width: 0%"></div>
                                                                    <div class="ProgNO"></div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="pills-hc" role="tabpanel" aria-labelledby="pills-hc-tab">
                                                                <div class="contDiv">
                                                                    <div class="contProgress" style="width: 0%"></div>
                                                                    <div class="ProgNO"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="_cl-bottom">
        <button id="pl-close2" type="submit" class="btn btn-cancel m-0 mr-2 closeProductAddSidebar">Cancel</button>
        <button type="button" id="addProduct" class="btn btn-primary m-0">Add Item</button>
    </div>
</div>
@endsection
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Product Detail</h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Product Management</span></a></li>
            <li><span>Product Detail</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 mb-30">
        <div class="card top_border _product-D">
            <div class="row">
                <div class="col-md-5"> <img class="_product-IMG" src="{{URL::to('/')."/storage/products/".$product->picture}}" alt="" /> </div>
                <div class="col-md-7 _product-RS">
                    <h2>{{$product->name}}</h2>
                    <span class="_Cat"><strong>Service: </strong> {{$product->main_category}} </span> <span class="_Cat"><strong>Sub
                            Service: </strong> {{$product->sub_category}} </span>
                    <p>{{$product->description}}</p>
                    <div class="items-available">
                        <h3>Available Items <a class="btn add_button AddNewItem"><i class="fa fa-plus"></i> New Item</a>
                        </h3>
                        <div style="min-height: 250px; display:none" id="tblLoader">
                            <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                        </div>
                        <ul class="listOfItems">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection