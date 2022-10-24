@extends('layouts.master')
@section('content')
{{-- <div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-6">
        <h2 class="_head01">Orders <span> Management</span></h2>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a href="/Orders/create" class="btn add_button in-btn"><i class="fa fa-plus"></i> <span>
                        Add Order</span></a>
                <h2>All <span> Orders </span></h2>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Issued Date</th>
                            <th>PO Number</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->customer }}</td>
<td>{{ $item->issue_date }}</td>
<td>{{ $item->po_num }}</td>
<td>{{ ucfirst($item->current_status) }}</td>
<td>
    @if($item->current_status !== "completed")
    <a href="/Orders/{{$item->id}}/edit" class="btn btn-default btn-line">Edit</a>
    @endif

    @if($item->current_status == "pending")
    <a href="/OrderDetails/{{ $item->id }}" class="btn btn-default">Details</a>
    @endif

    @if($item->current_status == 'performa')
    <button id="{{ $item->id }}" class="btn btn-default viewInvoice" data-toggle="modal"
        data-target="#performaInvoiceModal">View
        Invoice</button>
    @endif

    @if($item->current_status == 'processed')
    <button id="{{ $item->id }}" class="btn btn-default completeOrder">Complete</button>
    @endif

    @if($item->total_amount && $item->payment_received == 0 && $item->current_status ==
    'completed')
    <button id="{{ $item->id ."/". ($item->total_amount - $item->discount_value) }}"
        class="btn btn-default recieve_payment" data-toggle="modal" data-target="#exampleModal">Receive Payment</button>
    @endif

    @if($item->current_status !== "completed")
    <form id="deletePerformaForm" style="display: inline-block"><input type="text" name="_method" value="DELETE"
            hidden=""><input type="text" name="_token" value="oqlp7k5E694Yndoxh66f1UcgJ6nhuqgpQvkBWsBy"
            hidden=""><button type="button" id="{{ $item->id }}" class="btn btn-default deletePerforma"
            title="Delete">Delete</button></form>
    @endif
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div> --}}
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
            <a href="/Orders/create" class="btn add_button"><i class="fa fa-plus"></i> <span> New Order</span></a>
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
                                    <th>Customer Name</th>
                                    <th>Issued Date</th>
                                    <th>PO Number</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pending_orders as $item)
                                <tr>
                                    <td>{{ $item->customer }}</td>
                                    <td>{{ $item->issue_date }}</td>
                                    <td>{{ $item->po_num }}</td>
                                    <td>{{ ucfirst($item->current_status) }}</td>
                                    <td>
                                        <a href="/Orders/{{$item->id}}/edit" class="btn btn-default btn-line">Edit</a>
                                        <a href="/OrderDetails/{{ $item->id }}" class="btn btn-default">Details</a>
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

                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <table class="table table-hover dt-responsive nowrap order_listing" style="width:100% !important">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Issued Date</th>
                                    <th>PO Number</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($processed_orders as $item)
                                <tr>
                                    <td>{{ $item->customer }}</td>
                                    <td>{{ $item->issue_date }}</td>
                                    <td>{{ $item->po_num }}</td>
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
                                    <th>Customer Name</th>
                                    <th>Issued Date</th>
                                    <th>PO Number</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($completed_orders as $item)
                                <tr>
                                    <td>{{ $item->customer }}</td>
                                    <td>{{ $item->issue_date }}</td>
                                    <td>{{ $item->po_num }}</td>
                                    <td>{{ ucfirst($item->current_status) }}</td>
                                    <td>
                                        @if($item->total_amount && $item->payment_received == 0 && $item->current_status
                                        == 'completed')
                                        <button id="{{ $item->id ."/". ($item->paid_amt ? (($item->total_amount - $item->discount_value) - $item->paid_amt) : $item->total_amount - $item->discount_value).'/'. $item->currency_symbol}}"
                                            class="btn btn-default recieve_payment" data-toggle="modal"
                                            data-target="#exampleModal">Receive Payment</button>
                                        @endif
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
