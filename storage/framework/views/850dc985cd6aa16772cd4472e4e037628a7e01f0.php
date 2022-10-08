
<?php $__env->startSection('content'); ?>
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

    .dropdown {
        float: right;
        margin-right: 20px
    }

    .dropdown .btn {
        padding: 4px 4px;
        font-size: 12px;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
        -khtml-border-radius: 0;
        text-transform: capitalize;
        background: linear-gradient(90deg, #040725 0%, #040725 100%);
        color: #fff;
        line-height: 1;
        letter-spacing: 1px;
    }

    .dropdown .dropdown-menu {
        min-width: 65px;
        padding: 0;
        margin: 0;
        font-size: 11px;
        border-radius: 0;
    }

    .dropdown .dropdown-item {
        color: #282828;
        padding: 5px 11px;
        letter-spacing: 1px
    }

    .dropdown .dropdown-item:HOVER {
        color: #fff;
        background: linear-gradient(90deg, #040725 0%, #040725 100%);
        outline: none !important;
    }

   

    ._emp-D .doc-img,
    ._product-card .doc-img {
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 0;
    }

    ._product-card {
        overflow: visible;
    }

    ._product-card .dropdown {
        float: none;
        margin-right: 0;
        position: absolute;
        top: 10px;
        right: 8px;

    }

    .remove_click {
        pointer-events: none;
    }

    ._product-card .dropdown .btn {
        background: linear-gradient(90deg, #040725 0%, #040725 100%);
    }
</style>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01 mb-15">Intake Form <span>Management</span></h2>
    </div>

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="header-tabs pb-1 mb-10">
            <div class="row">
                <div class="col-auto">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active top-tabs" id="nav-home-tab" type="customer" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Form List<span class="_cus-val count_customers"> 0 </span></a>

                    </div>
                </div>

                <div class="col">
                    <div class="Product-Filter Cus-Filter">
                        <div class="row">
                            <div class="col-auto p-0">
                                <div class="CL-Product"><i class="fa fa-search"></i>
                                    <input type="text" class="form-control dynamic_search" id="" placeholder="Search">
                                </div>
                                <div class="_cust_filter m-0">
                                    <select class="custom-select custom-select-sm dynamic_filter">
                                        <option selected="" value="0">All</option>
                                        <option value="1">Pending</option>
                                        <option value="2">Accepted</option>
                                        <option value="3">Partially Filled</option>
                                        <option value="4">Submitted</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto pl-0 top_bar_customer">

                                <a href="<?php echo e(route('create-intake')); ?>" class="btn text-white btn-addproduct mb-0 "><i class="fa fa-plus"></i> Add New Form </a>
                                <div class="nav" id="nav-tab" role="tablist"> <a class="nav-item nav-link" id="productthumb-tab" data-toggle="tab" href="#productthumb2" role="tab" aria-controls="productthumb2" aria-selected="false"><i class="fa fa-th-large"></i></a> <a class="nav-item nav-link active" id="productList2-tab" data-toggle="tab" href="#productList2" role="tab" aria-controls="productList2" aria-selected="true"><i class="fa fa-th-list"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-content" id="nav-tabContent">

    
    <div class="tab-pane fade show active body_sales_agants" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active " id="productList2" role="tabpanel" aria-labelledby="productList2-tab">

                        <div class="Product-row-title">
                            <div class="row">
                                <div class="col colStyle h-auto" style="max-width:385px">Client</div>
                                <div class="col colStyle h-auto" style="max-width:220px">Form Type</div>
                                <div class="col colStyle h-auto" style="max-width:150px">Dated</div>
                                <div class="col colStyle h-auto" style="max-width:190px">Status</div>

                                <div class="col colStyle h-auto" style="max-width:180px">Action</div>
                            </div>
                        </div>
                        <div style="min-height: 400px" class="tblLoader">
                            <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                        </div>
                        <div class="cust_list_div ">
                        </div>
                    </div>
                    <div class="tab-pane fade " id="productthumb2" role="tabpanel" aria-labelledby="productthumb2-tab">
                        <div style="min-height: 400px" class="tblLoader">
                            <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                        </div>
                        <div class="row PT-15 cust_grid_div ">
                        </div>
                    </div>
                </div>
                <div class="ProductPageNav text-center">
                    <div id="cust_holder" class="holder" style="position: relative; "></div>
                    
                </div>
            </div>
        </div>
    </div>



</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('js'); ?>
<script>
    <?php if(\Session::has('error')): ?>
    $('#notifDiv').fadeIn();
    $('#notifDiv').css('background', 'red');
    $('#notifDiv').text('<?php echo e(\Session::get('
        error ')); ?>');
    setTimeout(() => {
        $('#notifDiv').fadeOut();
    }, 5000);
    <?php endif; ?>
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lms\Sourcecode-Academia-BE\resources\views/intake/index.blade.php ENDPATH**/ ?>