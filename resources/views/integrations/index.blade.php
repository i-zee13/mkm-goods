@extends('layouts.master')
@section('data-sidebar')
@endsection
@section('content')
    <style>
        .reportCard h3 {
            font-size: 15px;
            text-align: center;
            letter-spacing: 1px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            position: relative;
            margin: 0;
            text-align: center;
            width: 100%;
        }

        .box-sec:HOVER {
            background: linear-gradient(0deg, #fff 0%, #fff 100%);
            color: #040725;
        }
        .box-sec:HOVER .img-svg img {
            filter: none;
        }
    </style>
    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Third Party <span> Integrations</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Integration</span></a></li>
                <li><span>Management</span></li>
            </ol>
        </div>
    </div>

    <div class="row _dash-card p-0">
        <div class="col-lg-12">
            <h2 class="_head01 mt-5 mb-15">Email <span> Integrations</span></h2>
        </div>
        @foreach($integrations as $row)
            @if($row->section == 'email')
                <div class="col-md-2">
                    <a href="{{route("integration",['id'=>$row->id])}}" class="box-sec d-flex align-content-center flex-wrap reportCard">
                        <span class="img-svg"><img src="/images/{{$row->icon}}" alt=""></span>
                        <h3>{{ucfirst($row->label)}}</h3>
                    </a>
                </div>
            @endif
        @endforeach

        <div class="col-lg-12">
            <h2 class="_head01 mt-5 mb-15">Payment <span> Integrations</span></h2>
        </div>
        @foreach($integrations as $row)
            @if($row->section == 'payment')
                <div class="col-md-2">
                    <a href="{{route("integration",['id'=>$row->id])}}" class="box-sec d-flex align-content-center flex-wrap reportCard">
                        <span class="img-svg"><img src="/images/{{$row->icon}}" alt=""></span>
                        <h3>{{ucfirst($row->label)}}</h3>
                    </a>
                </div>
            @endif
        @endforeach
    </div>

@endsection
