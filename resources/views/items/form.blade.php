@extends('layouts.master')
@section('data-sidebar')
    {{--<div id="product-cl-sec">
        <a href="#" id="pl-close" class="close-btn-pl"></a>
        <div class="pro-header-text">New <span>Service</span></div>
        <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
            <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
        </div>
        <div class="pc-cartlist">
            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter pt-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <form style="display: flex;" id="saveIngredientsForm">
                                        @csrf
                                        <input type="text" id="operation" hidden>
                                        <input type="text" name="ingredients_id" hidden>
                                        <div id="floating-label" class="card p-20 top_border mb-3" style="width: 100%">
                                            <h2 class="_head03">Ingredients <span>Details</span></h2>
                                            <div class="form-wrap p-0">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label mb-10">Ingredients Name*</label>
                                                            <input type="text" name="ingredients_name" class="form-control"
                                                                   required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="_cl-bottom">
            <button type="submit" class="btn btn-primary mr-2" id="saveIngredients">Save</button>
            <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelIngredients">Cancel</button>
        </div>
    </div>--}}
    <style>
        .text-filed{height: 24px;margin: 0;border: solid 1px #dddddd;box-shadow: none; margin-top: -1px;
            width: 100px; font-size: 12px; padding-left: 8px; padding-right: 10px;}
        .p-spec-table td, .p-spec-table th, .modal-body table th, .modal-body table td{padding-right:20px!important; padding-left: 10px!important}
        .p-spec-table td, .p-spec-table table td{padding-right:10px!important; padding-left: 10px!important; padding-top: 5px; padding-bottom: 8px;}
        .b-valuse{background-color: #f3f3f3; padding: 8px; margin-top: 5px; font-size: 16px;}
        .pt-25{padding-top: 25px!important}
        .pt-28{padding-top: 28px!important}
        .mt-19{margin-top:19px}

        .recipeSearch {
            position: relative;
        }
        .recipeSearch input {
            height: 32px;
            border: solid 1px #eae9e9;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            padding-left: 30px;
            font-size: 13px;
            letter-spacing: 1px;
        }
        .recipeSearch .fa {
            position: absolute;
            top: 8px;
            left: 8px;
            color: #b5b5b5;
        }
        .AddItemsTable {
            padding: 0;
            margin: 0
        }
        .AddItemsTable tr {
            border-bottom: solid 1px #eeeeee
        }
        .AddItemsTable td {
            padding-bottom: 7px;
            padding-top: 7px
        }
        .RecipeListDiv {
            padding: 0;
            display: table;
        }
        .RecipeListDiv .PR_Name {
            display: table-cell;
            vertical-align: middle;
            font-size: 14px;
            letter-spacing: 1px;
            line-height: 16px
        }
        .RecipeListDiv .PrList_img {
            width: 35px;
            height: 35px;
            margin-right: 8px;
            border: solid 1px #e0e0e0
        }
        .AddItemsTable .btn-default {
            padding: 5px 8px;
            font-size: 13px;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            -khtml-border-radius: 0;
            background: linear-gradient(90deg, #1e54d3 0%, #040725 100%);
            color: #fff;
            text-align: center;
            margin: 0;
            line-height: 1;
            min-width: 74px;
            letter-spacing: 1px;
            float: right;
            border: none!important
        }
        .AddDetailPR {
            padding: 25px;
            font-size: 14px
        }
        .AddDetailPR .form-control {
            height: 32px;
            border: solid 1px #dedede;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            padding: 0px 10px;
            font-size: 13px;
            letter-spacing: 1px;
        }
        .AddDetailPR select {
            border-radius: 0;
            padding: 0px 10px;
            height: 32px;
            border: solid 1px #dedede;
            font-size: 14px
        }

        .se_cus-type .form-control, .se_cus-type .form-s2 .select2-container .select2-selection--single {
            border: 1px solid #eeeeee;
            background-color: #fff;
        }
    </style>
    <div id="product-cl-sec"> <a href="#" id="pl-close" class="close-btn-pl"></a>
        <div class="pro-header-text">Add <span>Ingredients</span></div>
        <div class="se_cus-type form-wrap p-15">
            <div class="row">
                <div class="col-12">
                    <div class="recipeSearch"><i class="fa fa-search"></i>
                        <input type="text" class="form-control" id="" placeholder="Search">
                    </div>
                </div>
            </div>
        </div>
        <div class="pc-cartlist">
            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter pt-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card top_border p-15">
                                        <table class="AddItemsTable" width="100%">
                                            <tbody>
                                            @foreach($recipes as $recipe)
                                                <tr>
                                                    <td width="80%"><div class="ItemsListDiv">
                                                            <div id="{{$recipe->id}}" class="PR_Name">{{$recipe->ingredients_name}}</div>
                                                        </div></td>
                                                    <td><button id="ingAdd_{{$recipe->id}}" onclick="addIng('{{$recipe->id}}','{{$recipe->ingredients_name}}');" class="btn btn-default mb-0">Add</button></td>
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
            </div>
        </div>
        <div class="_cl-bottom">
            <button type="submit" class="btn btn-primary mr-2 addIngBtn">Add</button>
            <button id="pl-close" type="submit" class="btn btn-cancel mr-2">Cancel</button>
        </div>
    </div>
@endsection
@section('content')
    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Add Item</h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span> Add Item</span></a></li>
                <li><span>Active</span></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    {{--<a class="btn add_button openDataSidebarForAddingIngredients"><i class="fa fa-plus"></i> New Ingredients</a>--}}
                    <h2>Ingredients List</h2>
                </div>
                <div id="floating-label" class="row m-0">
                    <div class="form-wrap pb-0 PT-10">
                        <div class="row m-0">
                            @csrf
                            <div class="col-3 pr-0">
                                <div class="form-group">
                                    <label class="control-label mb-10">Item Name</label>
                                    <input type="text" id="item_recipe_name" name="item_recipe_name" class="form-control" placeholder="">
                                </div>
                            </div>

                            <div class="col-3 pr-0">
                                <button id="productlist01" type="submit" class="btn btn-primary mt-19">Add Ingredients</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                            <div style="min-height: 400px" id="tblLoader">
                                <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                            </div>
                        <div class="addBody p-20">


                        </div>
                        <div class="col-md-12 p-0">
                            <div style="background-color: #f6f6f6; padding: 15px; margin-top: 15px; margin-bottom: 0px; text-align: center; margin-bottom: 1px">
                                <button type="submit" class="btn btn-primary mr-2 saveIngForm">Save</button>
                                <button id="pl-close" type="submit" class="btn btn-cancel mr-2">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

