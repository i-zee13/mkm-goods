@extends('layouts.master')
@section('content')
<style>
    @page {
        width: auto
    }

    strong {
        font-weight: bold !important;
        ;
        font-family: 'Barlow', sans-serif !important;
    }

    .table-pdf {
        padding-top: 10px;
        margin-bottom: 15px;
        font-size: 11px;
        font-family: 'Barlow', sans-serif !important;
    }

    .table-pdf td,
    .table-pdf th {
        border: solid 1px #d2d2d2;
        font-size: 11px;
        text-align: left;
        ;
        font-family: 'Barlow', sans-serif !important;
    }

    .dispatch-order {
        padding: 0px !important;
    }

    .dispatch-order .container {
        max-width: 1220px;
    }

    .dispatch-order {
        padding: 0
    }

    ._PR_filter {
        margin-top: -4px;
        width: 190px !important;
    }

    ._PR_filter .form-s2 .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px !important;
        font-family: 'proximanova-light', sans-serif !important;
        font-size: 13px !important;
    }

    ._PR_filter .form-s2 .select2-container .select2-selection--single,
    ._PR_filter .form-s2 .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 31px !important;
    }

    #wrapper #content-wrapper {
        padding-left: 0 !important;
    }

    .container {
        max-width: 1280px;
    }

    .add-stock-input {
        font-size: 13px;
        width: 80px;
        height: 25px;
        box-shadow: none;
        border-color: #dddddd;
        padding: 0px 5px 0 8px;
    }

    .retailerTable .table thead th {
        font-size: 12px;
        padding: 5px 8px !important
    }

    .retailerTable .table td {
        font-size: 12px !important;
        padding: 5px 4px !important;
        vertical-align: middle;
        line-height: 1
    }

    .CP-name {
        letter-spacing: 1px;
    }

    .CP-name span {
        letter-spacing: 1px;
        display: block;
        margin-top: 4px;
    }

    .ProList-div .table img {
        margin-top: -2px;
        margin-bottom: -2px;
        margin-left: 4px;
    }

    ._selectProList .header .add_button {
        padding: 4px 8px 3px 8px;
        right: 15px;
    }

    .topstats {
        margin-top: 10px;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .topstats .gary-box {
        line-height: 1;
        background-color: #f9f9f9;
        border-bottom: solid 1px #d1d1d1;
        padding: 10px;
    }

    .topstats .gary-box span {
        font-family: 'Rationale', sans-serif;
        color: #040725;
        font-size: 18px;
        float: right;
        margin-top: -4px;
    }

    .min-w {
        min-width: 240px
    }

    .order-list {
        font-size: 12px;
        background: #fff;
        padding: 6px 10px;
        border: solid 1px #eaeaea;
        position: relative;
        transition: all 0.2s;
        transform: translateZ(0);
        -ms-transform: scale(0.97);
        -webkit-transform: scale(0.97);
        transform: scale(0.97);
        cursor: pointer;
    }

    .order-list.active {
        border-color: #040725;
    }

    .order-list:hover,
    .order-list.active {
        box-shadow: 0px 0px 22px 0px rgba(0, 0, 0, 0.18);
        -ms-transform: scale(1);
        -webkit-transform: scale(1);
        transform: scale(1);
        z-index: 3
    }

    .order-list span {
        display: block
    }

    .order-list span .fa {
        color: #b5b5b5
    }

    .order-list span.or-val {
        font-family: 'Rationale', sans-serif;
        font-size: 16.5px;
        line-height: 1;
        color: #040725
    }

    .order-list .ord-no {
        font-family: 'Poppins', sans-serif;
        line-height: 1;
        font-size: 35px;
        font-weight: 800;
        color: #ececec;
        position: absolute;
        right: 80px;
        top: 7px
    }

    .addPR-head {
        padding: 15px 15px 0px 20px !important;
        background: none !important
    }

    #orderList-id {
        flex: 0 0 300px;
        max-width: 300px;
        width: 300px;
    }

    #orderList-id2 {
        flex: 0 0 300px;
        max-width: 300px;
        width: 300px;
    }

    .value_input {
        padding: 2px;
        margin: 0 !important;
        font-size: 12px;
        box-shadow: none;
        height: 22px;
        width: 52px;
        border: solid 1px #e2e6ea;
    }

    .total-valu-div {
        width: 280px;
        font-size: 13px;
        padding-left: 20px;
        padding-right: 20px;
        margin-left: auto;
        margin-right: 0;
        padding-top: 5px;
        background-color: #f7f7f7;
        border: solid 1px #ececec
    }

    .total-valu-div .row {
        border-bottom: solid 1px #e8e6e6
    }

    .total-valu-div .row .col-6 {
        padding: 2px;
        line-height: 1.5;
        font-family: proximanova-semibold, sans-serif !important;
    }

    .total-valu-div span {
        font-family: 'Rationale', sans-serif;
        line-height: 1.1;
        font-size: 18px;
        text-align: right;
        display: block
    }

    .total-a-val {
        font-size: 17px !important;
        color: #040725;
    }

    .ProListHeight {
        height: calc(100vh - 200px)
    }

    .rightHeight {
        height: calc(100vh - 249px);
        overflow-y: auto;
    }

    .addpr {
        padding: 4px 8px;
        font-size: 12px;
        top: 11px;
        right: 15px;
    }

    .itemQTY {
        font-size: 12px;
        width: 70px;
        padding: 0px 5px;
        border: solid 1px #e6e6e6
    }

    .itemIMG {
        width: 32px;
        height: 32px;
        border: solid 1px #e5e5e5;
        margin-top: -5px;
        margin-bottom: -5px;
        margin-right: 5px;
        float: left
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
        font-size: 14px;
        letter-spacing: 1px;
        line-height: 16px
    }

    .ProListDiv .PrList_img {
        width: 35px;
        height: 35px;
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
        background: linear-gradient(90deg, #1e54d3 0%, #040725 100%);
        color: #fff;
        text-align: center;
        margin: 0;
        line-height: 1;
        min-width: 74px;
        letter-spacing: 1px;
        float: right;
        border: none !important
    }

    .AddDetailPR {
        padding: 25px;
        font-size: 14px
    }

    .AddDetailPR .form-control {
        height: 32px;
        border: solid 1px #dedede;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
        padding: 0px 10px;
        font-size: 13px;
        letter-spacing: 1px;
    }

    .AddDetailPR select {
        border-radius: 0;
        padding: 0px 10px;
        height: 32px;
        border: solid 1px #dedede;
        font-size: 14px
    }

    .se_cus-type .form-control {
        border: 1px solid #eeeeee;
        background-color: #fff;
    }

    .daily-operations .nav_M a,
    .daily-operations .nav_M .nav-link.active {
        padding-top: 15px;
    }

    .cash-report {
        background-color: #f8f8f8;
        min-height: calc(100vh - 210px);
    }

    .cash-report .header {
        background: linear-gradient(0deg, #f8f8f8 0%, #f8f8f8 50%);
        padding: 15px 20px;
    }

    .cash-report .report_value {
        background-color: #fff;
        font-size: 13px;
        position: relative;
        padding: 10px 10px;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        margin-top: 5px;
        -webkit-box-shadow: 0 2px 8px 0 rgba(79, 79, 79, .1);
        -moz-box-shadow: 0 2px 8px 0 rgba(79, 79, 79, .1);
        box-shadow: 0 2px 8px 0 rgba(79, 79, 79, .1);
        line-height: 1
    }

    .cash-report .report_value span {
        font-family: 'Rationale', sans-serif;
        line-height: 1;
        font-size: 18px;
        float: right;
        margin-top: -2px
    }

    .totalcash span {
        font-size: 20px !important;
        color: #040725
    }

    .cash-report .value_input {
        float: right;
        width: 85px;
    }

    .addsalesman {
        font-size: 11px;
        width: 100%;
        line-height: 1;
        margin-top: 5px;
    }

    .return-btn {
        line-height: 1;
        margin-top: 10px;
    }

    .add-expense {
        font-size: 13px;
        padding: 2px 10px;
        position: absolute;
        right: 0;
    }

    .red-bg {
        border: solid 1px #f12300
    }

    .act-btn-print {
        margin: 0px 0 0 0
    }

    .act-btn-print .col-4 {
        padding: 5px;
    }

    .print-btn {
        font-size: 14px;
        text-align: center;
        background: linear-gradient(90deg, #fff 0%, #fff 100%);
        color: #282828;
        border: solid 1px #040725;
        box-shadow: none;
        padding: 10px 14px;
        white-space: normal;
        width: 100%;
        min-height: 85px;
        line-height: 16px;
    }

    .print-btn:hover {
        background: linear-gradient(90deg, #1e54d3 0%, #040725 100%);
        color: #fff
    }

    .print-btn .fa {
        display: block;
        font-size: 16px;
        padding: 5px;
        margin-bottom: 5px;
    }

    .select-checkmark .salevalue {
        text-align: right;
        margin: auto;
        vertical-align: middle
    }

    .select-checkmark .ord-no {
        top: 14px;
        font-size: 45px
    }

    .select-checkmark .custom-control {
        text-align: right;
        margin-top: -15px;
        margin-right: -10px;
        margin-bottom: 13px;
    }

    .select-all-op {
        position: absolute;
        top: -3px;
        right: 15px;
    }

    .select-all-op .custom-control-label {
        font-size: 12px;
        line-height: 2.2
    }

    .header-tabs {
        box-shadow: none;
        border-bottom: solid 1px #e2e2e2
    }

    .header-tabs .nav-tabs .nav-link {
        border-bottom: solid 1px #e2e2e2
    }

    .header-tabs .nav-tabs .nav-item.show .nav-link,
    .header-tabs .nav-tabs .nav-link,
    .header-tabs .nav-tabs .nav-link.active {
        padding: 10px 26px;
        height: 42px;
    }

    .header-tabs .add_button {
        letter-spacing: 1px;
        padding: 4px 15px;
        right: 15px;
        box-shadow: none
    }

    .dc-table thead th {
        vertical-align: middle;
        padding: 4px 5px;
        border: solid 1px #fff !important
    }

    .dc-table td {
        padding: 5px 8px !important;
    }

    .wz-icon .fa {
        color: #fff;
    }

    .addpr {
        padding: 4px 8px;
        font-size: 12px;
        top: 11px;
        right: 15px;
        cursor: pointer;
    }

    .print-hidden {
        display: none
    }

    .print-show {
        display: inline-block;
        color: #fff !important
    }

    .th-boarder thead th,
    .retailerTable .table thead th {
        border: solid 1px #fff !important;
        /*
    vertical-align: middle;
    padding: 2px 5px!important;
*/
    }

    .input-border-w {
        border: solid 1px #ddd;
        width: 50px
    }


    .addReturn {
        right: 128px;
        box-shadow: none
    }

    .daily-operations .tab-content {
        padding-bottom: 10px
    }

    .bottom-act-btn {
        text-align: right;
        padding-top: 15px;
        padding-bottom: 15px
    }

    .bottom-act-btn .btn {
        letter-spacing: 1px;
        font-size: 12px;
        padding: 4px 12px;
        box-shadow: none
    }

    .execFooter {
        background: #F6F6F6;
        padding-top: 10px;
        padding-bottom: 10px;
        margin-top: 5px;
    }

    .Product-Filter {
        box-shadow: none;
        margin: 0;
        padding: 10px
    }

    .cash-report .value_input {
        float: right;
        width: 95px;
    }

    ._selectProList .header {
        padding: 15px 15px !important;
    }

    /*
#product-cl-sec{
 width: 750px;
}
*/
    .tab-content>.active {
        display: block !important;
    }

    .dataTable td,
    .dataTable th,
    .modal-body table th,
    .modal-body table td {
        padding: 5px
    }

    .dataTable .form-s2 .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 12px !important;
        letter-spacing: normal;
        line-height: 24px !important;
        height: 26px !important
    }

    .dataTable .form-s2 .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px !important
    }

    .dataTable .form-s2 .select2-container .select2-selection--single {
        height: 26px !important
    }

    .packeging-table td {
        font-size: 12px !important;
        padding: 5px !important;
    }

    .packeging-table th {
        padding: 5px !important;
        letter-spacing: normal !important;
        font-family: proximanova-semibold, sans-serif !important;
    }
</style>
<input id="customer_stock" type="text" hidden value="{{json_encode($customer_stock)}}">
<input id="company_stock" type="text" hidden value="{{json_encode($company_stock)}}">
<input id="order_content" type="text" hidden value="{{json_encode($order_content)}}">
<input id="order_id" type="text" hidden value="{{$order_id}}">
<input id="customer_id" type="text" hidden value="{{$customer_id}}">
<div class="modal fade" id="add-order-new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content  top_border">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Order<span></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <div class="row m-0 PT-15 PB-15">
                    <div class="col-4 pr-0">
                        <div class="form-s2">
                            <select class="form-control formselect" placeholder="Select Order Booker" style="width: 100%!important">
                                <option>Select Order Booker</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-4 pr-0">
                        <div class="form-s2">
                            <select class="form-control formselect" placeholder="Select Route" style="width: 100%!important">
                                <option>Select Route</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-s2">
                            <select class="form-control formselect" placeholder="Select Retialer" style="width: 100%!important">
                                <option>Select Retialer</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0" style="background-color: #f6f6f6">
                <button type="submit" class="btn btn-primary">Add Order</button>
                <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal-del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content top-borderRed">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete <span></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <p>Are you sure you want to delete?</p>
                </div>

            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary">Yes</button>
                <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="QuantityAndUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content top_border">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Detail <span></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body AddDetailPR">
                <div class="row">
                    <div class="col-md-4 pt-7 mb-15">Add Quantity*:</div>
                    <div class="col-md-8 mb-15">
                        <input type="number" class="form-control" placeholder="" style="font-size:13px">
                    </div>
                    <div class="col-md-4 pt-7 mb-15">Select Unit*:</div>
                    <div class="col-md-8 mb-15">
                        <select class="custom-select custom-select-sm" id="">
                            <option disabled selected value="0">Select Unit</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="modal-footer border-0" style="background-color: #f6f6f6">
                <button type="button" class="btn btn-primary">Confirm</button>
                <button type="button" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>




<div id="wrapper">

    <div id="content-wrapper">
        <div id="blureEffct">
            <div class="overlay-blure"></div>

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card daily-operations">

                            <ul class="nav nav-pills nav_M mb-3 tabs" id="myTab" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false"><span>Customer Stock</span>
                                        <span class="wz-icon"><i class="fa fa-user"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-load-tab" data-toggle="pill" href="#pills-load" role="tab" aria-controls="pills-load" aria-selected="false"><span>Company Stock</span>
                                        <span class="wz-icon"><i class="fa fa-cube"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-supplier-tab" data-toggle="pill" href="#pills-supplier" role="tab" aria-controls="pills-supplier" aria-selected="false"><span>Assign Supplier</span>
                                        <span class="wz-icon"><i class="fa fa-check"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-packeging" data-toggle="pill" href="#pills-packeging-tab" role="tab" aria-controls="pills-packeging" aria-selected="false"><span>Packaging Material</span>
                                        <span class="wz-icon"><i class="fa fa-gift"></i></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-final-tab" data-toggle="pill" href="#pills-final" role="tab" aria-controls="pills-final" aria-selected="false"><span>Order Sheet</span>
                                        <span class="wz-icon"><i class="fa fa-table"></i></span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane p-0 PT-20 tab_M fade show active" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

                                    <div class="col-12 PT-15">
                                        <table class="table table-hover nowrap th-boarder" id="example" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>SKU</th>
                                                    <th style="width: 430px">Product Name</th>
                                                    <th>Order QTY.</th>
                                                    <th>Batch ID</th>
                                                    <th>Available QTY.</th>
                                                    <th>Expiry Date</th>
                                                    <th>Assign QTY.</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($customer_stock as $stock)
                                                <tr>
                                                    <td>{{$stock->item->custom_id}}</td>
                                                    <td><strong>{{$stock->item->description}}</strong><br>{{$stock->item->name}}</td>
                                                    <td><span id="ordered-qty-customer-{{$stock->id}}">{{$stock->ordered_qty}}</span></td>
                                                    <td>{{$stock->batch->batch_id}}</td>
                                                    <td><span id="available-qty-{{$stock->id}}">{{$stock->balance}}</span></td>
                                                    <td>{{$stock->expiry_date}}</td>
                                                    <td><input type="text" id="assigned-aty-{{$stock->id}}" class="form-control value_input w-100 customer_stock_assignment" placeholder="0"></td>
                                                    <td><button onclick="transferCusotmerStock({{$stock->id}})" id="assignment-{{$stock->id}}" class="btn btn-default btn-line">Assign</button></td>
                                                </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="tab-pane tab_M p-0 PT-15 fade" id="pills-load" role="tabpanel" aria-labelledby="pills-load-tab">

                                    <div class="col-12 PT-15">
                                        <table class="table table-hover nowrap th-boarder" id="example2" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>SKU</th>
                                                    <th style="width: 430px">Product Name</th>
                                                    <th>Order QTY.</th>
                                                    <th>Assigned QTY.</th>
                                                    <th>Required QTY.</th>
                                                    <th>Batch ID</th>
                                                    <th>Available QTY.</th>
                                                    <th>Expiry Date</th>
                                                    <th>Assign QTY.</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($company_stock as $c_stock)
                                                <tr>
                                                    <td>{{$c_stock->item->custom_id}}</td>
                                                    <td><strong>{{$c_stock->item->description}}</strong><br>{{$c_stock->item->name}}</td>
                                                    <td>{{$c_stock->ordered_qty}}</td>
                                                    <td><span id="assigned-from-customer-{{$c_stock->item_id}}"></span></td>
                                                    <td><span id="required-qty-{{$c_stock->item_id}}"></span></td>
                                                    <td>{{$c_stock->batch->batch_id}}</td>
                                                    <td><span id="available-company-qty-{{$c_stock->id}}">{{$c_stock->balance}}</span></td>
                                                    <td>{{$c_stock->expiry_date}}</td>
                                                    <td><input type="text" id="assigned-company-aty-{{$c_stock->id}}" class="form-control value_input w-100 company_stock_assignment" placeholder="0"></td>
                                                    <td><button onclick="transferCompanyStock({{$c_stock->id}})" id="assignment-company-{{$c_stock->id}}" class="btn btn-default btn-line">Assign</button></td>
                                                </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="tab-pane tab_M p-0 PT-15 fade" id="pills-supplier" role="tabpanel" aria-labelledby="pills-supplier-tab">
                                    <div class="col-12 PT-15">
                                        <table class="table table-hover nowrap th-boarder" id="example3" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>SKU</th>
                                                    <th style="width: 300px">Product Name</th>
                                                    <th>Order QTY.</th>
                                                    <th>Assigned QTY.</th>
                                                    <th>Required QTY.</th>
                                                    <th>Assign QTY.</th>
                                                    <th style="width: 120px">Assign Supplier</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($order_content as $item)
                                                <tr>
                                                    <td>{{$item->item->custom_id}}</td>
                                                    <td><strong>{{$item->item->description}}</strong><br>{{$item->item->name}}</td>
                                                    <td>{{$item->qty}}</td>
                                                    <td><span id="supplier-assignment-assigned-qty-{{$item->item_id}}"></span></td>
                                                    <td><span id="supplier-assignment-required-qty-{{$item->item_id}}"></span></td>
                                                    <td><input type="text" class="form-control value_input w-100 assign-to-supplier" id="supplier-assign-{{$item->item_id}}" style="height:26px" placeholder="0"></td>
                                                    <td>
                                                        <div class="form-s2">
                                                            <select class="form-control formselect" placeholder="Select Supplier" id="suppliers-for-assignment-{{$item->item_id}}" style="width:100%">
                                                                <option value="0" selected>Select Supplier</option>
                                                                @forelse($suppliers as $supplier)
                                                                <option value="{{$supplier->id}}">{{$supplier->company_name}}</option>
                                                                @empty
                                                                <option value="0" selected>No Supplier</option>
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td><button onclick="assignToSupplier({{$item->item_id}})" id="supplier-assignment-{{$item->item_id}}" class="btn btn-default btn-line">Assign</button></td>
                                                </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane tab_M p-0 PT-15 fade" id="pills-packeging-tab" role="tabpanel" aria-labelledby="pills-packeging">
                                    <div class="col-12 PT-15">
                                        <table class="table table-hover nowrap th-boarder packeging-table" id="" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" vertical-align:middle style="vertical-align: middle !important; text-align:center">SKU</th>
                                                    <th rowspan="2" vertical-align:middle style="vertical-align: middle !important; text-align:center">Product Name</th>
                                                    <th colspan="4" style="text-align: center;">Psckiging Material Stock</th>
                                                    <th rowspan="2" vertical-align:middle style="vertical-align: middle !important; text-align:center">AVG PCS/PKT</th>
                                                    <th rowspan="2" vertical-align:middle style="vertical-align: middle !important; text-align:center">BATCHES TO MAKE</th>
                                                    <th rowspan="2" vertical-align:middle style="vertical-align: middle !important; text-align:center; width:150px; font-size:11px">REMARKS</th>
                                                <tr>
                                                    <th style="font-size: 11px !important; letter-spacing: normal !important">CTNS STOCK</th>
                                                    <th style="font-size: 11px !important; letter-spacing: normal !important">BAG/BOX STOCK</th>
                                                    <th style="font-size: 11px !important; letter-spacing: normal !important">STICKER TRAY STOCK</th>
                                                    <th style="font-size: 11px !important; letter-spacing: normal !important">PPB STOCK</th>
                                                </tr>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($order_content as $item)
                                                <tr>
                                                    <td>{{$item->item->custom_id}}</td>
                                                    <td><strong>{{$item->item->description}}</strong><br>{{$item->item->name}}</td>
                                                    <td><input type="number" id="ctns-stock-{{$item->item_id}}" class="form-control value_input w-100 assign-to-supplier" id="supplier-assign-" style="height:26px" placeholder="0"></td>
                                                    <td><input type="number" id="bag-box-{{$item->item_id}}" class="form-control value_input w-100 assign-to-supplier" id="supplier-assign-" style="height:26px" placeholder="0"></td>
                                                    <td><input type="number" id="sticker-tray-stock-{{$item->item_id}}" class="form-control value_input w-100 assign-to-supplier" id="supplier-assign-" style="height:26px" placeholder="0"></td>
                                                    <td><input type="number" id="ppb-stock-{{$item->item_id}}" class="form-control value_input w-100 assign-to-supplier" id="supplier-assign-" style="height:26px" placeholder="0"></td>
                                                    <td><input type="number" id="avg-pieces-pkt-{{$item->item_id}}" class="form-control value_input w-100 assign-to-supplier" id="supplier-assign-" style="height:26px" placeholder="0"></td>
                                                    <td><input type="number" id="bathes-to-make-stock-{{$item->item_id}}" class="form-control value_input w-100 assign-to-supplier" id="supplier-assign-" style="height:26px" placeholder="0"></td>
                                                    <td><textarea id="remarks-{{$item->item_id}}" class="form-control value_input w-100" name="" rows="1">Add Remarks</textarea></td>
                                                </tr>
                                                @empty
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane tab_M p-0 PT-15 fade" id="pills-final" role="tabpanel" aria-labelledby="pills-final-tab">
                                    <div class="col-12 PT-15">
                                        <table class="table-pdf" id="order_sheet_table" width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">SKU</th>
                                                    <th rowspan="2">Product's Name</th>
                                                    <th colspan="2" style="text-align:center">Order QTY.</th>
                                                    <th colspan="4" style="text-align:center">Finish Goods Stock</th>
                                                    <th colspan="2" style="text-align:center">Required Stock </th>

                                                </tr>
                                                <tr>
                                                    <th style="text-align:center">CTN</th>
                                                    <th style="text-align:center">PKT/BOX</th>

                                                    <th style="text-align:center">Batch ID</th>
                                                    <th style="text-align:center">CTN</th>
                                                    <th style="text-align:center">PKT/BOX</th>
                                                    <th style="text-align:center">Expiry</th>

                                                    <th style="text-align:center">CTN</th>
                                                    <th style="text-align:center">PKT/BOX</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               

                                            </tbody>


                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12 pl-10 pr-10 text-center">
                                <div class="execFooter">
                                    <button type="submit" class="prevtab btn btn-primary m-0 mr-2">Previous</button>
                                    <button type="button" class="nexttab btn btn-primary m-0 nexttab btnNext">Next</button>
                                    <a id="saveOrderSheet" onclick="saveOrderSheet()" class="btn btn-primary m-0 print-hidden">Save&Print Order Sheet</a>
                                </div>
                            </div>




                        </div>
                    </div>

                </div>

            </div>



        </div>
    </div>
</div>
@endsection