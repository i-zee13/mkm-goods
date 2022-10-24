@extends('layouts.master')
@section('data-sidebar')
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span>Shipper</span></div>
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
                                <form style="display: flex;" id="saveShipperForm">
                                    @csrf
                                    <input type="text" id="operation" hidden>
                                    <input type="text" name="shipper_id" hidden>
                                    <div id="floating-label" class="card p-20 top_border mb-3" style="width: 100%">
                                        <h2 class="_head03">Shipper <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Company Name*</label>
                                                        <input type="text" name="company_name" class="form-control required"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">POC*</label>
                                                        <input type="text" name="poc" class="form-control required" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">City</label>
                                                        <input type="text" name="city" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Address</label>
                                                        <input type="text" name="address" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Phone</label>
                                                        <input type="text" name="phone" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Fax</label>
                                                        <input type="text" name="fax" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Website</label>
                                                        <input type="text" name="website" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Email</label>
                                                        <input type="email" name="email" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label mb-10">Country</label>
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control required formselect" name="country" placeholder="Select Country">
                                                            <option value="0" disabled selected>Select Country*</option>
                                                            <option value="USA">USA</option>
                                                            <option value="UK">UK</option>
                                                            <option value="Chaina">Chaina</option>
                                                            <option value="Pakistan">Pakistan</option>
                                                        </select>
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
        <button type="submit" class="btn btn-primary mr-2" id="saveShipper">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelShipper">Cancel</button>
    </div>
</div>
@endsection
@section('content')

{{-- Modal --}}
<div class="modal fade bd-example-modal-lg-bulk-shipper" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content top_border">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Bulk <span> Upload</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 bulksection p-0">
                    <div id="floating-label">
                        <div class="form-wrap p-0">
                            <a href="/download_sample_shipper"> <button type="button" class="btn btn-primary font13" style="margin-bottom:15px;">Sample
                                    Download</button></a>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload Excel</span>
                                </div>
                                <div class="custom-file">
                                    <form method="POST" enctype="multipart/form-data" id="upload_excel_form">
                                        {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
                                        @csrf
                                        <input type="file" name="file" class="custom-file-input excel_file_input"
                                            id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label file_name" for="inputGroupFile01">Choose
                                            file</label>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display:none" class="alert alert-danger error_message_div" role="alert"> <strong>Failed!
                        </strong> Following Products are not
                        added due
                        to wrong formatting </div>
                    <div class="table-responsive not_uploadable_products_table">
                    </div>
                </div>
                <div class="modal-footer  border-0 p-0">
                    <button type="button" class="btn btn-cancel close_modal" data-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="button" class="btn btn-primary upload_excel_file_btn">Bulk Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Shippers <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Shipping Companies</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a class="btn add_button openDataSidebarForAddingShipper"><i class="fa fa-plus"></i> New Shipper</a>
                <a style="margin-right:130px;" data-toggle="modal" data-target=".bd-example-modal-lg-bulk-shipper"
                class="btn add_button"><i class="fa fa-plus"></i> Upload Bulk</a>
                <h2>Shipping Companies List</h2>
            </div>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body" style="display: none">
            </div>
        </div>
    </div>
</div>
@endsection
