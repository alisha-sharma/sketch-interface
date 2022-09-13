<?php include("./php/header.php"); ?>
<script type="text/javascript">
    <?php
    session_start();
    if (!isset($_SESSION['userName']) && !isset($_SESSION['target'])) {
        header('Location:../index.php');
    }
    $target = $_SESSION['target'];
    $name = $_SESSION['userName'];
    ?>
    let target = '<?php echo $target ?>';
</script>
<script src="../js/sketchpad.js" type="text/javascript"></script>
<div class="container-fluid">
    <div class="h4 pb-2 mt-4 mb-4 text-danger border-bottom border-danger text-center">
        SketchPad Interface - Data Collection of UML class diagram components
        <div class="login-text mb-2">
            Logged in as: <?php echo $name ?>
            <button type="button" class="btn-sm btn-info" id="logoutButton">Logout</button>
        </div>
    </div>
    <div class="ml-2 mb-2 text-center">
        The sketchpad interface is drawn using HTML5 Canvas and has both touchscreen and mouse support.
        You can draw UML class diagram elements like rectangles and arrows on the sketchpad and save them.
        The image data of the UML class diagram component will be used as training data for the sketch classifier.
    </div>
    <div class="mt-2 row col-md-6 offset-md-3" id="image-description">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Rectangle <img class="img-fluid" src="./img/rectangle.png" alt="rectangle" style="height:3rem">
                <span class="badge bg-primary rounded-pill"> <span id="rectangle">0</span> of <?php echo $target ?> Done</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Line <img class="img-fluid" src="./img/line.png" alt="rectangle" style="height:3rem">
                <span class="badge bg-primary rounded-pill"> <span
                            id="line">0</span> of <?php echo $target ?> Done</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Inheritance <img class="img-fluid" src="./img/inheritance.png" alt="rectangle" style="height:3rem">
                <span class="badge bg-primary rounded-pill"> <span id="inheritance">0</span>  of <?php echo $target ?> Done</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Composition <img class="img-fluid" src="./img/composition.png" alt="rectangle" style="height:3rem">
                <span class="badge bg-primary rounded-pill"> <span id="composition">0</span> of <?php echo $target ?> Done</span>
            </li>
        </ul>
    </div>

    <div class="row" id="sketch">
        <div class="row " id="instructions">
            <div class="col-md-6 offset-md-4">
                <div class="mt-4 alert alert-primary fade show text-center" role="alert" id="shape">

                </div>
            </div>
            <div class="mt-2 col-md-4 offset-md-6">
                <button class="btn-sm btn-info mb-2 d-none" id="reDraw"
                        onclick="redrawElement();"> Draw Again
                </button>
            </div>
        </div>

        <div class="col-12 mt-4" id="sketchpad-interface">
            <canvas id="sketchpad"></canvas>
        </div>

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
</div>
<?php include("./php/footer.php"); ?>




