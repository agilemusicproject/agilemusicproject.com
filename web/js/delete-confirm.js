$(document).ready(function(){
  $(".deleteButton").click(function(){
    if (!confirm("Are you sure you want to kill?")){
      return false;
    }
  });
});
