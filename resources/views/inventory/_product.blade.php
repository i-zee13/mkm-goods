@extends('layouts.master')

@section('content')
<div class="row mt-2 mb-3">
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
    <input type="text" name="brandType" value="new" hidden>
    <input type="text" name="productType" value="new" hidden>
    <div class="col-md-12">
        <div class="card">
            <div id="floating-label">
                <div id="example-basic">
                    <h3>New <span class="wz-c">Brand</span><span class="wz-icon"><i class="fa fa-tag"></i></span></h3>
                    <section>
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active newBrandTab" id="pills-home-tab" data-toggle="pill"
                                    href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Add
                                    New Brands</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link existingBrandTab" id="pills-profile-tab" data-toggle="pill"
                                    href="#pills-profile" role="tab" aria-controls="pills-profile"
                                    aria-selected="false">Existing Brands</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="form-wrap _w90 PT-10 PB-10">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="_head03">Add New <span>Brand</span></h3>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label mb-10">Brand ID*</label>
                                                <input type="text" name="brand_custom_id" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label mb-10">Brand Name*</label>
                                                <input type="text" name="brand_name" class="form-control">
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <div class="form-s2 pt-19">
                                                <select class="form-control wizardFormSelect" id="mainCatDD"
                                                    placeholder="Select Primary Service*">
                                                    <option value="0" selected disabled>Select Primary Service</option>
                                                    @foreach ($main as $item)
                                                    <option value="{{ $item->id }}">{{ $item->service_name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-s2 pt-19">
                                        <select class="form-control wizardFormSelect" name="sub_category_id"
                                            placeholder="Select Sub Service*">
                                            <option value="0">Select Sub Service*</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <form id="thumbnailForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="pt-19">
                                            <label class="font12">Add Thumbnail Picture*</label>
                                            <div class="upload-pic"></div>
                                            <input type="file" name="thumbnail" id="thumbnail" class="dropify"
                                                accept="image/x-png,image/jpg,image/jpeg" />
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <div class="pt-19">
                                        <label class="font12">Add Pictures*</label>
                                        <div id="dzContainer"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="PT-10 font12">Description</label>
                                    <div class="form-group">
                                        <textarea name="brand_description" rows="8"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="form-wrap _w90 PT-10 PB-10">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="_head03">Select Existing <span> Brand</span></h3>
                            </div>
                            <div class="col-md-12">
                                <div class="form-s2 pt-19">
                                    <select class="form-control wizardFormSelect" name="existing_brand_id"
                                        placeholder="Select Existing Brand">
                                        <option value="0" disabled selected>Select Existing Brand*</option>
                                        @foreach ($brands as $b)
                                        <option value="{{ $b->id }}">{{ $b->brand_custom_id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </section>
            <h3>New <span class="wz-c">Product</span><span class="wz-icon"><i class="fa fa fa-plus"></i></span>
            </h3>
            <section>
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active newProdTab" id="new_product_tab" data-toggle="pill"
                            href="#new_product_pill" role="tab" aria-controls="new_product_pill"
                            aria-selected="false">Add New
                            Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link existingProdTab" id="existing_product_tab" data-toggle="pill"
                            href="#existing_prod_pill" role="tab" aria-controls="existing_prod_pill"
                            aria-selected="true">Existing Products</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="new_product_pill" role="tabpanel"
                        aria-labelledby="new_product_tab">
                        <div class="form-wrap _w90 PT-10 PB-10">
                            <div class="row">
                                <div class="col-md-12 pt-10">
                                    <h3 class="_head03">Add New <span>Product</span></h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">SKU*</label>
                                        <input type="text" name="sku" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Product Name*</label>
                                        <input type="text" name="product_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-s2 pt-19">
                                        <select class="form-control wizardFormSelect" id="mainCatDD"
                                            placeholder="Select Primary Service*" name="main_cat_id">
                                            <option value="0" selected disabled>Select Primary Service</option>
                                            @foreach ($main as $item)
                                            <option value="{{ $item->id }}">{{ $item->service_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-s2 pt-19">
                                        <select class="form-control wizardFormSelect" name="sub_category_id"
                                            placeholder="Select Sub Service*">
                                            <option value="0">Select Sub Service*</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <form id="productImgForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="pt-19">
                                            <label class="font12">Add Picture</label>
                                            <div class="upload-pic"></div>
                                            <input type="file" name="picture" id="product_picture" class="dropify" />
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <label class="PT-10 font12">Description</label>
                                    <div class="form-group">
                                        <textarea name="product_description" rows="8"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="existing_prod_pill" role="tabpanel"
                        aria-labelledby="existing_product_tab">
                        <div class="form-wrap _w90 PT-10 PB-10">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="_head03">Select Existing <span> Product</span></h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-s2 pt-19">
                                        <select class="form-control wizardFormSelect" name="existing_product_id"
                                            placeholder="Select Existing Product">
                                            <option value="0">Select Existing Product*</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <h3>New <span class="wz-c">Item</span>
                <span class="wz-icon"><i class="fa fa fa-box-open"></i></span></h3>
            <section>
                <div class="col-md-12">
                    <div class="form-wrap _w90 PT-10 PB-10">
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
                                <h3 class="_head03">Basic <span>Unit</span></h3>
                            </div>
                            <div class="col-md-6">
                                <div class="form-s2 pt-19">
                                    <select class="form-control wizardFormSelect" name="unit_id"
                                        placeholder="Select Unit Type">
                                        <option value="0" selected disabled>Select Unit Type</option>
                                        @foreach ($units as $item)
                                        <option value="{{ $item->id }}">{{ $item->unit_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">Unit Weight</label>
                                    <input type="number" name="unit_weight" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 pt-10">
                                <h3 class="_head03">Packaging <span>Option</span></h3>
                            </div>
                            <div class="col-md-6">
                                <div class="form-s2 pt-19">
                                    <select class="form-control wizardFormSelect" name="variant_id"
                                        placeholder="Select Variants Type">
                                        <option value="0" selected disabled>Select Variant Type</option>
                                        @foreach ($variants as $item)
                                        <option value="{{ $item->id }}">{{ $item->variant_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">Unit Quantity</label>
                                    <input type="number" name="unit_quantity" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-s2 pt-19">
                                    <select class="form-control wizardFormSelect" name="variant_id_2"
                                        placeholder="Select Variants Type">
                                        <option value="0" selected disabled>Select Variant Type
                                        </option>
                                        @foreach ($variants as $item)
                                        <option value="{{ $item->id }}">{{ $item->variant_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">Variant Quantity*</label>
                                    <input type="number" name="variant_quantity_2" class="form-control"
                                        style="font-size: 13px">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-s2 pt-19">
                                    <select class="form-control wizardFormSelect" name="variant_id_3"
                                        placeholder="Select Variants Type">
                                        <option value="0" selected disabled>Select Variant Type
                                        </option>
                                        @foreach ($variants as $item)
                                        <option value="{{ $item->id }}">{{ $item->variant_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label mb-10">Variant Quantity*</label>
                                    <input type="number" name="variant_quantity_3" class="form-control"
                                        style="font-size: 13px">
                                </div>
                            </div>

                            <div class="col-md-12 pt-10">
                                <h3 class="_head03">Carton <span> Size</span></h3>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label mb-10">Cartan Size</label>
                                    <input type="number" name="unit_variant_quantity" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label mb-10">Length</label>
                                    <input type="text" name="length" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label mb-10">Width</label>
                                    <input type="text" name="width" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label mb-10">Height</label>
                                    <input type="text" name="height" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2 CBM_val">
                                <label>CBM Value</label>
                                <div class="form-group p-0 m-0 h-auto">
                                    <input type="text" name="cbm_value_label" class="form-control" readonly>
                                    <input type="text" name="cbm_value" hidden>
                                </div>
                            </div>
                            <div class="col-md-2 CBM_val">
                                <label>Actual CBM</label>
                                <div class="form-group p-0 m-0 h-auto">
                                    <input type="text" name="actual_cbm" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label mb-10">Standrad Unit Price</label>
                                    <input type="number" name="standrad_unit_price" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</div>
</div>
@endsection
