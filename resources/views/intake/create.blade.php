@extends('layouts.master')

@section('content')
<style>
  .pocPROFILE {
    font-size: 14px;
    padding: 15px 20px;
    line-height: 22px
  }

  .pocPROFILE h3 {
    font-size: 18px;
    margin: 0
  }

  .pocPROFILE h2 {
    font-size: 15px
  }

  .pocPic img {
    position: relative;
    width: 70px;
    height: 70px;
    height: auto;
    border-radius: 50%;
    -webkit-box-shadow: 0 0 20px 0 rgba(103, 92, 139, .25);
    box-shadow: 0 0 20px 0 rgba(103, 92, 139, .25);
  }

  .pocPROFILE .rightCont {
    letter-spacing: 1px;
    text-align: right
  }

  .pocPROFILE .rightCont .POCPH {
    font-size: 16px;
    display: block
  }

  .pocPROFILE .rightCont .POCPH strong {
    width: 108px;
    display: inline-block
  }

  .rightCont a {
    color: #EBB30A
  }

  .rightCont a:HOVER {
    text-decoration: underline
  }

  .pocPROFILE .form-control,
  .pocPROFILE .custom-select-sm,
  .pocPROFILE .form-s2 .select2-container .select2-selection--single,
  .phoneinput {
    box-shadow: none;
    height: 33px;
    background-color: #fff;
    border: solid 1px #e5e5e5;
    border-radius: 0;
    font-size: 13px;
  }

  .pocPROFILE .infoDiv {
    background-color: #f9f9f9;
    padding: 5px;
    margin-bottom: 8px;
  }

  .pocPROFILE .infoDiv .control-label {
    font-size: 13px;
    color: #7d7d7d !important;
    line-height: normal;
    margin-bottom: 0
  }

  .pocPROFILE .infoDiv p {
    font-size: 14px;
    color: #282828;
    line-height: normal;
    margin-bottom: 0
  }

  .pocPROFILE .p-col-L {
    padding-right: 4px
  }

  .pocPROFILE .p-col-R {
    padding-left: 4px
  }

  .ADD-border {
    border: solid 1px #ededed;
    padding: 10px 10px 4px 10px
  }

  .pocPROFILE .header {
    color: #424242;
    padding: 20px 0px;
    position: relative;
    box-shadow: none;
    background: none;
    border-bottom: solid 2px #ededed;
    margin-bottom: 5px;
    padding: 10px 0px;
  }

  .pocPROFILE .fa {
    color: #EBB30A
  }

  .POCBCard {
    width: 310px;
    height: auto
  }

  .PT-25 {
    padding-top: 25px !important
  }

  .pocPROFILE .dropify-wrapper {
    height: 150px;
    width: 100%;
  }

  .label-update {
    background: #EBB30A;
    color: #fff;
    text-align: center;
    font-size: 11px;
    line-height: 1;
    padding: 3px;
    margin-top: -24px;
    margin-left: 7px;
    z-index: 5;
    position: relative;
    width: 50px
  }

  .pocPROFILE .dropify-message p {
    letter-spacing: 0;
  }

  ._ch-pass {
    padding-top: 28px
  }

  .pocPROFILE .btn-primary,
  .pocPROFILE .btn-cancel {
    font-size: 13px
  }

  .change-password {
    box-shadow: none;
    padding: 15px;
    border: 1px solid rgba(0, 0, 0, .1);
  }

  .cp-close {
    line-height: 1;
    padding: 5px;
    position: absolute;
    right: -5px;
    top: -4px;
    opacity: .4;
    filter: grayscale(1)
  }

  .nam-title {
    font-size: 18px;
    margin-top: 15px;
    display: inline-block;
    letter-spacing: 1px
  }

  .con_info p {
    margin: 0;
    letter-spacing: 1.2px
  }

  .btn-edit-p {
    padding: 6px 14px 6px 14px;
    letter-spacing: 1px;
    font-size: 13px;
    line-height: 1;
    margin-top: -5px;
    float: right;
    margin-left: 10px
  }

  .btn-edit-line {
    color: #040725;
    background: #fff;
    border: 1px solid #040725;
  }

  .link-doc {
    border-bottom: solid 1px #EBEBEB;
    color: #282828;
    display: block;
    padding-top: 5px;
    padding-bottom: 5px;
    text-decoration: underline
  }

  .link-doc p {
    line-height: 1.3rem;
    height: 1.3rem;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    font-size: 13px;
    font-: ;
    weight: normal;
    margin-bottom: 0px
  }

  .link-doc p img {
    width: 18px;
    height: 18px;
    filter: invert();
    margin-right: 8px;
    opacity: 0.5
  }

  .btn-primary {
    letter-spacing: 1px
  }

  .line-none h2:before {
    display: none;
  }

  .date-birth input {
    width: 70px;
    margin-right: 10px;
    display: inline-block;
  }

  .addBTN-act {
    font-size: 13px;
    background-color: #040725;
    border: none;
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    border-radius: 0;
    -khtml-border-radius: 0;
    box-shadow: 2px 2px 10px 0 rgb(79 79 79 / 20%);
    padding: 6px 10px;
    color: #fff !important;
    float: right;
    cursor: pointer;
  }

  .closeBTN-d {
    background: #282828;
    border-radius: 50%;
    color: #fff;
    font-size: 14px;
    line-height: 22px;
    width: 24px;
    height: 24px;
    text-align: center;
    padding: 0;
    line-height: 1;
    border: solid 1px #282828 !important;
    outline: none;
    display: block;
    opacity: 0.5;
    margin-top: 5px;
  }

  .closeBTN-d:HOVER,
  .closeBTN-d:focus {
    opacity: 1;
    background: #f12300;
    border: solid 1px #f12300 !important;
  }

  .closeBTN-d i {
    color: #fff !important;
  }

  .phoneinput {
    padding-left: 10px;
  }

  .phone-SL {
    height: auto !important;
    margin: 0px;
  }

  .phone-SL .custom-select {
    font-size: 13px
  }

  .font11 {
    font-size: 11px;
  }

  .pt-7 {
    padding-top: 7px;
  }

  .mb-0 {
    margin-bottom: 0 !important;
  }


  .add-more-btn {
    color: #040725;
    background: linear-gradient(90deg, #e7e7e7 0%, #e7e7e7 100%);
    border: solid 1px #e7e7e7;
    box-shadow: none !important;
  }

  .pt-22 {
    padding-top: 22px !important;
  }

  /*  .disabled {
    background-color: #f5f5f5 !important;
    border: solid 1px #fff !important;
  } */

  .top-border {
    border-top: solid 2px #EBB30A;
  }

  .addBTN-act {
    padding: 3px 14px;
  }
.close{
  position:absolute; top:-3px; right:10px; z-index:5; font-size:32px
}
.close:focus{
  outline: none !important;
}
.close span{ padding: 5px; line-height: 1;
}

</style>
{{-- Modal To Remove all Data --}}

<div class="modal fade" id="deleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content top-borderRed">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remove <span></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <span> All current oprations will be removed. </span>
          <p id="modal_text">Are you sure you want to Remove?</p>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-primary confirm_delete">Yes</button>
        <button type="button" class="btn btn-cancel cancel_delete_modal" data-dismiss="modal" aria-label="Close">No</button>
      </div>
    </div>
  </div>

</div>

<div class="row mt-2 mb-3">
  <div class="col-lg-6 col-md-6 col-sm-6">
    <h2 class="_head01">Client <span>Intake Form</span></h2>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
    <ol class="breadcrumb">
      <li><a href="/clients"><span>Client</span></a></li>
      <li><span>Intake Form</span></li>
    </ol>
  </div>
</div>

<form id="form" enctype="multipart/form-data" class="">

  @csrf
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="body pocPROFILE">
          <div class="row">


            <div class="col-12">
              <div class="header pt-0">
                <h2>Intake Form <span>Definition</span></h2>
              </div>
            </div>
          </div>
          <div class="se_cus-type p-20 mb-3">
            <div class="row">

              <div class="col-md-4">
                <h2 class="_head04 border-0">Select <span> Form Type</span>*</h2>
                <div class="form-s2">
                  <select class="form-control formselect  " value="" placeholder="Select Contact Type" name="intake_form_type" id="intake_form_type" data-toggle="modal" data-target="#deleModal">
                    <option value="0">Select Form Type</option>
                    @foreach($intakeformtypes as $key=>$data)
                    <option value="{{$data->id}}">{{$data->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <h2 class="_head04 border-0">Select <span> Client Type </span>*</h2>
                <div class="form-s2">
                  <select class="form-control formselect " placeholder="Select Contact Type" name="client_type" id="client_type">
                    <option value="0">Select Client Type</option>
                    <option value="1">Exisiting</option>
                    <option value="2">New</option>
                  </select>
                </div>
              </div>

              <div class="col-md-4 client" style="display:none;">
                <h2 class="_head04 border-0">Select <span>Clients</span>*</h2>
                <div class="form-s2">
                  <select class="form-control formselect existing_client form_clear" name="existing_client" id="existing_client">
                    <option value="0"> Select Clients*</option>
                    @foreach($clients as $client)
                      <option value="{{$client->id}}">{{$client->first_name}} {{$client->last_name}}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <input type="text" id="" class="form-control " value="1" name="form_status" hidden>

            <div class="col-12">

              <div class="property_info" style="display: none;">
                <div class="row">
                  <div class="col-12 pt-10">
                    <div class="header pt-0">
                      <h2> Property <span>Information</span></h2>
                    </div>
                  </div>
                </div>

                <div class="infoDiv p-15">

                  <div class="row ">
                    <div class="col-md-4 mb-10">

                      <label class="control-label mb-5">Property *</label>
                      <div class="form-s2">
                        <select class="form-control formselect required " placeholder="Select Status" name="property_type_id" id="property_type_id">
                          <option value="0">Select Property </option>
                          @foreach($property_type as $data)
                          <option value="{{$data->id}}">{{$data->property_name}}</option>

                          @endforeach

                        </select>

                      </div>
                    </div>
                    <div class="col-md-2 mb-10">

                      <label class="control-label mb-5">Unit # *</label>
                      <input type="text" id="" class="form-control required" placeholder="" name="unit">

                    </div>
                    <div class="col-md-6 mb-10">

                      <label class="control-label mb-5">Street Address *</label>
                      <input type="text" id="" class="form-control required" placeholder="" name="street_address">
                    </div>

                    <div class="col-md-4 mb-10">
                      <div class="form-s2">
                        <label class="control-label mb-5">Country *</label>
                        <select class="form-control countries formselect required" placeholder="Select Residency Status" id="countries" name="country_id">

                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 mb-10">
                      <div class="form-s2">
                        <label class="control-label mb-5">State/Province *</label>

                        <select class="form-control formselect required" placeholder="Select Province/State" id="states" name="state_id">

                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 mb-10">
                      <label class="control-label mb-5">City *</label>
                      <div class="form-s2">
                        <select class="form-control formselect required" placeholder="" id="cities" name="city_id">

                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 mb-10">
                      <label class="control-label mb-5">Postal Code</label>
                      <div class="form-s2">
                        <select class="form-control formselect required" placeholder="" id="postal_code" name="postal_code_id">

                        </select>
                      </div>
                    </div>

                  </div>

                </div>
              </div>
            </div>


            <div class="col-12">

              <div class="form-wrap p-0">

                <div class=" show_existing_div" style="display: none">
                  <div class="col-12">
                    <div class="header pt-0">
                      <h2>Basic Information<span>of the Exisiting Client:</span></h2>
                    </div>
                  </div>
                  <div class=" p-15 show_existing_div" style="display:none">
                    <div class="row">
                      <div class="col-md-12 productRate-table m-0 body_existing_client mt-20 mb-30">
                        <table class="table table-hover dt-responsive nowrap" id="designationsTable" style="width:100%;">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Name </th>
                              <th>Email</th>

                              <th>Cellphone</th>
                              <th>Address</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                   

                    </div>
                  </div>
                </div>

                <div class="col-12 p-0">


                  <form id="add_more_form">
                    @csrf
                    <div class="collapse w-100" id="collapseExample">
                      <div class="infoDiv p-15 add_new  mb-0 top-border">
                        <div class="row">
                          <div class="col-12 position-relative">
                            <button type="button" class="close" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="_head03">New Basic Information</h2>
                          </div>

                          <div class="col-md-4 mb-10 ">

                            <label class="control-label mb-5">First Name *</label>
                            <input type="text" class="form-control first_name  required_client new_form_field " placeholder="" name="new_first_name" id="new_first_name">

                          </div>
                          <div class="col-md-4 mb-10">

                            <label class="control-label mb-5">Middle Name  </label>
                            <input type="text" id="new_middle_name" class="form-control  new_form_field " placeholder="" name="new_middle_name">

                          </div>

                          <div class="col-md-4 mb-10">

                            <label class="control-label mb-5">Last Name  </label>
                            <input type="text" id="new_last_name" class="form-control   new_form_field " placeholder="" name="new_last_name">

                          </div>

                          <!-- <div class="col-md-4">

                            <label class="control-label mb-5">Date of Birth (YYYY, MM ,DD ) </label>
                            <div>
                              <input autocomplete="off" id="datepicker2" type="text" class="form-control new_dob new_form_field " name="new_dob">

                            </div>

                          </div> -->


                          <div class="col-md-4 mb-10">
                            <label class="control-label mb-5">Email *</label>
                            <input type="text" id="new_email" class="form-control   new_form_field" placeholder="email@email.com" name="new_email">
                          </div>
<!-- 
                          <div class="col-md-4 mb-10">
                            <label class="control-label mb-5">Primary Cell Phone Number  </label>
                            <input type="text" id="new_primary_cellphone" class="form-control  new_form_field" placeholder="" name="new_primary_cellphone">
                          </div>

                          <div class="col-md-4 mb-10 ">

                            <label class="control-label mb-5">Gender  </label>
                            <div class="form-s2">
                              <select class="custom-select custom-select-sm  form-control   formselect new_form_field" id="new_gender_id" name="new_gender_id" value="">
                                <option value="0">Select Gender </option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4 mb-10">

                            <label class="control-label mb-5">Residency Status </label>
                            <div class="form-s2">
                              <select class="form-control formselect  " placeholder="Select Status" name="new_residence_status" id="new_residence_status">
                                <option value="0">Select Residnce </option>
                                @foreach($residence_status as $data)
                                <option value="{{$data->id}}" data-residence_name="{{$data->residence_name}}">{{$data->residence_name}}</option>

                                @endforeach

                              </select>

                            </div>
                          </div>

                          <div class="col-md-4">
                            <label class="control-label mb-5">Marital Status </label>
                            <div class="form-s2">
                              <select class="form-control formselect new_form_dropdown" placeholder="Select Status" name="new_marital_status" id="new_marital_status">
                                <option value="0">Select Status </option>
                                <option value="2">Single</option>
                                <option value="1">Married</option>
                                <option value="3">Legal Partners</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label class="control-label mb-5">Employment Status </label>
                            <div class="form-s2">
                              <select class="form-control formselect new_form_dropdown " placeholder="Select Employed" name="new_employment_status" id="new_employment_status">
                                <option value="0">Select Status</option>
                                <option value="1">Employed</option>
                                <option value="2">Not Employed</option>
                                <option value="3">Self Employed</option>
                              </select>
                            </div>
                          </div> -->

                        </div>

                      </div>
                    </div>
                    <button class="btn btn-primary w-100 add-more-btn add_more_client" data-toggle="collapse" href="#collapseExample" role="button" aria-controls="collapseExample" style="display:none"><i class="fa fa-plus"></i> Add More</button>
                  </form>


                </div>


                <div class="col-md-12 mt-25 p-0 detail_form">



                </div>



                <div class="col-md-12 text-right pr-0 PT-10" id="btns_div" style="display: none ;">
                  <button type="submit" id="save" class="btn btn-primary mr-2">Save</button>
                  <a href="/intake-forms" type="submit" class="btn btn-cancel" id="cancel">Cancel</a>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>

    </div>





  </div>
</form>




@endsection
@push('js')
<script>
var clients = JSON.parse('{!! json_encode($clients)  !!}');

</script>
@endpush
