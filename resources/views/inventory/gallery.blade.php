@extends('layouts.master')

@section('content')
<style>
    .holder>li {
        padding: 5px;
        margin: 2px;
        display: inline-block;
    }

    .holder>li[data-page] {
        border: solid #dee2e6 1px;
        border-radius: 5px;
        border-radius: 0px;
        font-size: 13px;
        padding: 8px 10px;
        line-height: 1;

    }

    .holder>li.separator:before {
        content: '...';
    }

    .holder>li.active {
        background: linear-gradient(90deg, #1e54d3 0%, #040725 100%);
        border-color: #040725;
        color: #fff;
    }

    .holder>li[data-page]:hover {
        cursor: pointer;
    }

    .col2 {
        width: 130px;
        flex: 0 0 auto;
        max-width: none;
    }

    .col3 {
        width: 190px;
        flex: 0 0 auto;
        max-width: none;
    }

    .col4 {
        width: 340px;
        flex: 0 0 auto;
        max-width: none;
    }

    .col5 {
        width: 250px;
        flex: 0 0 auto;
        max-width: none;
    }

    .pt-11 {
        padding-top: 11px
    }

    .Product-row a {
        color: #282828;
    }

    .Product-row a:hover,
    .Product-row a:focus {
        color: #040725;
    }

    .Product-row {
        padding: 8px 15px;
        margin-bottom: 0;
        box-shadow: 0px 0px 5px 0px rgb(0, 0, 0, 0.15);
    }
</style>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Product <span>List</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a><span>Product</span></a></li>
            <li><span>List</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="Product-Filter">
            <div class="row">
                <div class="col pr-0">
                    <div class="CL-Product mb-15"><i class="fa fa-search"></i>
                        <input type="text" class="form-control search_product" id="" placeholder="Search">
                    </div>
                    <div class="_cust_filter">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="nav" id="nav-tab" role="tablist"> <a class="nav-item nav-link" id="productthumb-tab" data-toggle="tab" href="#productthumb" role="tab" aria-controls="productthumb" aria-selected="false"><i class="fa fa-th-large"></i></a> <a class="nav-item nav-link active" id="productList-tab" data-toggle="tab" href="#productList" role="tab" aria-controls="productList" aria-selected="true"><i class="fa fa-th-list"></i></a> </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="productList" role="tabpanel" aria-labelledby="productList-tab">

                <div class="Product-row-title">
                    <div class="row">
                        <div class="col col2 pr-0">S.No</div>
                        <div class="col col2 pr-0">ITEM SKU</div>
                        <div class="col col3 pr-0">BRAND</div>
                        <div class="col col4 pl-0">PRODUCT NAME</div>
                        <div class="col col5">SUB CATEGORY</div>
                    </div>
                </div>
                <div style="min-height: 400px" class="tblLoader">
                    <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                </div>
                <div class="product_list_view_div">

                </div>
            </div>

            <div class="tab-pane fade" id="productthumb" role="tabpanel" aria-labelledby="productthumb-tab">
                <div style="min-height: 400px" class="tblLoader">
                    <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                </div>
                <div class="row PT-15 products_grid_view_div">

                </div>
            </div>

        </div>

        <div class="ProductPageNav text-center">
            <div id="holder" class="holder" style="position: relative; "></div>
            {{-- <ul class="pagination justify-content-center">
            </ul> --}}
        </div>
    </div>
</div>
@endsection