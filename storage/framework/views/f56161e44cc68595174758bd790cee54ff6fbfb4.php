

<?php $__env->startSection('content'); ?>
<style>
  .pocPROFILE {
    font-size: 14px;
    padding: 15px 20px;
    line-height: 22px
  }

  .pocPROFILE h3 {
    font-size: 18px;
    margin: 0
  }

  .pocPROFILE h2 {
    font-size: 15px
  }

  .pocPic img {
    position: relative;
    width: 70px;
    height: 70px;
    height: auto;
    border-radius: 50%;
    -webkit-box-shadow: 0 0 20px 0 rgba(103, 92, 139, .25);
    box-shadow: 0 0 20px 0 rgba(103, 92, 139, .25);
  }

  .pocPROFILE .rightCont {
    letter-spacing: 1px;
    text-align: right
  }

  .pocPROFILE .rightCont .POCPH {
    font-size: 16px;
    display: block
  }

  .pocPROFILE .rightCont .POCPH strong {
    width: 108px;
    display: inline-block
  }

  .rightCont a {
    color: #EBB30A
  }

  .rightCont a:HOVER {
    text-decoration: underline
  }

  .pocPROFILE .form-control,
  .pocPROFILE .custom-select-sm,
  .pocPROFILE .form-s2 .select2-container .select2-selection--single,
  .phoneinput {
    box-shadow: none;
    height: 33px;
    background-color: #fff;
    border: solid 1px #e5e5e5;
    border-radius: 0;
    font-size: 13px;
  }

  .pocPROFILE .infoDiv {
    background-color: #f9f9f9;
    padding: 5px;
    margin-bottom: 8px;
  }

  .pocPROFILE .infoDiv .control-label {
    font-size: 13px;
    color: #7d7d7d !important;
    line-height: normal;
    margin-bottom: 0
  }

  .pocPROFILE .infoDiv p {
    font-size: 14px;
    color: #282828;
    line-height: normal;
    margin-bottom: 0
  }

  .pocPROFILE .p-col-L {
    padding-right: 4px
  }

  .pocPROFILE .p-col-R {
    padding-left: 4px
  }

  .ADD-border {
    border: solid 1px #ededed;
    padding: 10px 10px 4px 10px
  }

  .pocPROFILE .header {
    color: #424242;
    padding: 20px 0px;
    position: relative;
    box-shadow: none;
    background: none;
    border-bottom: solid 2px #ededed;
    margin-bottom: 5px;
    padding: 10px 0px;
  }

  .pocPROFILE .fa {
    color: #EBB30A
  }

  .POCBCard {
    width: 310px;
    height: auto
  }

  .PT-25 {
    padding-top: 25px !important
  }

  .pocPROFILE .dropify-wrapper {
    height: 150px;
    width: 100%;
  }

  .label-update {
    background: #EBB30A;
    color: #fff;
    text-align: center;
    font-size: 11px;
    line-height: 1;
    padding: 3px;
    margin-top: -24px;
    margin-left: 7px;
    z-index: 5;
    position: relative;
    width: 50px
  }

  .pocPROFILE .dropify-message p {
    letter-spacing: 0;
  }

  ._ch-pass {
    padding-top: 28px
  }

  .pocPROFILE .btn-primary,
  .pocPROFILE .btn-cancel {
    font-size: 13px
  }

  .change-password {
    box-shadow: none;
    padding: 15px;
    border: 1px solid rgba(0, 0, 0, .1);
  }

  .cp-close {
    line-height: 1;
    padding: 5px;
    position: absolute;
    right: -5px;
    top: -4px;
    opacity: .4;
    filter: grayscale(1)
  }

  .nam-title {
    font-size: 18px;
    margin-top: 15px;
    display: inline-block;
    letter-spacing: 1px
  }

  .con_info p {
    margin: 0;
    letter-spacing: 1.2px
  }

  .btn-edit-p {
    padding: 6px 14px 6px 14px;
    letter-spacing: 1px;
    font-size: 13px;
    line-height: 1;
    margin-top: -5px;
    float: right;
    margin-left: 10px
  }

  .btn-edit-line {
    color: #040725;
    background: #fff;
    border: 1px solid #040725;
  }

  .link-doc {
    border-bottom: solid 1px #EBEBEB;
    color: #282828;
    display: block;
    padding-top: 5px;
    padding-bottom: 5px;
    text-decoration: underline
  }

  .link-doc p {
    line-height: 1.3rem;
    height: 1.3rem;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    font-size: 13px;
    font-: ;
    weight: normal;
    margin-bottom: 0px
  }

  .link-doc p img {
    width: 18px;
    height: 18px;
    filter: invert();
    margin-right: 8px;
    opacity: 0.5
  }

  .btn-primary {
    letter-spacing: 1px
  }

  .line-none h2:before {
    display: none;
  }

  .date-birth input {
    width: 70px;
    margin-right: 10px;
    display: inline-block;
  }

  .addBTN-act {
    font-size: 13px;
    background-color: #040725;
    border: none;
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    border-radius: 0;
    -khtml-border-radius: 0;
    box-shadow: 2px 2px 10px 0 rgb(79 79 79 / 20%);
    padding: 6px 10px;
    color: #fff !important;
    float: right;
    cursor: pointer;
  }

  .closeBTN-d {
    background: #282828;
    border-radius: 50%;
    color: #fff;
    font-size: 14px;
    line-height: 22px;
    width: 24px;
    height: 24px;
    text-align: center;
    padding: 0;
    line-height: 1;
    border: solid 1px #282828 !important;
    outline: none;
    display: block;
    opacity: 0.5;
    margin-top: 5px;
  }

  .closeBTN-d:HOVER,
  .closeBTN-d:focus {
    opacity: 1;
    background: #f12300;
    border: solid 1px #f12300 !important;
  }

  .closeBTN-d i {
    color: #fff !important;
  }

  .phoneinput {
    padding-left: 10px;
  }

  .phone-SL {
    height: auto !important;
    margin: 0px;
  }

  .phone-SL .custom-select {
    font-size: 13px
  }

  .font11 {
    font-size: 11px;
  }

  .pt-7 {
    padding-top: 7px;
  }
