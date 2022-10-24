@extends('layouts.master')
@section('content')
<div id="blureEffct" class="container">



    <div class="row mt-2 mb-3">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="_head01">Purchase<span> Orders</span></h2>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb">
                <li><a href="#"><span>Orders</span></a></li>
                <li><span>Purchase Orders</span></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header"> <a id="productlist01" href="/add-purchase-order" class="btn add_button"><i class="fa fa-plus"></i> <span>Add Purchase Order</span></a>
                    <h2>Purchase Order<span> List</span>
                        <div class="_list-total"></div>
                    </h2>
                </div>
                <div class="body">
                    <table class="table table-hover nowrap" id="example" style="width:100%">
                        <thead>
                            <tr>
                                <th>Purchase Date</th>
                                <th>Order Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purhased_orders as $order)
                            <tr>
                                <td>{{$order->purchase_date}}</td>
                                <td>{{$order->order_type == 1 ? "import" : "Local Purchase"}}</td>
                                <td><a href="/view-purchase-order/{{$order->id}}" class="btn smBTN mb-0">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



</div>
@endsection











    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/datatables.min.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.mCustomScrollbar.min.js"></script>


    <script src="js/chart.bundle.min.js"></script>
    <script src="js/echarts-en.min.js"></script>
    <script src="js/echarts-liquidfill.min.js"></script>
    <script src="js/dashboard-data.js"></script>


    <script src="js/custom.js"></script>
    <script>
        $(document).ready(function() {
            $('#example, #example2, #example3, #example4').DataTable();
        });
    </script>
</body>

</html>