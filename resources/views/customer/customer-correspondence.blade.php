@extends('layouts.master')
@section('data-sidebar')
<style>
    #mCSB_3_container {
        min-height: 400px;
    }

    .close-btn-pl {
        top: 10px;
        right: 10px;
        background-color: #040725
    }

    .close-btn-pl:after,
    .close-btn-pl:before {
        background-color: #fff;
        height: 20px;
        top: 5px
    }

    #product-cl-sec {
        right: -890px;
        opacity: 1;
        box-shadow: 0 1px 5px 0 rgba(45, 62, 80, .12);
        width: 930px
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

    mark {
        background: yellow;
        color: black;
        padding: 0px !important
    }

    .modalWindow {
        width: 800px
    }

    .modalExpand {
        width: 70%
    }

    .samplePRlist {
        max-height: 220px;
        width: 100%;
        overflow-y: scroll;
        padding-right: 15px;
        margin-bottom: 15px
    }

    .samplePRlist .alert-color {
        padding: 3px 0px;
        font-size: 12px;
        margin: 7px 0px
    }

    .samplePRlist .alert-color:HOVER {
        color: #fff;
        background-color: #040725
    }

    .samplePRlist .alert-color:HOVER .alert_close {
        color: #fff;
        opacity: 1
    }

    .alert_close {
        top: 1px;
        right: 5px
    }

    .samplePRlist .alert-color .col-md-6 {
        padding-left: 10px;
        padding-right: 10px
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
        background: linear-gradient(90deg, #1e54d3 0%, #040725 100%);
        border-color: #040725;
        color: #fff;
    }

    .holder>li[data-page]:hover {
        cursor: pointer;
    }

</style>
{{-- Reports Sidebar --}}
<div id="product-cl-sec" class="width_950">
    <div class="RB_bar"> <a id="productlist01" class="open-Report open_report_bar"><i style="cursor: pointer"
                class="fa fa-arrow-left"></i></a>
        <h1 class="R-Heading">Reports</h1>
    </div>
    <div class="pc-cartlist pb-0">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter _reportSide">
                    <div class="_report-DIV">
                        <div class="_report-Head">
                            <div class="row m-0">
                                <div class="col-12">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item"> <a class="nav-link active" id="pills-home-tab"
                                                data-toggle="pill" href="#pills-home" role="tab"
                                                aria-controls="pills-home" aria-selected="true">Sales</a>
                                        </li>
                                        <li class="nav-item"> <a class="nav-link" id="pills-contact-tab"
                                                data-toggle="pill" href="#pills-contact" role="tab"
                                                aria-controls="pills-contact" aria-selected="false">Products</a> </li>
                                    </ul>
                                    <a class="report-filters" href="#" id="dropdownMenuButtonReportFilters"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                            src="/images/report-filters.svg" alt="" /></a>
                                    <div class="_more-action">
                                        <div class="dropdown">
                                            <form class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="dropdownMenuButtonReportFilters">
                                                <div class="col-12">
                                                    <select class="custom-select" id="reporting_filter">
                                                        <option value="1" selected>Overall</option>
                                                        <option value="2">Current Month</option>
                                                        <option value="3">Last Month</option>
                                                        <option value="4">Custom</option>
                                                    </select>
                                                </div>
                                                <div class="row m-0 mt-15 selectCustom_date_div" style="display:none">
                                                    <div class="col-12">
                                                        <h3 class="p-0 border-0">Select Date</h3>
                                                    </div>
                                                    <div class="col-6 pr-5">
                                                        <input type="text" class="form-control daterangeDp start_date"
                                                            placeholder="" style="font-size: 13px">
                                                    </div>
                                                    <div class="col-6 pl-5">
                                                        <input type="text" class="form-control daterangeDp end_date"
                                                            placeholder="" style="font-size: 13px">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="report-state">
                            <div class="col-12">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab">
                                        <h2 class="_head01">Overall <span>Revenue</span></h2>
                                        <div class="row mb-10">
                                            <div class="col-12">
                                                <div class="card card-report rav-bg">
                                                    <h4>Total <span>Revenue</span></h4>
                                                    <h2 class="digit Rev-pos total_revenue_report">Loading... </h2>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="card card-report CH50">
                                                            <h4>Current <span>Month</span></h4>
                                                            <h2 class="digit current_month_rev_report">Loading... </h2>
                                                            <img class="gra-icon" src="/images/gra-month-icon.svg"
                                                                alt="" />
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="card card-report CH50">
                                                            <h4>Avg. <span>Rev/Quarter</span></h4>
                                                            <h2 class="digit avg_rev_quarter_report">Loading... </h2>
                                                            <img class="gra-icon" src="/images/quarter-icon.svg"
                                                                alt="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h2 class="_head01">Payments History <span></span></h2>
                                        <div class="row m-0">
                                            <div class="col p-0">
                                                <div class="card card-report CH50 bottomBG bg-states">
                                                    <h4 class="font16">Total<span> Outstanding Payment</span></h4>
                                                    <h2 class="digit outstanding_payment_report">Loading... </h2>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card card-report CH50 bottomBB bg-states"
                                                    style="background-position:bottom center">
                                                    <h4 class="font16">AVG <span> Payment Days</span></h4>
                                                    <h2 class="digit avg_payment_day_report">Loading... </h2>
                                                </div>
                                            </div>
                                            <div class="col p-0">
                                                <div class="card card-report CH50 bottomBGR bg-states"
                                                    style="background-position:top right">
                                                    <h4 class="font16">Last <span> Payment Received</span></h4>
                                                    <span class="dateLPR last_payment_date_report">Loading...</span>
                                                    <h2 class="digit last_payment_report">Loading... </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-10">
                                            <div class="col-6">
                                                <div class="card card-report">
                                                    <h4>Payment <span>Mode</span></h4>
                                                    <div class="PaymentMode-graph">
                                                        <canvas id="PaymentMode"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="card card-report">
                                                    <h4>Invoices<span></span></h4>
                                                    <h2 class="digit text-right total_payments_report"
                                                        style="right: 20px"><span class="TI-head">Total:</span><br>
                                                        --- </h2>
                                                    <div>
                                                        <div id="chart">
                                                            <canvas id="invoicechart"></canvas>
                                                        </div>
                                                        <div id="legend"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h2 class="_head01">Order History <span></span></h2>
                                        <div class="row m-0">
                                            <div class="col p-0">
                                                <div class="card card-report CH50 bottomBB bg-states">
                                                    <h4 class="font16">Total<span> Orders</span></h4>
                                                    <h2 class="digit total_orders_report">Loading... </h2>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card card-report CH50 bottomBG bg-states"
                                                    style="background-position:bottom center">
                                                    <h4 class="font16">Complete <span> Orders</span></h4>
                                                    <h2 class="digit completed_orders_report">Loading... </h2>
                                                </div>
                                            </div>
                                            <div class="col p-0">
                                                <div class="card card-report CH50 bottomBO bg-states"
                                                    style="background-position:top right">
                                                    <h4 class="font16">Pending <span> Orders</span></h4>
                                                    <h2 class="digit pending_orders_report">Loading... </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col p-0">
                                                <div class="card card-report CH50">
                                                    <h4 class="font16">Avg. <span> Orders Value</span></h4>
                                                    <h2 class="digit avg_order_val_report">Loading... </h2>
                                                    <img class="gra-icon" src="/images/ord-ord-value-icon.svg" alt="">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card card-report CH50">
                                                    <h4 class="font16">AVG.<span> Products/Orders</span></h4>
                                                    <h2 class="digit avg_pro_order_report">Loading... </h2>
                                                    <img class="gra-icon" src="/images/ord-products-ord-icon.svg"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col p-0">
                                                <div class="card card-report CH50">
                                                    <h4 class="font16">AVG.<span> QTY./Orders</span></h4>
                                                    <h2 class="digit avg_qty_order_report">Loading... </h2>
                                                    <img class="gra-icon" src="/images/ord-qty-ord-icon.svg" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col p-0">
                                                <div class="card card-report CH50">
                                                    <h4 class="font16">Current<span> Month Orders</span></h4>
                                                    <h2 class="digit current_month_orders_report">Loading... </h2>
                                                    <img class="gra-icon" src="/images/ord-month-ord-icon.svg" alt="">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card card-report CH50">
                                                    <h4 class="font16">Dispatch<span> Orders</span></h4>
                                                    <h2 class="digit dispatched_orders_report">Loading... </h2>
                                                    <img class="gra-icon" src="/images/ord-dispatch-ord-icon.svg"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col p-0">
                                                <div class="card card-report CH50">
                                                    <h4 class="font16">Avg. <span> Fulfillment Times</span></h4>
                                                    <h2 class="digit avg_fulfiltime_order_report">Loading... </h2>
                                                    <img class="gra-icon" src="/images/ord-ord-fullfill-icon.svg"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                        aria-labelledby="pills-contact-tab">
                                        <h2 class="_head01">Product <span>Wise </span></h2>
                                        <div id="e_chart_1" class="e_chart"></div>


                                        <h2 class="_head01">Service <span>Wise </span></h2>
                                        <canvas id="myChart" class="CategoryChart"></canvas>
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
@section('content')
<div id="blureEffct" class="container-fluid profile_LeftPadd">

    <div id="taskWindow" class="modalWindow h-auto">
        <div class="_MW-content">
            <form id="saveTaskForm" enctype="multipart/form-data">
                @csrf
                <h1 class="modalWindowTitle">Task <a class="modalWindow-act closeWindow"><img
                            src="/images/close-icon.svg" alt="" /></a> <a class="modalWindow-act modalExpand-btn"
                        href="#"><i class="fa fa-expand"></i></a></h1>
                <div class="_MW-mid-content">
                    <div class="row task-assign-date border-bP-5">
                        <div class="assigned-to w-auto">
                            <div class="col-12 p-0 text-gray mb-5">Due Date:</div>
                            <div class="col-auto l-height p-0">
                                <img class="calendarIcon" src="/images/calendar-icon002.svg" alt="">
                                <input class="assignedDate datepickerCorrespondence" id="dueDateDp" type="text"
                                    value="10/10/2019" style="font-size: 13px; padding: 0;">
                            </div>
                        </div>
                        <div class="assigned-to w-auto">
                            <div class="col-12 p-0 text-gray mb-5">Time:</div>
                            <div class="col-auto l-height p-0">
                                <img class="calendarIcon float-left" src="/images/time-icon.svg" alt="">
                                <div class="form-s2 date-List H-arrow">
                                    <select class="form-control formselect" id="dueTimeDD"
                                        style="width: 100px!important">
                                        {!! $time_options !!}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="assigned-to w-auto pl-0">
                            <div class="col-12 p-0 text-gray">Priority:</div>
                            <div class="col-12 p-0">
                                <div class="flag-iconP"><span class="fa fa-flag"></span> </div>
                                <div class="float-left TaskStAction PriorityFlag">
                                    <select id="taskPriorityCorrespondence" class="custom-select SP_flag">
                                        <option value="critical" selected>Critical</option>
                                        <option value="high">High</option>
                                        <option value="medium">Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col TaskTitle pl-0"><input type="text" id="taskTitle" class="form-control"
                            placeholder="Task Title*">
                    </div>
                    <textarea class="FW-textareaTask" id="momTask" name="Note" placeholder="Notes*"></textarea>
                    <div class="col-12 p-0">
                        <a class="attchFiles-act multi_attachments" type="voice"><img src="/images/audio-attach.svg"
                                alt=""> Upload Voice Note</a>
                        <input type="file" class="upload_voice_notes" name="voice_note[]" accept=".mp3" multiple
                            style="display:none" />
                        <a class="attchFiles-act multi_attachments" type="doc"><img src="/images/documents-attach.svg"
                                alt=""> Upload Documents</a>
                        <input type="file" name="multiple_documents[]" class="upload_documents" multiple
                            style="display:none" />
                        <a class="attchFiles-act multi_attachments" type="image"><img src="/images/pictures-attach.svg"
                                alt=""> Upload Images</a>
                        <input type="file" name="multiple_images[]" class="upload_images" multiple accept="image/*"
                            style="display:none" />
                    </div>
                    <!--div show when attach file-->
                    <div class="col-12 AttachFilesDiv"></div>

                    <div class="row task-assign-date border-TP-5">
                        <div class="assigned-to AssTask">
                            <div class="col-12 p-0 text-gray mb-5">Assigned to:</div>
                            <div class="col-12 pl-0 float-left">
                                <div class="form-s2 date-List EMP__List">
                                    <select class="form-control formselect required" id="assigned_to" name="assigned_to"
                                        multiple="multiple" style="width: 100%!">
                                        @foreach ($employees as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="assigned-to EmailR">
                            <div class="col-12 p-0 text-gray mb-5"><strong>Email Reminder</strong></div>
                            <div class="col-auto l-height p-0">
                                <img class="calendarIcon" src="/images/calendar-icon002.svg" alt="">
                                <input class="assignedDate datepickerCorrespondence" id="reminderDateDp" type="text"
                                    value="10/10/2019" style="font-size: 13px; padding: 0;"></div>
                        </div>
                        <div class="assigned-to ERTime">
                            <div class="col-12 p-0 text-gray mb-5"><br></div>
                            <div class="col-auto l-height p-0">
                                <img class="calendarIcon float-left" src="/images/time-icon.svg" alt="">
                                <div class="form-s2 date-List H-arrow">
                                    <select class="form-control formselect" id="reminderTimeDD"
                                        style="width: 100px!important">
                                        {!! $time_options !!}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row m-10">
                    <div class="col-4">
                        <div class="col-12 p-0 text-gray mb-5">Upload Voice Note:</div>
                        <div class="col-12 pl-0 float-left">
                            <div class="form-s2 date-List EMP__List">
                                <input type="file" name="voice_note[]" accept=".mp3" multiple />
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="col-12 p-0 text-gray mb-5">Upload Documents:</div>
                        <div class="col-12 pl-0 float-left">
                            <div class="form-s2 date-List EMP__List">
                                <input type="file" name="multiple_documents[]" multiple />
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="col-12 p-0 text-gray mb-5">Upload Images:</div>
                        <div class="col-12 pl-0 float-left">
                            <div class="form-s2 date-List EMP__List">
                                <input type="file" name="multiple_images[]" multiple accept="image/*" />
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="modalWindow-bottom">
                    <button type="button" id="saveTask" class="btn btn-primary mr-2 float-left">Save Task</button>
                    <div class="float-left">
                        <div class="CC-Select-NT float-left">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkDate">

                            </div>
                        </div>
                        <div class="assigned-to _date-FU" id="Date-Show">
                            <div class="l-height p-0">
                                <img class="calendarIcon" src="/images/calendar-icon002.svg" alt="">
                                <input class="assignedDate datepickerCorrespondence" type="text" value="10/10/2019"
                                    style="font-size: 13px; padding: 0;"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="noteWindow" class="modalWindow">
        <div class="_MW-content">
            <h1 class="modalWindowTitle">Note <a class="modalWindow-act closeWindow"><img src="/images/close-icon.svg"
                        alt="" /></a> <a class="modalWindow-act modalExpand-btn" href="#"><i
                        class="fa fa-expand"></i></a></h1>
            <div class="_MW-mid-content">
                <textarea style="height: 100%" class="FW-textarea" id="momNote" name="Note"
                    placeholder="Start Typing to leave a note*"></textarea>
            </div>
            <div class="modalWindow-bottom">
                <button type="button" id="saveNote" class="btn btn-primary mr-2 float-left">Save Note</button>
                <div class="float-left">
                    <div class="CC-Select-NT float-left">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkDate">

                        </div>
                    </div>
                    <div class="assigned-to _date-FU" id="Date-Show">
                        <div class="l-height p-0">
                            <img class="calendarIcon" src="/images/calendar-icon002.svg" alt="">
                            <input class="assignedDate datepickerCorrespondence" type="text" value="10/10/2019"
                                style="font-size: 13px; padding: 0;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="logWindow" class="modalWindow" style="height:auto !important">
        <div class="_MW-content">
            <form id="saveLogForm" enctype="multipart/form-data">
                @csrf
                <h1 class="modalWindowTitle">Log <span id="logType">call</span> <a
                        class="modalWindow-act closeWindow"><img src="/images/close-icon.svg" alt="" /></a>
                    <a class="modalWindow-act modalExpand-btn" href="#"><i class="fa fa-expand"></i></a></h1>
                <div class="_MW-mid-content">
                    <div class="row task-assign-date border-bP-5">
                        <div class="assigned-to">
                            <div class="col-12 p-0 text-gray mb-5">Date:</div>
                            <div class="col-auto l-height p-0">
                                <img class="calendarIcon" src="/images/calendar-icon002.svg" alt="">
                                <input class="assignedDate datepickerCorrespondence" type="text" id="logDp"
                                    value="10/10/2019" style="font-size: 13px"></div>
                        </div>
                        <div class="assigned-to">
                            <div class="col-12 p-0 text-gray mb-5">Time:</div>
                            <div class="col-auto l-height p-0">
                                <img class="calendarIcon float-left" src="/images/time-icon.svg" alt="">
                                <div class="form-s2 date-List H-arrow">
                                    <select class="form-control formselect" id="logTime" style="width: 100px!important">
                                        {!! $time_options !!}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <textarea class="FW-textarea textareaLog" id="momLog" name="Note" style="height:100px"
                        placeholder="Describe the call*..."></textarea>
                    <div class="col-12 p-0">
                        <a class="attchFiles-act multi_attachments" type="voice"><img src="/images/audio-attach.svg"
                                alt=""> Upload Voice Note</a>
                        <input type="file" class="upload_voice_notes_log" name="voice_note[]" accept=".mp3" multiple
                            style="display:none" />
                        <a class="attchFiles-act multi_attachments" type="doc"><img src="/images/documents-attach.svg"
                                alt=""> Upload Documents</a>
                        <input type="file" name="multiple_documents[]" class="upload_documents_log" multiple
                            style="display:none" />
                        <a class="attchFiles-act multi_attachments" type="image"><img src="/images/pictures-attach.svg"
                                alt=""> Upload Images</a>
                        <input type="file" name="multiple_images[]" class="upload_images_log" multiple accept="image/*"
                            style="display:none" />
                    </div>
                    <!--div show when attach file-->
                    <div class="col-12 AttachFilesDiv"></div>
                </div>
                <div class="row task-assign-date border-TP-5 p-10 ml-0 mr-0">
                    <div class="assigned-to AssTask">
                        <div class="col-12 p-0 text-gray mb-5">Select POC:</div>
                        <div class="col-12 pl-0 float-left">
                            <div class="form-s2 date-List EMP__List">
                                <select class="form-control formselect required" id="select_poc_correspondence"
                                    multiple="multiple" style="width: 100%!">
                                    {{-- <option value="{{$data->id}}" independence="0">
                                        {{$data->first_name. ' ' .$data->last_name}}</option> --}}
                                    @foreach ($pocs as $key => $poc_data)
                                    <option value="{{$poc_data->id}}" independence="1">
                                        {{$poc_data->first_name. ' ' .$poc_data->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="row ml-5">
                            <div class="col-md-6"> 
                                <div class="col-12 pl-0 float-left">
                                    <div class="form-s2 date-List EMP__List">
                                        <button class="btn btn-primary" data-toggle="modal"
                                            data-target="#CorrespondenceCompetitionModal">Add Competition</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                <div class="col-12 pl-0 float-left">
                                    <div class="form-s2 date-List EMP__List">
                                        <button class="btn btn-primary" data-toggle="modal"
                                            data-target="#CorrespondenceInterestedModal">Add Interested IN</button>
                                    </div>
                                </div>
                            </div>

                        </div> --}}

                    </div>
                    <div class="assigned-to">
                        <div class="col-12 p-0 text-gray mb-5"><button class="btn btn-primary logComBTN"
                                data-toggle="modal" data-target="#CorrespondenceCompetitionModal">Add
                                Competition</button></div>

                    </div>

                    <div class="assigned-to">
                        <div class="col-12 p-0 text-gray mb-5"><button class="btn btn-primary logComBTN"
                                data-toggle="modal" data-target="#CorrespondenceInterestedModal">Add Interested
                                In</button></div>

                    </div>
                </div>
                <div class="modalWindow-bottom">
                    <button type="button" id="saveLog" class="btn btn-primary mr-2 float-left">Log
                        Activity</button>
                    <div class="float-left">
                        <div class="CC-Select-NT float-left">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkDate">
                            </div>
                        </div>
                        <div class="assigned-to _date-FU" id="Date-Show">
                            <div class="l-height p-0">
                                <img class="calendarIcon" src="/images/calendar-icon002.svg" alt="">
                                <input class="assignedDate" type="text" value="10/10/2019" id="datepicker"
                                    style="font-size: 13px">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="overlay-blure"></div>
    <div class="row" style="margin-top: -15px">
        <div class="col-4 profile-left">
            <div class="CT_sec">
                <div class="row">
                    <div class="col"><a href="/Customer" class="btn _BC-btn"><i class="fa fa-angle-left"> </i>
                            Contacts</a></div>
                    {{-- <div class="col text-right">
                        <div class="btn-group">
                            <button type="button" class="btn _BC-btn dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"> Action </button>
                            <div class="dropdown-menu">
                                <a href="/CustomerProfile/{{$data->id}}" class="dropdown-item" type="button">Edit</a>
                    <hr class="m-0">
                    <button class="dropdown-item" type="button">Merge</button>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="_profile-card">
        <h2>{{ $data->company_name }}</h2>
        <ul>
            <li>
                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                        src="/images/add-pluse-icon-b.svg" alt="" /></a>Log
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item createLog" type="call">Log a call</a>
                    <a class="dropdown-item createLog" type="email">Log an email</a>
                    <a class="dropdown-item createLog" type="meeting">Log a meeting</a>
                </div>
            </li>
            <li><a id="createNote"><img src="/images/note-icon-b.svg" alt="" /></a>Note</li>
            <li><a id="createTask"><img src="/images/task-icon-b.svg" alt="" /></a>Task</li>
            <li onclick="openOrderTab()"><a><img src="/images/order-icon-b.svg" alt="" /></a>Order</li>
            <li onclick="openPaymentTab()"><a><img src="/images/payment-icon-b.svg" alt="" /></a>Payment
            </li>
            <li><a class="sample_modal" type="sample"><img src="/images/sampling-icon-b.svg"
                        alt="Sampling" /></a>Sampling</li>
            <li><a class="sample_modal" type="quotation"><img src="/images/pricequot-icon-b.svg"
                        alt="Price QTN." /></a>Price QTN.</li>
        </ul>
    </div>
</div>



<div class="left_Info">
    <div style="padding: 5px 5px 20px 10px">
        <a class="Comp_Coll" data-toggle="collapse" data-target="#multiCollapseExampleComp" aria-expanded="false"
            aria-controls="multiCollapseExampleComp">
            <h2 class="_head03 m-0">Agency <span>Details</span> <i class="fa fa-angle-down"></i></h2>
        </a>
        <div class="collapse Comp_detail p-0" id="multiCollapseExampleComp">
            <div class="form-wrap p-0 _user-profile-info">
                <div class="row CP-Details">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Agency Name</label>
                            <p>{{ $data->company_name }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Business Type</label>
                            <p>
                                {{ ($data->business_type=='1' ? "Real Estate Agency"  : ($data->business_type=='2' ? "Mortgage Broker"  :  ($data->business_type=='3' ? "Lender"  : ($data->business_type=='4' ? "Bank"  : "NA") )) )}}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Business Ph</label>
                            <p>{{ $data->business_phone }}</p>
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label class="control-label">Email address</label>
                            <p>{{ $data->email ? $data->email : "NA" }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label class="control-label">Web Page Address</label>
                            <p>{{ $data->website_url ? $data->website_url : "NA" }}</p>
                        </div>
                    </div>
                </div>

                <div class="row addressCard">
                    <div class="col-md-12">
                        <h3>Official Address</h3>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <p>{{$data->office_no}}, {{$data->street_address }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 p-col-L">
                        <div class="form-group">
                            <label class="control-label">Postal Code</label>
                            <p>{{$data->postal_code ? $data->postal_code : "NA"}}</p>
                        </div>
                    </div>
                    <div class="col-md-6 p-col-R">
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <p>{{$data->city ? $data->city : "NA"}}</p>
                        </div>
                    </div>

                    <div class="col-md-6 p-col-L">
                        <div class="form-group">
                            <label class="control-label">State</label>
                            <p>{{$data->state ? $data->state : "NA"}}</p>
                        </div>
                    </div>

                    <div class="col-md-6 p-col-R">
                        <div class="form-group">
                            <label class="control-label">Country</label>
                            <p>{{$data->country ? $data->country : "NA"}}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <h2 class="_head03">Contact <span>List</span></h2>
        
        @foreach ($pocs as $key => $poc_data)
        
        <a class="Comp_POC mt-15" data-toggle="collapse" data-target="#multiCollapseExample{{$key}}"
            aria-expanded="false" aria-controls="multiCollapseExample{{$key}}">
            <img src="/images/avatar-img.jpg"
                alt="" />
            {{$poc_data->first_name. ' '. $poc_data->last_name}} <i class="fa fa-angle-down"></i>
        </a>
        <div class="collapse Comp_detail" id="multiCollapseExample{{$key}}">
            <div class="form-wrap p-0 _user-profile-info">

                <div class="row CP-Details">
                    <div class="col-md-6 p-col-L">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <p>{{$poc_data->first_name}} {{$poc_data->last_name}} </p>
                        </div>
                    </div>
                    <div class="col-md-6 p-col-R">
                        <div class="form-group">
                            <label class="control-label">Contact Type</label>
                            <p>{{$poc_data->contact_type_name}}</p>
                        </div>
                    </div>
                    <div class="col-md-6 p-col-L">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <p>{{$poc_data->email ? $poc_data->email : "NA"}}</p>
                        </div>
                    </div>
                    <div class="col-md-6 p-col-R">
                        <div class="form-group">
                            <label class="control-label">Contact No.</label>
                            <p>
                                {{$poc_data->contact_cellphone}}
                            </p>
                            
                        </div>
                    </div>
                    <div class="col-md-6 p-col-L">
                        <div class="form-group">
                            <label class="control-label">Employment Status</label>
                            <p>
                                {{ ($poc_data->employment_status=='1' ? "Freelance"  : ($poc_data->employment_status=='2' ? "Employeed" : "NA") )}}
                            </p>
                            
                        </div>
                    </div>
                        <div class="col-md-12">
                            <h5>Address</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Address</label>
                                <p>{{$poc_data->office_no}}, {{$poc_data->business_address }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 p-col-L">
                            <div class="form-group">
                                <label class="control-label">Postal Code</label>
                                <p>{{$poc_data->postal_code ? $poc_data->postal_code : "NA"}}</p>
                            </div>
                        </div>
                        <div class="col-md-6 p-col-R">
                            <div class="form-group">
                                <label class="control-label">City</label>
                                <p>{{$poc_data->city ? $poc_data->city : "NA"}}</p>
                            </div>
                        </div>
    
                        <div class="col-md-6 p-col-L">
                            <div class="form-group">
                                <label class="control-label">State</label>
                                <p>{{$poc_data->state ? $poc_data->state : "NA"}}</p>
                            </div>
                        </div>
    
                        <div class="col-md-6 p-col-R">
                            <div class="form-group">
                                <label class="control-label">Country</label>
                                <p>{{$poc_data->country ? $poc_data->country : "NA"}}</p>
                            </div>
                        </div>
                    {{-- @if($poc_data->business)
                    @foreach (explode(",",$poc_data->business) as $value)
                    <div class="col-md-6 p-col-L">
                        <div class="form-group">
                            <label class="control-label">Business Phone</label>
                            <p>{{ $value }}</p>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    @if($poc_data->mobile_no)
                    @foreach (explode(",",$poc_data->mobile_no) as $value)
                    <div class="col-md-6 p-col-R">
                        <div class="form-group">
                            <label class="control-label">Mobile No</label>
                            <p>{{ $value }}</p>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    @if($poc_data->whatsapp)
                    @foreach (explode(",",$poc_data->whatsapp) as $value)
                    <div class="col-md-6 p-col-L">
                        <div class="form-group">
                            <label class="control-label">WhatsApp No</label>
                            <p>{{ $value}}</p>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <div class="col-md-6 p-col-R">
                        <div class="form-group">
                            <label class="control-label">Wechat</label>
                            <p>{{ $poc_data->wechat ? $poc_data->wechat : "NA" }}</p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">LinkedIn</label>
                            <p>{{ $poc_data->linkedin ? $poc_data->linkedin : "NA" }}</p>
                        </div>
                    </div> --}}
                </div>
            </div>

        </div>
        @endforeach
    </div>
</div>

</div>
<div class="col profile-center">
    <div class="col-lg-12 _activityMD" style="min-height: 400px !important">
        <div class="_activityHead filtersDiv">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-activity-tab" data-toggle="pill" href="#pills-activity"
                        role="tab" aria-controls="pills-activity" aria-selected="true">Activity</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-notes-tab" data-toggle="pill" href="#pills-notes" role="tab"
                        aria-controls="pills-notes" aria-selected="false">Notes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-task-tab" data-toggle="pill" href="#pills-task" role="tab"
                        aria-controls="pills-task" aria-selected="false">Task</a>
                </li>
                <li class="nav-item" id="orderTabPill">
                    <a class="nav-link" id="pills-order-tab" data-toggle="pill" href="#pills-order" role="tab"
                        aria-controls="pills-order" aria-selected="false">Order</a>
                </li>
                <li class="nav-item" id="paymentTabPill">
                    <a class="nav-link" id="payments-pill-tab" data-toggle="pill" href="#payments-pill" role="tab"
                        aria-controls="payments-pill" aria-selected="false">Payment</a>
                </li>
            </ul>

            <div class="_more-action __filter">
                <div class="dropdown float-left filtersDivComplete">
                    <button class="btn btn-primary dropdown-toggle filterActiviesDD" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter
                        Activity (0/5)
                    </button>
                    <form class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

                        <div class="CC-Select">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="filterCb[]" item="note" class="custom-control-input"
                                    id="customCheck100">
                                <label class="custom-control-label" for="customCheck100">Notes</label>
                            </div>
                        </div>
                        <div class="CC-Select">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="filterCb[]" item="task" class="custom-control-input"
                                    id="customCheck102">
                                <label class="custom-control-label" for="customCheck102">Task</label>
                            </div>
                        </div>
                        <div class="CC-Select">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="filterCb[]" item="call" class="custom-control-input"
                                    id="customCheck105">
                                <label class="custom-control-label" for="customCheck105">Log
                                    call</label>
                            </div>
                        </div>
                        <div class="CC-Select">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="filterCb[]" item="email" class="custom-control-input"
                                    id="customCheck106">
                                <label class="custom-control-label" for="customCheck106">Log
                                    email</label>
                            </div>
                        </div>
                        <div class="CC-Select">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="filterCb[]" item="meeting" class="custom-control-input"
                                    id="customCheck107">
                                <label class="custom-control-label" for="customCheck107">Log
                                    meeting</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="form-s2 date-List EMP__List filtersDivComplete" style="width: 200px;">
                    <select id="userFilter" class="form-control formselect">
                        <option attr-name="all" selected>All Users</option>
                        @foreach ($employees as $emp)
                        <option attr-name="{{ $emp->name }}" value="{{ $emp->id }}">{{ $emp->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="S__Activity filtersDivComplete">
                    <a href="#"><i class="fa fa-search"></i></a>
                    <input type="search" class="SearchActivity" placeholder="Search Activity">
                </div>
            </div>
        </div>
        <div class="_activitycards">
            <div class="tab-content PC-Tab pt-0" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-activity" role="tabpanel"
                    aria-labelledby="pills-activity-tab">
                    <div class="dynamicDataDiv"></div>
                </div>
                <div class="tab-pane fade" id="pills-notes" role="tabpanel" aria-labelledby="pills-notes-tab">
                    <div class="dynamicNotesDiv"></div>
                </div>
                <div class="tab-pane fade" id="pills-task" role="tabpanel" aria-labelledby="pills-task-tab">
                    <div class="dynamicTasksDiv"></div>
                </div>
                <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab">
                    <div class="orders_card_div"></div>
                    <div class="order_pagnation_link text-center">
                        <div id="order_cards_holder" class="holder" style="position: relative;"></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="payments-pill" role="tabpanel" aria-labelledby="payments-pill-tab">
                    <div class="Activity-card">
                        <div class="body">
                            <table class="table table-hover dt-responsive nowrap" id="paymentTable"
                                style="width:100% !important">
                                <thead>
                                    <tr>
                                        <th>Issued Date</th>
                                        <th>PO Number</th>
                                        <th>Order Amount</th>
                                        <th>Amount Paid</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $item)
                                    @if ($item->paid_amt)
                                    <tr>
                                        <td>{{ $item->issue_date }}</td>
                                        <td>{{ $item->po_num }}</td>
                                        <td>{{ number_format($item->total_amount) }}</td>
                                        <td>{{ number_format($item->paid_amt) }}</td>
                                        <td>{{ ucfirst($item->current_status) }}</td>
                                        <td>
                                            <button oid="{{ $item->id }}" class="btn btn-default paymentHistory"
                                                data-toggle="modal" data-target="#paymentHistoryModal">Payment
                                                History</button>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
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
</div>
</div>
@endsection
