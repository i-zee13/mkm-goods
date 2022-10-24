@extends('layouts.master')
@section('data-sidebar')
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span>Category</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter ">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <form style="display: flex;" id="saveMainCatForm">
                                    @csrf
                                    <input type="text" id="operation" hidden>
                                    <input type="text" name="main_cat_id" hidden>
                                    <div id="floating-label" class="card p-20 top_border mb-3" style="width: 100%">
                                        <h2 class="_head03">Category <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Category Name *</label>
                                                        <input type="text" name="service_name" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <span>Upload Icon *</span>
                                                    <div class="upload-pic"></div>
                                                    <div class="img">
                                                        <input type="file" id="input-file-now" data-default-file="" class="dropify" name="service_icon" data-old_input="hidden_service_icon" accept="image/*" data-allowed-file-extensions="jpg png jpeg JPEG" />
                                                    </div>
                                                </div>


                                            </div>
                                            <h2 class="_head03 mt-10">Choose Status<span></span></h2>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input yes" type="radio" name="publish_service" id="yes" value="1">
                                                            <label class="custom-control-label font13" for="yes">Yes</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input no" type="radio" name="publish_service" id="no" value="0">
                                                            <label class="custom-control-label font13" for="no">No</label>
                                                        </div>
                                                    </div>
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
        <button type="submit" class="btn btn-primary mr-2" id="saveMainCat">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelMainCat">Cancel</button>
    </div>
</div>
@endsection
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Category <span>Area</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Main Category</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a class="btn add_button openDataSidebarForAddingMainCat"><i class="fa fa-plus"></i> New Category</a>
                <h2>Main Categories</h2>
            </div>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body" style="display: none">
            </div>
        </div>
    </div>
</div>
@endsection