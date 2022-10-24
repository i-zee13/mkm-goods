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
            <div class="overflow-plist">
                <div class="plist-content">
                    <div class="_left-filter pt-0">
                        <div class="se_cus-type p-20 mb-3">
                            <input hidden type="text" id="hidden_cust_type" value="{{$types}}" />
                            <h2 class="_head04 border-0">Select <span> Customer Type*</span></h2>
                            <div class="form-s2">
                                <select class="form-control formselect required" name="type"
                                    placeholder="Select Customer Type*">
                                    <option value="0" disabled selected>Select Customer Type*</option>
                                    @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                    @endforeach
                                </select>
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
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Company ID</label>
                                                        <input type="text" name="compId" class="form-control">
                                                    </div>
                                                    <small id="idTakenError" style="color: red; display: none">This id
                                                        is already taken</small>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Company Name*</label>
                                                        <input type="text" name="compName"
                                                            class="form-control required">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-s2">
                                                        <label class="font12">Parent Company</label>
                                                        <select class="form-control formselect" name="parentCompnay"
                                                            placeholder="select Parent Company">
                                                            <option value="0">Select Parent Company</option>
                                                            @foreach ($customers as $comp)
                                                            <option value="{{ $comp->id }}">{{ $comp->company_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h2 class="_head03 PT-20">Contact <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Business Phone*</label>
                                                        <input type="text" name="businessPh"
                                                            class="form-control required" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Fax No</label>
                                                        <input type="text" name="faxPh" class="form-control"
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
                                                        <label class="control-label mb-10">Address*</label>
                                                        <input type="text" name="address" class="form-control required"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">City*</label>
                                                        <input type="text" name="city" class="form-control required"
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
                                                        <label class="control-label mb-10">Zip/Postal</label>
                                                        <input type="text" name="zip" class="form-control"
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
                                                <div class="col-md-12">
                                                    <div class="form-s2">
                                                        <label class="font12">Country*</label>
                                                        <select class="form-control formselect required" name=country
                                                            placeholder="select Country*">
                                                            <option value="0" disabled selected>Select Country*</option>
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
                                            </div>
                                        </div>
                                        <h2 class="_head03 PT-20">POC <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row poc_repeatable_div">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">First Name*</label>
                                                        <input type="text" name="fName"
                                                            class="form-control required poc_fName" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Last Name</label>
                                                        <input type="text" name="lName" class="form-control poc_lName"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Job Title*</label>
                                                        <input type="text" name="jobTitle"
                                                            class="form-control required poc_jTitle" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Email address</label>
                                                        <input type="text" name="poc_email"
                                                            class="form-control poc_email" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Business Phone*</label>
                                                        <input type="text" name="pocBusPh"
                                                            class="form-control required poc_bNum" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Mobile Number</label>
                                                        <input type="text" name="pocMob" class="form-control poc_mNum"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">WhatsApp No</label>
                                                        <input type="text" name="pocWhatsapp"
                                                            class="form-control poc_wNum" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Wechat</label>
                                                        <input type="text" name="pocWechat"
                                                            class="form-control poc_wechat" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">LinkedIn</label>
                                                        <input type="text" name="pocLin"
                                                            class="form-control poc_linkedin" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h2 class="_head03 PT-20">Add<span> Business Card</span></h2>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-wrap pt-10 pb-0" id="cardFrontDiv">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-wrap pt-10 pb-0" id="cardBackDiv">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="dynamicPocs">
                                        </div>
                                        <h2 class="_head03 PT-20">Additional <span>Details</span></h2>
                                        <div class="form-s2">
                                            <input hidden type="text" id="hidden_doc_type" value="{{$doc_type}}" />
                                            <label class="PT-10 font12">Document Types Required*</label>
                                            <select class="form-control sd-type required" name="documentTypes"
                                                multiple="multiple">
                                                @if (!empty($doc_type))
                                                @foreach ($doc_type as $docs)
                                                <option value="{{$docs->id}}">{{$docs->document_name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-s2">
                                            <input hidden type="text" id="hidden_del_port" value="{{$ports}}" />
                                            <label class="PT-10 font12">Delivery Ports*</label>
                                            <select class="form-control sd-type required" name="deliveryPorts"
                                                multiple="multiple">
                                                @foreach ($ports as $p)
                                                <option value="{{ $p->id }}">{{ $p->port_name }} ({{ $p->port_code }})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-s2 pt-19">
                                            <label class="font12">Select Acquisition Source</label>
                                            <select class="form-control formselect" name="acqSource"
                                                placeholder="Acquisition Source">
                                                <option value="0" disabled selected>Select Acquisition Source</option>
                                                @if(!empty($acquisition))
                                                @foreach ($acquisition as $acq)
                                                <option value="{{$acq->id}}">{{$acq->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
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
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                                            <option value="0" disabled selected>Select Contact Status
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
                                        <div class="form-s2 pt-19">
                                            <label class="font12">Life Cycle Stage*</label>
                                            <select class="form-control formselect required"
                                                placeholder="Contact Status" name="life_cycle_stage">
                                                <option value="customer">Customer</option>
                                                <option value="lead">Sales Lead</option>
                                                <option value="prospect">Prospect</option>
                                                <option value="dead">Dead</option>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-wrap pt-19 pb-0" id="dropifyImgDiv">
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
                                        {{-- <div id="dynamicPocs">
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2" id="saveCustomer">Save</button>
        <button class="btn btn-primary mr-2" id="addAnotherPoc">Add Another POC</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2" id="cancelCustomer">Cancel</button>
    </div>
</div>