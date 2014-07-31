$(document).ready(function() {
    if ($('#emailNotification').attr('data-emailWasSent')) {
        $(':input', '#contactForm')
        .not(':submit, :hidden')
        .val('');
    }
});
