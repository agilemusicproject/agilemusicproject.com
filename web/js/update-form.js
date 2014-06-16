function photoOptions()
{
    $("select[id='form_photo_actions']").change(function(){
        document.getElementById('form_photo').style.display='none';
        if ($(this).val() == "photo_nothing" || $(this).val() == "photo_delete") {
            document.getElementById('form_photo').style.display='none';
        } else {
            document.getElementById('form_photo').style.display='block';
        }
    });
}

function showOptions()
{
    document.getElementById('form_photo_actions').style.display='block';
}

function hideFileInput()
{
    document.getElementById('form_photo').style.display='none';
}