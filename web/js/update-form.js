function duplicateFileError(filename, divID) {
    var results = $.ajax({
        async: false,
        url: "/images/photos/" + filename,
        success: function(data) {
            $("#checking").remove();
            if ($("#duplicateError").length == 0) {
                $(divID).after("<div id=\"duplicateError\">There is already a file with this name.</div>");
            }
            $("#form_photo_rename").css("display","block").val('');
            $(divID).css("display","none");
        },
        error: function(err, status)
        {
            $("#duplicateError").remove();
            $("#checking").remove();
        }
    });
    if (results.status == "200") {
        return true;
    } else {
        return false;
    }
}
//TODO did not submit when upload photo from url
$(document).ready(function() {
    var divID = "#form_photo";
    var fileExtension;
    $("#form_photo_actions").change(function() {
        $("#form_photo_rename").css("display","none");
        var choice = $(this).val();
        if (choice == "photo_file") {
            $("#form_photo")[0].style.display='block';
            $("#form_photo").prop('required', true);
            $("#form_photo_url")[0].style.display='none';
            $("#form_photo_url").prop('required', false);
            divID = "#form_photo";
        } else if (choice == "photo_url") {
            $("#form_photo")[0].style.display='none';
            $("#form_photo").prop('required', false);
            $("#form_photo_url")[0].style.display='block';
            $("#form_photo_url").prop('required', true);
            divID = "#form_photo_url";
        } else {
            $("#form_photo")[0].style.display='none';
            $("#form_photo").prop('required', false);
            $("#form_photo_url")[0].style.display='none';
            $("#form_photo_url").prop('required', false);
            divID = null;
        }
        console.log("updating divID to " + divID);
    });
    $("#form_submit").click(function() {
        var filename;
        console.log("getting divID: " + divID);
        if ($('#form_photo_rename').val()) {
            filename = $('#form_photo_rename').val() + fileExtension;
            $('#form_photo_rename').val(filename);
        } else if (divID == "#form_photo_url") {
            var url = $('#form_photo_url').val();
            filename = url.substr(url.lastIndexOf("/") + 1);
            fileExtension = filename.substr(filename.lastIndexOf('.'));
        } else if (divID == "#form_photo") {
            filename = $(divID)[0].files[0].name;
            fileExtension = filename.substr(filename.lastIndexOf('.'));
        }
        if ($("#checking").length == 0) {
            $(divID).after("<div id=\"checking\">Checking file...</div>");
        }
        if (!duplicateFileError(filename, divID)) {
            $("#photoEditForm").submit();
        }
    });
});
