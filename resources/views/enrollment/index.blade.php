@extends('layouts.master')
@section('data-sidebar')
    <div id="product-cl-sec" class="faqs-sidebar">
        <a href="#" id="pl-close" class="close-btn-pl"></a>
        <div class="pro-header-text">New <span>Enrollment</span></div>
        <div class="pc-cartlist">
            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter pt-0">
                        <input type="hidden" id="p_service">
                        <input type="hidden" id="s_service">
                        <input type="hidden" id="s_s_service">
                        <form id="SaveEnrollmentForm">
                            @csrf
                            <input type="hidden" name="hidden_faq_id">
                            <div class="se_cus-type p-20">
                                <!-- <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="_head04 border-0 mb-0">Select FAQ <span>Type *</span></h2>
                                        <div class="form-s2">
                                            <select class="form-control faq-required" name="faq_type" id="faq_type" placeholder="select Grade">
                                                <option selected value="0">Select  Type</option>
                                                <option value="1">General</option>
                                                <option value="2">Category Related</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row services_row" id="services_row" style="display: none;padding-top: 2%">
                                    <div class="col-md-12">
                                        <div class="form-s2">
                                            <select class="form-control services-info" name="primary_service_id" id="primary_service_id" placeholder="select Main Category">
                                                <option selected value="0">Main Category *</option>
                                            
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row services_row" id="services_row" style="display: none;padding-top: 2%">
                                    <div class="col-md-12">
                                        <div class="form-s2">
                                            <select class="form-control" name="secondary_service_id" id="secondary_services" placeholder="select Sub Category">
                                                <option selected value="0">Sub Category</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row services_row" id="services_row" style="display: none;padding-top: 2%">
                                    <div class="col-md-12">
                                        <div class="form-s2">
                                            <select class="form-control" name="sub_secondary_service_id" id="sub_secondary_services" placeholder="select Grade">
                                                <option selected value="0">Sub Secondary Services</option>
                                            </select>
                                        </div> 
                                    </div>
                                </div> -->
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="floating-label" class="card p-20 top_border mb-3">
                                            <h2 class="_head03">FAQ <span>Details</span></h2>
                                            <div class="form-wrap p-0 PT-10">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Question *</label>
                                                            <input type="text" id="fq_question" name="faq_question" class="form-control faq-required"
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 pt-9">
                                                        <label class="font12 mb-5">Answer *</label>
                                                        <textarea name="faq_answer"></textarea>
                                                        {{-- <textarea class="textarea-st faq-required" id="faq_answer" name="faq_answer" rows="6"></textarea> --}}
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
        </div>
        <div class="_cl-bottom">
            <button type="submit" class="btn btn-primary mr-2 save-faq" id="save-faq">Save</button>
            <button id="pl-close" type="submit" class="btn btn-cancel mr-2 faq-cancel" id="faq-cancel">Cancel</button>
        </div>
    </div>
@endsection

    @section('content')
    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Enrollment <span>Mangement</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Enrollments </span></a></li>
                <li><span>Add</span></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <button type="button" class="btn add_button add_enrollment"><i class="fa fa-plus"></i> <span>Add
                    Enrollment</span></button>
                    <h2>Enrollment <span>List</span></h2>
                </div>
                <div style="min-height: 400px" class="loader">
                    <img src="{{asset('images/loader.gif')}}" width="30px" height="auto"
                        style="position: absolute; left: 50%; top: 45%;">
                </div>
                <div class="body enrollment_list">
                    
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- push('js')
<script src="mix('js/custom/faq.js'"></script>
endpush -->
