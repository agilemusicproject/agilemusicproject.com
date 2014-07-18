$(document).ready(function(){
  $(".deleteButton").click(function(){
    $('.dialogBox').css("display", "block");
    $('.deleteButton').css("display", "none");
  });
  $(".cancelButton").click(function(){
    $('.dialogBox').css("display", "none");
    $('.deleteButton').css("display", "block");
  });
});
