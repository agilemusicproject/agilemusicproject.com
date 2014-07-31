$(document).ready(function() {
   $('#sortMusic').sortable({
      update: function(event, ui) {
         var sortData = $(this).sortable('serialize');
         $.post('/music/update', {list: sortData}, function(o) {},'json');
      }
   });
});
