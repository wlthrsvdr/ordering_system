$(document).ready(function () {
    $('#info_contianer').hide();

    $('#wallet_rfid_text').focus();
    $('#wallet_rfid_info_text').focus();

    // $('body').mousemove(function () {
    //     $('#wallet_rfid_text').focus();
    //     $('#wallet_rfid_info_text').focus();

    // });
});


(function update() {
    $('#wallet_rfid_text').on('keyup', delay(function (e) {
        if ($(this).val() >= 10) {
            // var rfidText = $(this).val();
            // $('#wallet_rfid_info_text').val($(this).val());

            var rfidText = document.getElementById("wallet_rfid_text").value;
            $('#wallet_rfid_info_text').val(document.getElementById("wallet_rfid_text").value);
            var AlertMsg = $('div[role="alert"]');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "get-info",
                data: {
                    rfidText: rfidText
                },
                dataType: "json",
                success: function (res) {

                    $('#back_tap_container').hide();
                    $('#back_info_contianer').show();
                    $('#wallet_rfid_text').blur();
                    $('#wallet_rfid_text').focus();

                    $('#back_userId').val(res.id);
                    $('#back_input_firstname').val(res.firstname);
                    $('#back_input_middlename').val(res.middlename);
                    $('#back_input_lastname').val(res.lastname);
                    $('#back_input_contact_number').val(res.contact_number);
                    $('#back_input_balance').val(res.e_money);

                    $(AlertMsg).hide();
                },
                error: function (err) {
                    $('#wallet_rfid_text').val('');
                    $('#wallet_rfid_info_text').val('');
                    ShowAlert('error', 'Rfid number not found', 'danger');
                    // console.log(err, "error");
                    // // location.reload(true)
                }
            });

        }
    }, 500));
})();

function ShowAlert(msg_title, msg_body, msg_type) {
    var AlertMsg = $('div[role="alert"]');
    $(AlertMsg).find('strong').html(msg_title);
    $(AlertMsg).find('p').html(msg_body);
    $(AlertMsg).removeAttr('class');
    $(AlertMsg).addClass('alert alert-' + msg_type);
    $(AlertMsg).show();
}

function delay(fn, ms) {
    let timer = 0
    return function (...args) {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
    }
}


