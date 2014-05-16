var width = 610;
var height = 458;

function drawPostNote(idName, Xcoordinate, Ycoordinate, text)
{
  var canvas = document.getElementById( idName );
  canvas.width = width/2;
  canvas.height = height/2;
  var context = canvas.getContext("2d");
  var imageObj = new Image();
  imageObj.onload = function(){
    context.drawImage(imageObj, Xcoordinate, Ycoordinate, canvas.width, canvas.height);
    context.font = "20pt Calibri";
    context.fillText(text, canvas.width/3, canvas.height/3);
    context.textAlign = 'center';
  };
  imageObj.src = "images/sticky-notes.bmp";
}