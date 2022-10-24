@extends('layouts.master')
@section('content')


	

@section('data-sidebar')
    @include('brands.detail')
@endsection



    <div class="container">
        <div class="row mt-2 mb-3">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h2 class="_head01">Brands <span>List</span></h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <ol class="breadcrumb">
                    <li><a href="#"><span>Brands</span></a></li>
                    <li><span>Add</span></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <a id="productlist01" href="#" class="btn add_button"><i class="fa fa-plus"></i>
                            <span>Add Brands</span></a>
                        <h2>Brands <span>List</span></h2>
                    </div>
                    <div style="min-height: 400px" id="tblLoader">

                        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                    </div>
                    <div class="body" style="display: none">
                       
                    </div>

                @endsection
