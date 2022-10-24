@extends('layouts.master')
@section('content')
<style>
    .TaskStAction .custom-select:disabled {
        background-color: white
    }

</style>
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Task <span>Management</span></h2>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Task</span></a></li>
            <li><span>List</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a class="modalShowTaskCentralized" class="btn add_button"><i class="fa fa-plus"></i> <span> New
                        Task</span></a>
                <h2>Task <span> List</span></h2>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive nowrap tasksListTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Task Title</th>
                            <th>Created by</th>
                            <th>Due Date</th>
                            <th>Time</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" style="text-align: center; line-height: 3; font-weight: bold">
                                LOADING
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
