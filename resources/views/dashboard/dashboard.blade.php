@extends('layouts.master')
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <h2 class="_head01">Dashboard <span></span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="Datefilter-Dash dashboard_date_filter" style="display:none">
            <div><input type="text" class="form-control datepicker" id="end_date" placeholder="End Date"
                    style="font-size: 13px"></div>
            <div><input type="text" class="form-control datepicker" id="start_date" placeholder="Start Date"
                    style="font-size: 13px"></div>
        </div>
        <div class="_dash-select">
            <select class="custom-select custom-select-sm dashboard_filter">
                <option selected value="1">Current Month</option>
                <option value="2">Last Month</option>
                <option value="3">Custom</option>
                <option value="4">Overall</option>
            </select>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-5 col-12">
        <div class="row">
            <div class="col-md-6 mb-30">
                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/totalreveneue.svg" alt="" /></div>
                    <h5 class="text-muted">Total Reveneue</h5>
                    <h3 class="cp-stats-value dashboard_avg_rev">Loading...</h3>
                    <p class="mb-0"></p>
                </div>
            </div>

            <div class="col-md-6 mb-30">

                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/totalbookings.svg" alt="" /></div>
                    <h5 class="text-muted">Total Orders</h5>
                    <h3 class="cp-stats-value dashboard_ttl_orders">Loading...</h3>
                    <p class="mb-0"></p>
                </div>

            </div>

            <div class="col-md-6 mb-30">

                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/active-cust.svg" alt="" /></div>
                    <h5 class="text-muted">Active Customers</h5>
                    <h3 class="cp-stats-value dashboard_active_cust">Loading...</h3>
                    <p class="mb-0"></p>
                </div>

            </div>

            <div class="col-md-6 mb-30">

                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/avg-rv-cust.svg" alt="" /></div>
                    <h5 class="text-muted">AVG. REV. / Cust</h5>
                    <h3 class="cp-stats-value dashboard_avg_rev_perCust">Loading...</h3>
                    <p class="mb-0"></p>
                </div>

            </div>

        </div>

    </div>
    <div class="col-lg-7 col-12 mb-30">
        <div class="card _grap-bar pt-0">
            <div class="mt-3 chartjs-chart">
                <div id="e_chart_1" class="e_chartM"></div>
            </div>
        </div>
    </div>
</div>

<div class="card _grayB mb-30">
    <div class="row m-0">
        <div class="col-md-4 _amState">
            <p>Total Outstanding Payment</p>
            <h3> <small class="fa fa-circle align-middle text-primary"> </small> <span
                    class="dashboard_outstanding_paymnet">Loading...</span></h3>
        </div>
        <div class="col-md-4 _amState BLight _borL B_border">
            <p>Amount Received </p>
            <h3><small class="fa fa-circle align-middle text-success"> </small> <span
                    class="dashboard_amount_rec">Loading...</span></h3>
        </div>

        <div class="col-md-4 _amState _borL">
            <p>Pending Amount</p>
            <h3><small class="fa fa-circle align-middle text-danger"> </small> <span
                    class="dashboard_pend_amt">Loading...</span></h3>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-9 mb-30">
        <div class="card _grap-bar">
            <canvas id="line-chart-example" class="line-chart"></canvas>
        </div>
    </div>

    <div class="col-md-3 mb-30">
        <div class="row _RVperDay">

            <div class="col-12">
                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/avg-revenue.svg" alt="" /></div>
                    <h3 class="cp-stats-value dashboard_avg_revPerDay">Loading...</h3>
                    <h5 class="text-muted">AVG Revenue Per Day</h5>
                </div>
            </div>

            <div class="col-12">
                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/avg-revenue-shipment.svg" alt="" /></div>
                    <h3 class="cp-stats-value dashboard_avg_revPerOrder">Loading...</h3>
                    <h5 class="text-muted">AVG Revenue Per Order</h5>
                </div>
            </div>

            <div class="col-12">
                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/avg-shipment-day.svg" alt="" /></div>
                    <h3 class="cp-stats-value dashboard_avg_orderPerDay">Loading...</h3>
                    <h5 class="text-muted">AVG Order Per Day</h5>
                </div>
            </div>

            <div class="col-12">
                <div class="card cp-stats">
                    <div class="cp-stats-icon"><img src="/images/weight-shipment.svg" alt="" /></div>
                    <h3 class="cp-stats-value dashboard_avg_weightPerOrder">Loading...</h3>
                    <h5 class="text-muted">AVG Weight Per Order</h5>
                </div>
            </div>

            <div class="col-12">
                <div class="card cp-stats border-0">
                    <div class="cp-stats-icon"><img src="/images/avg-delivery-time.svg" alt="" /></div>
                    <h3 class="cp-stats-value dashboard_avg_deliveryTime">Loading...</h3>
                    <h5 class="text-muted">AVG Delivery Time</h5>
                </div>
            </div>

        </div>
    </div>

</div>


<div class="row">
    <div class="col-md-4 mb-30">
        <div class="card p-20 top_border">
            <h2 class="_head03 border-0">Revenue <span>By Country</span></h2>
            <div class="country_data_div">
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-30">
        <div class="card p-20 top_border">
            <h2 class="_head03 border-0">Top <span>10 Products</span></h2>

            <div class="table-responsive _dash-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>QUANTITY</th>
                            <th>WEIGHT</th>
                            <th>REVENUE</th>
                        </tr>
                    </thead>
                    <tbody id="top_products_tbody">
                        {{-- <tr>
                            <td> ASOS Ridley High Waist </td>
                            <td> $79.49 </td>
                            <td> 82 </td>
                            <td> $6,518.18 </td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
