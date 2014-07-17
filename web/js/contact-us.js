$(document).ready(function() {
    if ( $('#emailNotification').attr('value') == "1" ) {
        $(':input','#contactForm').val('');
    }
    console.log('false');
});
