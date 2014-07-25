$(document).ready(function() {
   $('#sortBios').sortable({
      update: function(event, ui) {
         var sortData = $(this).sortable('serialize');
         $.post('/meettheband/sort', {list: sortData}, function(o) {},'json');
      }
   });

});
