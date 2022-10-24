@extends('layouts.master')
@section('content')
    <style>
        .pt-7 {
            padding-top: 7px !important
        }

        .mb-4 {
            margin-bottom: 4px !important
        }

        .font11 {
            font-size: 11px !important
        }

        .headingDB {
            padding: 15px 20px !important;
            margin-left: -5px
        }

    </style>

    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Import <span> {{$page['page_header']}}</span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>{{$page['page_header']}}</span></a></li>
                <li><span>Upload</span></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card mb-30">
                <div class="header">
                    <h2>Upload <span> {{$page['page_header']}}</span></h2>
                    <a href="{{url('/modules/imports/samples/'.$page['sample-url'])}}" download class="btn add_button "><i class="fa fa-download"></i> <span>Download Sample</span></a>
                </div>
                <div class="body PT-15">
                    <div id="floating-label">
                        <div class="form-wrap p-0">
                            <form id="upload-file" enctype="multipart/form-data">
                            <!-- action="{{url($page['url'])}}" method="POST"  -->
                            <input type="hidden" id='form_action' action="{{$page['url']}}" >
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="file" name="file" id="input-file-now" class="dropify" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required / >
                                    </div>
                                    <div class="col-12 PT-10 text-right">
                                        <button type="button" class="btn btn-primary m-0 mt-5 save_new_distributor">Upload</button>
                                        <a href="/" class="btn btn-primary m-0 mt-5 ml-2 btn-cancel">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card mb-30 error_card"  style="display: none"></div>
        </div>

    </div>


@endsection

@push('js')
    <script src="/modules/imports/js/imports.js"></script>
@endpush