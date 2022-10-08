
<?php $__env->startSection('data-sidebar'); ?>
<div id="product-cl-sec">
    <a id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span id="opp_name"></span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <form style="display: flex;" id="saveSettingsForm">
                                    <?php echo csrf_field(); ?>
                                    <input type="text" id="operation" name="operation" hidden>
                                    <input type="text" id="opp_id" name="opp_id" hidden>
                                    <input type="text" id="opp_name_input" name="opp_name_input" hidden>

                                    <div id="floating-label" class="card p-20 top_border mb-3 designation_form_div" style="width: 100%; display:none">
                                        <h2 class="_head03">Designation <span>Details</span></h2>
                                        <div class="form-wrap p-0 font13">
                                            <div class="row">
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Designation Name*</label>
                                                        <input type="text" name="designation_name" class="form-control required_designation">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                        <input type="checkbox" name="rights[]" class="custom-control-input custom_checkbox" value="all_tasks" id="all_tasks">
                                                        <label class="custom-control-label" for="all_tasks">All
                                                            Tasks</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                        <input type="checkbox" name="rights[]" class="custom-control-input custom_checkbox" value="emp_activity" id="emp_activity">
                                                        <label class="custom-control-label" for="emp_activity">Employee
                                                            Activity</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                        <input type="checkbox" name="rights[]" class="custom-control-input custom_checkbox" value="pnl_access" id="pnl_access">
                                                        <label class="custom-control-label" for="pnl_access">Admin Access</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="floating-label" class="card p-20 top_border mb-3 department_form_div" style="width: 100%; display:none">
                                        <h2 class="_head03">Department <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Department Name*</label>
                                                        <input type="text" name="department_name" class="form-control required_department">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="floating-label" class="card p-20 top_border mb-3 assets_form_div" style="width: 100%; display:none">
                                        <h2 class="_head03">Assets <span>Types</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Asset Title*</label>
                                                        <input type="text" name="asset_name" class="form-control required_asset_name">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="floating-label" class="card p-20 top_border mb-3 custType_form_div" style="width: 100%; display:none">
                                        <h2 class="_head03">Customer <span>Types</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Type Name*</label>
                                                        <input type="text" name="customer_type" class="form-control required_customer_type">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Discount (%)*</label>
                                                        <input type="number" name="discount" class="form-control required_customer_type">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="floating-label" class="card p-20 top_border mb-3 exchangeRateDiv" style="width: 100%; display:none">
                                        <h2 class="_head03">Exchange <span>Rates</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Exchange Rate*</label>
                                                        <input type="number" name="exchange_rate" class="form-control required_exchange_rate">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Start Date*</label>
                                                        <input type="text" name="date_from" class="form-control required_exchange_rate">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">End Date*</label>
                                                        <input type="text" name="date_till" class="form-control required_exchange_rate">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Select Currency*</label>
                                                        <select class="form-control" name="currency" placeholder="Select Currency" style="width: 100%">
                                                            <option sign="$" value="USD">USD - United States Dollar
                                                            </option>
                                                            <option sign="HK$" value="HKD">HKD — Hong Kong dollar
                                                            </option>
                                                            <option sign="AFN" value="AFN">AFN — Afghani</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="floating-label" class="card p-20 top_border mb-3 CompanyInfoDiv" style="width: 100%; display:none">
                                        <h2 class="_head03">Company <span>Info</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Business Title*</label>
                                                        <input type="text" name="business_title" class="form-control required_company_info">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Business Number*</label>
                                                        <input type="text" name="business_number" class="form-control required_company_info">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Business Email*</label>
                                                        <input type="text" name="business_email" class="form-control required_company_info">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Postal Code*</label>
                                                        <input type="text" name="postal_code" class="form-control required_company_info" maxlength="6">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Business Address*</label>
                                                        <input type="text" name="business_address" class="form-control required_company_info">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="floating-label" class="card p-20 top_border mb-3 PalletInfoDiv" style="width: 100%; display:none">
                                        <h2 class="_head03">Pallet <span>Info</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Pallet Name*</label>
                                                        <input type="text" name="pallet_name" class="form-control required_pallet_info">
                                                    </div>
                                                </div>

                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Empty Pallet Weight*</label>
                                                        <input type="text" name="empty_pallet_weight" class="form-control required_pallet_info only_numerics">
                                                    </div>
                                                </div>

                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Pallet Length*</label>
                                                        <input type="text" name="pallet_length" class="form-control required_pallet_info only_numerics">
                                                    </div>
                                                </div>

                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Pallet Width</label>
                                                        <input type="text" name="pallet_width" class="form-control required_pallet_info only_numerics">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="floating-label" class="card p-20 top_border mb-3 gender_form_div" style="width: 100%; display:none">
                                        <h2 class="_head03">Gender <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Gender Name*</label>
                                                        <input type="text" name="gender_name" class="form-control required_gender">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="floating-label" class="card p-20 top_border mb-3 relation_form_div" style="width: 100%; display:none">
                                        <h2 class="_head03">Relationship <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Relation Name*</label>
                                                        <input type="text" name="relation_name" class="form-control required_relation">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="floating-label" class="card p-20 top_border mb-3 property_form_div" style="width: 100%; display:none">
                                        <h2 class="_head03">Property <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Property Name*</label>
                                                        <input type="text" name="property_name" class="form-control required_property">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="floating-label" class="card p-20 top_border mb-3 documentVerification_form_div" style="width: 100%; display:none">
                                        <h2 class="_head03">Verification Documents <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Verification Title *</label>
                                                        <input type="text" name="document_verification_name" class="form-control required_documentverification">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="floating-label" class="card p-20 top_border mb-3 ContactTypes" style="width: 100%; display:none">
                                        <h2 class="_head03">Contact <span>Types</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Type Name*</label>
                                                        <input type="text" name="contact_name" class="form-control required_contact_types">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pt-5" id="contact_type_flag">
                                                    <label class="border-0 mb-10" style="font-size:13px">Type*</label>
                                                    <div class="form-s2">
                                                        <select name="contact_type_flag" id="contact_type_flag" class="formselect required_contact_types">
                                                            <option value="0">Type</option>
                                                            <option value="1">Client</option>
                                                            <option value="2">Realtor</option>
                                                            <option value="3">Mortgage Agent</option>
                                                            <option value="4">Banker</option>
                                                            <option value="5">Lender</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="floating-label" class="card p-20 top_border mb-3 residence_form_div" style="width: 100%; display:none">
                                        <h2 class="_head03">Residence <span>Status</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Residence Name*</label>
                                                        <input type="text" name="residence_name" class="form-control required_residence">
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
        <button type="button" class="btn btn-primary mr-2" id="saveBtn">Save</button>
        <button id="pl-close" type="button" class="btn btn-cancel mr-2" id="cancelBtn">Cancel</button>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Settings <span></span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Settings</span></a></li>
            <li><span>Setting Details</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card _Dispatch">
            <div class="header">
                <h2>Setting <span>Details</span></h2>
            </div>
            <div class="row m-0">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="nav flex-column nav-pills CB-account-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <!-- <a class="nav-link active" id="v-pills-06-tab" data-toggle="pill" href="#v-pills-06" role="tab" aria-controls="v-pills-06" aria-selected="false">Company Information </a> -->
                        <a class="nav-link " id="v-pills-01-tab" data-toggle="pill" href="#v-pills-01" role="tab" aria-controls="v-pills-01" aria-selected="true">Designations</a>
                        <a class="nav-link" id="v-pills-02-tab" data-toggle="pill" href="#v-pills-02" role="tab" aria-controls="v-pills-02" aria-selected="false">Departments </a>
                   <!-- <a class="nav-link" id="v-pills-03-tab" data-toggle="pill" href="#v-pills-03" role="tab" aria-controls="v-pills-03" aria-selected="false">Assets Types </a> -->
                        <!-- <a class="nav-link" id="v-pills-04-tab" data-toggle="pill" href="#v-pills-04" role="tab" aria-controls="v-pills-04" aria-selected="false">Customer Types </a> -->


                        <a class="nav-link" id="v-pills-08-tab" data-toggle="pill" href="#v-pills-08" role="tab" aria-controls="v-pills-08" aria-selected="false">Gender </a>
                        <a class="nav-link" id="v-pills-10-tab" data-toggle="pill" href="#v-pills-10" role="tab" aria-controls="v-pills-10" aria-selected="false">Relationship Types </a>
                        <!-- <a class="nav-link" id="v-pills-11-tab" data-toggle="pill" href="#v-pills-11" role="tab" aria-controls="v-pills-11" aria-selected="false">Property Types </a> -->
                        <a class="nav-link" id="v-pills-12-tab" data-toggle="pill" href="#v-pills-12" role="tab" aria-controls="v-pills-12" aria-selected="false">Verification Documents </a>
                        <!-- <a class="nav-link" id="v-pills-09-tab" data-toggle="pill" href="#v-pills-09" role="tab" aria-controls="v-pills-09" aria-selected="false">Contact Types </a> -->
                        <!-- <a class="nav-link" id="v-pills-13-tab" data-toggle="pill" href="#v-pills-13" role="tab" aria-controls="v-pills-13" aria-selected="false">Residence Status </a> -->
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-12 ml-800">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active " id="v-pills-01" role="tabpanel" aria-labelledby="v-pills-01-tab">
                            <div class="col-md-12 PT-20 mb-0">
                                <h2 class="_head04">Designations
                                    <a class="btn add_button openDataSidebarForAddingDesignation" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> New Designation</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 body_designations mt-20 mb-30">

                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-02" role="tabpanel" aria-labelledby="v-pills-02-tab">
                            <div class="col-md-12 mb-0" style="padding-top:20px !important">
                                <h2 class="_head04">Departments
                                    <a class="btn add_button openDataSidebarForAddingDepartment" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> New Department</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 body_departments mt-20 mb-30">

                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-03" role="tabpanel" aria-labelledby="v-pills-03-tab">
                            <div class="col-md-12 mb-0" style="padding-top:20px !important">
                                <h2 class="_head04">Assets Types
                                    <a class="btn add_button openDataSidebarForAddingAssets" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> New Asset Type</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 body_assets mt-20 mb-30">

                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-04" role="tabpanel" aria-labelledby="v-pills-04-tab">
                            <div class="col-md-12 mb-0" style="padding-top:20px !important">
                                <h2 class="_head04">Customer Type
                                    <a class="btn add_button openDataSidebarForAddingCustType" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> New Customer Type</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 body_cust_type mt-20 mb-30">

                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-05" role="tabpanel" aria-labelledby="v-pills-05-tab">
                            <div class="col-md-12 mb-0" style="padding-top:20px !important">
                                <h2 class="_head04">Exchange Rates
                                    <a class="btn add_button openDataSidebarForAddingExchangeRate" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> New Exchange Rate</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 exchangeRatesDiv mt-20 mb-30">
                            </div>
                        </div>

                        <div class="tab-pane fade " id="v-pills-06" role="tabpanel" aria-labelledby="v-pills-06-tab">
                            <div class="col-md-12 mb-0" style="padding-top:20px !important">
                                <h2 class="_head04">Company Information
                                    <a class="btn add_button openDataSidebarForAddingCompanyInfo" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> New Information</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 CompanyInfoTableDiv mt-20 mb-30">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-07" role="tabpanel" aria-labelledby="v-pills-07-tab">
                            <div class="col-md-12 mb-0" style="padding-top:20px !important">
                                <h2 class="_head04">Pallets
                                    <a class="btn add_button openDataSidebarForAddingNewPallet" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> New Pallet</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 PalletsInfoTableDiv mt-20 mb-30">
                            </div>
                        </div>


                        <div class="tab-pane fade" id="v-pills-08" role="tabpanel" aria-labelledby="v-pills-08-tab">
                            <div class="col-md-12 mb-0" style="padding-top:20px !important">
                                <h2 class="_head04">Gender
                                    <a class="btn add_button openDataSidebarForAddingGenderType" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> New Gender</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 body_gender mt-20 mb-30">

                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-13" role="tabpanel" aria-labelledby="v-pills-13-tab">
                            <div class="col-md-12 mb-0" style="padding-top:20px !important">
                                <h2 class="_head04">Residence Status
                                    <a class="btn add_button openDataSidebarForAddingResidenceStatus" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> New Residence</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 ResidenceTableDiv mt-20 mb-30">
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-09" role="tabpanel" aria-labelledby="v-pills-09-tab">
                            <div class="col-md-12 mb-0" style="padding-top:20px !important">
                                <h2 class="_head04">Contact Types
                                    <a class="btn add_button openDataSidebarForAddingContactTypes" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> Contact Types</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 ContactTypesTableDiv mt-20 mb-30">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-10" role="tabpanel" aria-labelledby="v-pills-10-tab">
                            <div class="col-md-12 mb-0" style="padding-top:20px !important">
                                <h2 class="_head04">Relationship Type
                                    <a class="btn add_button openDataSidebarForAddingRelation" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> New Relation</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 body_relation mt-20 mb-30">

                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-11" role="tabpanel" aria-labelledby="v-pills-11-tab">
                            <div class="col-md-12 mb-0" style="padding-top:20px !important">
                                <h2 class="_head04">Property Type
                                    <a class="btn add_button openDataSidebarForAddingProperty" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> New Property</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 body_property mt-20 mb-30">

                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-12" role="tabpanel" aria-labelledby="v-pills-12-tab">
                            <div class="col-md-12 mb-0" style="padding-top:20px !important">
                                <h2 class="_head04">Verification Documents
                                    <a class="btn add_button openDataSidebarForAddingDocumentVerification" style="right:0px; top:-7px;"><i class="fa fa-plus"></i> New Verification Document</a>
                                </h2>
                            </div>
                            <div style="min-height: 400px" class="loader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 40%; top: 45%;">
                            </div>
                            <div class="col-md-12 productRate-table m-0 body_document_verification mt-20 mb-30">

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Sourcecode-Academia-BE\resources\views/settings/settings.blade.php ENDPATH**/ ?>