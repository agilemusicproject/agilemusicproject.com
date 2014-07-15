$(document).ready(function() {
    $("#form_photo_actions").change(function() {
        var choice = $(this).val();
        if (choice == "photo_file") {
            $("#form_photo")[0].style.display='block';
            $("#form_photo_url")[0].style.display='none';
        } else if (choice == "photo_url") {
            $("#form_photo")[0].style.display='none';
            $("#form_photo_url")[0].style.display='block';
        } else {
            $("#form_photo")[0].style.display='none';
            $("#form_photo_url")[0].style.display='none';
        }
    });
});
