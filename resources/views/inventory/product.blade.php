@extends('layouts.master')
@section('data-sidebar')
    <div id="product-cl-sec">
        <a href="#" id="pl-close" class="close-btn-pl"></a>
        <div class="pro-header-text">New <span>Item</span></div>
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
                                                    <textarea rows="5" name="item_description"></textarea>
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
                                                            class="form-control required unit_weight positive" placeholder="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pt-10">
                                                <div class="col-md-4 pr-0 PT-5">
                                                    <div class="form-s2">
                                                        <label class="font12 mb-0">Select Variant
                                                            <small>(optional)</small></label>
                                                        <select class="form-control wizardFormSelect"
                                                            name="variant_id_2" placeholder="Select Variants Type">
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
                                                            name="variant_id_3" placeholder="Select Variants Type">
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
                                                        <label class="control-label mb-10">Master Carton Packiging Weight*</label>
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
                                                        <input type="text" name="actual_cbm" class="form-control"
                                                        disabled>
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
            <button type="submit" class="btn btn-primary mr-2" id="saveItemsAddProductPage">Save</button>
            <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancel">Cancel</button>
        </div>
    </div>
    <div id="product-add">
        <a id="pl-close2" class="close-btn-pl pl-close"></a>
        <div class="pro-header-text ml-0">New <span>Brand</span></div>
        <div class="pc-cartlist">
            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter pt-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div id="floating-label" class="card p-20 top_border">
                                        <form id="saveBrandForm" enctype="multipart/form-data">
                                            @csrf
                                            <h2 class="_head03">Add <span>New Brand</span></h2>
                                            <div class="form-wrap p-0">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Brand ID*</label>
                                                            <input type="text" class="form-control requiredBrand"
                                                                name="brand_custom_id">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Brand Name*</label>
                                                            <input type="text" class="form-control requiredBrand"
                                                                name="brand_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="font12">Description</label>
                                                        <div>
                                                            <textarea name="brand_description" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h2 class="_head03 mt-15">Add <span>Brand Pictures</span></h2>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-wrap p-0">
                                                            <label class="font12 mb-5">Thumbnail Picture*</label>
                                                            <div class="upload-pic"></div>
                                                            <input type="file" name="brand_thumbnail" id="input-file-now"
                                                                class="dropify" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 PT-10">
                                                        <label class="font12 mb-5">Pictures*</label>
                                                        <div id="dzContainer"></div>
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
        </div>
        <div class="_cl-bottom">
            <button type="button" id="saveBrand" class="btn btn-primary mr-2">Add</button>
            <button id="pl-close2" type="submit" class="btn btn-cancel mr-2 pl-close">Cancel</button>
        </div>
    </div>
