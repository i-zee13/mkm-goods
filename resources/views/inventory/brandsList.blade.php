@extends('layouts.master')
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Products <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Brands List</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Brands List</h2>
            </div>
            <div class="body">
                <table class="table table-hover dt-responsive nowrap" id="brandsTable" style="width:100% !important;">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Brand ID</th>
                            <th>Brand Name</th>
                            <th>Total Products</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sno = 1; ?>
                        @foreach ($brands as $b)
                        <tr>
                            <td> {{$sno++}} </td>
                            <td> {{$b->brand_custom_id}} </td>
                            <td> {{$b->brand_name}} </td>
                            <td> {{$b->totalProducts}} </td>
                            <td>
                                <a href="/BrandProducts/{{ $b->id }}" class="btn btn-default btn-line">View Products</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
