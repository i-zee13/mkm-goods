

<?php $__env->startSection('content'); ?>

        <div id="blureEffct" class="container">
            <div class="row mt-2 mb-2">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <h2 class="_head01">Course<span> Management</span></h2>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="#"><span>Course</span></a></li>
                        <li><span>New</span></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <div class="row m-0">
                                <div class="col pl-0">
                                    <h2 class="_head03 font18 border-0 pb-0">New <span>Course</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="body p-0">
                            <form id="course_form">
                                <?php echo csrf_field(); ?>
                                <div class="col-12 AddPro-Leftinfo AddPro-box">
                                    <div class="row addproTop">

                                        <div class="col-3">
                                            <label class="font12 mb-5">Main Category *</label>
                                            <div class="form-s2">
                                                <select class="form-control formselect main_category course-required" placeholder="select Main Category" style="width:100%!important" name="main_category_id" value="">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3 pl-0">
                                            <label class="font12 mb-5">Sub Category *</label>
                                            <div class="form-s2">
                                                <select class="form-control formselect sub_category course-required" placeholder="select Sub Category" style="width:100%!important" name="sub_category_id">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3 pl-0">
                                            <label class="font12 mb-5">Course Methodology *</label>
                                            <div class="form-s2">
                                                <select class="form-control formselect" placeholder="select Designation" style="width:100%!important" name="course_methodology">
                                                    <option value="0" selected>Select Course Methodology</option>
                                                    <option value="1"> Classroom</option>
                                                    <option value="2">Skill Development</option>
                                                    <option value="3">One on One Coaching Session</option>
                                                    <option value="4">Corporate Program</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3 pl-0">
                                            <label class="font12 mb-5">Course Type *</label>
                                            <div class="form-s2">
                                                <select class="form-control formselect" placeholder="select Designation" style="width:100%!important" name="course_type">
                                                    <option value="0" selected>Select Course Type</option>
                                                    <option value="1">Live sessions</option>
                                                    <option value="2">On Demand</option>
                                                    <option value="3">Webinar</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-9 AddPro-Leftinfo">
                                        <div class="row">
                                            <div class="col-12">
                                                <h2 class="_head03 font18 PB-5 mb-15">Course <span>Detail</span></h2>
                                            </div>
                                        </div>
                                        <div class="row Addpro-form">

                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 col-form-label">Course Code *</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control course-required" name="course_code">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 col-form-label">Course Level *</label>
                                                    <div class="col-sm-8">
                                                        <div class="form-s2">
                                                            <select class="form-control formselect course-required" placeholder="select Course Level" style="width:100%!important" name="course_level">
                                                                <option value="0" selected>Select Course Level</option>
                                                                <option value="1">Beginner</option>
                                                                <option value="2">Intermidate</option>
                                                                <option value="3">Advanced</option>
                                                                <option value="4">Expert</option>
                                                                <option value="5">NA</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-5 pr-0 col-form-label">Course Pricing Model *</label>
                                                    <div class="col-sm-7 pl-0">
                                                        <div class="row">
                                                            <div class="col-auto PT-8">
                                                                <div class="custom-control custom-radio font14">
                                                                    <input class="custom-control-input" type="radio" name="course_pricing_model" id="yes001" value="1">
                                                                    <label class="custom-control-label" for="yes001">Standard</label>
                                                                </div>
                                                            </div>
                                                            <div class="col pl-0 PT-8">
                                                                <div class="custom-control custom-radio font14">
                                                                    <input class="custom-control-input" type="radio" name="course_pricing_model" id="no001" value="2" checked>
                                                                    <label class="custom-control-label" for="no001" >Batch Wise</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 course_price" style="display:none">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 col-form-label">Course Price *</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="course_price">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-6"></div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">Course Title</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control course-required" name="course_title">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 pr-0 col-form-label">Course Subscription</label>
                                                    <div class="col-sm-8">
                                                        <div class="form-s2">
                                                            <select class="form-control formselect course-required" placeholder="select Course Subscription" style="width:100%!important" name="course_subscription_method">
                                                                <option selected>Select Course Subscription</option>
                                                                <option value="1">Monthly</option>
                                                                <option value="2">One time</option>
                                                                <option value="3">Quarterly</option>
                                                                <option value="4">Annual</option>
                                                                <option value="5">Free</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="col-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 col-form-label">Course Duration </label>
                                                    <div class="col-sm-8">
                                                        <div class="form-s2">
                                                            <select class="form-control formselect" placeholder="select Course Duration"
                                                                style="width:100%!important">
                                                                <option selected>Select Course Duration</option>
                                                                <option>2 week</option>
                                                                <option>4 week</option>
                                                                <option>8 week</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 col-form-label">Course Duration (in Months) *</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control course-required" name="course_duration">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="col-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-5 pr-0 col-form-label">Age Restrition</label>
                                                    <div class="col-sm-7 pl-0 font14">
                                                        <div class="row">
                                                            <div class="col-auto pl-0 PT-5">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" name="AgeRestrition" id="yes002" value="valuable">
                                                                    <label class="custom-control-label" for="yes002">Yes</label>
                                                                </div>
                                                            </div>
                                                            <div class="col pl-0 PT-5">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" name="AgeRestrition" id="no002" value="valuable">
                                                                    <label class="custom-control-label" for="no002">No</label>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->



                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-5 pr-0 col-form-label">Course Incubator *</label>
                                                    <div class="col-sm-7 pl-0 font14">
                                                        <div class="row">
                                                            <div class="col-auto  pl-0 PT-5">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" name="course_incubator" id="yes005" value="1" checked>
                                                                    <label class="custom-control-label" for="yes005">Yes</label>
                                                                </div>
                                                            </div>
                                                            <div class="col pl-0 PT-5">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" name="course_incubator" id="no005" value="2">
                                                                    <label class="custom-control-label" for="no005">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">Short
                                                        Description *</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="proTextarea course-required" name="short_description"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2 col-form-label">Long Description *
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <textarea class="proTextarea  course-required" name="long_description"></textarea>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12 Weightage-sec">

                                                <div class="row m-0">
                                                    <div class="col-6 h-border pl-0">
                                                        <h2 class="_head04 font18 border-0 PB-5">Course <span>Graduation Criteria</span></h2>
                                                    </div>
                                                    <div class="col-6 h-border pr-0">
                                                        <div class="switch-div">
                                                            <span class="btn_text">Show</span>
                                                            <label class="switch">
                                                                <input type="checkbox" class="show_btn" name="gradutation_switch_btn" value="0">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>




                                                <div class="show_gradution_block" style="display:none">
                                                    <div class="row">
                                                        <div class="col-4 PT-7">

                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <label class="font12 mb-5">Minimum Score</label>
                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <label class="font12 mb-5">Weightage</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4 PT-7">
                                                            <strong>Quiz</strong>
                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <input type="text" class="form-control" name="minimum_quiz_score">
                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <input type="text" class="form-control only_numerics" name="quiz_weightage">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4 PT-7">
                                                            <strong>Attendence</strong>
                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <input type="text" class="form-control" name="minimum_attendnace">
                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <input type="text" class="form-control only_numerics" name="attendance_weightage">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 PT-7">
                                                            <strong>Assignment</strong>
                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <input type="text" class="form-control" name="minimum_assignment_score">
                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <input type="text" class="form-control only_numerics" name="assignment_weightage">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 PT-7">
                                                            <strong>Participation</strong>
                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <input type="text" class="form-control" name="minimum_participation_score">
                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <input type="text" class="form-control only_numerics" name="participation_weightage">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row">
                                                    <div class="col-4 PT-7">
                                                        <strong>Text info here</strong>
                                                    </div>
                                                    <div class="col-3 pl-0">
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="col-3 pl-0">
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div> -->


                                                    <div class="row total-Weightage">
                                                        <div class="col-4">

                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <input type="text" class="form-control" placeholder="Total Weightage" readonly>
                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <input type="text" name="total_weightage" class="form-control total_weightage" placeholder="0%" data-value="" readonly>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="row font14">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label for="" class="col-form-label pr-0">
                                                                 
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-2 pl-0">
                                                        <strong></strong>
                                                    </div>
                                                    <div class="col-2 pl-0">
                                                        <strong></strong>
                                                    </div>
                                                </div>  -->
                                                </div>
                                            </div>



                                            <div class="col-12 PT-15">
                                                <h2 class="_head04 font18 PB-10">Course <span>Attributes</span>
                                                </h2>
                                                <div class="row add-property">

                                                    <div class="col-6">
                                                        <label class="font12 mb-5">Attribute</label>
                                                        <div class="form-s2">
                                                            <!-- <select class="form-control formselect attribute" placeholder="select Designation" style="width:100%!important" name="attribute_id"> -->
                                                                <select id="MCategory" class="demo-default attribute" data-placeholder="Attribute">


                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col pl-0">
                                                        <label class="mb-5"><strong>Value</strong></label>
                                                        <div class="form-s2">
                                                            <!-- <select class="form-control formselect attribute_value" placeholder="select Designation" style="width:100%!important" name="attribute_value_id"> -->
                                                                <select id="SCategory" class="demo-default attribute_value" data-placeholder="Value">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto pl-0 PT-15"><button type="" class="btn btn-primary mt-10 add_attribute">Add Attribute</button></div>
                                                    <div class="col-12 PT-20">

                                                        <table width="100%" class="table nowrap table-type">
                                                            <tbody class="multiple_attribute_tbl">



                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12 PT-15">
                                                <h2 class="_head04 font18 PB-10">Course <span>Search Tags</span></h2>

                                                <div class="add-property">
                                                    <div class="row m-0">
                                                        <div class="col pr-0">
                                                            <input type="" class="form-control tag_input" placeholder="" name="tag">
                                                        </div>
                                                        <div class="col-auto pl-0"><button type="" class="btn btn-primary add_tag">Add Tag</button></div>
                                                    </div>

                                                    <div class="row m-0">
                                                        <div class="col-12 multiple_tags_tbl">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                        <div class="col-12 PT-15">
                                            <h2 class="_head04 font18 PB-10 mb-15">SEO <span>Information</span></h2>
                                            <div class="row Addpro-form">
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3 col-form-label">Page Meta
                                                            Title</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="page_meta">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3 col-form-label">Meta
                                                            Description</label>
                                                        <div class="col-sm-9">
                                                            <textarea class="proTextarea"  name="meta_description"> </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3 col-form-label">Meta Keywords
                                                            (Separate by commas)</label>
                                                        <div class="col-sm-9">
                                                            <textarea class="proTextarea" name="meta_keywords"> </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3 pr-0 col-form-label">Meta
                                                            Property URL</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="meta_property_url">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3 pr-0 col-form-label">Meta
                                                            Property Type</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="meta_property_type">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3 col-form-label">Meta Property
                                                            Title</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="meta_property_title">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3 col-form-label">Meta Property
                                                            Description</label>
                                                        <div class="col-sm-9">
                                                            <textarea class="proTextarea" name="meta_property_description"> </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3 col-form-label">Meta Property
                                                            Image</label>
                                                        <div class="col-sm-9">

                                                            <div class="form-wrap p-0">
                                                                <div class="upload-pic"></div>
                                                                <input type="file" id="input-file-now" class="dropify"  name="meta_property_image" accept="image/*" data-allowed-file-extensions="jpg png jpeg JPEG"/>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3 col-form-label">Footer
                                                            Content</label>
                                                        <div class="col-sm-9">
                                                            <textarea class="proTextarea" name="footer_content"> </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                            <div class="col-12 PT-10 PB-20 text-right">
                                                <button type="button" class="btn btn-primary btn_save_course">Save</button>
                                                <button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">Cancel</button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="Product-imgUpload">
                                            <h4>Course Images</h4>
                                            <div class="col-md-12 PT-5 PB-15">
                                                <div class="form-wrap p-0">
                                                    <label class="font12 mb-5">Add Thumbnail (650 x 400) *</label>
                                                    <div class="upload-pic"></div>
                                                    <input type="file" id="input-file-now" class="dropify course-required" name="course_thumbnail" 
                                                    data-min-width="649" data-max-width="651" data-min-height="399" data-max-height="401" accept="image/*" data-allowed-file-extensions="jpg png jpeg JPEG"/>
                                                </div>
                                            </div>
                                            <h4>Add Cover Images</h4>
                                            <div class="col-md-12 PT-5">
                                                <div class="form-wrap p-0">
                                                    <label class="font12 mb-5"> Desktop (1920 x 640) *</label>
                                                    <div class="upload-pic"></div>
                                                    <input type="file" id="input-file-now" class="dropify course-required" name="course_desktop_cover_image" 
                                                     data-min-width="1919" data-max-width="1921" data-min-height="639" data-max-height="641" accept="image/*" data-allowed-file-extensions="jpg png jpeg JPEG"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12 PT-5">
                                                <div class="form-wrap p-0">
                                                    <label class="font12 mb-5">Tablet (1024 x 519) *</label>
                                                    <div class="upload-pic"></div>
                                                    <input type="file" id="input-file-now" class="dropify course-required" name="course_tablet_cover_image" 
                                                    data-min-width="1023" data-max-width="1025" data-min-height="518" data-max-height="520" accept="image/*" data-allowed-file-extensions="jpg png jpeg JPEG"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12 PT-5">
                                                <div class="form-wrap p-0">
                                                    <label class="font12 mb-5">Mobile (480 x 791) *</label>
                                                    <div class="upload-pic"></div>
                                                    <input type="file" id="input-file-now" class="dropify course-required" name="course_mobile_cover_image" 
                                                    data-min-width="479" data-max-width="481" data-min-height="790" data-max-height="792" accept="image/*" data-allowed-file-extensions="jpg png jpeg JPEG"/>
                                                </div>
                                            </div>

                                            <div class="col-12 Addpro-form PT-10">
                                                <label class="font12 mb-5">Youtube Video Link</label>

                                                <div class="control-group">
                                                    <input type="text" class="form-control" name="youtube_link">

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
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lms\Sourcecode-Academia-BE\resources\views/course/add-course.blade.php ENDPATH**/ ?>