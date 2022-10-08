
<?php $__env->startSection('data-sidebar'); ?>
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text"><span>Employee</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <form style="display: flex; width: 100%" id="saveEmployeeForm" enctype="multipart/form-data">
            
            <?php echo csrf_field(); ?>
            <input type="text" id="operation" class="operation" hidden>
            <input type="hidden" id="employee_updating_id" name="employee_updating_id">

            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter pt-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div id="floating-label" class="card p-20 top_border mt-3 mb-3">
                                        <h2 class="_head03">Profile <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Full Name*</label>
                                                        <input type="text" name="name" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Phone No</label>
                                                        <input type="text" name="phone" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Email ID</label>
                                                        <input type="text" name="email" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">SIN No</label>
                                                        <input type="text" name="sin" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-s2">
                                                        <label class="font11 mb-0">Country*</label>
                                                        <select class="form-control formselect emp_countries" placeholder="select Country*" name="country">
                                                            <option selected value="0">Select Country</option>
                                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2">
                                                        <label class="font11 mb-0">State*</label>
                                                        <select class="form-control formselect emp_states" placeholder="Select State*" name="state">
                                                            <option selected value="0">Select State</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-s2">
                                                        <label class="font11 mb-0">City*</label>
                                                        <select class="form-control formselect emp_cities" placeholder="Select City*" name="city">
                                                            <option selected value="0">Select City</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pt-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Address</label>
                                                        <input type="text" name="address" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h2 class="_head03 PT-10">Create <span> User</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Username*</label>
                                                        <input type="text" name="username" class="form-control" placeholder="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Password*</label>
                                                        <input type="password" name="password" class="form-control" placeholder="">
                                                    </div>
                                                  
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-wrap pt-19 PB-10" id="dropifyImgDiv">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h2 class="_head03 PT-10">Additional <span> Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">

                                                <div class="col-md-12 pt-5">
                                                    <label class="font12 mb-0">Hiring Date</label>
                                                    <div class="form-group h-auto">
                                                        <input type="text" name="hiring" id="datepicker" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pt-5">
                                                    <div class="form-group mb-0">
                                                        <label class="control-label mb-10">Salary</label>
                                                        <input type="text" name="salary" class="form-control" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-md-12 pt-5">

                                                    <div class="form-s2 pt-5">
                                                        <label class="font11 mb-0">Designation</label>
                                                        <select name="designation" class="form-control formselect" placeholder="select Designation">
                                                            <option value="0" selected>Select Designation*</option>
                                                            <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $des): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($des->id); ?>"><?php echo e($des->designation); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 pt-5">

                                                    <div class="form-s2 pt-5">
                                                        <label class="font11 mb-0">Reporting To</label>
                                                        <select name="reporting" class="form-control formselect" placeholder="Reporting To">
                                                            <option value="0" selected>Reporting To</option>
                                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($data->id); ?>"><?php echo e($data->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 pt-5">

                                                    <div class="form-s2 pt-5">
                                                        <label class="font11 mb-0">Department</label>
                                                        <select name="department" class="form-control formselect" placeholder="Select Department">
                                                            <option value="0" selected>Select Department*</option>
                                                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($department->id); ?>">
                                                                <?php echo e($department->department); ?>

                                                            </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            
                                                        </select>
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
        </form>
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2" id="saveEmployee">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelEmployee">Cancel</button>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Employee <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Employee</span></a></li>
            <li><span>List</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a id="productlist01" href="#" class="btn add_button openDataSidebarForAddingEmployee"><i class="fa fa-plus"></i> <span> New Employee</span></a>
                <h2>Employee <span> List</span></h2>
            </div>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body" style="display: none">
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
    var states = [];
    var cities = [];
    $.get("/get-states-cities", function(response) {
        states = response.states;
        cities = response.cities;
    });
    $(document).on('change', '.emp_countries', function() {
        $('.emp_states').html(`<option selected value="0">Select State</option>`);
        $('.emp_cities').html(`<option selected value="0">Select City</option>`);
        var country_id = $(this).val();
        if (country_id > 0) {
            var country_states = states.filter(x => x.country_id == country_id);
            if (country_states) {
                country_states.forEach(element => {
                    $('.emp_states').append(`<option  value="${element['id']}">${element['name']}</option>`);
                });
            }
        }
        $('.emp_states').select2();
    });
    $(document).on('change', '.emp_states', function() {
        $('.emp_cities').html(`<option selected value="0">Select City</option>`);
        var state_id = $(this).val();
        if (state_id > 0) {
            var state_cities = cities.filter(x => x.state_id && x.state_id == state_id);
            if (state_cities) {
                state_cities.forEach(element => {
                    $('.emp_cities').append(`<option  value="${element['id']}">${element['name']}</option>`);
                });
            }
        }
        $('.emp_cities').select2();
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lms\Sourcecode-Academia-BE\resources\views/auth/register.blade.php ENDPATH**/ ?>