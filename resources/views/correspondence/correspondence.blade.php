@extends('layouts.master')
@section('data-sidebar')
<style>
    ._sa-customer .form-s2 .select2-container .select2-selection--single {
        background-color: #f6f6f6;
    }

</style>
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span>Correspondence</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <form style="display: flex;" id="saveCorrespondenceForm">
                                    @csrf
                                    <input type="text" id="operation" hidden>
                                    <input type="text" name="correspondence_id" hidden>
                                    <div id="floating-label" class="card p-20 top_border mb-3" style="width: 100%">
                                        <h2 class="_head03">Correspondence <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect" name="prospect_customer"
                                                            placeholder="select Parent Company">
                                                            <option value="0">Select Prospect Customer *</option>
                                                            @foreach ($prospects as $p)
                                                            <option value="{{ $p->id }}">{{ $p->company_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 pt-19">
                                                    <div class="_sa-customer" style="padding: 0; max-width: 100%">
                                                        <div class="form-s2 selpluse">
                                                            <select class="form-control formselect"
                                                                placeholder="select Medium" name="mediumDD"
                                                                id="mediumsSelect2">
                                                                <option value="0">Select Medium *</option>
                                                                @foreach ($mediums as $m)
                                                                <option value="{{ $m->id }}">{{ $m->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <a data-toggle="modal" id="addNewMedium"
                                                                data-target=".AddDynamicStagesMediums" style="right: 0;"
                                                                class="btn plus_button po-ab productlist01 _OA-disply openDataSidebarForAddingCustomer"><i
                                                                    class="fa fa-plus"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pt-19">
                                                    <div class="_sa-customer" style="padding: 0; max-width: 100%">
                                                        <div class="form-s2 selpluse">
                                                            <select class="form-control formselect"
                                                                placeholder="select Stage" name="stageDD"
                                                                id="stagesSelect2">
                                                                <option value="0">Select Stage *</option>
                                                                @foreach ($stages as $s)
                                                                <option value="{{ $s->id }}">{{ $s->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <a data-toggle="modal" id="addNewStage"
                                                                data-target=".AddDynamicStagesMediums" style="right: 0;"
                                                                class="btn plus_button po-ab productlist01 _OA-disply openDataSidebarForAddingCustomer"><i
                                                                    class="fa fa-plus"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 pt-19">
                                                    <label class="font12">Follow Up</label>
                                                    <input type="text" name="follow_up" class="datepicker form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 pt-30">
                                                    <label class="font12">Minutes of meeting *</label>
                                                    <textarea id="mom" name="moms" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="row" id="dynamicConcerns">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2" id="saveCorrespondence">Save</button>
        <button type="submit" class="btn btn-primary mr-2" id="addConcern">Add Concern</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancel">Cancel</button>
    </div>
</div>
@endsection
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Correspondence</h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Correspondence</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a class="btn add_button" style="margin-right: 200px; display: none" id="showGrouped"><i
                        class="fa fa-arrow-left"></i> Back</a>
                <a class="btn add_button openDataSidebarForAddingCorrespondence"><i class="fa fa-plus"></i> New
                    Correspondence</a>
                <h2>Correspondence List</h2>
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
