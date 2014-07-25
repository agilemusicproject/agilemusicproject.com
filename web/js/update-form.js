$(document).ready(function() {
    $("#form_photo_actions").change(function() {
        var choice = $(this).val();
        if (choice == "photo_file") {
            $("#form_photo")[0].style.display='block';
            $("#form_photo").prop('required', true);
            $("#form_photo_url")[0].style.display='none';
            $("#form_photo_url").prop('required', false);
        } else if (choice == "photo_url") {
            $("#form_photo")[0].style.display='none';
            $("#form_photo").prop('required', false);
            $("#form_photo_url")[0].style.display='block';
            $("#form_photo_url").prop('required', true);
        } else {
            $("#form_photo")[0].style.display='none';
            $("#form_photo").prop('required', false);
            $("#form_photo_url")[0].style.display='none';
            $("#form_photo_url").prop('required', false);
        }
    });
});
