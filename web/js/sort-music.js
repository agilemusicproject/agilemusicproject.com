$(document).ready(function() {
   var sortData = $('#sortMusic').sortable({
      update: function(event, ui) {
         return $(this).sortable('serialize');
      }
   });
   $('#sortSubmit').click(function(sortData){
      $.post('/music/update', {list: sortData}, function(o) {
      },'json');
   });
});
