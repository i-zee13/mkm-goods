@extends('layouts.master')
@section('content')

<div class="row mt-2 mb-2">
        <div class="col-lg-6 col-md-6 col-sm-6">
          <h2 class="_head01">Client Identification <span>& Verification Form</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">          
          <button class="btn btn-primary btn-edit-p btn-edit-line">Edit Profile</button>
          <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-edit-p">Approve</button>
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
                  <p><strong>{{$form->first_name}}</strong></p>
                </div>
              </div>
              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Middle Name</label>
                  <p><strong>{{$form->middle_name}}</strong></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 p-col-L">
                <div class="infoDiv">
                  <label class="control-label mb-5">Last Name</label>
                  <p><strong>{{$form->last_name}}</strong></p>
                </div>
              </div>
              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Gender</label>
                  <p><strong>{{$form->gender_id}}</strong></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 p-col-L">
                <div class="infoDiv">
                  <label class="control-label mb-5">Date of Birth</label>
                  <p><strong>{{$form->dob}}</strong></p>
                </div>
              </div>
              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Residency Status</label>
                  <p><strong>{{$form->residence_status}}</strong></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="infoDiv">
                  <label class="control-label mb-5">Home Address</label>
                  <p><strong>{{$form->primary_address}} </strong></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 p-col-L">
                <div class="infoDiv">
                  <label class="control-label mb-5">Home Phone Number</label>
                  <p><strong>{{$form->primary_landline}}</strong></p>
                </div>
              </div>
              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Cell Phone Number</label>
                  <p><strong>{{$form->primary_cellphone}}</strong></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 p-col-L">
                <div class="infoDiv">
                  <label class="control-label mb-5">Email</label>
                  <p><strong>{{$form->email}}</strong></p>
                </div>
              </div>
              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">City</label>
                  <p><strong>{{$form->city_id}}</strong></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 p-col-L">
                <div class="infoDiv">
                  <label class="control-label mb-5">Province/State</label>
                  <p><strong>{{$form->state_id}}</strong></p>
                </div>
              </div>
              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Postal Code</label>
                  <p><strong>{{$form->postal_code_id}}</strong></p>
                </div>
              </div>
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
                  <p><strong>Employed</strong></p>
                </div>
              </div>
              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Company Name</label>
                  <p><strong>Company Name</strong></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 p-col-L">
                <div class="infoDiv">
                  <label class="control-label mb-5">Phone Number</label>
                  <p><strong>+1 254-254-5555</strong></p>
                </div>
              </div>

              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Job Titles</label>
                  <p><strong>salesman</strong></p>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="infoDiv">
                  <label class="control-label mb-5">Address</label>
                  <p><strong>1105, 57 Charles St. West, Toronto, ON</strong></p>
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
                  <p><strong>Married</strong></p>
                </div>
              </div>
              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Spouse/Partners First Name</label>
                  <p><strong>Latika</strong></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 p-col-L">
                <div class="infoDiv">
                  <label class="control-label mb-5">Spouse/Partners Middle Name</label>
                  <p><strong>Yasmin</strong></p>
                </div>
              </div>

              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Spouse/Partners Last Name</label>
                  <p><strong>Khan</strong></p>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-md-6 p-col-L">
                <div class="infoDiv">
                  <label class="control-label mb-5">Gender</label>
                  <p><strong>Female</strong></p>
                </div>
              </div>

              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Email</label>
                  <p><strong>latika@gmail.com</strong></p>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-md-6 p-col-L">
                <div class="infoDiv">
                  <label class="control-label mb-5">Home Phone Number</label>
                  <p><strong>+1 254-254-5555</strong></p>
                </div>
              </div>

              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Cell Phone Number</label>
                  <p><strong>+1 545 222 8785</strong></p>
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
                  <p><strong>Tenants in Common</strong></p>
                </div>
              </div>
              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Property status</label>
                  <p><strong>Primary Home</strong></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 p-col-L">
                <div class="infoDiv">
                  <label class="control-label mb-5">Are you a first time home buyer?</label>
                  <p><strong>Yes</strong></p>
                </div>
              </div>

              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Has your spouse ever owned a home?</label>
                  <p><strong>Yes</strong></p>
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
                  <p><strong>.</strong></p>
                </div>
              </div>
              <div class="col-md-6 p-col-R">
                <div class="infoDiv">
                  <label class="control-label mb-5">Consent to send information via email to email provided: (initial)</label>
                  <p><strong>.</strong></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="infoDiv">
                  <label class="control-label mb-5">Were YOU physically present in Canada for 183 days out of the 12-month period prior to the date the conveyance is tendered for registration? *</label>
                  <p><strong>Yes</strong></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 p-col-L">
                <div class="infoDiv">
                  <label class="control-label mb-5">Client Signature (type your name)</label>
                  <p><strong>Latika Yasmin</strong></p>
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
            <p><strong>Insurance</strong></p>
          </div>
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
            <p><strong>035415424187</strong></p>
          </div>
        </div>

        <div class="col-md-12 mb-15">
          <div class="infoDiv">
            <label class="control-label mb-5">Document Expiry</label>
            <p><strong>4/15/2024</strong></p>
          </div>
        </div>

        <div class="col-12">
          <div class="header">
            <h2>Front<span></span></h2>
          </div>
        </div>
        <div class="col-md-12 mb-20"><img style="width: 100%; height: 190px" src="images/front-s.jpg" alt=""></div>
        <div class="col-12">
          <div class="header">
            <h2>Back <span></span></h2>
          </div>
        </div>
        <div class="col-md-12"><img style="width: 100%; height: 190px" src="images/back.jpg" alt=""></div>


        <div class="col-12 PT-20">
          <div class="header line-none">
            <h2>2. Credit <span>Card </span></h2>
          </div>
        </div>
        <div class="col-md-12 mb-5">
          <div class="infoDiv">
            <label class="control-label mb-5">Document Number (ID #)</label>
            <p><strong>035415424187</strong></p>
          </div>
        </div>

        <div class="col-md-12 mb-15">
          <div class="infoDiv">
            <label class="control-label mb-5">Document Expiry</label>
            <p><strong>4/15/2024</strong></p>
          </div>
        </div>

        <div class="col-12">
          <div class="header">
            <h2>Front<span></span></h2>
          </div>
        </div>
        <div class="col-md-12 mb-20"><img style="width: 100%; height: 190px" src="images/c-card-front.jpg" alt=""></div>
        <div class="col-12">
          <div class="header">
            <h2>Back <span></span></h2>
          </div>
        </div>
        <div class="col-md-12"><img style="width: 100%; height: 190px" src="images/c-card-back.jpg" alt=""></div>


      </div>
    </div>
  </div>
</div>

<div class="col-md-12 text-right PT-30">
  <button data-toggle="modal" data-target="#exampleModal" type="submit" class="btn btn-primary mr-2">Approve</button>
  <button type="submit" class="btn btn-primary mr-2">Edit Profile</button>
  <button type="submit" class="btn btn-cancel">Cancel</button>
</div>
</div>
    @endsection