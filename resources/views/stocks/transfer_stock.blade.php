@extends('layouts.master')
@section('content')
<style>
  .table-set th {
    font-size: 12px !important;
    padding: 5px !important
  }

  .table-set td {
    font-size: 12px !important;
    padding: 5px !important
  }

  .dataTable .btn-default {
    letter-spacing: 1px
  }

  .form-s2 .select2-container--default .select2-selection--single .select2-selection__rendered {
    font-size: 13px;
    line-height: 30px
  }

  .form-s2 .select2-container .select2-selection--single {
    height: 30px !important;
  }

  .form-s2 .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 30px;
  }

  .btn-sm {
    font-size: 13px;
    padding: 4px 15px;
    margin-top: 29px;
    box-shadow: none
  }

  .btn-add-all {
    position: absolute;
    right: 15px;
    top: 11px;
    margin: 0
  }

  .add-stock-input {
    font-size: 12px;
    width: 80px;
    height: 21px;
    box-shadow: none;
    border-color: #dddddd;
    padding: 0px 5px 0 5px;
  }

  .font11 {
    font-size: 11px !important
  }
</style>
<div class="overlay-blure"></div>
<div id="blureEffct" class="container">

  <div class="row mt-2 mb-2">
    <div class="col-lg-6 col-md-6 col-sm-6">
      <h2 class="_head01">Stock <span> Transfer</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
      <ol class="breadcrumb">
        <li><a href="#"><span>Stock</span></a></li>
        <li><span>Transfer</span></li>
      </ol>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card PB-10">
        <div class="row m-0">
          <div class="col-6 p-0">
            <div class="header addPR-head">
              <h2>Current <span>Stock</span></h2>
            </div>

            <div class="row m-0">



              <div class="col-md-6 PT-5 pr-0">
                <label class="font11 mb-0">Select Batch</label>
                <div class="form-s2" id="batches_div">
                  <select id="batches" class="form-control formselect" placeholder="Select Batch">
                    <option value="0">Select Batch</option>
                    @foreach($batches as $batch)
                    <option value="{{$batch->id}}">{{$batch->batch_id}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-auto pr-0">
                <button type="button" class="btn btn-primary btn-sm" id="search_batch_stock">Search Batch</button>
              </div>
              <div class="col">
                <button type="button" id="transfer_all" class="btn btn-primary btn-sm btn-line w-100">Transfer ALL</button>
              </div>



            </div>

            <div class="col-12">
              <hr class="mt-10 mb-10">
            </div>
            <div class="col-12 retailerTable PB-10">
              <table class="table table-hover nowrap table-set" id="items_of_batch" style="width:100%">
                <thead>
                  <tr>
                    <th>SKU</th>
                    <th>Item Name</th>
                    <th>QTY.</th>
                    <th>Transfer QTY.</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>


                </tbody>
              </table>
            </div>

          </div>
          <div class="col-6 p-0">

            <div class="_selectProList h-100">

              <div class="header">
                <h2 class="w-100">New <span> Stock</span></h2>
              </div>

              <div class="row m-0 PB-10 mb-10" style="background-color:#fff;">



                <div class="col-md-6 PT-5 pr-0">
                  <label class="font11 mb-0">Select Customer</label>
                  <div class="form-s2" id="customers_div">
                    <select id="customers" class="form-control formselect" placeholder="Select Customer">
                      <option value="0">All Customer</option>
                      @foreach($customers as $customer)
                      <option value="{{$customer->id}}">{{$customer->company_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <!-- <div class="col-auto pr-0">
                        <button type="submit" class="btn btn-primary btn-sm" id="search_customer_stock">Search customer</button>
                      </div> -->
                <div class="col-3">
                </div>
                <div class="col-3">
                  <button type="button" id="revert_all" class="btn btn-primary btn-sm btn-line w-100">Revert ALL</button>
                </div>
              </div>

              <div class="col-12 retailerTable PB-10">
                <table class="table table-hover  nowrap table-set" id="items_of_customer" style="width:100%">
                  <thead>
                    <tr>
                      <th>SKU</th>
                      <th>Item Name</th>
                      <th>QTY.</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- <tr>
                            <td>2542</td>
                            <td>Coinchoclate 001</td>
                            <td>254</td>
                            <td><button class="btn btn-default mb-0">Revert</button></td>
                          </tr> -->
                  </tbody>
                </table>

              </div>




            </div>



          </div>

          <div class="col-md-12 text-right PT-15">
            <button type="button" class="btn btn-primary mr-2" onclick="saveCustomerStock()" id="save_cutomer_stock">Save</button>
            <button id="pl-close" type="submit" class="btn btn-cancel">Cancel</button>
          </div>

        </div>

      </div>
    </div>
  </div>

  <footer class="sticky-footer">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        2019 Sell3sixty All rights reserved
      </div>
    </div>
  </footer>

</div>


</div>
@endsection