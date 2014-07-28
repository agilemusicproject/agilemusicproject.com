function duplicateFileError(filename, divID) {
    $("#form_submit").attr("disabled", "disabled");
        if ($("#checking").length == 0) {
            $(divID).after("<div id=\"checking\">Checking file...</div>");
        }
    $.ajax({
        url: "/images/photos/" + filename,
        success: function(data) {
            $("#checking").remove();
            if ($("#duplicateError").length == 0) {
                $(divID).after("<div id=\"duplicateError\">There is already a file with this name.</div>");
            }
            $("#form_photo_rename").css("display","block");
            $(divID).css("display","none");
        },
        error: function(err)
        {
            console.log(err);
            $("#form_submit").removeAttr("disabled");
            $("#duplicateError").remove();
            $("#checking").remove();
        }
    });
}

$(document).ready(function() {
    var divID = null;
    $("#form_photo_actions").change(function() {
        $("#form_photo_rename").css("display","none");
        var choice = $(this).val();
        if (choice == "photo_file") {
            $("#form_photo")[0].style.display='block';
            $("#form_photo").prop('required', true);
            $("#form_photo_url")[0].style.display='none';
            $("#form_photo_url").prop('required', false);
            $("#form_photo_rename").prop('required', false);
        } else if (choice == "photo_url") {
            $("#form_photo")[0].style.display='none';
            $("#form_photo").prop('required', false);
            $("#form_photo_url")[0].style.display='block';
            $("#form_photo_url").prop('required', true);
            $("#form_photo_rename").prop('required', false);
        } else {
            $("#form_photo")[0].style.display='none';
            $("#form_photo").prop('required', false);
            $("#form_photo_url")[0].style.display='none';
            $("#form_photo_url").prop('required', false);
            $("#form_photo_rename").prop('required', true);
        }
    });
    $("#form_photo").change(function() {
        divID = "#form_photo";
        var filename = $(this)[0].files[0].name;
        duplicateFileError(filename, divID);
    });
    $("#form_photo_rename").on('input', function() {
        var filename = $('#form_photo_rename').val();
        duplicateFileError(filename, divID);
    });
    $("#form_photo_url").on('input', function() {
        divID = "#form_photo_url";
        var url = $('#form_photo_url').val();
        var filename = url.substr(url.lastIndexOf("/") + 1);
        duplicateFileError(filename, divID);
    });
});
