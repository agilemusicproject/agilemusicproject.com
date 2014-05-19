//the width and height of the image. Use to make the width and heigth of the canvas
var width = 610;
var height = 458;

function drawPostNote(idName, text, degrees)
{
    var canvas = document.getElementById( idName );
    canvas.width = width/2;
    canvas.height = height/2;
    var context = canvas.getContext("2d");
    var imageObj = new Image();
    context.translate(canvas.width/2, canvas.height/2);
    context.rotate(degrees * Math.PI/180);
    context.translate(-canvas.width/2, -canvas.height/2);
    imageObj.onload = function() {
        context.drawImage(imageObj, 0, 0, canvas.width, canvas.height);
        context.font = "20pt Calibri";
        context.fillText(text, canvas.width/3, canvas.height/3);
        context.textAlign = 'center';
    };
    imageObj.src = "images/sticky-notes_v2.png";
}