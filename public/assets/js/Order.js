$(document).ready(function () {


});


// function getData(orderId) {
//     console.log(orderId);
// }

$('#pay-card-button').on('click', function () {

    var orderId = $(this).attr("order-id")

    $('#confirm-pay-via-card').modal('show');

    $('#rfid_text').focus();
    $('body').mousemove(function () {
        $('#rfid_text').focus();


    });


    (function update() {
        $('#rfid_text').keyup(function () {
            if ($(this).val().length > 0) {
                var rfidText = $(this).val();
                var AlertMsg = $('div[role="alert"]');
                var textVal = $(this).val();

                console.log('lenght', textVal.length);
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
                    },
                    error: function (err) {
                        $('#rfid_text').val('');
                        ShowAlert('', 'Rfid number not found', 'danger');


                    }
                })

            }

        }).then(function () {
            setTimeout(update, 3000);
        });
    })();

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