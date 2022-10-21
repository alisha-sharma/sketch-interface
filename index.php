<?php include("./php/header.php"); ?>
<script type="text/javascript">
    <?php
    session_start();
    if (isset($_SESSION['userName'])) {
        header('Location: ./draw.php');
    }
    ?>
</script>
<body>
<div class="flex-wrapper">
    <div class="container-fluid">
        <div class="h4 pb-2 mt-3 mb-4 text-danger border-bottom border-danger text-center">
            SketchPad Interface - Data Collection of UML class diagram components
        </div>
        <div class="ml-2 text-center">
            The sketchpad interface is drawn using HTML5 Canvas and has both touchscreen and mouse support.
            You can draw UML class diagram elements like rectangles and arrows on the sketchpad and save them.
            The image data of the UML class diagram component will be used as training data for the sketch classifier.
        </div>
        <div class="draw-button">
            <button type="button" id="button-start" class="btn btn-warning" data-toggle="modal" data-target="#userInfo">
                <span class="center">Start Drawing</span>
            </button>
        </div>

        <div class="mt-2 mb-4 alert alert-success fade show text-center d-none" id="flashMessage" role="alert">
            <strong>Login success.</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
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
                                <label class="control-label">Name * (only alphabets, numbers and underscore are allowed) </label>
                                <div>
                                    <input type="text" class="form-control input-lg"
                                           name="name" id="name" pattern="[a-zA-Z0-9_]*" required>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div>
                                    <button type="submit" class="btn btn-outline-success submit" name="submit">Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="closeModal" data-dismiss="modal">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include("./php/footer.php"); ?>
</div>
</body>
<!--Modal End -->



