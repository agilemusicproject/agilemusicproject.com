function photoOptions()
{
    $("#form_photo_actions").change(function(){
        // change rest to jquery too
       // document.getElementById('form_photo').style.display='none';
        $("#form_photo")[0].style.display='none';
        if ($(this).val() == "photo_nothing" || $(this).val() == "photo_delete") {
            //document.getElementById('form_photo').style.display='none';
            $("#form_photo")[0].style.display='none';
        } else {
           // document.getElementById('form_photo').style.display='block';
           $("#form_photo")[0].style.display='block';
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