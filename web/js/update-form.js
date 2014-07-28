function duplicateFileError(filename) {
    $.ajax({
        url: "/images/photos/" + filename,
        success: function(data) {
            $("#checking").remove();
            if ($("#duplicateError").length == 0) {
                $("#form_photo").after("<div id=\"duplicateError\">There is already a file with this name.</div>");
            }
            $("#form_photo_rename").css("display","block");
            $("#form_photo").css("display","none");
        },
        error: function(err)
        {
            $("#form_submit").removeAttr("disabled");
            $("#duplicateError").remove();
            $("#checking").remove();
        }

    });
}
$(document).ready(function() {
    $("#form_photo_actions").change(function() {
        $("#form_photo_rename").css("display","none");
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
    $("#form_photo").change(function() {
        $("#form_submit").attr("disabled", "disabled");
        $("#form_photo").after("<div id=\"checking\">Checking file...</div>");
        var filename = $(this)[0].files[0].name;
        duplicateFileError(filename);
    });
    $('#form_photo_rename').on('input', function() {
        $("#form_submit").attr("disabled", "disabled");
        $("#form_photo").after("<div id=\"checking\">Checking file...</div>");
        var filename = $('#form_photo_rename').val();
        duplicateFileError(filename);
    });
});