@endsection
@section('content')

    <style>
        .select-BMS {
            background-color: #f4f4f4;
            padding-bottom: 15px;
            padding-top: 10px
        }

        .select-BMS .form-s2 .select2-container .select2-selection--single {
            border: 1px solid #dddddd;
            background-color: #ffffff;
        }

        .selectBrand {
            position: relative;
            padding-right: 33px;
        }

        .selectBrand .AddBrand {
            z-index: 5;
            top: 0px;
            right: 0px;
            height: 35px;
            width: 33px;
            padding-top: 7px;
            box-shadow: none;
        }

        .Addpro-form .proTextarea {
            padding: 8px;
        }

        .Addpro-form .dropify-wrapper {
            height: 80px !important;
        }

        .Addpro-form .dropify-wrapper .dropify-message span.file-icon {
            font-size: 40px !important;
        }

        table.dataTable {
            margin-top: 5px !important;
        }

        .itemtable td {
            padding: 5px;
        }

        .items-Details-td {
            background-color: #f2f2f2;
            width: auto;
            padding: 8px;
            position: relative;
            font-size: 12px
        }

        .add_button {
            letter-spacing: 1px;
        }

        .pt-4 {
            padding-top: 4px !important;
        }

        .items-Details-td .col strong {
            display: block
        }

        .title-row {
            font-size: 12px;
            background-color: #f5f8fe;
            padding-top: 5px;
            padding-bottom: 5px;
            border-bottom: solid 1px #dee2e6;
            margin: 0;
        }

        .detail-row {
            font-size: 12px;
            margin: 0;
            border-bottom: solid 1px #dee2e6;
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .col-sn {
            flex: 60px;
            max-width: 60px;
            padding-left: 10px;
        }

        .action-col {
            flex: 184px;
            max-width: 184px;
            padding-left: 0;
        }

        .all-col {
            flex: 110px;
            max-width: 110px;
            padding-left: 0;
        }

    </style>
    <div class="row mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Inventory <span>Management</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Inventory</span></a></li>
                <li><span>Add Inventory</span></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header borderB2">
                    <h2>Add <span> Product</span></h2>
                </div>
                <div class="body pt-5">
                    <form id="saveProductForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row select-BMS">
                            <div class="col-md-4">
                                <div class="form-s2">
                                    <label class="font12 mb-5">Select Brand*</label>
                                    <div class="selectBrand">
                                        <a id="productadd" class="btn plus_button AddBrand"><i class="fa fa-plus"></i>
                                        </a>
                                        <select class="form-control formselect requiredAddProduct" name="brand_id"
                                            placeholder="select Brand">
                                            <option value="0" disabled selected>Select Brand*</option>
                                            @foreach ($brands as $b)
                                                <option value="{{ $b->id }}">{{ $b->brand_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-s2">
                                    <label class="font12 mb-5">Primary Service*</label>
                                    <select class="form-control formselect requiredAddProduct" id="mainCatDD"
                                        name="main_category" placeholder="select Primary Service">
                                        <option value="0" selected disabled>Select Primary Service*</option>
                                        @foreach ($main as $item)
                                            <option value="{{ $item->id }}">{{ $item->service_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-s2">
                                    <label class="font12 mb-5">Sub Service*</label>
                                    <select class="form-control formselect requiredAddProduct" name="sub_category_id"
                                        placeholder="select Sub Service">
                                        <option>Select Sub Service</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row Addpro-form">
                            <div class="col-md-12 PT-20 PB-10">
                                <h3 class="_head03">Product <span> Detail</span></h3>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">Product SKU*</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="sku" id="product_sku" class="form-control font15 requiredAddProduct">
                                        <div id="error_for_sku" style="color:red;padding-top:5px;display:none;font-size:14px" ><strong>This Sku Is Not Available</strong></div>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">Product Name*</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" class="form-control requiredAddProduct">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 pt-10">
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-8">
                                        <textarea name="description" class="proTextarea w-100"> </textarea>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-6 pt-10">
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">Add Picture</label>
                                    <div class="col-sm-8">
                                        <div class="form-wrap p-0">
                                            <div class="upload-pic"></div>
                                            <input type="file" name="product_picture" id="input-file-now"
                                                class="dropify" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">Short Name*</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="short_name" id="short_name" class="form-control font15">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">HS Code*</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="hs_code" id="hs_code" class="form-control font15">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12 PT-20">
                            <h3 class="_head03">Item <span> List</span></h3>
                            <a id="addTmpItem" class="btn add_button"><i class="fa fa-plus"></i>
                                <span>Add Item</span></a>
                        </div>
                        <div class="col-12" id="productsTblDiv">
                            <div class="col-12">
                                <div class="row title-row">
                                    <div class="col-3 col-sn"><strong>S.No</strong></div>
                                    <div class="col"><strong>Name</strong></div>
                                    <div class="col-3 all-col"><strong>Variant</strong></div>
                                    <div class="col-3 all-col"><strong>Unit Type</strong></div>
                                    <div class="col-3 all-col"><strong>Unit Weight</strong></div>
                                    <div class="col-3 all-col"><strong>CBM</strong></div>
                                    <div class="col-3 all-col"><strong>Actual CBM</strong></div>
                                    <div class="col action-col"><strong>Action</strong></div>
                                </div>
                            </div>
                            {{-- <table class="table dt-responsive nowrap itemtable" id="" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Variant</th>
                                    <th>Unit Type</th>
                                    <th>Unit Weight</th>
                                    <th>CBM</th>
                                    <th>Actual CBM</th>
                                    <th>Standrad Unit Price</th>
                                    <th style="width: 180px">Action</th>
                                </tr>
                            </thead>
                            <tbody id="itemsListTbody">
                            </tbody>
                        </table> --}}
                        </div>
                        <div class="col-md-12 text-center PT-20">
                            <button type="button" id="saveProductBtn" class="btn btn-primary mr-2">Save</button>
                            <a href="/" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
