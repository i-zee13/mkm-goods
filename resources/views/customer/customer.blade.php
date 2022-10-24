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
                {!! Form::hidden('product_updating_id', '') !!}
                @csrf
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


            </form>
            <div class="row">
                <div class="col-md-12">
                    <form id="dropzonewidgetcustImages">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
{{-- </form> --}}
</div>

<div class="_cl-bottom">
    <button type="button" class="btn btn-primary mr-2" id="saveAgency">Save</button>
    <button type="button" class="btn btn-cancel mr-2 pl-close" id="cancelAgency">Cancel</button>
</div>

</div>
</div>

<div class="poc_form">
    <div id="product-cl-sec" class="poc_form_div">
        <a class="close-btn-pl pl-close"></a>
        <div class="pro-header-text ml-0">New <span>Contact</span></div>
        <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
            <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
        </div>
        <div class="pc-cartlist">
            <form style="display: flex;" id="saveContactForm">
                @csrf
                <input hidden class="operation" name="operation" type="text" />
                <input hidden class="poc_update_id" name="poc_update_id" type="text" />

                <input hidden class="ext_card_back" name="ext_card_back" type="text" />
                <input hidden class="ext_profile" name="ext_profile" type="text" />
                <div class="overflow-plist">
                    <div class="plist-content">
                        <div class="_left-filter pt-0">
                            <div class="se_cus-type p-20 mb-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class=" border-0" style="font-size:13px">Contact Types*</label>
                                        <div class="form-s2">
                                            <select class="form-control formselect required" name="contact_type" placeholder="Select Contact Type*" id="contact_type">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="floating-label" class="card p-20 top_border">

                                            <h2 class="_head03">Contact <span>Details</span></h2>

                                            <div class="form-wrap p-0">
                                                {{-- <div class="form-wrap POC-IM">
                                                    <div class="upload-pic dropifyImgDiv"></div>
                                                </div> --}}

                                                <div class="row">
                                                    <div class="col-md-6 pt-5">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">First Name*</label>
                                                            <input type="text" class="form-control required" name="first_name" id="first_name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 pt-5">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Middle Name</label>
                                                            <input type="text" name="middle_name" class="form-control" placeholder="" id="middle_name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 pt-5">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Last Name*</label>
                                                            <input type="text" name="last_name" class="form-control required" placeholder="" id="last_name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-s2"> <label class="font12 mb-5">DOB*</label>
                                                            <div>
                                                                <input type="date" name="dob" class="form-control required" placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-s2"> <label class="font12 mb-5">Genders*</label>
                                                            <div>
                                                                <select class="form-control formselect required" name="gender_id" placeholder="Select Gender" id="genders">

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-s2"> <label class="font12 mb-5">Employment Status*</label>
                                                            <div>
                                                                <select class="form-control formselect required employement_status" name="employment_status" placeholder="Select Status">
                                                                    <option value="-1" disabled selected>Select Status</option>
                                                                    <option value="1">Freelance</option>
                                                                    <option value="2">Employeed</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 agency_id" style="display: none">
                                                        <div class="form-s2"> <label class="font12 mb-5">Agency
                                                                Name*</label>
                                                            <div>
                                                                <select class="form-control formselect agency_select" name="customer_id" placeholder="select Type">
                                                                    <option selected disabled value="-1">Select Agency
                                                                    </option>
                                                                    @foreach ($customers as $data)
                                                                    <option value="{{$data->id}}">
                                                                        {{$data->company_name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- <div class="col-md-6 pt-8">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Job Title*</label>
                                                            <input type="text" name="job_title"
                                                                class="form-control required" placeholder="">
                                                        </div>
                                                    </div> --}}

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
                                                                        <option selected disabled value="-1">Type
                                                                        </option>
                                                                        <option value="Cell Phone">Cell Phone</option>
                                                                        <option value="landline">Landline</option>
                                                                        <option value="office">Office</option>
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
                                                        <h2 class="_head03">Other Contact Info <span></span></h2>
                                                    </div>
                                                    <div class="col-md-6 pt-5">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Contact No*</label>
                                                            <input type="text" class="form-control required" name="contact_cellphone" id="contact_cellphone">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pt-5">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Official Email*</label>
                                                            <input type="text" class="form-control required" name="official_email" id="official_email">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pt-5">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Personal Email*</label>
                                                            <input type="text" class="form-control required" name="personal_email" id="personal_email">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row address_div">
                                                    <div class="col-md-12 mt-20">
                                                        <h2 class="_head03">Business Address <span></span></h2>
                                                    </div>
                                                    <div class="col-md-4 pt-5 pr-10">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Office No*</label>
                                                            <input type="text" class="form-control required" name="office_no">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 pt-5 pl-0">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Address*</label>
                                                            <input type="text" class="form-control required" name="business_address">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-s2">
                                                            <label class="font11 mb-0">Country*</label>
                                                            <div>
                                                                <select class="form-control formselect required  all_countries" placeholder="select Country" name="country_id">

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-s2">
                                                            <label class="font11 mb-0">State*</label>
                                                            <div>
                                                                <select class="form-control formselect required  all_states" placeholder="select State" name="state_id">

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 pt-5">
                                                        <div class="form-s2">
                                                            <label class="font11 mb-0">City*</label>
                                                            <div>
                                                                <select class="form-control formselect required  all_cities" placeholder="select City" name="city_id">

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 pt-5">
                                                        <div class="form-s2">
                                                            <label class="font11 mb-0">Postal Code*</label>
                                                            <div>
                                                                <select class="form-control formselect required all_postal_codes" placeholder="select Postal Code" name="postal_code">

                                                                </select>
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
                </div>
            </form>
        </div>


        <div class="_cl-bottom">
            <button type="button" class="btn btn-primary mr-2 save_poc_detail">Save</button>
            <button type="button" class="btn btn-cancel mr-2 cancel_poc pl-close">Cancel</button>
        </div>
    </div>
