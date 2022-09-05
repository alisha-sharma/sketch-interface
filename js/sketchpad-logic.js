let canvas, canvasContext; //letiables to reference canvas and canvas context
let mouseX, mouseY, mouseDown = 0; //letiables to keep track of mouse positions
let touchX, touchY = 0; //letiables to keep track of the touch positions
let offsetX, offsetY; //letiables holding current canvas offset position
let size = 4;
let points = [];
let touchLines = [];
const OUT_SIZE = 256;
const PADDING = 8;

$("document").ready(function () {

    $("#line-width").bind('keyup mouseup', function () {
        size = $(this).val();
    });
    $(window).resize(saveResizeAndRedisplay);
    //get canvas element
    canvas = document.getElementById('sketchpad');
    //get 2d drawing context for the canvas
    let rect = canvas.getBoundingClientRect();
    canvas.width = rect.width;
    canvas.height = rect.height;
    if (canvas.getContext)
        canvasContext = canvas.getContext('2d');
    //check valid context and add event listener
    if (canvasContext) {
        canvasContext.fillStyle = "white";
        canvasContext.fillRect(0, 0, canvas.width, canvas.height);
        canvasContext.webkitImageSmoothingEnabled = false;
        canvasContext.mozImageSmoothingEnabled = false;
        canvasContext.imageSmoothingEnabled = false;

        //add event listener for mouse events
        canvas.addEventListener('mousedown', sketchpad_mouseDown, false);
        canvas.addEventListener('mousemove', sketchpad_mouseMove, false);
        canvas.addEventListener('mouseup', sketchpad_mouseUp, false);

        // add event listener for touch events
        canvas.addEventListener('touchstart', sketchpad_touchStart, false);
        canvas.addEventListener('touchmove', sketchpad_touchMove, false);
        canvas.addEventListener('touchend', sketchpad_touchEnd, false);
    }
});

// Keep track of the mouse button being pressed and draw a dot at current location
function sketchpad_mouseDown() {
    mouseDown = 1;
    // Draw a filled line
    canvasContext.beginPath();
    // move to current mouse position
    canvasContext.moveTo(mouseX, mouseY);

    let touchPoint = {};
    touchPoint.X = mouseX;
    touchPoint.Y = mouseY;
    points.push(touchPoint);

    drawLine(canvasContext, mouseX, mouseY);
}

// Keep track of the mouse position and draw a dot if mouse button is currently pressed
function sketchpad_mouseMove(e) {
    // Update the mouse co-ordinates when moved
    getMousePos(e);

    // Draw a dot if the mouse button is currently being pressed
    if (mouseDown === 1) {
        let touchPoint = {};
        touchPoint.X = mouseX;
        touchPoint.Y = mouseY;
        points.push(touchPoint);
        drawLine(canvasContext, mouseX, mouseY);
    }
}

// Keep track of the mouse button being released
function sketchpad_mouseUp() {
    mouseDown = 0;
    // close path when mouse is released
    canvasContext.closePath();

    let touchLine = {};
    touchLine.points = points;
    touchLine.canvasWidth = canvas.width;
    touchLine.canvasHeight = canvas.height;
    touchLines.push(touchLine);
    // reset current line points
    points = [];
}

// Get the current mouse position relative to the top-left of the canvas
function getMousePos(e) {
    if (!e) return;

    if (e.offsetX) {
        mouseX = e.offsetX * canvas.width / canvas.clientWidth | 0;
        mouseY = e.offsetY * canvas.height / canvas.clientHeight | 0;
    } else if (e.layerX) {
        mouseX = e.layerX;
        mouseY = e.layerY;
    }
}

// Draw something when a touch start is detected
function sketchpad_touchStart() {
    // Update the touch co-ordinates
    getTouchPos();

    // Draw a filled line
    canvasContext.beginPath();
    // move to current mouse position
    canvasContext.moveTo(mouseX, mouseY);

    let touchPoint = {};
    touchPoint.X = touchX;
    touchPoint.Y = touchY;
    points.push(touchPoint);

    drawLine(canvasContext, touchX, touchY);

    // Prevents an additional mousedown event being triggered
    event.preventDefault();
}

function sketchpad_touchEnd() {
    // Reset lastX and lastY to -1 to indicate that they are now invalid, since we have lifted the "pen"
    // lastX = -1;
    // lastY = -1;
    canvasContext.closePath();

    let touchLine = {};
    touchLine.points = points;
    touchLine.canvasWidth = canvas.width;
    touchLine.canvasHeight = canvas.height;
    touchLines.push(touchLine);
    // reset current line points
    points = [];
}

// Draw something and prevent the default scrolling when touch movement is detected
function sketchpad_touchMove(e) {
    // Update the touch co-ordinates
    getTouchPos(e);

    let touchPoint = {};
    touchPoint.X = touchX;
    touchPoint.Y = touchY;
    points.push(touchPoint);
    // During a touchmove event, unlike a mousemove event, we don't need to check if the touch is engaged, since there will always be contact with the screen by definition.
    drawLine(canvasContext, touchX, touchY);

    // Prevent a scrolling action as a result of this touchmove triggering.
    event.preventDefault();
}

