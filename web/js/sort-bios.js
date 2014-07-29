$(document).ready(function() {
   $('#sortBios').sortable({
      update: function(event, ui) {
         var sortData = $(this).sortable('serialize');
         $.post('/meettheband/reorder', {list: sortData}, function(o) {},'json');
      }
   });

});
