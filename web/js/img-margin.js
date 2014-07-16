// using jquery instead of $ because wordpress
jQuery(document).ready(function() {
   jQuery(".post-entry img").each(function(index, e) {
       marginBottom = parseInt(jQuery(e).css("marginBottom"), 10);
       remainder = parseInt(jQuery(e).outerHeight(true), 10) % 20;
       offset = marginBottom - remainder;
       jQuery(e).css("marginBottom", offset + "px");
   });
});