</style>



<div class="row mt-2 mb-3">
  <div class="col-lg-6 col-md-6 col-sm-6">
    <h2 class="_head01">Commission  <span>Management</span></h2>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
    <ol class="breadcrumb">
      <li><a href="/students"><span>Commission</span></a></li>
      <li><span>Edit</span></li>
    </ol>
  </div>
</div>

<form id="form" enctype="multipart/form-data" class="">

  <!-- <input type="hidden" name="account_type" value="1"> -->
  <input type="hidden" name="hidden_order_id" value="">
  <input type="text" id="hidden_commission_id" value="<?php echo e($commission->id); ?>" name="id" hidden>

 
  <?php echo csrf_field(); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="body pocPROFILE">
          <div class="row">
            <div class="col-12">
              <div class="header pt-0">
                <h2>Basic Information <span>of the Order :</span></h2>
              </div>
            </div>

            <div class="col-12">
              <div class="form-wrap p-0">

                <div class="infoDiv p-15">
                  <div class="row"> 
                    <div class="col-md-3 mb-10 ">

                <label class="control-label mb-5">Invoice No *</label>
                <input type="text" id="" class="form-control first_name  " placeholder="" name="invoice_no" id="invoice_no" value="<?php echo e($order->invoice_no); ?>" readonly>

              </div>
              <div class="col-md-3 mb-10">

                      <label class="control-label mb-5">Date  *</label>
                      <input type="text" id="" class="form-control  " placeholder=""  value="<?php echo e($order->date); ?>" readonly name="date" >

               </div>
                    <div class="col-md-3 mb-10 ">

                      <label class="control-label mb-5">Vehical No *</label>
                      <input type="text" id="" class="form-control first_name  " placeholder=""  value="<?php echo e($order->vehical_no); ?>" readonly name="vehical_no" id="vehical_no">

                    </div>
                    <div class="col-md-3 mb-10">

                      <label class="control-label mb-5">From *</label>
                      <input type="text" id="" class="form-control   " placeholder=""  value="<?php echo e($order->order_from); ?>" readonly name="order_from">

                    </div>

                    <div class="col-md-3 mb-10">

                      <label class="control-label mb-5">To  *</label>
                      <input type="text" id="" class="form-control  " placeholder=""  value="<?php echo e($order->order_to); ?>" readonly name="order_to">

                    </div>
                      <div class="col-md-3 mb-10">

                      <label class="control-label mb-5">Adda Name  *</label>
                      <input type="text" id="" class="form-control  " placeholder=""  value="<?php echo e($order->add_name); ?>" readonly name="add_name">

                    </div>
                   

                    <div class="col-md-3">

                      <label class="control-label mb-5">Goods *</label>
                      <div>
                        <input  type="text" class="form-control " name="goods" value="<?php echo e($order->goods); ?>" readonly>

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

