@extends('layouts.master')
@section('data-sidebar')
<style>
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


{{-- Modal Bulk Upload Customer --}}
<div class="modal fade bd-example-modal-lg-bulk-customer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content top_border">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Bulk <span> Upload</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 bulksection p-0">
                    <div id="floating-label">
                        <div class="form-wrap p-0">

                            <a href="/download-sample-teacher" class="sample_download_link"> 
                                <button type="button" class="btn btn-primary font13" style="margin-bottom:15px; margin-top: 10px">Sample Download</button>
                            </a>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload Excel</span>
                                </div>
                                <div class="custom-file">
                                    <form method="POST" enctype="multipart/form-data" id="upload_excel_form">
                                        @csrf
                                        <input type="file" name="file" class="custom-file-input excel_file_input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label file_name" for="inputGroupFile01">Choose file</label>
                                            
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div style="display:none" class="alert alert-danger error_message_div" role="alert"> <strong>Failed!
                        </strong> Following Teachers are not added due to wrong formatting </div>
                    <div class="table-responsive not_uploadable_client_table">
                    </div>
                </div>
                <div class="modal-footer  border-0 p-0">
                    <button type="button" class="btn btn-cancel close_modal" data-dismiss="modal" aria-label="Close">Close</button>
                    <button type="button" class="btn btn-primary upload_excel_file_btn">Bulk Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Select Type Modal --}}
<div class="modal fade" id="poc_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content top-border">
            <div class="modal-header statusMH">
                <h5 class="modal-title" id="exampleModalLabel">Status: <span class="modal_poc_name"> </span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-20">
                <div class="row">
                    <div class="col-6 status-sh">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="active_status" value="active" data-id="active_status" name="radio_status" checked>
                            <label class="custom-control-label head-sta" for="active_status"> Active</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh StDeactive">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="deactive_status" value="deactive" data-id="deactive_status" name="radio_status">
                            <label class="custom-control-label head-sta" for="deactive_status"> Deactive</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh StLead">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="hid002" value="lead" data-id="hid002" name="radio_status">
                            <label class="custom-control-label head-sta" for="hid002"> Lead</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh StProspect">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="hid003" value="prospect" data-id="hid003" name="radio_status">
                            <label class="custom-control-label head-sta" for="hid003"> Prospect</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh StCustomer">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="hid004" value="customer" data-id="hid004" name="radio_status">
                            <label class="custom-control-label head-sta" for="hid004"> Customer</label>
                        </div>
                    </div>

                    <div class="col-6 status-sh STChurned">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input radio_status" type="radio" id="hid005" value="churned" data-id="hid005" name="radio_status">
                            <label class="custom-control-label head-sta" for="hid005"> Churned</label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary save_status">Save</button>
                <!--<button type="submit" class="btn btn-cancel" data-dismiss="modal" aria-label="Close">Cancel</button>-->
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01 mb-15">Teacher <span>Management</span></h2>
    </div>

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="header-tabs pb-1 mb-10">
            <div class="row">
                <div class="col-auto">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active top-tabs" id="nav-home-tab" type="customer" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Teachers List<span class="_cus-val count_customers"> 0 </span></a>

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
                                        <option value="1">Active</option>
                                        <option value="2">In Active</option>
                                        <option value="3">Churnned</option>
                                        <option value="4">Blocked</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto pl-0 top_bar_customer">
                                <a class="btn btn-addproduct  mb-0" href="/import-instructors"><i class="fa fa-upload"></i> Bulk
                                    Upload </a>
                                <a href="/teacher-create" class="btn text-white btn-addproduct mb-0 "><i class="fa fa-plus"></i> Add Teacher </a>
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

    {{-- Teacher List --}}
    <div class="tab-pane fade show active body_sales_agants" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active " id="productList2" role="tabpanel" aria-labelledby="productList2-tab">

                        <div class="Product-row-title">
                            <div class="row">
                                <div class="col colStyle h-auto" style="max-width:355px"> Name</div>
                                <div class="col colStyle h-auto" style="max-width:220px">Country</div>
                                <div class="col colStyle h-auto" style="max-width:2200px">Email</div>
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