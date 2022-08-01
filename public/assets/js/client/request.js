
$(document).ready(function () {
    console.log('request js here');
   
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
})