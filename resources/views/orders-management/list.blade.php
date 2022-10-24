@extends('layouts.master')
@section('content')

{{-- Modal Bulk Upload Order --}}
<div class="modal fade bd-example-modal-lg-bulk-order" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="custom-select custom-select-sm select_currency_bulkUpload">
                                        <option value="0" selected disabled>Select Currency*</option>
                                        <option sign="$" value="USD">USD - United States Dollar</option>
                                        <option sign="Rs" value="PKR">PKR - Pakistan Rupees </option>
                                        <option sign="HK$" value="HKD">HKD — Hong Kong dollar</option>
                                        <option sign="AFN" value="AFN">AFN — Afghani</option>
                                    </select>
                                </div>

                            </div>
                            <a href="/download_sample_order" class="sample_download_link"> <button type="button" class="btn btn-primary font13" style="margin-bottom:15px; margin-top: 10px">Sample Download</button></a>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload Excel</span>
                                </div>
                                <div class="custom-file">
                                    <form method="POST" enctype="multipart/form-data" id="upload_orderExcel_form">
                                        {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
                                        @csrf
                                        <input type="file" name="file" class="custom-file-input order_file_input"
                                            id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label file_name" for="inputGroupFile01">Choose
                                            file</label>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display:none" class="alert alert-danger error_message_div" role="alert"> <strong>Failed!
                        </strong> Following Orders are not added due to wrong formatting </div>
                    <div class="table-responsive not_uploadable_orders_table">
                    </div>
                </div>
                <div class="modal-footer  border-0 p-0">
                    <button type="button" class="btn btn-cancel close_modal" data-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="button" class="btn btn-primary upload_order_file_btn">Bulk Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Bulk Upload Order Items --}}
