
<?php $__env->startSection('content'); ?>
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Site <span>Settings</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Route List</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a class="btn add_button addNewParentMod" style="margin-right: 200px"><i class="fa fa-plus"></i> Add
                    New</a>
                <a class="btn add_button saveParentPriorityList"><i class="fa fa-plus"></i> Save Parent
                    Priority List</a>
                <h2>Routes List</h2>
            </div>
            <div class="body">
                <ul class="sortable" class="list-group subMenu" style="display: block">
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li
                        style="height: 300px; overflow: auto; margin-bottom: 20px; width: 30%; display: inline-block; margin-left: 10px; float: left; padding-bottom: 10px">
                        <span
                            style="cursor: pointer; background: #fafafa; padding: 0px; margin: 0px; height: 50px; text-align: center; line-height: 50px; border: 1px solid #1d53d2; text-transform: uppercase; font-weight: bold; display: block;"
                            class="parentMod" value="<?php echo e($item['parent_module']); ?>"><?php echo e($item['parent_module']); ?></span>
                        <input type="text" module-name="<?php echo e($item['parent_module']); ?>" value=<?php echo e($item['parent_module']); ?>

                            class="form-control parentModEditor" style="display: none">
                        <div class="form-group p-b-10 p-t-10">
                            <ul class="sortable" class="list-group subMenu">
                                <?php $__currentLoopData = $item['sub_mods']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li parent-module-name="<?php echo e($item['parent_module']); ?>" item-id=<?php echo e($sub['id']); ?>

                                    class="list-group-item subModItems editSubNavItem">
                                    <label style="font-size: 12pt" for="dbV1"
                                        class="lab-medium"><?php echo e($sub['sub_module'] ? $sub['sub_module'] : $sub['made_up_name']); ?></label>
                                    <span class="deleteSubNavItem"
                                        style="float: right; color: red; width: 50px;text-align: right;"
                                        item-id="<?php echo e($sub['id']); ?>"><i class="fa fa-trash"></i></span>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <li class="addNewSubMob"
                                    style="text-align: center; background: #1d53d2; color: white; font-weight: bold;padding:11px"
                                    class="list-group-item">
                                    <label parent-module="<?php echo e($item['parent_module']); ?>"
                                        style=" cursor: pointer; font-size: 12pt; font-weight: bold; float: left"
                                        for="dbV1" class="lab-medium deleteParentMod">DELETE</label>
                                    <label style="font-size: 10pt; width: 150px" for="dbV1" class="lab-medium">ADD
                                        NEW</label>
                                    <label style="cursor: pointer; font-size: 12pt; font-weight: bold; float: right"
                                        for="dbV1" class="lab-medium savePriorityList">SAVE</label>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        $(".sortable").sortable();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Sourcecode-Academia-BE\resources\views/admin/settings.blade.php ENDPATH**/ ?>