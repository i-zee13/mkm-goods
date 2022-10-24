
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
	-webkit-box-shadow: 0 0 20px 0 rgba(103,92,139,.25);
	box-shadow: 0 0 20px 0 rgba(103,92,139,.25);
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
.pocPROFILE .form-control, .pocPROFILE .custom-select-sm, .pocPROFILE .form-s2 .select2-container .select2-selection--single {
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
	color: #7d7d7d!important; line-height: normal;
	margin-bottom: 0
}
.pocPROFILE .infoDiv p {
	font-size: 14px;
	color: #282828; line-height: normal;
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
	padding-top: 25px!important
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
	margin-top: -24px; margin-left:7px;  
	z-index: 5;
	position: relative; width: 50px
}
.pocPROFILE .dropify-message p {
	letter-spacing: 0;
}
._ch-pass {
	padding-top: 28px
}
.pocPROFILE .btn-primary, .pocPROFILE .btn-cancel {
	font-size: 13px
}
.change-password {
	box-shadow: none;
	padding: 15px;
	border: 1px solid rgba(0,0,0,.1);
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
.nam-title{font-size: 18px; margin-top: 15px; display: inline-block; letter-spacing: 1px}
.con_info p{margin: 0; letter-spacing: 1.2px}
.btn-edit-p{padding: 6px 14px 6px 14px;letter-spacing: 1px;font-size: 13px;line-height: 1; margin-top: -5px; float: right; margin-left: 10px}
.btn-edit-line {
    color: #040725;
    background: #fff;
    border: 1px solid #040725;
}
.link-doc{border-bottom: solid 1px #EBEBEB; color: #282828; display:block; padding-top:5px; padding-bottom:5px;text-decoration:underline}
.link-doc p{line-height:1.3rem; height:1.3rem; overflow:hidden; text-overflow:ellipsis; -webkit-box-orient:vertical; -webkit-line-clamp:1; font-size:13px; font-: 		;weight:normal; margin-bottom: 0px
}
.link-doc p img	{width:18px; height:18px; filter: invert(); margin-right:8px; opacity: 0.5}
.btn-primary{letter-spacing: 1px}
	
.line-none h2:before {
   display: none;
}
.date-birth input{width: 70px;margin-right: 10px; display: inline-block;}
</style>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content top_border">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center">Verification <span>Form Approve</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body confir_pay">
        <div class="check_mark">
          <div class="sa-icon sa-success animate"> <span class="sa-line sa-tip animateSuccessTip"></span> <span class="sa-line sa-long animateSuccessLong"></span>
            <div class="sa-placeholder"></div>
            <div class="sa-fix"></div>
          </div>
        </div>
        <p align="center"><strong>Are you sure you want to approve verification form?</strong></p>
      </div>
      <div class="modal-footer border-0">
        <div style="display: block; text-align: center; margin: auto">
          <button type="button" class="btn btn-primary">Yes</button>
          <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">No</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- {{dd($form)}} -->
    <div class="overlay-blure"></div>
   
      <div class="row mt-2 mb-2">
        <div class="col-lg-6 col-md-6 col-sm-6">
          <h2 class="_head01">Client Identification <span>& Verification Form</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <button type="submit" class="btn btn-primary btn-edit-p btn-cancel">Cancel</button>
            <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-edit-p">Save</button>
        </div>
      </div>
      <div class="row">

        <div class="col-md-8">
          <div class="card">
            <div class="body pocPROFILE">
              <div class="row">
                <div class="col-12">
                  <div class="header pt-0">
                    <h2>Basic Information  <span>of the Primary Client:</span></h2>
                  </div>
                </div>
            
                <div class="col-12">
                  <div class="form-wrap p-0">
                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">First Name</label>
							<input type="text" id="" class="form-control" placeholder="" value="{{$form->first_name}}">
                        </div>
                      </div>
                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Middle Name</label>
							<input type="text" id="" class="form-control" placeholder="" value="{{$form->middle_name}}">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Last Name</label>
							<input type="text" id="" class="form-control" placeholder="" value="{{$form->last_name}}">
                        </div>
                      </div>
                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Gender</label>
                            <select class="custom-select custom-select-sm">
                                @foreach($genders as $gender) 
                                <option value="{{$gender->id}}">{{$gender->gender_name}}</option>
                                @endforeach
                                </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv date-birth">
                          <label class="control-label mb-5">Date of Birth (DD, MM, YYYY)</label>
                          <div class="form-group">
                          <input type="text" id="datepicker" name="dob" class="form-control form-datepicker required_client"
                                        style="font-size: 13px" value="{{$form->dob}}">
                                                       
                          </div> 
                        </div>
                      </div>
                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Residency Status</label>
                          <div class="form-s2">
                          <select class="form-control formselect client_required " placeholder="Select Status" name="residence_status">
                          <option value="0">Select Residnce </option>
                          @foreach($residences as $row)
                          <!-- {{$row->id == $form->residence_status   ? "selected" : ""}} -->
                          <option value="{{$row->id}}"  >{{$row->residence_name}}</option>
                          @endforeach
                        </select>
                           </div> 
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Home Address</label>
							<input type="text" id="" class="form-control" placeholder="" value="{{$form->primary_address}}">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Home Phone Number</label>
						  <input type="text" id="" class="form-control" placeholder="" value="{{$form->primary_landline}}">
                        </div>
                      </div>
                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Cell Phone Number</label>
						  <input type="text" id="" class="form-control" placeholder="" value="{{$form->primary_cellphone}}">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Email</label>
						  <input type="text" id="" class="form-control"  value="{{$form->email}}">
                        </div>
                      </div>
                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">City</label>
                          <div class="form-s2">
                            <select class="form-control formselect" placeholder="Select City">
                              <option>Toronto</option>                              
                             </select>
                         </div> 
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Province/State</label>
                          <div class="form-s2">
                            <select class="form-control formselect" placeholder="Select Province/State">
                              <option>Ontario</option>                              
                             </select>
                         </div> 
                          <p><strong></strong></p>
                        </div>
                      </div>
                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Postal Code</label>
						  <input type="text" id="" class="form-control" placeholder="" value="V3W15N">
                        </div>
                      </div>
                    </div>

 
                  </div>
                </div>
                @if($form->intake_form_type <= 4) @if($form->employment_status == 1 || $form->employment_status == 3)
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
						  <input type="text" id="" class="form-control" placeholder="" value="Company Name">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Phone Number</label>
						  <input type="text" id="" class="form-control" placeholder="" value="+1 254-254-5555">
                        </div>
                      </div>

                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Job Titles</label>
						  <input type="text" id="" class="form-control" placeholder="" value="salesman">
                        </div>
                      </div>

                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Address</label>
						  <input type="text" class="form-control" placeholder="" value="1105, 57 Charles St. West, Toronto, ON">
                        </div>
                      </div> 
                      
                    </div>

                  </div>
                </div>
                    @endif
      



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
						  <input type="text" class="form-control" placeholder="" value="Latika">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Spouse/Partners Middle Name</label>
						  <input type="text" class="form-control" placeholder="" value="Yasmin">
                        </div>
                      </div>

                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Spouse/Partners Last Name</label>
						  <input type="text" class="form-control" placeholder="" value="Khan">
                        </div>
                      </div>

                    </div>

                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Gender</label>
                          <select class="custom-select custom-select-sm">
                            <option>Male</option>
                            <option selected>Female</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Email</label>
						  <input type="text" class="form-control" placeholder="" value="latika@gmail.com">
                        </div>
                      </div>

                    </div>

                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Home Phone Number</label>
						  <input type="text" class="form-control" placeholder="" value="+1 254-254-5555">
                        </div>
                      </div>

                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Cell Phone Number</label>
						  <input type="text" class="form-control" placeholder="" value="+1 545 222 8785">
                        </div>
                      </div>

                    </div>

                  </div>
                </div>


                <div class="col-12">
                  <div class="header">
                    <h2>Capacity <span></span></h2>
                  </div>
                </div>
                <div class="col-12 mb-15">
                  <div class="form-wrap p-0">
                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Tenancy Type</label>
                          <select class="custom-select custom-select-sm">
                            <option>Tenants in Common</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Property status</label>
                          <select class="custom-select custom-select-sm">
                            <option>Primary Home</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Are you a first time home buyer?</label>
                          <select class="custom-select custom-select-sm">
                            <option>Yes</option>
                            <option>No</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Has your spouse ever owned a home?</label>
                          <select class="custom-select custom-select-sm">
                            <option>Yes</option>
                            <option>No</option>
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>



                <div class="col-12">
                  <div class="header">
                    <h2>Consent <span>& Sign-off</span></h2>
                  </div>
                </div>
                <div class="col-12 mb-15">
                  <div class="form-wrap p-0">
                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Consent to Electronically share the info with bank and Title insurance as required</label>
						  <input type="text" class="form-control" placeholder="" value="">
                        </div>
                      </div>
                      <div class="col-md-6 p-col-R">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Consent to send information via email to email provided: (initial)</label>
                          <input type="text" class="form-control" placeholder="" value="">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Were YOU physically present in Canada for 183 days out of the 12-month period prior to the date the conveyance is tendered for registration? *</label>
                          <input type="text" class="form-control" placeholder="" value="">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 p-col-L">
                        <div class="infoDiv">
                          <label class="control-label mb-5">Client Signature (type your name)</label>
                          <input type="text" class="form-control" placeholder="" value="">
                        </div>
                      </div> 
                    </div>


                  </div>
                </div>

                <div class="col-12">
                  <div class="header">
                    <h2>Required <span>Document</span></h2>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Property Insurance</label>
                      <select class="custom-select custom-select-sm">
                        <option>Insurance</option>
                        <option>Insurance</option>
                      </select>
                  </div>
                </div>

                <div class="col-md-12 PB-10">
				    <label class="font11 mb-5">Upload Documents</label>
                        <form action="#" class="dropzone" id="my-awesome-dropzone">
                          <div class="fallback">
                            <input name="file" type="file" multiple />
                          </div>
                        </form> 
			   </div>  

                <div class="col-12 mb-15">
                  <div class="row PT-10">
                    <div class="col-md-6"> <a href="#" class="link-doc">
                      <p><img src="images/activity-icon.svg" alt="">Mortgage-Instructions.jpg</p>
                      </a> </div>
                    <div class="col-md-6"> <a href="#" class="link-doc">
                      <p><img src="images/activity-icon.svg" alt="">Void-Cheque.jpg</p>
                      </a> </div>
                    <div class="col-md-6"> <a href="#" class="link-doc">
                      <p><img src="images/activity-icon.svg" alt="">document-file-name-45454-54.jpg</p>
                      </a> </div>
                    <div class="col-md-6"> <a href="#" class="link-doc">
                      <p><img src="images/activity-icon.svg" alt="">document-file-name-name-here.jpg</p>
                      </a> </div>
                  </div>
                </div> 
              @endif
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
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
                    <input type="text" class="form-control" placeholder="" value="035415424187">
                  </div>
                </div>

                <div class="col-md-12 mb-15">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Document Expiry</label>
                    <input type="text" class="form-control datepicker" autocomplete="off" placeholder="4/15/2024">
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
                    <input type="text" class="form-control" placeholder="035415424187">
                    <p><strong></strong></p>
                  </div>
                </div>

                <div class="col-md-12 mb-15">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Document Expiry</label>
                    <input type="text" class="form-control datepicker" autocomplete="off" placeholder="4/15/2024">
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
        </div>

        <div class="col-md-12 text-right PT-30">
          <button data-toggle="modal" data-target="#exampleModal" type="submit" class="btn btn-primary mr-2">Save</button>
          <button type="submit" class="btn btn-cancel">Cancel</button>
        </div>
      </div>
    
  
@endsection
