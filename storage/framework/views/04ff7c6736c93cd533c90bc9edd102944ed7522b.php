

<?php $__env->startSection('content'); ?>
<style>

        .bootstrap-datetimepicker-widget a {
            color: #a1c95c;
        }
    </style>
<div id="blureEffct" class="container">
    <div class="row mt-2 mb-2">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Batch<span> Management</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="<?php echo e(route('batches')); ?>"><span>Batch</span></a></li>
                <li><span>New</span></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="body p-0">
                    <form id="saveBatchForm">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="hidden_batch_id" value="<?php echo e($batch->id); ?>" class="hidden_batch_id">
                        <div id="floating-label" class=" p-20  mb-3">
                            <div class="form-wrap p-0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="header pt-0">
                                            <h2>Batch <span>Definition</span></h2>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- <label class="PT-10 font12 mb-5">Courses *</label> -->
                                        <div class="form-s2 pt-19">
                                            <select id="course_list" class="form-control formselect batch-required " placeholder="select Course " name="course_id"  >
                                                <option value="0" selected>Select Course Code *</option>
                                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($course->id); ?>" <?php echo e($batch->course_id == $course->id ? 'selected' : ''); ?>><?php echo e($course->course_code); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10 ">Batch Code *</label>
                                            <input type="text" id="" class="form-control batch-required" placeholder="" name="batch_code" value="<?php echo e($batch->batch_code); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Batch Title *</label>
                                            <input type="text" id="" class="form-control batch-required" placeholder="" name="batch_title" value="<?php echo e($batch->batch_title); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Batch Price </batch-wise></label>
                                            <input type="text" id="" class="form-control batch_price only_numerics" placeholder="" name="batch_price" value="<?php echo e($batch->batch_price); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Batch Duration (In Months) </batch-wise></label>
                                            <input type="text" id="" class="form-control   only_numerics batch-required" placeholder="" name="batch_duration" value="<?php echo e($batch->batch_duration_in_months); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Batch Description *</label>
                                            <textarea id="" class="form-control " placeholder="" name="batch_description"> <?php echo e($batch->batch_description); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <h2 class="_head04 font18 PB-10">Batch <span>Enrollments</span> </h2>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="PT-10 font12 mb-5">Enrollment Start Date *</label>
                                        <div class="form-group" style="height: auto">
                                            <input type="text" id="datepicker3" class="form-control batch-required" placeholder="" name="enrollment_start_date" value="<?php echo e($batch->enr_start_date); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="PT-10 font12 mb-5">Enrollment End Date *</label>
                                        <div class="form-group" style="height: auto">
                                            <input type="text" id="datepicker4" class="form-control batch-required" placeholder="" name="enrollment_end_date" value="<?php echo e($batch->enr_end_date); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="PT-10 font12 mb-5">Batch Start Date *</label>
                                        <div class="form-group" style="height: auto">
                                            <input type="text" id="datepicker" class="form-control batch-required" placeholder="" name="batch_start_date" value="<?php echo e($batch->batch_start_date); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="PT-10 font12 mb-5">Batch End Date *</label>
                                        <div class="form-group" style="height: auto">
                                            <input type="text" id="datepicker2" class="form-control batch-required" placeholder="" name="batch_end_date" value="<?php echo e($batch->batch_end_date); ?>">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <h2 class="_head04 font18 PB-10">Other <span>Info</span> </h2>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Grace Period</label>
                                            <input type="text" id="" class="form-control only_numerics" placeholder="" name="grace_period" value="<?php echo e($batch->grace_period); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Early Bird Discount (in Percantage)</label>
                                            <input type="text" id="" class="form-control only_numerics" placeholder="" name="eb_discount" value="<?php echo e($batch->eb_discount); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Early Bird Max Days</label>
                                            <input type="text" id="" class="form-control only_numerics" placeholder="" name="eb_max_days" value="<?php echo e($batch->eb_max_days); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Session Duration (In Minutes) </batch-wise></label>
                                            <input type="text" id="sesssion_duration" class="form-control   only_numerics batch-required" placeholder="" name="session_duration" value="<?php echo e($batch->session_duration_in_minutes); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Total Sessions *</label>
                                            <input type="text" id="" class="form-control batch-required" placeholder="" name="total_sessions" value="<?php echo e($batch->total_sessions); ?>">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-12"><label class="PT-10 font12">Status</label></div>
                                            <div class="col-auto pr-0">
                                                <div class="custom-control custom-radio font14">
                                                    <input class="custom-control-input active" type="radio" name="batch_status" id="q-mc-01" value="1" <?php echo e($batch->status == 1 ?'checked="checked"' : ''); ?> >
                                                    <label class="custom-control-label" for="q-mc-01">Active</label>
                                                </div>
                                            </div>
                                            <div class="col pr-0">
                                                <div class="custom-control custom-radio font14">
                                                    <input class="custom-control-input inactive" type="radio" name="batch_status" id="q-tf-01" value="0" <?php echo e($batch->status == 0 ?'checked="checked"' : ''); ?>>
                                                    <label class="custom-control-label" for="q-tf-01">Inactive</label>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-12 PT-15">
                                        <h2 class="_head04 font18 PB-10">Batch <span>Slots</span>
                                        </h2>
                                        <div class="row add-property">

                                            <div class="col-md-6">
                                                <label class="font12 mb-5"> Start Time *</label>
                                                <div class="form-group" style="height: auto">
                                                <input type='text' id="start_time" class="form-control start_time datetimepicker3"  name="start_time" autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label class="font12 mb-5">End Time *</label>
                                                <div class="form-group" style="height: auto">
                                                <input type='text' id="end_time" class="form-control end_time datetimepicker3"  name="end_time" autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class="col-auto pl-0 PT-15"><button type="" class="btn btn-primary mt-10 add_slot">Add Slot</button></div>
                                            <div class="col-12 PT-20">

                                                <table width="100%" class="table nowrap table-type">
                                                    <tbody class="multiple_slots_tbl">
                                                        <?php $__currentLoopData = $batch_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr id="#new-row-">
                                                            <td style="width:100px"><?php echo e($key+1); ?></td>
                                                            <td style="width:250"><?php echo e(date('g:i A', strtotime($slot->start_time))); ?></td>
                                                            <td><?php echo e(date('g:i A', strtotime($slot->end_time))); ?></td>
                                                            <td><button class="btn btn-primary red-bg  remove" id="<?php echo e(date('g:i A',strtotime($slot->start_time))); ?>"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="col-12 PT-10 PB-20 text-right">
                    <button type="submit" class="btn btn-primary mr-2 save-batch" id="save-batch">Save</button>
                    <button id="pl-close" type="submit" class="btn btn-cancel mr-2 faq-cancel" id="faq-cancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lms\Sourcecode-Academia-BE\resources\views/course/edit-batch.blade.php ENDPATH**/ ?>