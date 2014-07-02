$(document).ready(function() {
   var sortData;
   $('#sortMusic').sortable({
      update: function(event, ui) {
         sortData = $(this).sortable('serialize');
      }
   });
   $('#sortSubmit').click(function(){
      $.post('/music/update', {list: sortData}, function(o) {
            },'json');
   });

});
