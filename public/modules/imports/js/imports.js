function showExcelErrors(response){
    var rand_no = Math.floor(Math.random()*90000) + 10000;
    $('.errors_div').empty();
    if(response.errors.length){
        $('.error_card').append(`<div class="header">
                                        <h2>Errors <span> List</span></h2>
                                    </div>
                                    <div class="body PT-15">
                                            <div class="col-md-12 mb-30 p-0 errors_div"></div>
                                    </div>`);
        $('.error_card').show('slow');
        $('.errors_div').append(`
                                    <div class="" style="height:100%;width:100%;overflow-x: scroll; padding-bottom:10px"><table class="table table-hover  nowrap" id="Table-${rand_no}" style="width:100%;">
                                    <thead><tr><th>Row No</th></tr></thead> 
                                    <tbody></tbody>
                                    </table></div>
                                        `);
        response.header.forEach(y=>{
            $(`#Table-${rand_no} thead tr`).append(`<th style="text-transform: capitalize">${y.replace("_", " ")}</th>`);
        });
        response.errors.forEach(x=>{
            var tr = `<td style="text-align: center">${x.row_no}</td>`;
            var keys = $.map(x.row_errors, function(value, key) { return key; });
            response.header.forEach(y=>{
                if($.inArray(y,keys) !== -1){
                    tr += `<td title="${x.row_errors[y]}"><span style="padding:4px 5px; color: #721c24; background-color: #f8d7da;
border: solid 1px #d39ca2; float: left; min-width: 75px; min-height: 21px; line-height: 1;">${x.row_data[y]==null?'':x.row_data[y]}</span></td>`;
                }else{
                    tr += `<td>${x.row_data[y]==null?'':x.row_data[y]}</td>`;
                }
            });
            $(`#Table-${rand_no} tbody`).append(`<tr>${tr}</tr>`);
        });
    }
    $(`#Table-${rand_no}`).DataTable({
        "ordering": false
    });
}
$('#input-file-now').dropify({
    messages: {
        'default': 'Upload/Drag and drop excel(xls,xlsx) file',
        'replace': 'Upload/Drag and drop or click to replace',
        'remove':  'Remove',
        'error':   'Ooops, something wrong happended.'
    }
});
$(document).ready(function (e) {
    $('.error_card').hide();
    $(".save_new_distributor").on('click',(function(e) {
       
        e.preventDefault();
        $('.error_card').hide();
        $('.error_card').empty();

        $('#upload-file').ajaxSubmit({
            url: $('#form_action').attr('action'),
            type: "POST",
            contentType: false,
            cache: false,
            processData:false,
            beforeSend : function()
            {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'blue');
                $('#notifDiv').text('Please wait.Your file is uploading ....');
            },
            success: function(response)
            {
                if(response.status == 'success'){
                    $(".dropify-clear").trigger("click");
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text(response.msg);
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }else{
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text(response.msg);
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    showExcelErrors(response)
                }
            },
            error: function(e)
            {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                if(e.status == 422)
                    $('#notifDiv').text(e.responseJSON.errors.file);
                else
                    $('#notifDiv').text(e.responseJSON.message);
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
            }
        });
    }));
});