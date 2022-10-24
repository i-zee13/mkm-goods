@extends('layouts.master')
@section('content')
{{-- <div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">All <span> Notification</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Notification</span></a></li>
            <li><span>List</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
                @if(!empty($all_notifications))
                @foreach($all_notifications as $notifications)
                <div class="alert alert-warning alert-dismissible fade show alert-color _NF-se" role="alert">
                    <img src="{{ Storage::exists('public/company/'.$notifications->picture) ? URL::to('/storage/company').'/'.$notifications->picture : '/images/avatar.svg'}}"
class="NU-img float-none mb-0" alt="">
<strong class="notifications_list_all"
    id="{{$notifications->id}}">{{$notifications->order_id ? "Order " : $notifications->customer}}
</strong> {{ $notifications->message }}
</div>
@endforeach
@else
<label>No new notifications</label>
@endif
</div>
</div>
</div>
</div> --}}
<div class="_activityEmp">
    <div class="_activityEmp-Head">
        <div class="row mt-2">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h2 class="_head01">Overall <span>Notification</span></h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <ol class="breadcrumb">
                    <li><a href="#"><span>Overall</span></a></li>
                    <li><span>Notification</span></li>
                </ol>
            </div>

            <div class="col-12 _activity-filter-EMP">
                <div class="_more-action __filter pr-0">
                    <div class="form-s2 date-List EMP__List" style="width: 140px!important">
                        <select class="form-control formselect notif_date_filter">
                            <option value="0" selected>All</option>
                            <option value="1">Yesterday</option>
                            <option value="2">Today</option>
                            <option value="3">Current Month</option>
                            <option value="4">Last Month</option>
                            <option value="5">Custom</option>
                        </select>
                    </div>
                    <div class="Datefilter-EMP notif_custom_div" style="display:none">
                        <div><input type="text" class="datepicker notif_start_date" class="form-control" placeholder="Start Date"
                                style="font-size: 13px"></div>
                        <div><input type="text" class="datepicker notif_end_date" class="form-control" placeholder="End Date"
                                style="font-size: 13px"></div>
                    </div>




                    <div class="S__Activity"> <a ><i class="fa fa-search"></i></a>
                        <input type="search" placeholder="Search Notification" class="searchNotif">
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div class="_activityEmp-timeline">
        <div class="row">
            <div class="col-md-12">
                <ul class="notificationList">
                    {{-- @if(!empty($all_notifications))
                    @foreach($all_notifications as $notifications)

                        <li>
                            <div class="row">
                                <div class="col-3"><img class="NotiImg" src="{{ Storage::exists('public/company/'.$notifications->picture) ? URL::to('/storage/company').'/'.$notifications->picture : '/images/avatar.svg'}}" alt="">
                                <h4>Created BY</h4><small>time</small>
                                </div>
                                <div class="col-9 border-left">
                                <h4><span class="blue-text">{{($notifications->order_id ? "Order " : ($notifications->customer_id ? 'Customer' : ($notifications->supplier_id ? 'Supplier' : ($notifications->prospect_customer_id ? 'Prospect Customer' : 'Item'))))}}</span></h4>
                                {{($notifications->order_id ? "Order " : ($notifications->customer_id ? 'Customer' : ($notifications->supplier_id ? 'Supplier' : ($notifications->prospect_customer_id ? 'Prospect Customer' : 'Item'))))}} <strong>{{$notifications->_name}}</strong> {{ $notifications->message }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                    @else
                    <label>No new notifications</label>
                    @endif --}}
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
