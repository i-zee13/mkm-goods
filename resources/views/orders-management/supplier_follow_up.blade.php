@extends('layouts.master')
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Supplier <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Supplier</span></a></li>
            <li><span>Follow Up</span></li>
        </ol>
    </div>
</div>

<div class="card top_border">
    <h2 class="_head03 p-20 border-0">Production Supplier: <strong class="blue-text"> {{$supplier_data->company_name}} </strong>
        <span class="float-right"><strong>Follow Up for:</strong> {{date('Y-m-d')}} </span></h2>

    <div class="col-12">
        <div class="Supplier-detail">
            <div class="row">
                <div class="col-8"><strong>POC Name:</strong> {{$supplier_data->company_poc ? $supplier_data->company_poc : 'NA'}} </div>
                <div class="col-4 text-right"><strong>Business Phone</strong> {{$supplier_data->business_phone ? $supplier_data->business_phone : 'NA'}}</div>
                <div class="col-6"><strong>POC Phone:</strong> {{($supplier_data->home_phone ? $supplier_data->home_phone : ($supplier_data->mobile_phone ? $supplier_data->mobile_phone : 'NA'))}}</div>
                <div class="col-6 text-right"><strong>Location:</strong> {{$supplier_data->address ? $supplier_data->address : 'NA'}}</div>
            </div>
        </div>
    </div>

    <div class="body">
        <h2 class="_head03 mb-20">Order List</h2>
        <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
            <thead>
                <tr>
                    <th>Order No</th>
                    <th>Order Date</th>
                    <th>Customer</th>
                    <th>Production Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($assignments as $supplier_assignment)
                    @if ($supplier_assignment->production_completed != 1)
                        <tr>
                            <td>{{$supplier_assignment->order_id}} </td>
                            <td>{{$supplier_assignment->order_date}}</td>
                            <td>{{$supplier_assignment->customer_name}}</td>
                            <td>NA</td>
                            <td><button id="{{ $supplier_assignment->order_id }}" class="btn btn-default mb-0 viewOrderSheet" data-toggle="modal"
                                    data-target=".orderSheetModal">Order Sheet</button>
                                <button class="btn btn-default mb-0 view_production_modal" data-toggle="modal" data-target=".add_production_modal" assign-id="{{$supplier_assignment->id}}" item-name="{{$supplier_assignment->item_name}}" product-name="{{$supplier_assignment->product_name}}" ass-qty="{{$supplier_assignment->item_quantity}}" producted-qty="{{$supplier_assignment->production_quantity}}" ass-emp="{{$supplier_assignment->assigned_employees}}" follow-date="{{$supplier_assignment->follow_up_date}}" del-date="{{$supplier_assignment->expected_delivery_date}}" batch="{{$supplier_assignment->batch}}">Follow Up</button>
                            </td>
                        </tr>
                    @endif
                @endforeach
               
            </tbody>
        </table>
    </div>


</div>
@endsection
