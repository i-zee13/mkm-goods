@extends('layouts.master')
@section('content')
<style>
    .itemQTY {
        font-size: 12px;
        width: 90px;
        padding: 3px 5px;
        border: solid 1px #e6e6e6
    }

    .add-product-line:HOVER i {
        color: #fff !important
    }

    .form-s2 .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
    }

    .form-s2 .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 28px;
        width: 25px;
    }

    .form-s2 .select2-container .select2-selection--single {
        height: 28px !important;
    }

    .table td,
    .table th {
        padding: 0.5rem;
    }
</style>
<div class="container">
    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Purchase <span> Order</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Order</span></a></li>
                <li><span>Create</span></li>
            </ol>
        </div>
    </div>
    <form action="/store_purchase_order" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12 mb-30">
                <div class="card mb-30">
                    <div class="header">
                        <h2>Create <span> Order</span></h2>
                    </div>
                    <div class="body PT-15">
                        <div id="floating-label">
                            <div class="form-wrap p-0">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="font11 mb-5">Select Date</label>
                                        <input type="text" readonly value="{{$purchase_order->purchase_date}}"  name="date" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="font11 mb-5">Order Type</label>
                                        <select disabled class="custom-select custom-select-sm" name="order_type">
                                            @if($purchase_order->order_type == 1)
                                            <option selected value="1">import</option>
                                            @endif
                                            @if($purchase_order->order_type == 2)
                                            <option selected value="2">Local Purchase</option>
                                            @endif
                                           
                                           
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="font11 mb-5">G.D. Challan #</label>
                                        <input type="text" name="gd_challan" readonly value="{{$purchase_order->gd_challan_number}}" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-hover dt-responsive nowrap" id="purchase_order" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Ingredient Name</th>
                                                    <th>Value</th>
                                                   
                                                </tr>
                                            </thead>
                                            <tfoot style=" background:linear-gradient(0deg, #f6f6f6 0%, #f6f6f6 100%); font-size: 14px">
                                                <tr>
                                                    <th style="text-align: right">Total USD.</th>
                                                    <th><input style="background-color: transparent; border:none ; font-weight:bold" type="number" value="{{$purchase_order->ttl_value}}" id="total_value" readonly></th>
                                                    <th></th>
                                                </tr>

                                            </tfoot>
                                            <tbody>
                                                @foreach($purchase_order_content as $content)
                                                <tr>
                                                    <td>
                                                        <div class="form-s2">
                                                        <input placeholder="0" class="itemQTY" value="{{$content->item_name}}" readonly>
                                                        </div>
                                                    </td>
                                                    <td><input placeholder="0" class="itemQTY" value="{{$content->item_value}}" readonly></td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>

                                        <div class="col-md-12 p-0">
                                            <div style="background-color: #f6f6f6; padding: 15px; margin-top: 15px; margin-bottom: 0px; text-align: center; margin-bottom: 1px">

                                                <a href="/purchase-order" class="btn btn-cancel mr-2">Back</a>
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
@endsection