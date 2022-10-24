@extends('layouts.master')
@section('content')
{{-- Modal --}}
<div class="modal fade price_quotations" id="price_quotations" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title _head03" ></h5>
                <div class="col-md-3 pr-0">
                    <div class="form-s2">
                        <select class="form-control formselect select_product_sample quotation_dropdown_product" id=""
                            placeholder="Select Supplier">
                            <option value="0" disabled selected>Select Product*</option>
                            @if (!empty($products))
                                @foreach ($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-3 pr-0">
                    <div class="form-s2">
                        <select class="form-control formselect select_item_sample quotation_dropdown_item" id=""
                            placeholder="Select Supplier">
                            <option value="0" disabled selected>Select Item*</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 pr-0">
                    <div class="form-s2">
                        <select class="form-control formselect select_customer_sample" id=""
                            placeholder="Select Supplier">
                            <option value="0" disabled selected>Select Customer*</option>
                            @if (!empty($customers))
                                @foreach ($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->company_name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-2 pr-0">
                    <button type="button" class="btn btn-primary add_sample_to_table" id="">Add</button>
                </div>
            </div>
            <div class="modal-body pt-5">
                <div id="floating-label" class="form-wrap pt-0 pb-0">
                    <div class="row">
                        <div class="col-md-12 productRate-table m-0">
                            <table class="table table-hover dt-responsive nowrap table-PL" style="width:100% !important">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Item</th>
                                        <th>Customer</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="sampleTableBody">
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-15 mb-10">
                            <div class="col-4">
                                <div class="assigned-to">
                                    <div class="col-12 font13 p-0">Delivery Date</div>
                                    <div class="col-auto p-0"> <img class="calendarIcon"
                                            src="/images/calendar-icon002.svg" alt="">
                                        <input class="assignedDate expected_delivery_date" type="text" id="edtDp" value="{{ date('Y-m-d') }}"
                                            style="font-size: 13px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="assigned-to">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Transaction Id*</label>
                                        <input type="text" name="transaction_id" class="form-control"placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="assigned-to">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Courier*</label>
                                        <input type="text" name="courier" class="form-control"placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="font12 mb-5">Remarks</label>
                            <div class="form-group">
                                <textarea name="description" id="sampleRemarks" rows="8"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-0 PT-10">
                    <button type="button" class="btn btn-primary save_sampling" id="">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Display Quotations --}}
<div class="modal fade display_quotations" id="display_quotations" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title _head03"> Price List</h5>
                </div>
            <div class="modal-body pt-5">
                <div id="floating-label" class="form-wrap pt-0 pb-0">
                    <div class="row">
                        <div class="col-md-12 productRate-table m-0">
                            <table class="table table-hover dt-responsive nowrap table-PL view_quote_table" style="width:100% !important">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Item</th>
                                        <th>Customer</th>
                                        <th>Price</th>
                                        
                                    </tr>
                                </thead>
                                <tbody class="show_sampleTableBody">
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="row mt-15 mb-10">
                            <div class="col-4">
                                <div class="assigned-to">
                                    <div class="col-12 font13 p-0">Delivery Date</div>
                                    <div class="col-auto p-0"> <img class="calendarIcon"
                                            src="/images/calendar-icon002.svg" alt="">
                                        <input class="assignedDate" disabled type="text" id="exp_DD" value=""
                                            style="font-size: 13px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="assigned-to">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Transaction Id*</label>
                                        <input type="text" id="show_transaction_id" readonly class="form-control"placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="assigned-to">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Courier*</label>
                                        <input type="text" id="show_courier" readonly class="form-control"placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="font12 mb-5">Remarks</label>
                            <div class="form-group">
                                <textarea name="description" readonly id="show_sample" rows="8"></textarea>
                            </div>
                        </div> --}}
                    </div>
                    <img src="/images/loader.gif" width="30px" height="auto" class="show_sample_loader"
                            style="position: absolute; left: 50%; top: 45%; display:none">
                </div>
                <div class="modal-footer p-0 PT-10">
                    <a class="btn btn-primary export_as_excel" id="">Export</a>
                </div>
            </div>
            
        </div>
    </div>
</div>



<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Price <span>Quotation</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Price Quotation</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a class="btn add_button add_quote_btn" data-toggle="modal" data-target=".price_quotations"><i class="fa fa-plus"></i> Add Quotation</a>
                <h2>Quotations List</h2>
            </div>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto"
                    style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body" style="display: none">
            </div>
        </div>
    </div>
</div>
@endsection
