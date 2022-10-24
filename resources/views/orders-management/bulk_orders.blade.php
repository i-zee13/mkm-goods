@extends('layouts.master')
@section('content')

<div class="first_div">
    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Upload <span>Orders</span>
            </h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6"></div>
    </div>
    <div class="card">
        <div class="col-12 bulksection mt-20">
            <div id="floating-label">
                <div class="form-wrap p-0">
                    <form method="POST" enctype="multipart/form-data" id="upload_orderExcel_form">
                        {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
                        @csrf
                        <div class="row">
                            <div class="form-s2 p-0 pb-15 col-md-3 m-10">
                                <select class="form-control formselect select_currency_bulkUpload"
                                    placeholder="Select Brand">
                                    <option value="0" selected disabled>Select Currency*</option>
                                    <option sign="$" value="USD">USD - United States Dollar</option>
                                    <option sign="Rs" value="PKR">PKR - Pakistan Rupees </option>
                                    <option sign="HK$" value="HKD">HKD — Hong Kong dollar</option>
                                    <option sign="AFN" value="AFN">AFN — Afghani</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload Excel</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="file"
                                    class="custom-file-input order_file_input" id="inputGroupFile01"
                                    aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label file_name" for="inputGroupFile01">Choose
                                    file</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div style="display:none" class="alert alert-danger error_message_div" role="alert"> <strong>Failed!
                </strong> Following Orders are not added due to wrong formatting </div>
            <div class="table-responsive not_uploadable_orders_table">
            </div>
        </div>
        <div class="modal-footer pt-0 border-0">
            <a href="/download_sample_order" class="sample_download_link"><button type="button" class="btn btn-primary font13">Download
                    Sample</button></a>
            <button type="button" class="btn btn-primary upload_order_file_btn font13">Bulk Upload</button>
        </div>
    </div>
</div>



<div class="second_div mt-20">
    <div class="row mt-2">
        <div class="col-lg-6 col-md-6 col-sm-6 ">
            <h2 class="_head01">Upload <span>Order Items</span>
            </h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6"></div>
    </div>
    <div class="card">
        <div class="col-12 bulksection mt-20">
            <div id="floating-label">
                <div class="form-wrap p-0">
                    <form method="POST" enctype="multipart/form-data" id="upload_orderItemsExcel_form">
                        {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
                        @csrf
                       
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon02">Upload Excel</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input orderItem_file_input"
                                id="inputGroupFile02" aria-describedby="inputGroupFileAddon02">
                            <label class="custom-file-label file_name_items" for="inputGroupFile02">Choose
                                file</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div style="display:none" class="alert alert-danger error_message_div_items" role="alert"> <strong>Failed!
            </strong> Following Items are not added due to wrong formatting </div>
        <div class="table-responsive ">
        </div>
    </div>
    <div class="modal-footer border-0 pt-0">
        <a href="/download_sample_order_items"><button type="button" class="btn btn-primary font13">Download
                Sample</button></a>
        <button type="button" class="btn btn-primary upload_orderItems_file_btn font13">Bulk Upload</button>
    </div>
</div>
</div>

@endsection
