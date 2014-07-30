function imageFound(divID) {
    if ($("#duplicateError").length == 0) {
        $(divID).after("<div id=\"duplicateError\">There is already a file with this name.</div>");
    }
    $("#form_photo_rename").css("display","block").val('').focus();
    $(divID).css("display","none");
    return true;
}

function imageNotFound() {
    $("#duplicateError").remove();
    return false;
}

function fileNameExists(filename) {
    var http = new XMLHttpRequest();
    http.open('POST', "/images/photos/" + filename, false);
    http.send();
    return http.status != 404;
}

function duplicateFileError(filename, divID) {
    if (fileNameExists(filename)) {
        return imageFound(divID);
    } else {
        return imageNotFound();
    }
}

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
    });
    $("#form_submit").click(function() {
        var filename;
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
        if (!duplicateFileError(filename, divID)) {
            $("#photoEditForm").submit();
        }
    });
});
