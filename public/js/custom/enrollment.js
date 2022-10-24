///runwatch
// import swal from 'sweetalert';
let deleteRef   = '';
let p_service   = '';
let s_service   = '';
let s_s_service = '';

$(document).on('click','.add_enrollment',function(){
    openSidebar();
    CKEDITOR.instances['faq_answer'].setData();
    $('#SaveEnrollmentForm')[0].reset();
    $('input[name="faq_question"]').focus();
    $('input[name="faq_question"]').blur();
    $('select[name="faq_type"]').trigger('change');
    $('input[name="hidden_faq_id"]').val('');
})

$(document).on('click', '#save-faq', function () {
let dirty = false;
    $('.faq-required').each(function () {
        if (!$(this).val() || $(this).val() == 0) {
            dirty = true;
            if ($(this).hasClass('formselect') || $(this).hasClass('sd-type') ) {
                $(this).parent().find('.select2-container').css('border', '0px solid red');
            }else{
                $(this).css('border', '0px solid red');
            }   
        }
    });
    if (dirty) {
        $('#notifDiv').fadeIn();
        $('#notifDiv').css('background', 'red');
        $('#notifDiv').text('Please provide all the required information (*)');
        setTimeout(() => {
            $('#notifDiv').fadeOut();
        }, 3000);
        return;
    }
    var CurrentRef = $(this);
    CurrentRef.attr('disabled', 'disabled');
    CurrentRef.text('Processing...');
    var faq_details    =   CKEDITOR.instances['faq_answer'].getData();
    if(faq_details == '')
    {
        $('#notifDiv').fadeIn();
        $('#notifDiv').css('background', 'red');
        $('#notifDiv').text('Please provide Faq Answer (*)');
        setTimeout(() => {
            $('#notifDiv').fadeOut();
        }, 3000);  
        CurrentRef.attr('disabled', false);
        CurrentRef.text('Save');
        return;
      
    }
    $('#SaveEnrollmentForm').ajaxSubmit({
        type    :   "POST",
        url     :   "/save-enrollment",
        data    :   {
            faq_details    :   faq_details
        },
        success :   function(response){
            CurrentRef.attr('disabled', false);
            CurrentRef.text('Save');
            if(response.msg == 'faq_added'){
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'green');
                $('#notifDiv').text('FAQs Added');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                $('#SaveEnrollmentForm')[0].reset();
                CKEDITOR.instances['faq_answer'].setData();
                closeSidebar();
                all_enrollment_list();
            }else{
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Not added at this moment');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
            }
        }
    })
})

$(document).on('click','.status_change_faq',function(){
    var faq_status      =   '';
    var id              =   $(this).attr('id');
    var current_status  =   $(this).attr('data-value');
    if(current_status == 1){
        faq_status      =   0;
    }else{
        faq_status      =   1;
    }
    var CurrentRef      =   $(this);
    CurrentRef.attr('disabled', 'disabled');
    $.ajax({
        type    :   'POST',
        url     :   `/faq-status-change`,
        data    :   {
            _token      :   $('meta[name="csrf_token"]').attr('content'),
            id          :   id,
            faq_status  :   faq_status,
        },
        success :   function (response) {
            CurrentRef.attr('disabled', false);
            if(response.msg == 'status_change'){
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'green');
                $('#notifDiv').text('FAQs Status Change');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                all_enrollment_list();
            }
        }
    });
})
function all_enrollment_list(){
    $('.enrollment_list').empty();
    $.ajax({
        type    :   'GET',
        url     :   '/all-enrollment-list',
        success :   function(response){
            $('.enrollment_list').append(`
            <table class="table table-hover dt-responsive nowrap EnrollmentListTable" style="width:100%;">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Student</th>
                        <th>Session</th>
                        <th>Batch</th>
                        <th>Course</th>
                        <th>Enroll Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
            <tbody></tbody>
            </table>`
            );
            $('.EnrollmentListTable tbody').empty();
            response.enrollment.forEach((element, key) => {
                $('.EnrollmentListTable tbody').append(`
                    <tr>
                        <td>${key + 1}</td>
                        <td>${element['student_code']}</td>
                        <td>${element['session_code']}</td>
                        <td>${element['batch_code']}</td>
                        <td>${element['course_code']}</td>
                        <td>${element['enrollment_date']}</td>

                        <td>
                            <button id="${element['id']}" class="btn btn-default btn-line edit_faq">
                            Edit
                            </button>
                            <button id="${element['id']}" class="btn btn-default red-bg delete_faq">Delete</button>
                            <button id="${element['id']}" class="btn btn-default status_change_faq" data-value="${element.status}">${element.status==1 ? 'Active' : 'Inactive'}</button>
                        </td>
                    </tr>`);
            });
            $('.EnrollmentListTable').fadeIn();
            $('.EnrollmentListTable').DataTable();
            $('.loader').hide();
        }
    })
}
//Delete Faq
$(document).on('click', '.delete_faq', function () {
    var id = $(this).attr('id');
    deleteRef = $(this);
    swal({
        title   : "Are you sure?",
        // text    : "",
        icon    : "warning",
        buttons: true,
        dangerMode: true,
        focusCancel: false,
      })
      .then((willDelete) => {
        if (willDelete) {
            var thisRef = $(this);
            deleteRef.attr('disabled', 'disabled');
            deleteRef.text('Processing...');
            var id = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: '/delete-faq',
                data: {
                    _token: $('meta[name="csrf_token"]').attr('content'),
                    id: id
                },
                success: function (response) {
                    if (response.msg == 'faq_deleted') {
                        all_enrollment_list();
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'green');
                        $('#notifDiv').text('Successfully deleted.');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                    } else {
                        deleteRef.removeAttr('disabled');
                        deleteRef.text('Delete');
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'red');
                        $('#notifDiv').text('Unable to delete at the moment');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                    }
                }
            });
        }
      });
      
})
all_enrollment_list();