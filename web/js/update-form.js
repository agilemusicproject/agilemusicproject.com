function duplicateFileError(filename) {
    $.ajax({
        url: "/images/photos/" . filename,
        success: function(data) {
            if ($(data).find("img")[0].exists()) {
                $("#form_photo").after("<div id=\"duplicateError\">There is already a file with this name.</div>");
                $("#form_photo_rename").css("display","block");
            } else {
                $("#form_submit").removeAttr("disabled");
                $("#duplicateError").remove();
            }
        }
    });
}
$(document).ready(function() {
    $("#form_photo_actions").change(function() {
        $("#form_photo_rename").css("display","none");
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
    $("#form_photo").change(function() {
        $("#form_submit").attr("disabled", "disabled");
        var filename = $(this)[0].files[0].name;
        duplicateFileError(filename);
    });
    $('#form_photo_rename').on('input', function() {
        var filename = $('#form_photo_rename').val();
        duplicateFileError(filename);
    });
});
