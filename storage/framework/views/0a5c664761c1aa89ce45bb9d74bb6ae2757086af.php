
    <?php $__env->startSection('content'); ?>
    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Campaigns <span>Management</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Campaigns </span></a></li>
                <li><span>Add</span></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <a href="/create-campaign" class="btn add_button add_faqs"><i class="fa fa-plus"></i> <span>Add
                    New</span></a>
                    <h2>Campaigns <span>List</span></h2>
                </div>
               
                <div style="min-height: 400px" class="loader">
                    <img src="<?php echo e(asset('images/loader.gif')); ?>" width="30px" height="auto"
                        style="position: absolute; left: 50%; top: 45%;">
                </div>
                <div class="body campaigns_list">
           
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<!-- push('js')
<script src="mix('js/custom/faq.js'"></script>
endpush -->

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lms\Sourcecode-Academia-BE\resources\views/campaigns/list.blade.php ENDPATH**/ ?>