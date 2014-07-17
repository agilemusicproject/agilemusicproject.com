$(document).ready(function() {
    if ( $('#emailNotification').attr('value') == "1" ) {
        $(':input','#contactForm')
        .not(':submit')
        .val('');
    }
});
