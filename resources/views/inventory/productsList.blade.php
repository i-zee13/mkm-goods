@extends('layouts.master')
@section('data-sidebar')
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">Product <span>Detail</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter pt-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <form style="display: flex;" id="saveProductForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="product_id" hidden>
                                    <div id="floating-label" class="card p-20 top_border mb-3" style="width: 100%">
                                        <h2 class="_head03">Product <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">SKU*</label>
                                                        <input type="text" name="sku" class="form-control required"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Name*</label>
                                                        <input type="text" name="name" class="form-control required"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control wizardFormSelect required"
                                                            id="mainCatDDProductsSidebar" name="primary_service_id"
                                                            placeholder="Select Primary Service*">
                                                            <option value="0" selected disabled>Select Primary Service*
                                                            </option>
                                                            @foreach ($main as $item)
                                                            <option value="{{ $item->id }}">{{ $item->service_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control wizardFormSelect required"
                                                            id="subCatDD" name="sub_category_id"
                                                            placeholder="Select Sub Service*">
                                                            <option value="0" selected disabled>Select Sub Service*
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 pt-19">
                                                    <label class="font12">Add Thumbnail Picture*</label>
                                                    <div id="thumbnaildropifyDiv"></div>
                                                </div>
                                                <div class="col-md-12 pt-19">
                                                    <label class="font12">Add Picture*</label>
                                                    <div id="pictureDropifyDiv"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 pt-19">
                                                    <label class="font12">Description</label>
                                                    <textarea rows="5" name="description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2" id="saveProductFromSidebar">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancel">Cancel</button>
    </div>
</div>
@endsection
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Products <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Products List</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Products List</h2>
            </div>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto"
                    style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body" style="display: none">
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    secServices = '{!! $sub !!}';
    secServices = JSON.parse(secServices);

</script>
