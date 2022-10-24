@extends('layouts.master')
@section('data-sidebar')
    <style>
        #product-cl-sec,
        #product-add {
            width: 600px
        }

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

        .holder>li[data-page-poc] {
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
            background: linear-gradient(90deg, #0a0e36 0%, #040725 100%);
        ;
            border-color: #040725;
            color: #fff;
        }

        .holder>li[data-page]:hover {
            cursor: pointer;
        }

        @media (max-width:800px) {

            #product-cl-sec,
            #product-add {
                width: 100%
            }
        }

        .cusDetail-th,
        .cusDetail-th:HOVER {
            padding-left: 6px;
            padding-right: 6px;
        }

        .cusDetail-th,
        .cusDetail-th:HOVER {
            margin-left: 0;
            margin-right: 5px;
        }

        .POC-IM {
            margin: 0;
            padding: 15px 0 0 0
        }

        .POC-IM .dropify-wrapper .dropify-message p {
            line-height: 1
        }

        .POC-IM .dropify-wrapper,
        .POC-IM .dropify-wrapper .dropify-preview .dropify-render img {
            height: 80px !important;
            width: 80px;
            border-radius: 50%;
            margin: auto
        }

        .POC-IM .dropify-wrapper .dropify-message span.file-icon {
            font-size: 30px;
            color: #CCC
        }

        .POC-IM .dropify-wrapper .dropify-clear {
            top: 19px;
            right: 8px
        }

        .POC-IM .dropify-wrapper .dropify-preview {
            padding: 2px
        }

        .POC-IM .dropify-wrapper .dropify-preview .dropify-infos .dropify-infos-inner p.dropify-infos-message {
            padding-top: 10px;
            font-size: 11px
        }
        .closeBTN, .closeBTN:HOVER{cursor: pointer;}
    </style>
    <div class="agency_form">
        <div id="product-cl-sec" class="agency_form_div">
            <a class="close-btn-pl pl-close"></a>
            <div class="pro-header-text ml-0">New <span>Agency</span></div>
            <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="pc-cartlist">
                <form style="display: flex;" id="saveAgencyForm">
                    @csrf
                    <input type="hidden" name="product_updating_id" id="product_updating_id">
                    <input type="text" id="operation" hidden>
                    <input type="text" value="" hidden class="doc_key" name="doc_key" />
                    <div class="overflow-plist">
                        <div class="plist-content">
                            <div class="_left-filter pt-0">
                                <div class="se_cus-type p-20 mb-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input hidden type="text" id="hidden_cust_type" value="{{$types}}" />
                                            <label class=" border-0" style="font-size:13px">Select Business Type*</label>
                                            <div class="form-s2">
                                                <select class="form-control formselect required_agency" name="business_type" placeholder="Select Business Type*">
                                                    <option value="0" disabled selected>Select Business Type</option>
                                                    <option value="1">Real Estate Agency</option>
                                                    <option value="2">Mortgage Broker</option>
                                                    <option value="3">Lender</option>
                                                    <option value="4">Bank</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="floating-label" class="card p-20 top_border mb-3">
                                                <h2 class="_head03">Agency <span>Details</span></h2>
                                                <input hidden type="text" id="hidden_comp_name" value="{{$customers}}" />
                                                <div class="form-wrap p-0">
                                                    <div class="row">
                                                        <div class="col-md-6 pt-5">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Company Name*</label>
                                                                <input type="text" name="company_name" class="form-control required_agency" id="company_name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 pt-5">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Company Contact Number*</label>
                                                                <input type="text" name="company_contact_number" class="form-control required_agency" id="company_number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-wrap p-0">
                                                    <div class="row">
                                                        <div class="col-md-12 mt-20">
                                                            <h2 class="_head03">Other Contact Info <span></span></h2>
                                                        </div>
                                                        <div class="col-md-6 pt-5">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Business Phone No.*</label>
                                                                <input type="text" class="form-control required_agency" name="business_phone_no" id="business_number">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 pt-5">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Email*</label>
                                                                <input type="text" class="form-control email required_agency" name="email" id="email" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 pt-5">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Website URL*</label>
                                                                <input type="text" class="form-control required_agency" name="website_url" id="url">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Official Address --}}
                                                <div class="row ">
                                                    <div class="col-md-12 mt-20">
                                                        <h2 class="_head03">Official Address <span></span></h2>
                                                    </div>
                                                    <div class="col-md-4 pr-10 pt-5">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Office No.*</label>
                                                            <input type="text" class="form-control required_agency" name="office_no" style="font-size: 13px;color:#212121;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 pt-5 pl-0">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Street Address*</label>
                                                            <input type="text" class="form-control required_agency" name="street_address" style="font-size: 13px;color:#212121;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-s2">
                                                            <label class="font11 mb-0">Country*</label>
                                                            <select class="form-control formselect required_agency all_countries" placeholder="select Country*" name="country_id">

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-s2">
                                                            <label class="font11 mb-0">State*</label>
                                                            <select class="form-control formselect required_agency all_states" placeholder="Select State*" name="state_id">

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pt-5">
                                                        <div class="form-s2">
                                                            <label class="font11 mb-0">City*</label>
                                                            <select class="form-control formselect required_agency all_cities" placeholder="Select City*" name="city_id">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pt-5">
                                                        <div class="form-s2">
                                                            <label class="font11 mb-0">Postal Code*</label>
                                                            <select class="form-control formselect required_agency all_postal_codes" placeholder="Select City*" name="postal_code">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                    {{-- Official Address --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="_cl-bottom">
                <button type="button" class="btn btn-primary mr-2" id="saveAgency">Save</button>
                <button type="button" class="btn btn-cancel mr-2 pl-close" id="cancelAgency">Cancel</button>
            </div>
        </div>
    </div>
    {{-- </form> --}}







@endsection

@section('content')

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01 mb-15">Business Contact <span>Management</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Business Contact</span></a></li>
                <li><span>Agency List</span></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="header-tabs pb-1 mb-10">
                <div class="row">
                    <div class="col-auto">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active top-tabs" id="nav-home-tab" type="customer" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Agency List<span class="_cus-val count_customers"> 0 </span></a>
                            </a>
                        </div>
                    </div>

                    <div class="col">
                        <div class="Product-Filter Cus-Filter">
                            <div class="row">
                                <div class="col-auto p-0">
                                    <div class="CL-Product"><i class="fa fa-search"></i>
                                        <input type="text" class="form-control dynamic_search" data-current_action="customer" id="" placeholder="Search">
                                    </div>
                                    <div class="_cust_filter m-0" id="agency_filter">
                                        <select class="custom-select custom-select-sm dynamic_filter" data-current_action="customer">
                                            <option selected="" value="0">All</option>
                                            <option value="1">Real Estate Agency</option>
                                            <option value="2">Mortgage Broker</option>
                                            <option value="3">Lender</option>
                                            <option value="4">Bank</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-auto pl-0 top_bar_customer">
                                    <button class="btn btn-addproduct mb-0 bulk_upload_btn" data-toggle="modal"
                                        data-target=".bd-example-modal-lg-bulk-customer"><i class="fa fa-upload"></i> Bulk
                                        Upload
                                    </button>
                                    <button class="btn btn-addproduct mb-0 openDataSidebarForAddingAgency"><i class="fa fa-plus"></i> Add Agency </button>
                                    <div class="nav" id="nav-tab" role="tablist"> <a class="nav-item nav-link" id="productthumb-tab" data-toggle="tab" href="#productthumb2" role="tab" aria-controls="productthumb2" aria-selected="false"><i class="fa fa-th-large"></i></a> <a class="nav-item nav-link active" id="productList2-tab" data-toggle="tab" href="#productList2" role="tab" aria-controls="productList2" aria-selected="true"><i class="fa fa-th-list"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content" id="nav-tabContent">
        {{-- Agency List --}}
        <div class="tab-pane fade show active body_sales_agants" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active " id="productList2" role="tabpanel" aria-labelledby="productList2-tab">

                            <div class="Product-row-title">
                                <div class="row">
                                    <div class="col colStyle h-auto" style="max-width:343px">Agency Name</div>
                                    <div class="col colStyle h-auto" style="max-width:220px">Country</div>
                                    <div class="col colStyle h-auto" style="max-width:190px">Email</div>
                                    <div class="col colStyle h-auto" style="max-width:195px">Phone No.</div>
                                    <div class="col colStyle h-auto" style="max-width:195px">Business Type</div>
                                    <div class="col colStyle h-auto" style="max-width:180px">Action</div>
                                </div>
                            </div>
                            <div style="min-height: 400px" class="tblLoader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                            </div>
                            <div class="cust_list_div">
                            </div>
                        </div>
                        <div class="tab-pane fade " id="productthumb2" role="tabpanel" aria-labelledby="productthumb2-tab">
                            <div style="min-height: 400px" class="tblLoader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                            </div>
                            <div class="row PT-15 cust_grid_div">
                            </div>
                        </div>
                    </div>
                    <div class="ProductPageNav text-center">
                        <div id="cust_holder" class="holder" style="position: relative; "></div>
                        {{-- <ul class="pagination justify-content-center pagination_cust">

                        </ul> --}}
                    </div>
                </div>
            </div>
        </div>


    </div>
    {{-- Modal Bulk Upload Agency --}}
    <div class="modal fade bd-example-modal-lg-bulk-customer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                {{-- <div class="row">
                                    <div class="col-md-3">
                                        <select class="custom-select custom-select-sm select_business_type_for_bulk">
                                            <option value="0" selected disabled>Select Business Type</option>
                                            <option value="1">Real Estate Agency</option>
                                            <option value="2">Mortgage Broker</option>
                                            <option value="3">Lender</option>
                                            <option value="4">Bank</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="custom-select custom-select-sm all_countries" name="country_id">

                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="custom-select custom-select-sm all_states" name="country_id">

                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="custom-select custom-select-sm all_cities" name="country_id">

                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="custom-select custom-select-sm all_postal_codes" name="country_id">

                                        </select>
                                    </div>
    
                                </div> --}}
                                <a href="/download_sample_customers" class="sample_download_link"> <button type="button" class="btn btn-primary font13" style="margin-bottom:15px; margin-top: 10px">Sample
                                        Download</button></a>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload Excel</span>
                                    </div>
                                    <div class="custom-file">
                                        <form method="POST" enctype="multipart/form-data" id="upload_excel_form">
                                            @csrf
                                            <input type="file" name="file" class="custom-file-input excel_file_input" id="inputGroupFile01" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"  aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label file_name" for="inputGroupFile01">Choose
                                                file</label>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Company Name Already Exists --}}
                        <div style="display:none" class="alert alert-danger error_message_div" role="alert"> <strong>Failed!
                            </strong> Following Agencies are not added. </div>
                        <div class="table-responsive not_uploadable_customers_table">
                        
                        </div>
                        {{-- Business Type Not Found --}}
                        <div style="display:none" class="alert alert-danger error_message_business_type_div" role="alert"> <strong>Failed!
                        </strong> Following Agencies are not added. </div>
                        <div class="table-responsive not_uploadable_business_type_table">
                        
                        </div>
                    </div>
                    <div class="modal-footer  border-0 p-0">
                        <button type="button" class="btn btn-cancel close_modal" data-dismiss="modal" aria-label="Close">Close</button>
                        <button type="button" class="btn btn-primary upload_excel_file_btn">Bulk Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection