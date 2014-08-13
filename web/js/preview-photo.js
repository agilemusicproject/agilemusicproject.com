$(document).ready(function() {
    $("#form_photo").change(function() {
        $('#form_photo_url').val('');
        if (this.files[0]) {
            var reader= new FileReader();
            reader.onload = function (e) {
                $('.preview').css("display", "inline").attr('src', e.target.result);
                $("#newPreviewLabel").css("display", "inline");
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    $('#form_photo_url').on('input', function() {
        var url = $('#form_photo_url').val();
        if (url != "") {
            $('#form_photo').val('');
            $('.preview').css("inline", "block").attr('src', url);
            $("#newPreviewLabel").css("display", "inline");
        }
    });
    $(".preview").error(function() {
        $(this).css("display", "none");
        $("#newPreviewLabel").css("display", "none");
    });
    $("#form_photo_actions").change(function() {
        var option = $("#form_photo_actions option:selected").text();
        if (option == "Add Nothing" || option == "Do Nothing" || option == "Delete Photo") {
            $(".preview").css("display", "none");
            $("#newPreviewLabel").css("display", "none");
        }
    });
});
