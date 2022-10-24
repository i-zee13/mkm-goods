@extends('layouts.master')
@section('data-sidebar')
@endsection

@section('content')
    @php
        error_reporting(0);
        $setting  =   json_decode($integration->setting);
    @endphp
    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Manage <span>Integration</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Manage</span></a></li>
                <li><span>Integration</span></li>
            </ol>
        </div>
    </div>
{{--    <div style="min-height: 400px" id="tblLoader">--}}
{{--        <img src="/images/loader.gif" width="30px" height="auto"--}}
{{--             style="position: absolute; left: 50%; top: 45%;">--}}
{{--    </div>--}}

    <form id="integrationForm" name="integrationForm" method="post" >
        @csrf
        <input type="hidden" name="integrationID" readonly value="{{$integration->id}}">
        <input type="hidden" name="section" readonly value="{{$integration->section}}">
        <input type="hidden" name="type" readonly value="{{$integration->type}}">
        <div class="row" id="MainContent" >
                <div class="col-lg-6">
                    <div class="card">
                        <div class="header">
                            <h2>{{ucfirst($integration->label)}} <span> Credentials (Live)</span></h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Api Key</label>
                                        <input type="text" name="live[api_key]" class="form-control" value="{{$setting->live->api_key}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Sender (Name)</label>
                                        <input type="text" name="live[sender_name]" class="form-control" value="{{$setting->live->sender_name}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Sender (Email)</label>
                                        <input type="text" name="live[sender_email]" class="form-control" value="{{$setting->live->sender_email}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="header">
                            <h2>{{ucfirst($integration->label)}} <span> Credentials (Demo)</span></h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Api Key</label>
                                        <input type="text" name="demo[api_key]" class="form-control" value="{{$setting->demo->api_key}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Sender (Name)</label>
                                        <input type="text" name="demo[sender_name]" class="form-control" value="{{$setting->demo->sender_name}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Sender (Email)</label>
                                        <input type="text" name="demo[sender_email]" class="form-control" value="{{$setting->demo->sender_email}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-s2 pt-19">
                        <label class="control-label mb-10">Status*</label>
                        <select name="status" class="form-control formselect">
                            <option {{$integration->status == 'active'?'selected':''}} value="active">Active</option>
                            <option {{$integration->status != 'active'?'selected':''}} value="inactive">In-active</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <br><br>
                    <div class="row assCatalogue-radio PTm-10 PB-10" id="filters-area">
                        <div class="col-auto pr-400">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="mode" id="live-mode" value="live"  {{$integration->mode == 'live'?'checked':''}}>
                                <label class="custom-control-label font13 pt-1" for="live-mode">Live</label>
                            </div>
                        </div>
                        <div class="col-auto pr-400">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="mode" id="demo-mode" value="demo" {{$integration->mode != 'live'?'checked':''}}>
                                <label class="custom-control-label font13 pt-1" for="demo-mode">Demo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-20">
                    <button type="button" class="btn btn-primary mr-2 save-btn" id="SaveIntegrationBtn" onclick="SaveIntegration()">Save</button>
                </div>
        </div>
    </form>
@endsection

@push('js')
    <script src="/js/custom/integrations.js?v={{ time() }}"></script>
@endpush
