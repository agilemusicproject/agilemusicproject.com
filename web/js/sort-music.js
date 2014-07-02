$(document).ready(function() {
   $('#sortMusic').sortable({
      update: function(event, ui) {
         var sortData = $(this).sortable('serialize');
   //on click post
         //try sortData instead of o
            $.post('/music/update', {list: sortData}, function(o) {
            },'json');

      }
   });

});
