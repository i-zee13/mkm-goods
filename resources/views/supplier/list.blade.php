@extends('layouts.master')
@section('data-sidebar')
<div id="product-cl-sec">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span>Supplier</span></div>
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
                                <form style="display: flex;" id="saveSupplierForm">
                                    {!! Form::hidden('supplier_updating_id', '') !!}
                                    {!! Form::hidden('tokenForAjaxReq', csrf_token()) !!}
                                    @csrf
                                    <input type="text" id="operation" hidden>
                                    <input type="text" name="product_types" hidden>
                                    <div id="floating-label" class="card p-20 top_border mb-3">
                                        <h2 class="_head03">Supplier <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">ID*</label>
                                                        <input type="text" name="supplier_custom_id"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Company Name*</label>
                                                        <input type="text" name="compName" class="form-control"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">POC*</label>
                                                        <input type="text" name="poc" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Job Title</label>
                                                        <input type="text" name="job_title" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Business Phone*</label>
                                                        <input type="number" name="businessPh" class="form-control"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Mobile Number</label>
                                                        <input type="number" name="mobPh" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h2 class="_head03 PT-20">Contact <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Home Phone</label>
                                                        <input type="number" name="homePh" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">WhatsApp No</label>
                                                        <input type="number" name="whatsappPh" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Fax No</label>
                                                        <input type="number" name="faxPh" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Address</label>
                                                        <input type="text" name="address" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">City</label>
                                                        <input type="text" name="city" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">State/Province</label>
                                                        <input type="text" name="state" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Zip/Postal Code</label>
                                                        <input type="text" name="postal" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-s2 pt-19">
                                                        <select class="form-control formselect" name="country"
                                                            placeholder="select Country*">
                                                            <option value="0">Select Country*</option>
                                                            <option>Afghanistan </option>
                                                            <option>Albania </option>
                                                            <option>Algeria </option>
                                                            <option>American Samoa </option>
                                                            <option>Andorra </option>
                                                            <option>Angola </option>
                                                            <option>Anguilla </option>
                                                            <option>Antigua & Barbuda </option>
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
                                                            <option>Bosnia & Herzegovina </option>
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
                                                            <option>Saint Kitts & Nevis </option>
                                                            <option>Saint Lucia </option>
                                                            <option>St Pierre & Miquelon </option>
                                                            <option>Saint Vincent and the Grenadines </option>
                                                            <option>Samoa </option>
                                                            <option>San Marino </option>
                                                            <option>Sao Tome & Principe </option>
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
                                                            <option>Trinidad & Tobago </option>
                                                            <option>Tunisia </option>
                                                            <option>Turkey </option>
                                                            <option>Turkmenistan </option>
                                                            <option>Turks & Caicos Is </option>
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
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Region</label>
                                                        <input type="text" name="region" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Email address</label>
                                                        <input type="text" name="email" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Web Page Address</label>
                                                        <input type="text" name="webpage" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h2 class="_head03 PT-20">Additional <span>Details</span></h2>
                                        <div class="form-s2">
                                            <label class="PT-10 font12">Product Type</label>
                                            <select id="product_types" class="form-control sd-type" multiple="multiple">
                                                <option value="Product Type 51">Product Type 51</option>
                                                <option value="Product Type 41">Product Type 41</option>
                                                <option value="Types 2">Types 2</option>
                                                <option value="Types 3">Types 3</option>
                                                <option value="Types 4">Types 4</option>
                                                <option value="Types 5">Types 5</option>
                                                <option value="Types 6">Types 6</option>
                                                <option value="Types 7">Types 7</option>
                                                <option value="Types 8">Types 8</option>
                                            </select>
                                        </div>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="PT-10 font12">Remarks</label>
                                                    <div class="form-group">
                                                        <textarea name="remarks" rows="8"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div id="floating-label" class="card p-20 top_border mb-3">
                                    <form action="/supplierDocsDzRoute" class="dropzone" id="supplieDzForm"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="text" name="docRefKey" hidden>
                                        <input type="text" name="supplier_id" hidden>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2" id="saveSupplier">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelSupplier">Cancel</button>
    </div>
</div>
@endsection
@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Supplier <span>Management</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Suppliers</span></a></li>
            <li><span>Active</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <a class="btn add_button openDataSidebarForAddingSupplier"><i class="fa fa-plus"></i> New Supplier</a>
                <h2>Suppliers List</h2>
            </div>
            <div style="min-height: 400px" id="tblLoader">
                <img src="/images/loader.gif" width="30px" height="auto"
                    style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body" style="display: none">
            </div>
        </div>
    </div>
</div>
@endsection
