@extends('layouts.master')
@section('css')
@endsection
@section('content')

    <style>
        .targetQty {
            font-size: 13px;
            height: 26px;
            box-shadow: none;
            width: 110px;
            padding-left: 10px;
            padding-right: 10px;
            border-color: #e9e9e9;
        }

        .dataTable td,
        .modal-body table td {
            padding: 3px 5px;
            vertical-align: middle;
        }

        .dataTable td .btn-default {
            margin-bottom: 0
        }

    </style>


    <input type="hidden" value="{{$id}}" id="customer_id">
    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Customer: <span>Pricing</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Product</span></a></li>
                <li><span>Set Price </span></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-30">

            <div class="card PB-20">

                <div class="header" style="padding-top:13px;padding-bottom:13px;">
                    <div class="row">
                        <div class="col-12">
                            <h2>Set <span>Price</span></h2>
                        </div>

                    </div>
                </div>

                <div>


                    <form id="products_with_prices">
                    <div class="col-12 PT-10 PB-10">
                        <table class="table table-hover nowrap line-height" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Product Name</th>
                                    <th>Item Name</th>
                                    <th>Standard Price</th>
                                    <th>Packing Unit</th>
                                    <th>Custom Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $key => $item)
                                    {{-- @dd($item->product_sku) --}}
                                    <tr>
                                        <td>{{ $item->product_sku }}<input type="hidden" name="array_key[{{$key}}]" value="1"></td>
                                        <td>{{ $item->product ? $item->product->name : 'no product' }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->variant_unit_price }} </td>
                                       
                                        @if(in_array($item->id,$fixedPricesForCustomerIds))
                                        <td>{{$item->packingVariant ? $item->packingVariant->unit_name:''}}</td><td><input type="text" id="item-{{$item->id}}" class="form-control targetQty" placeholder="{{ number_format($itemsCustomerPrices[$item->id], 2, '.', ',')}}"></td><td><button onclick="setPriceForCustomer({{$item->id}})" id="btn-{{$item->id}}"class="btn btn-default mb-0">Update</button></td>
                                        @else
                                        <td>{{$item->packingVariant ? $item->packingVariant->unit_name:''}}</td><td><input type="text" id="item-{{$item->id}}" class="form-control targetQty" placeholder=""></td><td><button onclick="setPriceForCustomer({{$item->id}})" id="btn-{{$item->id}}"class="btn btn-default mb-0">Set</button></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>


                </div>






                <div class="col-md-12 PT-20 text-right">
                    <button type="button" onclick="redirectToHome()" class="btn btn-primary mr-2">Save</button>
                    <button type="button" onclick="redirect()" class="btn btn-cancel">Cancel</button>
                </div>


            </div>



        </div>


    </div>
    </div>









@endsection














</body>


