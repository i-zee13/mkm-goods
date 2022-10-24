@extends('layouts.master')
@section('data-sidebar')

<style>
	.nav-pills .nav-link.active ._cus-val,
	.nav-tabs .nav-link.active ._cus-val {
		color: #fff;
		background-color: #EBB30A;
	}

	.profile-center .nav-pills .nav-link.active,
	._report-Head .nav-pills .nav-link.active {
		color: #040827;
	}

	.nav-pills .nav-link ._cus-val,
	.nav-tabs .nav-link ._cus-val {
		background-color: #e2e9fb;
		color: #7f8998;
		font-size: 10px;
		padding: 3px 4px 2px 4px;
		height: 16px;
		margin-top: 3px;
		margin-left: 5px;
		font-family: proximanova-light, sans-serif;
		border-radius: 5px;
		display: inline-block;
		line-height: 1;
	}

	.target-tab {
		height: 50px;
		margin-top: 15px;
		padding-top: 5px;
		background-color: #fff;
		position: relative;
	}

	.dataTable td,
	.modal-body table td {
		padding: 5px 5px;
		vertical-align: middle;
	}

	.add_button {
		right: 15px;
		top: -2px;
		padding: 4px 15px;
	}

	.table th {
		letter-spacing: normal;
	}

	.pocPROFILE .infoDiv {
		padding: 5px 8px;
	}

	.pocPROFILE .fa {
		color: #fff;
	}

	.pt-0 {
		padding-top: 0 !important;
	}

	.select2 {
		width: 100% !important;
	}

	.cnicCardimg {
		width: 500px;
		height: auto;
		display: block;
		margin: 15px auto;
	}
</style>
<div class="modal fade preview" id="ViewCNICimg" tabindex="-1" role="dialog" aria-labelledby="DetailModalLabel" aria-hidden="true">
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
				<button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>
