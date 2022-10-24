@extends('layouts.master')
@section('content')
<div class="row mt-2">
    <div class="col-md-6">
        <h2 class="_head01 float-left">Order <span>Detail</span></h2>
    </div>
    <div class="col-md-3 font14 text-right"><strong>Order Date:</strong>
        {{date("d/m/Y", strtotime($order_core->created_at))}}</div>
    <div class="col-md-3 font14 text-right"><strong>Complete Order Date:</strong>
        {{$order_core->completed_at ? date("d/m/Y", strtotime($order_core->completed_at)) : 'NA'}}</div>
</div>
<div class="row mt-2">
    <div class="col-md-12">
        <div class="card p-20 top_border mb-30" style="border-top: solid 3px #040725;">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col _col-title">Company Name:
                            <span><strong>{{$order_core->customer_name}}</strong></span></div>
                        <div class="col _col-title" style="max-width:150px">PO NO. <span>{{$order_core->po_num}}</span>
                        </div>
                        <div class="col _col-title" style="max-width:150px">Order Type.
                            <span>{{$order_core->order_type}}</span>
                        </div>
                        <div class="col _col-title" style="max-width:150px">Invoice NO.
                            <span>{{$order_core->eform_num}}</span></div>
                        <div class="col-auto _order-price"><span>Order Amount
                                ({{$order_core->currency_symbol}}.)</span>{{$order_core->currency_symbol}}.
                            {{number_format($order_core->total_amount)}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 tableOL">
                            <table class="table table-hover dt-responsive mb-0" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Item </th>
                                        <th>QTY.</th>
                                        <th>Weight / Unit</th>
                                        <th>Weight / Carton</th>
                                        <th>CBM</th>
                                        <th>Total CBM</th>
                                        <th>Unit Price</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order_content as $data)
                                    <tr>
                                        <td>{{$data->product_name}}</td>
                                        <td>{{$data->item_name}}</td>
                                        <td>{{$data->qty}}</td>
                                        <td>{{$data->weight_per_unit}} Grams</td>
                                        <td>{{$data->weight_per_ctn}} KG(s)</td>
                                        <td>{{$data->cbm}}</td>
                                        <td>{{$data->total_cbm}}</td>
                                        <td>{{$order_core->currency_symbol.'. '.$data->unit_price}}</td>
                                        <td>{{$order_core->currency_symbol.'. '.number_format($data->qty*$data->unit_price)}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-30">
        <div class="card OrderDL">
            <div class="header _pillsTabs">
                <h2>Supplier <span> List</span></h2>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive mb-0" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Supplier Name</th>
                            <th>Product Name</th>
                            <th>Item </th>
                            <th>QTY.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assigned_suppliers as $value)
                        <tr>
                            <td>{{$value->supplier}}</td>
                            <td>{{$value->product_name}}</td>
                            <td>{{$value->item_name}}</td>
                            <td>{{$value->item_quantity}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-30">
        <div class="card OrderDL">
            <div class="header _pillsTabs">
                <h2>Payment <span> History</span></h2>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive mb-0" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Transaction Type</th>
                            <th>Payment </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $pay)
                        <tr>
                            <td>{{date("d/m/Y", strtotime($pay->created_at))}}</td>
                            <td>{{$pay->type == 1 ? 'Cash' : 'Bank Transfer'}}</td>
                            <td>{{$pay->currency_symbol}}. {{number_format($pay->amount)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-30">
        <div class="card OrderDL">
            <div class="header _pillsTabs">
                <h2>Shipping <span>Detail</span></h2>
            </div>
            <div class="body font13">
                <div class="row">
                    <div class="col-6">
                        <strong>Shipment Type:</strong> {{$order_core->order_type}}
                    </div>
                    <div class="col-6"><strong>Date of Shipment:</strong> {{$order_core->date_of_shipment}}</div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <hr class="mt-5 mb-5">
                    </div>
                    <div class="col-6"><strong>Shipping Company:</strong><br> {{$order_core->shipment_company}} </div>
                    <div class="col-6"><strong>Forwarder:</strong><br> {{$order_core->forwarder}}</div>
                    <div class="col-12">
                        <hr class="mt-5 mb-5">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4"><strong>ETA:</strong><br>NA</div>
                    <div class="col-4">
                        <strong>EDT:</strong><br>{{$order_core->expected_delivery_date ? $order_core->expected_delivery_date : "NA"}}
                    </div>
                    <div class="col-4"><strong>Discharge
                            Date:</strong><br>{{$order_core->discharge_date ? $order_core->discharge_date : 'NA'}}</div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <hr class="mt-5 mb-5">
                    </div>
                    <div class="col-12"><strong>Discharge
                            Port:</strong><br>{{$order_core->port_of_discharge ? $order_core->port_of_discharge : 'NA'}}
                    </div>
                    <div class="col-12 PT-10">
                        <h6>Documents List</h6>
                        <div class="Up-DocList" style="border-top:solid 1px #dee2e6; margin-top:10px">
                            <?php 
                                    $documents = json_decode($order_core->documents, true);
                                    ?>
                            @if ($documents)
                            @foreach ($documents as $value)
                            @foreach ($value as $image)
                            <a target="_blank" href="{{$ship_doc_url.$image['file']}}"><i class="fa fa-file"></i>
                                {{$image['filename']}}</a>
                            @endforeach
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-30">
        <div class="card OrderDL">
            <div class="header _pillsTabs">
                <h2>Documents <span>List</span></h2>
                <button class="btn btn-primary back_document_div" style="display:none; float:right">Back</button>
            </div>
            <div class="body">
                <div class="Up-DocList main_docs_heading_div">
                    <ul>
                        @if ($documents)
                        @foreach ($documents as $key => $value)
                        <li class="PB-5 multi_complete_docs" url="{{$ship_doc_url}}" type="{{$key}}"
                            document="{{json_encode($value)}}"><a href="#"><i class="fa fa-file"></i>{{$key}}</a></li>
                        @endforeach
                        @endif
                    </ul>
                </div>
                <div class="Up-DocList docs_display_div"></div>
            </div>
        </div>
    </div>
</div>
@endsection
