<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SketchPad Interface</title>

    <link rel="stylesheet" href="./css/sketchpad.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="./js/sketchpad-logic.js" type="text/javascript"></script>
</head>
<body>
<div class="container-fluid">
    <div class="h4 pb-2 mt-3 mb-4 text-danger border-bottom border-danger text-center">
        SketchPad Interface - Data Collection of UML class diagram components
    </div>
    <div class="ml-2 text-center">
        The sketchpad interface below is created using HTML5 Canvas and has both touchscreen and mouse support.
        You can draw UML class diagram elements like rectangles and arrows on the sketchpad and save them.
        The image data of the UML class diagram component will be used as training data for the sketch classifier.
    </div>
    <div class="row">
        <div class="col-11 mt-4" id="sketchpad-interface">
            <canvas id="sketchpad"> </canvas>
        </div>
        <!--    </div>-->
        <div class="row btn-section">
            <div class="mt-3 button">
                <div class="col-12 mb-3">
                    <label for="line-width">Line Width: </label>
                    <input id="line-width" type="number" value="4">
                </div>
                <div>
                    <button class="col-md-4 btn btn-outline-secondary mb-2" id="clearButton" onclick="clearCanvas(canvas,canvasContext);"> Clear SketchPad</button>
                    <button class="col-md-4 btn btn-outline-secondary mb-2" id="saveButton" onclick="saveImage(canvas,canvasContext);"> Save Image</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


