@extends('layouts.master')
@section('data-sidebar')
<style>
    #performaPreferences {
        z-index: 1000;
    }

</style>
{{-- <div id="performaPreferences">
    <a class="close-sidebar" class="close-btn-pl"></a>
    <div class="pro-header-text ml-0" id="performaPreferencesHeading">CBM <span>Calculation</span></div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter pt-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 _ord-rightside">
                                <div class="form-wrap pt-0 pb-0" id="shipmentCalculation">
                                    <div class="card p-20 top_border mb-3">
                                        <div class="row">
                                            <div class="col-md-12 PT-10">
                                                <label class="control-label">Additional Weight / Carton (KG)</label>
                                                <input type="text" value="{{ $orderInfo['additional_weight'] }}"
style="font-size: 13px" name="additional_weight_ctn">
</div>
<div class="col-md-6 PT-10">
    <div class="form-group">
        <label class="control-label">Net Weight</label>
        <input readonly type="text" value="{{ $orderInfo['net_weight'] }}" name="net_weight" placeholder="0"
            style="font-size: 13px">
    </div>
</div>
<div class="col-md-6 PT-10">
    <div class="form-group">
        <label class="control-label">Actual Net Weight</label>
        <input type="text" value="{{ $orderInfo['actual_weight'] }}" name="actual_net_weight" placeholder="0"
            style="font-size: 13px">
    </div>
</div>
<div class="col-md-12 PT-10">
    <div class="form-group">
        <label class="control-label">Total CBM Value</label>
        <input type="text" readonly value="{{ $orderInfo['total_cbm'] }}" name="total_cbm_value_shipment_calculation"
            style="font-size: 13px">
    </div>
</div>
<div class="col-12">
    <ul class="nav nav-pills float-left" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pill-20-tab" data-toggle="pill" href="#pill-20" role="tab"
                aria-controls="pill-20" aria-selected="true">20 FT</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-40-tab" data-toggle="pill" href="#pills-40" role="tab"
                aria-controls="pills-40" aria-selected="false">40 FT</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-hc-tab" data-toggle="pill" href="#pills-hc" role="tab"
                aria-controls="pills-hc" aria-selected="false">40 FT HC</a>
        </li>
    </ul>
</div>
<div class="col-12">
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pill-20" role="tabpanel" aria-labelledby="pill-20-tab">
            <div class="contDiv">
                <div class="contProgress" style="width: 0%"></div>
                <div class="ProgNO"></div>
            </div>
            <div id="extra20Ft">
            </div>
        </div>
        <div class="tab-pane fade" id="pills-40" role="tabpanel" aria-labelledby="pills-40-tab">
            <div class="contDiv">
                <div class="contProgress" style="width: 0%"></div>
                <div class="ProgNO"></div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-hc" role="tabpanel" aria-labelledby="pills-hc-tab">
            <div class="contDiv">
                <div class="contProgress" style="width: 0%"></div>
                <div class="ProgNO"></div>
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
</div>
<div class="_cl-bottom">
    <button id="pl-close2" type="button" class="btn btn-cancel m-0 mr-2 closeProductAddSidebar">Cancel</button>
    <button type="button" class="saveCbmCalcOnly btn btn-primary m-0">Save</button>
</div>
</div> --}}
<div id="product-cl-sec" class="width_950">
    <div class="RB_bar"> <a id="productlist01" class="open-Report"><i style="cursor: pointer"
                class="fa fa-arrow-left"></i></a>
        <h1 class="R-Heading">Activity</h1>
    </div>
    <a href="#" id="pl-close" style="cursor: pointer" class="close-btn-pl"></a>
    <div class="pc-cartlist pb-0">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter pt-0">
                    <div class="container">
                        <div class="FU-history">
                            <ul class="Act-timeline" style="margin-left: 150px !important">
                                @foreach ($activity as $item)
                                <li>
                                    <div class="dateFollowUP">{{ date('d/m/Y', strtotime($item['at'])) }}</div>
                                    <div class="timeline-icon"><img
                                            src="{{ $item['picture'] ? str_replace('./', '/', $item['picture']) : '/images/avatar.svg' }}"
                                            alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{ $item['employee'] }}</h4>
                                        @if ($item['activity_type'] == 'assignment' || $item['activity_type'] ==
                                        'reassignment')
                                        <div class="historyDiv">
                                            <h5><span
                                                    class="blue-text">{{ $item['activity_type'] == 'assignment' ? "Assign" : "Reassign" }}
                                                    to Supplier:</span>
                                                {{ $item['activity_type'] == 'assignment' ? $item['data']['supplier'] : $item['data']['before_updated']['new_supplier_id'] }}
                                            </h5>
                                            <p><strong>EDT:</strong>
                                                {{ $item['activity_type'] == 'assignment' ? date('d/m/Y', strtotime($item['data']['edt'])) : date('d/m/Y', strtotime($item['data']['before_updated']['new_edt'])) }}
                                            </p>
                                            <p class="pt-5"><strong>User Remarks</strong></p>
                                            <p>{{ $item['activity_type'] == 'assignment' ? $item['data']['remarks'] : $item['data']['before_updated']['new_remarks'] }}
                                                <p>
                                        </div>
                                        @elseif($item['activity_type'] == 'production' || $item['activity_type'] ==
                                        'delay' || $item['activity_type'] == 'completed')
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span>
                                                {{ $item['activity_type'] == 'production' ? 'Add Production' : ( $item['activity_type'] == 'delay' ? 'Report Delay' : 'Mark Complete' ) }}
                                            </h5>
                                            @if ($item['activity_type'] == 'delay')
                                            <p><strong>New EDT:</strong>
                                                {{ date('d/m/Y', strtotime($item['new_edt'])) }}</p>
                                            @endif
                                            @if ($item['activity_type'] !== 'completed')
                                            <p class="pt-5">
                                                <strong>{{ $item['activity_type'] == 'production' ? 'User Remarks' : 'Reason' }}</strong>
                                            </p>
                                            @endif
                                            <p>
                                                {{ $item['activity_type'] == 'completed' ? 'Order Complete' : ( $item['activity_type'] == 'delay' ? $item['new_reason'] : $item['data']['remarks'] ) }}
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                </li>
                                @endforeach
                                <li>
                                    <div class="dateFollowUP">{{ date('d/m/Y', strtotime($orderInfo['created_at'])) }}
                                    </div>
                                    <div class="timeline-icon"><img
                                            src="{{ $orderInfo['picture'] ? str_replace('./', '/', $orderInfo['picture']) : '/images/avatar.svg' }}"
                                            alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{ $orderInfo['employee'] }}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Order Create For:</span>
                                                {{ $orderInfo['customer_name'] }}
                                            </h5>
                                            <div class="row pt-5">
                                                <div class="col"><strong>Product:</strong>
                                                    {{ sizeof($orderInfo['contents']) }}</div>
                                                <div class="col text-center"><strong>QTY:</strong>
                                                    {{ array_sum(array_column($orderInfo['contents'], 'qty')) }}CTNS
                                                </div>
                                                <div class="col text-right"><strong>Order Type:</strong>
                                                    {{ $orderInfo['order_type'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<style>
    .close-btn-pl {
        top: 0px;
        right: 0px;
        background-color: #040725
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
        letter-spacing: 15px;
        padding-left: 10px;
        line-height: 1
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
        background: linear-gradient(90deg, #040725 0%, #040725 100%);
        position: absolute
    }

</style>
<div class="row">
    <div class="col-4 profile-left">
        <div class="CT_sec p-0 m-0">
            <div class="orderTop">
                <h2>Order <span>Details</span></h2>
                <div class="order_status">Status: <span class="In-Process">In Process</span></div>
                <div class="Order-Cust-detail">
                    <div class="row">
                        <div class="col-8 pr-5"><strong>Client info:</strong> {{ $customer['company_name'] }}</div>
                        <div class="col-4 text-right pl-5"><strong>Date:</strong>
                            {{ date('Y-m-d', strtotime($orderInfo['created_at'])) }}</div>
                        <div class="col-8"><strong>POC:</strong>
                            {{ $customer['first_name'].' '.$customer['last_name'] }} </div>
                        <div class="col-4 text-right"><strong>PO No:</strong> {{ $orderInfo['po_num'] }}</div>
                        <div class="col-6"><strong>Location:</strong> {{ $customer['city'] }},
                            {{ $customer['country'] }}</div>
                        <div class="col-6 text-right"><strong>Invoice No:</strong> {{ $orderInfo['invoice_num'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="left_Info">
            @foreach ($orderInfo['contents'] as $key => $item)
            <div class="Order-PL {{ $key % 2 == 0 ? '' : 'OrderCBG' }}">
                <div class="row">
                    <div class="col-auto pr-10"><img class="OP-imag" src="{{ $item['thumbnail'] }}" alt="" /></div>
                    <div class="col pl-0">
                        <h4 class="opName">{{ $item['product_name'] }}</h4>
                        @if (!$item['assigned_qty'] || $item['assigned_qty'] <= 0) <div class="ProductStatus">
                            Un-Assigned
                    </div>
                    @endif
                    @if ($item['assigned_qty'] && $item['assigned_qty'] > 0 && $item['assigned_qty'] < $item['qty'])
                        <div class="ProductStatus _PartiallyBG">Partially Assigned
                </div>
                @endif
                @if ($item['assigned_qty'] == $item['qty'] && $item['assigned_qty'] ==
                $item['production'])
                <div class="ProductStatus _InProductionBG">Completed</div>
                @elseif ($item['assigned_qty'] == $item['qty'])
                <div class="ProductStatus _InProductionBG">In Production</div>
                @endif
                <span><strong>Item:</strong> {{ $item['item_name'] }}</span>
                <div class="row OP-QP">
                    <div class="col"><strong>QTY.:</strong> {{ $item['qty'] }}</div>
                    <div class="col pl-5"><strong>U.Price:</strong> {{ $item['unit_price'] }} </div>
                    <div class="col pl-5 text-right">
                        <strong>Total Price:</strong>
                        {{ number_format($item['amount']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 p-0 pt-10">
            <div class="row">
                <div class="col"><strong>Production Status</strong></div>
                <div class="col text-right blue-text"><strong>{{ $item['production'] }} CTNS/{{ $item['qty'] }}
                        CTNS</strong>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar"
                    style="width: {{ ROUND((($item['production']/$item['qty'])*100)) }}%;"
                    aria-valuenow="{{ ROUND((($item['production']/$item['qty'])*100)) }}" aria-valuemin="0"
                    aria-valuemax="100">
                    {{ ROUND((($item['production']/$item['qty'])*100)) }}%</div>
            </div>
        </div>
        <div class="col-12 p-0 pt-10">
            @if ($item['dispatched'] && $item['dispatched'] > 0)
            <div class="row">
                <div class="col"><strong>Dispatch Status</strong></div>
                <div class="col text-right blue-text"><strong>{{ $item['dispatched'] }} CTNS/{{ $item['qty'] }}
                        CTNS</strong>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar"
                    style="width: {{ ROUND((($item['dispatched']/$item['qty'])*100)) }}%;"
                    aria-valuenow="{{ ROUND((($item['dispatched']/$item['qty'])*100)) }}" aria-valuemin="0"
                    aria-valuemax="100">
                    {{ ROUND((($item['dispatched']/$item['qty'])*100)) }}%</div>
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
</div>
<div class="col-8 profile-center">
    <div class="col-lg-12 _activityMD">
        <div class="_activityHead">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" id="pills-activity-tab" data-toggle="pill"
                        href="#pills-activity" role="tab" aria-controls="pills-activity"
                        aria-selected="true">Supplier</a>
                </li>
                <li class="nav-item"> <a class="nav-link" id="pills-notes-tab" data-toggle="pill" href="#pills-notes"
                        role="tab" aria-controls="pills-notes" aria-selected="false">Shipping
                        Detail</a> </li>
                <li class="nav-item"> <a class="nav-link" id="pills-task-tab" data-toggle="pill" href="#pills-task"
                        role="tab" aria-controls="pills-task" aria-selected="false">Documents</a> </li>
                <li class="nav-item"> <a class="nav-link" id="pills-other-tab" data-toggle="pill" href="#pills-other"
                        role="tab" aria-controls="pills-other" aria-selected="false">Other</a> </li>
            </ul>
        </div>
        <div>
            <div class="tab-content PC-Tab pt-0" id="pills-tabContent" style="margin-bottom: 100px">
                <div class="tab-pane fade show active" id="pills-activity" role="tabpanel"
                    aria-labelledby="pills-activity-tab">

                    @if(sizeof($assignments))
                    <div class="col-md-12 text-right">
                        <a class="btn btn-primary AddSupp peventsDisabled"><i class="fa fa-plus"></i>
                            <span> Assign Supplier </span></a>
                    </div>
                    @else
                    <a class="AssSupplier peventsDisabled">
                        <img src="/images/assign-supplier-icon.svg" alt="" />
                        <span><i class="fa fa-plus"></i> Assign
                            Supplier
                        </span> </a>
                    @endif
                    @foreach ($assignments as $key => $item)
                    <div class="Activity-card _supplierCard assignment-{{ $item['batch'] }} {{ $key > 0 ? 'mt-20' : '' }}"
                        style="margin-right:10px !important;">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 _supName"><strong>{{ $item['supplier'] }}</strong>
                                        <div class="float-right font13">Status: <span
                                                class="In-Process">{{ $item['items'][0]['production_completed'] ? 'Completed' : 'In Process' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 pr-0 PT-10">
                                        <div class="row">
                                            <div class="col pt-5 pr-0 font12"><strong>Assign Date:</strong>
                                                {{ date('d/m/Y', strtotime($item['created_at'])) }}</div>
                                            <div class="col pt-5 pr-0 font12"><strong>EDT:</strong>
                                                {{ date('d/m/Y', strtotime($item['expected_delivery_date'])) }}
                                            </div>
                                            <div class="col pt-5 pr-0 font12"><strong>Follow Up Date:</strong>
                                                {{ date('d/m/Y', strtotime($item['follow_up_date'])) }}</div>
                                            <div class="col-4 pl-0 text-right">
                                                <button class="btn btn-primary _blueBTN viewOrderSheet"
                                                    batch-code="{{ $item['batch'] }}" data-toggle="modal"
                                                    data-target=".orderSheetModal" assignment-id="{{ $item['id'] }}"
                                                    id="{{ $orderInfo['id'] }}" type="button">Order
                                                    Sheet</button>
                                                @if ($item['production_quantity'] > 0 && $item['production_quantity'] !=
                                                $item['dispatched_quantity'])
                                                {{-- <a href="/Dispatch/{{ $orderInfo['id'] }}/{{ $item['batch'] }}/{{ $item['dispatch_in_progress'] }}"
                                                target="_blank" class="btn btn-primary _blueBTN">Dispatch</a> --}}
                                                @endif
                                                {{-- @if (!$item['items'][0]['production_completed']) --}}
                                                <div class="btn-group _more-action">
                                                    <button class="btn btn-sm dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"> More Actions </button>
                                                    <div class="dropdown-menu dropdown-menu-right"> <a
                                                            class="dropdown-item peventsDisabled reassignment"
                                                            batch-code="{{ $item['batch'] }}" data-toggle="modal"
                                                            data-target=".assignSupplierModal">Reassign</a> <a
                                                            class="dropdown-item peventsDisabled followUpBtnModalOpener"
                                                            data-toggle="modal" batch-code="{{ $item['batch'] }}"
                                                            data-target=".followModal">Follow
                                                            Up</a> <a class="dropdown-item deleteSuppAssignmentModal"
                                                            data-toggle="modal"
                                                            data-target="#deleteSuppAssignmentReasonModal"
                                                            batch-code="{{ $item['batch'] }}">Delete</a> </div>
                                                </div>
                                                {{-- @endif --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row task-detail" style="margin: 20px -15px 0px -15px; display: block">
                            <div class="col-md-12 p-0"> <a class="taskDetailL" data-toggle="collapse"
                                    href="#collapseExample{{ $key }}" role="button" aria-expanded="false"
                                    aria-controls="collapseExample{{ $key }}"><i class="fa fa-angle-down"></i> View
                                    Detail</a>
                                <div class="collapse" id="collapseExample{{ $key }}">
                                    <div class="col-md-12 p-0 productRate-table overflowYV m-0 mt-10">
                                        <table class="table table-hover dt-responsive nowrap table-PL"
                                            style="width:100% !important">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Item Name</th>
                                                    <th>QTY.</th>
                                                    <th>Assigned QTY.</th>
                                                    <th>Produced QTY.</th>
                                                    <th>Dispatched QTY.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($item['items'] as $content)
                                                <tr>
                                                    <td>{{ $content['product'] }}</td>
                                                    <td>{{ $content['item'] }}</td>
                                                    <td>{{ $content['total_qty'] }}</td>
                                                    <td>{{ $content['assigned_qty'] }}</td>
                                                    <td>{{ $content['production_quantity'] }}</td>
                                                    <td>{{ $content['dispatched_quantity'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="pills-notes" role="tabpanel" aria-labelledby="pills-notes-tab">
                    <div class="Activity-card _supplierCard">
                        <div id="floating-label">
                            @if ($orderInfo['order_type'] !== 'FOB')
                            <div class="form-wrap pt-0 pb-0">
                                <div class="row">
                                    <div class="col-md-6 mb-20">
                                        <label class="font12 mb-5">Country Of Origin</label>
                                        <div class="form-s2">
                                            <select class="form-control formselect" name="country_of_origin"
                                                placeholder="Select Payment Type" style="width: 100%">
                                                <option selected>Pakistan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label class="font12 mb-5">Expected Delivery Date</label>
                                        <div class="form-group" style="height: auto !important">
                                            <input type="text" value="{{ $orderInfo['expected_delivery_date'] }}"
                                                class="form-control detailsEdt">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-20">
                                        <label class="font12 mb-5">Port of Loading</label>
                                        <div class="form-s2">
                                            <select class="form-control formselect" placeholder="Select Payment Type"
                                                style="width: 100%" id="portOfLoading">
                                                <option disabled selected>Select Port of Loading</option>
                                                @foreach ($ports as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $orderInfo['port_of_loading'] == $item->id ? "selected": "" }}>
                                                    {{ $item->port_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-20">
                                        <label class="font12 mb-5">Port of Discharge</label>
                                        <div class="form-s2">
                                            <select class="form-control formselect" placeholder="Select Payment Type"
                                                style="width: 100%" id="portOfDisch">
                                                <option disabled selected>Select Port of Discharge</option>
                                                @foreach ($ports as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $orderInfo['port_of_discharge'] == $item->id ? "selected": "" }}>
                                                    {{ $item->port_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label class="font12 mb-5">Mode of Shipment</label>
                                        <div class="form-s2">
                                            <select class="form-control formselect" placeholder="Select Payment Type"
                                                style="width: 100%" id="modeOfShipment">
                                                <option disabled selected>Select Mode of Shipment</option>
                                                <option value="Sea"
                                                    {{ $orderInfo['mode_of_shipment'] == "Sea" ? "selected" : "" }}>
                                                    By Sea</option>
                                                <option value="Land"
                                                    {{ $orderInfo['mode_of_shipment'] == "Land" ? "selected" : "" }}>
                                                    By Land</option>
                                                <option value="Air"
                                                    {{ $orderInfo['mode_of_shipment'] == "Air" ? "selected" : "" }}>
                                                    By Air</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label class="font12 mb-5">Select Route</label>
                                        <div class="form-s2">
                                            <select class="form-control sd-type" multiple="multiple" style="width: 100%"
                                                id="shipping_route">
                                                @foreach ($ports as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ in_array($item->id, $orderInfo["shipment_route"]) ? "selected" : "" }}>
                                                    {{ $item->port_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label class="font12 mb-5">Shipped Via</label>
                                        <div class="form-s2">
                                            <select class="form-control formselect" placeholder="Select Payment Type"
                                                style="width: 100%" id="shippedVia">
                                                <option disabled selected>Select Company Name</option>
                                                @foreach ($shipping_companies as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $orderInfo["shipment_company"] == $item->id ? "selected": "" }}>
                                                    {{ $item->company_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mt-5">
                                            <label class="control-label mb-10">Freight
                                                Charges</label>
                                            <input type="text" value="{{ $orderInfo['quoted_freight_charges'] }}"
                                                id="quoted_freight_charges" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 p-0">
                                <button href="#" class="btn btn-primary"
                                    id="saveShipmentInfoFromDetailsPage">Save</button>
                            </div>
                            @else
                            FOB orders do not require additional shipping information
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-task" role="tabpanel" aria-labelledby="pills-task-tab">
                    <div class="Activity-card _supplierCard">
                        <span id="noDocsAttached" style="display: none">No documents attached</span>
                        <select class="form-control" placeholder="select document" style="width: 100%; display: none"
                            id="all_documents">
                            <option disabled selected>Select Document
                            </option>
                            <option value="Certificate of Origin">Certificate of Origin
                            </option>
                            <option value="External Health Certificate">External Health
                                Certificate</option>
                            <option value="Product Specification Documents">Product
                                Specification Documents</option>
                            <option value="Sanitary Certificate">Sanitary Certificate
                            </option>
                            <option value="PCSIR">PCSIR</option>
                            <option value="Phytosanitry">Phytosanitry</option>
                            <option value="Form A">Form A</option>
                            <option value="GD">GD</option>
                            <option value="Milk Certificate">Milk Certificate</option>
                            <option value="Health Certificat">Health Certificate Govt
                                Issued
                            </option>
                        </select>
                        <div id="allDocsContainer"></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-other" role="tabpanel" aria-labelledby="pills-other-tab">
                    <a id="cbmCalculation" class="AssSupplier OtherAction">
                        <img src="/images/cbm-calcu-icon.svg" alt="" /><span>CBM Calculation </span>
                    </a>
                    <a class="AssSupplier OtherAction">
                        <img src="/images/payment-setting-icon.svg" alt="" /><span>Payment
                            Settings</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="Action_bottom OR-PB">
    <div class="container-fuild p-0">
        <div class="row">
            <div class="col-6 OrderValue">Total Order Value: <span class="blue-text">
                    {{ number_format($orderInfo['total_amount']-$orderInfo['discount_value']) }}</span>
                {{-- <div class="displayB">Days: <span class="blue-text"> 45 </span> </div> --}}
            </div>
            <div class="col-6 text-right pt-19">
                <a class="btn btn-primary mr-2 peventsDisabled"
                    style="color: white !important; line-height: 1; opacity: 0.7" id="markCompleteBtn">Process</a>
                <a href="/Dispatch/{{ Request::segment(2) }}/{{ $dispatchInProgress }}"
                    class="btn btn-primary mr-2 peventsDisabled" id="dispatchBtn"
                    style="line-height: 1; opacity: 0.7">Dispatch</a>
                <a class="btn btn-primary mr-2" href="/Orders/{{ Request::segment(2) }}/edit" target="_blank"> Edit
                    Order</a> <a href="/OrderManagement" class="btn btn-primary btn-cancel">Cancel</a> </div>
        </div>
    </div>
</div>
@endsection
