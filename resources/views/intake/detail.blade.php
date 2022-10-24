@extends('layouts.master')
@section('content')

<style>
  .addBTN-act {

    font-size: 13px;
    background-color: #ececec;
    border: none;
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    border-radius: 0;
    -khtml-border-radius: 0;
    box-shadow: none !important;
    padding: 3px 12px;
    color: #040725 !important;
    float: right;
    cursor: pointer;
  }

  .cnicCardimg {
    width: 500px;
    height: auto;
    display: block;
    margin: 15px auto;
  }

  .btn-success,
  .btn-success:hover,
  .btn-success:focus {
    border: solid 1px #28a745 !important;
    color: #fff;
    background: linear-gradient(90deg, #28a745 0%, #28a745 100%);
  }

  .link-doc {
    cursor: pointer;
    color: #040725;
    text-decoration: underline !important;
    opacity: 0.6;

  }

  .link-doc:hover {
    color: #040725 !important;

    opacity: 1;
  }
</style>

<div class="modal fade preview" id="ViewDocumentImg" tabindex="-1" role="dialog" aria-labelledby="DetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content top_border">
      <div class="modal-header">
        <h5 class="modal-title" id="DetailModalLabel">Document <span> Preview</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">

        </div>
      </div>
      <div class="modal-footer border-0 p-10">
        <a href="" class="btn btn-primary btn_modal_download" download>Download</a>
        <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="row mt-2 mb-2">
  <div class="col-lg-6 col-md-6 col-sm-6">
    <h2 class="_head01">Client <span>Intake Form</span></h2>
  </div>

  <div class="col-lg-6 col-md-6 col-sm-6">
    <ol class="breadcrumb">
      <li>
        <a href="/clients"><span>Client</span></a>
      </li>
      <li><span>Intake</span></li>
    </ol>

    <!-- <input type="hidden" value="{{$form->status}}" id="form_status"> -->
    <input type="hidden" value="{{$form_id}}" id="form_id">

  </div>
</div>
<div class="row">

  <div class="col-md-8">
    <div class="card">
      <div class="body pocPROFILE">
        <div class="row">
          <div class="col-12">
            <div class="header pt-0">
              <h2>Basic Information <span>of Client:</span></h2>
            </div>
          </div>

          <div class="col-12">
            <div class="form-wrap p-0">
              <div class="row">
                <div class="col-md-6 p-col-L">
                  <div class="infoDiv">
                    <label class="control-label mb-5">First Name</label>
                    <p><strong>{{$form->first_name ? $form->first_name : 'NA' }}</strong></p>
                  </div>
                </div>
                <div class="col-md-6 p-col-R">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Middle Name</label>
                    <p><strong>{{$form->middle_name ? $form->middle_name : 'NA'}}</strong></p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 p-col-L">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Last Name</label>
                    <p><strong>{{$form->last_name ? $form->last_name :'NA'}}</strong></p>
                  </div>
                </div>
                <div class="col-md-6 p-col-R">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Gender</label>
                    <p><strong>{{$form->gender}}</strong></p>
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
                    <p><strong>{{$form->residence ? $form->residence : 'NA'}}</strong></p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Home Address</label>
                    <p><strong>{{$form->primary_address ? $form->primary_address : 'NA'}} </strong></p>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 p-col-L">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Home Phone Number</label>
                    <p><strong>{{$form->primary_landline ? $form->primary_landline : 'NA'}}</strong></p>
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
                    <label class="control-label mb-5">Country</label>
                    <p><strong>{{$form->country ? $form->country : 'NA' }}</strong></p>
                  </div>
                </div>
              </div>

              <div class="row">

                <div class="col-md-6 p-col-L">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Province/State</label>
                    <p><strong>{{$form->state ? $form->state : 'NA'}}</strong></p>
                  </div>
                </div>
                <div class="col-md-6 p-col-R">
                  <div class="infoDiv">
                    <label class="control-label mb-5">City</label>
                    <p><strong>{{$form->city ? $form->city : 'NA' }}</strong></p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 p-col-L">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Postal Code</label>
                    <p><strong>{{$form->postal_code ? $form->postal_code :'NA'}}</strong></p>
                  </div>
                </div>
              </div>


            </div>
          </div>
          @if($form->intake_form_type > 4)

          <div class="col-12">
            <div class="header">
              <h2>Assests <span>Information</span></h2>
            </div>
          </div> 
          @if($form->intake_form_type == 5)
          <div class="col-12 mb-15">
            <div class="form-wrap p-0">
              <div class="row">

                <div class="col-md-6 p-col-L ">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Movable and Immovable properties</label>
                    <p><strong>{{$form->will_move_immove_property ? $form->will_move_immove_property : 'NA'}}</strong></p>
                  </div>
                </div>
                <div class="col-md-6 p-col-R">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Shares</label>
                    <p><strong>{{$form->will_shares ? $form->will_shares : 'NA'}}</strong></p>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 p-col-L">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Bank Accounts</label>
                    <p><strong>{{$form->will_bank_account ? $form->will_bank_account : 'NA'}}</strong></p>
                  </div>
                </div>

                <div class="col-md-6 p-col-R">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Insurances</label>
                    <p><strong>{{$form->will_insurance ? $form->will_insurance : 'NA'}}</strong></p>

                  </div>
                </div>

              </div>

              <div class="row">
                <div class="col-md-6 p-col-L">
                  <div class="infoDiv">
                    <label class="control-label mb-5">RRSP's</label>
                    <p><strong>{{$form->will_rrsp ? $form->will_rrsp : 'NA'}}</strong></p>
                  </div>
                </div>
                <div class="col-md-6 p-col-R">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Disposition of Assets</label>
                    <p><strong>{{$form->will_estate_distributed ? $form->will_estate_distributed : 'NA'}}</strong></p>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-6 p-col-L">
                  <div class="infoDiv">
                    <label class="control-label mb-5">Funeral & Burial rites</label>
                    <p><strong>{{$form->will_funeral_burial_rites ? $form->will_funeral_burial_rites : 'NA'}}</strong></p>
                  </div>
                </div>
              </div>

            </div>
          </div>
  @else
  <div class="col-md-12 mb-10 p-col-L">
              <div class="infoDiv">
                <p><strong>NA</strong></p>
              </div>
            </div>
  @endif

          <div class="col-12 mt-10">
            <div class="header pt-0">
              <h2>{{($form->intake_form_type == 5 ? 'Beneficiaries' : 'Nominees')}}</h2>
            </div>
          </div>
          @if($nominees->isEmpty())

          <div class="col-md-12 mb-10 p-col-L">
            <div class="infoDiv">
              <p><strong>NA</strong></p>
            </div>
          </div>
          @else
          @foreach($nominees as $key => $nominee)
          <div class="col-12 mt-5">
            <h2 class="_head03">{{$nominee->first_name}} {{$nominee->last_name}}<span></span>
              <button class="btn addBTN-act collapsed" data-toggle="collapse" href="#collapseExample1{{$key+1}}" role="button" aria-expanded="false" aria-controls="collapseExample">Detail <i class="fa fa-angle-down ml-1"></i></button>
            </h2>
            <div class="collapse w-100  p-0" id="collapseExample1{{$key+1}}">
              <div class="  ">
                <div class="row m-0">
                  <div class="col-md-4 mb-10 p-col-L p-col-R">
                    <div class="infoDiv">
                      <label class="control-label mb-5">First Name </label>
                      <p><strong> {{$nominee->first_name}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10 p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5 ">Middle Name </label>
                      <p><strong> {{$nominee->middle_name ? $nominee->middle_name : 'NA'}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Last Name </label>
                      <p><strong> {{$nominee->last_name ? $nominee->last_name : 'NA'}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R  ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">DOB </label>
                      <p><strong> {{$nominee->dob ? $nominee->dob : 'NA'}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Email </label>
                      <p><strong> {{$nominee->email ? $nominee->email :'NA'}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Gender </label>
                      <p><strong> {{$nominee->gender_name}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Cellphone # </label>
                      <p><strong> {{$nominee->primary_cellphone ? $nominee->primary_cellphone : 'NA'}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Home Phone # </label>
                      <p><strong> {{$nominee->primary_landline ? $nominee->primary_landline : 'NA'}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Relation </label>
                      <p><strong>

                          {{ ($nominee->secondary_relationship_type == 1 ? 'Father' : ($nominee->secondary_relationship_type == 2 ? 'Mother' :
                                       ($nominee->secondary_relationship_type == 3 ? 'Son' : ($nominee->secondary_relationship_type == 4 ? 'Daughter' :
                                       ($nominee->secondary_relationship_type == 5 ? 'Brother' :
                                       ($nominee->secondary_relationship_type == 6 ? 'Sister' : ($nominee->secondary_relationship_type == 7 ? 'Spouse' : 
                                       ($nominee->secondary_relationship_type == 8 ? 'Legal Partner' :
                                       ($nominee->secondary_relationship_type == 9 ? 'Relative' : ($nominee->secondary_relationship_type == 10 ? 'Friend' : 
                                       'Bussiness Partner'))))))))))}}

                        </strong></p>
                    </div>
                  </div>

                  <div class="col-md-6 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Type </label>
                      <p><strong> 
                      {{ ($nominee->secondary_client_type == 1 ? 'POA Beneficiary Health' : 
                         ($nominee->secondary_client_type == 2 ? 'POA Beneficiary Property' :
                         ($nominee->secondary_client_type == 3 ? 'Executor & Beneficiary' :
                         ($nominee->secondary_client_type == 4 ? 'Beneficiary ' :'Executor'
                                       ))))}}
                      </strong></p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          @endforeach
          @if(!empty($gaurdian))
          <div class="col-12 mt-10">
            <div class="header pt-0">
              <h2>Gaurdian</h2>
            </div>
          </div>
          <div class="col-12 mt-5">
            <h2 class="_head03">{{$gaurdian->first_name}} {{$gaurdian->last_name}}<span></span>
              <button class="btn addBTN-act collapsed" data-toggle="collapse" href="#collapseGaurdian" role="button" aria-expanded="false" aria-controls="collapseExample">Detail <i class="fa fa-angle-down ml-1"></i></button>
            </h2>
            <div class="collapse w-100  p-0" id="collapseGaurdian">
              <div class="  ">
                <div class="row m-0">
                  <div class="col-md-4 mb-10 p-col-L p-col-R">
                    <div class="infoDiv">
                      <label class="control-label mb-5">First Name </label>
                      <p><strong> {{$gaurdian->first_name}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10 p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5 ">Middle Name </label>
                      <p><strong> {{$gaurdian->middle_name ? $gaurdian->middle_name : 'NA'}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Last Name </label>
                      <p><strong> {{$gaurdian->last_name ? $gaurdian->last_name : 'NA'}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R  ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">DOB </label>
                      <p><strong> {{$gaurdian->dob ? $gaurdian->dob : 'NA'}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Email </label>
                      <p><strong> {{$gaurdian->email ? $gaurdian->email :'NA'}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Gender </label>
                      <p><strong> {{$gaurdian->gender_name}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Cellphone # </label>
                      <p><strong> {{$gaurdian->primary_cellphone ? $gaurdian->primary_cellphone : 'NA'}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Home Phone # </label>
                      <p><strong> {{$gaurdian->primary_landline ? $gaurdian->primary_landline : 'NA'}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-4 mb-10  p-col-L p-col-R ">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Relation </label>
                      <p><strong>

                          {{ ($gaurdian->secondary_relationship_type == 1 ? 'Father' : ($gaurdian->secondary_relationship_type == 2 ? 'Mother' :
                                       ($gaurdian->secondary_relationship_type == 3 ? 'Son' : ($gaurdian->secondary_relationship_type == 4 ? 'Daughter' :
                                       ($gaurdian->secondary_relationship_type == 5 ? 'Brother' :
                                       ($gaurdian->secondary_relationship_type == 6 ? 'Sister' : ($gaurdian->secondary_relationship_type == 7 ? 'Spouse' : 
                                       ($gaurdian->secondary_relationship_type == 8 ? 'Legal Partner' :
                                       ($gaurdian->secondary_relationship_type == 9 ? 'Relative' : ($gaurdian->secondary_relationship_type == 10 ? 'Friend' : 
                                       'Bussiness Partner'))))))))))}}

                        </strong></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif
          @endif
          @endif
         @if($form->intake_form_type <= 4) 
            <div class="col-12">
              <div class="header">
                <h2>Employment <span>Information</span></h2>
              </div>
            </div>  
           
            @if($form->employment_status == 1 || $form->employment_status == 3)
            <div class="col-12 mb-15">
              <div class="form-wrap p-0">
                <div class="row">
                  <div class="col-md-6 p-col-L">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Occupation</label>
                      <p><strong>
                          {{ ($form->employment_status == 1 ? 'Employed' :  ($form->employment_status == 2 ? 'Not Employed' : 'Self Employed' ))}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-6 p-col-R">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Company Name</label>
                      <p><strong>{{$employment->company_name}}</strong></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 p-col-L">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Phone Number</label>
                      <p><strong>{{$employment->company_contact_number}}</strong></p>
                    </div>
                  </div>

                  <div class="col-md-6 p-col-R">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Job Title</label>
                      <p><strong>{{$employment->job_title}}</strong></p>

                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Address</label>
                      <p><strong>{{$employment->street_address}}. {{$employment->postal_code}} , {{$employment->city}} {{$employment->state}}, {{$employment->country}}</strong></p>
                    </div>
                  </div>

                </div>

              </div>
            </div>
            @else
            <div class="col-md-12 mb-10 p-col-L">
              <div class="infoDiv">
                <p><strong>{{$form->employment_status == 2 ? 'Un-Employed' : 'Retired'}}</strong></p>
              </div>
            </div>
            @endif
            <div class="col-12">
              <div class="header">
                <h2>Marital <span>Status</span></h2>
              </div>
            </div>

            @if($form->marital_status != 2)
            @foreach($nominees as $spouse)

            @if( $spouse->secondary_relationship_type == 7 || $spouse->secondary_relationship_type == 8 )


            <div class="col-12 mb-15">
              <div class="form-wrap p-0">
                <div class="row">
                  <div class="col-md-6 p-col-L">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Marital Status</label>
                      <p><strong>
                          {{ ($form->marital_status == 1 ? 'Married' : ($form->marital_status == 2 ? 'Un-Married':
                             ($form->marital_status == 3 ? 'Legal Partner' : 'NA' )))}}
                        </strong></p>
                    </div>
                  </div>

                  <div class="col-md-6 p-col-R">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Spouse/Partners First Name</label>
                      <p><strong>{{$spouse->first_name}}</strong></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 p-col-L">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Spouse/Partners Middle Name</label>
                      <p><strong>{{$spouse->middle_name}}</strong></p>
                    </div>
                  </div>

                  <div class="col-md-6 p-col-R">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Spouse/Partners Last Name</label>
                      <p><strong>{{$spouse->last_name}}</strong></p>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-6 p-col-L">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Gender</label>
                      <p><strong>{{$spouse->gender_name}}</strong></p>
                    </div>
                  </div>

                  <div class="col-md-6 p-col-R">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Email</label>
                      <p><strong>{{$spouse->email}}</strong></p>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-6 p-col-L">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Home Phone Number</label>
                      <p><strong>{{$spouse->primary_landline}}</strong></p>
                    </div>
                  </div>

                  <div class="col-md-6 p-col-R">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Cell Phone Number</label>
                      <p><strong>{{$spouse->primary_cellphone}}</strong></p>
                    </div>
                  </div>

                </div>

              </div>
            </div>
            @endif
            @endforeach
            @else
            <div class="col-md-12 mb-10 p-col-L">
              <div class="infoDiv">
                <p><strong>Single</strong></p>
              </div>
            </div>
            @endif

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
                      <p><strong>{{ ($property_info->tenancy_type == 1 ? 'Joint Tenants' :  ($property_info->tenancy_type == 2 ? 'Tenants in Common' :'NA' ))}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-6 p-col-R">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Property status</label>
                      <p><strong>{{($property_info->property_status == 1 ? 'Primary Home' : ($property_info->property_status == 2 ? 'Investment Home' : 'NA' ))}}</strong></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 p-col-L">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Are you a first time home buyer?</label>
                      <p><strong>{{$form->first_time_buyer == 1 ? 'YES' : 'NO'}}</strong></p>
                    </div>
                  </div>

                  <div class="col-md-6 p-col-R">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Has your spouse ever owned a home?</label>
                      <p><strong>{{$form->spouse_owned_home == 1 ? 'YES' : 'NO'}}</strong></p>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="header">
                <h2>Property <span>Information</span></h2>
              </div>
            </div>
            <div class="col-12 mb-15">
              <div class="form-wrap p-0">
                <div class="row">
                  <div class="col-md-6 p-col-L">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Property</label>
                      <p><strong>
                          {{$property_info->property}}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-6 p-col-R">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Unit</label>
                      <p><strong> {{$property_info->unit}}</strong></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Address</label>
                      <p><strong>{{$property_info->street_address}}. {{$property_info->postal_code}} , {{$property_info->city}} {{$property_info->state}}, {{$property_info->country}}</strong></p>
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
                      <p><strong>{{$form->consent_one }}</strong></p>
                    </div>
                  </div>
                  <div class="col-md-6 p-col-R">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Consent to send information via email to email provided: (initial)</label>
                      <p><strong>{{$form->consent_two }}</strong></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Were YOU physically present in Canada for 183 days out of the 12-month period prior to the date the conveyance is tendered for registration? *</label>
                      <p><strong>{{$form->canada_183_days == 1 ? 'YES' : 'NO'}}</strong></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 p-col-L">
                    <div class="infoDiv">
                      <label class="control-label mb-5">Client Signature (type your name)</label>
                      <p><strong>{{$form->client_signature}}</strong></p>
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

            @if($property_info != '')
            <div class="col-md-12">
              <div class="infoDiv">
                <label class="control-label mb-5">Property Insurance</label>
                <p><strong>{{$property_info->property_insurance ? $property_info->property_insurance : 'NA'}}</strong></p>
              </div>
            </div>


            <!-- <div class="col-md-6">

              <div class="header">
                <h2>Mortage Insurance<span></span></h2>
              </div>

              @if(in_array($mortgage_instructions_docextention,['png','pdf','PNG','jpeg','JPG','jpg'],true))
              <a data-toggle="modal" data-target="#ViewDocumentImg" class="link-doc" data-img=" {{$property_info->mortgage_instructions_doc}}" onClick="openModel('{{$property_info->mortgage_instructions_doc ? $property_info->mortgage_instructions_doc : 'error.png'}}')">
                @else
                <a href="/storage/{{$property_info->mortgage_instructions_doc}}" class="link-doc" download>
                  @endif
                  Mortage Insurance.{{$mortgage_instructions_docextention}}
                </a>
            </div> -->
            <div class="col-md-6">
              <div class="header">
                <h2>Void Check<span></span></h2>
              </div>
              @if(in_array($void_cheque_extention,['png','pdf','PNG','jpeg','JPG','jpg']))
              <a data-toggle="modal" data-target="#ViewDocumentImg" onClick="openModel('{{$property_info->void_cheque}}')" class="link-doc" download>
                @else
                <a href="/storage/{{$property_info->void_cheque}}" class="link-doc" download>
                  @endif
                  Void Cheque.{{$void_cheque_extention}}



                </a>
            </div>


            @endif

            @endif
        </div>
      </div>
    </div>
  </div>


  @if(@count($documents)>0)
  <div class="col-md-4">
    <div class="card">
      <div class="body pocPROFILE">
        <div class="row">
          <div class="col-12">
            <div class="header pt-0">
              <h2>Client ID <span>Documents</span></h2>
            </div>
          </div>
          @foreach($documents as $key => $document)

          <div class="col-12">
            <div class="header line-none">

              <h2 class="w-100">{{$key+1}}. {{$document->document_type}}
                <button class="btn addBTN-act collapsed" data-toggle="collapse" href="#collapseExample{{$key+1}}" role="button" aria-expanded="false"
                 data-id-document="collapseExample{{$key+1}}" aria-controls="collapseExample"
               data-id="{{$key+1}}">Detail <i class="fa fa-angle-down ml-1"></i></button>
              </h2>
            </div>
          </div>
          <div class="collapse w-100 " id="collapseExample{{$key+1}}" data-id="{{$key+1}}" >
            <div class="col-md-12 mb-5">
              <div class="infoDiv">
                <label class="control-label mb-5">Document Number (ID #)</label>
                documents     <p><strong>{{$document->document_number}}</strong></p>
              </div>
            </div>

            <div class="col-md-12 mb-15 ">
              <div class="infoDiv">
                <label class="control-label mb-5">Document Expiry</label>
                <p><strong>{{$document->expiry_date}}</strong></p>
              </div>
            </div>

            <div class="col-12">
              <div class="header">
                <h2>Front<span></span></h2>
              </div>
            </div>
            <div class="col-md-12 mb-20">
              <a data-toggle="modal" data-target="#ViewDocumentImg" style="cursor: pointer;" data-img="{{$document->doc_front_image}}" onClick="openModel('{{$document->doc_front_image}}')">

                <img style="width: 100%; height: auto ; max-height:300px" src="/storage/{{$document->doc_front_image}}" alt="">
              </a>
            </div>
            <div class="col-12">
              <div class="header">
                <h2>Back <span></span></h2>
              </div>
            </div>
            <div class="col-md-12 PB-15">
              <a data-toggle="modal" data-target="#ViewDocumentImg" class=" p-0 frontimg" style="cursor: pointer;" data-img="{{$document->doc_front_image}}" onClick="openModel('{{$document->doc_back_image}}')">
                <img style="width: 100%; height: auto ; max-height:300px" src="/storage/{{$document->doc_back_image}}" alt="">
              </a>
            </div>
          </div>
          @endforeach


        </div>
      </div>
    </div>
  </div>
@endif



</div>
<style>
  .Action_bottom {
    padding: 12px;
    height: 60px;
    z-index: 996;
  }

  .Action_bottom .btn {
    font-size: 14px !important;
  }
</style>

<div class="Action_bottom">
  <div class="container-fluid">
    <div class="align-right">
      @if($form->status != 2)
      <button type="submit" class="btn btn-primary mr-2 approve_btn">Approve</button>
      <!-- <a href="/intake-form-edit/{{$form_id}}" type="submit" class="btn btn-primary mr-2" >Edit Form</a> -->

      <a href="/intake-forms" type="submit" class="btn btn-cancel">Cancel</a>

      @else
      <button class="btn btn-success " style="cursor: none !important;">Approved</button>

      @endif
    </div>
  </div>
</div>

@endsection