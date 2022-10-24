@extends('layouts.master')
@section('data-sidebar')
<style>
    #product-cl-sec,
    #product-add {
        width: 930px
    }

    @media (max-width:800px) {

        #product-cl-sec,
        #product-add {
            width: 100%
        }
    }
</style>
<div id="product-cl-sec" class="width_950">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">Product <span> Cost</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" >
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist add_cost_div" style="display:none">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter pt-0">
                    <div class="se_cus-type p-20 mb-3">
                        <h2 class="_head04 border-0">Customer: <span id="pnl_cust_name"> </span></h2>
                        <div class="row _invNDV">
                            <div class="col-4"><strong>Invoice No: </strong><span id="pnl_invoice_num"> </span> </div>
                            <div class="col-4 text-center"><strong>Invoice Date: </strong><span id="pnl_invoice_date"> </span></div>
                            <div class="col-4 text-right"><strong>Invoice Value: </strong><span id="pnl_invoice_value"> </span></div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="card p-20 top_border mb-3">

                                    <div class="row _invNDV-g PB-20">
                                        <div class="col-6"><strong>Invoice Currency Type : </strong><span id="pnl_currency_type"> </span></div>
                                        <div class="col-6 text-right"><strong>Exchange Rate: </strong> <input type="number"
                                                class="Pro-COST exchange_rate" placeholder="0"> </div>
                                    </div>

                                    <h2 class="_head03 mb-20">Add <span>Cost</span></h2>

                                    <table class="table table-hover dt-responsive nowrap" id="example3"
                                        style="width:100% !important">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>QTY.</th>
                                                <th id="sell_unit_price_head">Sell Unit Price(US $)</th>
                                                <th>Price (PKR)</th>
                                                <th>Cost</th>
                                                <th>Profit/Loss</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body_invoice_items">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="_cl-bottom">
        <button type="button" class="btn btn-primary mr-2 open_modal_toAddCost">Add</button>
        <button type="button" class="btn btn-primary mr-2 open_modal" hidden data-toggle="modal"
            data-target=".bd-example-modal-lg">Add</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2 close_sideBar">Cancel</button>
    </div>
</div>
@endsection

@section('content')
{{-- Modal --}}



<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">PNL <span>Management</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>PNL</span></a></li>
            <li><span>Management</span></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="floating-label" class="card daily-operations">

            <ul class="nav nav-pills nav_M mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                        aria-controls="pills-home" aria-selected="true"><span>Product</span> Cost
                        <span class="wz-icon"><i class="fa fa-dollar-sign"></i></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                        aria-controls="pills-contact" aria-selected="false"><span>PNL</span> Detail
                        <span class="wz-icon"><i class="fa fa-list-ul"></i></span>
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane tab_M fade show active" id="pills-home" role="tabpanel"
                    aria-labelledby="pills-home-tab">

                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" id="pills-pending-tab" data-toggle="pill"
                                href="#pills-pending" role="tab" aria-controls="pills-pending"
                                aria-selected="true">Pending</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" id="pills-entered-tab" data-toggle="pill"
                                href="#pills-entered" role="tab" aria-controls="pills-entered"
                                aria-selected="false">Entered</a>
                        </li>
                    </ul>

                    <div class="tab-content p-0" id="pills-tabContent">

                        <div class="tab-pane fade show active" id="pills-pending" role="tabpanel"
                            aria-labelledby="pills-pending-tab">
                            <div class="col-md-12 p-0">
                                <img src="/images/loader.gif" class="pnl_loader" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                                <table class="table table-hover dt-responsive nowrap " id="example" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Invoice No</th>
                                            <th>Customer Name</th>
                                            <th>Invoice Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="body_pending_orders">
                                        {{-- @if(!empty($orders))
                                            @foreach ($orders as $invoice)
                                                <tr>
                                                    <td>{{$invoice->issue_date}}</td>
                                                    <td>{{$invoice->invoice_num}}</td>
                                                    <td>{{$invoice->customer_name}}</td>
                                                    <td>{{$invoice->current_status}}</td>
                                                    <td><button id="{{$invoice->id}}" class="btn btn-default mb-0" title="Delivery Challan">View
                                                            Invoice</button>
                                                        <button id="{{$invoice->id}}" class="btn btn-default mb-0 OpenSidebarforAddingCost"
                                                            title="Add Cost">Add
                                                            Cost</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-entered" role="tabpanel"
                            aria-labelledby="pills-entered-tab">
                            <div class="col-md-12 p-0">
                                <div class="col-md-12 p-0">
                                    <img src="/images/loader.gif" class="pnl_loader" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                                    <table class="table table-hover dt-responsive nowrap " id="example2"
                                        style="width:100% !important">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Invoice No</th>
                                                <th>Customer Name</th>
                                                <th>Invoice Status</th>
                                                <th>Cost</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="body_entered_orders">
                                            {{-- <tr>
                                                <td>07/09/2019</td>
                                                <td>02154</td>
                                                <td>Style Textile</td>
                                                <td>Status</td>
                                                <td>1,570</td>
                                                <td><a href="#" class="btn btn-default mb-0" title="View Invoice">View
                                                        Invoice</a>
                                                </td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="tab-pane tab_M fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

                    <div class="col-md-12">
                        <h3 class="_head03 mb-10">Sales <span>Detail</span></h3>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="st_boxgray">Total Invoices<span id="pnl_stat_ttlInv"></span> </div>
                            </div>
                            <div class="col-md-3">
                                <div class="st_boxgray">Total Revenue<span id="pnl_stat_ttlRev"></span> </div>
                            </div>
                            <div class="col-md-3">
                                <div class="st_boxgray">Total Cost<span id="pnl_stat_ttlCst"></span> </div>
                            </div>
                            <div class="col-md-3">
                                <div class="st_boxgray">Gross Profit<span id="pnl_stat_gProf"></span> </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">


                        <div class="st_boxgray _profitT">
                            <div class="row">
                                <div class="col-md-6"><img src="/images/total-profit.svg" alt="" /> </div>
                                <div class="col-md-6" id="pnl_stat_netProf"></div>

                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-md-12 text-center">
                    <button disabled type="button" class="btn btn-primary m-0 mr-2 previous_btn">Previous</button>
                    <button type="button" class="btn btn-primary m-0 next_btn">Next</button>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection
