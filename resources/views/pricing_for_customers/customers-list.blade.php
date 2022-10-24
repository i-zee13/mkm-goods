@extends('layouts.master')
@section('css')
    <style>
        .dashboard-date .form-control {
            font-family: 'Rationale', sans-serif !important;
        }

        .dashboard-date {
            width: 260px;
            float: right;
            margin-top: 4px;
            margin-right: 15px;
            position: relative;
        }

        .dashboard-date .fa {
            position: absolute;
            top: 10px;
            right: 0;
            font-size: 16px;
            color: #888888
        }

        .dashboard-date .form-control {
            border: 0;
            box-shadow: none;
            font-size: 20px;
            text-align: right;
            z-index: 3;
            background-color: transparent !important;
            padding-right: 20px;
        }

        .value_input {
            padding: 2px;
            margin: 0 !important;
            font-size: 12px;
            box-shadow: none;
            height: 22px;
            width: 52px;
            border: solid 1px #e2e6ea;
        }

        .execFooter {
            background: #F6F6F6;
            padding-top: 10px;
            padding-bottom: 10px;
            margin-bottom: 15px;
            margin-top: 10px;
            text-align: center
        }

        .switch-sm {
            line-height: 19px;
            padding-top: 5px;
            width: 102px
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 26px;
            height: 17px;
            margin-bottom: 0;
            margin-right: 5px
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0
        }

        .switch .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s
        }

        .switch .slider:before {
            position: absolute;
            content: "";
            height: 11px;
            width: 11px;
            left: 3px;
            bottom: 3px;
            background-color: #fff;
            -webkit-transition: .4s;
            transition: .4s
        }

        .switch input:checked+.slider {
            background-color: #fbc407
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #fbc407
        }

        .switch input:checked+.slider:before {
            -webkit-transform: translateX(10px);
            -ms-transform: translateX(10px);
            transform: translateX(10px)
        }

        .switch .slider.round {
            border-radius: 26px
        }

        .switch .slider.round:before {
            border-radius: 50%
        }

        .switch input:checked+.slider {
            background-color: #040725
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #040725
        }

    </style>
@endsection
@section('content')
    <div id="blureEffct" class="container">

        <div class="row mt-2 mb-3">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h2 class="_head01">Customers<span> List</span></h2>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <ol class="breadcrumb">
                    <li><a href="#"><span> Customers</span></a></li>
                    <li><span>List</span></li>
                </ol>
            </div>
        </div>

        <div class="row" style="">



            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-4">
                                <h2>View Customers <span> List</span></h2>
                            </div>
                            <div class="col-4">

                            </div>

                        </div>
                    </div>
                    <div class="body">
                        <table class="table table-hover  nowrap table_bodyyyyy" id="customers"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Customer Id</th>
                                    <th>Customer Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td>{{$customer->id}}</td>
                                        <td>{{$customer->company_name}}</td>
                                        <td>
                                            @if(in_array($customer->id , $checkIds))<a href="set-price-for-customer/{{$customer->id}}"><button class="btn btn-default mb-0">Update</button></a>
                                            @else($customer->id)<a href="set-price-for-customer/{{$customer->id}}"><button class="btn btn-default mb-0">Set</button></a>
                                            @endif
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

    @endsection
