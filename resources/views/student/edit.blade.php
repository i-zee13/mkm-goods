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
</style>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="overlay-blure"></div>
    <div class="container">

      <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
          <h2 class="_head01">Student Identification <span>& Verification Form</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <ol class="breadcrumb">
            <li><a href="/students"><span>Student</span></a></li>
            <li><span>Add</span></li>
          </ol>
        </div>
      </div>

      <form id="form" enctype="multipart/form-data">
        @csrf
       
        <input type="hidden" name="added_via" value="3">
        <input type="hidden" name="status" value="2">
        <input type="hidden" name="password_created_by" value="1">
        <input type="text" id="hidden_student_id" value="{{$client->id}}" name="id" hidden>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="body pocPROFILE">
                <div class="row">
                  <div class="col-12">
                    <div class="header pt-0">
                      <h2>Student <span>Definition</span></h2>
                    </div>
                  </div>
                </div>
                <div class="se_cus-type p-20 mb-3">
                  <div class="row">



                    <div class="col-md-4">
                      <h2 class="_head04 border-0">Select <span> Acquisition Source</span>*</h2>
                      <div class="form-s2">
                        <select class="form-control formselect student_required" placeholder="Select Contact Type" name="acquisition_source">
                          <option value="0">Select Student Type</option>
                          <@foreach($acquisition_sources as $row) <option value="{{$row->id}}" {{$client->acquisition_source == $row->id ? 'Selected' : '' }}>{{$row->name}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 mb-10 ">

                      <label class="control-label mb-5">Student Code *</label>
                      <input type="text" id="" class="form-control   student_required" placeholder="" value="{{$client->student_code}}" name="student_code" id="student_code">

                    </div>
                    <div class="col-md-4">
                      <h2 class="_head04 border-0">Select <span> Account Type</span>*</h2>
                      <div class="form-s2">
                        <select class="form-control formselect student_required" placeholder="Select Account Type" name="account_type" id="account_type">
                          <option value="0">Select Account Type</option>
                          <option value="1" {{$client->account_type == 1 ? 'Selected' : ''}}>Primary</option>
                          <option value="2" {{$client->account_type == 2 ? 'Selected' : ''}}>Secondary</option>
                        </select>
                      </div>
                    </div>
                  
                    <div class="col-md-4 relation_type" >

                      <label class="control-label mb-5">Relationship Type *</label>
                      <div class="form-s2">
                        <select class="form-control formselect form_field_required" placeholder="Select Relationship" value="{{$client->relationship_type}}" name="relationship_type">
                          <option value="0">Select Relationship </option>
                          <option value="1" {{$client->relationship_type == 1 ? 'Selected' : ''}}>Father</option>
                          <option value="2" {{$client->relationship_type == 2 ? 'Selected' : ''}}>Mother</option>
                          <option value="3" {{$client->relationship_type == 3 ? 'Selected' : ''}}>Son</option>
                          <option value="4" {{$client->relationship_type == 4 ? 'Selected' : ''}}>Daughter</option>
                          <option value="5" {{$client->relationship_type == 5 ? 'Selected' : ''}}>Brother</option>
                          <option value="6" {{$client->relationship_type == 6 ? 'Selected' : ''}}>Sister</option>
                          <option value="7" {{$client->relationship_type == 7 ? 'Selected' : ''}}>Spouse</option>
                          <option value="8" {{$client->relationship_type == 8 ? 'Selected' : ''}}>Legal Partner</option>
                          <option value="9" {{$client->relationship_type == 9 ? 'Selected' : ''}}>Relative</option>
                          <option value="10" {{$client->relationship_type == 10 ? 'Selected' : ''}}>Friend</option>
                          <option value="11" {{$client->relationship_type == 11 ? 'Selected' : ''}}>Business Partner</option>
                        </select>
                      </div>

                    </div>
                  
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="header pt-0">
                      <h2>Basic Information <span>of the Primary Student:</span></h2>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-wrap p-0">

                      <div class="infoDiv p-15">
                        <div class="row">
                          <div class="col-md-4 mb-10 ">

                            <label class="control-label mb-5">First Name *</label>
                            <input type="text" id="" class="form-control first_name student_required letters" placeholder="" value="{{$client->first_name}}" name="first_name" id="first_name">

                          </div>
                          <div class="col-md-4 mb-10">

                            <label class="control-label mb-5">Middle Name *</label>
                            <input type="text" id="" class="form-control letters" placeholder="" value="{{$client->middle_name}}" name="middle_name">

                          </div>

                          <div class="col-md-4 mb-10">

                            <label class="control-label mb-5">Last Name *</label>
                            <input type="text" id="" class="form-control student_required letters" placeholder="" value="{{$client->last_name}}" name="last_name">

                          </div>



                          <div class="col-md-4 mb-10 ">

                            <label class="control-label mb-5">Gender *</label>
                            <select class="custom-select custom-select-sm student_required" id="gender" value="{{$client->gender_id}}" name="gender_id">
                              <option value="{{$client->gender_id}}">{{$client->gender}}</option>
                            </select>

                          </div>

                          <div class="col-md-4">

                            <label class="control-label mb-5">Date of Birth ( MM ,DD, YYYY) *</label>
                            <div>
                              <input id="datepicker" type="text" class="form-control student_required" value="{{$client->dob}}" name="dob">

                            </div>

                          </div>

                        </div>

                      </div>
                      <div class="row">
                        <div class="col-12 pt-10">
                          <div class="header pt-0">
                            <h2>Create <span>User</span></h2>
                          </div>
                        </div>
                      </div>
                      <div class="infoDiv p-15">

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label mb-5">Email *</label>
                              <input type="text" id="email" class="form-control student_required" placeholder="latika@gmail.com" value="{{$client->email}}" name="email">
                            </div>
                            <div class="form-group">
                              <label class="control-label mb-10">Password*</label>
                              <input type="password" name="password" class="form-control student_required" placeholder="" value="{{$client->password}}">

                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-wrap pt-19 PB-10" id="dropifyImgDiv">
                              <input type="file" name="profile_img" class="dropify" accept="image/*" value="{{$client->profile_img}}" data-default-file="/storage/{{$client->profile_img}}" data-allowed-file-extensions="jpg png jpeg JPEG" />
                              <input type="hidden" name="hidden_profile_img" value="{{$client->profile_img}}" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 pt-10">
                          <div class="header pt-0">
                            <h2>Primary <span>Contact Info</span></h2>
                          </div>
                        </div>
                      </div>

                      <div class="infoDiv p-15">

                        <div class="row">
                          <div class="col-md-4 mb-10">

                            <label class="control-label mb-5">House # *</label>
                            <input type="text" id="" class="form-control" placeholder="" value="{{$client->house_no}}" name="house_no">

                          </div>
                          <div class="col-md-8 mb-10">
                            <label class="control-label mb-5">Primary Address *</label>
                            <input type="text" id="" class="form-control form_field_required" placeholder="" value="{{$client->primary_address}}" name="primary_address">
                          </div>

                          <div class="col-md-4 mb-10">
                            <label class="control-label mb-5">Primary Cell Phone Number *</label>
                            <input type="text" id="primary_cellphone" class="form-control student_required" placeholder="" value="{{$client->primary_cellphone}}" name="primary_cellphone">
                          </div>
                          <div class="col-md-4 mb-10">
                            <label class="control-label mb-5">Secondary Number </label>
                            <input type="text" id="secondary_phone" class="form-control " placeholder="" value="{{$client->secondary_phone}}" name="secondary_phone">
                          </div>
                          <div class="col-md-4 mb-10">
                            <label class="control-label mb-5">Whatsapp Number </label>
                            <input type="text" id="whatsapp_no" class="form-control " placeholder="" value="{{$client->whatsapp_no}}" name="whatsapp_no">
                          </div>
                          <div class="col-md-4 mb-10">
                            <div class="form-s2">
                              <label class="control-label mb-5">Country *</label>
                              <select class="form-control countries formselect student_required" placeholder="Select Residency Status" id="countries" value="{{$client->country_id}}" name="country_id">

                                <option value="{{$client->country_id}}">{{$client->country}}</option>


                              </select>
                            </div>
                          </div>
                          <div class="col-md-4 mb-10">
                            <div class="form-s2">
                              <label class="control-label mb-5">State/Province *</label>

                              <select class="form-control formselect student_required" placeholder="Select Province/State" id="states" value="{{$client->state_id}}" name="state_id">
                                <option value="{{$client->state_id}}">{{$client->state}}</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4 mb-10">
                            <label class="control-label mb-5">City *</label>
                            <div class="form-s2">
                              <select class="form-control formselect student_required" placeholder="" id="cities" value="{{$client->city_id}}" name="city_id">
                                <option value="{{$client->city_id}}">{{$client->city}}</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4 mb-10">
                            <label class="control-label mb-5">Postal Code *</label>
                            <div class="form-s2">
                              <select class="form-control formselect student_required" placeholder="" id="postal_code" value="{{$client->postal_code_id}}" name="postal_code_id">
                                <option value="{{$client->postal_code_id}}">{{$client->postal_code}}</option>
                              </select>
                            </div>
                          </div>

                        </div>

                      </div>
                      <div class="col-md-12 text-right pr-0 PT-10">
                        <button type="submit" id="save" class="btn btn-primary mr-2">Update</button>
                        <a href="/clients" type="submit" class="btn btn-cancel" id="cancel">Cancel</a>
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


  </div>
</div>
@endsection