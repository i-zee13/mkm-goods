@extends('layouts.master')
@section('content')

{{-- Modal --}}
<div class="modal fade bd-example-modal-sendMail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title _head03" id="exampleModalLongTitle">Enter <span>Email</span></h5>
                <button type="button" class="close close_excel_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="floating-label" class="form-wrap p-10 pt-0 pb-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label mb-10">Email*</label>
                                <input name="excel_email" id="excel_email" placeholder="email@email.com"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-0 pt-19">
                        <button type="button" class="btn btn-primary send_excel_email">Send Mail</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Products <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Items List</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Items List</h2>
                {{-- <a href="/" class="btn send_excel_email add_button" data-toggle="modal" data-target=".bd-example-modal-sendMail"><i
                    class="fa fa-plus"></i> Send Mail</a> --}}
                <button class="btn send_excel_email add_button"><i class="fa fa-plus"></i> Download</button>
                <div class="_dash-select" style="margin-right:120px">
                    <select class="custom-select custom-select-sm brand_filter">
                        <option selected value="0">All Brands</option>
                        @foreach ($brands as $data)
                            <option value="{{$data->id}}">{{$data->brand_name}}</option> 
                        @endforeach 
                    </select>
                </div>
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
