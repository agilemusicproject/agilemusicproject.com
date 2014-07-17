$(document).ready(function() {
if ( $('#emailNotification').attr('value') == "1" ) {
      console.log('true');
      $("#contactForm")[0].reset();
    }
console.log('false');
});
