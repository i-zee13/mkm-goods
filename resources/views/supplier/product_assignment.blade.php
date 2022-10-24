@extends('layouts.master')
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Supplier <span>Product Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Suppliers</span></a></li>
            <li><span>Product Assignment</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Supplier <span> Assignment</span></h2>
            </div>
            <div class="body">
                <div class="col-md-6">
                    <div class="form-s2">
                        <select class="form-control formselect" id="supplier_id" placeholder="Select Supplier">
                            @foreach ($suppliers as $s)
                                <option value="{{ $s->id }}">{{ $s->supplier_custom_id }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="#" class="viewAssign" data-toggle="modal" data-target=".supplierProductAssignmentModal">View Assignment</a>
                </div>
            </div>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body tblBody" style="display: none">
            </div>
        </div>
    </div>
</div>
@endsection
