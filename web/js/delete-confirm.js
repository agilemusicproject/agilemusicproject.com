$(document).ready(function(){
  $(".deleteButton").click(function(){
    $( ".dialogBox" ).dialog({
      buttons: [ { text: "Yes", click: function() { $( this ).dialog( "close" ); } },
               { text: "No", click: function() { $( this ).dialog( "close" ); return false; } }]
    });
  });
});
