$(document).ready(function () {

});

$("#input_img").change(function (event) {
    var src = $(this).val();

    // $("#imagePreview").html(src ? "<img src='" + src + "'>" : "");
    var image = document.getElementById('output');
    image.src = URL.createObjectURL(event.target.files[0]);
});