// Get the touch position relative to the top-left of the canvas
// When we get the raw values of pageX and pageY below, they take into account the scrolling on the page
// but not the position relative to our target div. We'll adjust them using "target.offsetLeft" and
// "target.offsetTop" to get the correct values in relation to the top left of the canvas.
function getTouchPos(e) {
    if (!e)
        e = event;

    if (e.touches) {
        if (e.touches.length === 1) { // Only deal with one finger
            let touch = e.touches[0]; // Get the information for finger #1
            touchX = touch.pageX - touch.target.offsetLeft;
            touchY = touch.pageY - touch.target.offsetTop;
        }
    }
}

function drawLine(canvasContext, x, y) {

    let alpha = 255;
    // set rgb values to 0 for black color
    canvasContext.strokeStyle = "rgba(" + 0 + "," + 0 + "," + 0 + "," + (alpha / 255) + ")";

    // Set the line "cap" style to round, so lines at different angles can join into each other
    canvasContext.lineCap = "round";

    // Now draw a line to the current touch/pointer position
    canvasContext.lineTo(x, y);

    // Set the line thickness and draw the line
    canvasContext.lineWidth = size;
    canvasContext.stroke();
}

// Clear the canvas context using the canvas width and height
function clearCanvas(canvas, canvasContext) {
    canvasContext.fillRect(0, 0, canvas.width, canvas.height);

    // reset line points and all drawn lines in the canvas
    points = [];
    touchLines = [];
}

// save Image
function saveImage(canvas, canvasContext) {
    const setX = new Set();
    const setY = new Set();
    touchLines.forEach((function (line, i) {
        if (line.points.length === 0) return;
        let touchPoints = line.points;
        touchPoints.forEach((function (p) {
            setX.add(p.X);
            setY.add(p.Y);
        }));
    }));

    const minX = Math.min(...setX);
    const minY = Math.min(...setY);
    const maxX = Math.max(...setX);
    const maxY = Math.max(...setY);

    const imgWidth = maxX - minX;
    const imgHeight = maxY - minY;
    let imageData = canvasContext.getImageData(minX, minY, imgWidth, imgHeight);

    let myCanvas = document.createElement('canvas');
    myCanvas.width = OUT_SIZE;
    myCanvas.height = OUT_SIZE;

    let myContext = myCanvas.getContext("2d");
    myContext.fillStyle = "white";
    myContext.fillRect(0, 0, OUT_SIZE, OUT_SIZE);

    //maintaining aspect ratio
    let wrh = imgWidth / imgHeight;
    let newWidth = myCanvas.width;
    let newHeight = newWidth / wrh;

    if (newHeight > myCanvas.height) {
        newHeight = myCanvas.height;
        newWidth = newHeight * wrh;
    }

    let xOffset = newWidth < myCanvas.width ? ((myCanvas.width - newWidth) / 2) : 0;
    let yOffset = newHeight < myCanvas.height ? ((myCanvas.height - newHeight) / 2) : 0;

    let img = imagedata_to_image(imageData);
    img.onload = function () {
        // drawImage the img on the canvas
        myContext.drawImage(img, xOffset + PADDING, yOffset + PADDING, newWidth - PADDING * 2, newHeight - PADDING * 2);
        let link = document.createElement('a');
        link.textContent = 'download image';
        link.href = myCanvas.toDataURL('image/png', 1.0);
        link.download = "1.png";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

function imagedata_to_image(imagedata) {
    let canvas = document.createElement('canvas');
    let ctx = canvas.getContext('2d');
    canvas.width = imagedata.width;
    canvas.height = imagedata.height;
    ctx.putImageData(imagedata, 0, 0);

    let image = new Image();
    image.src = canvas.toDataURL();
    return image;
}

// Clear the canvas context and redraw image
function redrawImage(canvas, canvasContext) {
    //clear canvas first
    canvasContext.fillRect(0, 0, canvas.width, canvas.height);

    touchLines.forEach((function (line) {
        if (line.points.length === 0) return;
        let firstPoint = line.points[0];
        canvasContext.beginPath();
        // first move to initial point
        canvasContext.moveTo(firstPoint.X, firstPoint.Y);
        let scaleX = canvas.width / line.canvasWidth;
        let scaleY = canvas.height / line.canvasHeight;
        let touchPoints = line.points;
        touchPoints.forEach((function (p) {
            drawLine(canvasContext, p.X * scaleX, p.Y * scaleY);
        }));

        canvasContext.closePath();
    }));
}

// function to recalculate the canvas offsets
function reOffset() {
    let bounds = canvas.getBoundingClientRect();
    offsetX = bounds.left;
    offsetY = bounds.top;
}

function saveResizeAndRedisplay() {
    reOffset();
    if (canvas != null && canvasContext != null)
        redrawImage(canvas, canvasContext);
}



