@extends('layouts.master')
<style>
    .print-icon-div{text-align: center; padding: 15px;}
    .print-icon-div a{display: inline-block; border: solid 1px #e9ecef; padding: 15px; width: 100%; text-align: center; text-decoration: none; color: #282828; font-size: 13px;}
    .print-icon-div a i{opacity: 0.4;display: block}
    .print-icon-div a:HOVER i, .print-icon-div a:focus i{opacity: 1}
    .print-icon-div a:HOVER{border: solid 1px #040725; color: #040725; box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.3);}
    .print-icon{filter: grayscale(1); width: 45px; opacity: 0.7; display: block; margin: auto; margin-top: 10px; margin-bottom: 15px;}
    .print-icon-div a:HOVER .print-icon{filter:none; opacity: 1;}
    .heading3{margin: 0; font-size: 16px;}
    .select-date, .select-date:focus{box-shadow: none; border: none; background-color:#f6f6f6; font-size: 14px; height: 30px; width: 200px}
    .fa-download{color: #040725; margin-right: 5px;}
    .fa-file-pdf{font-size: 35px; display: block; margin-bottom: 15px; margin-top: 10px;}
</style>
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-6">
        <h2 class="_head01">Performa <span> Management</span></h2>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>All <span> Performas </span></h2>

                    <a href="/Performas/create" class="btn add_button in-btn"><i class="fa fa-plus"></i> <span> Performa</span></a>

            </div>
            <div class="body">
                <table class="table table-hover nowrap" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Issued Date</th>
                            <th>PO Number</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->customer }}</td>
                                    <td>{{ $item->issue_date }}</td>
                                    <td>{{ $item->po_num }}</td>

                                    <td>{{ ucfirst($item->current_status) }}</td>
                                        @if($item->current_status == 'draft')
                                    <td>
                                        <a href="/Performas/{{$item->id}}/edit" class="btn btn-default btn-line">Edit</a>
                                        <button id="{{ $item->id }}" class="btn btn-default approve_performa">Approve</button>
                                        <a id="{{ $item->id }}" target="_blank" href="/get-cbm/{{$item->id}}" class="btn btn-default download_pdf">CBM</a>

                                        <button id="{{ $item->id }}" class="btn btn-default red-bg dis_approve_performa">Disapprove</button>
                                        <button id="{{ $item->id }}" target="_blank" onclick="pdf_modal({{$item->id}})" class="btn btn-default download_pdf">Download PDF</button>

                                        {{--<form id="deletePerformaForm" style="display: inline-block"><input type="text"
                                                name="_method" value="DELETE" hidden=""><input type="text" name="_token"
                                                value="oqlp7k5E694Yndoxh66f1UcgJ6nhuqgpQvkBWsBy" hidden=""><button type="button"
                                                id="{{ $item->id }}" class="btn btn-default deletePerforma"
                                                title="Delete">Delete</button></form>--}}
                                    </td>
                                    @else
                                            <td>

                                                <a id="{{ $item->id }}" target="_blank" href="/get-cbm/{{$item->id}}" class="btn btn-default download_pdf">CBM</a>

                                                <button id="{{ $item->id }}" target="_blank" onclick="pdf_modal({{$item->id}})" class="btn btn-default download_pdf">Download PDF</button>

                                            </td>
                                    @endif
                                </tr>


                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="pdf_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content top_border">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-download"></i> Donwload PDF File<span></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row print-icon-div pb-0 pt-0">
                    <div class="col-6 pl-0">
                        <a href="javascript:void(0)" onclick="getLogoPDF();" class="withLogo"><i class="fas fa-file-pdf"></i> <strong>PDF with logo</strong></a>
                    </div>

                    <div class="col-6 pr-0">
                        <a href="javascript:void(0)" onclick="getNoLogoPDF();" class="withoutLogo"><i class="fas fa-file-pdf"></i> <strong>PDF without logo</strong></a>
                    </div>

                </div>
            </div>
            <input type="text" hidden name="withLogo" id="withLogo" value=""/>
            <input type="text" hidden name="withoutLogo" id="withoutLogo" value=""/>
        </div>
    </div>
</div>
@endsection
