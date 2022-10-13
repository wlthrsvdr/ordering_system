$(document).ready(function () {
    $('#rfid_text').focus();
});


function showModal(id) {
    var userId = id;

    $('#confirm-reg-card').modal('show');
    $('#rfid_text').focus();

    (function update() {
        $('#rfid_text').on('keyup', delay(function (e) {
            if ($(this).val().length >= 10) {
                // var rfidText = $(this).val();
                var rfidText = document.getElementById("rfid_text").value;
                var AlertMsg = $('div[role="alert"]');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    url: "customer/register-card",
                    data: {
                        rfidText: rfidText,
                        userId: userId
                    },
                    dataType: "json",
                    success: function (res) {
                        if (res) {
                            if (res.status_code === 401) {
                                ShowAlert('', res.msg, 'danger');
                                $('#rfid_text').val('');
                                setTimeout(function () {
                                    $(AlertMsg).hide();
                                }, 2000);
                            } else {
                                ShowAlert('', res.msg, "success");
                                $('#rfid_text').val('');
                                setTimeout(function () {
                                    $(AlertMsg).hide();
                                    location.reload();
                                }, 2000);
                            }
                        }
                    },
                    error: function (err) {
                        $('#rfid_text').val('');
                        ShowAlert('', 'Rfid number not found', 'danger');


                    }
                })

            }

        }, 500))
    })();
}

$('#pay-card-button').on('click', function () {
    console.log("Asdasd");
    var userId = $(this).attr("user-id")

    $('#confirm-reg-card').modal('show');

    $('#rfid_text').focus();
    $('body').mousemove(function () {
        $('#rfid_text').focus();


    });


    (function update() {
        $('#rfid_text').on('keyup', delay(function (e) {
            if ($(this).val().length >= 10) {
                // var rfidText = $(this).val();
                var rfidText = document.getElementById("rfid_text").value;
                var AlertMsg = $('div[role="alert"]');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    url: "customer/register-card",
                    data: {
                        rfidText: rfidText,
                        userId: userId
                    },
                    dataType: "json",
                    success: function (res) {
                        if (res) {
                            if (res.status_code === 401) {
                                ShowAlert('', res.msg, 'danger');
                                $('#rfid_text').val('');
                                setTimeout(function () {
                                    $(AlertMsg).hide();
                                }, 2000);
                            } else {
                                ShowAlert('', res.msg, "success");
                                $('#rfid_text').val('');
                                setTimeout(function () {
                                    $(AlertMsg).hide();
                                    location.reload();
                                }, 2000);
                            }
                        }
                    },
                    error: function (err) {
                        $('#rfid_text').val('');
                        ShowAlert('', 'Rfid number not found', 'danger');


                    }
                })

            }

        }, 500))
    })();

});

$('#confirm-reg-card').on('shown.bs.modal', function () {

    $('#rfid_text').focus();

});

function ShowAlert(msg_title, msg_body, msg_type) {
    var AlertMsg = $('div[role="alert"]');
    $(AlertMsg).find('strong').html(msg_title);
    $(AlertMsg).find('p').html(msg_body);
    $(AlertMsg).removeAttr('class');
    $(AlertMsg).addClass('alert alert-' + msg_type);
    $(AlertMsg).show();
}

$(function () {
    $(".action-pay-via-card").on("click", function () {
        var btn = $(this);
        $("#btn-confirm-pay-via-card").attr({
            "href": btn.data('url')
        });
    });

})

function delay(fn, ms) {
    let timer = 0
    return function (...args) {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
    }
}