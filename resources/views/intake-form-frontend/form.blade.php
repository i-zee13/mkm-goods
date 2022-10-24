@extends('layouts.public')
@section('content')
<div class="row">
    <div class="col-md-12 email-sec">
        <h3> Client Identification and Verification Form</h3>
        <p>For use where client, beneficiary or principal is an individual.</p>
        <div class="sm-text">Pursuant to By-law 7.1 made under the Law Society Act, lawyers are required to verify
            the identity of their clients in the circumstances and in the manner therein set out.
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12">
                <div class="progress">
                    <div class="progress-bar form-progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                        aria-valuemax="100"></div>
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show YB-right active" id="v-pills-01" role="tabpanel" aria-labelledby="v-pills-01-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if($client_intake_form->intake_form_type == '5')
                                            <h2>Testator Information</h2>
                                            @else
                                            <h2>Basic Information of the Primary Client </h2>
                                            @endif
                                            <span class="s_NO">01</span>
                                        </div>
                                        <input type="hidden" name="intake_form_type" id="intake_form_type" value="{{$client_intake_form->intake_form_type}}">
                                        <input type="hidden" name="intake_forms_id" id="intake_forms_id" value="{{$intake_form_id}}">
                                        <input type="hidden" name="have_guardian" id="have_guardian" value="{{$client_intake_form->have_guardian}}">
                                        <input type="hidden" name="default_country_id" id="default_country" value="{{$countries->id}}">
                                        <input type="hidden" name="ben_age" id="ben_age" value="">
                                        
                                        
                                        <div class="col-md-12">
                                            <form style="display: flex;" id="savePrimaryClient">
                                                @csrf
                                                <input type="hidden" name="client_id" id="client_id" value="{{$clients->id}}">
                                                <input type="hidden" name="intake_key" id="intake_key" value="{{$client_intake_form->unique_key}}">
                                                <input type="hidden" name="intake_form_type" id="intake_form_type" value="{{$client_intake_form->intake_form_type}}">
                                                <input type="hidden" name="client_country_id" id="client_country" value="{{$clients->country_id}}">
                                                <input type="hidden" name="client_state_id" id="client_state" value="{{$clients->state_id}}">
                                                <input type="hidden" name="client_city_id" id="client_city" value="{{$clients->city_id}}">
                                                <input type="hidden" name="client_postal_code_id" id="client_postal_code" value="{{$clients->postal_code_id}}">
                                                <input type="hidden" id="countries_client" value="c_client">
                                                <div class="row client_input_row">
                                                    <div class="col-md-6">
                                                        <label>First Name *</label>
                                                        <div class="form-group">
                                                            <input type="text" id="first_name" name="first_name" class="form-control required_client" placeholder=""
                                                                style="font-size: 13px" value="{{$clients->first_name}}" client-data-name="First Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Middle Name</label>
                                                        <div class="form-group">
                                                            <input type="text" id="middle_name" name="middle_name" class="form-control" placeholder=""
                                                                style="font-size: 13px" value="{{$clients->middle_name}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Last Name *</label>
                                                        <div class="form-group">
                                                            <input type="text" id="last_name" name="last_name" class="form-control required_client" placeholder=""
                                                                style="font-size: 13px" value="{{$clients->last_name}}" client-data-name="Last Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Gender *</label>
                                                        <div class="form-group">
                                                            <select class="custom-select custom-select-sm formselect required_client" id="gender" name="gender_id" client-data-name="Gender">
                                                                <option value="0">Select Gender</option>
                                                                @foreach ($genders as $gender)
                                                                    <option value="{{$gender->id}}" {{$clients->gender_id==$gender->id ? 'selected' : ''}}>{{$gender->gender_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Date of Birth *</label>
                                                        <div class="form-group">
                                                            <input type="text" id="datepicker" name="dob" class="form-control form-datepicker required_client"
                                                                style="font-size: 13px" value="{{$clients->dob}}" autocomplete="off" client-data-name="Date of Birth">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label>Email *</label>
                                                        <div class="form-group">
                                                            <input type="email" id="email" name="email" class="form-control required_client" placeholder=""
                                                                style="font-size: 13px" value="{{$clients->email}}" client-data-name="Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Residency Status *</label>
                                                        <div class="form-group">
                                                            <select class="custom-select custom-select-sm formselect required_client" name="residence_status" id="residence_status" client-data-name="Residency Status">
                                                                <option value="0">Select Residence</option>
                                                                @foreach ($residence_status as $data)
                                                                    <option value="{{$data->id}}" {{$clients->residence_status==$data->id ? 'selected' : ''}}>{{$data->residence_name}}</option>   
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Home Address *</label>
                                                        <div class="form-group">
                                                            <input type="text" id="home_address" name="primary_address" class="form-control required_client" placeholder=""
                                                                style="font-size: 13px" value="{{$clients->primary_address}}" client-data-name="Home Address">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Home Phone Number *</label>
                                                        <div class="form-group">
                                                            <input type="text" id="primary_landline" name="primary_landline" class="form-control required_client" placeholder=""
                                                                style="font-size: 13px" value="{{$clients->primary_landline}}" client-data-name="Home Phone No.">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Cell Phone Number *</label>
                                                        <div class="form-group">
                                                            <input type="text" id="primary_cellphone" name="primary_cellphone" class="form-control required_client" placeholder=""
                                                                style="font-size: 13px" value="{{$clients->primary_cellphone}}" client-data-name="Cell Phone No.">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Country *</label>
                                                        <div class="form-group">
                                                            <select id="all_countries_client" name="country_id" class="form-control formselect required_client all_countries_client"
                                                            style="font-size: 13px" client-data-name="Country">
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Province *</label>
                                                        <div class="form-group">
                                                            <select id="all_states_client" name="state_id" class="form-control formselect required_client all_states_client"
                                                            style="font-size: 13px" client-data-name="Province">
    
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>City *</label>
                                                        <div class="form-group">
                                                            <select id="all_cities_client" name="city_id" class="form-control formselect required_client all_cities_client"
                                                            style="font-size: 13px" client-data-name="City">
    
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Postal Code *</label>
                                                        <div class="form-group">
                                                            <input type="text" id="postal_codes_client" maxlength="6" minlength="6" name="postal_code" class="form-control required_client"
                                                            style="font-size: 13px" value="{{$client_postal_code->postal_code ? $client_postal_code->postal_code : ''}}" client-data-name="Postal Code">
                                                        </div>
                                                    </div>  
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="button" class="btn w-btn float-right" name="form1" id="form1">Save & Continue</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($client_intake_form->intake_form_type <= '4')
                    {{-- Employment Info --}}
                    <div class="tab-pane fade show YB-right" id="v-pills-02" role="tabpane2" aria-labelledby="v-pills-02-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Employment Information of the Primary Client</h2>
                                            <span class="s_NO">02</span>
                                        </div>
                                        <div class="col-md-12">
                                        <form id="SaveClientEmployeeInfo" class="employment_input_row">
                                            @csrf
                                            <input type="hidden" name="client_id" id="client_id" value="{{$clients->id}}">
                                            <input type="hidden" name="intake_key" id="intake_key" value="{{$client_intake_form->unique_key}}">
                                            <input type="hidden" name="employment_id" id="employment_id" value="">
                                            <input type="hidden" name="country_id" id="country_id" value="0">
                                            <input type="hidden" name="state_id" id="state_id" value="0">
                                            <input type="hidden" name="city_id" id="city_id" value="0">
                                            <input type="hidden" name="postal_code_id" id="postal_code_id" value="0">
                                                
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Occupation *</label>
                                                    <div class="form-group">
                                                        <select class="custom-select custom-select-sm formselect employee_status employee_required" id="employee_status" name="employment_status" data-employee-name="Occupation">
                                                        <option value="0">Select Occupation</option>
                                                        <option value="1">Employeed</option>
                                                        <option value="2">Un Employeed</option>
                                                        <option value="3">Self Employeed</option>
                                                        <option value="4">Retierd</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="job_title_hide">
                                                    <label>Job Title *</label>
                                                    <div class="form-group">
                                                        <input type="text" id="job_title" class="form-control employee_info" name="job_title" placeholder=""
                                                        style="font-size: 13px" data-employee-name="Job Title">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="employee_form">
                                                <div class="col-md-6">
                                                    <label>Company Name *</label>
                                                    <div class="form-group">
                                                        <input type="text" id="company_name" class="form-control employee_info" name="company_name" placeholder=""
                                                        style="font-size: 13px" data-employee-name="Company Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Company Contact Number *</label>
                                                    <div class="form-group">
                                                        <input type="text" id="company_contact_number" class="form-control employee_info" name="company_contact_number" placeholder=""
                                                        style="font-size: 13px" data-employee-name="Company Contact No.">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Office No *</label>
                                                    <div class="form-group">
                                                        <input type="text" id="office_no" class="form-control employee_info" name="office_no" placeholder=""
                                                        style="font-size: 13px" data-employee-name="Office No.">
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <label>Street Address *</label>
                                                    <div class="form-group">
                                                        <input type="text" id="street_address" class="form-control employee_info" name="street_address" placeholder=""
                                                        style="font-size: 13px" data-employee-name="Street Address">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Country *</label>
                                                    <div class="form-group">
                                                        <select id="all_countries" name="country_id2" class="form-control formselect employee_info all_countries"
                                                        style="font-size: 13px" data-employee-name="Country">

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Province *</label>
                                                    <div class="form-group">
                                                        <select id="all_states" name="state_id2" class="form-control formselect employee_info all_states"
                                                        style="font-size: 13px" data-employee-name="Province">

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>City *</label>
                                                    <div class="form-group">
                                                        <select id="all_cities" name="city_id2" class="form-control formselect employee_info all_cities"
                                                        style="font-size: 13px" data-employee-name="City">

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Postal Code *</label>
                                                    <div class="form-group">
                                                        <input id="all_postal_codes" maxlength="6" minlength="6" name="postal_code_id2" class="form-control employee_info all_postal_codes"
                                                        style="font-size: 13px" data-employee-name="Postal Code">
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-12" style="padding:15px"><strong>1.1.1. If the Client is not Employed
                                                </strong> </div>
                                                <div class="col-md-6">
                                                    <label>TBD</label>
                                                    <div class="form-group">
                                                        <input type="text" id="" class="form-control" placeholder=""
                                                        style="font-size: 13px">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>TBD</label>
                                                    <div class="form-group">
                                                        <input type="text" id="" class="form-control" placeholder=""
                                                        style="font-size: 13px">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>TBD</label>
                                                    <div class="form-group">
                                                        <input type="text" id="" class="form-control" placeholder=""
                                                        style="font-size: 13px">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>TBD</label>
                                                    <div class="form-group">
                                                        <input type="text" id="" class="form-control" placeholder=""
                                                        style="font-size: 13px">
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </form>
                                            <div class="row">
                                                <div class="col-md-12 pt-20">
                                                <button type="button" name="form2" id="form2" class="btn w-btn float-right">Save & Continue</button>
                                                <button class="btn w-btn float-right mr-1" type="button" name="previous-form2" id="previous-form2">Previous</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Marital Status --}}
                    <div class="tab-pane fade show YB-right" id="v-pills-03" role="tabpane3" aria-labelledby="v-pills-03-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Marital Status</h2>
                                            <span class="s_NO">03</span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form id="SaveClientMaritalInfo" class="marital_input_row">
                                                        @csrf
                                                        <input type="hidden" name="client_id" id="client_id" value="{{$clients->id}}">
                                                        {{-- <input type="hidden" name="secondary_client_id" id="secondary_client_id" value="{{$client_martial->secondary_contact_id}}"> --}}
                                                        <input type="hidden" name="sec_id" id="sec_id">
                                                        <input type="hidden" name="client_intake_form_id" id="client_intake_form_id" value="{{$client_intake_form->id}}">
                                                        <input type="hidden" name="intake_form_id" id="intake_form_id" value="{{$intake_form_id}}">
                                                        <input type="hidden" name="intake_form_type" id="intake_form_type" value="{{$client_intake_form->intake_form_type}}">
                                                        
                                                        <input type="hidden" name="relationship_type" id="relationship_type">
                                                        <input type="hidden" name="relationship_id" id="relationship_id">
                                                        <input type="hidden" name="intake_key" id="intake_key" value="{{$client_intake_form->unique_key}}">
                                                        <input type="hidden" name="country_id" id="country_id_mari" value="0">
                                                        <input type="hidden" name="state_id" id="state_id_mari" value="0">
                                                        <input type="hidden" name="city_id" id="city_id_mari" value="0">
                                                        <input type="hidden" name="postal_code_id" id="postal_code_id_mari" value="0">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Marital Status *</label>
                                                            <div class="form-group">
                                                                <select class="custom-select custom-select-sm formselect marital_status marital_required" name="marital_status" id="marital_status" data-marital-name="Marital Status">
                                                                    <option selected value="0">Select Marital Status *</option>
                                                                    <option value="1">Married</option>
                                                                    <option value="3">Common Law</option>
                                                                    <option value="2">Single</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" id="marital_first_name_hide">
                                                            <label>Spouse/Partners First Name *</label>
                                                            <div class="form-group">
                                                                <input type="text" id="mar_first_name" name="first_name" class="form-control marital_info" placeholder=""
                                                                style="font-size: 13px" data-marital-name="First Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="marital_form">
                                                        {{-- <div class="col-md-12" style="padding:15px"><strong>1.2.1 In Case if the client is
                                                            Mrried or has Common Law Partner </strong> </div> --}}
                                                        <div class="col-md-6">
                                                            <label>Spouse/Partners Middle Name</label>
                                                            <div class="form-group">
                                                                <input type="text" id="mar_middle_name" name="middle_name" class="form-control" placeholder=""
                                                                style="font-size: 13px">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Spouse/Partners Last Name *</label>
                                                            <div class="form-group">
                                                                <input type="text" id="mar_last_name" name="last_name" class="form-control marital_info" placeholder=""
                                                                style="font-size: 13px" data-marital-name="Last Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Gender</label>
                                                            <div class="form-group">
                                                                <select class="custom-select custom-select-sm formselect marital_info" name="re_gender_id" id="mar_re_gender_id" data-marital-name="Gender">
                                                                <option selected value="0">Select Gender *</option>
                                                                @foreach ($genders as $gender)
                                                                    <option value="{{$gender->id}}">{{$gender->gender_name}}</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Email *</label>
                                                            <div class="form-group">
                                                                <input type="email" id="mar_email" name="email" class="form-control marital_info" placeholder=""
                                                                style="font-size: 13px" data-marital-name="Email">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Home Phone Number *</label>
                                                            <div class="form-group">
                                                                <input type="text" id="mar_home_phone_no" name="home_phone_no" class="form-control marital_info" placeholder=""
                                                                style="font-size: 13px" data-marital-name="Home Phone No.">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Cell Phone Number *</label>
                                                            <div class="form-group">
                                                                <input type="text" id="mar_cell_phone_no" name="cell_phone_no" class="form-control marital_info" placeholder=""
                                                                style="font-size: 13px" data-marital-name="Cell Phone No.">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Country *</label>
                                                            <div class="form-group">
                                                                <select id="all_countries_marital" name="country_id_marital" class="form-control formselect marital_info all_countries_marital"
                                                                style="font-size: 13px" data-marital-name="Country">
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Province *</label>
                                                            <div class="form-group">
                                                                <select id="all_states_marital" name="state_id_marital" class="form-control formselect marital_info all_states_marital"
                                                                style="font-size: 13px" data-marital-name="Province">
        
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>City *</label>
                                                            <div class="form-group">
                                                                <select id="all_cities_marital" name="city_id_marital" class="form-control formselect marital_info all_cities_marital"
                                                                style="font-size: 13px" data-marital-name="City">
        
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Postal Code *</label>
                                                            <div class="form-group">
                                                                <input type="text" id="postal_codes_marital" maxlength="6" minlength="6" name="postal_code_marital" class="form-control marital_info"
                                                                style="font-size: 13px" data-marital-name="Postal Code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-12 pt-20">
                                                <button type="button" name="form3" id="form3" class="btn w-btn float-right">Save & Continue</button>
                                                <button class="btn w-btn float-right mr-1" type="button" name="previous-form3" id="previous-form3">Previous</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show YB-right" id="v-pills-04" role="tabpane4" aria-labelledby="v-pills-04-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Capacity</h2>
                                            <span class="s_NO">04</span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form id="SaveCapacityForm">
                                                        @csrf
                                                        <input type="hidden" name="client_intake_form_id" id="client_intake_form_id" value="{{$client_intake_form->id}}">
                                                        <input type="hidden" name="intake_form_id" id="intake_form_id" value="{{$intake_form_id}}">
                                                        <input type="hidden" name="client_id" id="client_id" value="{{$clients->id}}">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Tenancy Type</label>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-6 W-YN-195">
                                                                            <div class="custom-control custom-radio">
                                                                                <input class="custom-control-input tenancy_type" type="radio" name="tenancy_type"
                                                                                    id="joint_tenancy" value='1' data-id="joint_tenancy" {{$client_property->tenancy_type == '1' ? 'checked' : ''}}>
                                                                                <label class="custom-control-label" for="joint_tenancy">Joint Tenants</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 W-YN-195">
                                                                            <div class="custom-control custom-radio">
                                                                                <input class="custom-control-input" type="radio" name="tenancy_type"
                                                                                    id="tenants_common" value='2' data-id="tenants_common" {{$client_property->tenancy_type == '2' ? 'checked' : ''}}>
                                                                                <label class="custom-control-label" for="tenants_common">Tenants in Common</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <hr class="mt-0 mb-10">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label>Property status</label>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-6 W-YN-195">
                                                                            <div class="custom-control custom-radio">
                                                                            <input class="custom-control-input" type="radio" name="property_status"
                                                                                id="primary_home" value='1' data-id="primary_home" {{$client_property->property_status == '1' ? 'checked' : ''}}>
                                                                            <label class="custom-control-label" for="primary_home">Primary Home</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 W-YN-195">
                                                                            <div class="custom-control custom-radio">
                                                                                <input class="custom-control-input" type="radio" name="property_status"
                                                                                    id="investment_home" value='2' data-id="investment_home" {{$client_property->property_status == '2' ? 'checked' : ''}}>
                                                                                <label class="custom-control-label" for="investment_home">Investment Home</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <hr class="mt-0 mb-10">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label>Are you a first time home buyer?</label>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-6 W-YN">
                                                                            <div class="custom-control custom-radio">
                                                                            <input class="custom-control-input" type="radio" name="home_buyer"
                                                                                id="y001" value='1' data-id="y001" {{$client_intake_form->first_time_buyer == '1' ? 'checked' : ''}}>
                                                                            <label class="custom-control-label" for="y001">Yes</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 W-YN">
                                                                            <div class="custom-control custom-radio">
                                                                            <input class="custom-control-input" type="radio" name="home_buyer"
                                                                                id="n002" value='0' data-id="n002" {{$client_intake_form->first_time_buyer == '0' ? 'checked' : ''}}>
                                                                            <label class="custom-control-label" for="n002">No</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <hr class="mt-0 mb-10">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label>Has your spouse ever owned a home?</label>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-6 W-YN">
                                                                            <div class="custom-control custom-radio">
                                                                            <input class="custom-control-input" type="radio" name="spouse_owned_home"
                                                                                id="y002" value='1' data-id="y002" {{$client_intake_form->spouse_owned_home == '1' ? 'checked' : ''}}>
                                                                            <label class="custom-control-label" for="y002">Yes</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 W-YN">
                                                                            <div class="custom-control custom-radio">
                                                                            <input class="custom-control-input" type="radio" name="spouse_owned_home"
                                                                                id="n003" value='0' data-id="n003" {{$client_intake_form->spouse_owned_home == '0' ? 'checked' : ''}}>
                                                                            <label class="custom-control-label" for="n003">No</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 W-YN">
                                                                            <div class="custom-control custom-radio">
                                                                            <input class="custom-control-input" type="radio" name="spouse_owned_home"
                                                                                id="na003" value='2' data-id="na003" {{$client_intake_form->spouse_owned_home == '2' ? 'checked' : ''}}>
                                                                            <label class="custom-control-label" for="na003">NA</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-12 pt-20">
                                                    <button type="button" name="capacity_form" id="capacity_form" class="btn w-btn float-right">Save & Continue</a>
                                                    <button type="button" class="btn w-btn float-right mr-1" name="previous_capacity_form" id="previous_capacity_form" href="#">Previous</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show YB-right" id="v-pills-07" role="tabpane6"
                    aria-labelledby="v-pills-07-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Consent and Sign-off </h2>
                                            <span class="s_NO">06</span>
                                        </div>
                                        <div class="col-md-12">
                                            <form id="SaveConsentForm">
                                                @csrf
                                                <input type="hidden" name="client_id" id="client_id" value="{{$clients->id}}">
                                                <input type="hidden" name="client_intake_form_id" id="client_intake_form_id" value="{{$client_intake_form->id}}">
                                                <input type="hidden" name="intake_form_id" id="intake_form_id" value="{{$intake_form_id}}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Consent to Electronically share the info with bank and Title insurance as required</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="consent_one" name="consent_one" class="form-control consent_required" placeholder=""
                                                                    style="font-size: 13px" value="{{$client_intake_form->consent_one != '' ? $client_intake_form->consent_one : ''}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label>Consent to send information via email to email provided: (initial)</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="consent_two" name="consent_two" class="form-control consent_required" placeholder=""
                                                                    style="font-size: 13px" value="{{$client_intake_form->consent_two != '' ? $client_intake_form->consent_two : ''}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label>Were YOU physically present in Canada for 183 days out of the 12-month
                                                                period prior to the date the conveyance is tendered for registration? *</label>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-2 W-YN">
                                                                            <div class="custom-control custom-radio">
                                                                                <input class="custom-control-input" type="radio"
                                                                                name="canada_183_days" id="y011" value='1' data-id="y011" {{$client_intake_form->canada_183_days == '1' ? 'checked' : ''}}>
                                                                                <label class="custom-control-label" for="y011">Yes</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 W-YN">
                                                                            <div class="custom-control custom-radio">
                                                                                <input class="custom-control-input" type="radio"
                                                                                name="canada_183_days" id="n011" value='0' data-id="n011" {{$client_intake_form->canada_183_days == '0' ? 'checked' : ''}}>
                                                                                <label class="custom-control-label" for="n011">No</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Client Signature (type your name)</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="client_signature" name="client_signature" value="{{$client_intake_form->client_signature !='' ? $client_intake_form->client_signature : ''}}" class="form-control consent_required" placeholder=""
                                                                    style="font-size: 13px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 pt-20">
                                                        <button type="button" name="consent_save" id="consent_save" class="btn w-btn float-right">Save & Continue</button>
                                                        <button type="button" name="previous_consent_save" id="previous_consent_save" class="btn w-btn float-right mr-1">Previous</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Realtor --}}
                    <div class="tab-pane fade show YB-right" id="v-pills-13" role="tabpane7"
                    aria-labelledby="v-pills-13-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Realestate Agent</h2>
                                            <span class="s_NO">07</span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12 realestate-agent">
                                                        <form id="SaveRealtorForm" enctype="multipart/form-data">
                                                            @csrf
                                                        <input type="hidden" name="client_intake_form_id" id="client_intake_form_id" value="{{$client_intake_form->id}}">
                                                        <input type="hidden" name="intake_form_id" id="intake_form_id" value="{{$intake_form_idd}}">
                                                        <input type="hidden" name="client_id" id="client_id" value="{{$clients->id}}">
                                                        <input type="hidden" name="intake_key" id="intake_key" value="{{$client_intake_form->unique_key}}">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>First Name *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="realtor_first_name" name="first_name" class="form-control required_realtor" placeholder=""
                                                                        style="font-size: 13px" value="{{@$realtor_info->first_name}}" realtor-data-name="First Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Middle Name</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="realtor_middle_name" name="middle_name" class="form-control" placeholder=""
                                                                        style="font-size: 13px" value="{{@$realtor_info->middle_name}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Last Name *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="realtor_last_name" name="last_name" class="form-control required_realtor" placeholder=""
                                                                        style="font-size: 13px" realtor-data-name="Last Name" value="{{@$realtor_info->last_name}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Official Email *</label>
                                                                <div class="form-group">
                                                                    <input type="email" id="realtor_email" name="official_email" class="form-control required_realtor" placeholder=""
                                                                        style="font-size: 13px" realtor-data-name="Email" value="{{@$realtor_info->official_email}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Cell Phone Number *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="realtor_primary_cellphone" name="contact_cellphone" class="form-control required_realtor" placeholder=""
                                                                        style="font-size: 13px" realtor-data-name="Cell Phone No." value="{{@$realtor_info->contact_cellphone}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Agency Name *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="realtor_agency_name" name="agency_name" class="form-control required_realtor" placeholder=""
                                                                        style="font-size: 13px" realtor-data-name="Agency Name" value="{{@$realtor_info->agency_name}}">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                    <div class="col-md-12 pt-20">
                                                        <button type="button" name="realtor_save" id="realtor_save" class="btn w-btn float-right">Save & Continue</button>
                                                        <button type="button" class="btn w-btn float-right mr-1" name="previous_realtor_save" id="previous_realtor_save">Previous</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Mortgage Agent --}}
                    <div class="tab-pane fade show YB-right" id="v-pills-14" role="tabpane7"
                    aria-labelledby="v-pills-14-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Mortgage Agent</h2>
                                            <span class="s_NO">08</span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12 mortgage_agent">
                                                        <form id="SaveMortgageForm" enctype="multipart/form-data">
                                                            @csrf
                                                        <input type="hidden" name="client_intake_form_id" id="client_intake_form_id" value="{{$client_intake_form->id}}">
                                                        <input type="hidden" name="intake_form_id" id="intake_form_id" value="{{$intake_form_idd}}">
                                                        <input type="hidden" name="client_id" id="client_id" value="{{$clients->id}}">
                                                        <input type="hidden" name="intake_key" id="intake_key" value="{{$client_intake_form->unique_key}}">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>First Name *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="mortgage_first_name" name="first_name" class="form-control required_mortgage" placeholder=""
                                                                        style="font-size: 13px" value="{{@$mortgage_info->first_name}}" mortgage-data-name="First Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Middle Name</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="mortgage_middle_name" name="middle_name" class="form-control" placeholder=""
                                                                        style="font-size: 13px" value="{{@$mortgage_info->middle_name}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Last Name *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="mortgage_last_name" name="last_name" class="form-control required_mortgage" placeholder=""
                                                                        style="font-size: 13px" mortgage-data-name="Last Name" value="{{@$mortgage_info->last_name}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Official Email *</label>
                                                                <div class="form-group">
                                                                    <input type="email" id="mortgage_email" name="official_email" class="form-control required_mortgage" placeholder=""
                                                                        style="font-size: 13px" mortgage-data-name="Email" value="{{@$mortgage_info->official_email}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Cell Phone Number *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="mortgage_primary_cellphone" name="contact_cellphone" class="form-control required_mortgage" placeholder=""
                                                                        style="font-size: 13px" mortgage-data-name="Cell Phone No." value="{{@$mortgage_info->contact_cellphone}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Agency Name *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="mortgage_agency_name" name="agency_name" class="form-control required_mortgage" placeholder=""
                                                                        style="font-size: 13px" mortgage-data-name="Agency Name" value="{{@$mortgage_info->agency_name}}">
                                                                </div>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 pt-20">
                                                        <button type="button" name="mortgage_save" id="mortgage_save" class="btn w-btn float-right">Save & Continue</button>
                                                        <button type="button" class="btn w-btn float-right mr-1" name="previous_mortgage_save" id="previous_mortgage_save">Previous</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show YB-right" id="v-pills-08" role="tabpane7"
                    aria-labelledby="v-pills-08-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Document Required as per the Email Templates</h2>
                                            <span class="s_NO">09</span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                        <form id="SaveEmailTemplateForm" enctype="multipart/form-data">
                                                            @csrf
                                                        <input type="hidden" name="client_intake_form_id" id="client_intake_form_id" value="{{$client_intake_form->id}}">
                                                        <input type="hidden" name="intake_form_id" id="intake_form_id" value="{{$intake_form_idd}}">
                                                        <input type="hidden" name="client_id" id="client_id" value="{{$clients->id}}">
                                                        <input type="hidden" name="intake_key" id="intake_key" value="{{$client_intake_form->unique_key}}">
                                                        <input type="hidden" name="void_form" id="void_form" value="void_finish">
                                                        <div class="row">
                                                            {{-- <div class="col-md-12">
                                                                <label>Property Insurance </label>
                                                                <div class="form-group">
                                                                    <input type="text" id="property_insurance" class="form-control email_template_required" name="property_insurance" placeholder=""
                                                                    style="font-size: 13px" value="{{$client_property->property_insurance !='' ? $client_property->property_insurance : ''}}"> 
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Mortgage Instructions</label>
                                                                <div class="form-group upload-img">
                                                                    <input type="hidden" name="hidden_mortgage_doc" value="{{$client_property->mortgage_instructions_doc !='' ? $client_property->mortgage_instructions_doc : ''}}"> 
                                                                    <input type="file" id="input-file-now" name="mortgage_doc" data-default-file="/storage/{{$client_property->mortgage_instructions_doc !='' ? $client_property->mortgage_instructions_doc : ''}}"
                                                                    class="dropify " />
                                                                </div>
                                                            </div> --}}
                                                            <div class="col-md-6">
                                                                <label>Void Cheque</label>
                                                                <div class="form-group upload-img">
                                                                    {{-- <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="customFile" name="void_doc">
                                                                        <label class="custom-file-label" for="customFile">Image Upload</label>
                                                                    </div> --}}
                                                                    <input type="hidden" name="hidden_void_doc" value="{{$client_property->void_cheque !='' ? $client_property->void_cheque : ''}}"> 
                                                                    <div class="upload-pic"></div>
                                                                    <input type="file" id="input-file-now" name="void_doc" data-default-file="/storage/{{$client_property->void_cheque !='' ? $client_property->void_cheque : ''}}"
                                                                                class="dropify" accept="image/*, application/pdf"  data-allowed-file-extensions="jpg png jpeg tif tiff svg pjp webp xbm jxl jfif bmp avif ico gif pdf"/>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 pt-20">
                                                        <button type="button" name="email_template_save" id="email_template_save" class="btn w-btn float-right">Finish</button>
                                                        <button type="button" class="btn w-btn float-right mr-1" name="previous_email_template_save" id="previous_email_template_save">Previous</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="tab-pane fade show YB-right" id="v-pills-05" role="tabpane5" aria-labelledby="v-pills-05-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>ID/Documents Uploading</h2>
                                            {{-- <button class="btn w-btn addnew-btn"> <i class="fa fa-plus"></i> New Add </button> --}}
                                            <span class=" addnew-btn"> Minimum Required Two Records </span>
                                            <span class="s_NO" id="s_no_doc">
                                                @if($client_intake_form->intake_form_type <= '4')
                                                    05
                                                @elseif($client_intake_form->intake_form_type == '5')
                                                    04
                                                @else
                                                    02
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">   
                                                    <form id="saveDocuments" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="client_id" id="hidden_client_id" value="{{$clients->id}}">
                                                    <input type="hidden" name="intake_key" id="intake_key" value="{{$client_intake_form->unique_key}}">
                                                    <input type="hidden" name="intake_form_id" id="intake_form_id_doc" value="{{$intake_form_id}}">
                                                    @foreach ($client_documents as $client_document)
                                                    <input type="hidden" name="client_id" id="hidden_client_id" value="{{!empty($client_document->student_id) ? $client_document->student_id : ''}}">
                                                    {{-- <input type="hidden" name="client_document_id" id="client_document_id" value="{{!empty($client_document->id) ? $client_document->id : ''}}"> --}}
                                                    @endforeach
                                                        <div class="row document_input_row">
                                                            {{-- <div class="col-md-12">
                                                                <h3>Document Type - {{$key+1}}</h3>
                                                            </div> --}}
                                                            <div class="col-md-6">
                                                                <label>Document Type *</label>
                                                                <div class="form-group">
                                                                    <select class="custom-select custom-select-sm required_document formselect" name="document_type" id="document_type" data-document-name="Document Type">
                                                                        <option value="0" selected>Select Document Type</option>
                                                                        @foreach ($documents as $document)
                                                                            <option value="{{$document->id}}">
                                                                                {{$document->document_verification_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Document Number (ID #) *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="document_number" name="document_number" class="form-control required_document" placeholder=""
                                                                        style="font-size: 13px" data-document-name="Document Number">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Document Issuance Date</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="datepicker2" name="document_issuance_date" class="form-control form-datepicker"
                                                                        placeholder="" style="font-size: 13px" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Document Expiry Date *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="datepicker3" name="document_expiry_date" class="form-datepicker form-control required_document"
                                                                        placeholder="" style="font-size: 13px" data-document-name="Document Expiry Date">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-wrap p-0">
                                                                            <label class="font11 mb-5">Document Front Image *</label>
                                                                            <div class="upload-pic"></div>
                                                                            <input type="file" id="input-file-now" name="document_front_image" data-default-file=""
                                                                                class="dropify required_document" accept="image/*"  data-allowed-file-extensions="jpg png jpeg tif tiff svg pjp webp xbm jxl jfif bmp avif ico gif" data-document-name="Document Front Image"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-wrap p-0">
                                                                            <label class="font11 mb-5">Document Back Image *</label>
                                                                            <div class="upload-pic"></div> 
                                                                            <input type="file" id="input-file-now" name="document_back_image" data-default-file=""
                                                                                class="dropify required_document" accept="image/*" data-allowed-file-extensions="jpg png jpeg tif tiff svg pjp webp xbm jxl jfif bmp avif ico gif" data-document-name="Document Back Image"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-12 pt-20">
                                                    <button type="button" name="form4" id="form4" class="btn w-btn float-right">Add Document</button>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <hr>
                                                </div>
                                                {{-- All Documents --}}
                                                <span class="collapse_all_documents" style="width: 100%">
                                                    
                                                </span>
                                                <div class="col-md-12 pt-20">
                                                    <button disabled class="btn w-btn float-right" type="button" id="document-next-button">Save & Continue</button>
                                                    <button class="btn w-btn float-right mr-1" type="button" name="previous-form4" id="previous-form4">Previous</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show YB-right" id="v-pills-06" role="tabpane6" aria-labelledby="v-pills-06-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>
                                                @if($client_intake_form->intake_form_type == '5')
                                                    Beneficiaries
                                                @else
                                                    Nominees
                                                @endif
                                            </h2>
                                            <span class=" addnew-btn"> Minimum Required One Record</span>
                                            <span class="s_NO">
                                                @if($client_intake_form->intake_form_type <= '4')
                                                    05
                                                @elseif($client_intake_form->intake_form_type == '5')
                                                    02
                                                @else
                                                    03
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-md-12">
                                            <form id="savePOA" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="client_id" id="hidden_client_id" value="{{$clients->id}}">
                                                <input type="hidden" name="intake_key" id="intake_key" value="{{$client_intake_form->unique_key}}">
                                                <input type="hidden" name="intake_form_id" id="intake_form_id" value="{{$intake_form_id}}">
                                                <input type="hidden" name="intake_form_type" id="intake_form_type" value="{{$client_intake_form->intake_form_type}}">
                                                <input type="hidden" name="gender_id" id="hidden_gender_id" value="{{$clients->gender_id}}">
                                                <input type="hidden" name="operation" id="operation" value="add">
                                                @if($client_intake_form->intake_form_type == 6)
                                                    <input type="hidden" name="beneficiary_type" value="1">
                                                @endif
                                                @if($client_intake_form->intake_form_type == 7)
                                                    <input type="hidden" name="beneficiary_type" value="2">
                                                @endif

                                                <div class="row poa_input_row">
                                                    @if($client_intake_form->intake_form_type == 5)
                                                    <div class="col-lg-6 col-md-6" id="beneficiary_type_div" style="display: none">
                                                        <label>Beneficiary Type *</label>
                                                        <div class="form-group">
                                                            <select class="form-control formselect" id="beneficiary_types" name="beneficiary_type" style="font-size: 13px" data-poa-name="Beneficiary Type">
                                                                <option value="0">Select Beneficiary Type</option>
                                                                <option value="4">Beneficiary</option>
                                                                <option value="5">Executor</option>
                                                                <option value="3">Beneficiary & Executor</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="col-lg-6 col-md-6">
                                                        <label>First Name *</label>
                                                        <div class="form-group">
                                                            <input type="text" id="first_name_poa" name="first_name" class="form-control required_poa" placeholder=""
                                                                style="font-size: 13px" data-poa-name="First Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <label>Middle Name</label>
                                                        <div class="form-group">
                                                            <input type="text" id="middle_name_poa" name="middle_name" class="form-control" placeholder=""
                                                                style="font-size: 13px">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <label>Last Name *</label>
                                                        <div class="form-group">
                                                            <input type="text" id="last_name_poa" name="last_name" class="form-control required_poa" placeholder=""
                                                                style="font-size: 13px" data-poa-name="Last Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <label>DOB</label>
                                                        <div class="form-group">
                                                            <input type="text" id="datepicker" name="dob" class="form-control form-datepicker" placeholder=""
                                                                style="font-size: 13px">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <label>Relationship Type *</label>
                                                        <div class="form-group">
                                                            <select class="custom-select custom-select-sm required_poa formselect"  placeholder="Select Relation Ship Type" name="relationship_type" data-poa-name="Relationship Type">
                                                                <option selected value="0">Select Relationship Type</option>
                                                                <option value="1">Father</option>
                                                                <option value="2">Mother</option>
                                                                <option value="3">Son</option>
                                                                <option value="4">Daughter</option>
                                                                <option value="5">Brother</option>
                                                                <option value="6">Sister</option>
                                                                <option value="7">Spouse</option>
                                                                <option value="8">Legal Partner</option>
                                                                <option value="9">Relative</option>
                                                                <option value="10">Friend</option>
                                                                <option value="11">Business Partner</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <label>Gender *</label>
                                                        <div class="form-group">
                                                            <select class="custom-select custom-select-sm required_poa formselect" name="re_gender_id" id="re_gender_id" data-poa-name="Gender">
                                                                <option selected value="0">Select Gender</option>
                                                                @foreach ($genders as $gender)
                                                                    <option value="{{$gender->id}}">{{$gender->gender_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-lg-4 col-md-6">
                                                        <label>Date of Birth</label>
                                                        <div class="row m-0">
                                                            <div class="col p-0">
                                                                <div class="form-group">
                                                                    <input type="text" id="datepicker4" name="dob" class="form-control form-datepicker"
                                                                        style="font-size: 13px">
                                                                </div>
                                                            </div>    
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <label>Residency Status</label>
                                                        <div class="form-group">
                                                            <select class="custom-select custom-select-sm">
                                                                <option value="1">Canadian</option>
                                                                <option value="2">Citizen/Permancent</option>
                                                            </select>
                                                        </div>
                                                    </div> --}}  
                                                </div>
                                            </form>
                                        </div>
                                            <div class="col-md-12 text-right">
                                                <button type="button" name="form5" id="form5" class="btn w-btn float-right">Add Beneficiary</button>
                                                
                                            </div>
                                            <div class="col-md-12">
                                                <hr>
                                            </div>
                                            {{-- All POA --}}
                                            <span class="collapse_all_poa" style="width: 100%">
                                                        
                                            </span>
                                            <div class="col-md-12 pt-20">
                                                @if($client_intake_form->intake_form_type == '5')
                                                    <button disabled class="btn w-btn float-right" type="button" id="poa-next-button">Save & Continue</button>
                                                    <button class="btn w-btn float-right mr-1" type="button" name="previous-poa-btn" id="previous-poa-btn">Previous</button>
                                                @else
                                                    <button disabled class="btn w-btn float-right" type="submit" id="poa-finish-button">Finish</button>
                                                    <button class="btn w-btn float-right mr-1" type="button" name="previous-form5" id="previous-form5">Previous</button>
                                                @endif
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($client_intake_form->intake_form_type == '5')
                    <div class="tab-pane fade show YB-right" id="v-pills-09" role="tabpane7" aria-labelledby="v-pills-09-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Guardians</h2>
                                            <span class="s_NO">03</span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                        <form id="SaveGuardiansFrom">
                                                            @csrf
                                                        <input type="hidden" name="client_intake_form_id" id="client_intake_form_id" value="{{$client_intake_form->id}}">
                                                        <input type="hidden" name="intake_form_id" id="intake_form_id" value="{{$intake_form_id}}">
                                                        <input type="hidden" name="client_id" id="client_id" value="{{$clients->id}}">
                                                        <input type="hidden" name="intake_form_type" id="intake_form_type" value="{{$client_intake_form->intake_form_type}}">
                                                        <input type="hidden" name="intake_key" id="intake_key" value="{{$client_intake_form->unique_key}}">
                                                        <input type="hidden" name="guradian_details_id" id="guradian_details_id" value="{{$guradian_details->id}}">
                                                        <input type="hidden" name="guardians_id" id="guardians_id" value="">
                                                        <input type="hidden" name="guar_country_id" id="guar_country_id" value="{{$guradian_details->country_id}}">
                                                        <input type="hidden" name="guar_state_id" id="guar_state_id" value="{{$guradian_details->state_id}}">
                                                        <input type="hidden" name="guar_city_id" id="guar_city_id" value="{{$guradian_details->city_id}}">
                                                        <input type="hidden" name="guar_postal_code_id" id="guar_postal_code_id" value="{{$guradian_details->postal_code_id}}">
                                                        <div class="row guardian-input-row">
                                                            <div class="col-md-6">
                                                                <label>Guardian *</label>
                                                                <div class="form-group">
                                                                    <select name="guardian_status" class="form-control guardian_required" style="font-size: 13px" id="guardian_status" data-guardian-name="Guardian Status">
                                                                        <option value="">Select Guardian Status</option>
                                                                        <option value="0">No</option>
                                                                        <option value="1">Yes</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 guardian_form">
                                                                <label>First Name *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="guar_first_name" name="first_name" value="{{$guradian_details->first_name!='' ? $guradian_details->first_name : ''}}" class="form-control guardian_info" placeholder=""
                                                                        style="font-size: 13px" data-guardian-name="First Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 guardian_form">
                                                                <label>Middle Name</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="guar_middle_name" name="middle_name" value="{{$guradian_details->middle_name!='' ? $guradian_details->middle_name : ''}}" class="form-control" placeholder=""
                                                                        style="font-size: 13px">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 guardian_form">
                                                                <label>Last Name *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="guar_last_name" name="last_name" value="{{$guradian_details->last_name!='' ? $guradian_details->last_name : ''}}" class="form-control guardian_info" placeholder=""
                                                                        style="font-size: 13px" data-guardian-name="Last Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 guardian_form">
                                                                <label>DOB *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="datepicker" name="dob" value="{{$guradian_details->dob!='' ? $guradian_details->dob : ''}}" class="form-control form-datepicker guardian_info" placeholder=""
                                                                        style="font-size: 13px" data-guardian-name="Date of Birth">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 guardian_form">
                                                                <label>Relationship Type *</label>
                                                                <div class="form-group">
                                                                    <select class="custom-select custom-select-sm formselect guardian_info"  placeholder="Select Relation Ship Type" name="relationship_type" data-guardian-name="Relationship Type">
                                                                        <option selected value="">Select Relationship Type</option>
                                                                        <option value="12" {{$guradian_details->first_name != '' ? 'selected' : ''}}>Child Guardian</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 guardian_form">
                                                                <label>Gender *</label>
                                                                <div class="form-group">
                                                                    <select class="custom-select custom-select-sm formselect guardian_info" name="gender_id" id="guar_gender_id" data-guardian-name="Gender">
                                                                        <option selected value="">Select Gender</option>
                                                                        @foreach ($genders as $gender)
                                                                            <option value="{{$gender->id}}" {{$guradian_details == $gender->id ? 'selected' : ''}}>{{$gender->gender_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 guardian_form">
                                                                <label>Email *</label>
                                                                <div class="form-group">
                                                                    <input type="email" id="guar_email" name="email" value="{{$guradian_details->email!='' ? $guradian_details->email : ''}}" class="form-control guardian_info" placeholder=""
                                                                        style="font-size: 13px" data-guardian-name="Email">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 guardian_form">
                                                                <label>Home Phone Number *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="guar_home_phone_no" name="home_phone_no" value="{{$guradian_details->primary_landline!='' ? $guradian_details->primary_landline : ''}}" class="form-control guardian_info" placeholder=""
                                                                        style="font-size: 13px" data-guardian-name="Home Phone No.">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 guardian_form">
                                                                <label>Cell Phone Number *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="guar_cell_phone_no" name="cell_phone_no" value="{{$guradian_details->primary_cellphone!='' ? $guradian_details->primary_cellphone : ''}}" class="form-control guardian_info" placeholder=""
                                                                        style="font-size: 13px" data-guardian-name="Cell Phone No.">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 guardian_form">
                                                                <label>Country *</label>
                                                                <div class="form-group">
                                                                    <select id="all_countries_guar" name="country_id_guar" class="form-control guardian_info formselect all_countries_guar"
                                                                    style="font-size: 13px" data-guardian-name="Country">
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 guardian_form">
                                                                <label>Province *</label>
                                                                <div class="form-group">
                                                                    <select id="all_states_guar" name="state_id_guar" class="form-control guardian_info formselect all_states_guar"
                                                                    style="font-size: 13px" data-guardian-name="Province">
            
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 guardian_form">
                                                                <label>City *</label>
                                                                <div class="form-group">
                                                                    <select id="all_cities_guar" name="city_id_guar" class="form-control guardian_info formselect all_cities_guar"
                                                                    style="font-size: 13px" data-guardian-name="City">
            
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 guardian_form">
                                                                <label>Postal Code *</label>
                                                                <div class="form-group">
                                                                    <input type="text" id="postal_codes_guar" maxlength="6" minlength="6" name="postal_code_guar" class="form-control guardian_info"
                                                                    style="font-size: 13px" value="{{$guardian_postal_code->postal_code ? $guardian_postal_code->postal_code : ''}}" data-guardian-name="Postal Code">
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-12 pt-20">
                                                        <button type="button" name="guardian_save" id="guardian_save" class="btn w-btn float-right">Save & Continue</button>
                                                        <button type="button" class="btn w-btn float-right mr-1" name="previous_guardian_save" id="previous_guardian_save">Previous</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Will Assets --}}
                    <div class="tab-pane fade show YB-right" id="v-pills-10" role="tabpane7" aria-labelledby="v-pills-10-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Assets</h2>
                                            <span class="s_NO" id="s_no_assets">05</span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form id="SaveWillAssetsFrom">
                                                            @csrf
                                                        <input type="hidden" name="client_intake_form_id" id="client_intake_form_id" value="{{$client_intake_form->id}}">
                                                        <input type="hidden" name="intake_form_id" id="intake_form_id" value="{{$intake_form_id}}">
                                                        <input type="hidden" name="client_id" id="client_id" value="{{$clients->id}}">
                                                        <input type="hidden" name="intake_form_type" id="intake_form_type" value="{{$client_intake_form->intake_form_type}}">
                                                        <input type="hidden" name="intake_key" id="intake_key" value="{{$client_intake_form->unique_key}}">
                                                        <div class="row assets-input-row">
                                                            <div class="col-md-6">
                                                                <label>Moveable & Immovable Properties *</label>
                                                                <div class="form-group">
                                                                    <textarea class="form-control assets_required h-auto" rows="2" name="will_move_immove_property" id="will_move_immove_property"
                                                                    style="font-size: 13px" data-assets-name="Moveable & Immovable Properties">{{$client_intake_form->will_move_immove_property !='' ? $client_intake_form->will_move_immove_property : ''}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Bank Account *</label>
                                                                <div class="form-group">
                                                                    <textarea name="will_bank_account" id="will_bank_account" class="form-control assets_required h-auto" rows="2" 
                                                                    style="font-size: 13px" data-assets-name="Bank Accounts">{{$client_intake_form->will_bank_account !='' ? $client_intake_form->will_bank_account : ''}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Insurances *</label>
                                                                <div class="form-group">
                                                                    <textarea name="will_insurance" id="will_insurance" class="form-control assets_required h-auto" rows="2"
                                                                    style="font-size: 13px" data-assets-name="Insurances">{{$client_intake_form->will_insurance !='' ? $client_intake_form->will_insurance : ''}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>RRSP's *</label>
                                                                <div class="form-group">
                                                                    <textarea name="will_rrsp" id="will_rrsp" class="form-control assets_required h-auto" rows="2"
                                                                    style="font-size: 13px" data-assets-name="RRSP's">{{$client_intake_form->will_rrsp !='' ? $client_intake_form->will_rrsp : ''}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Shares *</label>
                                                                <div class="form-group">
                                                                    <textarea name="will_shares" id="will_shares" class="form-control assets_required h-auto" rows="2"
                                                                    style="font-size: 13px" data-assets-name="Shares">{{$client_intake_form->will_shares !='' ? $client_intake_form->will_shares : ''}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>All Other Valuables *</label>
                                                                <div class="form-group">
                                                                    <textarea name="will_valuables" id="will_valuables" class="form-control assets_required h-auto" rows="2"
                                                                    style="font-size: 13px" data-assets-name="All Other Valuables">{{$client_intake_form->will_valuables !='' ? $client_intake_form->will_valuables : ''}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                    <div class="col-md-12 pt-20">
                                                        <button type="button" name="assets_save" id="assets_save" class="btn w-btn float-right">Save & Continue</button>
                                                        <button type="button" class="btn w-btn float-right mr-1" name="previous_assets_save" id="previous_assets_save">Previous</button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Disposition of Assets --}}
                    <div class="tab-pane fade show YB-right" id="v-pills-11" role="tabpane7" aria-labelledby="v-pills-11-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Disposition of Assets</h2>
                                            <span class="s_NO" id="s_no_disposition">06</span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                        <form id="SaveWillDistributedForm">
                                                            @csrf
                                                        <input type="hidden" name="client_intake_form_id" id="client_intake_form_id" value="{{$client_intake_form->id}}">
                                                        <input type="hidden" name="intake_form_id" id="intake_form_id" value="{{$intake_form_id}}">
                                                        <input type="hidden" name="client_id" id="client_id" value="{{$clients->id}}">
                                                        <input type="hidden" name="intake_form_type" id="intake_form_type" value="{{$client_intake_form->intake_form_type}}">
                                                        <input type="hidden" name="intake_key" id="intake_key" value="{{$client_intake_form->unique_key}}">
                                                        <div class="row distributed-input-row">
                                                            <div class="col-md-12">
                                                                <label>How you wish the estate to be distributed ? *</label>
                                                                <div class="form-group">
                                                                    <textarea name="will_estate_distributed" id="will_estate_distributed" class="form-control distributed_required h-auto" rows="2"
                                                                    style="font-size: 13px" data-distributed-name="Estate Distributed">{{$client_intake_form->will_estate_distributed !='' ? $client_intake_form->will_estate_distributed : ''}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-12 pt-20">
                                                        <button type="button" name="distributed_save" id="distributed_save" class="btn w-btn float-right">Save & Continue</button>
                                                        <button type="button" class="btn w-btn float-right mr-1" name="previous_distributed_save" id="previous_distributed_save">Previous</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Funeral & Burial rites --}}
                    <div class="tab-pane fade show YB-right" id="v-pills-12" role="tabpane7" aria-labelledby="v-pills-12-tab">
                        <div class="CB_info white_form">
                            <div class="card">
                                <div class="im-form-wrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Funeral and Burial Rites</h2>
                                            <span class="s_NO" id="s_no_rites">07</span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                        <form id="SaveWillFuneralRitesForm">
                                                            @csrf
                                                        <input type="hidden" name="client_intake_form_id" id="client_intake_form_id" value="{{$client_intake_form->id}}">
                                                        <input type="hidden" name="intake_form_id" id="intake_form_id" value="{{$intake_form_id}}">
                                                        <input type="hidden" name="client_id" id="client_id" value="{{$clients->id}}">
                                                        <input type="hidden" name="intake_form_type" id="intake_form_type" value="{{$client_intake_form->intake_form_type}}">
                                                        <input type="hidden" name="intake_key" id="intake_key" value="{{$client_intake_form->unique_key}}">
                                                        <input type="hidden" name="funeral_form" value="funeral_finish">
                                                        <div class="row funeral-input-row">
                                                            <div class="col-md-12">
                                                                <label>Funeral & Burial Rites *</label>
                                                                <div class="form-group">
                                                                    <textarea type="text" name="will_funeral_burial_rites" id="will_funeral_burial_rites" class="form-control funeral_required h-auto" rows="2"
                                                                    style="font-size: 13px" data-funeral-name="Funeral & Burial Rites">{{$client_intake_form->will_funeral_burial_rites !='' ? $client_intake_form->will_funeral_burial_rites : ''}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-12 pt-20">
                                                        <button type="button" name="funeral_save" id="funeral_save" class="btn w-btn float-right">Finish</button>
                                                        <button type="button" class="btn w-btn float-right mr-1" name="previous_funeral_save" id="previous_funeral_save">Previous</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <p class="sm-text pt-10">
                    We respect your privacy and protecting it seriously. The use of information
                    collected through this form shall be limited to the purpose of providing the service for which you
                    have engaged us.
                </p>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="nav flex-column nav-pills CB-account-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <h3>Progress</h3>
                    <a class="nav-link active" id="v-pills-01-tab" data-toggle="pill" href="#v-pills-01" role="tab"
                        aria-controls="v-pills-01" aria-selected="true"><span class="sno">01</span>
                        @if($client_intake_form->intake_form_type == '5')
                        Testator
                        @else
                        Basic Information of the Primary Client
                        @endif
                    </a>
                    @if($client_intake_form->intake_form_type <= '4')
                    <a class="nav-link" id="v-pills-02-tab" data-toggle="pill" href="#v-pills-02" role="tab"
                        aria-controls="v-pills-02" aria-selected="false"><span class="sno">02</span>
                        Employment Information of the Primary Client</a>
                    <a class="nav-link" id="v-pills-03-tab" data-toggle="pill" href="#v-pills-03" role="tab"
                        aria-controls="v-pills-03" aria-selected="false"><span class="sno">03</span>
                        Marital Status </a>
                    <a class="nav-link" id="v-pills-04-tab" data-toggle="pill" href="#v-pills-04" role="tab" aria-controls="v-pills-04" aria-selected="false"><span class="sno">04</span> Capacity</a>
                    @endif

                    @if($client_intake_form->intake_form_type != '5')
                    <a class="nav-link" id="v-pills-05-tab" data-toggle="pill" href="#v-pills-05" role="tab"
                        aria-controls="v-pills-05" aria-selected="false"><span class="sno">
                        @if($client_intake_form->intake_form_type <= '4')
                            05
                        @elseif($client_intake_form->intake_form_type == '5')
                            04
                        @else
                            02
                        @endif
                        </span> ID/Documents
                        Uploading
                    </a>
                    @endif
                    @if($client_intake_form->intake_form_type <= '4')
                        <a class="nav-link" id="v-pills-07-tab" data-toggle="pill" href="#v-pills-07" role="tab"
                        aria-controls="v-pills-07" aria-selected="false"><span class="sno">
                            06
                        </span>
                        Consent And Sign-Off
                        </a>
                        <a class="nav-link" id="v-pills-13-tab" data-toggle="pill" href="#v-pills-13" role="tab"
                        aria-controls="v-pills-13" aria-selected="false"><span class="sno">07</span> Realestate Agent</a>
                        <a class="nav-link" id="v-pills-14-tab" data-toggle="pill" href="#v-pills-14" role="tab"
                        aria-controls="v-pills-14" aria-selected="false"><span class="sno">08</span> Mortgage Agent</a>
                        <a class="nav-link" id="v-pills-08-tab" data-toggle="pill" href="#v-pills-08" role="tab"
                        aria-controls="v-pills-08" aria-selected="false"><span class="sno">09</span> Document Required as
                        per the Email Templates</a>
                    @endif
                    @if($client_intake_form->intake_form_type > '4')
                    <a class="nav-link" id="v-pills-06-tab" data-toggle="pill" href="#v-pills-06" role="tab"
                        aria-controls="v-pills-06" aria-selected="false"><span class="sno">
                            @if($client_intake_form->intake_form_type == '5')
                            02
                            @else
                            03
                            @endif
                        </span>
                        @if($client_intake_form->intake_form_type == '5')
                        Beneficiaries
                        @else
                        Nominees
                        @endif
                    </a>
                    @endif
                    @if($client_intake_form->intake_form_type == '5')
                        <a class="nav-link" id="v-pills-09-tab" data-toggle="pill" href="#v-pills-09" role="tab"
                        aria-controls="v-pills-09" aria-selected="false"><span class="sno">03</span>Guardians</a>
                        <a class="nav-link" id="v-pills-05-tab" data-toggle="pill" href="#v-pills-05" role="tab"
                        aria-controls="v-pills-05" aria-selected="false"><span class="sno" id="sno_doc">04</span>  
                        ID/Documents Uploading
                    </a>
                        <a class="nav-link" id="v-pills-10-tab" data-toggle="pill" href="#v-pills-10" role="tab"
                        aria-controls="v-pills-10" aria-selected="false"><span class="sno" id="sno_assets">05</span>Assets</a>
                        <a class="nav-link" id="v-pills-11-tab" data-toggle="pill" href="#v-pills-11" role="tab"
                        aria-controls="v-pills-11" aria-selected="false"><span class="sno" id="sno_disposition">06</span>Disposition of Assets</a>
                        <a class="nav-link" id="v-pills-12-tab" data-toggle="pill" href="#v-pills-12" role="tab"
                        aria-controls="v-pills-12" aria-selected="false"><span class="sno" id="sno_rites">07</span>Funeral & Burial Rites</a>
                    @endif
                    <!-- <a class="nav-link" id="v-pills-08-tab" data-toggle="pill" href="#v-pills-08" role="tab" aria-controls="v-pills-08" aria-selected="false"><span class="sno">08</span> .</a>
                        <a class="nav-link" id="v-pills-09-tab" data-toggle="pill" href="#v-pills-09" role="tab" aria-controls="v-pills-09" aria-selected="false"><span class="sno">09</span> .</a>
                        <a class="nav-link" id="v-pills-10-tab" data-toggle="pill" href="#v-pills-10" role="tab" aria-controls="v-pills-10" aria-selected="false"><span class="sno">10</span> .</a>
                        <a class="nav-link" id="v-pills-11-tab" data-toggle="pill" href="#v-pills-11" role="tab" aria-controls="v-pills-11" aria-selected="false"><span class="sno">11</span> .</a>					   -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
