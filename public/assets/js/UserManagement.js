$(document).ready(function () {




});


$('#update_user_form').submit(function (e) {
    e.preventDefault();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "update_user",
        data: $('#update_user_form').serialize(),
        dataType: "json",
        success: function (res) {
            $('#update_user_modal').modal('hide');
            location.reload();
        },
        error: function (err) {

        }
    });

});

function getUserInfo(id) {

    $('#update_user_modal').modal('show');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: "get_user/" + id,
        data: "data",
        dataType: "json",
        success: function (res) {
            console.log(res);
            $('#profiles_id').val(res.id);
            $('#users_id').val(res.userId);
            $('#update_firstname').val(res.first_name);
            $('#update_middlename').val(res.middle_name);
            $('#update_lastname').val(res.last_name);
            $('#update_suffix').val(res.suffix);
            $('#update_gender').val(res.gender);
            $('#update_civil_status').val(res.civil_status);
            $('#update_bday').val(res.bday);
            $('#update_email').val(res.email);
            $('#update_password').val(res.password);
            $('#update_confirm_password').val(res.password);
            $('#update_age').val(res.age);
            $('#update_address').val(res.purok);
            $('#update_phone').val(res.phone);
            $('#update_telno').val(res.telno);
            $('#update_user_role').val(res.role);
            $('#update_resident_type').val(res.resident_type);
            
        },
        error: function (err) {
            console.log(err, "error");
        }
    });
}

function approvedUser(id) {

    console.log(id);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "approved_user/" + id,
        data: id,
        dataType: "json",
        success: function (res) {
            console.log(res, "res");
            location.reload();
        },
        error: function (err) {
            console.log(err, "error");
        }
    });

}

function blockUser(id) {
    console.log(id);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "block_user/" + id,
        data: id,
        dataType: "json",
        success: function (res) {
            console.log(res, "res");
            location.reload();
        },
        error: function (err) {
            console.log(err, "error");
        }
    });
}