</div>



@endsection

@section('content')


{{-- Select Type Modal --}}
<div class="modal fade" id="poc_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input class="custom-control-input radio_status" type="radio" id="active_status" value="active" data-id="active_status" name="radio_status" checked>
                            <label class="custom-control-label head-sta" for="active_status"> Active</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh StDeactive">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="deactive_status" value="deactive" data-id="deactive_status" name="radio_status">
                            <label class="custom-control-label head-sta" for="deactive_status"> Deactive</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh StLead">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="hid002" value="lead" data-id="hid002" name="radio_status">
                            <label class="custom-control-label head-sta" for="hid002"> Lead</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh StProspect">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="hid003" value="prospect" data-id="hid003" name="radio_status">
                            <label class="custom-control-label head-sta" for="hid003"> Prospect</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh StCustomer">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="hid004" value="customer" data-id="hid004" name="radio_status">
                            <label class="custom-control-label head-sta" for="hid004"> Customer</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh STChurned">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="hid005" value="churned" data-id="hid005" name="radio_status">
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


{{-- Modal After Customer Add --}}
<div class="modal fade" id="add_poc_against_cust" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content top-border">
            <div class="modal-header statusMH">
                <h5 class="modal-title" id="exampleModalLabel">Add POC Against <span class="added_customer"> </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-20">
                <div class="row">
                    <div class="col-6 status-sh StCustomer">
                        <h2 class="_head04 border-0">Select <span> POC</span></h2>
                        <div class="form-s2">
                            <select class="form-control formselect already_added_poc_for_customer" placeholder="Select POC*">
                                <option>Select POC</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary save_poc_against_cust">Save</button>
                <button type="button" class="btn btn-primary " data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>