<div id="product-cl-sec"> <a href="#" id="pl-close" class="close-btn-pl"></a>

	<div class="pro-header-text ml-0">Add <span>Details </span></div>
	<div class="pc-cartlist">
		<div class="overflow-plist">
			<div class="plist-content">
				<div class="_left-filter">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<form style="display: flex;" id="saveClientForm">
									@csrf
									<input type="text" id="client_id" name="client_id" value="{{$client->id}}" hidden>
									<input type="text" id="gender_id" name="gender_id" value="{{$client->gender_id}}" hidden>

									<input type="text" id="operation" name="operation" hidden>
									<input type="text" id="opp_id" name="opp_id" hidden>
									<input type="text" id="secondary_id" name="secondary_id" value="" hidden>
									<input type="text" id="opp_name_input" name="opp_name_input" hidden>
									<div id="floating-label" class="card p-20 pt-0 top_border">



										<div class="form-wrap p-0">

											<div class="row address_form_div " id="address">
												<div class="col-md-12 mt-20">
													<h2 class="_head03">Address <span>Detail</span></h2>
												</div>
												<div class="col-md-3 pr-0">
													<label class="font11 mb-0">Select Address Type</label>
													<select class="custom-select custom-select-sm" name="address_type">
														<option value="0" selected>Type</option>
														<option value="1">Business</option>
														<option value="2">Residential</option>
													</select>
												</div>

												<div class="col-md-9 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">Address *</label>
														<input type="text" class="form-control required_address" name="primary_address">
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">House # *</label>
														<input type="text" class="form-control required_address" name="house_no">
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">Landline Number *</label>
														<input type="text" class="form-control landline required_address" name="primary_landline">
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">Cellphone Number *</label>
														<input type="text" class="form-control cellphone required_address" name="primary_cellphone">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-s2" style="width:100%">
														<label class="font11 mb-0">Country *</label>
														<select class="form-control countries formselect  required_address" placeholder="Select Residency" id="countries" name="country_id">

														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-s2">
														<label class="font11 mb-0">State *</label>
														<select class="form-control formselect  required_address" placeholder="Select Province/State" id="states" name="state_id">

														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-s2">
														<label class="font11 mb-0">City *</label>
														<select class="form-control formselect  required_address" placeholder="" id="cities" name="city_id">

														</select>
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-s2">
														<label class="font11 mb-0">Postal Code *</label>
														<select class="form-control formselect required_address " placeholder="" id="postal_code" name="postal_code_id">

														</select>
													</div>
												</div>

											</div>


											<div class="row employe_form_div">
												<div class="col-md-12 mt-20">
													<h2 class="_head03">Employment <span>Information</span></h2>
												</div>

												<div class="col-md-6 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">Company Name *</label>
														<input type="text" class="form-control required_employee" name="company_name">
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">Phone Number *</label>
														<input type="text" class="form-control required_employee" name="company_contact_number">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-s2">
														<label class="font11 mb-0">Job Title *</label>
														<input type="text" class="form-control required_employee" name="job_title">

													</div>
												</div>
												<div class="col-md-6">
													<div class="form-s2">
														<label class="font11 mb-0">Employment Status *</label>
														<select class="form-control formselect required_employee" placeholder="Select Status" name="employment_status">
															<option selected>Select Status</option>
															<option value="1">Active</option>
															<option value="2">In-Active</option>
														</select>
													</div>
												</div>

												<div class="col-md-6 pt-10">
													<div class="form-group">
														<label class="control-label mb-10">Office No *</label>
														<input type="text" class="form-control required_employee" name="office_no">
													</div>
												</div>
												<div class="col-md-6 pt-10">
													<div class="form-group">
														<label class="control-label mb-10">Street Address *</label>
														<input type="text" class="form-control required_employee" name="street_address">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-s2">
														<label class="font11 mb-0">Country *</label>
														<select class="form-control formselect countries_Employment  required_employee" placeholder="Select Residency" id="country_Employment" name="country_id2">

														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-s2">
														<label class="font11 mb-0">State *</label>
														<select class="form-control formselect required_employee" placeholder="Select Province/State" id="states_Employment" name="state_id2">

														</select>
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-s2">
														<label class="font11 mb-0">City *</label>
														<select class="form-control formselect  required_employee" placeholder="" id="cities_Employment" name="city_id2">

														</select>
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-s2">
														<label class="font11 mb-0">Postal Code *</label>
														<select class="form-control formselect required_employee" placeholder="" id="postal_code_Employment" name="postal_code_id2">

														</select>
													</div>
												</div>
											</div>



											<div class="row martial_form_div">
												<div class="col-md-12 mt-20">
													<h2 class="_head03">Marital <span>Status</span></h2>
												</div>
												<div class="col-md-6">
													<div class="form-s2">
														<label class="font11 mb-0">Marital Status</label>
														<select class="form-control formselect" placeholder="select Marital Status">
															<option selected>Select Marital Status</option>
															<option>Marital Status</option>
														</select>
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">Spouse / Partner First Name</label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">Spouse / Partner Middle Name</label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">Spouse/ Partner Last Name</label>
														<input type="text" class="form-control">
													</div>
												</div>

												<div class="col-md-6">
													<label class="font11 mb-0">Select Gender</label>
													<select class="custom-select custom-select-sm">
														<option selected>Select Gender</option>
														<option value="1">Male</option>
														<option value="2">Female</option>
													</select>
												</div>

												<div class="col-md-6 PT-5">
													<div class="form-group">
														<label class="control-label mb-10">Email</label>
														<input type="text" class="form-control">
													</div>
												</div>


												<div class="col-md-6 PT-5">
													<div class="form-group">
														<label class="control-label mb-10">Home Phone Number</label>
														<input type="text" class="form-control">
													</div>
												</div>

												<div class="col-md-6 PT-5">
													<div class="form-group">
														<label class="control-label mb-10">Cell Phone Number</label>
														<input type="text" class="form-control">
													</div>
												</div>

											</div>



											<div class="row documents_form_div">
												<div class="col-md-12 mt-20">
													<h2 class="_head03">Client <span>Identification Documents</span></h2>
												</div>
												<div class="col-md-6">
													<div class="form-s2">
														<label class="font11 mb-0">Document Type *</label>
														<select class="form-control formselect" placeholder="select Document Type" name="document_type">
															<option selected>Select Document Type </option>
															@foreach($documents as $document)
															<option value="{{$document->id}}">{{$document->document_verification_name}}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">Document Number *</label>
														<input type="text" class="form-control required_document" name="document_number">
													</div>
												</div>
												<div class="col-md-6">
													<label class="font12 mb-0">Document Issuance Date *</label>
													<input autocomplete="off" type="text" id="datepicker" class="form-control issue_date " placeholder="" name="issuance_date">
												</div>
												<div class="col-md-6">
													<label class="font12 m-0">Document Expiry Date *</label>
													<input autocomplete="off" type="text" id="datepicker2" class="form-control expire_date " placeholder="" name="expiry_date">
												</div>

												<div class="col-md-6 pt-5">
													<div class="form-wrap p-0">
														<label class="font11 mb-5">Document Front Image *</label>
														<div class="upload-pic  " id="front_img">

														</div>
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-wrap p-0">
														<label class="font11 mb-5">Document Back Image *</label>
														<div class="upload-pic " id="back_img">

														</div>
													</div>
												</div>

											</div>


											<div class="row relatives_form_div">
												<div class="col-md-12 mt-20">
													<h2 class="_head03">Add <span>Relatives</span></h2>
													{{--<button id="" class="btn add_button openDataSidebarForAddingAddress"> Add New</button>--}}
												</div>
												<div class="col-md-6 pt-5">


													<input type="text" class="form-control" value="{{$client->first_name}} {{$client->last_name}}" readonly hidden>



													<div class="form-s2">
														<label class="font11 mb-0">Relation Ship Type *</label>
														<select class="form-control formselect" placeholder="Select Relation Ship Type" name="relationship_type">
															<option selected>Select Relation Ship Type</option>
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
												<div class="col-md-6 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">Relative First Name *</label>
														<input type="text" class="form-control required_relative" name="first_name">
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">Relative Partner Middle Name *</label>
														<input type="text" class="form-control required_relative" name="middle_name">
													</div>
												</div>
												<div class="col-md-6 pt-5">
													<div class="form-group">
														<label class="control-label mb-10">Relative Partner Last Name *</label>
														<input type="text" class="form-control required_relative" name="last_name">
													</div>
												</div>

												<div class="col-md-6 form-s2">
													<label class="font11 mb-0">Select Gender *</label>
													<select class="custom-select   required_relative " name="re_gender_id">
														<option value="">Select Gender</option>
														<option value="1">Male</option>
														<option value="2">Female</option>
													</select>
												</div>

												<div class="col-md-6 PT-5">
													<div class="form-group">
														<label class="control-label mb-10">Email *</label>
														<input type="text" class="form-control required_relative" name="email">
													</div>
												</div>


												<div class="col-md-6 PT-5">
													<div class="form-group">
														<label class="control-label mb-10">Home Phone Number *</label>
														<input type="text" class="form-control required_relative" name="home_phone_no">
													</div>
												</div>

												<div class="col-md-6 PT-5">
													<div class="form-group">
														<label class="control-label mb-10">Cell Phone Number *</label>
														<input type="text" class="form-control required_relative" name="cell_phone_no">
													</div>
												</div>

											</div>



										</div>



									</div>

								</form>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="_cl-bottom">
		<button type="submit" class="btn btn-primary mr-2" id="formSave_Btn">Save</button>
		<button id="pl-close" type="submit" class="btn btn-cancel mr-2">Cancel</button>
	</div>
