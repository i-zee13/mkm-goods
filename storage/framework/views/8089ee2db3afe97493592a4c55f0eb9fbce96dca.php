
 
<?php if(is_array($my_designation_rights['designation_rights'] || Auth::user()->super)): ?>
<?php if(in_array("emp_activity", json_decode($my_designation_rights['designation_rights'], true)) || Auth::user()->super): ?>
<?php $__env->startSection('data-sidebar'); ?>
<style>
    .close-btn-pl {
        top: 0px;
        right: 0px;
        background-color: #101010
    }

    .close-btn-pl:after,
    .close-btn-pl:before {
        background-color: #fff;
        height: 20px;
        top: 5px
    }

    #product-cl-sec {
        right: -700px;
        opacity: 1;
        box-shadow: 0 1px 5px 0 rgba(45, 62, 80, .12);
        width: 735px
    }

    #product-cl-sec.active {
        right: 0px;
        opacity: 1;
        box-shadow: 0px 0px 100px 0px rgba(0, 0, 0, 0.5)
    }

    .R-Heading {
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        font-size: 22px;
        letter-spacing: 5px;
        padding-left: 10px;
        line-height: 1;
        width: 347px;
        position: absolute;
        left: -155px;
        top: 200px
    }

    .open-Report,
    .open-ReportHOVER {
        font-size: 18px;
        text-align: center;
        color: #fff !important;
        padding: 10px 8px 18px 8px;
        display: block
    }

    .RB_bar {
        color: #fff;
        height: 100vh;
        width: 40px;
        background:linear-gradient(90deg, #161616 0%, #101010 100%);
        position: absolute
    }

    ._left-filter {
        padding-top: 0
    }

    .FU-history {
        margin-top: 0
    }

</style>
<div id="product-cl-sec">
    <div class="RB_bar"> <a id="productlist01" class="open-Report"><i style="cursor: pointer"
                class="fa fa-arrow-left"></i></a>
        <h1 class="R-Heading">Employee Activity</h1>
    </div>
    <a id="pl-close" style="cursor: pointer" class="close-btn-pl"></a>
    <div class="pc-cartlist pb-0">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter activityTime">
                    <div class="container">
                        <div class="FU-history">

                            <div class="col-12">
                                <h1 class="ACT-head">Today Activity</h1>
                            </div>

                            <?php if(sizeof($activities['orders']) == 0 && sizeof($activities['items']) == 0 &&
                            sizeof($activities['products']) == 0 && sizeof($activities['customers']) == 0 &&
                            sizeof($activities['pocs']) == 0 && sizeof($activities['suppliers']) == 0 &&
                            sizeof($activities['forwarders']) == 0 && sizeof($activities['shippers']) == 0 &&
                            sizeof($activities['employees']) == 0 && sizeof($activities['payments']) == 0): ?>
                            <div class="NoAct"><img src="/images/noavtivity-icon.svg" alt="" />You don't have any
                                activity yet<br>
                                <a href="/view_all_activities" class="btn btn-primary mt-15 font13">View Previous
                                    Activity</a>
                            </div>
                            <?php else: ?>
                            <ul class="Act-timeline">
                                <?php $__currentLoopData = $activities['orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orders): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($orders->created_at == date('Y-m-d') && $orders->created_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($orders->created_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($orders->created_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Sales Order</h5>
                                            <p><?php echo e($orders->created_by); ?> has created a New Sales Order for
                                                <?php echo e($orders->customer_name); ?> Worth <?php echo e($orders->currency); ?>

                                                <?php echo e($orders->total_amount); ?> Order # <a
                                                    href="/OrderManagement"><?php echo e($orders->id); ?></a></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($orders->updated_at == date('Y-m-d') && $orders->updated_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($orders->updated_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($orders->updated_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Sales Order Update</h5>
                                            <p><?php echo e($orders->updated_by); ?> has updated Sales Order # <a
                                                    href="/OrderManagement"><?php echo e($orders->id); ?></a> for
                                                <?php echo e($orders->customer_name); ?> worth <?php echo e($orders->currency); ?>

                                                <?php echo e($orders->total_amount); ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($orders->completed_at == date('Y-m-d') && $orders->completed_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($orders->completed_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($orders->completed_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Sales Order Complete</h5>
                                            <p><?php echo e($orders->completed_by); ?> has completed the Sales Order # <a
                                                    href="/OrderManagement"><?php echo e($orders->id); ?></a> for
                                                <?php echo e($orders->customer_name); ?> worth <?php echo e($orders->currency); ?>

                                                <?php echo e($orders->total_amount); ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($orders->processed_at == date('Y-m-d') && $orders->processed_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($orders->processed_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($orders->processed_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Sales Order Dispatch</h5>
                                            <p><?php echo e($orders->processed_by); ?> has created a full dispatch for Sales Order #
                                                <a href="/OrderManagement"><?php echo e($orders->id); ?></a> for
                                                <?php echo e($orders->customer_name); ?> worth <?php echo e($orders->currency); ?>

                                                <?php echo e($orders->total_amount); ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $activities['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($items->created_at == date('Y-m-d') && $items->created_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($items->created_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($items->created_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Variant</h5>
                                            <p><?php echo e($items->created_by); ?> has created a new Item <a
                                                    href="/ProductItems/<?php echo e($items->product_sku); ?>"><?php echo e($items->name); ?></a>
                                                for <?php echo e($items->product_name); ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($items->updated_at == date('Y-m-d') && $items->updated_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($items->updated_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($items->updated_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Update Variant</h5>
                                            <p><?php echo e($items->updated_by); ?> has updated Item <a
                                                    href="/ProductItems/<?php echo e($items->product_sku); ?>"><?php echo e($items->name); ?></a>
                                                for <?php echo e($items->product_name); ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $activities['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($products->created_at == date('Y-m-d') && $products->created_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($products->created_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($products->created_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Product</h5>
                                            <p><?php echo e($products->created_at); ?> has created a new Product<a
                                                    href="/BrandProducts/<?php echo e($products->brand_id); ?>"><?php echo e($products->name); ?></a>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($products->updated_at == date('Y-m-d') && $products->updated_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($products->updated_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($products->updated_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Product Update</h5>
                                            <p><?php echo e($products->updated_by); ?> has Updated Product <a
                                                    href="/BrandProducts/<?php echo e($products->brand_id); ?>"><?php echo e($products->name); ?></a>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $activities['customers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($customers->created_at == date('Y-m-d') && $customers->created_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($customers->created_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($customers->created_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Customer</h5>
                                            <p><?php echo e($customers->created_by); ?> has created a new customer <a
                                                    href="/Correspondence/create/<?php echo e($customers->id); ?>"><?php echo e($customers->company_name); ?></a>
                                                from <?php echo e($customers->country); ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($customers->updated_at == date('Y-m-d') && $customers->updated_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($customers->updated_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($customers->updated_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Customer Update</h5>
                                            <p><?php echo e($customers->updated_by); ?> has updated customer details <a
                                                    href="/Correspondence/create/<?php echo e($customers->id); ?>"><?php echo e($customers->company_name); ?></a>
                                                from <?php echo e($customers->country); ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $activities['pocs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pocs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($pocs->created_at == date('Y-m-d') && $pocs->created_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($pocs->created_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($pocs->created_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New POC</h5>
                                            <p><?php echo e($pocs->created_by); ?> has added a new POC <?php echo e($pocs->first_name); ?> for <a
                                                    href="/Correspondence/create/<?php echo e($pocs->customer_id); ?>"><?php echo e($pocs->customer_name); ?></a>
                                                from <?php echo e($pocs->cust_country); ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($pocs->updated_at == date('Y-m-d') && $pocs->updated_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($pocs->updated_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($pocs->updated_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Update POC</h5>
                                            <p><?php echo e($pocs->updated_by); ?> has updated POC details of <?php echo e($pocs->first_name); ?>

                                                for <a
                                                    href="/Correspondence/create/<?php echo e($pocs->customer_id); ?>"><?php echo e($pocs->customer_name); ?></a>
                                                from <?php echo e($pocs->cust_country); ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                <?php $__currentLoopData = $activities['suppliers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($sup->created_at == date('Y-m-d') && $sup->created_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($sup->created_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($sup->created_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Supplier</h5>
                                            <p><?php echo e($sup->created_by); ?> has created a new supplier <a
                                                    href="/Suppliers"><?php echo e($sup->company_name); ?></a></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($sup->updated_at == date('Y-m-d') && $sup->updated_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($sup->updated_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($sup->updated_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Update Supplier</h5>
                                            <p><?php echo e($sup->updated_by); ?> has updated supplier details <a
                                                    href="/Suppliers"><?php echo e($sup->company_name); ?></a></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $activities['forwarders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forwarders): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($forwarders->created_at == date('Y-m-d') && $forwarders->created_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($forwarders->created_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($forwarders->created_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Forwarder</h5>
                                            <p><?php echo e($forwarders->created_by); ?> has created a new Forwarding Company <a
                                                    href="/forwarder"><?php echo e($forwarders->company_name); ?></a></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($forwarders->updated_at == date('Y-m-d') && $forwarders->updated_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($forwarders->updated_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($forwarders->updated_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Update Forwarder</h5>
                                            <p><?php echo e($forwarders->updated_by); ?> has updated Forwarding <a
                                                    href="/forwarder"><?php echo e($forwarders->company_name); ?></a></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $activities['shippers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shippers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($shippers->created_at == date('Y-m-d') && $shippers->created_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($shippers->created_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($shippers->created_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Shipping Company</h5>
                                            <p><?php echo e($shippers->created_by); ?> has created a new Shipping Company <a
                                                    href="/Shipping"><?php echo e($shippers->company_name); ?></a></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($shippers->updated_at == date('Y-m-d') && $shippers->updated_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($shippers->updated_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($shippers->updated_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Update Shipping Company</h5>
                                            <p><?php echo e($shippers->updated_by); ?> has updated Shipping Company <a
                                                    href="/Shipping"><?php echo e($shippers->company_name); ?></a></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $activities['employees']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($emp->created_at == date('Y-m-d') && $emp->created_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($emp->created_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($emp->created_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Employee</h5>
                                            <p><?php echo e($emp->created_by); ?> has added a new Employee <a
                                                    href="/register"><?php echo e($emp->name); ?></a></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($emp->updated_at == date('Y-m-d') && $emp->updated_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($emp->updated_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($emp->updated_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Update Employee</h5>
                                            <p><?php echo e($emp->updated_by); ?> has updated employee <a
                                                    href="/register"><?php echo e($emp->name); ?></a></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $activities['payments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($payments->created_at == date('Y-m-d') && $payments->created_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($payments->created_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($payments->created_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Payment Created</h5>
                                            <p>New Payment Created</p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($payments->updated_at == date('Y-m-d') && $payments->updated_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($payments->updated_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($payments->updated_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Payment Updated</h5>
                                            <p>Existing Payment Updated</p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $activities['tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($task->created_at == date('Y-m-d') && $task->created_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($task->created_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($task->created_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Task Created</h5>
                                            <p>New Task Created</p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($task->updated_at == date('Y-m-d') && $task->updated_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($task->updated_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($task->updated_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Task Updated</h5>
                                            <p>Existing Task Updated</p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if($task->completed_at == date('Y-m-d') && $task->completed_by): ?>
                                <li>
                                    <div class="dateFollowUP"><?php echo e($task->completed_at); ?></div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4><?php echo e($task->completed_by); ?></h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Task Completed</h5>
                                            <p>Task Completed</p>
                                        </div>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <a href="/view_all_activities" class="btn-primary view-all-EA">View All
                                    Activities</a>
                                </li>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php endif; ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
<style>
    @media (max-width: 1280px) {
        #content-wrapper {
            padding-right: 25px !important;
        }
    }

</style>
<div class="row _user-TS">
    <div class="col-md-5 _dashTOP">
        
        <img class="_user_Pimage" src="<?php echo e(Auth::user()->picture ? str_replace('./', '/', Auth::user()->picture) : '/images/avatar.svg'); ?>" alt="" />
        <h2 class="_head01"><?php echo e(Auth::user()->name); ?></h2>
        <p>Here’s what’s happening in your company today.</p>
    </div>
    <div class="col-md-7 _user-CS">
        <ul>
            <li><span><img src="images/task-icon-b.svg" alt=""></span>
                <div></div>Task
            </li>
            <li><span><img src="images/note-icon-b.svg" alt=""></span>
                <div></div>Note
            </li>
            <li><span><img src="images/call-icon-b.svg" alt=""></span>
                <div></div>Call
            </li>
            <li><span><img src="images/email-icon-b.svg" alt=""></span>
                <div></div>Email
            </li>
            <li><span><img src="images/meeting-icon-b.svg" alt=""></span>
                <div></div>Meeting
            </li>
        </ul>
    </div>
</div>
<div class="row">






































































































































</div>



























































<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Sourcecode-Academia-BE\resources\views/home.blade.php ENDPATH**/ ?>