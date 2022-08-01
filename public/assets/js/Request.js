$(document).ready(function () {



});


function printForm(id, type, is_approved) {

    console.log(id);

    if (is_approved == 1) {

        $.ajax({
            type: "get",
            url: "printCertificate/" + id + '/' + type,
            data: "data",
            xhrFields: {
                responseType: "blob"
            },
            success: function (res) {
                // console.log(res);
                $("#PrintCertModal").modal("show");
                var url = window.URL.createObjectURL(res);
                $("#printCert").attr("src", url + '#toolbar=0&navpanes=0&scrollbar=0');

            },
            error: function (err) {
                // location.reload();
                console.log(err);
            }
        });

    } else {

        $.ajax({
            type: "get",
            url: "printCertificate/" + id + '/' + type,
            data: "data",
            xhrFields: {
                responseType: "blob"
            },
            success: function (res) {
                location.reload();

            },
            error: function (err) {

                console.log(err);
            }
        });

    }



}

function PrintNow() {

    var cert_id = $('#cert_id').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "complete_print/" + cert_id,
        data: "data",
        dataType: "json",
        success: function (res) {

            if (res) {
                var myIframe = document.getElementById("printCert").contentWindow;
                myIframe.focus();
                myIframe.print();
                // location.reload();
                return false;

            }
        },
        error: function (err) {
            console.log(err, "err");
        }
    });

    // var cert_id = $('#cert_id').val();
    // console.log(cert_id);

    // var myIframe = document.getElementById("printCert").contentWindow;
    // myIframe.focus();
    // myIframe.print();
    // return false;
}

function approved(id) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "approved/" + id,
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

function disapproved(id) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "disapproved/" + id,
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