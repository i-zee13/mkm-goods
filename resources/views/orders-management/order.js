var place_order_array = [];
var order_id = "";
var product_id = "";
var callSheetData = [];
var customers_order_list = [];
var expense_array = [];
var update = false;
var segments = location.href.split('/');

var diesel_button_ref = '';

var complains = [];
var cheque_info = [];
var add_payment_ref = '';

var table_customer_ids = [];

$(document).ready(function () {

    if (segments[3]) {
        if (segments[3] == "view_orders_list") {
            if (segments[4]) {
                setTimeout(() => {
                    $('#cust_for_update').val(segments[4]).trigger('change');
                }, 500)
            }
        }
    }

    if (segments[3] == 'order' || segments[3] == 'cust_pref' || segments[3] == 'update_rates') {
        $('#tblLoaderOne').hide();
    }

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    $(document).ready(function () {

    });

    $(document).on('change', '#day', function () {

        var team_id = $('#delivery_team').val();
        if (team_id == '0' || team_id == null) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Select Delivery Team');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            $(this).val('0').trigger('change');
            return;
        }
        $('#tblLoaderOne').show();
        $('.zone_name_area').text($(this).children("option:selected").text() + " ");
        $('.zone_name_area').append('<span>List</span>');
        place_order_array = [];
        table_customer_ids = [];
        // customers_tableBody_forOrder

        var day = $(this).children("option:selected").val();
        $('#customers_tableBody_forOrder').empty();
        $.ajax({
            type: 'GET',
            url: '/GetCustomersListForOrder',
            data: {
                _token: '{!! csrf_token() !!}',
                day: day,
                team_id: team_id
            },
            success: function (response) {
                $('#tblLoaderOne').hide();
                var response = JSON.parse(response);
                //console.log(response); 
                //Rates(WhiteBottles - BlueBottles)
                $('#customers_tableBody_forOrder').empty();
                $('#tableContainer').empty();
                $('#tableContainer').append(`<table class="table dt-responsive nowrap cust-PB-list" id="exampleorder" style="width:100%">
                <thead>
                    ${
                        segments[3] == 'update_rates' ? 
                        ` <tr>
                            <th rowspan="2">Id</th>
                            <th rowspan="2">Customer Name</th> 
                            <th colspan="2" class="text-center">White Bottle</th>
                            <th colspan="2" class="text-center">Blue Bottle</th> 
                            <th rowspan="2">Action</th>
                        </tr>
                        <tr> 
                            <th>Old Rate</th>
                            <th>New Rate</th>
                            <th>Old Rate</th>
                            <th>New Rate</th>
                        </tr>` 
                        : 
                        `<tr>
                        <th rowspan="2">Id</th>
                        <th rowspan="2">Customer Name</th>
                        <th colspan="4" class="text-center">Balance</th>
                        ${
                            segments[3] == 'cust_pref' ? '' : `<th colspan="2" class="text-center">White Bottle</th>
                            <th colspan="2" class="text-center">Blue Bottle</th>
                            <th rowspan="2" style="width:30px">Amt. Recvd</th>
                           `
                        }
                        <th rowspan="2">Action</th>
                    </tr>
                    <tr>
                        <th>Old</th>  
                        <th>Curr</th>
                        <th>W.Bott</th>
                        <th>B.Bott</th>
                      ${
                          segments[3] == 'cust_pref' ? '' : `<th>Del</th>
                          <th>Emp</th>
                          <th>Del</th>
                          <th>Emp</th>`
                      }
                      
                    </tr>`
                    }
                    
                </thead>
                <tbody id="customers_tableBody_forOrder">
                </tbody>
                </table>`);
                if (segments[3] == 'cust_pref') {
                    response.forEach(element => {
                        $("#customers_tableBody_forOrder").append(`<tr><td>${(element['custom_id'] ? element['custom_id'] : 'NA')}</td><td>${(element['company_name'] ? element['company_name'] : (element['merchant_name'] ? element['merchant_name'] : element['organization_name']))}</td><td><input type="text" value="${(element['new_balance'] != null ? element['new_balance'] : (element['opening_bal'] ? element['opening_bal'] : 0))}" style="font-size: 13px" class="opening_bal form-control PBL_input"/></td><td><input type="text" value="${(element['new_w_bottle_rem'] != null ? element['new_w_bottle_rem'] : (element['white_bottle'] ? element['white_bottle'] : 0))}" style="font-size: 13px" class="white_bottle form-control PBL_input"/></td><td><input type="text" value="${(element['new_b_bottle_rem'] != null ? element['new_b_bottle_rem'] : (element['blue_bottle'] ? element['blue_bottle'] : 0))}" style="font-size: 13px" class="blue_bottle form-control PBL_input"/></td><td><button id="${element['id']}" class="btn btn-default add_cust_pref" name="${element['rates']}" title="Add">Add</button></td></tr>`);
                    });
                } else if (segments[3] == 'update_rates') {
                    response.forEach(element => {
                        var rate = element['rates'].split('-');
                        $("#customers_tableBody_forOrder").append(`<tr><td>${(element['custom_id'] ? element['custom_id'] : 'NA')}</td><td>${(element['company_name'] ? element['company_name'] : (element['merchant_name'] ? element['merchant_name'] : element['organization_name']))}</td><td><input readonly type="text" value="${rate[0]}" style="font-size: 13px" class="white_bottle form-control PBL_input"/></td><td><input type="text" value="" style="font-size: 13px" class="newWhiteBottles form-control PBL_input"/></td><td><input readonly type="text" value="${rate[1]}" style="font-size: 13px" class="blue_bottle form-control PBL_input"/></td><td><input type="text" value="" style="font-size: 13px" class="newBlueBottles form-control PBL_input"/></td><td><button id="${element['id']}" class="btn btn-default add_new_rates" name="${element['rates']}" title="Add">Add</button></td></tr>`);
                    });
                } else {
                    response.forEach(element => {
                        var old_balance = (element['all_month_amount_payable'] ? parseFloat(element['all_month_amount_payable']) : 0) - (element['all_month_amount_paid'] ? parseFloat(element['all_month_amount_paid']) : 0);
                        if (!element.all_month_amount_payable && parseFloat(old_balance) == 0)
                            old_balance = element.opening_bal;

                        var curr_balance = (element['this_month_amount_payable'] ? parseFloat(element['this_month_amount_payable']) : 0);

                        debugger;
                        // Agar old month balance mojood hai to pehle balance us men se kaato warna new balance se kaato
                        if (old_balance) {
                            // Agar amount old balance se ziada paid hai, to old balance poori kaat lo, or baqi amount current month se kaato
                            if (element['this_month_amount_paid'] && parseFloat(element['this_month_amount_paid']) > old_balance) {
                                curr_balance -= (parseFloat(element['this_month_amount_paid']) - old_balance);
                                old_balance = 0;
                            } else
                                old_balance -= (element['this_month_amount_paid'] ? parseFloat(element['this_month_amount_paid']) : 0)
                        } else
                            curr_balance -= (element['this_month_amount_paid'] ? parseFloat(element['this_month_amount_paid']) : 0)

                        $("#customers_tableBody_forOrder").append(`<tr><td>${(element['custom_id'] ? element['custom_id'] : 'NA')}</td><td>${(element['company_name'] ? element['company_name'] : (element['merchant_name'] ? element['merchant_name'] : element['organization_name']))}</td><td><input type="text" value="${old_balance}" style="font-size: 13px" readonly class="form-control PBL_input"/></td><td><input type="text" value="${curr_balance}" style="font-size: 13px" readonly class="form-control PBL_input"/><input type="text" hidden value="${(element['new_balance'] != null ? element['new_balance'] : (element['opening_bal'] ? element['opening_bal'] : 0))}" style="font-size: 13px" readonly class="opening_bal form-control PBL_input"/></td><td><input readonly type="text" value="${(element['new_w_bottle_rem'] != null ? element['new_w_bottle_rem'] : (element['white_bottle'] ? element['white_bottle'] : 0))}" style="font-size: 13px" class="white_bottle form-control PBL_input"/></td><td><input readonly type="text" value="${(element['new_b_bottle_rem'] != null ? element['new_b_bottle_rem'] : (element['blue_bottle'] ? element['blue_bottle'] : 0))}" style="font-size: 13px" class="blue_bottle form-control PBL_input"/></td><td><input type="text" class="form-control PBL_input white_del_bottles" name="${element['rates']}" style="font-size: 13px"></td><td><input type="text" class="form-control PBL_input white_emp_bottles" style="font-size: 13px"></td><td><input type="text" class="form-control PBL_input blue_del_bottles"  name="${element['rates']}" style="font-size: 13px"></td><td><input type="text" class="form-control PBL_input blue_emp_bottles" style="font-size: 13px"></td><td><input type="text" class="form-control PBL_input amount_res" style="font-size: 13px; width:65px;"></td><td style="width:74px"> <button id="${element['id']}" class="btn btn-default add_order_btn btn-icons m-0" gst="${element['gst'] ? element['gst'] : 0}" name="${element['rates']}" title="Add"><img class="add_btn_image" src="/images/add-icon.svg" alt=""></button>  <button id="${element['id']}" class="btn btn-default addDieselFromOrder btn-icons m-0" title="Diesel" data-toggle="modal" data-target="#diesel_modal"><img src="/images/fuel.svg" alt=""></button>  <button id="${element['id']}" class="btn btn-default remove_cost btn-icons green-bg m-0" style="display:none"><img src="/images/fuel-remove.svg" alt=""></button> <button id="${element['id']}" class="btn btn-default addChequeFromOrder btn-icons m-0" title="Cheque" data-toggle="modal" data-target="#cheque_modal"><img src="/images/add-payment.svg" alt=""></button></td></tr>`);
                        table_customer_ids.push(element['id']);
                    });

                }


                $('#exampleorder').dataTable({
                    "paging": false
                });
            }
        });
    });


    $(document).on('keyup', '.white_emp_bottles', function () {
        // alert('here');
        if (update) {
            var white_bottle = $(this).parent().parent().find('td').eq(5).find('.white_bottle').val();
            if (parseFloat($(this).val()) > parseFloat(white_bottle)) {
                var val = $(this).val().toString();
                $(this).val(val.substr(0, val.length - 1));
            }
        } else {
            var white_bottle = $(this).parent().parent().find('td').eq(4).find('.white_bottle').val();
            if (parseFloat($(this).val()) > parseFloat(white_bottle)) {
                var val = $(this).val().toString();
                $(this).val(val.substr(0, val.length - 1));
            }
        }

    });

    $(document).on('keyup', '.blue_emp_bottles', function () {
        // alert('here');
        if (update) {
            var blue_bottle = $(this).parent().parent().find('td').eq(6).find('.blue_bottle').val();
            if (parseFloat($(this).val()) > parseFloat(blue_bottle)) {
                var val = $(this).val().toString();
                $(this).val(val.substr(0, val.length - 1));
            }
        } else {
            var blue_bottle = $(this).parent().parent().find('td').eq(5).find('.blue_bottle').val();
            if (parseFloat($(this).val()) > parseFloat(blue_bottle)) {
                var val = $(this).val().toString();
                $(this).val(val.substr(0, val.length - 1));
            }
        }
    });



    var count = 0;
    $(document).on('click', '.add_order_btn', function () {
        var customer_id = $(this).attr('id');
        var rates = $(this).attr('name').split('-');
        var saved_white_bot_rate = 0;
        var saved_blue_bot_rate = 0;

        if ($(this).attr('name') != "null") {
            saved_white_bot_rate = rates[0];
            saved_blue_bot_rate = rates[1];
        } else {
            saved_white_bot_rate = 0;
            saved_blue_bot_rate = 0;
        }


        var current_bal = $(this).parent().parent().find('td').eq(3).find('.opening_bal').val();

        var white_bottle = $(this).parent().parent().find('td').eq(4).find('.white_bottle').val();
        var blue_bottle = $(this).parent().parent().find('td').eq(5).find('.blue_bottle').val();

        var white_del_bottles = $(this).parent().parent().find('td').eq(6).find('.white_del_bottles').val();
        var white_emp_bottles = $(this).parent().parent().find('td').eq(7).find('.white_emp_bottles').val();
        var blue_del_bottles = $(this).parent().parent().find('td').eq(8).find('.blue_del_bottles').val();
        var blue_emp_bottles = $(this).parent().parent().find('td').eq(9).find('.blue_emp_bottles').val();
        var amount_res = $(this).parent().parent().find('td').eq(10).find('.amount_res').val();
        if ($(this).parent().hasClass('dtr-data')) {
            //Screen resized

            var rowInd = $(this).parent().parent().parent().parent().parent().index() - 1;
            var trElem = $(`#exampleorder tbody tr:eq(${rowInd})`);
            //debugger;
            current_bal = trElem.find('td').eq(2).find('.opening_bal').val();

            white_bottle = trElem.find('td').eq(3).find('.white_bottle').val();
            blue_bottle = trElem.find('td').eq(4).find('.blue_bottle').val();

            white_del_bottles = trElem.find('td').eq(5).find('.white_del_bottles').val();
            white_emp_bottles = trElem.find('td').eq(6).find('.white_emp_bottles').val();
            blue_del_bottles = trElem.find('td').eq(7).find('.blue_del_bottles').val();
            blue_emp_bottles = trElem.find('td').eq(8).find('.blue_emp_bottles').val();
            amount_res = trElem.find('td').eq(9).find('.amount_res').val();

        }
        if (customer_id == '' || current_bal == "" || white_bottle == "" || blue_bottle == "" || white_del_bottles == "" && blue_del_bottles == "") {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please provide all the required information');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        } else {

            var percentage = parseFloat($(this).attr('gst')) / 100
            var botts_value = (parseFloat(saved_white_bot_rate) * parseFloat(white_del_bottles ? white_del_bottles : 0)) + (parseFloat(saved_blue_bot_rate) * parseFloat(blue_del_bottles ? blue_del_bottles : 0))
            var gst_value = parseFloat(percentage) * parseFloat(botts_value);

            var prod_id_found = false;
            place_order_array.find(x => {
                if (x.customer_id == customer_id) {
                    x.current_bal = current_bal;
                    x.blue_bottle = blue_bottle;
                    x.white_bottle = white_bottle;
                    x.white_del_bottles = white_del_bottles ? white_del_bottles : 0;
                    x.white_emp_bottles = white_emp_bottles ? white_emp_bottles : 0;
                    x.blue_del_bottles = blue_del_bottles ? blue_del_bottles : 0;
                    x.blue_emp_bottles = blue_emp_bottles ? blue_emp_bottles : 0;
                    x.amount_res = amount_res ? amount_res : 0;
                    x.gst_val = gst_value;
                    prod_id_found = true;

                    //debugger;
                    var _white_del = 0;
                    var _blue_del = 0;
                    var _amt_white = 0;
                    var test = 0;
                    var white = 0;
                    $('.white_del_bottles').each(function () {
                        if ($(this).val() == '') {
                            _white_del += parseFloat(0);
                            _amt_white += 0;
                        } else {
                            _white_del += parseFloat($(this).val());
                            test = $(this).attr('name').split('-');
                            if ($(this).attr('name') != "null") {
                                white = test[0];
                            } else {
                                white = 0;
                            }

                            _amt_white += (parseFloat(white) * parseFloat($(this).val()));
                        }
                    });

                    var _amt_blue = 0;
                    var testing = 0;
                    var blue = 0;
                    $('.blue_del_bottles').each(function () {
                        if ($(this).val() == '') {
                            _blue_del += parseFloat(0);
                            testing += 0;
                        } else {
                            _blue_del += parseFloat($(this).val());
                            testing = $(this).attr('name').split('-');
                            if ($(this).attr('name') != "null") {
                                blue = testing[1];
                            } else {
                                blue = 0;
                            }

                            _amt_blue += (parseFloat(blue) * parseFloat($(this).val()));
                        }
                    });

                    var _white_emp = 0;
                    var _blue_emp = 0;
                    $('.white_emp_bottles').each(function () {
                        if ($(this).val() == '') {
                            _white_emp += parseFloat(0);
                        } else {
                            _white_emp += parseFloat($(this).val());
                        }
                    });
                    $('.blue_emp_bottles').each(function () {
                        if ($(this).val() == '') {
                            _blue_emp += parseFloat(0);
                        } else {
                            _blue_emp += parseFloat($(this).val());
                        }
                    });


                    var _amount = 0;
                    $('.amount_res').each(function () {
                        if ($(this).val() == '') {
                            _amount += parseFloat(0);
                        } else {
                            _amount += parseFloat($(this).val());
                        }
                    });

                    var _delivered = _white_del + _blue_del;
                    $('#total_white_delivered').attr('name', _white_del);
                    $('#total_white_delivered').text(number_format(_white_del));

                    $('#total_blue_delivered').attr('name', _blue_del);
                    $('#total_blue_delivered').text(number_format(_blue_del));

                    $('#total_sold').attr('name', _delivered);
                    $('#total_sold').text(number_format(_delivered));

                    var _returned = _white_emp + _blue_emp;
                    $('#total_return_white').attr('name', _white_emp);
                    $('#total_return_white').text(number_format(_white_emp));

                    $('#total_return_blue').attr('name', _blue_emp);
                    $('#total_return_blue').text(number_format(_blue_emp));

                    $('#total_return').attr('name', _returned);
                    $('#total_return').text(number_format(_returned));

                    $('#total_amount').attr('name', _amount);
                    $('#total_amount').text(number_format(_amount));

                    var _grand_ttl = parseFloat(_amt_white) + parseFloat(_amt_blue);
                    $('#total_order_amount').attr('name', _grand_ttl);
                    $('#total_order_amount').text(number_format(_grand_ttl));

                }
            });
            if (!prod_id_found) {
                count++;
                place_order_array.push({
                    "customer_id": customer_id,
                    "current_bal": current_bal,
                    "blue_bottle": blue_bottle,
                    "white_bottle": white_bottle,
                    "white_del_bottles": white_del_bottles ? white_del_bottles : 0,
                    "white_emp_bottles": white_emp_bottles ? white_emp_bottles : 0,
                    "blue_del_bottles": blue_del_bottles ? blue_del_bottles : 0,
                    "blue_emp_bottles": blue_emp_bottles ? blue_emp_bottles : 0,
                    "amount_res": amount_res ? amount_res : 0,
                    "diesel_cost": 0,
                    "gst_val": gst_value
                });
                //$(this).text('Edit');
                $(this).find('.add_btn_image').attr('src', '/images/edit-icon.svg');
                $(this).addClass('green-bg');
                //$(this).unbind("click");

                $('#total_white_delivered').text(number_format(parseFloat($('#total_white_delivered').attr('name')) + parseFloat(white_del_bottles ? white_del_bottles : 0)));
                $('#total_white_delivered').attr('name', parseFloat(white_del_bottles ? white_del_bottles : 0));

                $('#total_blue_delivered').text(number_format(parseFloat($('#total_blue_delivered').attr('name')) + parseFloat(blue_del_bottles ? blue_del_bottles : 0)));
                $('#total_blue_delivered').attr('name', parseFloat(blue_del_bottles ? blue_del_bottles : 0));


                //$(this).removeClass('add_order_btn');
                $('#total_visit').text(count);
                // $('#total_sold').text(parseFloat($('#total_sold').text()) + parseFloat(white_del_bottles) + parseFloat(blue_del_bottles));
                var delivered = parseFloat($('#total_sold').attr('name')) + parseFloat(white_del_bottles ? white_del_bottles : 0) + parseFloat(blue_del_bottles ? blue_del_bottles : 0);
                $('#total_sold').attr('name', delivered);
                $('#total_sold').text(number_format(delivered));

                var returned = parseFloat($('#total_return').attr('name')) + parseFloat(white_emp_bottles ? white_emp_bottles : 0) + parseFloat(blue_emp_bottles ? blue_emp_bottles : 0);
                $('#total_return').attr('name', returned);
                $('#total_return').text(number_format(returned));

                $('#total_return_white').text(number_format(parseFloat($('#total_return_white').attr('name')) + parseFloat(white_emp_bottles ? white_emp_bottles : 0)));
                $('#total_return_white').attr('name', white_emp_bottles);

                $('#total_return_blue').text(number_format(parseFloat($('#total_return_blue').attr('name')) + parseFloat(blue_emp_bottles ? blue_emp_bottles : 0)));
                $('#total_return_blue').attr('name', blue_emp_bottles);

                var amt = parseFloat($('#total_amount').attr('name')) + parseFloat(amount_res ? amount_res : 0);
                $('#total_amount').attr('name', amt);
                $('#total_amount').text(number_format(amt));

                var grnad_ttl = parseFloat($('#total_order_amount').attr('name')) + (parseFloat(saved_white_bot_rate) * parseFloat(white_del_bottles ? white_del_bottles : 0)) + (parseFloat(saved_blue_bot_rate) * parseFloat(blue_del_bottles ? blue_del_bottles : 0));
                $('#total_order_amount').attr('name', grnad_ttl);
                $('#total_order_amount').text(number_format(grnad_ttl));
            }

            var total_gst_val = 0;
            place_order_array.forEach(element => {
                total_gst_val += parseFloat(element['gst_val'])
            })
            $('#total_gst_amount').text(number_format(total_gst_val))
            $('#total_gst_amount').attr('name', total_gst_val)

            $('#order_final_amount').text(number_format(total_gst_val + parseFloat($('#total_order_amount').attr('name'))))

            // console.log(place_order_array);
        }
    });

    //Save Customer Preferences
    $(document).on('click', '.add_cust_pref', function () {
        // debugger;
        var customer_id = $(this).attr('id');
        var current_bal = $(this).parent().parent().find('td').eq(2).find('.opening_bal').val();
        var white_bottle = $(this).parent().parent().find('td').eq(3).find('.white_bottle').val();
        var blue_bottle = $(this).parent().parent().find('td').eq(4).find('.blue_bottle').val();
        var thisRef = $(this);
        if (current_bal == '' || white_bottle == '' || blue_bottle == '') {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Fill all fields');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }
        thisRef.attr('disabled', 'disabled');
        thisRef.text('Processing...');
        $.ajax({
            type: 'POST',
            url: '/update_cust_pref',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                current_bal: current_bal,
                white_bottle: white_bottle,
                blue_bottle: blue_bottle,
                customer_id: customer_id
            },
            success: function (response) {
                thisRef.removeAttr('disabled');
                thisRef.text('Add');
                if (JSON.parse(response) == "success") {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Added successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else if (JSON.parse(response) == "failed") {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to add at the moment!');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            }
        });
    });

    //Update New Rates
    $(document).on('click', '.add_new_rates', function () {
        //debugger;
        var customer_id = $(this).attr('id');
        var white_bottle = $(this).parent().parent().find('td').eq(4).find('.newWhiteBottles').val();
        var blue_bottle = $(this).parent().parent().find('td').eq(5).find('.newBlueBottles').val();
        var thisRef = $(this);
        if (white_bottle == '' || blue_bottle == '') {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Fill all fields');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }
        thisRef.attr('disabled', 'disabled');
        thisRef.text('Processing...');
        $.ajax({
            type: 'POST',
            url: '/update_bottle_rates',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                white_bottle: white_bottle,
                blue_bottle: blue_bottle,
                customer_id: customer_id
            },
            success: function (response) {
                thisRef.removeAttr('disabled');
                thisRef.text('Add');
                if (JSON.parse(response) == "success") {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Added successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else if (JSON.parse(response) == "failed") {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to add at the moment!');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            }
        });
    })


    $(document).on('click', '.process_orders', function () {
        //alert($('.order_date').val()); return
        var verif = [];
        $('.required').css('border', '');
        $('.required').parent().css('border', '');

        $('.required').each(function () {
            if ($(this).val() == "") {
                $(this).css("border", "1px solid red");
                verif.push(false);
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please provide all the required information (*)');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            } else if ($(this).val() == 0 || $(this).val() == null) {
                $(this).parent().css("border", "1px solid red");
                verif.push(false);
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please provide all the required information (*)');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            } else {
                verif.push(true);
            }
        });

        if (verif.includes(false)) {
            return;
        }
        if (place_order_array == '') {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Place Order');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }
        // console.log(place_order_array);
        var thisRef = $(this);
        thisRef.text('Processing...');
        thisRef.attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: '/place_order',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                place_order_array: place_order_array,
                date: $('.order_date').val(),
                team: $('#delivery_team').val(),
                day: $('#day').val(),
                expense_array: expense_array,
                complains: complains,
                cheque_info: cheque_info
            },
            success: function (response) {
                //debugger;
                if (JSON.parse(response) == "success") {
                    location.reload();
                    thisRef.removeAttr('disabled');
                    thisRef.text('Process');
                    place_order_array = '';
                    $('#customers_tableBody_forOrder').empty();
                    $('.order_date').val('');
                    $('.zone_name_area').empty();
                    $('#total_visit').text(0);
                    $('#total_sold').text(0);
                    $('#total_white_delivered').text(0);
                    $('#total_blue_delivered').text(0);
                    $('#total_return_white').text(0);
                    $('#total_return_blue').text(0);
                    $('#total_return').text(0);
                    $('#total_amount').text(0);
                    count = 0;

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Order placed successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else if (JSON.parse(response) == "failed") {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to place order');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            }
        });
    });


    $(document).on('click', '.clear_all', function () {
        place_order_array = [];
        $('#customers_tableBody_forOrder').empty();
        $('#datepicker').val('');
        $('#delivery_team').val('0').trigger('change');
        $('#route').val(0).trigger('change');
        $('.zone_name_area').empty();
        $('#total_visit').text(0);
        $('#total_sold').text(0);
        $('#total_white_delivered').text(0);
        $('#total_blue_delivered').text(0);
        $('#total_return_white').text(0);
        $('#total_return_blue').text(0);
        $('#total_return').text(0);
        $('#total_amount').text(0);
        count = 0;
    });



    //Preview
    $(document).on('input', '#searchBar', function () {
        let searchQ = $(this).val();
        let data = callSheetData.filter(x => x.customer_name.toLowerCase().includes(searchQ.toLowerCase()));
        updateTableData(data);
    });
    $(document).on('click', '.preview_order', function () {
        var _data = $(this).attr('id');
        $('#hidden_team_id_for_pdf').val(_data);
        $('#preview_loader').show();
        $('.modal_body').hide();
        $.ajax({
            type: 'GET',
            url: '/GetDataForPreview',
            data: {
                _token: '{!! csrf_token() !!}',
                _data: _data
            },
            success: function (response) {
                $('#preview_loader').hide();
                $('.modal_body').show();
                var response = JSON.parse(response);
                $('#date_modal').text(response.single_data.date);
                $('#team_modal').text(response.single_data.team_name);
                $('#route_modal').text(response.single_data.area_name);
                $('#ttl_expense').text(response.single_data.expense ? number_format(response.single_data.expense) : 00);
                $('#total_visit_modal').text(number_format(response.single_data.total_visits));
                $('#total_del_blue_bot_modal').text(number_format(parseInt(response.single_data.blue_del)));
                $('#total_del_white_bot_modal').text(number_format(parseInt(response.single_data.white_del)));
                $('#total_emp_blue_bot_modal').text(number_format(parseInt(response.single_data.blue_emp)));
                $('#total_emp_white_bot_modal').text(number_format(parseInt(response.single_data.white_emp)));
                $('#total_amt_recvd_modal').text(number_format(response.single_data.amount_recived));
                $('#total_price_modal').text(number_format(response.single_data.total_price));
                callSheetData = response.data;
                updateTableData(callSheetData);
            }
        });
    });
    $(document).on('click', '.save_pdf', function () {
        window.open("/fpdf/call_sheet.php?oid=" + $('#hidden_team_id_for_pdf').val(), '_blank');
    });




    //Edit Order
    $(document).on('click', '.edit_single_order', function () {
        $('#edit_loader').show();
        $('.edit_layout').hide();
        $('#product-cl-sec').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        $('body').toggleClass('no-scroll');
        var id = $(this).attr('id');
        $.ajax({
            type: 'GET',
            url: '/GetSingleOrderData',
            data: {
                _token: '{!! csrf_token() !!}',
                id: id
            },
            success: function (response) {
                var response = JSON.parse(response);
                $('#edit_loader').hide();
                $('.edit_layout').show();
                $('#customer_name').text(response.customer_name);
                $('#curr_bal').text(response.current_bal);
                $('#curr_w_bot').text(response.white_bottle);
                $('#curr_w_bot').focus();

                $('#curr_b_bot').text(response.blue_bottle);
                $('#curr_b_bot').focus();

                $('#edit_w_del').val(response.white_del_bottles);
                $('#edit_w_del').focus();

                $('#edit_w_emp').val(response.white_emp_bottles);
                $('#edit_w_emp').focus();

                $('#edit_b_del').val(response.blue_del_bottles);
                $('#edit_b_del').focus();

                $('#edit_b_emp').val(response.blue_emp_bottles);
                $('#edit_b_emp').focus();

                $('#amount_rec').val(response.amount_rec);
                $('#amount_rec').focus();
                $('.save_order_edit').attr('id', response.id);
                $('#cust_id').val(response.cust_id);
            }
        });
    });

    $(document).on('keyup', '#edit_w_emp', function () {
        var white_bottle = $('#curr_w_bot').text();
        if (parseFloat($(this).val()) > parseFloat(white_bottle)) {
            var val = $(this).val().toString();
            $(this).val(val.substr(0, val.length - 1));
        }
    });
    $(document).on('keyup', '#edit_b_emp', function () {
        var blue_bottle = $('#curr_b_bot').text();
        if (parseFloat($(this).val()) > parseFloat(blue_bottle)) {
            var val = $(this).val().toString();
            $(this).val(val.substr(0, val.length - 1));
        }
    });

    $(document).on('click', '.save_order_edit', function () {
        //alert($('meta[name="csrf-token"]').attr('content')); return;
        var thisRef = $(this);
        thisRef.text('Processing...');
        thisRef.attr('disabled', 'disabled');
        $('.cancel_update').attr('disabled', 'disabled');
        var id = thisRef.attr('id');
        var white_del = $('#edit_w_del').val();
        var blue_del = $('#edit_b_del').val();
        var white_emp = $('#edit_w_emp').val();
        var blue_emp = $('#edit_b_emp').val();
        var amount_rec = $('#amount_rec').val();
        $.ajax({
            type: 'POST',
            url: '/update_single_order',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id,
                white_del: white_del,
                blue_del: blue_del,
                white_emp: white_emp,
                blue_emp: blue_emp,
                cust_id: $('#cust_id').val(),
                current_bal: $('#curr_bal').text(),
                last_w_bot: $('#curr_w_bot').text(),
                last_b_bot: $('#curr_b_bot').text(),
                amount_rec: amount_rec
            },
            success: function (response) {
                var response = JSON.parse(response);
                //console.log(response);
                thisRef.text('Add');
                thisRef.removeAttr('disabled');
                $('.cancel_update').removeAttr('disabled');
                if (response == 'success') {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Successfully updated');
                    $('.cancel_update').click();
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to update at the moment');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            }
        });
    });


    $(document).on('click', '.delete_order', function () {
        var id = $(this).attr('id');
        var thisRef = $(this);
        thisRef.attr('disabled', 'disabled');
        thisRef.text('Processing...');
        $.ajax({
            type: 'GET',
            url: '/delete_single_order',
            data: {
                _token: '{!! csrf_token() !!}',
                id: id
            },
            success: function (response) {
                var response = JSON.parse(response);
                thisRef.removeAttr('disabled');
                thisRef.text('Delete');
                if (response == 'success') {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Successfully Deleted');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    thisRef.parent().parent().remove();
                    //location.reload();
                } else {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to delete at the moment');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            }
        });
    });





    //Update
    $(document).on('change', '#cust_for_update', function () {
        update = true;
        var counter = 0;
        customers_order_list = [];
        $('#tblLoaderUpdate').show();
        $('.zone_name_area').text($(this).children("option:selected").text() + " ");
        $('.zone_name_area').append('<span>List</span>');
        var id = $(this).children("option:selected").val();
        $('#customers_tableBody_forUpdateOrder').empty();
        $('#customers_tableBody_forUpdateOrder').append('<img src="/images/loader.gif" id="tblLoaderUpdate" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">');
        $.ajax({
            type: 'GET',
            url: '/GetCustomersOrders',
            data: {
                _token: '{!! csrf_token() !!}',
                id: id
            },
            success: function (response) {
                $('#tblLoaderUpdate').hide();
                var response = JSON.parse(response);
                //console.log(response); return;
                //Rates(WhiteBottles - BlueBottles)
                $('#customers_tableBody_forUpdateOrder').empty();
                $('#updatetableContainer').empty();
                $('#updatetableContainer').append(`<table class="table dt-responsive nowrap cust-PB-list" id="exampleorder" style="width:100%">
                <thead>
                    <tr>
                        <th rowspan="2">Id</th>
                        <th rowspan="2">Date</th>
                        <th rowspan="2">Customer Name</th>
                        <th colspan="3" class="text-center">Balance</th>
                        <th colspan="2" class="text-center">White Bottle</th>
                        <th colspan="2" class="text-center">Blue Bottle</th>
                        <th rowspan="2" style="width:30px">Amt. Recvd</th>
                    </tr>
                    <tr>
                      <th>Curr</th>
                      <th>W.Bott</th>
                      <th>B.Bott</th>
                      <th>Del</th>
                      <th>Emp</th>
                      <th>Del</th>
                      <th>Emp</th>
                    </tr>
                </thead>
                <tbody id="customers_tableBody_forUpdateOrder">
                </tbody>
            </table>`);

                response.forEach(element => {
                    $("#customers_tableBody_forUpdateOrder").append(`<tr class="table_row" id="${element['id']}"><td>${element['cust_id']}</td><td><input type="text" style="font-size: 13px" class="form-control required order_date" placeholder="" value="${element['date']}"></td><td>${element['customer_name']}</td><td><input type="text" value="${(counter == 0 ? element['biling_opening_bal'] : element['current_bal'])}" style="font-size: 13px" readonly class="opening_bal form-control PBL_input"/></td><td><input readonly type="text" value="${(counter == 0 ? element['billing_white_bot'] : element['white_bottle'])}" style="font-size: 13px" class="white_bottle form-control PBL_input"/></td><td><input readonly type="text" value="${(counter == 0 ? element['billing_blue_bot'] : element['blue_bottle'])}" style="font-size: 13px" class="blue_bottle form-control PBL_input"/></td><td><input type="text" class="form-control PBL_input white_del_bottles" value="${element['white_del_bottles']}" name="${element['rates']}" style="font-size: 13px"></td><td><input type="text" class="form-control PBL_input white_emp_bottles" value="${element['white_emp_bottles']}" style="font-size: 13px"></td><td><input type="text" class="form-control PBL_input blue_del_bottles" value="${element['blue_del_bottles']}" name="${element['rates']}" style="font-size: 13px"></td><td><input type="text" class="form-control PBL_input blue_emp_bottles" value="${element['blue_emp_bottles']}" style="font-size: 13px"></td><td><input type="text" class="form-control PBL_input amount_rec" value="${element['amount_rec']}" style="font-size: 13px; width:65px;"></td></tr>`);
                    customers_order_list.push({
                        'order_id': element['id'],
                        "date": element['date'],
                        "current_bal": (counter == 0 ? element['biling_opening_bal'] : element['current_bal']),
                        "white_bottles": (counter == 0 ? element['billing_white_bot'] : element['white_bottle']),
                        "blue_bottles": (counter == 0 ? element['billing_blue_bot'] : element['blue_bottle']),
                        "white_del_bottles": element['white_del_bottles'],
                        "white_emp_bottles": element['white_emp_bottles'],
                        "blue_del_bottles": element['blue_del_bottles'],
                        "blue_emp_bottles": element['blue_emp_bottles'],
                        "amount_rec": element['amount_rec'],
                        "rates": element['rates']
                    });
                    counter++;
                });
                $('#exampleorder').dataTable({
                    "paging": false
                });

                $('.order_date').datepicker({
                    format: 'yyyy-mm-dd'
                });
            }
        });
    });

    var verif = [];
    $(document).on('click', '.update_order', function () {
        //console.log(customers_order_list);
        var counter = 0;
        var new_order_array = [];
        var last_curr_bal = 0;
        var last_w_del_bot = 0;
        var last_w_emp_bot = 0;
        var last_b_del_bot = 0;
        var last_b_emp_bot = 0;
        var last_order_price = 0;
        var last_amt_rec = 0;
        var last_w_b = 0;
        var last_b_b = 0;
        verif = [];
        $('.white_emp_bottles').css("border", "");
        $('.blue_emp_bottles').css("border", "");

        $('.table_row').each(function () {
            debugger;

            if (counter == 0) {

                if (parseFloat($(this).find('.white_bottle').val()) < parseFloat($(this).find('.white_emp_bottles').val())) {
                    verif.push(false);
                    $(this).find('.white_emp_bottles').css("border", "1px solid red");
                } else if (parseFloat($(this).find('.blue_bottle').val()) < parseFloat($(this).find('.blue_emp_bottles').val())) {
                    verif.push(false);
                    $(this).find('.blue_emp_bottles').css("border", "1px solid red");
                } else {
                    verif.push(true);
                    last_curr_bal = $(this).find('.opening_bal').val();
                    last_w_del_bot = $(this).find('.white_del_bottles').val();
                    last_w_emp_bot = $(this).find('.white_emp_bottles').val();
                    last_b_del_bot = $(this).find('.blue_del_bottles').val();
                    last_b_emp_bot = $(this).find('.blue_emp_bottles').val();
                    last_amt_rec = $(this).find('.amount_rec').val();
                    last_w_b = $(this).find('.white_bottle').val();
                    last_b_b = $(this).find('.blue_bottle').val();

                    var price = $(this).find('.blue_del_bottles').attr('name').split('-');
                    var w_price = price[0];
                    var b_price = price[1];
                    last_order_price = (parseFloat(w_price) * parseFloat($(this).find('.white_del_bottles').val())) + (parseFloat(b_price) * parseFloat($(this).find('.blue_del_bottles').val()));
                    new_order_array.push({
                        'order_id': $(this).attr('id'),
                        'date': $(this).find('.order_date').val(),
                        'current_bal': $(this).find('.opening_bal').val(),
                        'white_bottle': $(this).find('.white_bottle').val(),
                        'blue_bottle': $(this).find('.blue_bottle').val(),
                        'white_del_bottles': $(this).find('.white_del_bottles').val(),
                        'white_emp_bottles': $(this).find('.white_emp_bottles').val(),
                        'blue_del_bottles': $(this).find('.blue_del_bottles').val(),
                        'blue_emp_bottles': $(this).find('.blue_emp_bottles').val(),
                        'amount_rec': $(this).find('.amount_rec').val(),
                        'order_price': (parseFloat(w_price) * parseFloat($(this).find('.white_del_bottles').val())) + (parseFloat(b_price) * parseFloat($(this).find('.blue_del_bottles').val()))
                    });
                }


            } else {

                last_w_b = (parseFloat(last_w_b) + parseFloat(last_w_del_bot)) - parseFloat(last_w_emp_bot);
                last_b_b = (parseFloat(last_b_b) + parseFloat(last_b_del_bot)) - parseFloat(last_b_emp_bot);

                if (last_w_b < $(this).find('.white_emp_bottles').val()) {
                    verif.push(false);
                    $(this).find('.white_emp_bottles').css("border", "1px solid red");
                } else if (last_b_b < $(this).find('.blue_emp_bottles').val()) {
                    verif.push(false);
                    $(this).find('.blue_emp_bottles').css("border", "1px solid red");
                } else {
                    verif.push(true);
                    var price = $(this).find('.blue_del_bottles').attr('name').split('-');
                    var w_price = price[0];
                    var b_price = price[1];

                    new_order_array.push({
                        'order_id': $(this).attr('id'),
                        'date': $(this).find('.order_date').val(),
                        'current_bal': parseFloat(last_curr_bal) + parseFloat(last_order_price) - parseFloat(last_amt_rec),
                        'white_bottle': last_w_b,
                        'blue_bottle': last_b_b,
                        'white_del_bottles': $(this).find('.white_del_bottles').val(),
                        'white_emp_bottles': $(this).find('.white_emp_bottles').val(),
                        'blue_del_bottles': $(this).find('.blue_del_bottles').val(),
                        'blue_emp_bottles': $(this).find('.blue_emp_bottles').val(),
                        'amount_rec': $(this).find('.amount_rec').val(),
                        'order_price': (parseFloat(w_price) * parseFloat($(this).find('.white_del_bottles').val())) + (parseFloat(b_price) * parseFloat($(this).find('.blue_del_bottles').val()))
                    });

                    last_curr_bal = parseFloat(last_curr_bal) + parseFloat(last_order_price) - parseFloat(last_amt_rec);
                    last_w_del_bot = $(this).find('.white_del_bottles').val();
                    last_w_emp_bot = $(this).find('.white_emp_bottles').val();
                    last_b_del_bot = $(this).find('.blue_del_bottles').val();
                    last_b_emp_bot = $(this).find('.blue_emp_bottles').val();
                    last_amt_rec = $(this).find('.amount_rec').val();


                    last_order_price = (parseFloat(w_price) * parseFloat($(this).find('.white_del_bottles').val())) + (parseFloat(b_price) * parseFloat($(this).find('.blue_del_bottles').val()));

                }

            }

            counter++;

        });

        if (verif.includes(false)) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Bottle Limit Exceeded');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        } else {
            // console.log(new_order_array);
            // return;
            var thisRef = $(this);
            thisRef.attr('disabled', 'disabled');
            thisRef.text('Processing');

            $.ajax({
                type: 'POST',
                url: '/update_order_against_cust',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    cust_id: $('#cust_for_update').val(),
                    new_order_array: new_order_array
                },
                success: function (response) {
                    var response = JSON.parse(response);
                    //console.log(response);
                    thisRef.text('Save');
                    thisRef.removeAttr('disabled');
                    if (response == 'success') {
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'green');
                        $('#notifDiv').text('Successfully updated');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                        location.reload();
                    } else {
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'red');
                        $('#notifDiv').text('Failed to update at the moment');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                    }
                }
            });

            // $('#notifDiv').fadeIn();
            // $('#notifDiv').css('background', 'green');
            // $('#notifDiv').text('All OK');
            // setTimeout(() => {
            //     $('#notifDiv').fadeOut();
            // }, 3000);
            console.log(new_order_array);
        }


    });




    var total_exp_amount = 0;
    $(document).on('click', '.add_expense', function () {
        if ($('.select_expense_type').val() == '0' || $('.select_expense_type').val() == null || $('.expense_amount').val() == '') {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please select expense type and add amount!');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }

        var expense_type = $('.select_expense_type').val();
        var type_found = false;
        expense_array.find(x => {
            if (x.expense_type == expense_type) {
                x.amount = $('.expense_amount').val();
                type_found = true;
            }
        });
        if (!type_found) {
            expense_array.push({
                "expense_type": expense_type,
                "amount": $('.expense_amount').val()
            });
        }
        $('.select_expense_type').val('0').trigger('change');
        $('.expense_amount').val('');
        //console.log(expense_array);
        $('.expense_list_table tbody').empty();
        total_exp_amount = 0;
        expense_array.forEach(element => {
            $('.expense_list_table tbody').append(`<tr><td>${element.expense_type}</td><td>${element.amount}</td><<td><button class="btn btn-default red-bg mb-0 delete_expense" title="Delete" id="${element.expense_type}">Delete</button></td></tr>`);
            total_exp_amount += parseFloat(element.amount);
        });
        $('.due_amount').val(parseFloat($('.collected_amount').attr('name')) - total_exp_amount);
        $('.due_amount').attr('name', parseFloat($('.collected_amount').attr('name')) - total_exp_amount);
        $('.expense_added').val(total_exp_amount);
        $('.expense_added').attr('name', total_exp_amount);
        $('#total_expense_amount').text(total_exp_amount);
    });

    $(document).on('click', '.delete_expense', function () {
        var id = $(this).attr('id');
        $(this).parent().parent().remove();
        expense_array = expense_array.filter(x => x.expense_type !== id);
        total_exp_amount = 0;
        expense_array.forEach(element => {
            total_exp_amount += parseFloat(element.amount);
        });
        $('.due_amount').val(parseFloat($('.collected_amount').attr('name')) - total_exp_amount);
        $('.due_amount').attr('name', parseFloat($('.collected_amount').attr('name')) - total_exp_amount);
        $('.expense_added').val(total_exp_amount);
        $('.expense_added').attr('name', total_exp_amount);
        $('#total_expense_amount').text(total_exp_amount);
    });




    //Open Diesel Modal
    $(document).on('click', '.addDieselFromOrder', function () {
        diesel_button_ref = $(this);
        $('.add_diesel_orderModal').attr('id', $(this).attr('id'));
    })

    //Add Diesel
    $(document).on('click', '.add_diesel_orderModal', function () {
        if (!$('.diesel_cost').val()) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Enter Cost!');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }

        var customer_found = false;
        place_order_array.find(x => {
            if (x.customer_id == $(this).attr('id')) {
                customer_found = true;
                x.diesel_cost = $('.diesel_cost').val() ? $('.diesel_cost').val() : 0;
            }
        })

        if (!customer_found) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Add Order First!');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return
        }

        $('.diesel_cost').val('')
        diesel_button_ref.hide();
        diesel_button_ref.parent().find('.remove_cost').show();
        $('.close_modal').click();

        var total_cost = 0;
        place_order_array.forEach(element => {
            total_cost += parseFloat(element['diesel_cost']);
        })
        $('#total_diesel_amount').text(number_format(total_cost));
        //console.log(diesel_cost)
    });

    //Remove Diesel
    $(document).on('click', '.remove_cost', function () {
        place_order_array.find(x => {
            if (x.customer_id == $(this).attr('id')) {
                customer_found = true;
                x.diesel_cost = 0;
            }
        })

        $(this).parent().find('.addDieselFromOrder').show();;
        $(this).hide();
        var total_cost = 0;
        place_order_array.forEach(element => {
            total_cost += parseFloat(element['diesel_cost']);
        })
        $('#total_diesel_amount').text(number_format(total_cost));
        //console.log(diesel_cost)
    })




    //Complains
    $(document).on('change', '.select_team_complaint', function () {
        $('.select_zone_complaint').empty();
        $('.select_zone_complaint').append(`<option value="0" selected disabled>Processing...</option>`);
        //Empty Customers
        $('.select_cust_complaint').empty();
        $('.select_cust_complaint').append(`<option value="0" selected disabled>Select Customer</option>`);
        var team_id = $(this).val();
        $.ajax({
            type: 'GET',
            url: '/GetZonesAgainstTeam',
            data: {
                _token: '{!! csrf_token() !!}',
                team_id: team_id
            },
            success: function (response) {
                var response = JSON.parse(response);
                $('.select_zone_complaint').empty();
                $('.select_zone_complaint').append(`<option value="0" selected disabled>Select Zone</option>`);
                response.forEach(element => {
                    $('.select_zone_complaint').append(`<option value="${element['id']}">${element['zone_name']}</option>`);
                });
            }
        });
    });

    $(document).on('change', '.select_zone_complaint', function () {
        $('.select_cust_complaint').empty();
        $('.select_cust_complaint').append(`<option value="0" selected disabled>Processing...</option>`);
        var team_id = $(this).val();
        $.ajax({
            type: 'GET',
            url: '/GetCustomersAgainstZones',
            data: {
                _token: '{!! csrf_token() !!}',
                team_id: team_id
            },
            success: function (response) {
                var response = JSON.parse(response);
                $('.select_cust_complaint').empty();
                $('.select_cust_complaint').append(`<option value="0" selected disabled>Select Customer</option>`);
                response.forEach(element => {
                    $('.select_cust_complaint').append(`<option brb="${element['blue_bottles_remaining']}" wrb="${element['white_bottles_remaining']}" rate="${element['rates']}" wb="${element['white_bottle']}" bb="${element['blue_bottle']}" bal="${element['balance']}" opp_bal="${element['opening_bal']}" name="${element['custom_id']}" value="${element['id']}">${(element['company_name'] ? element['company_name'] : (element['organization_name'] ? element['organization_name'] : element['merchant_name']))} (${element['custom_id']})</option>`);
                });
            }
        });
    });

    $(document).on('click', '.add_complaint_modal', function () {
        // if(place_order_array.length == 0){
        //     $('#notifDiv').fadeIn();
        //     $('#notifDiv').css('background', 'red');
        //     $('#notifDiv').text('Please Add Order First!');
        //     setTimeout(() => {
        //         $('#notifDiv').fadeOut();
        //     }, 3000);
        //     return
        // }
        if (!$('#day').val()) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Select Day First!');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return
        }

        var team = $('.select_team_complaint').val();
        var zone = $('.select_zone_complaint').val();
        var cust = $('.select_cust_complaint').val();
        var blue_bot = $('.blue_bot_complaint').val();
        var white_bot = $('.white_bot_complaint').val();
        var cust_name = $(".select_cust_complaint option:selected").text();
        var wrb = $(".select_cust_complaint option:selected").attr('wrb');
        var brb = $(".select_cust_complaint option:selected").attr('brb');
        var bal = $(".select_cust_complaint option:selected").attr('bal');
        var custom_id = $(".select_cust_complaint option:selected").attr('name');
        var opp_bal = $(".select_cust_complaint option:selected").attr('opp_bal');
        var wb = $(".select_cust_complaint option:selected").attr('wb');
        var bb = $(".select_cust_complaint option:selected").attr('bb');
        var rate = $(".select_cust_complaint option:selected").attr('rate');

        if (team == '0' || team == null || zone == '0' || zone == null || cust == '0' || cust == null) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please provide all the required information (*)');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }

        if (table_customer_ids.find(x => x == cust)) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Customer Already exist in List!');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }


        complain_id_found = false;
        complains.find(x => {
            if (x.customer_id == cust) {
                complain_id_found = true;
                x.blue_bot = blue_bot ? blue_bot : 0;
                x.white_bot = white_bot ? white_bot : 0;
            }
        });
        if (!complain_id_found) {
            complains.push({
                "team_id": team,
                "zone_id": zone,
                "customer_id": cust,
                "cust_name": cust_name,
                "blue_bot": blue_bot ? blue_bot : 0,
                "white_bot": white_bot ? white_bot : 0,
                "custom_id": custom_id,
                "bal": bal,
                'wrb': wrb,
                "brb": brb
            });
        }
        $('.select_team_complaint').val('0').trigger('change');
        $('.blue_bot_complaint').val('');
        $('.white_bot_complaint').val('');
        setTimeout(() => {
            $('.select_zone_complaint').empty();
            $('.select_zone_complaint').append(`<option value="0" selected disabled>Select Zone</option>`);
            $('.select_cust_complaint').empty();
            $('.select_cust_complaint').append(`<option value="0" selected disabled>Select Customer</option>`);
        }, 500);
        $('.complains_div').empty();
        complains.forEach(element => {
            $('.complains_div').append(`<div class="alert fade show alert-color" role="alert" style="padding: 10px; border-radius: 0; background-color: #fff; box-shadow: 0 2px 8px 0 rgba(79,79,79,.1); margin-bottom:5px">
                <div class="row m-0">
                    <div class="col-12 p-0"> <strong>${element['cust_name']}</strong>
                    <button style="margin-top:-5px; margin-right:-5px" id="${element['customer_id']}" type="button" class="close remove_complain" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    </div>
                    <div class="col-6 p-0">W Bottle: <strong>${element['white_bot']}</strong></div>
                    <div class="col-6 p-0">B Bottle: <strong>${element['blue_bot']}</strong></div>
                </div>
            </div> `);
        });

        $("#customers_tableBody_forOrder").append(`<tr><td>${(custom_id ?custom_id : 'NA')}</td><td>${cust_name}</td><td><input type="text" value="${(bal != null ? bal : (opp_bal ? opp_bal : 0))}" style="font-size: 13px" readonly class="opening_bal form-control PBL_input"/></td><td><input readonly type="text" value="${(wrb != null ? wrb : (wb ? wb : 0))}" style="font-size: 13px" class="white_bottle form-control PBL_input"/></td><td><input readonly type="text" value="${(brb != null ? brb : (bb ? bb : 0))}" style="font-size: 13px" class="blue_bottle form-control PBL_input"/></td><td><input type="text" class="form-control PBL_input white_del_bottles" name="${rate}" value="${white_bot}" style="font-size: 13px"></td><td><input type="text" class="form-control PBL_input white_emp_bottles" style="font-size: 13px"></td><td><input type="text" class="form-control PBL_input blue_del_bottles"  name="${rate}" value="${blue_bot}" style="font-size: 13px"></td><td><input type="text" class="form-control PBL_input blue_emp_bottles" style="font-size: 13px"></td><td><input type="text" class="form-control PBL_input amount_res" style="font-size: 13px; width:65px;"></td><td style="width:74px"> <button id="${cust}" class="btn btn-default add_order_btn btn-icons m-0" name="${rate}" title="Add"><img class="add_btn_image" src="/images/add-icon.svg" alt=""></button>  <button id="${cust}" class="btn btn-default addDieselFromOrder btn-icons m-0" title="Diesel" data-toggle="modal" data-target="#diesel_modal"><img src="/images/fuel.svg" alt=""></button>  <button id="${cust}" class="btn btn-default remove_cost btn-icons green-bg m-0" style="display:none"><img src="/images/fuel-remove.svg" alt=""></button> <button id="${cust}" class="btn btn-default addChequeFromOrder btn-icons m-0" title="Cheque" data-toggle="modal" data-target="#cheque_modal"><img src="/images/add-payment.svg" alt=""></button></td></tr>`);

        $('#total_complaints').text(complains.length);
    });

    $(document).on('click', '.remove_complain', function () {
        complains = complains.filter(x => x.customer_id != $(this).attr('id'));
        $('.complains_div').empty();
        complains.forEach(element => {
            $('.complains_div').append(`<div class="alert fade show alert-color" role="alert" style="padding: 10px; border-radius: 0; background-color: #fff; box-shadow: 0 2px 8px 0 rgba(79,79,79,.1); margin-bottom:5px">
                <div class="row m-0">
                    <div class="col-12 p-0"> <strong>${element['cust_name']}</strong>
                    <button style="margin-top:-5px; margin-right:-5px" id="${element['customer_id']}" type="button" class="close remove_complain" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    </div>
                    <div class="col-6 p-0">W Bottle: <strong>${element['white_bot']}</strong></div>
                    <div class="col-6 p-0">B Bottle: <strong>${element['blue_bot']}</strong></div>
                </div>
            </div> `);
        });

        $('#total_complaints').text(complains.length);
    })


    $(document).on('click', '.addChequeFromOrder', function () {
        add_payment_ref = $(this);
        $('.save_cheque_info').attr('id', $(this).attr('id'));
        cheque_info.find(x => {
            if (x.customer_id == $(this).attr('id')) {
                $('.cheque_num').val(x.cheque_num);
                $('.cheque_num').focus();
                $('.cheque_date').val(x.cheque_date);
                $('.cheque_date').focus();
                $('.cheque_bank_name').val(x.cheque_bank_name);
                $('.cheque_bank_name').focus();
                $('.cheque_amount').val(x.cheque_amount);
                $('.cheque_amount').focus();
            } else {
                $('.cheque_num').val('')
                $('.cheque_date').val('')
                $('.cheque_bank_name').val('')
                $('.cheque_amount').val('')
            }
        });

    })

    $(document).on('click', '.save_cheque_info', function () {
        if (!$('.cheque_num').val() || !$('.cheque_date').val() || !$('.cheque_bank_name').val() || !$('.cheque_amount').val()) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please provide all the required information(*)!');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return
        }

        var cheque_id_found = false;
        cheque_info.find(x => {
            if (x.customer_id == $(this).attr('id')) {
                cheque_id_found = true;
                x.cheque_num = $('.cheque_num').val();
                x.cheque_date = $('.cheque_date').val();
                x.cheque_bank_name = $('.cheque_bank_name').val();
                x.cheque_amount = $('.cheque_amount').val();
            }
        });
        if (!cheque_id_found) {
            cheque_info.push({
                "cheque_num": $('.cheque_num').val(),
                "cheque_date": $('.cheque_date').val(),
                "customer_id": $(this).attr('id'),
                "cheque_bank_name": $('.cheque_bank_name').val(),
                "cheque_amount": $('.cheque_amount').val()
            });
            $('.cheque_num').val('')
            $('.cheque_date').val('')
            $('.cheque_bank_name').val('')
            $('.cheque_amount').val('')
        }
        $('.close_modal').click();
        add_payment_ref.addClass('green-bg');

        var cheque_amt = 0;
        cheque_info.forEach(element => {
            cheque_amt += parseFloat(element['cheque_amount'])
        })
        $('#total_cheque_amount').text(cheque_amt);
    })

});

function updateTableData(data) {
    $('#customers_tableBody_forOrder').empty();
    if (!data || !data.length) {
        $('#customers_tableBody_forOrder').append('<tr><td colspan="12" style="text-align:center">No data available</td></tr>');
        return;
    }
    data.forEach(element => {
        $('#customers_tableBody_forOrder').append(`<tr> <td>${element['customer_custom_id']}</td> <td>${element['customer_name']}</td><td>${element['created_by']}</td> <td>${element['current_bal']}</td> <td>${element['white_bottle']}</td> <td>${element['blue_bottle']}</td> <td>${element['white_del_bottles']}</td> <td>${element['white_emp_bottles']}</td> <td>${element['blue_del_bottles']}</td> <td>${element['blue_emp_bottles']}</td> <td>${number_format(element['amount_rec'])}</td> </tr>`);
    });
}


function fetchCustomersAndOrders() {
    $.ajax({
        type: 'GET',
        url: '/GetCustomersAndOrders',
        success: function (response) {
            //console.log(response);
            $('.body_table').empty();
            $('.body_table').append('<table class="table table-hover dt-responsive nowrap" id="StockListTable" style="width:100%;"><thead><tr><th>Order ID</th><th>Customer</th><th>Recieve Payment</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#StockListTable tbody').empty();
            // });
            var response = JSON.parse(response);
            response.forEach(element => {
                $('#StockListTable tbody').append('<tr><td><span>' + element['id'] + '</span></td><td>' + (element['company_name'] != null ? element['company_name'] : (element['organization_name'] != null ? element['organization_name'] : element['merchant_name'])) + '</td><td>' + element['price'] + '</td><td><button id="' + element['id'] + '" class="btn btn-default view_detail" data-toggle="modal" data-target=".bd-example-modal-lg">View Detail</button><button id="' + element['id'] + '" class="btn btn-default red-bg delete_core">Delete</button></td></tr>');
                $('#customer_visited').text(element['count']);
                $('#total_sold_pro').text(element['total_products']);
                $('#total_return_pro').text(element['return_products']);
                $('#total_recieved_amount').text(element['total_amount']);
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#StockListTable').DataTable();
        }
    });
}

function number_format(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
