$(document).ready(function () {

});


function getNews(id) {

    $('#update_news_modal').modal('show');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: "get_news/" + id,
        data: "data",
        dataType: "json",
        success: function (res) {
            console.log(res.news);
            $('#news_id').val(res.id);
            $('#new_title_id').val(res.news_title);
            $('#posted_by_id').val(res.posted_by);
            $('#position_id').val(res.position);
            $('#news_textarea_id').val(res.news);

        },
        error: function (err) {
            console.log(err, "error");
        }
    });
}

$('#update_news_form').submit(function (e) {
    e.preventDefault();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "update_news",
        data: $('#update_news_form').serialize(),
        dataType: "json",
        success: function (res) {
            console.log(res);
            $('#update_news_modal').modal('hide');
            location.reload();
        },
        error: function (err) {
            console.log(err);
        }
    });

});