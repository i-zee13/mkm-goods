@extends('layouts.master')
@section('content')
<style>
    .disabledWizardSelectors {
        opacity: 0.5;
        pointer-events: none;
    }

</style>
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Order <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Order</span></a></li>
            <li><span>Dispatch Details</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card _Dispatch">
            <div class="header">
                <h2>Order <span>Dispatch</span></h2>
            </div>
            <div class="row m-0">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="nav flex-column nav-pills CB-account-tab" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <a class=" {{ $order['products_selection'] ? '' : 'active' }} nav-link" id="prod-selection-pill"
                            data-toggle="pill" href="#pselectiontab" role="tab" aria-controls="pselectiontab"
                            aria-selected="true">Products
                            Selection</a>
                        <a class=" {{ $order['products_selection'] ? 'active' : 'disabledWizardSelectors' }} nav-link"
                            id="v-pills-01-tab" data-toggle="pill" href="#v-pills-01" role="tab"
                            aria-controls="v-pills-01" aria-selected="false">Shipping
                            Information</a>
                        <a class=" {{ $order['products_selection'] ? '' : 'disabledWizardSelectors' }} nav-link"
                            id="v-pills-07-tab" data-toggle="pill" href="#v-pills-07" role="tab"
                            aria-controls="v-pills-07" aria-selected="false">Invoice Information </a>

                        <a class=" {{ $order['products_selection'] ? '' : 'disabledWizardSelectors' }} nav-link"
                            id="v-pills-02-tab" data-toggle="pill" href="#v-pills-02" role="tab"
                            aria-controls="v-pills-02" aria-selected="false">e-form </a>
                        <a class=" {{ $order['products_selection'] ? '' : 'disabledWizardSelectors' }} nav-link"
                            id="v-pills-03-tab" data-toggle="pill" href="#v-pills-03" role="tab"
                            aria-controls="v-pills-03" aria-selected="false">Packing List
                        </a>
                        <a class=" {{ $order['products_selection'] ? '' : 'disabledWizardSelectors' }} nav-link"
                            id="v-pills-04-tab" data-toggle="pill" href="#v-pills-04" role="tab"
                            aria-controls="v-pills-04" aria-selected="false">Commercial Invoice </a>
                        <a class=" {{ $order['products_selection'] ? '' : 'disabledWizardSelectors' }} nav-link"
                            id="v-pills-05-tab" data-toggle="pill" href="#v-pills-05" role="tab"
                            aria-controls="v-pills-05" aria-selected="false">Upload Documents</a>
                        <a class=" {{ $order['products_selection'] ? '' : 'disabledWizardSelectors' }} nav-link"
                            id="v-pills-08-tab" data-toggle="pill" href="#v-pills-08" role="tab"
                            aria-controls="v-pills-08" aria-selected="false">Health Detail</a>
                        <a class=" {{ $order['products_selection'] ? '' : 'disabledWizardSelectors' }} nav-link"
                            id="v-pills-09-tab" data-toggle="pill" href="#v-pills-09" role="tab"
                            aria-controls="v-pills-09" aria-selected="false">Quality Detail</a>
                        <a class=" {{ $order['products_selection'] ? '' : 'disabledWizardSelectors' }} nav-link"
                            id="v-pills-10-tab" data-toggle="pill" href="#v-pills-10" role="tab"
                            aria-controls="v-pills-10" aria-selected="false">Conformity Detail</a>
                        <a class=" {{ $order['products_selection'] ? '' : 'disabledWizardSelectors' }} nav-link"
                            id="v-pills-06-tab" data-toggle="pill" href="#v-pills-06" role="tab"
                            aria-controls="v-pills-06" aria-selected="false">System Generated</a>
                        
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-12 ml-800">
                    <div style="min-height: 400px" id="loaderWaitDiv">
                        <img src="/images/loader.gif" width="30px" height="auto"
                            style="position: absolute; left: 40%; top: 45%;">
                    </div>
                    <div class="tab-content" id="v-pills-tabContent" style="display: none">

                        <div class="tab-pane fade {{ $order['products_selection'] ? '' : 'active show' }}"
                            id="pselectiontab" role="tabpanel" aria-labelledby="pselectiontab">
                            <div class="CB_info">
                                <div id="floating-label" class="card top_border mb-3">
                                    <div class="col-md-12">
                                        <div class="form-wrap PT-10 PB-20">
                                            <div class="row">
                                                <div class="col-md-12 pt-10 mb-0">
                                                    <h2 class="_head04">Products <span>Selection</span>
                                                    </h2>
                                                </div>
                                                <div class="col-md-12 productRate-table m-0">
                                                    <table class="table table-hover dt-responsive nowrap table-PL"
                                                        style="width:100% !important" id="dispatchProductsTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Assigned QTY.</th>
                                                                <th>Produced QTY.</th>
                                                                <th>Shipped QTY.</th>
                                                                <th>To Dispatch QTY.</th>
                                                                <th>Dispatch</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($order['contents'] as $item)
                                                            @if ($item['production_quantity'] !=
                                                            (!$order['products_selection'] ?
                                                            $item['dispatched_quantity'] : $item['shipped_quantity']))
                                                            <tr class="dispatchProductsSelectionTr"
                                                                assignment-id="{{ $item['id'] }}"
                                                                content-id="{{ $item['content_id'] }}"
                                                                batch="{{ $item['batch'] }}"
                                                                item-id="{{ $item['item_id'] }}"
                                                                supplier-id="{{ $item['supplier_id'] }}">
                                                                <td>
                                                                    <span
                                                                        style="display: block">{{ $item['product_name'] }}</span>
                                                                    <small
                                                                        style="display: block; margin: 4px 0px">{{ $item['item_name'] }}</small>
                                                                    <small
                                                                        style="font-weight: bold">{{ $item['supplier'] }}</small>
                                                                </td>
                                                                <td>{{ $item['assigned_qty'] }}</td>
                                                                <td>{{ $item['production_quantity'] }}</td>
                                                                <td>{{ !$order['products_selection'] ? $item['dispatched_quantity'] : $item['shipped_quantity'] }}
                                                                </td>
                                                                <td>{{ !$order['products_selection'] ? 0 : $item['dispatched_quantity'] }}
                                                                </td>
                                                                <td>
                                                                    <input
                                                                        dispatched="{{ $item['dispatched_quantity'] }}"
                                                                        produced="{{ $item['production_quantity'] }}"
                                                                        shipped="{{ !$order['products_selection'] ? $item['dispatched_quantity'] : $item['shipped_quantity'] }}"
                                                                        type="number" item-id="{{ $item['item_id'] }}"
                                                                        class="cu-Rate prodQtyForDispatch">
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class=" row m-0 PT-15">
                                                <button type="button" class="btn btn-primary mr-2"
                                                    id="saveDispatchQty">Save</button>
                                                <a href="/OrderDetails/{{ Request::segment(2) }}"
                                                    class="btn btn-cancel mr-2">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-07" role="tabpanel" aria-labelledby="v-pills-07-tab">
                            <div class="CB_info">
                                <div class="card top_border mb-3">
                                    <div class="col-md-12">
                                        <div class="form-wrap PT-10 pb-15">
                                            <div class="row">
                                                <div class="col-md-12 pt-10">
                                                    <input type="text" id="custom_invoice_id" class="customInvoiceField"
                                                        hidden>
                                                    <div class="_head04 border-0">Invoice <span>Detail</span>
                                                        <div class="OD-invoiceNo">
                                                            <div class="row">
                                                                <div class="col-auto">Invoice Date :</div>
                                                                <div class="col-auto pl-0">
                                                                    <input type="text"
                                                                        class="form-control customInvoiceField datepicker InvdateTP"
                                                                        placeholder="" id="invoice_date">
                                                                </div>
                                                                <div class="col-auto pl-0">Invoice No:
                                                                    <span id="invoice_num_custom_invoice">...</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="ShipCharSec mt-0">
                                                        <a class="invInfoEdit" style="cursor: pointer"
                                                            id="editInvoiceDetails"><i class="fa fa-pencil"></i></a>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label class="font12 mb-0">Invoice To </label>
                                                                <input type="text" id="invoice_to"
                                                                    value="{{$customer_name->customer_name}}" readonly
                                                                    class="form-control customInvoiceField invFor"
                                                                    placeholder="Name...">
                                                                <input type="text" id="invoice_to_address" readonly
                                                                    value="{{json_decode($customer_name->customer_address, true)[0]['street']}}"
                                                                    class="form-control customInvoiceField invForAdd"
                                                                    placeholder="Address Here...... .....  Lahore, Pakistan">
                                                            </div>

                                                        </div>

                                                        <div class="row PT-10">
                                                            <div class="col-md-4">
                                                                <label class="font12">Port</label>
                                                                <div class="form-s2">
                                                                    <select
                                                                        class="form-control customInvoiceField formselect"
                                                                        placeholder="Select Payment Type"
                                                                        id="invoice_port" style="width: 100%">
                                                                        <option disabled selected>Select Port of
                                                                            Discharge
                                                                        </option>
                                                                        @foreach ($ports as $item)
                                                                        <option value="{{ $item->id }}"
                                                                            {{ $order['port_of_discharge'] && $order['port_of_discharge'] == $item->id ? "selected" : "" }}>
                                                                            {{ $item->port_name }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label class="font12">City</label>
                                                                <div class="form-s2">
                                                                    <select id="invoice_city"
                                                                        class="form-control customInvoiceField formselect"
                                                                        placeholder="Select Payment Type"
                                                                        style="width: 100%">
                                                                        <option selected>Select City</option>
                                                                        @foreach ($all_cities as $item)
                                                                        <option value="{{ $item }}">
                                                                            {{ ucwords($item) }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label class="font12">Country</label>
                                                                <div class="form-s2">
                                                                    <select
                                                                        class="form-control customInvoiceField formselect"
                                                                        placeholder="Select Payment Type"
                                                                        id="invoice_country" style="width: 100%">
                                                                        <option value="0" disabled selected>Select
                                                                            Country</option>
                                                                        <option>Afghanistan </option>
                                                                        <option>Albania </option>
                                                                        <option>Algeria </option>
                                                                        <option>American Samoa </option>
                                                                        <option>Andorra </option>
                                                                        <option>Angola </option>
                                                                        <option>Anguilla </option>
                                                                        <option>Antigua &amp; Barbuda </option>
                                                                        <option>Argentina </option>
                                                                        <option>Armenia </option>
                                                                        <option>Aruba </option>
                                                                        <option>Australia </option>
                                                                        <option>Austria </option>
                                                                        <option>Azerbaijan </option>
                                                                        <option>Bahamas, The </option>
                                                                        <option>Bahrain </option>
                                                                        <option>Bangladesh </option>
                                                                        <option>Barbados </option>
                                                                        <option>Belarus </option>
                                                                        <option>Belgium </option>
                                                                        <option>Belize </option>
                                                                        <option>Benin </option>
                                                                        <option>Bermuda </option>
                                                                        <option>Bhutan </option>
                                                                        <option>Bolivia </option>
                                                                        <option>Bosnia &amp; Herzegovina </option>
                                                                        <option>Botswana </option>
                                                                        <option>Brazil </option>
                                                                        <option>British Virgin Is. </option>
                                                                        <option>Brunei </option>
                                                                        <option>Bulgaria </option>
                                                                        <option>Burkina Faso </option>
                                                                        <option>Burma </option>
                                                                        <option>Burundi </option>
                                                                        <option>Cambodia </option>
                                                                        <option>Cameroon </option>
                                                                        <option>Canada </option>
                                                                        <option>Cape Verde </option>
                                                                        <option>Cayman Islands </option>
                                                                        <option>Central African Rep. </option>
                                                                        <option>Chad </option>
                                                                        <option>Chile </option>
                                                                        <option>China </option>
                                                                        <option>Colombia </option>
                                                                        <option>Comoros </option>
                                                                        <option>Congo, Dem. Rep. </option>
                                                                        <option>Congo, Repub. of the </option>
                                                                        <option>Cook Islands </option>
                                                                        <option>Costa Rica </option>
                                                                        <option>Cote d'Ivoire </option>
                                                                        <option>Croatia </option>
                                                                        <option>Cuba </option>
                                                                        <option>Cyprus </option>
                                                                        <option>Czech Republic </option>
                                                                        <option>Denmark </option>
                                                                        <option>Djibouti </option>
                                                                        <option>Dominica </option>
                                                                        <option>Dominican Republic </option>
                                                                        <option>East Timor </option>
                                                                        <option>Ecuador </option>
                                                                        <option>Egypt </option>
                                                                        <option>El Salvador </option>
                                                                        <option>Equatorial Guinea </option>
                                                                        <option>Eritrea </option>
                                                                        <option>Estonia </option>
                                                                        <option>Ethiopia </option>
                                                                        <option>Faroe Islands </option>
                                                                        <option>Fiji </option>
                                                                        <option>Finland </option>
                                                                        <option>France </option>
                                                                        <option>French Guiana </option>
                                                                        <option>French Polynesia </option>
                                                                        <option>Gabon </option>
                                                                        <option>Gambia, The </option>
                                                                        <option>Gaza Strip </option>
                                                                        <option>Georgia </option>
                                                                        <option>Germany </option>
                                                                        <option>Ghana </option>
                                                                        <option>Gibraltar </option>
                                                                        <option>Greece </option>
                                                                        <option>Greenland </option>
                                                                        <option>Grenada </option>
                                                                        <option>Guadeloupe </option>
                                                                        <option>Guam </option>
                                                                        <option>Guatemala </option>
                                                                        <option>Guernsey </option>
                                                                        <option>Guinea </option>
                                                                        <option>Guinea-Bissau </option>
                                                                        <option>Guyana </option>
                                                                        <option>Haiti </option>
                                                                        <option>Honduras </option>
                                                                        <option>Hong Kong </option>
                                                                        <option>Hungary </option>
                                                                        <option>Iceland </option>
                                                                        <option>India </option>
                                                                        <option>Indonesia </option>
                                                                        <option>Iran </option>
                                                                        <option>Iraq </option>
                                                                        <option>Ireland </option>
                                                                        <option>Isle of Man </option>
                                                                        <option>Israel </option>
                                                                        <option>Italy </option>
                                                                        <option>Jamaica </option>
                                                                        <option>Japan </option>
                                                                        <option>Jersey </option>
                                                                        <option>Jordan </option>
                                                                        <option>Kazakhstan </option>
                                                                        <option>Kenya </option>
                                                                        <option>Kiribati </option>
                                                                        <option>Korea, North </option>
                                                                        <option>Korea, South </option>
                                                                        <option>Kuwait </option>
                                                                        <option>Kyrgyzstan </option>
                                                                        <option>Laos </option>
                                                                        <option>Latvia </option>
                                                                        <option>Lebanon </option>
                                                                        <option>Lesotho </option>
                                                                        <option>Liberia </option>
                                                                        <option>Libya </option>
                                                                        <option>Liechtenstein </option>
                                                                        <option>Lithuania </option>
                                                                        <option>Luxembourg </option>
                                                                        <option>Macau </option>
                                                                        <option>Macedonia </option>
                                                                        <option>Madagascar </option>
                                                                        <option>Malawi </option>
                                                                        <option>Malaysia </option>
                                                                        <option>Maldives </option>
                                                                        <option>Mali </option>
                                                                        <option>Malta </option>
                                                                        <option>Marshall Islands </option>
                                                                        <option>Martinique </option>
                                                                        <option>Mauritania </option>
                                                                        <option>Mauritius </option>
                                                                        <option>Mayotte </option>
                                                                        <option>Mexico </option>
                                                                        <option>Micronesia, Fed. St. </option>
                                                                        <option>Moldova </option>
                                                                        <option>Monaco </option>
                                                                        <option>Mongolia </option>
                                                                        <option>Montserrat </option>
                                                                        <option>Morocco </option>
                                                                        <option>Mozambique </option>
                                                                        <option>Namibia </option>
                                                                        <option>Nauru </option>
                                                                        <option>Nepal </option>
                                                                        <option>Netherlands </option>
                                                                        <option>Netherlands Antilles </option>
                                                                        <option>New Caledonia </option>
                                                                        <option>New Zealand </option>
                                                                        <option>Nicaragua </option>
                                                                        <option>Niger </option>
                                                                        <option>Nigeria </option>
                                                                        <option>N. Mariana Islands </option>
                                                                        <option>Norway </option>
                                                                        <option>Oman </option>
                                                                        <option>Pakistan </option>
                                                                        <option>Palau </option>
                                                                        <option>Panama </option>
                                                                        <option>Papua New Guinea </option>
                                                                        <option>Paraguay </option>
                                                                        <option>Peru </option>
                                                                        <option>Philippines </option>
                                                                        <option>Poland </option>
                                                                        <option>Portugal </option>
                                                                        <option>Puerto Rico </option>
                                                                        <option>Qatar </option>
                                                                        <option>Reunion </option>
                                                                        <option>Romania </option>
                                                                        <option>Russia </option>
                                                                        <option>Rwanda </option>
                                                                        <option>Saint Helena </option>
                                                                        <option>Saint Kitts &amp; Nevis </option>
                                                                        <option>Saint Lucia </option>
                                                                        <option>St Pierre &amp; Miquelon </option>
                                                                        <option>Saint Vincent and the Grenadines
                                                                        </option>
                                                                        <option>Samoa </option>
                                                                        <option>San Marino </option>
                                                                        <option>Sao Tome &amp; Principe </option>
                                                                        <option>Saudi Arabia </option>
                                                                        <option>Senegal </option>
                                                                        <option>Serbia </option>
                                                                        <option>Seychelles </option>
                                                                        <option>Sierra Leone </option>
                                                                        <option>Singapore </option>
                                                                        <option>Slovakia </option>
                                                                        <option>Slovenia </option>
                                                                        <option>Solomon Islands </option>
                                                                        <option>Somalia </option>
                                                                        <option>South Africa </option>
                                                                        <option>Spain </option>
                                                                        <option>Sri Lanka </option>
                                                                        <option>Sudan </option>
                                                                        <option>Suriname </option>
                                                                        <option>Swaziland </option>
                                                                        <option>Sweden </option>
                                                                        <option>Switzerland </option>
                                                                        <option>Syria </option>
                                                                        <option>Taiwan </option>
                                                                        <option>Tajikistan </option>
                                                                        <option>Tanzania </option>
                                                                        <option>Thailand </option>
                                                                        <option>Togo </option>
                                                                        <option>Tonga </option>
                                                                        <option>Trinidad &amp; Tobago </option>
                                                                        <option>Tunisia </option>
                                                                        <option>Turkey </option>
                                                                        <option>Turkmenistan </option>
                                                                        <option>Turks &amp; Caicos Is </option>
                                                                        <option>Tuvalu </option>
                                                                        <option>Uganda </option>
                                                                        <option>Ukraine </option>
                                                                        <option>United Arab Emirates </option>
                                                                        <option>United Kingdom </option>
                                                                        <option>United States </option>
                                                                        <option>Uruguay </option>
                                                                        <option>Uzbekistan </option>
                                                                        <option>Vanuatu </option>
                                                                        <option>Venezuela </option>
                                                                        <option>Vietnam </option>
                                                                        <option>Virgin Islands </option>
                                                                        <option>Wallis and Futuna </option>
                                                                        <option>West Bank </option>
                                                                        <option>Western Sahara </option>
                                                                        <option>Yemen </option>
                                                                        <option>Zambia </option>
                                                                        <option>Zimbabwe</option>
                                                                    </select>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-12 pt-10">
                                                    <h2 class="_head04 mb-10">Product <span>Details</span></h2>
                                                </div>

                                                <div class="col-12">

                                                    <div class="row" id="floating-label">

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Invoice
                                                                    For</label>
                                                                <input type="text" id="invoice_for"
                                                                    class="form-control customInvoiceField"
                                                                    placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">PTC Code </label>
                                                                <input type="text" id="ptc_code"
                                                                    class="form-control customInvoiceField"
                                                                    placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">SRO</label>
                                                                <input type="text" id="sro"
                                                                    class="form-control customInvoiceField"
                                                                    placeholder="">
                                                            </div>
                                                        </div>


                                                        <div class="col-md-4 pt-10">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">S/B No </label>
                                                                <input type="text" id="sb_no"
                                                                    class="form-control customInvoiceField"
                                                                    placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4" style="padding-top:5px;">
                                                            <label class="font12 mb-5">S/B Date: </label>
                                                            <div class="">
                                                                <input type="text" id="sb_date"
                                                                    class="form-control customInvoiceField datepicker"
                                                                    placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Marks No </label>
                                                                <input type="text" id="marks_no"
                                                                    class="form-control customInvoiceField"
                                                                    placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">S/T No</label>
                                                                <input type="text" id="st_no"
                                                                    class="form-control customInvoiceField"
                                                                    placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 PT-20">
                                                            <h2 class="_head04">LC <span>Details</span></h2>
                                                        </div>
                                                        <div class="col-md-4 PT-10">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">L/C Through
                                                                </label>
                                                                <input type="text" id="lc_through"
                                                                    class="form-control customInvoiceField lcRequired"
                                                                    placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 PT-10">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">L/C Number
                                                                </label>
                                                                <input type="text" id="lc_number"
                                                                    class="form-control customInvoiceField lcRequired"
                                                                    placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4" style="padding-top:5px;">
                                                            <label class="font12 mb-5">L/C Date</label>
                                                            <div class="">
                                                                <input type="text" id="lc_date"
                                                                    class="form-control customInvoiceField datepicker lcRequired"
                                                                    placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mb-5 PT-20">
                                                            <div class="row m-0 justify-content-end">
                                                                <div class="col-auto FontLabVal"><strong>FOB
                                                                        Value</strong></div>
                                                                <div class="col-auto selectCurr"><select
                                                                        id="fob_currency"
                                                                        class="custom-select custom-select-sm customInvoiceField">
                                                                        <option selected value="USD">USD</option>
                                                                        <option value="PKR">PKR</option>
                                                                        <option value="HKD">HKD</option>
                                                                        <option value="AFN">AFN</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-auto p-0 FOBVal"><input type="number"
                                                                        id="fob_value"
                                                                        class="form-control FOBVinput customInvoiceField">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="row m-0 justify-content-end">
                                                                <div class="col-auto FontLabVal">
                                                                    <strong>Discount</strong></div>
                                                                <div class="col-auto selectCurr"><select
                                                                        id="discount_currency"
                                                                        class="custom-select custom-select-sm customInvoiceField">
                                                                        <option selected value="USD">USD</option>
                                                                        <option value="PKR">PKR</option>
                                                                        <option value="HKD">HKD</option>
                                                                        <option value="AFN">AFN</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-auto p-0 FOBVal"><input type="number"
                                                                        id="discount"
                                                                        onchange="if(this.value > 100) return false;"
                                                                        class="form-control customInvoiceField">
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row m-0 PT-15 pb-10">
                                                <button type="submit" class="btn btn-primary mr-2"
                                                    id="saveCustominvInfo">Save</button>
                                                <button type="submit" class="btn btn-cancel mr-2">Cancel</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade {{ $order['products_selection'] ? 'show active' : '' }}"
                            id="v-pills-01" role="tabpanel" aria-labelledby="v-pills-01-tab">
                            <div class="CB_info">
                                <div id="floating-label" class="card top_border mb-3">
                                    <div class="col-md-12">
                                        <div class="form-wrap PT-10 pb-15">
                                            <div class="row shipmentSectionDiv">
                                                <div class="col-md-12 pt-10 allDiv">
                                                    <h2 class="_head04">Shipping
                                                        <span>Information</span>
                                                        <div class="OD-invoiceNo">Invoice No:
                                                            <span id="invoice_num">..</span></div>
                                                    </h2>
                                                </div>
                                                <div class="col-12 pt-5">
                                                    <div class="row ST-sec">
                                                        <div class="col-auto"><strong>Select Shipment
                                                                Type:</strong></div>
                                                        <div class="col-auto">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" type="radio"
                                                                    name="order_type" id="weekly" value='FOB'
                                                                    {{ $order['order_type'] == "FOB" ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="weekly">FOB</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" type="radio"
                                                                    name="order_type" id="biweekly" value='CFR'
                                                                    {{ $order['order_type'] == "CFR" ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="biweekly">CFR</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" type="radio"
                                                                    name="order_type" id="monthly" value='CFI'
                                                                    {{ $order['order_type'] == "CFI" ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="monthly">CFI</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 pt-10">
                                                    <div class="row">
                                                        <div class="col-2 nonFobDiv">
                                                            <label class="font12">Date of
                                                                Shipment</label>
                                                            <div class="form-group" style="height: auto !important">
                                                                <input type="text" id="date_of_shipment"
                                                                    class="form-control dispatchOrderDatepicker required"
                                                                    placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 nonFobDiv">
                                                            <label class="font12">Shipping Company*</label>
                                                            <div class="form-s2">
                                                                <select class="form-control formselect required"
                                                                    placeholder="Select Secondary Customer"
                                                                    id="shipment_company">
                                                                    <option disabled selected>Select Shipping
                                                                        Company
                                                                    </option>
                                                                    @foreach ($shippers as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->company_name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 nonFobDiv">
                                                            <label class="font12">Forwarder*</label>
                                                            <div class="form-s2">
                                                                <select class="form-control formselect required"
                                                                    placeholder="Select Secondary Customer"
                                                                    id="forwarder">
                                                                    <option disabled selected>Select Company
                                                                    </option>
                                                                    @foreach ($forwarders as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->company_name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-2 allField" style="padding-top:2px;">
                                                            <label class="font12 mb-5">ETA*</label>
                                                            <div class="form-group" style="height: auto !important">
                                                                <input type="text" id="eta_date"
                                                                    class="form-control dispatchOrderDatepicker required"
                                                                    placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-2 allField" style="padding-top:2px;">
                                                            <label class="font12 mb-5">EDT*</label>
                                                            <div class="form-group" style="height: auto !important">
                                                                <input type="text" id="expected_delivery_date"
                                                                    class="form-control dispatchOrderDatepicker required"
                                                                    placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-2 nonFobDiv">
                                                            <label class="font12">Discharge Date*</label>
                                                            <div class="form-group" style="height: auto !important">
                                                                <input type="text"
                                                                    class="form-control dispatchOrderDatepicker required"
                                                                    placeholder="" id="discharge_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 nonFobDiv">
                                                            <label class="font12">Discharge Port*</label>
                                                            <div class="form-s2">
                                                                <select class="form-control formselect required"
                                                                    placeholder="Select Payment Type"
                                                                    id="port_of_discharge" style="width: 100%">
                                                                    <option disabled selected>Select Port of
                                                                        Discharge
                                                                    </option>
                                                                    @foreach ($ports as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->port_name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-10 nonFobDiv">
                                                            <label class="font12">Select Route*</label>
                                                            <div class="form-s2">
                                                                <select class="form-control sd-type required"
                                                                    multiple="multiple" style="width: 100%"
                                                                    id="shipment_route">
                                                                    @foreach ($ports as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->port_name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 PT-5 nonFobDiv">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Voyage
                                                                    Number*</label>
                                                                <input type="text" id="voyage_number"
                                                                    class="form-control required" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 PT-5 nonFobDiv">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Vessel
                                                                    Name*</label>
                                                                <input type="text" id="vessel_name"
                                                                    class="form-control required" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 PT-5 nonFobDiv">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Vessel
                                                                    Number*</label>
                                                                <input type="text" id="vessel_number"
                                                                    class="form-control required" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 PT-5 nonFobDiv">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">OMI
                                                                    Number*</label>
                                                                <input type="text" id="omi_number"
                                                                    class="form-control required" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-10 nonFobDiv">
                                                            <h2 class="_head04">Container <span> Type</span>
                                                            </h2>
                                                        </div>
                                                        <div class="col-12 mb-10 nonFobDiv">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label class="font12 mb-0">Container
                                                                        Type*</label>
                                                                    <select class="custom-select mt-5"
                                                                        id="containerTypeDD">
                                                                        <option disabled selected>Select Container
                                                                            Type
                                                                        </option>
                                                                        <option>20 FT</option>
                                                                        <option>40 FT</option>
                                                                        <option>40 FT HC</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mt-5">
                                                                        <label class="control-label mb-5">Container
                                                                            No.*</label>
                                                                        <input type="text" id="containerNumber"
                                                                            class="form-control" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 _addSecon-btn">
                                                                    <button type="button" class="btn btn-primary mr-2"
                                                                        id="addContainerTypes">Add</button>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12"
                                                                    id="dynamicallyAddedContainerTypes">
                                                                    <hr class="mt-10 mb-10">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-10 nonFobDiv">
                                                            <h2 class="_head04">Freight <span>
                                                                    Charges</span></h2>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-12 PT-5">
                                                                    <div class="row nonFobDiv">
                                                                        <div class="col"><strong
                                                                                class="PT-5 font13">Quoted
                                                                                Charges*</strong></div>
                                                                        <div class="col-auto selectCurr">
                                                                            <select
                                                                                class="custom-select custom-select-sm"
                                                                                id="quoted_charges_currency">
                                                                                <option disabled selected>Select
                                                                                    Currency</option>
                                                                                <option sign="$" value="USD">USD
                                                                                </option>
                                                                                <option sign="Rs" value="PKR" selected>
                                                                                    PKR
                                                                                </option>
                                                                                <option sign="HK$" value="HKD">HKD
                                                                                </option>
                                                                                <option sign="AFN" value="AFN">AFN
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-3  pl-0">
                                                                            <input type="text"
                                                                                id="quoted_freight_charges"
                                                                                class="form-control required" value="0">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <hr class="mt-5  mb-5">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row nonFobDiv">
                                                                        <div class="col"><strong
                                                                                class="PT-5 font13">Actual
                                                                                Freight*</strong></div>
                                                                        <div class="col-auto selectCurr">
                                                                            <select
                                                                                class="custom-select custom-select-sm"
                                                                                id="actual_freight_currency">
                                                                                <option disabled selected>Select
                                                                                    Currency</option>
                                                                                <option sign="$" value="USD">USD
                                                                                </option>
                                                                                <option sign="Rs" value="PKR" selected>
                                                                                    PKR
                                                                                </option>
                                                                                <option sign="HK$" value="HKD">HKD
                                                                                </option>
                                                                                <option sign="AFN" value="AFN">AFN
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-3  pl-0">
                                                                            <input type="text"
                                                                                id="actual_freight_charges"
                                                                                class="form-control required" value="0">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <hr class="mt-5  mb-5">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row nonFobDiv insuranceDiv">
                                                                        <div class="col"><strong
                                                                                class="PT-5 font13">Insurance
                                                                                Charges*</strong></div>
                                                                        <div class="col-auto selectCurr">
                                                                            <select
                                                                                class="custom-select custom-select-sm"
                                                                                id="insurance_charges_currency">
                                                                                <option disabled selected>Select
                                                                                    Currency</option>
                                                                                <option sign="$" value="USD">USD
                                                                                </option>
                                                                                <option sign="Rs" value="PKR" selected>
                                                                                    PKR
                                                                                </option>
                                                                                <option sign="HK$" value="HKD">HKD
                                                                                </option>
                                                                                <option sign="AFN" value="AFN">AFN
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-3  pl-0">
                                                                            <input type="text" id="insurance_charges"
                                                                                class="form-control required" value="0">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <hr class="mt-5  mb-5">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="shipmentDzDiv" class="col-md-12 pt-10 mb-10">
                                                            <h2 class="_head04">Documents <span> Upload
                                                                    (images, pdf, doc, docx,
                                                                    xlsx)</span></h2>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div id="shippingDocsDzContainer"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row m-0 PT-15">
                                                <button type="button" class="btn btn-primary mr-2"
                                                    id="saveShipmentInfo">Save</button>
                                                <a href="/OrderDetails/{{ Request::segment(2) }}"
                                                    class="btn btn-cancel mr-2">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-02" role="tabpanel" aria-labelledby="v-pills-02-tab">
                            <div class="CB_info">
                                <div id="floating-label" class="card top_border mb-3">
                                    <div class="col-md-12">
                                        <div class="form-wrap PT-10 pb-15">
                                            <div class="row">
                                                <div class="col-md-12 pt-10 mb-10">
                                                    <h2 class="_head04">e-form <span></span>
                                                        <div class="OD-invoiceNo">e-From Number:
                                                            <span id="eform_num">E-0154585</span></div>
                                                    </h2>
                                                </div>
                                                <div class="col-md-6 PT-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Bank*</label>
                                                        <input type="text" id="bank_name" class="form-control required"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="font12" style="margin-bottom: 6px">Issue
                                                        Date*</label>
                                                    <div class="form-group" style="height: auto !important">
                                                        <input type="text" id="issue_date"
                                                            class="form-control required dispatchOrderDatepicker"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 PT-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Total
                                                            Invoice*</label>
                                                        <input type="text" id="total_amount" class="form-control"
                                                            placeholder="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 PT-5">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Form E Number
                                                        </label>
                                                        <input type="text" id="form_e_no" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="font12 mb-5">Currency*</label>
                                                    <div class="form-s2">
                                                        <select class="form-control formselect"
                                                            placeholder="Select Type" id="currency"
                                                            style="width: 100% !important">
                                                            <option disabled selected>Select Currency</option>
                                                            <option sign="$" value="USD">USD - United States Dollar
                                                            </option>
                                                            <option sign="Rs" value="PKR" selected>PKR - Pakistan
                                                                Rupees
                                                            </option>
                                                            <option sign="HK$" value="HKD">HKD — Hong Kong dollar
                                                            </option>
                                                            <option sign="AFN" value="AFN">AFN — Afghani</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pt-10 mb-10">
                                                    <h2 class="_head04">Documents <span> Upload
                                                            <small>(images, pdf, doc, docx, xlsx)</small></span>
                                                    </h2>
                                                </div>
                                                <div class="col-md-12">
                                                    <div id="eformDocsDzContainer"></div>
                                                </div>
                                            </div>
                                            <div class="row m-0 PT-15">
                                                <button type="button" class="btn btn-primary mr-2"
                                                    id="saveEformInfo">Save</button>
                                                <a href="/OrderDetails/{{ Request::segment(2) }}"
                                                    class="btn btn-cancel mr-2">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-03" role="tabpanel" aria-labelledby="v-pills-03-tab">
                            <div class="tab-pane fade show active" id="v-pills-01" role="tabpanel"
                                aria-labelledby="v-pills-01-tab">
                                <div class="CB_info">
                                    <div id="floating-label" class="card top_border mb-3">
                                        <div class="col-md-12">
                                            <div class="form-wrap PT-10 PB-20">
                                                <div class="row">
                                                    <div class="col-md-12 pt-10 mb-0">
                                                        <h2 class="_head04 mb-0">Packing
                                                            <span>List</span></h2>
                                                    </div>
                                                    <div class="col-md-12 productRate-table m-0" style="overflow-x:scroll">
                                                        <table class="table table-hover dt-responsive nowrap table-PL"
                                                            style="width:1000px !important">
                                                            <thead>
                                                                <tr>
                                                                    <th>Carton No.</th>
                                                                    <th>Product Name</th>
                                                                    <th>Cartons</th>
                                                                    <th>Net Weight </th>
                                                                    <th>Unit Weight </th>
                                                                    <th>Variant Weight </th>
                                                                    <th>Gross Weight </th>
                                                                    <th>Actual N.W </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $stat = [ 'ctn' => 0, 'nw' => 0, 'gw' => 0, 'acnw' => 0 ]; ?>
                                                                @foreach ($order['contents'] as $item)
                                                                @if (!isset($item['not_assigned_for_dispatch']))
                                                                <tr class="packingListTr" batch="{{ $item['batch'] }}"
                                                                    item-id="{{ $item['item_id'] }}"
                                                                    assignment-id="{{ $item['id'] }}">
                                                                    <td>
                                                                        <input type="text"
                                                                            class="from_ctn_no CN-st-end required"
                                                                            placeholder="0"
                                                                            value="{{ $item['from_ctn_no'] }}">
                                                                        to
                                                                        <input type="text"
                                                                            class="to_ctn_no CN-st-end required"
                                                                            placeholder="0"
                                                                            value="{{ $item['to_ctn_no'] }}"></td>
                                                                    <td class="product_name_plist">
                                                                        <span
                                                                            style="display: block">{{ $item['product_name'] }}</span>
                                                                        <small
                                                                            style="display: block; margin: 4px 0px">{{ $item['item_name'] }}</small>
                                                                    </td>
                                                                    <td class="quantity_plist">
                                                                        {{ ($item["dispatched_quantity"]) }}
                                                                    </td>
                                                                    <td class="net_weight_plist">
                                                                        {{ ROUND(($item["dispatched_quantity"]*$item["weight_per_ctn"]), 2) }}
                                                                    </td>
                                                                    <td class="unit_weight_plist">
                                                                        {{ ROUND(($item["unit_weight"]), 2) }}
                                                                    </td>
                                                                    <td class="variant_weight_plist">
                                                                        {{ ROUND(($item["unit_weight"]*$item["unit_quantity"]), 2) }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="text"
                                                                            class="gross_weight cu-Rate required"
                                                                            placeholder="0"
                                                                            value="{{ $item['gross_weight'] }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number"
                                                                            class="dispatch_actual_NW cu-Rate required"
                                                                            placeholder="0"
                                                                            value="{{ $item['dispatch_actual_NW'] }}">
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                <?php $stat['ctn'] += ($item["dispatched_quantity"]);
                                                                    $stat['nw'] += ROUND(($item["dispatched_quantity"]*$item["weight_per_ctn"]), 2); ?>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>Total</th>
                                                                    <th id="ttlCtnsPackingList">{{ $stat['ctn'] }}
                                                                        CTNS
                                                                    </th>
                                                                    <th id="netWeightPackingList">{{$stat['nw']}}
                                                                        KGS
                                                                    </th>
                                                                    <th id="unitWeightPackingList"></th>
                                                                    <th id="variantWeightpackingList"></th>
                                                                    <th id="grossWeightPackingList">0 KGS</th>
                                                                    <th id="actual_NW_packingList">0 KGS</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row m-0 PT-15">
                                                    <button type="button" class="btn btn-primary mr-2"
                                                        id="savePackingList">Save</button>
                                                    <a href="/OrderDetails/{{ Request::segment(2) }}"
                                                        class="btn btn-cancel mr-2">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-04" role="tabpanel" aria-labelledby="v-pills-04-tab">
                            <div class="CB_info">
                                <div id="floating-label" class="card top_border mb-3">
                                    <div class="col-md-12">
                                        <div class="form-wrap PT-10 PB-20">
                                            <div class="row">
                                                <div class="col-md-12 pt-10 mb-0">
                                                    <h2 class="_head04">Commercial <span>Invoice</span>
                                                    </h2>
                                                </div>
                                                <div class="col-md-12 productRate-table m-0">
                                                    <table class="table table-hover dt-responsive nowrap table-PL"
                                                        style="width:100% !important">
                                                        <thead>
                                                            <tr>
                                                                <th>QTY. In CTNS</th>
                                                                <th>Product Name</th>
                                                                <th>Unit Price(
                                                                    {{ $order['currency']. ' '.$order['currency_symbol'] }}
                                                                    )</th>
                                                                <th>Amount(
                                                                    {{ $order['currency']. ' '.$order['currency_symbol'] }}
                                                                    )</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($order['contents'] as $item)
                                                            @if (!isset($item['not_assigned_for_dispatch']))
                                                            <tr class="commercialPricesTr" batch="{{ $item['batch'] }}"
                                                                item-id="{{ $item['item_id'] }}"
                                                                assignment-id="{{ $item['id'] }}">
                                                                <td>{{ $item["dispatched_quantity"] }}
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        style="display: block">{{ $item['product_name'] }}</span>
                                                                    <small
                                                                        style="display: block; margin: 4px 0px">{{ $item['item_name'] }}</small>
                                                                </td>
                                                                <td>{{ $order['currency_symbol'] }}
                                                                    <input type="text"
                                                                        value="{{ number_format($item['commercial_unit_price']) }}"
                                                                        class="cu-Rate commercialUnitPrice required"
                                                                        placeholder="0"
                                                                        real-val="{{ $item['commercial_unit_price'] }}"
                                                                        item-id='{{ $item['id'] }}'>
                                                                </td>
                                                                <td class="totalAmountCommercial">
                                                                    <span>{{ $order['currency_symbol'].' '.number_format($item['commercial_amount']) }}</span>
                                                                    <input type="text" class="final_amount required"
                                                                        value="{{ $item['commercial_amount'] }}" hidden>
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row m-0 PT-15">
                                                <button type="button" class="btn btn-primary mr-2"
                                                    id="saveCommercialPrices">Save</button>
                                                <a href="/OrderDetails/{{ Request::segment(2) }}"
                                                    class="btn btn-cancel mr-2">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-05" role="tabpanel" aria-labelledby="v-pills-05-tab">
                            <div class="CB_info">
                                <div id="floating-label" class="card top_border mb-3">
                                    <div class="col-md-12">
                                        <div class="form-wrap PT-10 PB-20">
                                            <div class="row">
                                                <div class="col-md-12 pt-10 mb-10">
                                                    <h2 class="_head04">Documents <span> Upload
                                                            <small>(images, pdf, doc, docx, xlsx)</small></span>
                                                    </h2>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-s2">
                                                        <select class="form-control formselect"
                                                            placeholder="select document" style="width: 100%"
                                                            id="all_documents">
                                                            <option disabled selected>Select Document
                                                            </option>
                                                            <option value="Certificate of Origin">Certificate of
                                                                Origin
                                                            </option>
                                                            <option value="External Health Certificate">External
                                                                Health
                                                                Certificate</option>
                                                            <option value="Product Specification Documents">Product
                                                                Specification Documents</option>
                                                            <option value="Sanitary Certificate">Sanitary
                                                                Certificate
                                                            </option>
                                                            <option value="PCSIR">PCSIR</option>
                                                            <option value="Phytosanitry">Phytosanitry</option>
                                                            <option value="Form A">Form A</option>
                                                            <option value="GD">GD</option>
                                                            <option value="Milk Certificate">Milk Certificate
                                                            </option>
                                                            <option value="Health Certificat">Health Certificate
                                                                Govt
                                                                Issued
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 PT-5">
                                                    <label class="font12">Documents Attachment</label>
                                                    <div class="">
                                                        <div id="diffTypesOfDocumentsDispatchOrdersDzContainer">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="allDocsContainer"></div>
                                            </div>
                                            <div class="row m-0 PT-15">
                                                <button type="button" class="btn btn-primary mr-2"
                                                    id="saveAllDocuments">Save</button>
                                                <a href="/OrderDetails/{{ Request::segment(2) }}"
                                                    class="btn btn-cancel mr-2">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-06" role="tabpanel" aria-labelledby="v-pills-06-tab">
                            <div class="CB_info">
                                <div id="floating-label" class="card top_border mb-3">
                                    <div class="col-md-12">
                                        <div class="form-wrap PT-10 PB-20">
                                            <div class="row">
                                                <div class="col-md-12 pt-10 mb-0">
                                                    <h2 class="_head04">System <span> Generated</span>
                                                    </h2>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row m-0">
                                                        <div class="col-md-8 SysGenHead"><strong>Name</strong></div>
                                                        <div class="col-md-4 SysGenHead"><strong>Action</strong>
                                                        </div>
                                                    </div>
                                                    <div class="row SysGen-row">
                                                        <div class="col-md-8"><strong>Commercial Invoice</strong>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button class="btn smBTN btn-line mb-0" type="button"
                                                                data-toggle="collapse" data-target="#editcolum"
                                                                aria-expanded="false"
                                                                aria-controls="editcolum ">Edit</button>
                                                            <a id="/fpdf/comercial_invoice.php?oid={{ Request::segment(2) }}"
                                                                class="btn smBTN mb-0 preview_pdf_btn"
                                                                style="color:white !important">Preview</a></div>

                                                        <div class="col-12 collapse" id="editcolum">
                                                            <div class="row editcolumDiv">
                                                                <div class="col">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" name="marks" checked
                                                                            class="custom-control-input pramas_check_box"
                                                                            value="marks" id="marks">
                                                                        <label class="custom-control-label"
                                                                            for="marks">Marks & No.s</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" name="qty" checked
                                                                            class="custom-control-input pramas_check_box"
                                                                            value="qty" id="qty">
                                                                        <label class="custom-control-label"
                                                                            for="qty">QTY.
                                                                            In CTNS</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" name="goods" checked
                                                                            class="custom-control-input pramas_check_box"
                                                                            value="goods" id="goods">
                                                                        <label class="custom-control-label"
                                                                            for="goods">Product Name</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" name="price" checked
                                                                            class="custom-control-input pramas_check_box"
                                                                            value="price" id="price">
                                                                        <label class="custom-control-label"
                                                                            for="price">Unit
                                                                            Price</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" name="amount" checked
                                                                            class="custom-control-input pramas_check_box"
                                                                            value="amount" id="amount">
                                                                        <label class="custom-control-label"
                                                                            for="amount">Amount</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row SysGen-row">
                                                        <div class="col-md-8"><strong>Packing List</strong>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button class="btn smBTN btn-line mb-0" type="button"
                                                                data-toggle="collapse" data-target="#editcolum2"
                                                                aria-expanded="false"
                                                                aria-controls="editcolum">Edit</button>
                                                            <a id="/fpdf/packing_list.php?oid={{ Request::segment(2) }}"
                                                                class="btn smBTN mb-0 preview_pdf_btn"
                                                                style="color:white !important">Preview</a></div>

                                                        <div class="col-12 collapse" id="editcolum2">
                                                            <div class="row editcolumDiv">
                                                                <div class="col">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" name="ctn_no" checked
                                                                            class="custom-control-input pramas_check_box"
                                                                            value="ctn_no" id="ctn_no">
                                                                        <label class="custom-control-label"
                                                                            for="ctn_no">CARTON & NO.</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" name="p-goods" checked
                                                                            class="custom-control-input pramas_check_box"
                                                                            value="p-goods" id="p-goods">
                                                                        <label class="custom-control-label"
                                                                            for="p-goods">Product Name</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" name="p-qty" checked
                                                                            class="custom-control-input pramas_check_box"
                                                                            value="p-qty" id="p-qty">
                                                                        <label class="custom-control-label"
                                                                            for="p-qty">CARTONS</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" name="net_weight" checked
                                                                            class="custom-control-input pramas_check_box"
                                                                            value="net_weight" id="net_weight">
                                                                        <label class="custom-control-label"
                                                                            for="net_weight">NET WEIGHT</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" name="gross_weight"
                                                                            checked
                                                                            class="custom-control-input pramas_check_box"
                                                                            value="gross_weight" id="gross_weight">
                                                                        <label class="custom-control-label"
                                                                            for="gross_weight">Gross WEIGHT</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row SysGen-row">
                                                        <div class="col-md-8"><strong>Health Certifcate</strong>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a id="/fpdf/health_certificate.php?oid={{ Request::segment(2) }}/{{ Request::segment(3) }}"
                                                                class="btn smBTN mb-0 without_params_pdf"
                                                                style="color:white !important">Preview</a></div>
                                                    </div>

                                                    <div class="row SysGen-row">
                                                        <div class="col-md-8"><strong>Quality Control
                                                                Certificate</strong></div>
                                                        <div class="col-md-4">
                                                            <a id="/fpdf/quality_control.php?oid={{ Request::segment(2) }}/{{ Request::segment(3) }}"
                                                                class="btn smBTN mb-0 without_params_pdf"
                                                                style="color:white !important">Preview</a></div>
                                                    </div>

                                                    <div class="row SysGen-row">
                                                        <div class="col-md-8"><strong>Certifcate of
                                                                Conformity</strong>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a id="/fpdf/conformity.php?oid={{ Request::segment(2) }}/{{ Request::segment(3) }}"
                                                                class="btn smBTN mb-0 without_params_pdf"
                                                                style="color:white !important">Preview</a></div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="row m-0 PT-15">
                                                <button type="button" class="btn btn-primary mr-2"
                                                    id="processOrder">Process</button>
                                                <a href="/OrderDetails/{{ Request::segment(2) }}"
                                                    class="btn btn-cancel mr-2">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-08" role="tabpanel" aria-labelledby="v-pills-08-tab">
                            <div class="CB_info">
                                <div id="floating-label" class="card top_border mb-3">
                                    <div class="col-md-12">
                                        <div class="form-wrap PT-10 PB-20">
                                            <div class="row">
                                                <div class="col-md-12 pt-10 mb-0">
                                                    <h2 class="_head04">Health <span> Detail</span>
                                                    </h2>
                                                </div> 
                                                <div class="col-md-12 pt-10 mb-0">
                                                    <textarea id="health_detail" name="health_detail" rows="8" placeholder="About Health Detail">@foreach($certificates as $data)
                                                            @if ($data->type == 'health')
                                                                {{$data->text}}
                                                            @endif 
                                                        @endforeach
                                                    </textarea>
                                                </div> 
                                            </div>
                                            <div class="row m-0 PT-15">
                                                <button type="button" class="btn btn-primary mr-2 save_paragraph" detail-type ="health">Save</button>
                                                <a href="/OrderDetails/{{ Request::segment(2) }}" class="btn btn-cancel mr-2">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-09" role="tabpanel" aria-labelledby="v-pills-09-tab">
                            <div class="CB_info">
                                <div id="floating-label" class="card top_border mb-3">
                                    <div class="col-md-12">
                                        <div class="form-wrap PT-10 PB-20">
                                            <div class="row">
                                                <div class="col-md-12 pt-10 mb-0">
                                                    <h2 class="_head04">Quality <span> Detail</span>
                                                    </h2>
                                                </div> 
                                                <div class="col-md-12 pt-10 mb-0">
                                                    <textarea id="quality_detail" name="quality_detail" rows="8" placeholder="About Quality Detail">
                                                        @foreach($certificates as $data)
                                                            @if ($data->type == 'quality')
                                                                {{$data->text}}
                                                            @endif 
                                                        @endforeach
                                                    </textarea>
                                                </div> 
                                            </div>
                                            <div class="row m-0 PT-15">
                                                <button type="button" class="btn btn-primary mr-2 save_paragraph" detail-type="quality">Save</button>
                                                <a href="/OrderDetails/{{ Request::segment(2) }}" class="btn btn-cancel mr-2">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-10" role="tabpanel" aria-labelledby="v-pills-10-tab">
                            <div class="CB_info">
                                <div id="floating-label" class="card top_border mb-3">
                                    <div class="col-md-12">
                                        <div class="form-wrap PT-10 PB-20">
                                            <div class="row">
                                                <div class="col-md-12 pt-10 mb-0">
                                                    <h2 class="_head04">Conformity <span> Detail</span>
                                                    </h2>
                                                </div> 
                                                <div class="col-md-12 pt-10 mb-0">
                                                    <textarea id="conformity_detail" name="conformity_detail" rows="8" placeholder="About Compormity Detail">
                                                        @foreach($certificates as $data)
                                                            @if ($data->type == 'conformity')
                                                                {{$data->text}}
                                                            @endif 
                                                        @endforeach
                                                    </textarea>
                                                </div> 
                                            </div>
                                            <div class="row m-0 PT-15">
                                                <button type="button" class="btn btn-primary mr-2 save_paragraph" detail-type="conformity">Save</button>
                                                <a href="/OrderDetails/{{ Request::segment(2) }}" class="btn btn-cancel mr-2">Cancel</a>
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
@endsection
<script>
    orderData = JSON.parse('{!! json_encode($order) !!}');
    setTimeout(()=>{
        $('#loaderWaitDiv').hide();
        $('#v-pills-tabContent').show();
    },2000);

</script>
