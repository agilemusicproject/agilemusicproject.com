var isDuplicateFile = null;
function setDuplicateFileValue(value) {
    isDuplicateFile = value;
}
function getDuplicateFileValue() {
    return isDuplicateFile;
}
function duplicateFileError(filename, divID) {
    $.ajax({
        async: false,
        url: "/images/photos/" + filename,
        success: function(data) {
            $("#checking").remove();
            if ($("#duplicateError").length == 0) {
                $(divID).after("<div id=\"duplicateError\">There is already a file with this name.</div>");
            }
            $("#form_photo_rename").css("display","block").val('');
            $(divID).css("display","none");
            setDuplicateFileValue(true);
        },
        error: function(err)
        {
            $("#duplicateError").remove();
            $("#checking").remove();
            setDuplicateFileValue(false);
        }
    });
    return getDuplicateFileValue();
}

$(document).ready(function() {
    var divID = "#form_photo";
    function updateDivID(newDivID) {
        divID = newDivID;
    }
    function getDivID() {
        return divID;
    }
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
        updateDivID(divID);
    });
    $("#form_submit").click(function() {
        var filename;
        divID = getDivID();
        if ($('#form_photo_rename').val() != "") {
            filename = $('#form_photo_rename').val();
        } else if (divID == "#form_photo_url"){
            var url = $('#form_photo_url').val();
            filename = url.substr(url.lastIndexOf("/") + 1);
        } else if (divID == "#form_photo"){
            filename = $(divID)[0].files[0].name;
        }
        if ($("#checking").length == 0) {
            $(divID).after("<div id=\"checking\">Checking file...</div>");
        }
        if (!duplicateFileError(filename, divID)) {
            $("#photoEditForm").submit();
        }
    });
});
