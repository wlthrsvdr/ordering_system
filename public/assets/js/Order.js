$(document).ready(function () {
    var orderId = 0;

    $('#order_rfid_text').focus();
    $('body').mousemove(function () {
        $('#order_rfid_text').focus();


    });

    $('#pay-card-button').on('click', function () {

        orderId = $(this).attr("order-id")

        $('#confirm-pay-via-card').modal('show');
        $('#order_rfid_text').focus();

    });

    $('#confirm-pay-via-card').on('shown.bs.modal', function () {

        $('#order_rfid_text').focus();


    });

    (function update() {
        $('#order_rfid_text').on('keyup', delay(function (e) {
            if ($(this).val().length >= 10) {
                // $('#order_rfid_text').trigger("keyup");
                // var rfidText = $(this).val();
                var rfidText = document.getElementById("order_rfid_text").value;
                var AlertMsg = $('div[role="alert"]');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    url: "order/pay-via-card",
                    data: {
                        card: rfidText,
                        orderId: orderId
                    },
                    dataType: "json",
                    success: function (res) {
                        if (res.status_code === 401) {
                            ShowAlert('', res.msg, 'danger');
                            $('#order_rfid_text').val('');
                            $('#order_rfid_text').blur();
                            setTimeout(function () {
                                $(AlertMsg).hide();
                                location.reload(true);
                            }, 2000);
                        } else {
                            ShowAlert('', res.msg, "success");
                            console.log("asd")
                            $('#order_rfid_text').val('');
                            $('#order_rfid_text').blur();
                            setTimeout(function () {
                                $(AlertMsg).hide();
                                location.reload(true);
                            }, 2000);
                        }
                    },
                    error: function (err) {
                        $('#order_rfid_text').val('');
                        ShowAlert('', 'Rfid number not found', 'danger');


                    }
                })

            }

        }, 500));
    })();
});


function delay(fn, ms) {
    let timer = 0
    return function (...args) {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
    }
}


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