$(document).ready(function() {
    $("#form_photo_actions").change(function() {
        $("#form_photo")[0].style.display='none';
        if ($(this).val() == "photo_nothing" || $(this).val() == "photo_delete") {
            $("#form_photo")[0].style.display='none';
        } else {
           $("#form_photo")[0].style.display='block';
        }
    });
});
