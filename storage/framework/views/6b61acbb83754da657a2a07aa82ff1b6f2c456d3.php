
<?php $__env->startSection('data-sidebar'); ?>
<style>
    .weekDays-selector input {
        display: none !important;
    }

    .weekDays-selector input[type=checkbox]+label {
        display: inline-block;
        border-radius: 0px;
        background: #f6f6f6;
        height: 30px;
        width: 50px;
        margin-right: 3px;
        line-height: 31px;
        text-align: center;
        cursor: pointer;
        font-size: 13px;
    }

    .weekDays-selector input[type=checkbox]:checked+label {
        background: #a2c95c;
        color: #ffffff;
    }
</style>
<div id="product-cl-sec" class="faqs-sidebar">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span>Session</span></div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter">
                    <form id="saveSessionForm">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="hidden_session_id">
                        <input type="hidden" name="hidden_session_day_id">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div id="floating-label" class="card p-20 top_border mb-3">
                                        <h2 class="_head03">Session <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect session-required courses" placeholder="select Course " name="course_id">
                                                            <option value="0" selected>Select Course ID *</option>
                                                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($course->id); ?>"><?php echo e($course->course_code); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect session-required" id="batches" placeholder="select Session " name="batch_id">
                                                            <option value="0" selected>Select Batch Code *</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10 ">Session Code *</label>
                                                        <input type="text" id="" class="form-control session-required" placeholder="" name="session_code">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Max Students *</label>
                                                        <input type="text" id="" class="form-control session-required" placeholder="" name="max_students">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect session-required" placeholder="select Instructor " name="primary_teacher_id">
                                                            <option value="0" selected>Select Primary Instructor *</option>
                                                            <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->first_name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect " placeholder="select Instructor " name="sub_teacher_id">
                                                            <option value="0" selected>Select Sub Instructor </option>
                                                            <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->first_name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect session-required" placeholder="select Instructor " name="primary_teacher_id">
                                                            <option value="0" selected>Select Batch Slot *</option>
                                                            <?php $__currentLoopData = $batch_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($slot->id); ?>"><?php echo e(date('g:i a',strtotime($slot->start_time))); ?> To <?php echo e(date('g:i a',strtotime($slot->end_time))); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                </div>
                                            <!-- <div class="row">
                                                <div class="col-md-6">
                                                    <label class="PT-10 font12 mb-5"> Start Time *</label>
                                                    <div class="form-group" style="height: auto">
                                                        <input type="time" id="" class="form-control session-required" placeholder="" name="start_time">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="PT-10 font12 mb-5">End Time *</label>
                                                    <div class="form-group" style="height: auto">
                                                        <input type="time" id="" class="form-control session-required" placeholder="" name="end_time">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <h2 class="_head03 mt-10">Select Days <span></span></h2>
                                            <div class="col-md-12 PT-10">
                                                <div class="row">
                                                <div class="weekDays-selector">
                                                    <input type="checkbox" id="all" class="weekday" name="all[]" value="0" />
                                                    <label for="all">All</label>
                                                    <input type="checkbox" id="weekday-mon" class="weekday" name="days[]" value="1"  />
                                                    <label for="weekday-mon">Mon</label>
                                                    <input type="checkbox" id="weekday-tue" class="weekday" name="days[]" value="2" />
                                                    <label for="weekday-tue">Tue</label>
                                                    <input type="checkbox" id="weekday-wed" class="weekday" name="days[]" value="3" />
                                                    <label for="weekday-wed">Wed</label>
                                                    <input type="checkbox" id="weekday-thu" class="weekday" name="days[]" value="4" />
                                                    <label for="weekday-thu">Thu</label>
                                                    <input type="checkbox" id="weekday-fri" class="weekday" name="days[]" value="5" />
                                                    <label for="weekday-fri">Fri</label>
                                                    <input type="checkbox" id="weekday-sat" class="weekday" name="days[]" value="6" />
                                                    <label for="weekday-sat">Sat</label>
                                                    <input type="checkbox" id="weekday-sun" class="weekday" name="days[]" value="7" />
                                                    <label for="weekday-sun">Sun</label>
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
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2 save-session" id="save-session">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2 faq-cancel" id="faq-cancel">Cancel</button>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Sessions <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Sessions </span></a></li>
            <li><span>Add</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <button type="button" class="btn add_button add_faqs"><i class="fa fa-plus"></i> <span>Add
                        Session</span></button>
                <h2>Sessions <span>List</span></h2>
            </div>
            <div style="min-height: 400px" class="loader">
                <img src="<?php echo e(asset('images/loader.gif')); ?>" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body session_list">

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<!-- push('js')
<script src="mix('js/custom/faq.js'"></script>
endpush -->
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lms\Sourcecode-Academia-BE\resources\views/course/session.blade.php ENDPATH**/ ?>