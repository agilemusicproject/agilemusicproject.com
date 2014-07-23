$(document).ready(function() {
    $("#form_photo").change(function() {
        $('#form_photo_url').val('');
        if (this.files[0]) {
            var reader= new FileReader();
            reader.onload = function (e) {
                $('.preview').css("display","block").attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    $('#form_photo_url').on('input', function() {
        var url = $('#form_photo_url').val();
        if (url != "") {
            $('#form_photo').val('');
            $('.preview').css("display","block").attr('src', url);
        }
    });
});
