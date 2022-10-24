@extends('layouts.master')
@section('content')

<div class="first_div">
    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Import <span>Product</span>
            </h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6"></div>
    </div>
    <div class="card">
        <div class="col-12 bulksection mt-20">
            <div id="floating-label">
                <div class="form-wrap p-0">
                    <form method="POST" enctype="multipart/form-data" id="upload_brandwiseProducts_form">
                        {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
                        @csrf
                        <div class="form-s2 p-0 pb-15 col-md-4">
                            <select name="brand" class="form-control formselect select_brand"
                                placeholder="Select Brand">
                                <option value="0" selected disabled>Select Brand*</option>
                                @if (!empty($brands))
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload Excel</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="file_productwise"
                                    class="custom-file-input excel_file_productwise" id="inputGroupFile01"
                                    aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label file_name_product" for="inputGroupFile01">Choose
                                    file</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div style="display:none" class="alert alert-danger error_message_products_div" role="alert">
                <strong>Failed!
                </strong> Following Products are not added due to wrong formatting </div>
            <div class="table-responsive not_uploadable_products_table">
            </div>
        </div>
        <div class="col-md-12 PB-15">
            <a href="/download_brandwise_sample"><button type="button" class="btn btn-primary font13 mr-2">Download
                    Sample</button></a>
            <button type="button" class="btn btn-primary upload_products_brand_wise font13">Bulk Upload</button>
        </div>
    </div>
</div>



<div class="second_div mt-20">
    <div class="row mt-2">
        <div class="col-lg-6 col-md-6 col-sm-6 ">
            <h2 class="_head01">Upload <span>Variants</span>
            </h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6"></div>
    </div>
    <div class="card">
        <div class="col-12 bulksection mt-20">
            <div id="floating-label">
                <div class="form-wrap p-0">
                    <form method="POST" enctype="multipart/form-data" id="upload_productsItem_form">
                        {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
                        @csrf
                         
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon02">Upload Excel</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" name="file_productItems" class="custom-file-input excel_file_productItems"
                            id="inputGroupFile02" aria-describedby="inputGroupFileAddon02">
                        <label class="custom-file-label file_name_items" for="inputGroupFile02">Choose
                            file</label>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div style="display:none" class="alert alert-danger error_message_div" role="alert"> <strong>Failed!
            </strong> Following Items are not added due to wrong formatting </div>
        <div class="table-responsive not_uploadable_items_table">
        </div>
    </div>
    <div class="col-md-12 PB-15">
        <a href="/download_productItem_sample"><button type="button" class="btn btn-primary font13 mr-2">Download
                Sample</button></a>
        {{-- <button type="button" class="btn btn-primary font13 mr-2 download_product_items">Download Sample</button> --}}
        <button type="button" class="btn btn-primary upload_product_item font13">Bulk Upload</button>
    </div>
</div>


<div class="third_div mt-20">
    <div class="row mt-2">
        <div class="col-lg-6 col-md-6 col-sm-6 ">
            <h2 class="_head01">Update <span>Products & Items</span>
            </h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6"></div>
    </div>
    <div class="card">
        <div class="col-12 bulksection mt-20">
            <div id="floating-label">
                <div class="form-wrap p-0">
                    <form method="POST" enctype="multipart/form-data" id="update_productsItem_form">
                        {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon03">Upload Excel</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="file_productItems"
                                    class="custom-file-input excel_file_productItems_update" id="inputGroupFile03"
                                    aria-describedby="inputGroupFileAddon03">
                                <label class="custom-file-label file_name_items_update" for="inputGroupFile03">Choose
                                    file</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div style="display:none" class="alert alert-danger error_message_div_update" role="alert"> <strong>Failed!
                </strong> Following Items are not added due to wrong formatting </div>
            <div class="table-responsive not_uploadable_items_table_update">
            </div>
        </div>
        <div class="col-md-12 PB-15"> 
            <button type="button" class="btn btn-primary font13 mr-2 download_product_items">Download Products</button>
            <button type="button" class="btn btn-primary update_product_item font13">Bulk Upload</button>
        </div>
    </div>
</div>
@endsection
