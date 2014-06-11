function photoOptions()
{
    $("input[id='form_photo_actions_0']").change(function(){
        document.getElementById('form_photo').style.display='none';
    });
    
    $("input[id='form_photo_actions_1']").change(function(){
        document.getElementById('form_photo').style.display='block';
    });
    
    $("input[id='form_photo_actions_2']").change(function(){
        document.getElementById('form_photo').style.display='none';
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