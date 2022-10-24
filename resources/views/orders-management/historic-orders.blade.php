@extends('layouts.master')
@section('content')

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
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Orders List</h2>
                <a href="/Orders/create/historical" class="btn add_button"><i class="fa fa-plus"></i> <span> New Order</span></a>
            </div>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto"
                    style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body" style="display: none">
                <table class="table table-hover dt-responsive nowrap orders_listing" style="width:100% !important">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>E-Invoice</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                        <tr>
                            <td>{{ $item->customer }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->invoice_num }}</td>
                            <td>{{ ucfirst($item->current_status) }}</td>
                            <td>
                                <a href="/Orders/{{$item->id}}/edit/historic" class="btn btn-default btn-line">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
