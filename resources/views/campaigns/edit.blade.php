@extends('layouts.master')

@section('content')
<style>
    .pt-9 {
        padding-top: 9px;
    }

    .grayTopborder {
        border-top: solid 1px #e5e5e5
    }

    .assCatalogue-radio {
        margin: 5px;
        margin-bottom: 15px;
        background-color: #f6f6f6;
    }

    .RrulesHeading {
        padding: 0px 20px 10px 20px !important;
        background: transparent !important;
        border-bottom: solid 1px #e5e5e5
    }

    .pt-3 {
        padding-top: 3px !important;
    }

    .red-bg {
        border: solid 1px #f12300 !important
    }

    .retailerTable {
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .retailerTable .table thead th {
        border-bottom: solid 1px #001e35 !important;
        background-color: #fff !important;
    }

    .retailerTable {
        padding: 0;
        margin: 0
    }

    .retailerTable tr {
        border-bottom: solid 1px #eeeeee
    }

    .retailerTable td {
        padding-bottom: 7px;
        padding-top: 7px
    }

    .add-pr-btn {
        padding: 6px 18px;
        letter-spacing: 1px;
        font-size: 13px;
        line-height: 1;
        float: right;
        margin-right: -15px;
    }

    .productSearch {
        position: relative;
    }

    .productSearch input {
        height: 32px;
        border: solid 1px #eae9e9;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
        padding-left: 30px;
        font-size: 13px;
        letter-spacing: 1px;
    }

    .productSearch .fa {
        position: absolute;
        top: 8px;
        left: 8px;
        color: #b5b5b5;
    }

    .AddProductTable {
        padding: 0;
        margin: 0
    }

    .AddProductTable tr {
        border-bottom: solid 1px #eeeeee
    }

    .AddProductTable td {
        padding-bottom: 7px;
        padding-top: 7px
    }

    .ProListDiv {
        padding: 0;
        display: table;
    }

    .ProListDiv .PR_Name {
        display: table-cell;
        vertical-align: middle;
        font-size: 13px;
        letter-spacing: 1px;
        line-height: 18px
    }

    .ProListDiv .PrList_img {
        width: 33px;
        height: 33px;
        margin-right: 8px;
        border: solid 1px #e0e0e0
    }

    .AddProductTable .btn-default {
        padding: 5px 8px;
        font-size: 13px;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
        -khtml-border-radius: 0;
        background: linear-gradient(90deg, #001e35 0%, #001e35 100%);
        color: #fff;
        text-align: center;
        margin: 0;
        line-height: 1;
        min-width: 74px;
        letter-spacing: 1px;
        float: right;
        border: none !important
    }

    .se_cus-type .form-control {
        border: 1px solid #eeeeee;
        background-color: #fff;
    }

    /* .retailerTable .table .btn-line:HOVER {
        border-color: #f12300 !important;
        color: #fff;
        background: linear-gradient(90deg, #f12300 0%, #f12300 100%);
    } */
</style>
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Campaign <span> Management</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Campaign </span></a></li>
            <li><span>Create</span></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-30">
        <form id="form">
                @csrf
               
        <input type="hidden" class="hidden_campaign_id"  name="hidden_campaign_id" value="{{$campaign->id}}">

        <div class="card PB-20">

            <div class="header">
                <h2>Create <span> Campaign </span></h2>
            </div>
            
            <div class="row m-0">
                <div class="form-wrap pb-0 PT-10">


                    <div class="row m-0">
                        <div class="col pr-0">
                            <label class="font12 mb-5">Campaign Type </label>
                            <div class="form-s2">
                                <select class="form-control formselect required" placeholder="select Scheme Type" style="width: 100%" name="campaign_type">
                                    <option value="1" {{$campaign->campaign_type == 1 ? 'selected' : ''}} >Discount on Price</option>
                                    <!-- <option value="2">Specific Product/Category/Collection</option>
                                        <option value="3">Specific Product Category</option>
                                        <option value="4">Bundle Offer </option>
                                        <option value="5">Free Product</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col pr-0">
                            <label class="font12 mb-5">Discount Type</label>
                            <div class="form-s2">
                                <select class="form-control formselect discount_type required"  placeholder="select Scheme Type" name="discount_type" style="width: 100%">
                                    <option value="1" {{$campaign->discount_type == 1 ? 'selected' : ''}}>Value</option>
                                    <option value="2" {{$campaign->discount_type == 2 ? 'selected' : ''}}>Percentage</option>
                                </select>
                            </div>
                        </div>
                        <div class="col pr-0">
                            <div class="form-group">
                                <label class="control-label mb-5">Disscount *</label>
                                <input type="text" id="discount" class="form-control required only_numerics " name="campaign_discount" placeholder="" value="{{$campaign->campaign_discount}}">
                            </div>
                        </div>
                        <div class="col pr-0">
                            <div class="form-group">
                                <label class="control-label mb-5">Campaign Title *</label>
                                <input type="text" id="" class="form-control required" name="campaign_title"  placeholder="" value="{{$campaign->campaign_title}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label mb-5">Label Title *</label>
                                <input type="text" id="Title" class="form-control required" name="label_title" placeholder="" value="{{$campaign->label_title}}">
                            </div>
                        </div>
                      
                    </div>
                    <div class="header RrulesHeading mt-15">
                        <h2>Date <span>Details</span></h2>
                    </div>
                    <div class="row form-wrap p-0">

                        <div class="col-3">
                            <div class="form-group" style="height: auto">
                                <label class="control-label mb-5">Start Date</label>
                                <input type="text" class="form-control datepicker required" placeholder="" name="start_date" value="{{$campaign->start_date}}">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group" style="height: auto">
                                <label class="control-label mb-5">End Date</label>
                                <input type="text" class="form-control datepicker required" placeholder="" name="end_date" value="{{$campaign->end_date}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row retailerTable">

                <div class="col-12">
                    <div class="header RrulesHeading mt-10 mb-20" style="margin-left:-15px">
                        <h2>Add <span>Specific Courses</span></h2>
                    </div>
                    <div style="min-height: 400px" class="loader">
                    <img src="{{asset('images/loader.gif')}}" width="30px" height="auto"
                        style="position: absolute; left: 50%; top: 45%;">
                </div>
                    <div class="body course_list">
                    
                    </div>
                    <!-- <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
                        <thead>
                            <tr>
                                <th>Course Title</th>
                                <th>Course Code</th>
                                <th>Batch Code</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campaign_courses as $course)
                          
                            <tr>
                                <td>
                                    <div class="ProListDiv"><img class="PrList_img" src="{{$course->course_thumbnail ? '/storage/'.$course->course_thumbnail : 'images/product-img-005.jpg'}}" alt="">
                                        <div class="PR_Name">{{Str::limit($course->course_title,50)}}</div>
                                    </div>
                                </td>
                                <td><div class="PR_Name">{{$course->course_code}}</div></td>
                                <td><div class="PR_Name">{{$course->batch_code}}</div></td>
                                <td><button type="button" id="add-btn" class="btn btn-default btn-line mb-0 add-btn" course-id="{{$course->id}}"  batch-id="{{$course->batch_id}}" status="{{$course->status}}">Add</button></td>
                            </tr>
                            @endforeach
                </tbody>
                </table> -->

            </div>

        </div>

        <div class="col-md-12 text-right PT-15">
            <button type="submit" class="btn btn-primary mr-2" id="save-campaign">Save</button>
            <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
        </div>
    </div>
    
</form>
</div>
</div>
@endsection