{{-- Modal Bulk Upload Customer --}}
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
                            <div class="row">
                                <div class="col-md-3">
                                    <select class="custom-select custom-select-sm select_type_for_bulk">
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="custom-select custom-select-sm select_acquisition_for_bulk">
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="custom-select custom-select-sm select_lifeCycle_for_bulk">
                                        <option value="0" selected disabled>Select Life Cycle*</option>
                                        <option value="customer">Customer</option>
                                        <option value="lead">Sales Lead</option>
                                        <option value="prospect">Prospect</option>
                                        <option value="dead">Dead</option>
                                    </select>
                                </div>

                            </div>
                            <a href="/download_sample_customers" class="sample_download_link"> <button type="button" class="btn btn-primary font13" style="margin-bottom:15px; margin-top: 10px">Sample
                                    Download</button></a>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload Excel</span>
                                </div>
                                <div class="custom-file">
                                    <form method="POST" enctype="multipart/form-data" id="upload_excel_form">
                                        {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
                                        @csrf
                                        <input type="file" name="file" class="custom-file-input excel_file_input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label file_name" for="inputGroupFile01">Choose
                                            file</label>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display:none" class="alert alert-danger error_message_div" role="alert"> <strong>Failed!
                        </strong> Following Customers are not added due to wrong formatting </div>
                    <div class="table-responsive not_uploadable_customers_table">
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



<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01 mb-15">Business Contact <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Business Contact</span></a></li>
            <li><span>List</span></li>
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
                        <a class="nav-item nav-link top-tabs poc_tab_top" id="nav-profile-tab" type="poc" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Contact List <span class="_cus-val count_poc"> 0 </span>
                        </a>
                    </div>
                </div>

                <div class="col">
                    <div class="Product-Filter Cus-Filter">
                        <div class="row">
                            <div class="col-auto p-0">
                                <div class="CL-Product"><i class="fa fa-search"></i>
                                    <input type="text" class="form-control dynamic_search" id="" placeholder="Search">
                                </div>
                                <div class="_cust_filter m-0" id="agency_filter">
                                    <select class="custom-select custom-select-sm dynamic_filter">
                                        <option selected="" value="0">All</option>
                                        <option value="1">Real Estate Agency</option>
                                        <option value="2">Mortgage Broker</option>
                                        <option value="3">Lender</option>
                                        <option value="4">Bank</option>
                                    </select>
                                </div>
                                <div class="_cust_filter m-0" id="poc_filter" style="display: none">
                                    <select class="custom-select custom-select-sm dynamic_filter">
                                        <option selected="" value="0">All</option>
                                        <option value="1">Freelance</option>
                                        <option value="2">Employeed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto pl-0 top_bar_customer">
                                {{-- <button class="btn btn-addproduct mb-0 bulk_upload_btn" data-toggle="modal"
                                    data-target=".bd-example-modal-lg-bulk-customer"><i class="fa fa-upload"></i> Bulk
                                    Upload </button> --}}
                                <button class="btn btn-addproduct mb-0 openDataSidebarForAddingAgency"><i class="fa fa-plus"></i> Add Agency </button>
                                <div class="nav" id="nav-tab" role="tablist"> <a class="nav-item nav-link" id="productthumb-tab" data-toggle="tab" href="#productthumb2" role="tab" aria-controls="productthumb2" aria-selected="false"><i class="fa fa-th-large"></i></a> <a class="nav-item nav-link active" id="productList2-tab" data-toggle="tab" href="#productList2" role="tab" aria-controls="productList2" aria-selected="true"><i class="fa fa-th-list"></i></a>
                                </div>
                            </div>
                            <div class="col-auto top_bar_poc" style="display:none">
                                {{-- <button class="btn btn-addproduct mb-0 bulk_upload_btn" data-toggle="modal"
                                    data-target=".bd-example-modal-lg-bulk-customer"><i class="fa fa-upload"></i> Bulk
                                    Upload </button> --}}
                                <button class="btn btn-addproduct mb-0 opensideBarToAddContact"><i class="fa fa-plus"></i>
                                    Add Contact </button>
                                <div class="nav" id="nav-tab" role="tablist"> <a class="nav-item nav-link" id="productthumb-tab" data-toggle="tab" href="#productthumb" role="tab" aria-controls="productthumb" aria-selected="false"><i class="fa fa-th-large"></i></a> <a class="nav-item nav-link active" id="productList-tab" data-toggle="tab" href="#productList" role="tab" aria-controls="productList" aria-selected="true"><i class="fa fa-th-list"></i></a>
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

    {{-- Customer --}}
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

    {{-- POC --}}
    <div class="tab-pane fade body_emp_staff" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="productList" role="tabpanel" aria-labelledby="productList-tab">

                        <div class="Product-row-title">
                            <div class="row">
                                <div class="col colStyle h-auto" style="max-width:255px">POC Name</div>
                                <div class="col colStyle h-auto" style="max-width:180px">Phone No</div>
                                <div class="col colStyle h-auto" style="max-width:200px">Email</div>
                                <div class="col colStyle h-auto" style="max-width:300px">Company</div>
                                <div class="col colStyle h-auto" style="max-width:90px">Action</div>
                            </div>
                        </div>
                        <div style="min-height: 400px" class="tblLoader">
                            <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                        </div>
                        <div class="list_view_div"> </div>
                    </div>
                    <div class="tab-pane fade" id="productthumb" role="tabpanel" aria-labelledby="productthumb-tab">
                        <div style="min-height: 400px" class="tblLoader">
                            <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                        </div>
                        <div class="row PT-15 grid_view_div"></div>
                    </div>
                </div>
                <div class="ProductPageNav text-center">
                    <div id="poc_holder" class="holder" style="position: relative;"></div>
                    {{-- <ul class="pagination justify-content-center pagination_poc">
                    </ul> --}}
                </div>
            </div>
        </div>

    </div>

</div>
@endsection