$(document).ready(function () {

});


function getAnnouncement(id) {

    $('#update_annoucement_modal').modal('show');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: "get_annoucement/" + id,
        data: "data",
        dataType: "json",
        success: function (res) {
            console.log(res);
            $('#annoucement_id').val(res.id);
            $('#update_annoucement_txtarea').val(res.annoucement);


        },
        error: function (err) {
            console.log(err, "error");
        }
    });
}

$('#update_annoucement_form').submit(function (e) {
    e.preventDefault();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "update_announcement",
        data: $('#update_annoucement_form').serialize(),
        dataType: "json",
        success: function (res) {
            $('#update_annoucement_modal').modal('hide');
            location.reload();
        },
        error: function (err) {

        }
    });

});


function removeBanner(id) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "remove_banner_annoucement/" + id,
        data: "data",
        dataType: "json",
        success: function (res) {

            if (res) {
                location.reload();
            }
        },
        error: function (err) {
            console.log(err, "err");
        }
    });

}



function addBanner(id) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "put_banner_annoucement/" + id,
        data: "data",
        dataType: "json",
        success: function (res) {

            if (res) {
                location.reload();
            }
        },
        error: function (err) {
            console.log(err, "err");
        }
    });

}