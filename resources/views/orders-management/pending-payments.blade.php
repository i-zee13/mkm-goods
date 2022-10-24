@extends('layouts.master')
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Orders <span>Management</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Pending Payments</span></a></li>
            <li><span>List</span></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="header">
                <button class="btn add_button openRecAdvModal" data-toggle="modal"
                    data-target="#receiveAdvanceModal">Receive
                    Advance</button>
                <h2>Orders List</h2>
            </div>

            <div class="body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <table class="table table-hover dt-responsive nowrap recPaymTbld" style="width:100% !important">
                            <thead>
                                <tr>
                                    <th>Issued Date</th>
                                    <th>Customer</th>
                                    <th>Employee</th>
                                    <th>PO Number</th>
                                    <th>Discount</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $o)
                                <tr>
                                    <td>{{ $o->issue_date }}</td>
                                    <td>{{ $o->company_name }}</td>
                                    <td>{{ $o->name }}</td>
                                    <td>{{ $o->po_num }}</td>
                                    <td>{{ $o->currency_symbol.number_format(ROUND($o->discount_value)) }}</td>
                                    <td>{{ $o->currency_symbol.number_format(ROUND($o->total_amount - $o->discount_value)) }}
                                    </td>
                                    <td>{{ ucfirst($o->current_status) }}</td>
                                    <td>
                                        @if($o->payment_received == 0 && $o->current_status == 'completed')
                                        <button order-id="{{ $o->id }}"
                                            due="{{ ($o->total_amount - $o->discount_value) - $o->paid_amt }}"
                                            symbol="{{ $o->currency_symbol }}" adv-pmt={{ $o->advance }}
                                            balance="{{ $o->balance }}" class="btn btn-default receiveAllPayments"
                                            data-toggle="modal" data-target="#exampleModal">Receive Payment</button>
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
    </div>
</div>
@endsection
