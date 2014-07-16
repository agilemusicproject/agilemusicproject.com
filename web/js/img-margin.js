(function ($) {
    $(document).ready(function() {
       $(".post-entry img").each(function() {
           marginBottom = parseInt($(this).css("marginBottom"), 10);
           remainder = parseInt($(this).outerHeight(true), 10) % 20;
           $(this).css("marginBottom", marginBottom-remainder+"px");
       });
    });
}(jQuery));