@extends('layouts.master')
 
@if (is_array($my_designation_rights['designation_rights'] || Auth::user()->super))
@if (in_array("emp_activity", json_decode($my_designation_rights['designation_rights'], true)) || Auth::user()->super)
@section('data-sidebar')
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

                            @if(sizeof($activities['orders']) == 0 && sizeof($activities['items']) == 0 &&
                            sizeof($activities['products']) == 0 && sizeof($activities['customers']) == 0 &&
                            sizeof($activities['pocs']) == 0 && sizeof($activities['suppliers']) == 0 &&
                            sizeof($activities['forwarders']) == 0 && sizeof($activities['shippers']) == 0 &&
                            sizeof($activities['employees']) == 0 && sizeof($activities['payments']) == 0)
                            <div class="NoAct"><img src="/images/noavtivity-icon.svg" alt="" />You don't have any
                                activity yet<br>
                                <a href="/view_all_activities" class="btn btn-primary mt-15 font13">View Previous
                                    Activity</a>
                            </div>
                            @else
                            <ul class="Act-timeline">
                                @foreach ($activities['orders'] as $orders)
                                @if($orders->created_at == date('Y-m-d') && $orders->created_by)
                                <li>
                                    <div class="dateFollowUP">{{$orders->created_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$orders->created_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Sales Order</h5>
                                            <p>{{$orders->created_by}} has created a New Sales Order for
                                                {{$orders->customer_name}} Worth {{$orders->currency}}
                                                {{$orders->total_amount}} Order # <a
                                                    href="/OrderManagement">{{$orders->id}}</a></p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($orders->updated_at == date('Y-m-d') && $orders->updated_by)
                                <li>
                                    <div class="dateFollowUP">{{$orders->updated_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$orders->updated_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Sales Order Update</h5>
                                            <p>{{$orders->updated_by}} has updated Sales Order # <a
                                                    href="/OrderManagement">{{$orders->id}}</a> for
                                                {{$orders->customer_name}} worth {{$orders->currency}}
                                                {{$orders->total_amount}}</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($orders->completed_at == date('Y-m-d') && $orders->completed_by)
                                <li>
                                    <div class="dateFollowUP">{{$orders->completed_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$orders->completed_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Sales Order Complete</h5>
                                            <p>{{$orders->completed_by}} has completed the Sales Order # <a
                                                    href="/OrderManagement">{{$orders->id}}</a> for
                                                {{$orders->customer_name}} worth {{$orders->currency}}
                                                {{$orders->total_amount}}</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($orders->processed_at == date('Y-m-d') && $orders->processed_by)
                                <li>
                                    <div class="dateFollowUP">{{$orders->processed_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$orders->processed_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Sales Order Dispatch</h5>
                                            <p>{{$orders->processed_by}} has created a full dispatch for Sales Order #
                                                <a href="/OrderManagement">{{$orders->id}}</a> for
                                                {{$orders->customer_name}} worth {{$orders->currency}}
                                                {{$orders->total_amount}}</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach

                                @foreach ($activities['items'] as $items)
                                @if($items->created_at == date('Y-m-d') && $items->created_by)
                                <li>
                                    <div class="dateFollowUP">{{$items->created_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$items->created_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Variant</h5>
                                            <p>{{$items->created_by}} has created a new Item <a
                                                    href="/ProductItems/{{$items->product_sku}}">{{$items->name}}</a>
                                                for {{$items->product_name}}</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($items->updated_at == date('Y-m-d') && $items->updated_by)
                                <li>
                                    <div class="dateFollowUP">{{$items->updated_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$items->updated_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Update Variant</h5>
                                            <p>{{$items->updated_by}} has updated Item <a
                                                    href="/ProductItems/{{$items->product_sku}}">{{$items->name}}</a>
                                                for {{$items->product_name}}</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach

                                @foreach ($activities['products'] as $products)
                                @if($products->created_at == date('Y-m-d') && $products->created_by)
                                <li>
                                    <div class="dateFollowUP">{{$products->created_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$products->created_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Product</h5>
                                            <p>{{$products->created_at}} has created a new Product<a
                                                    href="/BrandProducts/{{$products->brand_id}}">{{$products->name}}</a>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($products->updated_at == date('Y-m-d') && $products->updated_by)
                                <li>
                                    <div class="dateFollowUP">{{$products->updated_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$products->updated_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Product Update</h5>
                                            <p>{{$products->updated_by}} has Updated Product <a
                                                    href="/BrandProducts/{{$products->brand_id}}">{{$products->name}}</a>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach

                                @foreach ($activities['customers'] as $customers)
                                @if($customers->created_at == date('Y-m-d') && $customers->created_by)
                                <li>
                                    <div class="dateFollowUP">{{$customers->created_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$customers->created_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Customer</h5>
                                            <p>{{$customers->created_by}} has created a new customer <a
                                                    href="/Correspondence/create/{{$customers->id}}">{{$customers->company_name}}</a>
                                                from {{$customers->country}}</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($customers->updated_at == date('Y-m-d') && $customers->updated_by)
                                <li>
                                    <div class="dateFollowUP">{{$customers->updated_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$customers->updated_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Customer Update</h5>
                                            <p>{{$customers->updated_by}} has updated customer details <a
                                                    href="/Correspondence/create/{{$customers->id}}">{{$customers->company_name}}</a>
                                                from {{$customers->country}}</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach

                                @foreach ($activities['pocs'] as $pocs)
                                @if($pocs->created_at == date('Y-m-d') && $pocs->created_by)
                                <li>
                                    <div class="dateFollowUP">{{$pocs->created_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$pocs->created_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New POC</h5>
                                            <p>{{$pocs->created_by}} has added a new POC {{$pocs->first_name}} for <a
                                                    href="/Correspondence/create/{{$pocs->customer_id}}">{{$pocs->customer_name}}</a>
                                                from {{$pocs->cust_country}}</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($pocs->updated_at == date('Y-m-d') && $pocs->updated_by)
                                <li>
                                    <div class="dateFollowUP">{{$pocs->updated_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$pocs->updated_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Update POC</h5>
                                            <p>{{$pocs->updated_by}} has updated POC details of {{$pocs->first_name}}
                                                for <a
                                                    href="/Correspondence/create/{{$pocs->customer_id}}">{{$pocs->customer_name}}</a>
                                                from {{$pocs->cust_country}}</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach


                                @foreach ($activities['suppliers'] as $sup)
                                @if($sup->created_at == date('Y-m-d') && $sup->created_by)
                                <li>
                                    <div class="dateFollowUP">{{$sup->created_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$sup->created_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Supplier</h5>
                                            <p>{{$sup->created_by}} has created a new supplier <a
                                                    href="/Suppliers">{{$sup->company_name}}</a></p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($sup->updated_at == date('Y-m-d') && $sup->updated_by)
                                <li>
                                    <div class="dateFollowUP">{{$sup->updated_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$sup->updated_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Update Supplier</h5>
                                            <p>{{$sup->updated_by}} has updated supplier details <a
                                                    href="/Suppliers">{{$sup->company_name}}</a></p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach

                                @foreach ($activities['forwarders'] as $forwarders)
                                @if($forwarders->created_at == date('Y-m-d') && $forwarders->created_by)
                                <li>
                                    <div class="dateFollowUP">{{$forwarders->created_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$forwarders->created_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Forwarder</h5>
                                            <p>{{$forwarders->created_by}} has created a new Forwarding Company <a
                                                    href="/forwarder">{{$forwarders->company_name}}</a></p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($forwarders->updated_at == date('Y-m-d') && $forwarders->updated_by)
                                <li>
                                    <div class="dateFollowUP">{{$forwarders->updated_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$forwarders->updated_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Update Forwarder</h5>
                                            <p>{{$forwarders->updated_by}} has updated Forwarding <a
                                                    href="/forwarder">{{$forwarders->company_name}}</a></p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach

                                @foreach ($activities['shippers'] as $shippers)
                                @if($shippers->created_at == date('Y-m-d') && $shippers->created_by)
                                <li>
                                    <div class="dateFollowUP">{{$shippers->created_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$shippers->created_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Shipping Company</h5>
                                            <p>{{$shippers->created_by}} has created a new Shipping Company <a
                                                    href="/Shipping">{{$shippers->company_name}}</a></p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($shippers->updated_at == date('Y-m-d') && $shippers->updated_by)
                                <li>
                                    <div class="dateFollowUP">{{$shippers->updated_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$shippers->updated_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Update Shipping Company</h5>
                                            <p>{{$shippers->updated_by}} has updated Shipping Company <a
                                                    href="/Shipping">{{$shippers->company_name}}</a></p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach

                                @foreach ($activities['employees'] as $emp)
                                @if($emp->created_at == date('Y-m-d') && $emp->created_by)
                                <li>
                                    <div class="dateFollowUP">{{$emp->created_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$emp->created_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> New Employee</h5>
                                            <p>{{$emp->created_by}} has added a new Employee <a
                                                    href="/register">{{$emp->name}}</a></p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($emp->updated_at == date('Y-m-d') && $emp->updated_by)
                                <li>
                                    <div class="dateFollowUP">{{$emp->updated_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$emp->updated_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Update Employee</h5>
                                            <p>{{$emp->updated_by}} has updated employee <a
                                                    href="/register">{{$emp->name}}</a></p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach

                                @foreach ($activities['payments'] as $payments)
                                @if($payments->created_at == date('Y-m-d') && $payments->created_by)
                                <li>
                                    <div class="dateFollowUP">{{$payments->created_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$payments->created_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Payment Created</h5>
                                            <p>New Payment Created</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($payments->updated_at == date('Y-m-d') && $payments->updated_by)
                                <li>
                                    <div class="dateFollowUP">{{$payments->updated_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$payments->updated_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Payment Updated</h5>
                                            <p>Existing Payment Updated</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach

                                @foreach ($activities['tasks'] as $task)
                                @if($task->created_at == date('Y-m-d') && $task->created_by)
                                <li>
                                    <div class="dateFollowUP">{{$task->created_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$task->created_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Task Created</h5>
                                            <p>New Task Created</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($task->updated_at == date('Y-m-d') && $task->updated_by)
                                <li>
                                    <div class="dateFollowUP">{{$task->updated_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$task->updated_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Task Updated</h5>
                                            <p>Existing Task Updated</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($task->completed_at == date('Y-m-d') && $task->completed_by)
                                <li>
                                    <div class="dateFollowUP">{{$task->completed_at}}</div>
                                    <div class="timeline-icon"><img src="/images/avatar.svg" alt=""></div>
                                    <div class="timeline-info">
                                        <h4>{{$task->completed_by}}</h4>
                                        <div class="historyDiv">
                                            <h5><span class="blue-text">Follow Up:</span> Task Completed</h5>
                                            <p>Task Completed</p>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @endforeach

                                <a href="/view_all_activities" class="btn-primary view-all-EA">View All
                                    Activities</a>
                                </li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endif
@endif

@section('content')
<style>
    @media (max-width: 1280px) {
        #content-wrapper {
            padding-right: 25px !important;
        }
    }

</style>
<div class="row _user-TS">
    <div class="col-md-5 _dashTOP">
        {{-- <img class="_user_Pimage" src="images/avatar.svg" alt=""> --}}
        <img class="_user_Pimage" src="{{ Auth::user()->picture ? str_replace('./', '/', Auth::user()->picture) : '/images/avatar.svg' }}" alt="" />
        <h2 class="_head01">{{ Auth::user()->name }}</h2>
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
{{--    <div class="col-md-6 mb-30">--}}
{{--        <div class="card _act-TL">--}}

{{--            <div class="header _pillsTabs">--}}
{{--                <h2>Latest <span> Tasks</span></h2>--}}

{{--                <ul class="nav nav-pills" id="pills-tab" role="tablist">--}}
{{--                    @if ($my_designation_rights['designation_rights'] || Auth::user()->super)--}}
{{--                    @if (in_array("all_tasks", json_decode($my_designation_rights['designation_rights'], true)) ||--}}
{{--                    Auth::user()->super)--}}
{{--                    <li class="nav-item"> <a class="nav-link active" id="pills-taskAll-tab" data-toggle="pill"--}}
{{--                            href="#pills-taskAll" role="tab" aria-controls="pills-taskAll" aria-selected="true">All--}}
{{--                            Task</a>--}}
{{--                    </li>--}}
{{--                    @endif--}}
{{--                    @endif--}}

{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link {{ !Auth::user()->super ? ($my_designation_rights['designation_rights'] ? (!in_array("all_tasks", json_decode($my_designation_rights['designation_rights'], true)) ? 'active' : ''): 'active') : '' }}"--}}
{{--                            id="pills-taskPend-tab" data-toggle="pill" href="#pills-taskPend" role="tab"--}}
{{--                            aria-controls="pills-taskPend" aria-selected="false">My Task</a> </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" id="pills-taskComp-tab" data-toggle="pill" href="#pills-taskComp" role="tab"--}}
{{--                            aria-controls="pills-taskComp" aria-selected="false">Pending Task</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}

{{--            <div class="body">--}}

{{--                <div class="tab-content" id="pills-tabContent">--}}
{{--                    @if ($my_designation_rights['designation_rights'] || Auth::user()->super)--}}
{{--                    @if (in_array("all_tasks", json_decode($my_designation_rights['designation_rights'], true)) ||--}}
{{--                    Auth::user()->super)--}}
{{--                    <div class="tab-pane fade show active" id="pills-taskAll" role="tabpanel"--}}
{{--                        aria-labelledby="pills-taskAll-tab">--}}
{{--                        <ul class="Act-timeline">--}}
{{--                            @foreach ($data['all'] as $c)--}}
{{--                            @if($c['type'] == 'task')--}}
{{--                            <a href="/Correspondence/create/{{$c['customer_id']}}"--}}
{{--                                style="text-decoration: inherit; color: inherit;">--}}
{{--                                <li>--}}
{{--                                    <div class="timeline-icon"><img src="/images/task-icon-b.svg" alt=""></div>--}}
{{--                                    <div class="timeline-info">--}}
{{--                                        <h5>{{ $c['title'] }}</h5>--}}
{{--                                        <p>{{ $c['mom'] }}</p>--}}
{{--                                        <small>{{$c['time_ago']}}</small>--}}
{{--                                    </div>--}}
{{--                            </a></li>--}}
{{--                            @endif--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                    @endif--}}
{{--                    @endif--}}
{{--                    <div class="tab-pane fade {{ !Auth::user()->super ? ($my_designation_rights['designation_rights'] ? (!in_array("all_tasks", json_decode($my_designation_rights['designation_rights'], true)) ? 'show active' : '') : 'show active') : '' }}"--}}
{{--                        id="pills-taskPend" role="tabpanel" aria-labelledby="pills-taskPend-tab">--}}
{{--                        <ul class="Act-timeline">--}}
{{--                            @foreach ($data['all'] as $c)--}}
{{--                            @if ($c['type'] == 'task' && $c['created_by'] == Auth::user()->id ||--}}
{{--                            in_array(Auth::user()->id,--}}
{{--                            explode(',', $c['assigned_to'])))--}}
{{--                            <a href="/Correspondence/create/{{$c['customer_id']}}"--}}
{{--                                style="text-decoration: inherit; color: inherit;">--}}
{{--                                <li>--}}
{{--                                    <div class="timeline-icon"><img src="/images/task-icon-b.svg" alt=""></div>--}}
{{--                                    <div class="timeline-info">--}}
{{--                                        <h5>{{ $c['title'] }}</h5>--}}
{{--                                        <p>{{ $c['mom'] }}</p>--}}
{{--                                        <small>{{$c['time_ago']}}</small>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                            </a>--}}
{{--                            @endif--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                    <div class="tab-pane fade" id="pills-taskComp" role="tabpanel" aria-labelledby="pills-taskComp-tab">--}}
{{--                        <ul class="Act-timeline">--}}
{{--                            @foreach ($data['all'] as $c)--}}
{{--                            @if ($c['type'] == 'task' && $c['completed_at'] == null)--}}
{{--                            @if ($c['created_by'] == Auth::user()->id || in_array(Auth::user()->id, explode(',',--}}
{{--                            $c['assigned_to'])))--}}
{{--                            <a href="/Correspondence/create/{{$c['customer_id']}}"--}}
{{--                                style="text-decoration: inherit; color: inherit;">--}}
{{--                                <li>--}}
{{--                                    <div class="timeline-icon"><img src="/images/task-icon-b.svg" alt=""></div>--}}
{{--                                    <div class="timeline-info">--}}
{{--                                        <h5>{{ $c['title'] }}</h5>--}}
{{--                                        <p>{{ $c['mom'] }}</p>--}}
{{--                                        <small>{{$c['time_ago']}}</small>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                            </a>--}}
{{--                            @endif--}}
{{--                            @endif--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}

{{--        </div>--}}

{{--    </div>--}}

{{--    <div class="col-md-6">--}}

{{--        <div class="card _act-TL">--}}
{{--            <div class="header">--}}
{{--                <h2>Production <span> Follow Up</span></h2><a href="#">View All</a>--}}
{{--            </div>--}}
{{--            <div class="body">--}}
{{--                @if (sizeof($follow_ups) > 0)--}}
{{--                @foreach ($follow_ups as $follow_up_data)--}}
{{--                <a href="/supplier_follow_up/{{$follow_up_data['supplier_id']}}" class="SupplierCard">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-12"><strong>Supplier:</strong> {{$follow_up_data['supplier_name']}} </div>--}}
{{--                        <div class="col-6"><strong>Total Order:</strong> {{$follow_up_data['total_orders']}}</div>--}}
{{--                        <div class="col-6 text-right"><strong>Products:</strong> {{$follow_up_data['total_products']}}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--                @endforeach--}}
{{--                @else--}}
{{--                <div class="NoFollowUp">--}}
{{--                    <img src="images/nofollowup-icon.svg" alt="">No Follow Up for Today--}}
{{--                </div>--}}
{{--                @endif--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
{{--<div class="row">--}}
{{--    <div class="col-md-12">--}}
{{--        <div class="card">--}}
{{--            <div class="header">--}}
{{--                <a id="productlist01" href="/Orders/create" class="btn add_button"><i class="fa fa-plus"></i>--}}
{{--                    <span> Add Order</span></a>--}}
{{--                <h2>Recent <span> Order</span></h2>--}}
{{--            </div>--}}
{{--            <div class="body">--}}
{{--                <table class="table table-hover dt-responsive nowrap" id="example" style="width:100% !important">--}}
{{--                    <thead>--}}
{{--                        <tr>--}}
{{--                            <th>Customer Name</th>--}}
{{--                            <th>Issued Date</th>--}}
{{--                            <th>PO Number</th>--}}
{{--                            <th>Supplier</th>--}}
{{--                            <th>Status</th>--}}
{{--                            <th>Action</th>--}}
{{--                        </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                        @foreach ($data['orders'] as $item)--}}
{{--                        <tr>--}}
{{--                            <td>{{ $item->customer }}</td>--}}
{{--                            <td>{{ $item->issue_date }}</td>--}}
{{--                            <td>{{ $item->po_num }}</td>--}}
{{--                            <td>{{ $item->supplier ? $item->supplier : "NA" }}</td>--}}
{{--                            <td>{{ ucfirst($item->current_status) }}</td>--}}
{{--                            <td>--}}

{{--                                @if($item->current_status == "pending")--}}
{{--                                --}}{{-- <a href="/Dispatch/{{ $item->id }}" class="btn btn-default">Dispatch</a> --}}
{{--                                <a href="/OrderDetails/{{ $item->id }}" class="btn btn-default">Details</a>--}}
{{--                                @endif--}}

{{--                                @if($item->current_status !== 'performa' && $item->current_status !== 'draft')--}}
{{--                                <button id="{{ $item->id }}" class="btn btn-default viewOrderSheet" data-toggle="modal"--}}
{{--                                    data-target=".orderSheetModal">Order Sheet</button>--}}
{{--                                @elseif($item->current_status == 'performa' || $item->current_status == 'draft')--}}
{{--                                <a href="/Orders/{{$item->id}}/edit" class="btn btn-default btn-line">Edit</a>--}}
{{--                                @elseif($item->current_status == 'processed')--}}
{{--                                <button id="{{ $item->id }}" class="btn btn-default completeOrder">Complete</button>--}}
{{--                                @endif--}}
{{--                                @if($item->total_amount && $item->payment_received == 0 && $item->current_status ==--}}
{{--                                'completed')--}}
{{--                                <button--}}
{{--                                    id="{{ $item->id ."/".($item->paid_amt ? (($item->total_amount - $item->discount_value) - $item->paid_amt) : $item->total_amount - $item->discount_value).'/'.($item->currency_symbol) }}"--}}
{{--                                    class="btn btn-default recieve_payment" data-toggle="modal"--}}
{{--                                    data-target="#exampleModal">Recieve Payment</button>--}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                        @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@endsection