@extends('layouts.master')
@section('content')
<style>
    .Up-DocList a {
        display: inline-block;
    }
</style>
<div class="container container-1240">
    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Order <span>Management</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Order</span></a></li>
                <li><span>Dispatch Details</span></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card _Dispatch">
                <div class="header">
                    <h2>Order <span>Dispatch</span></h2>
                </div>
                <div class="row m-0">
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <div class="nav flex-column nav-pills CB-account-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                            <a class="nav-link active" id="v-pills-00-tab" data-toggle="pill" href="#v-pills-00" role="tab" aria-controls="v-pills-00" aria-selected="true">Products Selection</a>

                            <a class="nav-link " id="v-pills-01-tab" data-toggle="pill" href="#v-pills-01" role="tab" aria-controls="v-pills-01" aria-selected="true">Shipping Information</a>

                            <a class="nav-link" id="v-pills-02-tab" data-toggle="pill" href="#v-pills-02" role="tab" aria-controls="v-pills-02" aria-selected="false">Invoice Information </a>

                            <a class="nav-link" id="v-pills-03-tab" data-toggle="pill" href="#v-pills-03" role="tab" aria-controls="v-pills-03" aria-selected="false">Packing List </a>

                            <a class="nav-link" id="v-pills-04-tab" data-toggle="pill" href="#v-pills-04" role="tab" aria-controls="v-pills-04" aria-selected="false">Commercial Invoice </a>

                            <a class="nav-link" id="v-cus-inv-tab" data-toggle="pill" href="#v-cus-inv" role="tab" aria-controls="v-cus-inv" aria-selected="false">Custom Invoice</a>

                            <a class="nav-link" id="v-act-inv-tab" data-toggle="pill" href="#v-act-inv" role="tab" aria-controls="v-act-inv" aria-selected="false">Actual Invoice</a>

                            <a class="nav-link" id="v-pills-05-tab" data-toggle="pill" href="#v-pills-05" role="tab" aria-controls="v-pills-05" aria-selected="false">Upload Documents</a>

                            <a class="nav-link" id="v-pills-06-tab" data-toggle="pill" href="#v-pills-06" role="tab" aria-controls="v-pills-06" aria-selected="false">System Generator</a>

                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-12 ml-800">
                        <div class="tab-content" id="v-pills-tabContent">

                            <div class="tab-pane fade show active" id="v-pills-00" role="tabpanel" aria-labelledby="v-pills-00-tab">
                                <div class="CB_info">
                                    <div id="floating-label" class="card top_border mb-3">
                                        <div class="col-md-12">
                                            <div class="form-wrap PT-10 pb-15">
                                                <div class="row">
                                                    <div class="col-md-12 pt-10">
                                                        <h2 class="_head04">Products <span>Selection</span>
                                                        </h2>
                                                    </div>


                                                    <div class="col-12 pt-10">
                                                        <form id="dispatch_form">
                                                            <table class="table table-hover nowrap table-PL" id="example1" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Product</th>
                                                                        <th>Ordered QTY.</th>
                                                                        <th>Stock Available.</th>
                                                                        <th>Dispatch</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($order_contents as $content)
                                                                    <tr>
                                                                        <td>{{$content->name}}</td>
                                                                        <td>{{$content->qty}}</td>
                                                                        <td>{{$content->available_stock}}</td>
                                                                        <input type="hidden" id="order_qty_for_{{$content->item_id}}" name="ordered_qty[{{$content->item_id}}]" value="{{$content->qty}}">
                                                                        <input type="hidden" name="customer_id" value="{{$content->customer_id}}">
                                                                        <input type="hidden" name="order_id" value="{{$content->order_id}}">
                                                                        <td><input type="text" name="dispatch_qty[{{$content->item_id}}]" class="dispatch_qty only_numerics" id="{{$content->item_id}}" class="cu-Rate" placeholder="0"></td>
                                                                    </tr>
                                                                    @endforeach

                                                                </tbody>
                                                            </table>
                                                        </form>

                                                    </div>






                                                </div>


                                                <div class="row m-0 PT-15">
                                                    <button type="button" class="btn btn-primary mr-2" id="dispatch_button">Save</button>
                                                    <button type="button" class="btn btn-cancel mr-2">Cancel</button>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-01" role="tabpanel" aria-labelledby="v-pills-01-tab">
                                <div class="CB_info">
                                    <div id="floating-label" class="card top_border mb-3">
                                        <div class="col-md-12">
                                            <div class="form-wrap PT-10 pb-15">
                                                <div class="row">
                                                    <div class="col-md-12 pt-10">
                                                        <h2 class="_head04">Shipping <span>Information</span>
                                                            <div class="OD-invoiceNo">Invoice No: <span>{{$order->invoice_num}}</span></div>
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 pt-5">
                                                        <div class="row ST-sec">
                                                            <div class="col-auto"><strong>Select Shipment Type:</strong></div>
                                                            <div class="col-auto">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" name="shippment_type" {{$order->order_type == "FOB" ? "checked" : "" }} id="weekly" value='valuable'>
                                                                    <label class="custom-control-label" for="weekly">FOB</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" name="shippment_type" {{$order->order_type == "CFR" ? "checked" : "" }} id="biweekly" value='valuable'>
                                                                    <label class="custom-control-label" for="biweekly">CFR</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" name="shippment_type" {{$order->order_type == "CFI" ? "checked" : "" }} id="monthly" value='valuable'>
                                                                    <label class="custom-control-label" for="monthly">CFI</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-12 pt-10">
                                                        <form id="shipping_information">
                                                            <div class="row">
                                                                <div class="col-2">
                                                                    <label class="font12">Date of Shipment</label>
                                                                    <div class="form-group" style="height: auto">
                                                                        <input type="text" name="date_of_shippment" value="{{$order->date_of_shipment}}" class="form-control datepicker" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="font12">Shipping Company</label>
                                                                    <div class="form-s2 ">
                                                                        <select class="form-control formselect" name="shipping_company" placeholder="Select Secondary  Customer">
                                                                            @foreach($shipping_companies as $company)
                                                                            <option {{$order->shipment_company == $company->id ? "selected" : ""}}>{{$company->company_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="font12">Freight Forwarder</label>
                                                                    <div class="form-s2">
                                                                        <select class="form-control formselect" name="freight_forwarder" placeholder="Select Secondary  Customer">
                                                                            <option>Select Forwarder</option>
                                                                            @foreach($forwarders as $forwarder)
                                                                            <option>{{$forwarder->company_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-2">
                                                                    <label class="font12">ETA</label>
                                                                    <div class="form-group" style="height: auto">
                                                                        <input type="text" value="{{$order->eta_date}}" class="form-control datepicker" name="eta" placeholder="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-2">
                                                                    <label class="font12">ETD</label>
                                                                    <div class="form-group" style="height: auto">
                                                                        <input type="text" class="form-control datepicker" name="etd" placeholder="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <label class="font12">Discharge Date</label>
                                                                    <div class="form-group" style="height: auto">
                                                                        <input type="text" value="{{$order->discharge_date}}" class="form-control datepicker" name="discharge_date" placeholder="">
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-6">
                                                                    <label class="font12">Discharge Port</label>
                                                                    <div class="form-s2">
                                                                        <select class="form-control formselect" placeholder="Select Payment Type" style="width: 100%">
                                                                            <option selected>Select Discharge Port</option>
                                                                            @foreach($delivery_ports as $port)
                                                                            <option {{$order->port_of_discharge == $port->id ? "selected" : ""}}>{{$port->port_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                

                                                                <div class="col-md-3 PT-5">
                                                                    <div class="form-group mt-5">
                                                                        <label class="control-label mb-10">Voyage Number</label>
                                                                        <input type="text" id="" value="{{$order->voyage_number}}" name="voyage_number" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3 PT-5">
                                                                    <div class="form-group mt-5">
                                                                        <label class="control-label mb-10">Vessel Name</label>
                                                                        <input type="text" id="" value="{{$order->vessel_name}}" name="vessel_name" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3 PT-5">
                                                                    <div class="form-group mt-5">
                                                                        <label class="control-label mb-10">Vessel Number</label>
                                                                        <input type="text" id="" name="vessel_number" value="" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3 PT-5">
                                                                    <div class="form-group mt-5">
                                                                        <label class="control-label mb-10">OMI Number</label>
                                                                        <input type="text" name="omi_number" id="" value="{{$order->omi_number}}" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-12 mt-10">
                                                                    <h2 class="_head04">Container <span> Details</span></h2>
                                                                </div>
                                                                <div class="col-12 mb-10">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label class="font12">Container Type</label>
                                                                            <select class="custom-select" id="container_type">
                                                                                <option selected>Select Container Type</option>
                                                                                <option>20 FT</option>
                                                                                <option>40 FT</option>
                                                                                <option>40 FT HC</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3 pt-5">
                                                                            <div class="form-group mt-5">
                                                                                <label class="control-label mb-5">Container No.</label>
                                                                                <input type="text" id="container_number" class="form-control" placeholder="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 _addSecon-btn">
                                                                            <button type="button" class="btn btn-primary mr-2 mt-5" id="add_container_details">Add</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12" id="container_numbers">
                                                                            <hr class="mt-10 mb-10">
                                                                           
                                                                            
                                                                           
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 mt-10">
                                                                    <h2 class="_head04">Freight <span> Charges</span></h2>
                                                                </div>

                                                                <div class="col-12">
                                                                    <div class="row">

                                                                        <!--<div class="col-md-12">
                              <div class="row m-0 justify-content-end">
                              <div class="col-auto FontLabVal"><strong>Quoted Charges</strong></div>
                              <div class="col-auto selectCurr"><select class="custom-select custom-select-sm">
								  <option>Select Currency</option>
								  <option selected value="1">USD</option>					 
								  <option>PKR</option>
								</select> 
                             </div>
                             <div class="col-auto p-0 FOBVal"><input type="text" id="" class="form-control" value="25.00"></div>
                              </div>
                              </div>
                               <div class="col-md-12">
                              <div class="row m-0 justify-content-end">
                              <div class="col-auto FontLabVal"><strong>Actual Charges</strong></div>
                              <div class="col-auto selectCurr"><select class="custom-select custom-select-sm">
								  <option>Select Currency</option>
								  <option selected value="1">USD</option>					 
								  <option>PKR</option>
								</select> 
                             </div>
                             <div class="col-auto p-0 FOBVal"><input type="text" id="" class="form-control" value="25.00"></div>
                              </div>
                              </div>-->

                                                                        <div class="col-12 PT-5">
                                                                            <div class="row">
                                                                                <div class="col"><strong class="PT-5 font13">Quoted Charges</strong></div>
                                                                                <div class="col-auto selectCurr"><select class="custom-select custom-select-sm" name="quoted_charges_currency">
                                                                                        <option>Select Currency</option>
                                                                                        <option {{$order->actual_freight_currency == "usd" ? "selected" : ""}} value="usd">USD</option>
                                                                                        <option {{$order->actual_freight_currency == "pkr" ? "selected" : ""}} value="pkr">PKR</option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="col-3 pl-0">
                                                                                    <input type="text" value="{{$order->quoted_freight_charges}}" name="qouted_charges" id="" class="form-control" value="0">
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <hr class="mt-5  mb-5">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 PT-5">
                                                                            <div class="row">
                                                                                <div class="col"><strong class="PT-5 font13">Actual Charges</strong></div>
                                                                                <div class="col-auto selectCurr"><select class="custom-select custom-select-sm" name="actual_charges_currency">
                                                                                        <option>Select Currency</option>
                                                                                        <option {{$order->actual_freight_currency == "usd" ? "selected" : ""}} value="usd">USD</option>
                                                                                        <option {{$order->actual_freight_currency == "pkr" ? "selected" : ""}} value="pkr" >PKR</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-3 pl-0">
                                                                                    <input type="text" value="{{$order->actual_freight_charges}}" name="actual_charges" id="" class="form-control" value="0">
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <hr class="mt-5  mb-5">
                                                                                </div>
                                                                            </div>
                                                                        </div>




                                                                    </div>
                                                                </div>




                                                                <!-- <div class="col-md-12 pt-10 mb-10">
                                                                <h2 class="_head04">Documents <span> Upload (images, pdf, doc, docx, xlsx)</span></h2>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div>
                                                                    <form action="#" class="dropzone" id="my-awesome-dropzone">
                                                                        <div class="fallback">
                                                                            <input name="file" type="file" multiple />
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div> -->

                                                            </div>
                                                    </div>
                                                    </form>

                                                </div>


                                                <div class="row m-0 PT-15">
                                                    <button type="button" id="save_shipping_info" class="btn btn-primary mr-2">Save</button>
                                                    <button type="button" class="btn btn-cancel mr-2">Cancel</button>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-02" role="tabpanel" aria-labelledby="v-pills-02-tab">
                                <div class="CB_info">
                                    <div class="card top_border mb-3">
                                        <div class="col-md-12">
                                            <div class="form-wrap PT-10 pb-15">
                                                <div class="row">
                                                    <div class="col-md-12 pt-10">
                                                        <div class="_head04 border-0">Invoice <span>Detail</span>
                                                            <div class="OD-invoiceNo">
                                                                <div class="row">
                                                                    <div class="col-auto">Invoice Date :</div>
                                                                    <div class="col-auto pl-0">
                                                                        <input type="text" class="form-control datepicker InvdateTP" placeholder="">
                                                                    </div>
                                                                    <div class="col-auto pl-0">Invoice No: <span>E-0154585</span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--   <div class="col-md-12">
                                 <strong>Customer Details</strong>
                                </div>-->

                                                    <div class="col-12">
                                                        <div class="ShipCharSec mt-0">
                                                            <a class="invInfoEdit" href="#"><i class="fa fa-pencil-alt"></i></a>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label class="font12 mb-0">Invoice To </label>
                                                                    <input type="text" class="form-control invFor" placeholder="{{$customer->company_name}}">
                                                                    <input type="text" class="form-control invForAdd" placeholder="{{$customer->address}}">
                                                                </div>

                                                            </div>

                                                            <div class="row PT-10">
                                                                <div class="col-md-4">
                                                                    <label class="font12">Port</label>
                                                                    <div class="form-s2">
                                                                        <select class="form-control formselect" placeholder="Select Payment Type" style="width: 100%">
                                                                            <option selected>Select Port</option>
                                                                            <option>Country</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="font12">City</label>
                                                                    <div class="form-s2">
                                                                        <select class="form-control formselect" placeholder="Select Payment Type" style="width: 100%">
                                                                            <option selected>Select City</option>
                                                                            <option>Country</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="font12">Country</label>
                                                                    <div class="form-s2">
                                                                        <select class="form-control formselect" placeholder="Select Payment Type" style="width: 100%">
                                                                            <option selected>Select Country</option>
                                                                            <option>Country</option>
                                                                        </select>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-12 pt-10">
                                                        <h2 class="_head04 mb-10">Product <span>Details</span></h2>
                                                    </div>

                                                    <div class="col-12">

                                                        <div class="row" id="floating-label">

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">Invoice For</label>
                                                                    <input type="text" class="form-control" placeholder="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">PTC Code </label>
                                                                    <input type="text" class="form-control" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">SRO</label>
                                                                    <input type="text" class="form-control" placeholder="">
                                                                </div>
                                                            </div>


                                                            <div class="col-md-4 pt-10">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">S/B No </label>
                                                                    <input type="text" class="form-control" placeholder="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label class="font12">S/B Date: </label>
                                                                <div class="form-group" style="height: auto">
                                                                    <input type="text" class="form-control datepicker" placeholder="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 pt-10">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">Form E number </label>
                                                                    <input type="text" class="form-control" placeholder="">
                                                                </div>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">Marks No </label>
                                                                    <input type="text" class="form-control" placeholder="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">S/T No</label>
                                                                    <input type="text" class="form-control" placeholder="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 PT-20">
                                                                <h2 class="_head04">LC <span>Details</span></h2>
                                                            </div>
                                                            <div class="col-md-4 PT-10">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">L/C Through </label>
                                                                    <input type="text" class="form-control" placeholder="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 PT-10">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-10">L/C Number </label>
                                                                    <input type="text" class="form-control" placeholder="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label class="font12">L/C Date</label>
                                                                <div class="form-group" style="height: auto">
                                                                    <input type="text" class="form-control datepicker" placeholder="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 mb-5 PT-20">
                                                                <div class="row m-0 justify-content-end">
                                                                    <div class="col-auto FontLabVal"><strong>FOB Value</strong></div>
                                                                    <div class="col-auto selectCurr"><select class="custom-select custom-select-sm">
                                                                            <option>Select Currency</option>
                                                                            <option selected value="1">USD</option>
                                                                            <option>PKR</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-auto p-0 FOBVal"><input type="text" id="" class="form-control FOBVinput" value="42,220.00"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="row m-0 justify-content-end">
                                                                    <div class="col-auto FontLabVal"><strong>Discount</strong></div>
                                                                    <div class="col-auto selectCurr"><select class="custom-select custom-select-sm">
                                                                            <option>Select Currency</option>
                                                                            <option selected value="1">USD</option>
                                                                            <option>PKR</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-auto p-0 FOBVal"><input type="text" id="" class="form-control" value="25.00"></div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row m-0 PT-15 pb-10">
                                                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                                                    <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-03" role="tabpanel" aria-labelledby="v-pills-03-tab">
                                <div class="tab-pane fade show active" id="v-pills-01" role="tabpanel" aria-labelledby="v-pills-01-tab">
                                    <div class="CB_info">
                                        <div id="floating-label" class="card top_border mb-3">
                                            <div class="col-md-12">
                                                <div class="form-wrap PT-10 PB-20">
                                                    <div class="row">
                                                        <div class="col-md-12 pt-10 mb-0">
                                                            <h2 class="_head04 mb-0">Packing <span>List</span></h2>
                                                        </div>
                                                        <div class="col-md-12 productRate-table m-0">
                                                            <table class="table table-hover nowrap table-PL" id="example1" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Carton No.</th>
                                                                        <th>Product Name</th>
                                                                        <th>Cartons</th>
                                                                        <th>Net Weight </th>
                                                                        <th>Gross Weight </th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>Total</th>
                                                                        <th> 2613 CTNS</th>
                                                                        <th>16255.200 KGS</th>
                                                                        <th>2155.524 KGS</th>
                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><input type="text" class="CN-st-end" placeholder="0">
                                                                            to
                                                                            <input type="text" class="CN-st-end" placeholder="0">
                                                                        </td>
                                                                        <td>Product Name a b c d e f g fa b c d e f</td>
                                                                        <td>400</td>
                                                                        <td>4000</td>
                                                                        <td><input type="text" class="cu-Rate" placeholder="0"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input type="text" class="CN-st-end" placeholder="0">
                                                                            to
                                                                            <input type="text" class="CN-st-end" placeholder="0">
                                                                        </td>
                                                                        <td>Product Name 1</td>
                                                                        <td>400</td>
                                                                        <td>4000</td>
                                                                        <td><input type="text" class="cu-Rate" placeholder="0"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input type="text" class="CN-st-end" placeholder="0">
                                                                            to
                                                                            <input type="text" class="CN-st-end" placeholder="0">
                                                                        </td>
                                                                        <td>Product Name 1</td>
                                                                        <td>400</td>
                                                                        <td>4000</td>
                                                                        <td><input type="text" class="cu-Rate" placeholder="0"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input type="text" class="CN-st-end" placeholder="0">
                                                                            to
                                                                            <input type="text" class="CN-st-end" placeholder="0">
                                                                        </td>
                                                                        <td>Product Name 1</td>
                                                                        <td>400</td>
                                                                        <td>4000</td>
                                                                        <td><input type="text" class="cu-Rate" placeholder="0"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row m-0 PT-15">
                                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                                        <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-04" role="tabpanel" aria-labelledby="v-pills-04-tab">
                                <div class="CB_info">
                                    <div id="floating-label" class="card top_border mb-3">
                                        <div class="col-md-12">
                                            <div class="form-wrap PT-10 PB-20">
                                                <div class="row">
                                                    <div class="col-md-12 pt-10 mb-0">
                                                        <h2 class="_head04">Commercial <span>Invoice</span></h2>
                                                    </div>
                                                    <div class="col-md-12 productRate-table m-0">
                                                        <table class="table table-hover  nowrap table-PL" style="width:100% !important">
                                                            <thead>
                                                                <tr>
                                                                    <th>QTY. In CTNS</th>
                                                                    <th>Product Name</th>
                                                                    <th>Unit Price(US $)</th>
                                                                    <th>Amount(US $) </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>500</td>
                                                                    <td>Product Name a b c d e f g fa b c d e f g f </td>
                                                                    <td>$
                                                                        <input type="text" class="cu-Rate" placeholder="0">
                                                                    </td>
                                                                    <td>$4,000.44</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>500</td>
                                                                    <td>Product Name a b c d e f g fa b c d e f g f </td>
                                                                    <td>$
                                                                        <input type="text" class="cu-Rate" placeholder="0">
                                                                    </td>
                                                                    <td>$4,000.44</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>500</td>
                                                                    <td>Product Name a b c d e f g fa b c d e f g f </td>
                                                                    <td>$
                                                                        <input type="text" class="cu-Rate" placeholder="0">
                                                                    </td>
                                                                    <td>$4,000.44</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>500</td>
                                                                    <td>Product Name a b c d e f g fa b c d e f g f </td>
                                                                    <td>$
                                                                        <input type="text" class="cu-Rate" placeholder="0">
                                                                    </td>
                                                                    <td>$4,000.44</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row m-0 PT-15">
                                                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                                                    <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-05" role="tabpanel" aria-labelledby="v-pills-05-tab">
                                <div class="CB_info">
                                    <div id="floating-label" class="card top_border mb-3">
                                        <div class="col-md-12">
                                            <div class="form-wrap PT-10 PB-20">
                                                <div class="row">
                                                    <div class="col-md-12 pt-10 mb-10">
                                                        <h2 class="_head04">Documents <span> Upload</span></h2>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-s2">
                                                            <select class="form-control formselect" placeholder="select Product" style="width: 100%">
                                                                <option selected>Select Document</option>
                                                                <option>Certificate of Origin</option>
                                                                <option>External Health Certificate</option>
                                                                <option>Product Specification Documents</option>
                                                                <option>Sanitary Certificate</option>
                                                                <option>PCSIR</option>
                                                                <option>Phytosanitry</option>
                                                                <option>Form A</option>
                                                                <option>GD</option>
                                                                <option>Milk Certificate</option>
                                                                <option>Health Certificate Govt Issued</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 PT-5">
                                                        <label class="font12">Documents Attachment</label>
                                                        <div class="">
                                                            <form action="#" class="dropzone" id="my-awesome-dropzone">
                                                                <div class="fallback">
                                                                    <input name="file" type="file" multiple />
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 PT-20">
                                                        <h2 class="_head04">Certificate of Origin</h2>
                                                        <div class="Up-DocList"> <a href="#"><i class="fa fa-file"></i>Certificate of Origin.jpg </a> <a href="#"><i class="fa fa-file"></i>Certificate of file name.pdf </a> <a href="#"><i class="fa fa-file"></i>Certificate of Origin.jpg </a> <a href="#"><i class="fa fa-file"></i>Certificate of file name.pdf </a> </div>
                                                    </div>
                                                    <div class="col-md-12 PT-20">
                                                        <h2 class="_head04">External Health Certificate</h2>
                                                        <div class="Up-DocList"> <a href="#"><i class="fa fa-file"></i>External-Health-Certificate.jpg </a> <a href="#"><i class="fa fa-file"></i>External-Health-Certificate-file-External-Health-Certificate-file.pdf </a> <a href="#"><i class="fa fa-file"></i>External-Health-Certificate.jpg </a> <a href="#"><i class="fa fa-file"></i>External-Health-Certificate-file.pdf </a> </div>
                                                    </div>
                                                    <div class="col-md-12 PT-20">
                                                        <h2 class="_head04">Product Specification Documents</h2>
                                                        <div class="Up-DocList"> <a href="#"><i class="fa fa-file"></i>ProductSpecificationDocuments.jpg </a> <a href="#"><i class="fa fa-file"></i>ProductSpecificationDocuments.pdf </a> <a href="#"><i class="fa fa-file"></i>ProductSpecificationDocuments.jpg </a> <a href="#"><i class="fa fa-file"></i>ProductSpecificationDocuments.pdf </a> </div>
                                                    </div>
                                                </div>
                                                <div class="row m-0 PT-15">
                                                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                                                    <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-cus-inv" role="tabpanel" aria-labelledby="v-cus-inv-tab">
                                <div class="CB_info">
                                    <div id="floating-label" class="card top_border mb-3">
                                        <div class="col-md-12">
                                            <div class="form-wrap PT-10 PB-20">
                                                <div class="row">
                                                    <div class="col-md-12 pt-10 mb-0">
                                                        <h2 class="_head04">Custom <span>Invoice</span></h2>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Invoice No</label>
                                                        <div class="form-s2">
                                                            <select class="form-control formselect" placeholder="Select Type" style="width: 100%">
                                                                <option selected>Select</option>
                                                                <option>21455</option>
                                                                <option>21456</option>
                                                                <option>21457</option>
                                                                <option>21458</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Invoice Date</label>
                                                        <input type="text" id="invoice_date" class="form-control customInvoiceField required dispatchOrderDatepicker" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Invoice For</label>
                                                        <input type="text" id="invoice_for" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Invoice Address</label>
                                                        <input type="text" id="invoice_address" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Invoice Port</label>
                                                        <input type="text" id="invoice_port" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">FOB Value</label>
                                                        <input type="number" id="fob_value" class="form-control customInvoiceField required" placeholder="">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Freight</label>
                                                        <input type="number" id="freight" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Insurance</label>
                                                        <input type="number" id="insurance" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Discount</label>
                                                        <input type="number" id="discount" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">S/B No</label>
                                                        <input type="text" id="sb_no" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">S/B Date</label>
                                                        <input type="text" id="sb_date" class="form-control customInvoiceField required dispatchOrderDatepicker" placeholder="">
                                                    </div>
                                                    <div class="col-12">
                                                        <hr class="mb-5">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Invoice To</label>
                                                        <input type="text" id="invoice_to" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">L/C Through</label>
                                                        <input type="text" id="lc_through" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">L/C Number</label>
                                                        <input type="text" id="lc_number" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">L/C Date</label>
                                                        <input type="text" id="lc_number" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Form 'E' No</label>
                                                        <input type="text" id="form_e_no" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Form 'E' Date</label>
                                                        <input type="text" id="form_e_date" class="form-control customInvoiceField required dispatchOrderDatepicker" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">FOBCFRCFI</label>
                                                        <input type="text" id="fobcfrcfi" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Shipped Via</label>
                                                        <input type="text" id="shipped_via" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Marks Number</label>
                                                        <input type="text" id="marks_no" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">AdvPmt</label>
                                                        <input type="number" id="adv_pmt" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-12">
                                                        <hr class="mb-5">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">SRO</label>
                                                        <input type="text" id="sro" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Custom Invoice No</label>
                                                        <input type="text" id="custom_invoice_no" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Invoice No</label>
                                                        <input type="text" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Invoice Country</label>
                                                        <input type="text" id="invoice_country" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Invoice City</label>
                                                        <input type="text" id="invoice_city" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Payment Terms1</label>
                                                        <input type="text" id="invoice_city" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">FDBC/PRC No</label>
                                                        <input type="text" id="fdbc_prc_no" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">FDBC/PRC Date</label>
                                                        <input type="text" id="fdbc_prc_date" class="form-control customInvoiceField required dispatchOrderDatepicker" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">Export Pak Rs</label>
                                                        <input type="number" id="export_pak_rs" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">S/T No</label>
                                                        <input type="text" id="st_no" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font12 mb-5">PTC Code</label>
                                                        <input type="text" id="ptc_code" class="form-control customInvoiceField required" placeholder="">
                                                    </div>
                                                    <div class="col-12">
                                                        <hr class="mb-5">
                                                    </div>
                                                    <div class="col-12">
                                                        <div style="overflow: scroll; height: 290px; padding: 20px">

                                                            <table class="table table-hover nowrap" id="example" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Order ID</th>
                                                                        <th>P</th>
                                                                        <th>Description</th>
                                                                        <th>Unit Price</th>
                                                                        <th>Qty</th>
                                                                        <th>Net Weight</th>
                                                                        <th>QtyBgJrBx</th>
                                                                        <th>Packing Des</th>
                                                                        <th>Carton No</th>
                                                                        <th>Carton No</th>
                                                                        <th>Carton No</th>
                                                                        <th>Carton No</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>0245</td>
                                                                        <td>Product Name</td>
                                                                        <td>Description</td>
                                                                        <td>11</td>
                                                                        <td>242</td>
                                                                        <td>300</td>
                                                                        <td>44</td>
                                                                        <td>222X222</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>0245</td>
                                                                        <td>Product Name</td>
                                                                        <td>Description</td>
                                                                        <td>11</td>
                                                                        <td>242</td>
                                                                        <td>300</td>
                                                                        <td>44</td>
                                                                        <td>222X222</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>0245</td>
                                                                        <td>Product Name</td>
                                                                        <td>Description</td>
                                                                        <td>11</td>
                                                                        <td>242</td>
                                                                        <td>300</td>
                                                                        <td>44</td>
                                                                        <td>222X222</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>0245</td>
                                                                        <td>Product Name</td>
                                                                        <td>Description</td>
                                                                        <td>11</td>
                                                                        <td>242</td>
                                                                        <td>300</td>
                                                                        <td>44</td>
                                                                        <td>222X222</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>0245</td>
                                                                        <td>Product Name</td>
                                                                        <td>Description</td>
                                                                        <td>11</td>
                                                                        <td>242</td>
                                                                        <td>300</td>
                                                                        <td>44</td>
                                                                        <td>222X222</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>0245</td>
                                                                        <td>Product Name</td>
                                                                        <td>Description</td>
                                                                        <td>11</td>
                                                                        <td>242</td>
                                                                        <td>300</td>
                                                                        <td>44</td>
                                                                        <td>222X222</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                        <td>555</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>

                                                        </div>

                                                    </div>
                                                    <div class="col-12">

                                                        <div class="row CoInvTotal">
                                                            <div class="col-md-3">
                                                                <label class="font12 mb-5">Total Quantity</label>
                                                                <input type="text" id="" class="form-control bor" value="158">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="font12 mb-5">Sub Total</label>
                                                                <input type="text" id="" class="form-control" value="28,580">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="font12 mb-5">Withholding Tax</label>
                                                                <input type="text" id="" class="form-control" value="28,580">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="font12 mb-5">Total Value</label>
                                                                <input type="text" id="" class="form-control" value="29,552">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>



                                                <div class="row m-0 PT-30">
                                                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                                                    <button type="submit" class="btn btn-primary mr-2">PDF</button>
                                                    <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-act-inv" role="tabpanel" aria-labelledby="v-act-inv-tab">
                                <div class="CB_info">Act ff

                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-06" role="tabpanel" aria-labelledby="v-pills-06-tab">
                                <div class="CB_info">
                                    <div id="floating-label" class="card top_border mb-3">
                                        <div class="col-md-12">
                                            <div class="form-wrap PT-10 PB-20">
                                                <div class="row">
                                                    <div class="col-md-12 pt-10 mb-0">
                                                        <h2 class="_head04">System <span> Generator</span></h2>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row m-0">
                                                            <div class="col-md-8 SysGenHead"><strong>Name</strong></div>
                                                            <div class="col-md-4 SysGenHead"><strong>Action</strong></div>
                                                        </div>
                                                        <div class="row SysGen-row">
                                                            <div class="col-md-8"><strong>Health Certificate</strong></div>
                                                            <div class="col-md-4">
                                                                <button class="btn smBTN btn-line mb-0" type="button" data-toggle="collapse" data-target="#editcolum" aria-expanded="false" aria-controls="editcolum">Edit</button>
                                                                <button class="btn smBTN mb-0">Preview</button>
                                                            </div>

                                                            <div class="col-12 collapse" id="editcolum">
                                                                <div class="row editcolumDiv">
                                                                    <div class="col">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" name="" class="custom-control-input" value="" id="00070">
                                                                            <label class="custom-control-label" for="00070">QTY. In CTNS</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" name="" class="custom-control-input" value="" id="00080">
                                                                            <label class="custom-control-label" for="00080">Product Name</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" name="" class="custom-control-input" value="" id="00090">
                                                                            <label class="custom-control-label" for="00090">Unit Price(US $)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" name="" class="custom-control-input" value="" id="00001">
                                                                            <label class="custom-control-label" for="00001">Amount(US $)</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row SysGen-row">
                                                            <div class="col-md-8"><strong>Certifcate of Conformity</strong></div>
                                                            <div class="col-md-4">
                                                                <button class="btn smBTN btn-line mb-0" type="button" data-toggle="collapse" data-target="#editcolum2" aria-expanded="false" aria-controls="editcolum">Edit</button>
                                                                <button class="btn smBTN mb-0">Preview</button>
                                                            </div>

                                                            <div class="col-12 collapse" id="editcolum2">
                                                                <div class="row editcolumDiv">
                                                                    <div class="col">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" name="" class="custom-control-input" value="" id="00070">
                                                                            <label class="custom-control-label" for="00070">QTY. In CTNS</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" name="" class="custom-control-input" value="" id="00080">
                                                                            <label class="custom-control-label" for="00080">Product Name</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" name="" class="custom-control-input" value="" id="00090">
                                                                            <label class="custom-control-label" for="00090">Unit Price(US $)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" name="" class="custom-control-input" value="" id="00001">
                                                                            <label class="custom-control-label" for="00001">Amount(US $)</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="row m-0 PT-15">
                                                    <button type="button" class="btn btn-primary mr-2">Save</button>
                                                    <button type="button" class="btn btn-cancel mr-2">Cancel</button>
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
    </div>
</div>
@endsection