@extends('layouts.master')
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-6">
        <h2 class="_head01">Orders <span> Management</span></h2>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a href="/Orders/create" class="btn add_button in-btn"><i class="fa fa-plus"></i> <span>
                        Order</span></a>
                <h2 class="order_status_heading"></h2> <span class="order_status_des"> </span>
            </div>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body">
            </div>
        </div>
    </div>
</div>
@endsection
