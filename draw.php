<?php include("./php/header.php"); ?>
<?php include("./php/file_utils.php"); ?>
<script type="text/javascript">
    <?php
    session_start();
    if (!isset($_SESSION['userName'])) {
        header('Location:./index.php');
    }
    $target = 50;
    $name = $_SESSION['userName'];
    ?>

    let totalFiles = <?php echo countFiles() ?>;
    let counterMap = {};
    counterMap["rectangle"] = <?php echo countFilesPerCategory("rectangle") ?>;
    counterMap["reference"] = <?php echo countFilesPerCategory("reference") ?>;
    counterMap["inheritance"] = <?php echo countFilesPerCategory("inheritance") ?>;
    counterMap["composition"] = <?php echo countFilesPerCategory("composition") ?>;
    counterMap["attribute"] = <?php echo countFilesPerCategory("attribute") ?>;
    let target = '<?php echo $target ?>';

</script>
<script src="./js/sketchpad.js" type="text/javascript"></script>
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
    <div id="toastMessage">Reminder!! Drawing instruction has been changed.</div>
    <div class="row" id="sketch">
        <div class="row col-7 left-side " id="instructions">
            <div class="col-md-5 offset-md-2">
                <div class="mt-4 alert alert-primary fade show text-center" role="alert" id="shape">

                </div>
            </div>
            <div class="mt-2 col-md-4 offset-md-4">
                <button class="btn-sm btn-info d-none" id="reDraw"
                        onclick="redrawElement();"> Draw Again
                </button>
            </div>
        </div>

        <div class="row mt-4" style="display: flex">
            <div class="col-9 left-side" id="sketchpad-interface">
                <canvas id="sketchpad"></canvas>
                <div class="row btn-section">
                    <div class="mt-3 button">
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
            <br style="clear:both;"/>
            <div class="col-3 right-side" id="image-description" style="margin-right: 0rem !important">
                <ul class="list-group list-items">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Rectangle <img class="img-fluid" src="./img/square.png" alt="rectangle">
                        <span class="badge bg-primary rounded-pill"> <span
                                    id="rectangle"> <?php echo countFilesPerCategory('rectangle') ?> </span> / <?php echo $target ?> Done</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Reference <img class="img-responsive" src="./img/reference.svg" alt="reference">
                        <span class="badge bg-primary rounded-pill"> <span
                                    id="reference"> <?php echo countFilesPerCategory('reference') ?> </span> /  <?php echo $target ?> Done</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Inheritance <img class="img-fluid" src="./img/Inheritance.svg" alt="inheritance" style="">
                        <span class="badge bg-primary rounded-pill"> <span
                                    id="inheritance"> <?php echo countFilesPerCategory('inheritance') ?> </span>  / <?php echo $target ?> Done</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Composition <img class="img-fluid" src="./img/composition.svg" alt="composition" style="">
                        <span class="badge bg-primary rounded-pill"> <span
                                    id="composition"> <?php echo countFilesPerCategory('composition') ?> </span> / <?php echo $target ?> Done</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Attribute <i class="fa fa-plus"></i>
                        <span class="badge bg-primary rounded-pill"> <span
                                    id="attribute"> <?php echo countFilesPerCategory('attribute') ?> </span> / <?php echo $target ?> Done</span>
                    </li>
                </ul>
            </div>
        </div>
        <!--        <div class="row btn-section">-->
        <!--            <div class="mt-3 button">-->
        <!--                <div>-->
        <!--                    <button class="col-md-4 btn btn-outline-secondary mb-2" id="clearButton"-->
        <!--                            onclick="clearCanvas(canvas,canvasContext);"> Clear SketchPad-->
        <!--                    </button>-->
        <!--                    <button class="col-md-4 btn btn-outline-secondary mb-2" id="saveButton"-->
        <!--                            onclick="saveImage(canvas,canvasContext);"> Save Image-->
        <!--                    </button>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
    </div>
</div>
<?php include("./php/footer.php"); ?>




