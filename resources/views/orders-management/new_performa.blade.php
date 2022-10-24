@extends('layouts.master')
@section('data-sidebar')
<style>
    .nav-link {
        border-bottom: 0px !important
    }

    #product-cl-sec,
    #product-add {
        width: 1170px
    }

    @media (max-width:800px) {

        #product-cl-sec,
        #product-add {
            width: 100%
        }
    }

    #pills-tab {
        border-bottom: 2px solid #174ecd;
        width: 100%;
        padding-bottom: 0px !important;
        margin-bottom: 15px !important;
        justify-content: left !important;
    }

</style>
<div id="performaPreferences">
    <a class="close-sidebar" class="close-btn-pl"></a>
    <div class="pro-header-text ml-0" id="performaPreferencesHeading">Add <span>Item</span></div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter pt-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 _ord-rightside">
                                <div class="form-wrap pt-0 pb-0" id="paymentSettingsDiv">
                                    <div class="card p-20 top_border mb-3">
                                        <h2>Add a Payment Schedule</h2>
                                        <div class="col-md-12 p-0">
                                            <div class="form-s2 pt-10 pb-15">
                                                <select class="form-control formselect" name="payment_type"
                                                    placeholder="Select Unit Type">
                                                    <option value="ADV" selected>Advance Payment</option>
                                                    <option value="DIF">Differed Payment</option>
                                                    <option value="ADVDIF">Advance + Differed Payment</option>
                                                    <option value="CAD">CAD Payment</option>
                                                    <option value="LC">LC Payment</option>
                                                    <option value="ADVBL">Advance + BL Copy</option>
                                                    <option value="ADVLC">Advance + LC Payment</option>
                                                    <option value="LCBL">LC + BL Copy</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" id="advPmtDiv" style="display: none">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">Advance Payment</label>
                                                    <input type="text" id="advPmt" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="row m-0 PT-10 PB-10">
                                                <div class="custom-control custom-radio float-left mr-5">
                                                    <input class="custom-control-input" type="radio"
                                                        name="paymentCriteria" id="rb-complaint" value='percentage'
                                                        data-id="rb-complaint" checked>
                                                    <label class="custom-control-label"
                                                        for="rb-complaint">Percentage</label>
                                                </div>
                                                <div class="custom-control custom-radio float-left">
                                                    <input class="custom-control-input" type="radio"
                                                        name="paymentCriteria" id="rb-suggestione" value='flat'
                                                        data-id="rb-suggestione">
                                                    <label class="custom-control-label" for="rb-suggestione">Flat
                                                        Amount</label>
                                                </div>
                                            </div>
                                            <div id="dynamicPayments">
                                            </div>
                                            <a class="btn add-product-line" id="addAnotherPayment"><i
                                                    class="fa fa-plus">
                                                </i> Add another Payment</a>
                                            <div class="_schedulpay-set">
                                                <hr>
                                                <div class="row">
                                                    <div class="col-6">Total</div>
                                                    <div class="col-6 text-right"><span
                                                            class="currencyChange">Rs</span>.
                                                        <span id="totalPaymentAm">0.00</span><br> <span
                                                            class="currencyChange">Rs</span>. <span
                                                            id="paymAmLeft">0.00</span>
                                                        left</div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-wrap pt-0 pb-0" id="shippingDetailsDiv">
                                    <div class="card p-20 top_border mb-3">
                                        <div class="row PB-10">
                                            <div class="col-md-12 mb-20">
                                                <label class="font12">Country Of Origin</label>
                                                <div class="form-s2">
                                                    <select class="form-control formselect"
                                                        placeholder="Select Payment Type" name="country_of_origin"
                                                        style="width: 100%">
                                                        <option selected>Pakistan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-20">
                                                <label class="font12">Expected Delivery Date</label>
                                                <input type="text" name="expected_delivery_date"
                                                    class="form-control expectedDeliveryDate">
                                            </div>
                                            <div class="col-md-12 mb-20 nonFobDiv">
                                                <label class="font12">Port of Loading</label>
                                                <div class="form-s2">
                                                    <select class="form-control formselect"
                                                        placeholder="Select Payment Type" name="port_of_loading"
                                                        style="width: 100%">
                                                        <option disabled selected>Select Port of Loading</option>
                                                        @foreach ($ports as $item)
                                                        <option value="{{ $item->id }}">{{ $item->port_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-20 nonFobDiv">
                                                <label class="font12">Port of Discharge</label>
                                                <div class="form-s2">
                                                    <select class="form-control formselect"
                                                        placeholder="Select Payment Type" name="port_of_discharge"
                                                        style="width: 100%">
                                                        <option disabled selected>Select Port of Discharge</option>
                                                        @foreach ($ports as $item)
                                                        <option value="{{ $item->id }}">{{ $item->port_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-20 nonFobDiv">
                                                <label class="font12">Mode of Shipment</label>
                                                <div class="form-s2">
                                                    <select name="mode_of_shipment" class="form-control formselect"
                                                        placeholder="Select Payment Type" style="width: 100%">
                                                        <option disabled selected>Select Mode of Shipment</option>
                                                        <option value="Sea">By Sea</option>
                                                        <option value="Land">By Land</option>
                                                        <option value="Air">By Air</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-20 nonFobDiv">
                                                <label class="font12">Select Route</label>
                                                <div class="form-s2">
                                                    <select class="form-control sd-type" name="shipping_route"
                                                        multiple="multiple" style="width: 100%">
                                                        @foreach ($ports as $item)
                                                        <option value="{{ $item->id }}">{{ $item->port_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-20 nonFobDiv">
                                                <label class="font12">Shipped Via</label>
                                                <div class="form-s2">
                                                    <select class="form-control formselect"
                                                        placeholder="Select Shipping Company" name="shipment_company"
                                                        style="width: 100%">
                                                        <option disabled selected>Select Company Name</option>
                                                        @foreach ($shipping_companies as $item)
                                                        <option value="{{ $item->id }}">{{ $item->company_name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 nonFobDiv">
                                                <div class="form-group mt-10">
                                                    <label class="control-label mb-10">Quoted Freight
                                                        Charges</label>
                                                    <input type="text" name="quoted_freight_charges"
                                                        class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-12 nonFobDiv">
                                                <div class="form-group mt-10">
                                                    <label class="control-label mb-10">Actual Freight
                                                        Charges</label>
                                                    <input type="text" name="actual_freight_charges"
                                                        class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-12 insuranceDiv">
                                                <div class="form-group mt-10">
                                                    <label class="control-label mb-10">Insurance
                                                        Charges</label>
                                                    <input type="text" name="insurance_charges" class="form-control"
                                                        placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-wrap pt-0 pb-0" id="currencyOption">
                                    <div class="row pt-0 PB-10">
                                        <div class="col-md-12">
                                            <div class="card p-20 top_border mb-3">
                                                <div class="form-s2">
                                                    <label for="" class="font12">Select Currency</label>
                                                    <select class="form-control " id="currencySelector"
                                                        placeholder="Select Currency" style="width: 100%">
                                                        <option sign="$" value="USD" selected>USD - United States Dollar
                                                        </option>
                                                        <option sign="EUR" value="EUR">EUR - Euro
                                                        </option>
                                                        <option sign="Rs" value="PKR">PKR - Pakistan Rupees
                                                        </option>
                                                        <option sign="HK$" value="HKD">HKD — Hong Kong dollar</option>
                                                        <option sign="AFN" value="AFN">AFN — Afghani</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-wrap pt-0 pb-0" id="shipmentCalculation">
                                    <div class="card p-20 top_border mb-3">
                                        <div class="row">
                                            <div class="col-md-12 PT-10">
                                                <label class="control-label">Additional Weight / Carton (KG)</label>
                                                <input type="text" style="font-size: 13px" name="additional_weight_ctn">
                                            </div>
                                            <div class="col-md-6 PT-10">
                                                <div class="form-group">
                                                    <label class="control-label">Net Weight</label>
                                                    <input readonly type="text" name="net_weight" placeholder="0"
                                                        style="font-size: 13px">
                                                </div>
                                            </div>
                                            <div class="col-md-6 PT-10">
                                                <div class="form-group">
                                                    <label class="control-label">Actual Net Weight</label>
                                                    <input type="text" name="actual_net_weight" style="font-size: 13px">
                                                </div>
                                            </div>
                                            <div class="col-md-12 PT-10">
                                                <div class="form-group">
                                                    <label class="control-label">Total CBM Value</label>
                                                    <input type="text" readonly
                                                        name="total_cbm_value_shipment_calculation"
                                                        style="font-size: 13px">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <ul class="nav nav-pills float-left" id="pills-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="pill-20-tab" data-toggle="pill"
                                                            href="#pill-20" role="tab" aria-controls="pill-20"
                                                            aria-selected="true">20 FT</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="pills-40-tab" data-toggle="pill"
                                                            href="#pills-40" role="tab" aria-controls="pills-40"
                                                            aria-selected="false">40 FT</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="pills-hc-tab" data-toggle="pill"
                                                            href="#pills-hc" role="tab" aria-controls="pills-hc"
                                                            aria-selected="false">40 FT HC</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-12">
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="pill-20" role="tabpanel"
                                                        aria-labelledby="pill-20-tab">
                                                        <div class="contDiv">
                                                            <div class="contProgress" style="width: 0%"></div>
                                                            <div class="ProgNO"></div>
                                                        </div>
                                                        <div id="extra20Ft">
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-40" role="tabpanel"
                                                        aria-labelledby="pills-40-tab">
                                                        <div class="contDiv">
                                                            <div class="contProgress" style="width: 0%"></div>
                                                            <div class="ProgNO"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-hc" role="tabpanel"
                                                        aria-labelledby="pills-hc-tab">
                                                        <div class="contDiv">
                                                            <div class="contProgress" style="width: 0%"></div>
                                                            <div class="ProgNO"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="_cl-bottom">
        <button id="pl-close2" type="button" class="btn btn-cancel m-0 mr-2 closeProductAddSidebar">Cancel</button>
        <button id="pl-close" type="button" class="saveContentFooter btn btn-primary m-0">Save</button>
        <button type="button" id="addProduct" class="itemContentFooter btn btn-primary m-0">Add Item</button>
        <button class="paymentContentFooter btn btn-cancel mr-2" id="resetPayments">Reset</button>
        {{-- <a class="paymentContentFooter btn btn-primary" style="color: white !important" id="addSchedule">Add
            Schedule</a> --}}
    </div>
</div>
<div id="product-add">
    <a class="close-sidebar" class="close-btn-pl"></a>
    <div class="pro-header-text ml-0">Add <span>Item</span></div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter pt-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div id="floating-label" class="card top_border mb-3">
                                    <div class="col-md-12">
                                        <div class="form-wrap PT-10 PB-20">
                                            <div class="row">
                                                <div class="col-md-12 pt-10">
                                                    <h3 class="_head03">Add New <span> Item</span></h3>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="PT-10 font12">Description</label>
                                                    <div class="form-group">
                                                        <textarea name="item_description" rows="8"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pt-10">
                                                    <h3 class="_head03">Basic <span>Unit*</span></h3>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect" name="unit_id"
                                                            placeholder="Select Unit Type">
                                                            <option value="0" selected disabled>Select Unit Type
                                                                *</option>
                                                            @foreach ($units as $item)
                                                            <option value="{{ $item->id }}">{{ $item->unit_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Unit Weight*</label>
                                                        <input type="number" name="unit_weight" style="font-size: 13px"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pt-10">
                                                    <h3 class="_head03">Packaging <span>Option*</span></h3>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect" name="variant_id"
                                                            placeholder="Select Variants Type">
                                                            <option value="0" selected>Select Variant Type
                                                            </option>
                                                            @foreach ($variants as $item)
                                                            <option value="{{ $item->id }}">{{ $item->variant_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Unit Quantity*</label>
                                                        <input type="number" name="unit_quantity" class="form-control"
                                                            style="font-size: 13px">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect" name="variant_id_2"
                                                            placeholder="Select Variants Type">
                                                            <option value="0" selected>Select Variant Type
                                                            </option>
                                                            @foreach ($variants as $item)
                                                            <option value="{{ $item->id }}">{{ $item->variant_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Variant Quantity*</label>
                                                        <input type="number" name="variant_quantity_2"
                                                            class="form-control" style="font-size: 13px">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect" name="variant_id_3"
                                                            placeholder="Select Variants Type">
                                                            <option value="0" selected>Select Variant Type
                                                            </option>
                                                            @foreach ($variants as $item)
                                                            <option value="{{ $item->id }}">{{ $item->variant_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Variant Quantity*</label>
                                                        <input type="number" name="variant_quantity_3"
                                                            class="form-control" style="font-size: 13px">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pt-10">
                                                    <h3 class="_head03">Master <span> Carton*</span></h3>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Master Carton*</label>
                                                        <input type="number" name="unit_variant_quantity"
                                                            style="font-size: 13px" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Length*</label>
                                                        <input type="number" name="length" style="font-size: 13px"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Width*</label>
                                                        <input type="number" name="width" style="font-size: 13px"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Height*</label>
                                                        <input type="number" name="height" style="font-size: 13px"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 CBM_val">
                                                    <label>CBM Value*</label>
                                                    <div class="form-group p-0 m-0 h-auto">
                                                        <input readonly type="text" name="cbm_value_label"
                                                            style="font-size: 13px" class="form-control">
                                                        <input type="text" name="cbm_value" hidden>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 CBM_val">
                                                    <label>Actual CBM</label>
                                                    <div class="form-group p-0 m-0 h-auto">
                                                        <input type="text" name="actual_cbm_label"
                                                            style="font-size: 13px" class="form-control">
                                                        <input type="text" name="actual_cbm" hidden>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 CBM_val" style="margin-top:4px;">
                                                    <label>Standrad Unit Price</label>
                                                    <div class="form-group p-0 m-0 h-auto">
                                                        <input type="number" name="standrad_unit_price"
                                                            style="font-size: 13px" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="_cl-bottom">
        <button id="pl-close2" type="submit" class="btn btn-cancel m-0 mr-2 closeProductAddSidebar">Cancel</button>
        <button type="button" id="addProduct" class="btn btn-primary m-0">Add Item</button>
    </div>
</div>
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span>Customer</span></div>
    <div style="min-height: 400px" id="dataSidebarLoader" style="display: none">
        <img src="/images/loader.gif" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
    </div>
    <div class="pc-cartlist">
        <form style="display: flex;" id="saveCustomerForm">
            {!! Form::hidden('product_updating_id', '') !!}
            @csrf
            <input type="text" id="operation" hidden>
            <input type="text" value="" hidden class="doc_key" name="doc_key" />
            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter pt-0">
                        <div class="se_cus-type p-20 mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <input hidden type="text" id="hidden_cust_type" value="{{$types}}" />
                                    <h2 class="_head04 border-0">Select <span> Customer Type</span></h2>
                                    <div class="form-s2">
                                        <select class="form-control formselect" name="type"
                                            placeholder="Select Customer Type*">
                                            <option value="0" disabled selected>Select Customer Type</option>
                                            @foreach ($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h2 class="_head04 border-0">Select <span> Acquisition Source</span></h2>
                                    <div class="form-s2">
                                        <select class="form-control formselect" name="acqSource"
                                            placeholder="Acquisition Source">
                                            <option value="0" disabled selected>Select Acquisition Source</option>
                                            @if(!empty($acquisition))
                                            @foreach ($acquisition as $acq)
                                            <option value="{{$acq->id}}">{{$acq->name}}
                                                {{$acq->year ? " - ".$acq->year : ""}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <h2 class="_head04 border-0">Select <span> Life Cycle Stage</span></h2>
                                    <div class="form-s2 ">
                                        <select class="form-control formselect" placeholder="Contact Status"
                                            name="life_cycle_stage">
                                            <option value="customer">Customer</option>
                                            <option value="lead">Sales Lead</option>
                                            <option value="prospect">Prospect</option>
                                            <option value="dead">Dead</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div id="floating-label" class="card p-20 top_border mb-3">
                                        <h2 class="_head03">Company <span>Details</span></h2>
                                        <input hidden type="text" id="hidden_comp_name" value="{{$customers}}" />
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-4 pt-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Company ID</label>
                                                        <input type="text" name="compId" class="form-control">
                                                    </div>
                                                    <small id="idTakenError" style="color: red; display: none">This
                                                        id
                                                        is already taken</small>

                                                </div>
                                                <div class="col-md-4 pt-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Company Name*</label>
                                                        <input type="text" name="compName"
                                                            class="form-control required_cust">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-s2"> <label class="font12 mb-5">Parent
                                                            Company</label>
                                                        <select class="form-control formselect" name="parentCompnay"
                                                            placeholder="select Parent Company">
                                                            <option value="0" disabled selected>Select Parent
                                                                Company
                                                            </option>
                                                            @foreach ($customers as $comp)
                                                            <option value="{{ $comp->id }}">
                                                                {{ $comp->company_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-10">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Fax Number</label>
                                                        <input type="text" name="faxPh" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mt-25">
                                                <h2 class="_head03">Phone <span>No</span><a
                                                        class="addBTN-act add_another_cust_contact"><i
                                                            class="fa fa-plus"></i> Add Phone</a></h2>
                                            </div>
                                            <div class="customer_phone_num_div row w-100 m-0">
                                                <div class="col-md-6">
                                                    <div class="form-group phone-SL div_parent">
                                                        <div class="col-auto p-0">
                                                            <select
                                                                class="custom-select custom-select-sm cust_phone_type">
                                                                <option selected disabled value="-1">Type</option>
                                                                <option value="business">Business</option>
                                                                <option value="mobile">Mobile</option>
                                                                <option value="whatsapp">WhatsApp</option>
                                                            </select>
                                                        </div>
                                                        <div class="col p-0">
                                                            <a class="closeBTN remove_phone_num"
                                                                style="color:white !important"><i
                                                                    class="fa fa-times"></i></a>
                                                            <input class="phoneinput cust_phone_number" type="text"
                                                                placeholder="0000000000">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mt-20">
                                                <h2 class="_head03">Email <span></span></h2>
                                            </div>
                                            <div class="col-md-6 pt-5">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">Personal Email</label>
                                                    <input type="text" class="form-control" name="personalemail">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-5">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">Official Email</label>
                                                    <input type="text" class="form-control" name="officalemail">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Social --}}
                                        <div class="row">
                                            <div class="col-md-12 mt-20">
                                                <h2 class="_head03">Social <span></span></h2>
                                            </div>
                                            <div class="col-md-6 pt-5">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">Linkedin Link</label>
                                                    <input type="text" class="form-control" name="cust_linkedin">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-5">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">Wechat Link</label>
                                                    <input type="text" class="form-control" name="cust_wechat">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Social --}}

                                        {{-- Official Address --}}
                                        <div class="row address_customer" type="official">
                                            <div class="col-md-12 mt-20">
                                                <h2 class="_head03">Official Address* <span></span></h2>
                                            </div>
                                            <div class="col-md-12 pt-5">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">Address</label>
                                                    <input type="text" class="form-control address"
                                                        address-type="official">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-5">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">Postal Code</label>
                                                    <input type="text" class="form-control code"
                                                        address-type="official">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-5">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">City</label>
                                                    <input type="text" class="form-control city"
                                                        address-type="official">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-5">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">State</label>
                                                    <input type="text" class="form-control state"
                                                        address-type="official">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-s2">
                                                    <label class="font11 mb-0">Country</label>
                                                    <select class="form-control formselect country"
                                                        placeholder="select Country" address-type="official">
                                                        @include('includes.countries')
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Official Address --}}

                                        {{-- Residential Address --}}
                                        <div class="row address_customer" type="residential">
                                            <div class="col-md-12 mt-20">
                                                <h2 class="_head03">Residential Address <span></span></h2>
                                            </div>
                                            <div class="col-md-12 pt-5">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">Address</label>
                                                    <input type="text" class="form-control address"
                                                        address-type="residential">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-5">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">Postal Code</label>
                                                    <input type="text" class="form-control code"
                                                        address-type="residential">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-5">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">City</label>
                                                    <input type="text" class="form-control city"
                                                        address-type="residential">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-5">
                                                <div class="form-group">
                                                    <label class="control-label mb-10">State</label>
                                                    <input type="text" class="form-control state"
                                                        address-type="residential">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-s2">
                                                    <label class="font11 mb-0">Country</label>
                                                    <select class="form-control formselect country"
                                                        placeholder="select Country" address-type="residential">
                                                        @include('includes.countries')
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Residential Address --}}


                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-s2">
                                                    <input hidden type="text" id="hidden_doc_type"
                                                        value="{{$doc_type}}" />
                                                    <label class="PT-10 font12">Document Types Required</label>
                                                    <select class="form-control sd-type" name="documentTypes"
                                                        multiple="multiple">
                                                        @if (!empty($doc_type))
                                                        @foreach ($doc_type as $docs)
                                                        <option value="{{$docs->id}}">{{$docs->document_name}}
                                                        </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-s2">
                                                    <input hidden type="text" id="hidden_del_port" value="{{$ports}}" />
                                                    <label class="PT-10 font12">Delivery Ports</label>
                                                    <select class="form-control sd-type" name="deliveryPorts"
                                                        multiple="multiple">
                                                        @foreach ($ports as $p)
                                                        <option value="{{ $p->id }}">{{ $p->port_name }}
                                                            ({{ $p->port_code }})
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-wrap pb-0 pt-19">
                                                    <div class="form-wrap pt-19 pb-0" id="dropifyImgDiv"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="prospectDataDiv">
                                            <div class="form-s2 pt-19">
                                                <label class="font12">Select Competition</label>
                                                <div class="_sa-customer" style="padding: 0; max-width: 100%">
                                                    <div class="form-s2 selpluse">
                                                        <select class="form-control formselect"
                                                            placeholder="select Competition" name="competitionDD"
                                                            id="competitionSelect2">
                                                            <option value="0" disabled selected>Select Competition
                                                            </option>
                                                        </select>
                                                        <a data-toggle="modal" id="addNewCompetition"
                                                            data-target=".AddDynamicCompetitionModal" style="right: 0;"
                                                            class="btn plus_button po-ab productlist01 _OA-disply"><i
                                                                class="fa fa-plus"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <h2 class="_head03 PT-20">Interested <span>In</span></h2>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <label class="font12">Product</label>
                                                        <select class="form-control sd-type"
                                                            name="interested_in_product" multiple="multiple">
                                                            @foreach ($products as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <label class="font12">Service</label>
                                                        <select class="form-control sd-type"
                                                            name="interested_in_category" multiple="multiple">
                                                            @foreach ($categories as $cat)
                                                            <option value="{{ $cat->id }}">{{ $cat->service_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-s2 pt-19">
                                                        <label class="font12">Contact Status</label>
                                                        <select class="form-control formselect" name="contact_status"
                                                            placeholder="Intersted in Product">
                                                            <option value="0" disabled selected>Select Contact
                                                                Status
                                                            </option>
                                                            <option value="new">New</option>
                                                            <option value="contacted">Contacted</option>
                                                            <option value="connected">Connected</option>
                                                            <option value="unqualified">Unqualified</option>
                                                            <option value="ninterested">Not Interested</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="PT-10 font12">Remarks</label>
                                                    <div class="form-group">
                                                        <input type="text" name="document_types" hidden>
                                                        <input type="text" name="delivery_ports" hidden>
                                                        <input type="text" name="interestedInProduct" hidden>
                                                        <input type="text" name="interestedInCategory" hidden>
                                                        <textarea name="description" rows="8"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        </form>
        <h2 class="_head04 PT-20">Add<span> Customer Images</span></h2>
        <div class="row">
            <div class="col-md-12">
                <form action="/client_docs" class="dropzone" id="dropzonewidgetcustImages" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="text" hidden name="operation" class="operation_docs" />
                    <input type="text" value="" hidden class="doc_key" name="doc_key" />
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
{{-- </form> --}}
</div>
<div class="_cl-bottom">
    <button type="submit" class="btn btn-primary mr-2" id="saveCustomer">Save</button>
    {{-- <button class="btn btn-primary mr-2" id="addAnotherPoc">Add Another POC</button> --}}
    <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelCustomer">Cancel</button>
</div>
</div>
@endsection
@section('content')

{{-- Modal After Customer Add --}}
<div class="modal fade" id="add_poc_against_cust" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content top-border">
            <div class="modal-header statusMH">
                <h5 class="modal-title" id="exampleModalLabel">Add POC Against <span class="added_customer"> </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-20">
                <div class="row">
                    <div class="col-6 status-sh StCustomer">
                        <h2 class="_head04 border-0">Select <span> POC</span></h2>
                        <div class="form-s2">
                            <select class="form-control formselect already_added_poc_for_customer"
                                placeholder="Select POC*">
                                <option>Select POC</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary save_poc_against_cust">Save</button>
                <button type="button" class="btn btn-primary " data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>




<button hidden data-toggle="modal" data-target="#add_poc_against_cust" class="open_poc_modal"></button>
<div class="row mt-2 mb-3">
    <div class="col-md-12">
        <h2 class="_head01 float-left">New <span>Order</span></h2>
    </div>
    <div class="col-md-3">
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-12">
        <div class="card p-20 top_border mb-3 _INV-h" id="printThis">
            <div class="row _add-customer">
                <div class="col-12">
                    <div class="row">
                        <div class="_sa-customer">
                            <div class="form-s2 selpluse">
                                <select class="form-control formselect" id="selectCustomerDD"
                                    placeholder="Select Customer">
                                </select>
                                <a class="btn plus_button po-ab productlist01 _OA-disply openDataSidebarForAddingCustomer"
                                    style="z-index: 100000;"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="_date-order">
                            <div class="form-group">
                                <label class="date_label">Date of Order</label>
                                <div class="dp3 input-append date position-relative" data-date="{{ date('Y-m-d') }}"
                                    data-date-format="yyyy-mm-dd">
                                    <input type="text" id="issueDate" value="{{ date('Y-m-d') }}" readonly
                                        style="font-size: 14px">
                                    <span class="add-on calendar-icon">
                                        <img src="/images/calendar-icon.svg" alt="" /> </span>
                                </div>
                            </div>
                        </div>
                        <div class="_date-order">
                            <div class="_posno"><label class="date_label">PO NO.</label>
                                <input type="text" id="poNumForm" placeholder="01254"
                                    style="font-size: 14px; width: 100%; border: 0!important; outline: 0!important; background-color: transparent; text-align: left;">
                            </div>
                        </div>
                        <div class="_orderType">
                            <div class="_posno"><label class="date_label">Order Type*</label>
                                <select name="order_type" class="custom-select custom-select-sm">
                                    <option disabled selected>Select Order Type*</option>
                                    <option value="FOB">FOB</option>
                                    <option value="CFR">CFR</option>
                                    <option value="CFI">CFI</option>
                                    <option value="CFN">CFN</option>
                                </select>
                            </div>
                        </div>
                        <div class="_date-order">
                            <div class="_posno"><label class="date_label">Invoice NO.</label>
                                {{-- <span id="invNumber"></span> --}}
                                <input type="text" id="invNumber" value="E-{{ sprintf("%04s", $invoice_num) }}"
                                    placeholder="01254"
                                    style="font-size: 14px; width: 100%; border: 0!important; outline: 0!important; background-color: transparent; text-align: left;">
                            </div>
                        </div>
                        <div class="col _order-price"><span>Amount Due (USD)</span> USD.0.00</div>
                    </div>
                    <div class="_cut-detail">
                        <div class="row">
                            <div class="col-md-6"><strong>Company Name: &nbsp; </strong> <span id="company_name"></span>
                            </div>
                            <div class="col-md-6"><strong>Poc: &nbsp; </strong> <span id="poc_name"></span></div>
                            <div class="col-md-6"><strong>Country: &nbsp; </strong> <span id="country"></span></div>
                            <div class="col-md-6"><strong>City: &nbsp; </strong> <span id="city"></span></div>
                        </div>
                    </div>
                    <div class="_add-product">
                        <div class="row AP_heading">
                            <div class="addItemCell PL-5">Product Name</div>
                            <div class="addItemCell">Item</div>
                            <div class="addItemCell2">QTY.</div>
                            <div class="addItemCelWEIGHT">Weight/Unit</div>
                            <div class="addItemCelWEIGHT">Weight/Carton</div>
                            <div class="addItemCellcbm">CBM</div>
                            <div class="addItemCellcbm">Total CBM</div>
                            <div class="addItemCell2">Unit Price</div>
                            <div class="addItemCell3">Amount</div>
                        </div>
                        <div id="productsContainer">
                        </div>
                        <div class="row AP_heading _totalBar">
                            <div class="addItemCell PL-5 text-right"></div>
                            <div class="addItemCell2"></div>
                            <div class="addItemCelWEIGHT"></div>
                            <div class="addItemCelWEIGHT"></div>
                            <div class="addItemCellcbm"></div>
                            <div class="addItemCellcbm"></div>
                            <div class="addItemCell2"></div>
                            <div class="addItemCell2"></div>
                            <div class="addItemCell2 text-right">Discount%</div>
                            <div class="addItemCell3" class=""><input placeholder="Discount%" name="order_discount"
                                    id="order_discount" style="font-size: 14px" /></div>
                        </div>
                        <div class="row AP_heading _totalBar">
                            <div class="addItemCell PL-5 text-right">Total: </div>
                            <div class="addItemCell2"></div>
                            <div class="addItemCelWEIGHT"></div>
                            <div class="addItemCelWEIGHT" class="totalCtns">0CTNS</div>
                            <div class="addItemCellcbm"></div>
                            <div class="addItemCellcbm"></div>
                            <div class="addItemCell2"></div>
                            <div class="addItemCell2"></div>
                            <div class="addItemCell2 text-right" class="totalAm"> USD.0.00</div>
                            <div class="addItemCell3" class="amount_after_discount" style="text-align:right !important">
                                USD.0.00</div>
                        </div>
                        <div class="row">
                            <div class="col _PR-W" id="amountInWords"></div>
                        </div>
                        <div class="row">
                            <a id="addMoreProductsInOrder" class="btn add-product-line"><i class="fa fa-plus"> </i> Add
                                a Product</a>
                        </div>
                        <div class="row _notesTER">
                            <div class="col-md-6">
                                Notes
                                <textarea class="textarea-NOTES" rows='1'
                                    placeholder="Enter Notes or bank transfer details"
                                    style="font-size: 13px"></textarea>
                            </div>
                            <div class="col-md-6">
                                Terms
                                <textarea class="textarea-TERMS" rows='1' placeholder="Enter your terms and conditions"
                                    style="font-size: 13px"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="Action_bottom">
        <div class="button-section align-right">
            <a href="/OrderManagement" class="btn btn-primary mr-2 btn-cancel">Cancel</a>
            <div class="btn-group _more-action _more-actionBlue">
                <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    Save
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" id="saveOrderBtn"><i class="fa fa-file-alt"> </i> Save as Order</a>
                    <a class="dropdown-item" id="saveDraft"><i class="fa fa-file-alt"> </i> Save as Draft</a>
                    <a class="dropdown-item" id="saveAsPerforma"><i class="fa fa-save"> </i> Save as Performa</a>
                    <a class="dropdown-item" id="downloadPdf"><i class="fa fa-file-pdf"> </i> Download PDF</a>
                    {{-- id="sendPdfEmail" id="saveOrderBtn"  --}}
                </div>
            </div>
        </div>
        <div class="container p-0" style="margin-top: 0;">
            <div class="col-md-12 p-0">
                <a id="paymentSettingsBtn" style="cursor: pointer" class="_AB-link"><img
                        src="/images/payment-icon-act.svg" alt="" />Payment
                    Settings</a>
                <a id="shippingDetailsBtn" style="cursor: pointer" class="_AB-link"><img
                        src="/images/shipping_details-icon-act.svg" alt="" />Shipping Details</a>
                <a id="currencyBtn" style="cursor: pointer" class="_AB-link"><img src="/images/currency-icon-act.svg"
                        alt="" />Currency
                    Option</a>
                <a id="cbmCalculationBtn" style="cursor: pointer" class="_AB-link"><img
                        src="/images/container-icon-act.svg" alt="" />CBM
                    Calculation</a>
            </div>
        </div>
    </div>
</div>
@endsection