<div class="modal fade bd-example-modal-lg-bulk-order-item" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                            <a href="/download_sample_order_items"> <button type="button" class="btn btn-primary font13" style="margin-bottom:15px; margin-top: 10px">Sample Download</button></a>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload Excel</span>
                                </div>
                                <div class="custom-file">
                                    <form method="POST" enctype="multipart/form-data" id="upload_orderItemsExcel_form">
                                        {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
                                        @csrf
                                        <input type="file" name="file" class="custom-file-input orderItem_file_input"
                                            id="inputGroupFile02" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label file_name" for="inputGroupFile02">Choose
                                            file</label>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display:none" class="alert alert-danger error_message_div" role="alert"> <strong>Failed!
                        </strong> Following Customers are not dded due to wrong formatting </div>
                    <div class="table-responsive not_uploadable_products_table">
                    </div>
                </div>
                <div class="modal-footer  border-0 p-0">
                    <button type="button" class="btn btn-cancel close_modal" data-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="button" class="btn btn-primary upload_orderItems_file_btn">Bulk Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Orders <span>Management</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Orders</span></a></li>
            <li><span>List</span></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="header-tabs">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                        aria-controls="pills-home" aria-selected="true"><span>Pending Orders</span> <span
                            class="_cus-val">
                            {{ ($pending_orders ? sizeof($pending_orders) : 00) }}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                        aria-controls="pills-profile" aria-selected="false"><span>Processed Orders </span> <span
                            class="_cus-val"> {{ ($processed_orders ? sizeof($processed_orders) : 00) }}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                        aria-controls="pills-contact" aria-selected="false"><span>Completed Orders </span> <span
                            class="_cus-val">{{ ($completed_orders ? sizeof($completed_orders) : 00) }}</span></a>
                </li>
            </ul>
            {{-- <button class="btn add_button open_modal" style="margin-right: 110px" data-toggle="modal" data-target=".bd-example-modal-lg-bulk-order"><i class="fa fa-plus"></i> Upload Bulk Orders </button>
            <button class="btn add_button open_modal" style="margin-right: 275px" data-toggle="modal" data-target=".bd-example-modal-lg-bulk-order-item"><i class="fa fa-plus"></i> Upload Bulk Order Items </button> --}}
            {{--<a href="/Orders/create" class="btn add_button"><i class="fa fa-plus"></i> <span> New Order</span></a>--}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="body">

                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <table class="table table-hover dt-responsive nowrap order_listing"  style="width:100% !important">
                            <thead>
                                <tr>
                                    <th>E-Invoice</th>
                                    <th>Customer Name</th>
                                    <th>Issued Date</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pending_orders as $item)
                                <tr>
                                    <td>{{ $item->invoice_num }}</td>
                                    <td>{{ $item->customer }}</td>
                                    <td>{{ $item->issue_date ? $item->issue_date : 'NA' }}</td>
                                    <td>{{ $item->created_by }}</td>
                                    <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                    <td>{{ ucfirst($item->current_status) }}</td>
                                    <td>
                                        <a href="/Orders/{{$item->id}}/edit" class="btn btn-default btn-line">Edit</a>
                                        <a href="/dispatch-order/{{$item->id}}" class="btn btn-default btn-line">Dispatch</a>
                                        <a href="/order-sheet/{{$item->id}}/{{$item->customer_id}}" class="btn btn-default btn-line">Order Sheet</a>
                                        {{--<a href="/OrderDetails/{{ $item->id }}" class="btn btn-default">Details</a>--}}
                                       {{-- <form id="deletePerformaForm" style="display: inline-block"><input type="text"
                                                name="_method" value="DELETE" hidden=""><input type="text" name="_token"
                                                value="oqlp7k5E694Yndoxh66f1UcgJ6nhuqgpQvkBWsBy" hidden=""><button
                                                type="button" id="{{ $item->id }}"
                                                class="btn btn-default deletePerforma" title="Delete">Delete</button>
                                        </form>--}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <table class="table table-hover dt-responsive nowrap order_listing" style="width:100% !important">
                            <thead>
                                <tr>
                                    <th>E-Invoice</th>
                                    <th>Customer Name</th>
                                    <th>Issued Date</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($processed_orders as $item)
                                <tr>
                                    <td>{{ $item->invoice_num }}</td>
                                    <td>{{ $item->customer }}</td>
                                    <td>{{ $item->issue_date ? $item->issue_date : 'NA' }}</td>
                                    <td>{{ $item->created_by }}</td>
                                    <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                    <td>{{ ucfirst($item->current_status) }}</td>
                                    <td>
                                        <a href="/Orders/{{$item->id}}/edit" class="btn btn-default btn-line">Edit</a>
                                        <button id="{{ $item->id }}" class="btn btn-default completeOrder">Complete</button>
                                        <form id="deletePerformaForm" style="display: inline-block"><input type="text"
                                                name="_method" value="DELETE" hidden=""><input type="text" name="_token"
                                                value="oqlp7k5E694Yndoxh66f1UcgJ6nhuqgpQvkBWsBy" hidden=""><button
                                                type="button" id="{{ $item->id }}"
                                                class="btn btn-default deletePerforma" title="Delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <table class="table table-hover dt-responsive nowrap order_listing" style="width:100% !important">
                            <thead>
                                <tr>
                                    <th>E-Invoice</th>
                                    <th>Customer Name</th>
                                    <th>Issued Date</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($completed_orders as $item)
                                <tr>
                                    <td>{{ $item->invoice_num }}</td>
                                    <td>{{ $item->customer }}</td>
                                    <td>{{ $item->issue_date ? $item->issue_date : 'NA' }}</td>
                                    <td>{{ $item->created_by }}</td>
                                    <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                    <td>{{ ucfirst($item->current_status) }}</td>
                                    <td>
                                        {{-- @if($item->total_amount && $item->payment_received == 0 && $item->current_status
                                        == 'completed')
                                        <button id="{{ $item->id ."/". ($item->paid_amt ? (($item->total_amount - $item->discount_value) - $item->paid_amt) : $item->total_amount - $item->discount_value).'/'. $item->currency_symbol}}"
                                            class="btn btn-default recieve_payment" data-toggle="modal"
                                            data-target="#exampleModal">Receive Payment</button>
                                        @endif --}}
                                        <a href="/CompletedOrderDetail/{{$item->id}}" class="btn btn-default">View Detail</a>
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
@endsection
