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

 

      <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
          <h2 class="_head01">Client Identification <span>& Verification Form</span></h2>
        </div>

      </div>
      <div class="row" id="table_row">
        <div class="col-md-12">
          <div class="card">
            <div class="header">
              <a id="add_clients" href="#" class="btn add_button"><i class="fa fa-plus"></i> <span> New Contact</span></a>
              <h2>Contact <span> List</span></h2>
            </div>
            <div style="min-height: 400px" id="loader">
              <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body_clients" style="display: none">
            </div>
          </div>
        </div>
      </div>

      <form id="form" enctype="multipart/form-data" style="display:none">

        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="body pocPROFILE">
                <div class="row">


                  <div class="col-12">
                    <div class="header pt-0">
                      <h2>Client <span>Definition</span></h2>
                    </div>
                  </div>
                </div>
                <div class="se_cus-type p-20 mb-3">
                  <div class="row">


                    <div class="col-md-4">
                      <h2 class="_head04 border-0">Select <span> Contact Type</span></h2>
                      <div class="form-s2">
                        <select class="form-control formselect" placeholder="Select Contact Type">
                          <option>Select Contact Type</option>
                          <option value="0">Client</option>
                          <option value="1">Realtor</option>
                          <option value="2">Mortgage agent</option>

                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <h2 class="_head04 border-0">Select <span> Acquisition Source</span></h2>
                      <div class="form-s2">
                        <select class="form-control formselect" placeholder="Select Contact Type">
                          <option>Select Contact Type</option>
                          <option>Contact Type 1</option>
                          <option>Contact Type 2</option>
                          <option>Contact Type 3</option>
                          <option>Contact Type 4</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <h2 class="_head04 border-0">Select <span> Life Cycle Stage*</span></h2>
                      <div class="form-s2 ">
                        <select class="form-control formselect">
                          <option> Select Life Cycle Stage*</option>
                          <option value="0">Lead</option>
                          <option value="1">Prospect</option>
                          <option value="2">Client</option>
                          <option value="3">Churned</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="header pt-0">
                      <h2>Basic Information <span>of the Primary Client:</span></h2>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-wrap p-0">

                      <div class="infoDiv p-15">
                        <div class="row">
                          <div class="col-md-4 mb-10 ">

                            <label class="control-label mb-5">First Name</label>
                            <input type="text" id="" class="form-control first_name" placeholder="" name="first_name" id="first_name">

                          </div>
                          <div class="col-md-4 mb-10">

                            <label class="control-label mb-5">Middle Name</label>
                            <input type="text" id="" class="form-control" placeholder="" name="middle_name">

                          </div>

                          <div class="col-md-4 mb-10">

                            <label class="control-label mb-5">Last Name</label>
                            <input type="text" id="" class="form-control" placeholder="" name="last_name">

                          </div>



                          <div class="col-md-4 mb-10 ">

                            <label class="control-label mb-5">Gender</label>
                            <select class="custom-select custom-select-sm" id="gender" name="genders_id">

                            </select>

                          </div>

                          <div class="col-md-4">

                            <label class="control-label mb-5">Date of Birth ( MM ,DD, YYYY)</label>
                            <div>
                              <input type="date" class="form-control" name="dob">

                            </div>

                          </div>
                          <div class="col-md-4 mb-10">

                            <label class="control-label mb-5">Residency Status</label>
                            <input type="text" id="" class="form-control" placeholder="" name="residence_status">

                          </div>
                          <div class="col-md-4 mb-10">

                            <label class="control-label mb-5">House #</label>
                            <input type="text" id="" class="form-control" placeholder="" name="house_no">

                          </div>
                          <div class="col-md-4">
                            <div class="infoDiv">
                              <label class="control-label mb-5">Marital Status</label>
                              <div class="form-s2">
                                <select class="form-control formselect" placeholder="Select Status">
                                  <option>Single</option>
                                  <option selected>Married</option>
                                  <option>Legal Partners</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="infoDiv">
                              <label class="control-label mb-5">Employment Status</label>
                              <div class="form-s2">
                                <select class="form-control formselect" placeholder="Select Employed">
                                  <option>Employed</option>
                                  <option>Not Employed</option>
                                  <option>Self Employed</option>
                                </select>
                              </div>
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
                            <label class="control-label mb-5">Primary Landline Number</label>
                            <input type="text" id="" class="form-control" placeholder="" name="home_phone_number">
                          </div>
                          <div class="col-md-4 mb-10">
                            <label class="control-label mb-5">Primary Cell Phone Number</label>
                            <input type="text" id="" class="form-control" placeholder="" name="cell_phone_number">
                          </div>
                          <div class="col-md-4 mb-10">
                            <label class="control-label mb-5">Email</label>
                            <input type="text" id="" class="form-control" placeholder="latika@gmail.com" name="email">
                          </div>
                          <div class="col-md-4 mb-10">
                            <div class="form-s2">
                              <label class="control-label mb-5">Country</label>
                              <select class="form-control countries formselect" placeholder="Select Residency Status" id="countries" name="countries_id">

                              </select>
                            </div>
                          </div>
                          <div class="col-md-4 mb-10">
                            <div class="form-s2">
                              <label class="control-label mb-5">State/Province</label>

                              <select class="form-control formselect" placeholder="Select Province/State" id="states" name="states_id">

                              </select>
                            </div>
                          </div>
                          <div class="col-md-4 mb-10">
                            <label class="control-label mb-5">City</label>
                            <div class="form-s2">
                              <select class="form-control formselect" placeholder="" id="cities" name="cities_id">

                              </select>
                            </div>
                          </div>
                          <div class="col-md-4 mb-10">
                            <label class="control-label mb-5">Postal Code</label>
                            <input type="text" id="" class="form-control" placeholder="" name="postal_code">
                          </div>

                        </div>

                      </div>
                      <div class="col-md-12 text-right pr-0 PT-10">
                        <button type="submit" id="submit" class="btn btn-primary mr-2">Save</button>
                        <button type="submit" class="btn btn-cancel" id="cancel">Cancel</button>
                      </div>

                    </div>
                  </div>

                  <div class="col-12">
                    <div class="header">
                      <h2>Employment <span>Information</span></h2>
                    </div>
                  </div>
                  <div class="col-12 mb-15">
                    <div class="form-wrap p-0">
                      <div class="row">
                        <div class="col-md-6 p-col-L">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Occupation</label>
                            <div class="form-s2">
                              <select class="form-control formselect" placeholder="Select Employed">
                                <option>Employed</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6 p-col-R">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Company Name</label>
                            <input type="text" id="" class="form-control" placeholder="" name="">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 p-col-L">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Phone Number</label>
                            <input type="text" id="" class="form-control" placeholder="+1 254-254-555" name="">
                          </div>
                        </div>

                        <div class="col-md-6 p-col-R">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Job Title</label>
                            <input type="text" id="" class="form-control" placeholder="Salesman" name="">
                          </div>
                        </div>

                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Address</label>
                            <input type="text" class="form-control" placeholder="" name="">
                          </div>
                        </div>

                      </div>

                    </div>
                  </div>





                  <div class="col-12">
                    <div class="header">
                      <h2>Marital <span>Status</span></h2>
                    </div>
                  </div>
                  <div class="col-12 mb-15">
                    <div class="form-wrap p-0">
                      <div class="row">
                        <div class="col-md-6 p-col-L">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Marital Status</label>
                            <select class="custom-select custom-select-sm">
                              <option>Single</option>
                              <option selected>Married</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 p-col-R">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Spouse/Partners First Name</label>
                            <input type="text" class="form-control" placeholder="Latika" name="">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 p-col-L">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Spouse/Partners Middle Name</label>
                            <input type="text" class="form-control" placeholder="" name="">
                          </div>
                        </div>

                        <div class="col-md-6 p-col-R">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Spouse/Partners Last Name</label>
                            <input type="text" class="form-control" placeholder="" name="">
                          </div>
                        </div>

                      </div>

                      <div class="row">
                        <div class="col-md-6 p-col-L">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Gender</label>
                            <select class="custom-select custom-select-sm" id="gender">

                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 p-col-R">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Email</label>
                            <input type="text" class="form-control" placeholder="latika@gmail.com" name="">
                          </div>
                        </div>

                      </div>

                      <div class="row">
                        <div class="col-md-6 p-col-L">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Home Phone Number</label>
                            <input type="text" class="form-control" placeholder="+1 254-254-5555" name="">
                          </div>
                        </div>

                        <div class="col-md-6 p-col-R">
                          <div class="infoDiv">
                            <label class="control-label mb-5">Cell Phone Number</label>
                            <input type="text" class="form-control" placeholder="+1 545 222 8785" name="">
                          </div>
                        </div>

                      </div>

                    </div>

                  </div>

                </div>
              </div>
            </div>

          </div>

          <!-- <div class="col-md-4">
            <div class="card">
              <div class="body pocPROFILE">
                <div class="row">
                  <div class="col-12">
                    <div class="header pt-0">
                      <h2>Client ID <span>Documents</span></h2>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="header line-none">
                      <h2>1. Permanent <span>Residency Card </span></h2>
                    </div>
                  </div>
                  <div class="col-md-12 mb-5">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Document Number (ID #)</label>
                      <input type="text" class="form-control" placeholder="" name="">
                    </div>
                  </div>

                  <div class="col-md-12 mb-15">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Document Expiry</label>
                      <input type="text" class="form-control datepicker" autocomplete="off" placeholder="">
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="header">
                      <h2>Front and Back<span></span></h2>
                    </div>
                  </div>

                  <div class="col-md-12 mb-20">
                    <div class="form-wrap p-0">
                      <label class="font11 mb-5">Frontside Upload</label>
                      <div class="upload-pic"></div>
                      <input type="file" id="input-file-now" data-default-file="images/front-s.jpg" class="dropify " />
                    </div>
                  </div>
                  <div class="col-md-12 mb-20">
                    <div class="form-wrap p-0">
                      <label class="font11 mb-5">Backside Upload</label>
                      <div class="upload-pic"></div>
                      <input type="file" id="input-file-now" data-default-file="images/back.jpg" class="dropify" />
                    </div>
                  </div>



                  <div class="col-12 PT-20">
                    <div class="header line-none">
                      <h2>2. Credit <span>Card </span></h2>
                    </div>
                  </div>
                  <div class="col-md-12 mb-5">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Document Number (ID #)</label>
                      <input type="text" class="form-control" placeholder="">
                      <p><strong></strong></p>
                    </div>
                  </div>

                  <div class="col-md-12 mb-15">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Document Expiry</label>
                      <input type="text" class="form-control datepicker" autocomplete="off" placeholder="">
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="header">
                      <h2>Front and Back<span></span></h2>
                    </div>
                  </div>

                  <div class="col-md-12 mb-20">
                    <div class="form-wrap p-0">
                      <label class="font11 mb-5">Frontside Upload</label>
                      <div class="upload-pic"></div>
                      <input type="file" id="input-file-now" data-default-file="images/c-card-front.jpg" class="dropify " />
                    </div>
                  </div>
                  <div class="col-md-12 mb-20">
                    <div class="form-wrap p-0">
                      <label class="font11 mb-5">Backside Upload</label>
                      <div class="upload-pic"></div>
                      <input type="file" id="input-file-now" data-default-file="images/c-card-back.jpg" class="dropify" />
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div> -->

          <div class="col-md-12 text-right PT-30">
            <button type="submit" id="submit" class="btn btn-primary mr-2">Save</button>
            <button type="submit" class="btn btn-cancel" id="cancel">Cancel</button>
          </div>

        </div>
      </form>
 
@endsection