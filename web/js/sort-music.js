$(document).ready(function() {
   $('#sortMusic').sortable({
      update: function(event, ui) {
         var sortData = $(this).sortable('serialize');
         console.log(sortData);
            $.post('/music/update', {list: sortData}, function(o) {
            },'json');
      }
   });

});
