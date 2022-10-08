
<?php $__env->startSection('data-sidebar'); ?>
<style>
    #product-cl-sec,
    #product-add {
        width: 600px
    }

    .holder>li {
        padding: 5px;
        margin: 2px;
        display: inline-block;
    }

    .holder>li[data-page] {
        border: solid #dee2e6 1px;
        border-radius: 5px;
        border-radius: 0px;
        font-size: 13px;
        padding: 8px 10px;
        line-height: 1;

    }

    .holder>li[data-page-poc] {
        border: solid #dee2e6 1px;
        border-radius: 5px;
        border-radius: 0px;
        font-size: 13px;
        padding: 8px 10px;
        line-height: 1;

    }

    .holder>li.separator:before {
        content: '...';
    }

    .holder>li.active {
        background: linear-gradient(90deg, #0a0e36 0%, #040725 100%);
        ;
        border-color: #040725;
        color: #fff;
    }

    .holder>li[data-page]:hover {
        cursor: pointer;
    }

    @media (max-width:800px) {

        #product-cl-sec,
        #product-add {
            width: 100%
        }
    }

    .cusDetail-th,
    .cusDetail-th:HOVER {
        padding-left: 6px;
        padding-right: 6px;
    }

    ._product-card h2 {
        margin-bottom: 10px;
        text-align: center;
        margin-top: 10px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Intake Form <span>Types</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Intake Form</span> Types</a></li>
                <li><span>List</span></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Intake Form <span> Types</span></h2>
                    <a href="<?php echo e(route('create-intake-form-type')); ?>" class="btn add_button"><i class="fa fa-plus"></i> New Intake Form Type</a>
                </div>
                <div class="body">
                    <table class="table table-hover nowrap" id="example" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $formtypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->id); ?></td>
                                <td><?php echo e($item->name); ?></td>
                                <td>
                                    <a href="<?php echo e(route('edit-intake-form-type',['id'=>$item->id])); ?>" class="btn btn-default" >Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Sourcecode-Academia-BE\resources\views/intake-form-types/index.blade.php ENDPATH**/ ?>