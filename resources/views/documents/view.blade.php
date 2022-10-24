@extends('layouts.master')
@section('data-sidebar')
    <style>
        .pocPROFILE {
            font-size: 14px;
            padding: 15px 20px;
            line-height: 22px
        }

        .pocPROFILE h3 {
            font-size: 18px;
            margin: 0
        }

        .pocPROFILE h2 {
            font-size: 15px
        }

        .pocPROFILE .form-control,
        .pocPROFILE .custom-select-sm,
        .pocPROFILE .form-s2 .select2-container .select2-selection--single {
            box-shadow: none;
            height: 33px;
            background-color: #fff;
            border: solid 1px #e5e5e5;
            border-radius: 0;
            font-size: 13px;
        }

        .pocPROFILE .infoDiv {
            background-color: #f9f9f9;
            padding: 5px;
            margin-bottom: 8px;
        }

        .pocPROFILE .infoDiv .control-label {
            font-size: 14px;
            color: #7d7d7d !important;
            line-height: normal;
            margin-bottom: 0
        }

        .pocPROFILE .infoDiv strong {
            font-size: 16px;
            color: #282828;
            line-height: normal;
            margin-bottom: 0
        }

        .pocPROFILE .p-col-L {
            padding-right: 4px
        }

        .pocPROFILE .p-col-R {
            padding-left: 4px
        }


        .pocPROFILE .btn-primary,
        .pocPROFILE .btn-cancel {
            font-size: 13px
        }


        .btn-edit-p {
            padding: 6px 14px 6px 14px;
            letter-spacing: 1px;
            font-size: 13px;
            line-height: 1;
            margin-top: -5px;
            float: right;
            margin-left: 10px
        }

        .btn-edit-line {
            color: #040725;
            background: #fff;
            border: 1px solid #040725;
        }


        .btn-primary {
            letter-spacing: 1px
        }
        .Witness-div {
            padding-bottom:20px;
        }
        .Witness-div .alert {
            color: #282828;
            background-color: #F4F4F4;
            border-color: #F0F0F1;
            font-size: 14px;
            line-height: 1;
            padding: 6px;
            border-radius: 0;
            display: inline-block;
            padding-right: 25px;
            width: 100% !important;
            margin-bottom: 12px;
        }
        .Witness-div .alert strong {
            padding-right: 10px;
        }
        .Witness-div .alert button {
            position: absolute;
            top: -4px;
            right: 3px;
        }

    </style>


    <div id="product-cl-sec">
        <a href="#" id="pl-close" class="close-btn-pl"></a>
        <div class="pro-header-text">Add <span>Witness</span></div>

        <div class="pc-cartlist">

            <div class="overflow-plist">

                <div class="plist-content">

                    <div class="_left-filter">

                        <div class="container">

                            <div class="row">

                                <div class="col-12">
                                    <div id="floating-label" class="card p-20 top_border mb-3">

                                        <h2 class="_head03">Witness <span>Details</span></h2>

                                        <div class="form-wrap p-0 PT-10">

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Name *</label>
                                                        <input type="text" id="witness-name" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Address</label>
                                                        <input type="text" id="witness-address" class="form-control" placeholder="">
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
            <button type="button" class="btn btn-primary mr-2 save-witness">Save</button>
            <button id="pl-close" type="submit" class="btn btn-cancel mr-2">Cancel</button>
        </div>


    </div>
    @endsection
@section('content')

    <div class="row mt-2 mb-2">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">{{@$intakeformtype->name}}<span></span></h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <button id="productlist01"  class="btn btn-primary btn-edit-p"><i class="fa fa-plus"></i> Add Witness</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form id="intake-documnet" method="post" action="{{url('/intake-form-document-print/'.@$intakeformtype->id)}}" >
                    <div class="body pocPROFILE">
                        <div class="row">
                                @csrf
                                <div class="col-12">
                                    <div class="form-wrap p-0">
                                        <div class="row">
                                            <div class="col-md-3 p-col-L">
                                                <div class="infoDiv">
                                                    <label class="control-label mb-5">Client Name</label>
                                                    <p><strong>{{@$client->first_name}} {{@$client->middle_name}} {{@$client->last_name}}</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-3 p-col-L p-col-R">
                                                <div class="infoDiv">
                                                    <label class="control-label mb-5">Email</label>
                                                    <p><strong>{{@$client->email}}</strong></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 p-col-R">
                                                <div class="infoDiv">
                                                    <label class="control-label mb-5">Gender</label>
                                                    <p><strong>{{@$client->gender_name}}</strong></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 p-col-L p-col-R">
                                                <div class="infoDiv">
                                                    <label class="control-label mb-5">Submitted At</label>
                                                    <p><strong>{{dateTimeFormat(@$client->submitted_at)}}</strong></p>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                                <div class="col-12 PT-15">
                                    <div class="header">
                                        <h2>POWER OF ATTORNEY FOR PERSONAL CARE <span></span></h2>
                                    </div>
                                </div>
                                <div class="col-12 PT-15">
                                    <textarea name="document" id="ckeditor">{{@$document}}</textarea>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="margin-top: 20px">
                                <div class="header pt-0 mb-10">
                                    <h2>Witness List<span></span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12  Witness-div">

                        </div>
                    </div>
                    <div class="col-md-12 text-right PB-15">
                    <button type="button" class="btn btn-primary mr-2 print_pdf">Print</button>
                    <a href="{{route('intake-forms')}}" class="btn btn-cancel">Cancel</a>
                </div>

                </form>
            </div>

        </div>




    </div>





@endsection

@push('js')
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script src="/js/custom/intake-form-documents.js"></script>
    <script>
        @if (\Session::has('error'))
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('{{\Session::get('error')}}');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 5000);
        @endif
    </script>
@endpush