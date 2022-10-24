@extends('layouts.master')
@section('content')
<style>
    ._PR_filter {
        margin-top: -4px;
        width: 250px !important;
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
        width: 100px;
        height: 25px;
        box-shadow: none;
        border-color: #dddddd;
        padding: 0px 5px 0 8px;
    }

    .retailerTable .dataTable td,
    .retailerTable .dataTable th {
        padding: 11px 5px;
        vertical-align: middle;
        line-height: normal
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

    .action-ord {
        background-color: #f6f6f6;
        padding: 10px;
        margin-top: 15px;
        text-align: center;
    }

    .dataTable .red-bg {
        color: #fff !important;
        border-color: #f12300 !important
    }

    .dataTable .btn-default {
        width: 54px;
        height: 25px;
    }

    .w-auto {
        width: 200px !important;
        text-align: right
    }

    .btn-bulk {
        font-size: 12px;
        padding: 5px 16px;
        box-shadow: none
    }

    .custom-select-sm {
        font-size: 13px;
        width: 115px;
        height: 25px;
        line-height: 1;
        border-radius: 0
    }

    .date-f {
        width: 130px
    }

    .date-f::-webkit-calendar-picker-indicator {
        margin: 0
    }
</style>


<div id="blureEffct">
    <div class="overlay-blure"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-30">
                <div class="card PB-20">


                 
                    <input type="text" id="item_ids" value='{{json_encode($items)}}' hidden></input>
                    <div class="col-12 p-0">

                        <div class="header addPR-head mb-10">
                            <h2>Add <span> Opening Stock</span> </h2>
                        </div>
                        <!-- <div class="row m-0 pt-10">
                            <div class="col-md-3">
                                <div class="form-s2 select_type_of_stock">
                                    <select id="select_type" class="form-control formselect" placeholder="Select Type">
                                        <option value=0 selected>Select Type</option>
                                        <option value="opening_stock">Opening Stock</option>
                                        <option value="production">Production</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" id="select_batch_div" style="display: none;">
                                <div class="form-s2 select_batch">
                                    <select id="select_batch" class="form-control formselect" placeholder="Select Type">
                                        <option value="0">Select Batch</option>
                                        @foreach($batches as $batch)
                                        <option value="{{$batch->id}}">{{$batch->batch_id}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> -->

                        <div class="header addPR-head mb-10">
                            <h2>Add <span>Stock</span> </h2>
                        </div>
                        <div class="col-12 retailerTable">
                            <table class="table table-hover  nowrap" id="items_table" style="width:100%">
                                <form id="form_id">
                                    <thead>
                                        <tr>
                                            <th>ITEM SKU</th>
                                            <th>PRODUCT NAME</th>
                                            <th>Variant</th>
                                            <th>MFG. Date</th>
                                            <th>Expire Date</th>
                                            <th>Remarks</th>
                                            <th>Unit</th>
                                            <th>QTY.</th>
                                            <th>Pieces QTY.</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $variant)

                                        <tr>
                                            {{-- <input id="test_the_ids" type="hidden" value="{{}}"> --}}
                                            <input id="product-id-{{$variant->id}}" type="hidden" value="{{ $variant->product ? $variant->product->id : ''}}">
                                            <input id="product-name-{{$variant->id}}" type="hidden" value="{{ $variant->product ? $variant->product->name : ''}}">
                                            <input name="id" value="{{$variant->id}}" type="hidden">
                                            <input name="item" value="{{$variant}}" type="hidden">
                                            <td>{{ $variant->product_sku }}</td>
                                            <td>{{ $variant->product ? $variant->product->name : 'PRODUCT NOT FOUND' }}
                                            </td>
                                            <td>{{ $variant->name }}</td>
                                            <td><input id="manufacturing-date-{{$variant->id}}" type="date" class="form-control add-stock-input date-f manufacturing_date"></td>
                                            <td><input id="expiry-date-{{$variant->id}}" type="date" class="form-control add-stock-input date-f expiry_date" disabled></td>
                                            <td><input id="remarks-{{$variant->id}}" type="text" class="form-control add-stock-input"></td>
                                            <td>
                                                <select id="unit-of-item-{{$variant->id}}" onchange="unitOfItem(this , {{$variant->id}})" class="custom-select custom-select-sm">
                                                    <option selected="">Select Unit</option>
                                                    <option value="1">Piece</option>
                                                    @foreach ($variant_names as $key => $variants)

                                                    @if($variant['variant_id_3'] != null && $variant['variant_id_3'] == $key )
                                                    <option value="{{ $key }}">{{ $variants }}</option>
                                                    @endif
                                                    @if($variant['variant_id_2'] != null && $variant['variant_id_2'] == $key )
                                                    <option value="{{ $key }}">{{ $variants }}</option>
                                                    @endif
                                                    @if($variant['variant_id'] != null && $variant['variant_id'] == $key )
                                                    <option value="{{ $key }}">{{ $variants }}</option>
                                                    @endif

                                                    @endforeach
                                                    <option value="2">Carton</option>
                                                </select>





                                            </td>
                                            {{-- oninput="valueOfQuantity(this , {{$variant}})" --}}
                                            <td><input id="qty-{{$variant->id}}" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" title="Numbers only" class="form-control add-stock-input qtyValue" placeholder="Quantity" disabled></td>
                                            <td><input type="text" id="quantity-in-piece-{{$variant->id}}" class="form-control add-stock-input piece" placeholder="" disabled></td>
                                            <td><button id="add-stock-button-{{$variant->id}}" class="btn btn-default btn-line mb-0 add_stock_button" onclick="saveStockOfItem({{$variant->id}},{{$variant}})">Add</button></td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    </form>
                            </table>
                       



                        </div>

                    </div>



                    <div class="col-md-12">
                        <div class="action-ord">
                            <button type="button" id="save" class="btn btn-primary mr-2">Save All</button>

                            <button id="remove_all" type="button" class="btn btn btn-cancel mr-2">Remove All</button>

                            <button type="button" id="cancel" class="btn btn-cancel">Cancel</button>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>

</div>


@endsection