</div>


@endsection
@section('content')
<div id="wrapper">


	<div id="content-wrapper">
		<div class="overlay-blure"></div>
		<div id="blureEffct" class="container">

			<div class="row mt-2 mb-3">



				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="_head01">Client : <span> {{$client->first_name}}</span></h2>
				</div>

				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						<li><a href="/clients"><span>Client</span></a></li>
						<li><span>Detail</span></li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 mb-30">
					<div class="card PB-20">
						<div class="body pocPROFILE pb-0">
							<div class="row">
								<div class="col-12">
									<div class="header pt-0">
										<h2>Client <span>Definition</span></h2>
										<button type="button" class="btn add_button" style="top:-6px!important; right:0!important;" id="edit_client_record" data-id="{{ $client->id }}" onClick="edit_client('{{ $client->id }}')"><i class="fa fa-pencil"></i> <span> Edit</span></button>
									</div>
								</div>
								<input type="text" id="student_id" name="student_id" value="{{$client->id}}" hidden>



								<div class="col-12 PB-10">
									<div class="form-wrap p-0">
										<div class="row">
											<div class="col-md-4 p-col-L">
												<div class="infoDiv">
													<label class="control-label">Contact Type</label>
													<p><strong>
															{{$client->client_type ? $client->client_type  : "NA"}}

														</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-R p-col-L">
												<div class="infoDiv">
													<label class="control-label">Acquisition Source</label>
													<p><strong>

															{{$client->acquisition_source ? $client->acquisition_source : "NA" }}
														</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-R">
												<div class="infoDiv">
													<label class="control-label">Life Cycle Stage</label>
													<p><strong>
															{{($client->life_cycle_stage==1 ? ' Lead' : ($client->life_cycle_stage==2 ? 'Prospect' :($client->life_cycle_stage==3 ? 'Client' : 'Churned' )))}}


														</strong></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>


							<div class="row">
								<div class="col-12">
									<div class="header pt-0">
										<h2>Basic <span>Information</span></h2>
									</div>
								</div>

								<div class="col-12 PB-10">
									<div class="form-wrap p-0">
										<div class="row">
											<div class="col-md-4 p-col-L">
												<div class="infoDiv">
													<label class="control-label">Frist Name</label>
													<p><strong>{{$client->first_name}}</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-R p-col-L">
												<div class="infoDiv">
													<label class="control-label">Middle Name</label>
													<p><strong>{{$client->middle_name ? $client->middle_name : "NA"}}</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-R">
												<div class="infoDiv">
													<label class="control-label">Last Name</label>
													<p><strong>{{$client->last_name}}</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-L">
												<div class="infoDiv">
													<label class="control-label">Date of Birth</label>
													<p><strong>{{$client->dob ? $client->dob : "NA"}}</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-R p-col-L">
												<div class="infoDiv">
													<label class="control-label">Gender</label>
													<p><strong>{{$client->gender ? $client->gender : "NA"}}</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-R">
												<div class="infoDiv">
													<label class="control-label">Residency Status</label>
													<p><strong>{{$client->residence ? $client->residence : "NA"}}</strong></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>


							<div class="row">
								<div class="col-12">
									<div class="header pt-0">
										<h2>Primary <span>Contact Info</span></h2>
									</div>
								</div>

								<div class="col-12">
									<div class="form-wrap p-0">
										<div class="row">
											<div class="col-md-4 p-col-L">
												<div class="infoDiv">
													<label class="control-label">Home Phone Number</label>
													<p><strong>{{$client->primary_landline ? $client->primary_landline : "NA"}}</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-R p-col-L">
												<div class="infoDiv">
													<label class="control-label">Cell Phone Number</label>
													<p><strong>{{$client->primary_cellphone ? $client->primary_cellphone : "NA"}}</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-R">
												<div class="infoDiv">
													<label class="control-label">email</label>
													<p><strong>{{$client->email ? $client->email : "NA"}}</strong></p>
												</div>
											</div>
											<div class="col-md-8 p-col-L">
												<div class="infoDiv">
													<label class="control-label">Home Address</label>
													<p><strong>{{$client->primary_address ? $client->primary_address : "NA"}}</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-R">
												<div class="infoDiv">
													<label class="control-label">Country</label>
													<p><strong> {{$client->country}}</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-L">
												<div class="infoDiv">
													<label class="control-label">State/Province</label>
													<p><strong>{{$client->state}}</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-L p-col-R">
												<div class="infoDiv">
													<label class="control-label">City</label>
													<p><strong> {{$client->city}}</strong></p>
												</div>
											</div>
											<div class="col-md-4 p-col-R">
												<div class="infoDiv">
													<label class="control-label">Postal Code</label>
													<p><strong>{{$client->postal_code ? $client->postal_code : "NA"}}</strong></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>


						<div class="col-12">
							<div class="_report-Head target-tab">
								<ul class="nav nav-pills mb-3 mt-0" id="pills-tab2" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="pills-target-p" data-toggle="pill" href="#target-p" role="tab" aria-controls="-target-p" aria-selected="true">Addresses <span class="_cus-val count_address">0
											</span></a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="pills-product-tab2" data-toggle="pill" href="#pills-product2" role="tab" aria-controls="pills-product2" aria-selected="true">Employment Info <span class="_cus-val count_employment">0
											</span></a>
									</li>




									<li class="nav-item">
										<a class="nav-link" id="pills-channels2-tab" data-toggle="pill" href="#pills-channels2" role="tab" aria-controls="pills-channels2" aria-selected="false">Documents<span class="_cus-val  count_document">0</span></a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="pills-otherkpi2-tab" data-toggle="pill" href="#pills-otherkpi2" role="tab" aria-controls="pills-otherkpi2" aria-selected="false">Relatives <span class="_cus-val count_relatives">0</span></a>
									</li>
								</ul>
							</div>

							<div class="tab-content" id="pills-tabContent2">

								<div class="tab-pane fade show active" id="target-p" role="tabpanel" aria-labelledby="target-p-tab">
									<div class="col-12 pl-0 pr-0 PT-20 PB-10">
										<div class="header pt-0">
											<h2>Address <span>List</span></h2>
											<button id="" class="btn add_button openDataSidebarForAddingAddress"><i class="fa fa-plus"></i> Add New
											</button>
										</div>
										<div style="min-height: 400px" class="loader">
											<img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
										</div>
										<div class="col-md-12 productRate-table m-0 body_address mt-20 mb-30">

										</div>
									</div>
									<div>

									</div>


								</div>

								<div class="tab-pane fade show" id="pills-product2" role="tabpanel" aria-labelledby="pills-product2-tab">
									<div class="col-12 pl-0 pr-0 PT-20 PB-10">
										<div class="header pt-0">
											<h2>Employment <span>Information</span></h2>
											<button id="productlist01" class="btn add_button openDataSidebarForAddingEmpolyment"><i class="fa fa-plus"></i> <span> Add New
												</span></button>
										</div>
									</div>
									<div style="min-height: 400px" class="loader">
										<img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
									</div>
									<div class="col-md-12 productRate-table m-0 body_employe mt-20 mb-30">

									</div>



								</div>



								<div class="tab-pane fade" id="pills-channels2" role="tabpanel" aria-labelledby="pills-channels-tab2">
									<div class="col-12 pl-0 pr-0 PT-20 PB-10">
										<div class="header pt-0">
											<h2>Client <span>Identification Documents</span></h2>
											<button id="productlist01" class="btn add_button openDataSidebarForAddingDocument"><i class="fa fa-plus"></i> <span> Add New
												</span></button>
										</div>
										<div style="min-height: 400px" class="loader">
											<img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
										</div>
										<div class="col-md-12 productRate-table m-0 body_document mt-20 mb-30">

										</div>
									</div>

								</div>

								<div class="tab-pane fade" id="pills-otherkpi2" role="tabpanel" aria-labelledby="pills-otherkpi2-tab">

									<div class="col-12 pl-0 pr-0 PT-20 PB-10">
										<div class="header pt-0">
											<h2>Relatives<span></span></h2>
											<button id="productlist01" class="btn add_button openDataSidebarForAddingRelative"><i class="fa fa-plus"></i> <span> Add New
												</span></button>
										</div>
										<div style="min-height: 400px" class="loader">
											<img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
										</div>
										<div class="col-md-12 productRate-table m-0 body_relative mt-20 mb-30">

										</div>
									</div>



								</div>


							</div>
						</div>


					</div>

				</div>
			</div>




			@endsection