$(document).ready(function () {
    $("#alert-success").fadeTo(2000, 500).slideUp(500, function () {
        $("#alert-success").slideUp(500);
    });

    $("#alert-failed").fadeTo(2000, 500).slideUp(500, function () {
        $("#alert-failed").slideUp(500);
    });

    $("#alert-danger").fadeTo(2000, 500).slideUp(500, function () {
        $("#alert-danger").slideUp(500);
    });
});