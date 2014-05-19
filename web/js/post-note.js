//Draws a single post-it note graphic on the canvas "idName", puts "text on the note, and rotates the note by "degrees"
function drawPostNote(idName, text, degrees)
{
    //the width and height of the image. Use to make the width and heigth of the canvas
    var canvas = document.getElementById(idName);
    canvas.width = 305;
    canvas.height = 229;
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
    imageObj.src = "images/sticky-notes.png";
}

function drawIndexPage()
{
    drawPostNote( "musicpostcard", "Music", -10);
    drawPostNote( "agilepostcard", "Agile", -7);
    drawPostNote( "meetTheBandpostcard", "The Band", 15);
    drawPostNote( "photospostcard", "Photos", 17);
    drawPostNote( "blogpostcard", "Blog", 4.5);     
    drawPostNote( "contactuspostcard", "Contact Us", -7);
    drawPostNote( "aboutpostcard", "About us", 17);
}