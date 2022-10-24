@extends('layouts.master')
@section('data-sidebar')
<style>
    .dropdown {
        float: right;
        margin-right: 20px
    }
    .remove_click {
        pointer-events: none;
    }
    .colStyle .dropdown:hover .dropdown-menu,
    ._product-card .dropdown:hover .dropdown-menu {
        display: block;
    }
    .dropdown .btn {
        padding: 4px 4px;
        font-size: 12px;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
        -khtml-border-radius: 0;
        text-transform: capitalize;
        background: linear-gradient(90deg, #040725 0%, #040725 100%);
        color: #fff;
        line-height: 1;
        letter-spacing: 1px;
    }

    .dropdown .dropdown-menu {
        min-width: 65px;
        padding: 0;
        margin: 0;
        font-size: 11px;
        border-radius: 0;
    }

    .dropdown .dropdown-item {
        color: #282828;
        padding: 5px 11px;
        letter-spacing: 1px
    }

    .dropdown .dropdown-item:HOVER {
        color: #fff;
        background: linear-gradient(90deg, #040725 0%, #040725 100%);
        outline: none !important;
    }

    #product-cl-sec,
    #product-add {
        width: 600px
    }

    .holder>li {
        padding: 5px;
        margin: 2px;
        display: inline-block;
    }

    .holder>li[data-page] {
        border: solid #dee2e6 1px;
        border-radius: 5px;
        border-radius: 0px;
        font-size: 13px;
        padding: 8px 10px;
        line-height: 1;

    }

    .holder>li[data-page-poc] {
        border: solid #dee2e6 1px;
        border-radius: 5px;
        border-radius: 0px;
        font-size: 13px;
        padding: 8px 10px;
        line-height: 1;

    }

    .holder>li.separator:before {
        content: '...';
    }

    .holder>li.active {
        background: linear-gradient(90deg, #0a0e36 0%, #040725 100%);
        ;
        border-color: #040725;
        color: #fff;
    }

    .holder>li[data-page]:hover {
        cursor: pointer;
    }
    .Product-Filter{
    float: right;
    background-color: transparent;
    padding: 8px 5px 0px 10px;
    box-shadow: none;
    margin-bottom: 0;
    border-bottom: none;
}
.CL-Product {
    width: 320px;
}
._cust_filter {
    width: 220px;
}
._emp-D .doc-img, ._product-card .doc-img {
    width: 30px;
    height: 30px;
    border: none;
    border-radius: 0;
margin-right:10px;

}
._product-card .doc-img{
  margin: auto;
  display: block;
  width: 45px;
    height: 45px;
}
 
.textMiddle {
    display: table-cell;
    vertical-align: middle;
    width: 100%;
}
    @media (max-width:800px) {

        #product-cl-sec,
        #product-add {
            width: 100%
        }
    }

    .cusDetail-th,
    .cusDetail-th:HOVER {
        padding-left: 6px;
        padding-right: 6px;
    }

    ._product-card h2 {
        margin-bottom: 10px;
        text-align: center;
        margin-top: 10px;
    }
</style>
 

@endsection

@section('content')


<div class="modal fade" id="lead_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content top-border">
                <form id="SaveModalStatus">
                    @csrf
                    <input type="hidden" name="lead_id" id="lead_id">
                  
                    <div class="modal-header statusMH">
                        <h5 class="modal-title" id="exampleModalLabel">Status: <span class="modal_lead_name"> </span></h5>
                        <button type="button" class="close-modal" id="close_modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-20">
                        <div class="row">
                            <div class="col-4">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input radio_status draft" type="radio" id="draft_status"
                                        value="1" data-id="draft_status" name="radio_status">
                                    <label class="custom-control-label head-sta" for="draft_status">Draft</label>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input radio_status publish" type="radio" id="publish_status"
                                        value="2" data-id="publish_status" name="radio_status">
                                    <label class="custom-control-label head-sta" for="publish_status"> Publish</label>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input radio_status remove_status" type="radio" id="remove_status"
                                        value="3" data-id="remove_status" name="radio_status">
                                    <label class="custom-control-label head-sta" for="remove_status"> Remove</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary save_status" id="save_status">Save</button>
                        <!--<button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">Cancel</button>-->
                    </div>
                </form>
            </div>
        </div>
        <button hidden data-toggle="modal" data-target="#lead_detail" id="hidden_status_modal"></button>
</div>
 


<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01 mb-15">Course <span>Management</span></h2>
    </div>

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="header-tabs pb-1 mb-10">
            <div class="row">
                <div class="col-auto">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active top-tabs" id="nav-home-tab" type="customer" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Course List<span class="_cus-val count_customers"> 0 </span></a>

                    </div>
                </div>

                <div class="col">
                    <div class="Product-Filter Cus-Filter">
                        <div class="row">
                            <div class="col-auto p-0">
                                <div class="CL-Product"><i class="fa fa-search"></i>
                                    <input type="text" class="form-control dynamic_search" id="" placeholder="Search">
                                </div>
                                <div class="_cust_filter m-0">
                                    <select class="custom-select custom-select-sm dynamic_filter">
                                        <option selected="" value="0">All</option>
                                        <option value="1">Draft</option>
                                        <option value="2">Published</option>
                                        <option value="3">Remove</option>
                                        <!-- <option value="4">Blocked</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto pl-0 top_bar_customer">
                                <!-- <button class="btn btn-addproduct mb-0 bulk_upload_btn" data-toggle="modal" data-target=".bd-example-modal-lg-bulk-customer"><i class="fa fa-upload"></i> Bulk
                                    Upload </button> -->
                                <a href="/add-course" class="btn text-white btn-addproduct mb-0 "><i class="fa fa-plus"></i> Add Course </a>
                                <div class="nav" id="nav-tab" role="tablist"> <a class="nav-item nav-link" id="productthumb-tab" data-toggle="tab" href="#productthumb2" role="tab" aria-controls="productthumb2" aria-selected="false"><i class="fa fa-th-large"></i></a> <a class="nav-item nav-link active" id="productList2-tab" data-toggle="tab" href="#productList2" role="tab" aria-controls="productList2" aria-selected="true"><i class="fa fa-th-list"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-content" id="nav-tabContent">

    {{-- Course List --}}
    <div class="tab-pane fade show active body_sales_agants" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active " id="productList2" role="tabpanel" aria-labelledby="productList2-tab">

                        <div class="Product-row-title">
                            <div class="row">
                                <div class="col colStyle h-auto" style="max-width:355px"> Name</div>
                                <div class="col colStyle h-auto" style="max-width:220px">Duration</div>
                                <div class="col colStyle h-auto" style="max-width:220px">Youtube Link</div>
                                <div class="col colStyle h-auto" style="max-width:150px">Status</div>
                                <div class="col colStyle h-auto" style="max-width:180px">Action</div>
                            </div>
                        </div>
                        <div style="min-height: 400px" class="tblLoader">
                            <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                        </div>
                        <div class="cust_list_div">
                        </div>
                    </div>
                    <div class="tab-pane fade " id="productthumb2" role="tabpanel" aria-labelledby="productthumb2-tab">
                        <div style="min-height: 400px" class="tblLoader">
                            <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
                        </div>
                        <div class="row PT-15 cust_grid_div">
                        </div>
                    </div>
                </div>
                <div class="ProductPageNav text-center">
                    <div id="cust_holder" class="holder" style="position: relative; "></div>
                    {{-- <ul class="pagination justify-content-center pagination_cust">
                       
                    </ul> --}}
                </div>
            </div>
        </div>
    </div>



</div>
@endsection