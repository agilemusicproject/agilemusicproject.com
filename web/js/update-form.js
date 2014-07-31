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
        } else if (divID == "#form_photo" && $(divID)[0].files[0] !== undefined) {
            filename = $(divID)[0].files[0].name;
            fileExtension = filename.substr(filename.lastIndexOf('.'));
        }
        if (filename !== undefined || divID === null) {
            $(divID).after("<div id=\"checking\">Checking file...</div>");
            $("#duplicateError").remove();
            $("#form_submit").attr("disabled", "disabled");
            $(".cancel_button").attr("disabled", "disabled");
            $.get('/checkImage/' + filename, function(data) {
                $('#checking').remove();
                $("#form_submit").removeAttr("disabled");
                $(".cancel_button").removeAttr("disabled");
                if (data.fileExists === false) {
                    $("#photoEditForm").submit();
                } else {
                    $(divID).after("<div id=\"duplicateError\">There is already a file with this name.</div>");
                    $("#form_photo_rename").css("display","block").val('').focus();
                }
            });
        }
    });
});
