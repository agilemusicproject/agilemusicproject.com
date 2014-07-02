$(document).ready(function() {
    //Enable thumbnail helper and set custom options
    $(".fancybox").fancybox({
        beforeLoad: function() {
            var el, id = $(this.element).data('title-id');

            if (id) {
                el = $('#' + id);
            
                if (el.length) {
                    this.title = el.html();
                }
            }
        },
        helpers:  {
            thumbs : {
                width: 50,
                height: 50
            }
        }
    });
});
