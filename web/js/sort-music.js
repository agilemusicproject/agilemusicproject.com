$(document).ready(function() {
   $('#sortMusic').sortable({
      update: function(event, ui) {
         var data = $(this).sortable('serialize');
         $.ajax({
            data: data,
            type: 'POST',
            url: '/music/update'
        });
      }
   });

});
