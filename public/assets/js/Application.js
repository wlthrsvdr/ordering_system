$('#input_apk').on('change', function (e) {

    // var fileName = $(this).val();

    $(this).next('.custom-file-label').html(e.target.files[0].name);
})