@extends('layouts.master')
@section('data-sidebar')
<div id="product-cl-sec">
    <a id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text ml-0">New <span>POC</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <form style="display: flex;" id="saveCompanyPocForm" enctype="multipart/form-data">
        @csrf
            <input hidden class="operation" name="operation" type="text"/>
            <input hidden class="poc_update_id" name="poc_update_id" type="text"/>
            <input hidden class="ext_card_front" name="ext_card_front" type="text"/>
            <input hidden class="ext_card_back" name="ext_card_back" type="text"/>
            <input hidden class="ext_profile" name="ext_profile" type="text"/>
            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter pt-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <style>
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

                                    </style>
                                    <div id="floating-label" class="card p-20 top_border">

                                        <h2 class="_head03">POC <span>Details</span></h2>

                                        <div class="form-wrap p-0">
                                            <div class="form-wrap POC-IM">
                                                <div class="upload-pic dropifyImgDiv"></div>
                                                {{-- <input type="file" id="input-file-now" class="dropify"
                                                    data-default-file="/images/avatar-img.jpg" /> --}}
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 pt-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">First Name*</label>
                                                        <input type="text" class="form-control required" name="first_name">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 pt-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Last Name*</label>
                                                        <input type="text" name="last_name" class="form-control required" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-s2"> <label class="font12 mb-5">Company Name*</label>
                                                        <div>
                                                            <select class="form-control formselect required" name="customer_id" placeholder="select Type">
                                                                <option selected disabled value="-1">Select Company</option>
                                                                @foreach ($customers as $data)
                                                                <option value="{{$data->id}}">{{$data->company_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group mt-5">
                                                        <label class="control-label mb-10">Job Title*</label>
                                                        <input type="text" name="job_title" class="form-control required" placeholder="">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 mt-25">
                                                    <h2 class="_head03">Phone <span>No</span><a class="addBTN-act add_another_number"><i class="fa fa-plus"></i> Add Phone</a></h2>
                                                </div>

                                                <div class="phone_nums_div row w-100 m-0">
                                                    <div class="col-md-6">
                                                        <div class="form-group phone-SL">
                                                            <div class="col-auto p-0">
                                                                <select class="custom-select custom-select-sm phone_type">
                                                                    <option selected disabled value="-1">Type</option>
                                                                    <option value="business">Business</option>
                                                                    <option value="mobile">Mobile</option>
                                                                    <option value="whatsapp">WhatsApp</option>
                                                                </select>
                                                            </div>
                                                            <div class="col p-0">
                                                                <a class="closeBTN remove_phone_num" style="color:white !important"><i class="fa fa-times"></i></a>
                                                                <input class="phoneinput poc_phone_number" type="text" placeholder="0000000000">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 mt-20">
                                                    <h2 class="_head03">Email <span></span></h2>
                                                </div>

                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Official Email*</label>
                                                        <input type="text" class="form-control required" name="official_email">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Personal Email*</label>
                                                        <input type="text" class="form-control required" name="personal_email">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mt-20">
                                                    <h2 class="_head03">Social <span></span></h2>
                                                </div>
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Linkedin Link*</label>
                                                        <input type="text" class="form-control required" name="linkedin">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Wechat Link*</label>
                                                        <input type="text" class="form-control required" name="wechat">
                                                    </div>
                                                </div>
                                            </div>
 
                                            <div class="row address_div" type="home">
                                                <div class="col-md-12 mt-20">
                                                    <h2 class="_head03">Home Address <span></span></h2>
                                                </div>
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Home Address*</label>
                                                        <input type="text" class="form-control required address" address-type="home" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Postal Code*</label>
                                                        <input type="text" class="form-control required code" address-type="home">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">City*</label>
                                                        <input type="text" class="form-control required city" address-type="home">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">

                                                    <div class="form-s2">
                                                        <label class="font11 mb-0">Country*</label>
                                                        <div>
                                                            <select class="form-control formselect required country" placeholder="select Country" address-type="home">
                                                                <option value="-1" selected disabled>Select Country</option>
                                                                <option value="Pakistan">Pakistan</option>
                                                                <option value="UK">UK</option>
                                                                <option value="USA">USA</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row address_div" type="offical">
                                                <div class="col-md-12 mt-20">
                                                    <h2 class="_head03">Official Address <span></span></h2>
                                                </div>
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Official Address*</label>
                                                        <input type="text" class="form-control required address" address-type="offical">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Postal Code*</label>
                                                        <input type="text" class="form-control required code" address-type="offical">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">City*</label>
                                                        <input type="text" class="form-control required city" address-type="offical">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">

                                                    <div class="form-s2">
                                                        <label class="font11 mb-0">Country*</label>
                                                        <div>
                                                            <select class="form-control formselect required country" placeholder="select Country" address-type="offical">
                                                                <option value="-1" selected disabled>Select Country</option>
                                                                <option value="Pakistan">Pakistan</option>
                                                                <option value="UK">UK</option>
                                                                <option value="USA">USA</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="row">
                                                <div class="col-md-12 mt-25">
                                                    <h2 class="_head03">Business <span>Card</span></h2>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="font11 mb-0">Front</label>
                                                    <div class="form-wrap p-0">
                                                        <div class="upload-pic cardFrontDiv"></div>
                                                        {{-- <input type="file" id="input-file-now" class="dropify" /> --}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="font11 mb-0">Back</label>
                                                    <div class="form-wrap p-0">
                                                        <div class="upload-pic cardBackDiv"></div>
                                                        {{-- <input type="file" id="input-file-now" class="dropify" /> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
        <button type="button" class="btn btn-primary mr-2 save_poc_detail">Save</button>
        <button id="pl-close" type="button" class="btn btn-cancel mr-2 cancel_poc">Cancel</button>
    </div>
</div>
@endsection


@section('content')
<style>
    .holder > li {
      padding: 5px;
      margin: 2px;
      display: inline-block;
    }
    .holder > li[data-page] {
      border: solid #dee2e6 1px;
      border-radius: 5px;
      border-radius: 0px; 
      font-size: 13px;
      padding: 8px 10px;
      line-height: 1;
      
    }
    .holder > li.separator:before {
      content: '...';
    }
    .holder > li.active {
      background: linear-gradient(90deg, #1e54d3 0%, #040725 100%);
      border-color: #040725;
      color: #fff;
    }
    .holder > li[data-page]:hover {
      cursor: pointer;
    }
</style>

<div class="modal fade" id="poc_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content top-border">
            <div class="modal-header statusMH">
                <h5 class="modal-title" id="exampleModalLabel">Status: <span class="modal_poc_name"> </span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-20">
                <div class="row">
                    <div class="col-6 status-sh">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="active_status" value="active"
                                data-id="active_status" name="radio_status" checked>
                            <label class="custom-control-label head-sta" for="active_status"> Active</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh StDeactive">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="deactive_status" value="deactive"
                                data-id="deactive_status" name="radio_status">
                            <label class="custom-control-label head-sta" for="deactive_status"> Deactive</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh StLead">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="hid002" value="lead"
                                data-id="hid002" name="radio_status">
                            <label class="custom-control-label head-sta" for="hid002"> Lead</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh StProspect">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="hid003" value="prospect"
                                data-id="hid003" name="radio_status">
                            <label class="custom-control-label head-sta" for="hid003"> Prospect</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh StCustomer">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="hid004" value="customer"
                                data-id="hid004" name="radio_status">
                            <label class="custom-control-label head-sta" for="hid004"> Customer</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh STChurned">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="hid005" value="churned"
                                data-id="hid005" name="radio_status">
                            <label class="custom-control-label head-sta" for="hid005"> Churned</label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary save_status">Save</button>
                <!--<button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">Cancel</button>-->
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">POC <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a><span>POC</span></a></li>
            <li><span>List</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="Product-Filter">
            <div class="row">
                <div class="col pr-0">
                    <div class="CL-Product"><i class="fa fa-search"></i>
                        <input type="text" class="form-control search_poc" id="" placeholder="Search">
                    </div>
                    <div class="_cust_filter">
                        <select class="custom-select custom-select-sm poc_type_filter">
                            <option selected="" value="0">All POC</option>
                            <option value="customer">Customer</option>
                            <option value="prospect">Prospects</option>
                            <option value="lead">Sales Leads</option>
                            <option value="deactive">Deactivated</option>
                            <option value="active">Activated</option>
                            <option value="churned">Churn</option>
                        </select>
                    </div>
                </div>
                <div class="col-auto">
                    {{-- //opensideBarToAddPoc --}}
                    <button class="btn btn-addproduct mb-0 "><i class="fa fa-plus"></i> Add POC
                    </button>
                    <div class="nav" id="nav-tab" role="tablist"> <a class="nav-item nav-link" id="productthumb-tab"
                            data-toggle="tab" href="#productthumb" role="tab" aria-controls="productthumb"
                            aria-selected="false"><i class="fa fa-th-large"></i></a> <a class="nav-item nav-link active"
                            id="productList-tab" data-toggle="tab" href="#productList" role="tab"
                            aria-controls="productList" aria-selected="true"><i class="fa fa-th-list"></i></a> </div>
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
                        <div class="col colStyle h-auto" style="max-width:230px">POC Name</div>
                        <div class="col colStyle h-auto" style="max-width:160px">Phone No</div>
                        <div class="col colStyle h-auto" style="max-width:180px">Email</div>
                        <div class="col colStyle h-auto" style="max-width:290px">Company</div>
                        <div class="col colStyle h-auto" style="max-width:170px">Status</div>
                        <div class="col colStyle _Action h-auto">Action</div>
                    </div>
                </div>

                <div style="min-height: 400px" class="tblLoader">
                    <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                </div>
                <div class="list_view_div">
                    {{-- <div class="Product-row">
                        <div class="row">

                            <div class="col colStyle" style="max-width:230px">
                                <div style="display:table">
                                    <div class="_emp-D"><img src="images/avatar.svg" alt=""></div>
                                    <div class="textMiddle">Saif Ali Khan</div>
                                </div>
                            </div>
                            <div class="col colStyle" style="max-width:160px">
                                <div class="textMiddle"> +953335554754</div>
                            </div>
                            <div class="col colStyle" style="max-width:180px">
                                <div class="textMiddle"> com@company.com</div>
                            </div>
                            <div class="col colStyle" style="max-width:290px">
                                <div class="textMiddle"> Company Name Here...</div>
                            </div>
                            <div class="col colStyle" style="max-width:170px">
                                <div class="textMiddle">
                                    <div class="textMiddle ST-Customer"><i class="fa fa-circle"></i>Customer
                                    </div>
                                </div>
                            </div>

                            <div class="col colStyle _Action">
                                <div class="textMiddle">
                                    <div class="dropdown"><button class="btn dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false"> Action </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                            <button class="dropdown-item" type="button">Edit</button>
                                            <button class="dropdown-item" type="button" data-toggle="modal"
                                                data-target="#poc_detail">Active</button>
                                            <button class="dropdown-item" type="button">Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> --}}
                </div>

            </div>


            
            <div class="tab-pane fade" id="productthumb" role="tabpanel" aria-labelledby="productthumb-tab">
                <div style="min-height: 400px" class="tblLoader">
                    <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                </div>
                <div class="row PT-15 grid_view_div">
                    {{-- <div class="col-lg-3 col-md-4">
                        <div class="_product-card">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenu2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <button class="dropdown-item" type="button">Edit</button>
                                    <button class="dropdown-item" type="button" data-toggle="modal"
                                        data-target="#poc_detail">Active</button>
                                    <button class="dropdown-item" type="button">Profile</button>
                                </div>
                            </div>
                            <div class="con_info _EMP-pr">
                                <img src="images/avatar.svg" alt="">
                                <h2>Usama Ali Khan</h2>
                                <p class="ST-Customer"><i class="fa fa-circle"></i>Customer</p>
                                <p><i class="fa fa-phone-square"></i>03224584541</p>
                                <p><i class="fa fa-envelope"></i> email@company.com</p>
                                <p><i class="fa fa-building"></i>Company Name Here</p>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

        </div>
        <div class="ProductPageNav">
            <ul id="poc_holder" class="pagination holder justify-content-center">
                {{-- <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active"><a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li> --}}
            </ul>
        </div>
    </div>
</div>
@endsection
