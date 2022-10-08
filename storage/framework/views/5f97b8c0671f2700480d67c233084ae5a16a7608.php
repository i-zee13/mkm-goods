
<?php $__env->startSection('data-sidebar'); ?>
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span>Service</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter ">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <form style="display: flex;" id="saveSubCatForm">
                                    <?php echo csrf_field(); ?>
                                    <input type="text" id="operation" hidden>
                                    <input type="text" id="sub_cat_id" hidden>
                                    <div id="floating-label" class="card p-20 top_border mb-3" style="width: 100%">
                                        <h2 class="_head03">Service <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12 PB-10 ">
                                                <label class="font12 mb-0">Primary Service*</label>   

                                                        <div class="form-s2 ">
                                                            <select class="form-control formselect client_required" name="primary_service_id">
                                                                <option value="-1" selected disabled> Select Primary Service
                                                                </option>
                                                                <?php $__currentLoopData = $main; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->service_name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 PB-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Service Name*</label>
                                                        <input type="text" name="service_name" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="_head03 mt-10">Publish <span></span></h2>
                                            <div class="col-md-12 PT-10">
                                                <div class="row">

                                                    <div class="col-auto pl-0">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input yes" type="radio" name="publish_service" id="yes" value="1">
                                                            <label class="custom-control-label font13" for="yes">Yes</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input no" type="radio" name="publish_service" id="no" value="0">
                                                            <label class="custom-control-label font13" for="no">No</label>
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
            </div>
        </div>
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2" id="saveSubCat">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelSubCat">Cancel</button>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Service <span>Area</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Secondary Service</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a class="btn add_button openDataSidebarForAddingSubCat"><i class="fa fa-plus"></i> New Secondary Service</a>
                <h2>Secondary Service Areas</h2>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lms\Sourcecode-Academia-BE\resources\views/services/sub.blade.php ENDPATH**/ ?>