


<?php $__env->startSection('content'); ?>

<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">User <span>Profile</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>User </span></a></li>
            <li><span>Profile</span></li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-lg-4 col-12 mb-30">
        <div class="card cp_user-l top_border">
            <div class="body">
                <div class="_cut-img mt-30"><img
                        src="<?php echo e(Auth::user()->picture ? URL::to(Auth::user()->picture) : '/images/avatar.svg'); ?>"
                        alt="" />
                    <div class="nam-title"><?php echo e((Auth::user()->name != null ? Auth::user()->name : "NA")); ?></div>
                </div>

                <div class="con_info lineHeight30">
                    <p><i class="fa fa-briefcase"></i><strong><?php echo e($designation->designation != null ?$designation->designation:'NA'); ?></strong></p>
                    <p><i
                            class="fa fa-phone-square"></i><strong><?php echo e((Auth::user()->phone != null ? Auth::user()->phone : "NA")); ?></strong>
                    </p>
                    <p><i
                            class="fa fa-envelope-square"></i><?php echo e((Auth::user()->email != null ? Auth::user()->email : "NA")); ?>

                    </p>
                    <p><i class="fa fa-globe"></i><?php echo e((Auth::user()->address != null ? Auth::user()->address : "NA")); ?>

                    </p>

                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-8 col-12 mb-30">
        <div class="row">

            <div class="body" style="width: 100%">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab1" data-toggle="tab" href="#tab01" role="tab"
                            aria-controls="tab01" aria-selected="true">Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab2" data-toggle="tab" href="#tab02" role="tab" aria-controls="tab02"
                            aria-selected="false">Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab3" data-toggle="tab" href="#tab03" role="tab" aria-controls="tab03"
                            aria-selected="false">Profile Picture</a>
                    </li>
                    
                </ul>
                <div class="tab-content tab-style" id="myTabContent">

                    <div class="tab-pane fade show active" id="tab01" role="tabpanel" aria-labelledby="tab1">

                        <div class="form-wrap p-0 _user-profile-info">
                            <div class="row">
                                <div class="col-md-6 p-col-L">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Full Name</label>
                                        <p><?php echo e((Auth::user()->name != null ? Auth::user()->name : "NA")); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6 p-col-R">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Phone No</label>
                                        <p><?php echo e((Auth::user()->phone != null ? Auth::user()->phone : "NA")); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 p-col-L">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Email ID</label>
                                        <p><?php echo e((Auth::user()->email != null ? Auth::user()->email : "NA")); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6 p-col-R">
                                    <div class="form-group">
                                        <label class="control-label mb-10">SIN No</label>
                                        <p><?php echo e((Auth::user()->sin != null ? Auth::user()->sin : "NA")); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 p-col-L">
                                    <div class="form-group">
                                        <label class="control-label mb-10">City</label>
                                        <p><?php echo e((Auth::user()->city != null ? Auth::user()->city : "NA")); ?></p>
                                    </div>
                                </div>

                                <div class="col-md-6 p-col-R">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Address</label>
                                        <p><?php echo e((Auth::user()->address != null ? Auth::user()->address : "NA")); ?>

                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 p-col-L">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Designation</label>
                                        <p><?php echo e($designation->designation != null?$designation->designation:'NA'); ?></p>
                                    </div>
                                </div>

                                <div class="col-md-6 p-col-R">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Reporting To</label>
                                        <p><?php echo e($reporting_to->name != null?$reporting_to->name:'NA'); ?></p>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>




                    <div class="tab-pane fade show" id="tab02" role="tabpanel" aria-labelledby="tab2">
                        <div class="form-wrap p-0">
                            <div class="row">

                                
                                

                                <form style="display: flex; width:100%" id="saveEditProfileForm">
                                  
                                    <?php echo csrf_field(); ?>
                                    <input type="text" hidden name="user_id" value="<?php echo e(Auth::user()->id); ?>" />
                                    <div class="" >
                                        <div class="col-md-12">

                                            <div id="floating-label" class="card p-20 mb-3">
                                                <h2 class="_head03">Change <span>Password</span></h2>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Current
                                                                Password*</label>
                                                            <input style="font-size: 13px" type="password"
                                                                name="current_password" id="current_password"
                                                                class="form-control" placeholder="" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">New
                                                                Password*</label>
                                                            <input style="font-size: 13px" type="password"
                                                                class="form-control" id="new_password" placeholder=""
                                                                value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 _ch-pass-p">
                                                        Minimum 6 Characters
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Confirm
                                                                Password*</label>
                                                            <input style="font-size: 13px" type="password"
                                                                class="form-control" name="confirm_password"
                                                                id="confirm_password" placeholder="" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 PT-10">
                                                        <button type="button" class="btn btn-primary mr-2 mb-10"
                                                            id="update_userpassword">Save Changes</button>
                                                        <button class="btn btn-cancel mr-2 mb-10" type="button"
                                                            data-toggle="collapse" data-target="#collapseExample"
                                                            aria-expanded="false"
                                                            aria-controls="collapseExample">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <div class="tab-pane fade show" id="tab03" role="tabpanel" aria-labelledby="tab3">
                        <div class="form-wrap p-0">
                            <div class="row">
                                <form style="display: flex; width:100%" id="saveEditProfilePictureForm">
                                     
                                    <?php echo csrf_field(); ?>
                                    <input type="text" hidden name="user_id" value="<?php echo e(Auth::user()->id); ?>" />
                                    <div>
                                        <div class="col-md-6">
                                            <div class="form-wrap up_h" style="width:100px;">
                                                <div class="upload-pic"></div>
                                                <input type="file" id="input-file-now" class="dropify profile-pic"
                                                    name="employeePicture"
                                                    data-default-file="<?php echo e(Auth::user()->picture ? URL::to(Auth::user()->picture) : ''); ?>" />
                                            </div>
                                            <button type="button" class="btn btn-primary"
                                                id="save_pic_user_profile">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>




                    <div class="tab-pane fade show" id="tab04" role="tabpanel" aria-labelledby="tab4">
                        <div class="form-wrap p-0">
                            <div class="row">
                                <?php echo csrf_field(); ?>
                                <table class="table table-bordered dt-responsive AssNotification" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>General Notification</th>
                                            <th>Email</th>
                                            <th>Web</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_notif" style="display:none;">
                                        <?php if(!empty($notifications_code)): ?>
                                        <?php $__currentLoopData = $notifications_code; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($notif->name); ?></td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" name="notification_permissions" value="email"
                                                        id="<?php echo e($notif->code); ?>" class="check_box <?php echo e($notif->code); ?>">
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" name="notification_permissions" value="web"
                                                        id="<?php echo e($notif->code); ?>" class="check_box <?php echo e($notif->code); ?>">
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-s2" style="display:none">
                                                <select class="form-control formselect" id="employee_id"
                                                    placeholder="Select Employee">
                                                    <option value="0" selected disabled>Select Employee</option>
                                                    <option value="<?php echo e(Auth::user()->id); ?>" selected>
                                                        <?php echo e(Auth::user()->name); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button"
                                                style="position:relative; margin: -20px -50px; top:50%; left:50%;"
                                                class="btn btn-primary sm-mt15" id="update_emp_pref">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lms\Sourcecode-Academia-BE\resources\views/includes/edit_profile.blade.php ENDPATH**/ ?>