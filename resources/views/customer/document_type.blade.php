@extends('layouts.master')

@section('data-sidebar')
<div id="product-cl-sec">
    <a id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span>Document Type</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div id="floating-label" class="card p-20 top_border mb-3">
                                    <h2 class="_head03">Add <span>Document Type</span></h2>
                                    
                                    <form style="display: flex;" id="saveDocumentTypeForm">
                                        {{-- {!! Form::hidden('_method', 'PUT') !!} --}}
                                        {!! Form::hidden('document_type_updating_id', '') !!}
                                        {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
                                        @csrf
                                        <input type="text" id="operation" name="operation" hidden>
                                        <input type="text" id="document_update_id" name="document_update_id" hidden>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Document Type Name*</label>
                                                        <input type="text" name="document_type_name" class="form-control required">
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
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2" id="saveDocumentType">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelDocumentType">Cancel</button>
    </div>
</div>
@endsection

@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Document <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Document</span></a></li>
            <li><span>Types List</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a id="productlist01"class="btn add_button openDataSidebarForAddingDocumentType"><i class="fa fa-plus"></i> <span> New Document Types</span></a>
                <h2>Document <span> Types List</span></h2>
            </div>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body body_document" style="display: none">
            </div>
        </div>
    </div>
</div>
@endsection