<div class="col-md-12 mt-15 ">
<div class="card ">
<div class="body pocPROFILE">
          <div class="row"> <div class="col-12">
              <div class="header pt-0">
                <h2>Manage <span>Commission :</span></h2>
              </div>
            </div>
			<div class="table-responsive p-2" >
            <table class="table table-bordered mg-b-0"  >
              <thead>
                <tr>
                  <th width="20">S.NO</th>
                  <th width="150px">Goods</th>
                  <th width="90px">Commission</th>
                  <th width="90px">Rent</th>
                  <th width="90px">Bilty</th>
                  <th width="120">Total</th>
                  <!-- <th width="100px">Action</th> -->
                </tr>
              </thead>
              			<form action="" method="Post"></form>
              <tbody>
                <tr>
                  <td>1</td>
                  <td><?php echo e($commission->goods); ?></td>
                  <td><?php echo e($commission->commission); ?></td>
                  <td><?php echo e($commission->total_rent); ?></td>
                  <td><?php echo e($order->builty_punch); ?></td>
                  <td><?php echo e($commission->total_rent); ?></td>
                 <!--  <td>
                  	
                  	<a href="edit-manage-khata.php?editid=&st=add"><i class="fa fa-edit" ></i></a> ||
                  	<a href="add-khata.php?delid="><i class="fa fa-trash" style="color:red"></i></a>
                  </td> -->
                </tr>
                <tr>
                  <th colspan="2" style="text-align: right">Total Commission</th>
                  <td><b><?php echo e($commission->commission); ?></b> Rs. </td>
                  <th colspan="2" style="text-align: right">Total Rupees</th>
                  <td><b><?php echo e($commission->total_rent); ?></b> Rs. </td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align: right"> Received Commission</td>
                  <td>
                    <input type="hidden" name="received_commission" id="received_amount" value="0" style="width: 10em">
                    <b><?php echo e($commission->received_commission); ?></b> Rs.
                  </td>
                  <td colspan="3"></td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align: right">Remaining Commission</td>
                  <td>
                    <b><?php echo e($commission->balance); ?></b> Rs.
                  </td>
                  <td colspan="3"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right">Add New Commission</td>
                  <td>
                    <input type="number" id="new_commission" class="in-table" max="<?php echo e($commission->balance); ?>" min="0" name="new_commission" value="<?php echo e($commission->balance); ?>" style="width:100px " required="">
                  </td>
                  
                </tr><tr>
                  <td colspan="12"><input id="btn-save-commission" data-id="<?php echo e($commission->id); ?>" type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm" style="float:right"></td>
                </tr>


               
              </tbody>
            </table>
        </div>
		</div>
    </div>
    </div>
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Sourcecode-Academia-BE\resources\views/orders/edit.blade.php ENDPATH**/ ?>