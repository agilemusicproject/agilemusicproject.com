$(document).ready(function(){
  window.alert = function(message, fallback){
    if(fallback)
    {
        old_alert(message);
        return;
    }
    $(document.createElement('div'))
    .attr({title: 'Alert', 'class': 'alert'})
    .html(message)
    .dialog({
      buttons: [
        {text: "Yes", click: function(){$(this).dialog('close');}},
        {text: "No", click: function(){$(this).dialog('close');}}
      ],
      close: function(){$(this).remove();},
      draggable: true,
      modal: true,
      resizable: false,
      width: 'auto'
    });
  };
});
