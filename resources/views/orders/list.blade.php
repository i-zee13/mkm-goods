@extends('layouts.master')
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-6">
        <h2 class="_head01">Performa <span> Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-6">
        <a href="/Performas/create" class="btn add_button in-btn"><i class="fa fa-plus"></i> <span> Performa</span></a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>All <span> Performas </span></h2>
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
                            @if($item->current_status == 'draft')
                                <tr>
                                    <td>{{ $item->customer }}</td>
                                    <td>{{ $item->issue_date }}</td>
                                    <td>{{ $item->po_num }}</td>
                                    <td>{{ ucfirst($item->current_status) }}</td>
                                    <td>
                                        <a href="/Performas/{{$item->id}}/edit" class="btn btn-default btn-line">Edit</a>
                                        <button id="{{ $item->id }}" class="btn btn-default approve_performa">Approve</button>
                                        {{--<form id="deletePerformaForm" style="display: inline-block"><input type="text"
                                                name="_method" value="DELETE" hidden=""><input type="text" name="_token"
                                                value="oqlp7k5E694Yndoxh66f1UcgJ6nhuqgpQvkBWsBy" hidden=""><button type="button"
                                                id="{{ $item->id }}" class="btn btn-default deletePerforma"
                                                title="Delete">Delete</button></form>--}}
                                    </td>
                                </tr>
                                @endif

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
