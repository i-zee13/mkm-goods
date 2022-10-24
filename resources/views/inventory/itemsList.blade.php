@extends('layouts.master')
@section('data-sidebar')
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">Add <span>Item</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter pt-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <form style="display: flex;" id="saveItemForm">
                                    @csrf
                                    <input type="text" name="item_id" hidden>
                                    <input type="hidden" name="product_sku" value="{{$product_sku}}">
                                    <div id="floating-label" class="card p-20 top_border mb-3" style="width: 100%">
                                        <h2 class="_head03">Add <span>New Item</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Name*</label>
                                                        <input type="text" name="name" class="form-control required"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row pt-10">
                                                <div class="col-md-12">
                                                    <label class="font12">Description</label>
                                                    <textarea rows="5" name="description"></textarea>
                                                </div>
                                            </div>
                                            <div class="row pt-10">
                                                <div class="col-md-12 pt-10">
                                                    <h3 class="_head03">Basic <span>Unit</span></h3>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2">
                                                        <label class="font12">Weight/Unit*</label>
                                                        <select class="form-control wizardFormSelect required"
                                                            id="unitDDSidebar" name="unit_id"
                                                            placeholder="Select Unit Type*">
                                                            <option value="0" selected disabled>Select Unit Type*
                                                            </option>
                                                            @foreach ($units as $unit)
                                                            <option value="{{ $unit->id }}">{{ $unit->unit_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pt-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Unit Weight*</label>
                                                        <input type="number" name="unit_weight"
                                                            class="form-control required positive" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row pt-10">
                                                <div class="col-md-12 pt-10">
                                                    <h3 class="_head03">Packaging <span>Option</span></h3>
                                                </div>
                                                <div class="col-md-4 pr-0 PT-5">
                                                    <div class="form-s2">
                                                        <label class="font12 mb-0">Select Variant</label>
                                                        <select class="form-control wizardFormSelect required"
                                                            id="variantDDSidebar" name="variant_id"
                                                            placeholder="Select Variant*">
                                                            <option value="0" selected>Select Variant
                                                            </option>
                                                            @foreach ($variants as $variant)
                                                            <option value="{{ $variant->id }}">
                                                                {{ $variant->variant_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pr-0 PT-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Packaging Weight*</label>
                                                        <input name="variant_1_packiging_weigth" type="number" class="form-control required positive">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pr-0 PT-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Unit Quantity*</label>
                                                        <input type="number" name="unit_quantity"
                                                            class="form-control required positive" placeholder="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pt-10">
                                                <div class="col-md-4 pr-0 PT-5">
                                                    <div class="form-s2">
                                                        <label class="font12 mb-0">Select Variant
                                                            <small>(optional)</small></label>
                                                        <select class="form-control wizardFormSelect"
                                                            name="variant_id_2" id="select_variant_2" placeholder="Select Variants Type">
                                                            <option value="0" selected>Select Variant Type
                                                            </option>
                                                            @foreach ($variants as $item)
                                                            <option value="{{ $item->id }}">{{ $item->variant_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pr-0 PT-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Packaging Weight*</label>
                                                        <input name="variant_2_packiging_weigth" type="number" class="form-control positive">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pr-0 PT-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Variant Quantity*</label>
                                                        <input type="number" name="variant_quantity_2"
                                                            class="form-control positive" style="font-size: 13px">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pt-10">
                                                <div class="col-md-4 pr-0 PT-5">
                                                    <div class="form-s2">
                                                        <label class="font12 mb-0">Select Variant
                                                            <small>(optional)</small></label>
                                                        <select class="form-control wizardFormSelect"
                                                            name="variant_id_3" id="select_variant_3" placeholder="Select Variants Type">
                                                            <option value="0" selected>Select Variant Type
                                                            </option>
                                                            @foreach ($variants as $item)
                                                            <option value="{{ $item->id }}">{{ $item->variant_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pr-0 PT-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Packaging Weight*</label>
                                                        <input name="variant_3_packiging_weigth" type="number" class="form-control positive">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pr-0 PT-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Variant Quantity*</label>
                                                        <input type="number" name="variant_quantity_3"
                                                            class="form-control positive" style="font-size: 13px">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pt-10">
                                                <div class="col-md-12 pt-10">
                                                    <h3 class="_head03">Master <span> Carton</span></h3>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Carton Quantity*</label>
                                                        <input type="number" name="unit_variant_quantity"
                                                            class="form-control required positive" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Master Carton Weight/Unit*</label>
                                                        <input type="number" name="master_carton_packiging_weigth" class="form-control required positive">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Length</label>
                                                        <input type="number" name="length" class="form-control  required positive"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Width</label>
                                                        <input type="number" name="width" class="form-control  required positive"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Height</label>
                                                        <input type="number" name="height" class="form-control  required positive"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row pt-10">
                                                
                                                <div class="col-md-4 CBM_val">
                                                    <label>CBM Value</label>
                                                    <div class="form-group p-0 m-0 h-auto">
                                                        <input type="number" name="cbm_value_label" class="form-control positive"
                                                            placeholder="" >
                                                      
                                                    </div>
                                                </div>
                                                <div class="col-md-4 CBM_val">
                                                    <label>Actual Cbm</label>
                                                    <div class="form-group p-0 m-0 h-auto">
                                                        <input type="text" name="actual_cbm" class="form-control positive"
                                                        readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <hr class="mt-10 mb-10">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="font12">Master Carton Unit Price</label>
                                                    <input type="number" name="master_carton_unit_price"
                                                        class="form-control positive required" placeholder="">
                                                </div>
                                                <div class="col-md-6">

                                                    <label class="font12">Variant Price</label>
                                                    <input type="number" name="variant_unit_price"
                                                        class="form-control positive required">

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
        <button type="submit" class="btn btn-primary mr-2" id="saveItemFromSidebar">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancel">Cancel</button>
    </div>
</div>
@endsection
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Products <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Items List</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Items List</h2>
            </div>
            <a class="btn add_button AddNewItem" id="addFromListPage"><i class="fa fa-plus"></i> New Item</a>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto"
                    style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body" style="display: none">
            </div>
        </div>
    </div>
</div>
@endsection
