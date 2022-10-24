@extends('layouts.master')

@section('data-sidebar')
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">Acquisition <span>Source</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <form style="display: flex; width: 100% !important;" id="saveAcquisitionSourceForm">
            
            @csrf
            <input type="text" id="operation" hidden name="operation">
            <input hidden type="text" id="hidden_AcquisitionSource" name="hidden_AcquisitionSource" value="" />
            <input hidden type="text" id="product_updating_id" name="product_updating_id" value="" />

            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter pt-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div id="floating-label" class="card p-20 top_border mb-3">
                                        <h2 class="_head03">Acquisition <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="control-label mb-10">Acquisition Type</label>
                                                    <div class="form-s2 pt-19">
                                                        <div>
                                                            <select class="form-control required formselect" name="type"
                                                                placeholder="Select Type" >
                                                                <option value="0" disabled selected>Select Acquisition Type*</option>
{{--                                                                <option value="Exhibition">Exhibition</option>--}}
{{--                                                                <option value="Online">Online</option>--}}
{{--                                                                <option value="Other">Other</option>--}}
                                                                <option value="Online">Online</option>
                                                                <option value="Referral">Referral</option>
                                                                <option value="Walk In">Walk In</option>
                                                                <option value="Print Media">Print Media</option>
                                                                <option value="Exhibition">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Name*</label>
                                                        <input type="text" name="name" class="form-control required">
                                                    </div>
                                                </div>
{{--                                                <div class="col-md-6">--}}
{{--                                                    <div class="form-group">--}}
{{--                                                        <label class="control-label mb-10">Year</label>--}}
{{--                                                        <input type="text" name="year" class="form-control">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-6">--}}
{{--                                                    <div class="form-group">--}}
{{--                                                        <label class="control-label mb-10">Cost</label>--}}
{{--                                                        <input type="number" name="cost" class="form-control">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
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
        <button type="submit" class="btn btn-primary mr-2" id="saveAcquisition">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelAcquisition">Cancel</button>
    </div>
</div>
@endsection

@section('content')

<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Acquisition <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Acquisition Companies</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a class="btn add_button openDataSidebarForAddingAcquisition"><i class="fa fa-plus"></i> New
                    Acquisition</a>
                <h2>Acquisition List</h2>
            </div>
            <div style="min-height: 400px" id="LoaderAcquisitionSource">
                <img src="/images/loader.gif" width="30px" height="auto"
                    style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body" style="display: none">
            </div>
        </div>
    </div>
</div>
@endsection
