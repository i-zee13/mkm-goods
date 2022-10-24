@extends('layouts.master')
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Customers <span>Assignment</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Customer</span> Assignment</a></li>
            <li><span>List</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Customer <span> Assignment</span></h2>
            </div>
            <div class="body PB-10">
                <div class="row">
                    <div class="col-auto pt-5 font15">Employee</div>
                    <div class="col-md-5">
                        <div class="form-s2">
                            <select class="form-control formselect" placeholder="Select Employee" id="empForAssignment">
                                <option selected disabled>Select Employee</option>
                                @foreach ($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <button style="cursor: pointer" class="viewAssign" id="viewAssign" data-toggle="modal"
                            data-target="#customerAssignmentModal">No
                            Assignments</button>
                    </div>
                </div>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive nowrap" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Customer Type</th>
                            <th>Life Cycle Stage</th>
                            <th>Country</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $item)
                        <tr>
                            <td>{{ $item->company_name }}</td>
                            <td>{{ $item->customer_type ? $item->customer_type : "NA" }}</td>
                            <td>{{ ucfirst($item->life_cycle_stage) }}</td>
                            <td>{{ $item->country ? $item->country : "NA" }}</td>
                            <td>
                                @if ($item->assigned_to)
                                <button class="btn btn-default" disabled>Assigned</button>
                                @else
                                <button class="btn btn-default assignCustomer"
                                    customer="{{ $item->id }}">Assign</button>
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
<div class="Action_bottom OR-PB" style="z-index: 100">
    <div class="container-fuild p-0">
        <div class="row">
            <div class="col-12 text-right pt-19" >
                <a id="saveAssignments" class="btn btn-primary mr-2" style="color:white !important">Save</a>
                <a href="/" class="btn btn-primary btn-cancel">Cancel</a></div>
        </div>
    </div>
</div>
<script>
    let assignmentCustomers = '{!! json_encode($customers) !!}';
    assignmentCustomers = JSON.parse(assignmentCustomers);

</script>
@endsection
