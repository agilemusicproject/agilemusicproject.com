//Draws a single post-it note graphic on the canvas "idName", puts "text on the note, and rotates the note by "degrees"
function drawPostNote(idName, textArray, degrees, filename)
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
        for (i=0; i<textArray.length; i++) {
            context.fillText(textArray[i], canvas.width/3, canvas.height/3 + (i*30));
        }
        context.textAlign = 'center';
    };
    imageObj.src = "/images/" + filename;
}

function drawIndexPage()
{
    drawMusicPostNote();
    drawAgilePostNote();
    drawBandPostNote();
    drawPhotosPostNote();
    drawBlogPostNote();
    drawContactPostNote();
    drawAboutPostNote();
    drawNewsPostNote();
}

function drawMusicPostNote()
{
    drawPostNote( "musicpostcard", ["Our Music"], -10, "sticky-notes_v23.png"); //16 is brighter
}

function drawAgilePostNote()
{
    drawPostNote( "agilepostcard", ["Agile"], -7, "sticky-notes_v20.png");
}

function drawBandPostNote()
{
    drawPostNote( "meetTheBandpostcard", ["Meet", "the Band"], 15, "sticky-notes_v12.png");
}

function drawPhotosPostNote()
{
    drawPostNote( "photospostcard", ["Photos"], 4.5, "sticky-notes_v21.png");
}

function drawBlogPostNote()
{
    drawPostNote( "blogpostcard", ["Blog"], 4.5, "sticky-notes_v14.png");
}

function drawContactPostNote()
{
    drawPostNote( "contactuspostcard", ["Contact Us"], -7, "sticky-notes_v13.png");
}

function drawAboutPostNote()
{
    drawPostNote( "aboutpostcard", ["About Us"], 17, "sticky-notes_v10.png");
}

function drawNewsPostNote()
{
    drawPostNote( "newspostcard", ["Our News"], -8, "sticky-notes_v15.png");
}
