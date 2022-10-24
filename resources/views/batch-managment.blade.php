@extends('layouts.master')
@section('data-sidebar')
<style>
    .in_value {
        font-family: 'Rationale', sans-serif !important;
        font-size: 20px !important;
        text-align: right;
        width: 140px;
        margin-left: auto;
        height: 30px !important
    }
</style>
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text"><span>Batch</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <form style="display: flex; width: 100%" id="saveEmployeeForm" enctype="multipart/form-data">
            {!! Form::hidden('employee_updating_id', '') !!}
            @csrf
            <input type="text" id="operation" hidden>
            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter pt-0">
                        <div class="container">


                            <div class="row">

                                <div class="col-12">
                                    <div class="card p-20 top_border mb-3">

                                        <h2 class="_head03">Batch <span>Details</span></h2>

                                        <div class="form-wrap p-0">

                                            <div class="row">
                                                <div class="col-md-6 font14 pt-5">
                                                    <strong>Batch Id</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="batch_id" class="form-control" placeholder="">
                                                </div>
                                                <div class="col-12">
                                                    <hr class="mt-5 mb-5">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 font14 pt-5">
                                                    <strong>Batch Type</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2">
                                                        <select name="batch_type" id="batch_type" class="form-control formselect" placeholder="Batch Type">
                                                            <option>General Production</option>
                                                            <option>Private Label</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <hr class="mt-5 mb-5">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 font14 pt-5">
                                                    <strong>Manufacturing Date</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="manufacturing_date" name="manufacturing_date" class="form-control" placeholder="">
                                                </div>
                                                <div class="col-12">
                                                    <hr class="mt-5 mb-5">
                                                </div>
                                            </div>
                                                <!-- <div class="row">
                                                    <div class="col-md-6 font14 pt-5">
                                                        <strong>Expiry Date</strong>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" id="expiry_date" name="expiry_date" class="form-control" placeholder="">
                                                    </div>
                                                    <div class="col-12">
                                                        <hr class="mt-5 mb-5">
                                                    </div>
                                                </div> -->

                                            <div class="row">
                                                <div class="col-md-6 font14 pt-5">
                                                    <strong>Supplier</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2">
                                                        <select name="supplier" id="supplier" class="form-control formselect" placeholder="select Country">
                                                            @foreach($suppliers as $supplier)
                                                            <option value="{{$supplier->id}}">{{$supplier->company_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <hr class="mt-5 mb-5">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 font14 pt-5">
                                                    <strong>Remarks</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="remarks" class="form-control" placeholder="">
                                                </div>
                                                <div class="col-12">
                                                    <hr class="mt-5 mb-5">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 font14 pt-5">
                                                    <strong>Batch Status</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2">
                                                        <select name="batch_status" id="batch_status" class="form-control formselect" placeholder="select Country">
                                                            <option value="New">New</option>
                                                            <option value="closed">closed</option>
                                                            <option value="On Going">On Going</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
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
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2" id="saveEmployee">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelEmployee">Cancel</button>
    </div>
</div>
@endsection
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Batch <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Batches</span></a></li>
            <li><span>List</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a id="productlist01" href="#" class="btn add_button openDataSidebarForAddingEmployee"><i class="fa fa-plus"></i> <span> New Batch</span></a>
                <h2>Batch <span> List</span></h2>
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