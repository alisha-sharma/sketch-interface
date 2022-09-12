<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SketchPad Interface</title>

    <link rel="stylesheet" href="./css/sketchpad.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
            crossorigin="anonymous"></script>
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
    <div class="draw-button">
        <button type="button" id="button-start" class="btn btn-warning" data-toggle="modal" data-target="#userInfo">
            <span class="center">Start Drawing</span>
        </button>
    </div>

    <div class="mt-2 mb-4 alert alert-success fade show text-center d-none" id="flashMessage" role="alert">
        <strong>User Name successfully added.</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="mt-2 row col-md-6 offset-md-3 d-none" id="image-description">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Rectangle <img class="img-fluid" src="./img/rectangle.png" alt="rectangle" style="height:3rem">
                <span class="badge bg-primary rounded-pill"> <span id="rectangle">0</span> of 100 Done</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                 Line <img class="img-fluid" src="./img/line.png" alt="rectangle" style="height:3rem">
                <span class="badge bg-primary rounded-pill"> <span id="line">0</span> of 100 Done</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Inheritance <img class="img-fluid" src="./img/inheritance.png" alt="rectangle" style="height:3rem">
                <span class="badge bg-primary rounded-pill"> <span id="inheritance">0</span>  of 100 Done</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Composition <img class="img-fluid" src="./img/composition.png" alt="rectangle" style="height:3rem">
                <span class="badge bg-primary rounded-pill"> <span id="composition">0</span> of 100 Done</span>
            </li>
        </ul>
    </div>

    <div class="row" id="sketch">
        <div class="row d-none" id="instructions">
            <div class="col-md-6 offset-md-4">
                <div class="mt-4 alert alert-primary fade show text-center" role="alert" id="shape">

                </div>
            </div>
        </div>

        <div class="col-12 mt-4" id="sketchpad-interface">
            <canvas id="sketchpad"></canvas>
        </div>
        <!--    </div>-->
        <div class="row btn-section">
            <div class="mt-3 button">
                <div class="col-12 mb-3">
                    <label for="line-width">Line Width: </label>
                    <input id="line-width" type="number" value="4">
                </div>
                <div>
                    <button class="col-md-4 btn btn-outline-secondary mb-2" id="clearButton"
                            onclick="clearCanvas(canvas,canvasContext);"> Clear SketchPad
                    </button>
                    <button class="col-md-4 btn btn-outline-secondary mb-2" id="saveButton"
                            onclick="saveImage(canvas,canvasContext);"> Save Image
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="userInfo" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-name"> User Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                        <input type="hidden" name="_method" value="PUT">
                       <form class="form" id="userDetail" action="" method="post" accept-charset="UTF-8">
                            <div class="form-group mt-2">
                                <label class="control-label">Name *</label>
                                <div>
                                    <input type="text" class="form-control input-lg"
                                           name="name" id="name" required>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div>
                                    <button type="submit" class="btn btn-outline-success submit" name="submit">Submit</button>
                                </div>
                            </div>
                       </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id= "closeModal" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal End -->
</div>
<script>

</script>
</body>
</html>


