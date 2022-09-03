let canvas, canvasContext; //variables to reference canvas and canvas context
let mouseX, mouseY, mouseDown = 0; //variables to keep track of mouse positions
let touchX, touchY = 0; //variables to keep track of the touch positions
let lastX, lastY = -1; //variables to keep track of last X, Y positions

let points = [];
let touchLines = [];

$("document").ready(function () {
    $(window).resize(saveResizeAndRedisplay);
    //get canvas element
    canvas = document.getElementById('sketchpad');
    //get 2d drawing context for the canvas
    var rect = canvas.getBoundingClientRect();
    canvas.width = rect.width;
    canvas.height = rect.height;
    if (canvas.getContext)
        canvasContext = canvas.getContext('2d');
    canvasContext.webkitImageSmoothingEnabled = false;
    canvasContext.mozImageSmoothingEnabled = false;
    canvasContext.imageSmoothingEnabled = false;
    //check valid context and add event listener
    if (canvasContext) {
        //add event listener for mouse events
        canvas.addEventListener('mousedown', sketchpad_mouseDown, false);
        canvas.addEventListener('mousemove', sketchpad_mouseMove, false);
        canvas.addEventListener('mouseup', sketchpad_mouseUp, false);

        // add event listener for touch events
        canvas.addEventListener('touchstart', sketchpad_touchStart, false);
        canvas.addEventListener('touchmove', sketchpad_touchMove, false);
    }
});

// Keep track of the mouse button being pressed and draw a dot at current location
function sketchpad_mouseDown() {
    mouseDown = 1;
    drawLine(canvasContext, mouseX, mouseY, 4);
}

// Keep track of the mouse button being released
function sketchpad_mouseUp() {
    mouseDown = 0;

    var touchLine = { };
    touchLine.points = points;
    touchLine.canvasWidth = canvas.width;
    touchLine.canvasHeight = canvas.height;
    touchLines.push(touchLine);
    // Reset lastX and lastY to -1 to indicate that they are now invalid, since we have lifted the "pen"
    lastX = -1;
    lastY = -1;
}

// Keep track of the mouse position and draw a dot if mouse button is currently pressed
function sketchpad_mouseMove(e) {
    // Update the mouse co-ordinates when moved
    getMousePos(e);

    // Draw a dot if the mouse button is currently being pressed
    if (mouseDown == 1) {
        var touchPoint = { };
        var touchLine = { };
        touchPoint.X = mouseX;
        touchPoint.Y = mouseY;
        points.push(touchPoint);
        drawLine(canvasContext, mouseX, mouseY, 4);
    }
}

// Get the current mouse position relative to the top-left of the canvas
function getMousePos(e) {
    if (!e)
        var e = event;

    if (e.offsetX) {
        mouseX = e.offsetX;
        mouseY = e.offsetY;
    } else if (e.layerX) {
        mouseX = e.layerX;
        mouseY = e.layerY;
    }
}

// Draw something when a touch start is detected
function sketchpad_touchStart() {
    // Update the touch co-ordinates
    getTouchPos();

    drawLine(canvasContext, touchX, touchY, 4);

    // Prevents an additional mousedown event being triggered
    event.preventDefault();
}

function sketchpad_touchEnd() {
    // Reset lastX and lastY to -1 to indicate that they are now invalid, since we have lifted the "pen"
    lastX = -1;
    lastY = -1;
}

// Draw something and prevent the default scrolling when touch movement is detected
function sketchpad_touchMove(e) {
    // Update the touch co-ordinates
    getTouchPos(e);
    // During a touchmove event, unlike a mousemove event, we don't need to check if the touch is engaged, since there will always be contact with the screen by definition.
    drawLine(canvasContext, touchX, touchY, 4);

    // Prevent a scrolling action as a result of this touchmove triggering.
    event.preventDefault();
}

// Get the touch position relative to the top-left of the canvas
// When we get the raw values of pageX and pageY below, they take into account the scrolling on the page
// but not the position relative to our target div. We'll adjust them using "target.offsetLeft" and
// "target.offsetTop" to get the correct values in relation to the top left of the canvas.
function getTouchPos(e) {
    if (!e)
        var e = event;

    if (e.touches) {
        if (e.touches.length === 1) { // Only deal with one finger
            var touch = e.touches[0]; // Get the information for finger #1
            touchX = touch.pageX - touch.target.offsetLeft;
            touchY = touch.pageY - touch.target.offsetTop;
        }
    }
}

function drawLine(canvasContext, x, y, size) {

    // If lastX is not set, set lastX and lastY to the current position
    if (lastX === -1) {
        lastX = x;
        lastY = y;
    }
    // RGB values set to 0 for black color, and 255 alpha (completely opaque)
    r = 0;
    g = 0;
    b = 0;
    a = 255;

    // Select a fill style
    canvasContext.strokeStyle = "rgba(" + r + "," + g + "," + b + "," + (a / 255) + ")";

    // Set the line "cap" style to round, so lines at different angles can join into each other
    canvasContext.lineCap = "round";

    // Draw a filled line
    canvasContext.beginPath();

    // First, move to the old (previous) position
    canvasContext.moveTo(lastX, lastY);

    // Now draw a line to the current touch/pointer position
    canvasContext.lineTo(x, y);

    // Set the line thickness and draw the line
    canvasContext.lineWidth = size;
    canvasContext.stroke();

    canvasContext.closePath();
    // Update the last position to reference the current position
    lastX = x;
    lastY = y;
}

// Clear the canvas context using the canvas width and height
function clearCanvas(canvas, canvasContext) {
    canvasContext.clearRect(0, 0, canvas.width, canvas.height);
}

// save Image
function saveImage(canvas, canvasContext) {
    var link = document.createElement('a');
    link.textContent = 'download image';
    link.href = canvas.toDataURL('image/png', 1.0);
    link.download = "1.png";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Clear the canvas context and redraw image
function redrawImage(canvas, canvasContext) {
    canvasContext.clearRect(0, 0, canvas.width, canvas.height);
    touchLines.forEach((function (line) {
        lastX = -1;
        lastY = -1;
        let scaleX = canvas.width / line.canvasWidth;
        let scaleY = canvas.height / line.canvasHeight;
        let touchPoints = line.points;
        touchPoints.forEach((function (p){
            drawLine(canvasContext, p.X * scaleX, p.Y * scaleY, 4);
        }));
    }));
}

function saveResizeAndRedisplay() {
    if(canvas != null && canvasContext !=null)
        redrawImage(canvas, canvasContext);
    // console.log("here");
    // // save the canvas content as imageURL
    // var data = canvas.toDataURL();
    // console.log(data);
    // // resize the canvas
    // //get canvas element
    // canvas = document.getElementById('sketchpad');
    // //get 2d drawing context for the canvas
    // var rect = canvas.getBoundingClientRect();
    // canvas.width = rect.width;
    // canvas.height = rect.height;
    //
    // // scale and redraw the canvas content
    // var img = new Image();
    // img.onload = function () {
    //     canvasContext.drawImage(img, 0, 0, canvas.width, canvas.height);
    //     console.log("image width:" + img.width + "height : " + img.height);
    // }
    // img.src = data;
}

