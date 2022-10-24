@extends('layouts.master')
@section('data-sidebar')
@endsection
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Recipes</h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Assign Recipes</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <input type="hidden" name="recipe_id" id="recipe_id" value="{{$id}}">
            <div class="header">
                {{--<a class="btn add_button" href="{{route('AddRecipes')}}"><i class="fa fa-plus"></i> New Recipe</a>--}}
                <h2>Product List</h2>
                <a class="btn add_button" href="{{url('Recipes')}}"><i class="fa fa-plus"></i> Submit</a>

            </div>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="ProBody p-20">

                <table class="table table-hover nowrap ProductTable" style="width:100%;">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>SKU</th>
                        <th>Item Name</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($proData as $data)

                            <tr>
                                <td>{{$data->item_item_id}}</td>
                                <td>{{$data->sku}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->product_name}}</td>
                                <td>{{$data->description}}</td>

                                @if($id == $data->recipe_id && $data->item_item_id == $data->item_id && $data->pro_product_id == $data->product_id)
                                    <td><button type="button" id="assign_{{$data->item_item_id}}" class="btn btn-default red-bg" onclick="DelAssignToRecipe({{$data->item_item_id}},{{$data->pro_product_id}});" title="Assign">Remove</button></td>

                                        @else
                                            <td><button type="button" id="assign_{{$data->item_item_id}}" class="btn btn-default" onclick="assignToRecipe({{$data->item_item_id}},{{$data->pro_product_id}});" title="Assign">Assign</button></td>
                                @endif

                            </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>
@endsection
