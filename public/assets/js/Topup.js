$(document).ready(function () {
    var text = "123456";
    var firstname = "waltz";
    $('#info_contianer').hide();

    $('#rfid_text').focus();
    $('body').mousemove(function () {
        $('#rfid_text').focus();


    });

    // (function update()
    $('#rfid_text').keyup(function () {
        if ($(this).val() != '') {
            var rfidText = $(this).val();
            $('#rfid_info_text').val($(this).val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "get-info/" + rfidText,
                data: "data",
                dataType: "json",
                success: function (res) {
                    console.log(res);
                    var AlertMsg = $('div[role="alert"]');

                    $('#tap_container').hide();
                    $('#info_contianer').show();

                    $('#userId').val(res.id);
                    $('#input_student_num').val(res.student_number);
                    $('#input_firstname').val(res.firstname);
                    $('#input_middlename').val(res.middlename);
                    $('#input_lastname').val(res.lastname);
                    $('#input_account_type').val(res.user_role);
                    $('#input_balance').val(res.e_money);

                    $(AlertMsg).hide();
                },
                error: function (err) {
                    $('#rfid_info_text').val('');
                    $('#rfid_text').val('');
                    ShowAlert('error', 'Rfid number not found', 'danger');
                    // console.log(err, "error");
                    // // location.reload(true)
                }
            });

        }

    })
    // .then(function () {
    //     setTimeout(update, 3000);
    // });
    // })();
});

function ShowAlert(msg_title, msg_body, msg_type) {
    var AlertMsg = $('div[role="alert"]');
    $(AlertMsg).find('strong').html(msg_title);
    $(AlertMsg).find('p').html(msg_body);
    $(AlertMsg).removeAttr('class');
    $(AlertMsg).addClass('alert alert-' + msg_type);
    $(AlertMsg).show();
}

