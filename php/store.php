<?php
include("./file_utils.php");
const UPLOAD_DIR = '../storage/';
session_start();
function storeImage()
{
    $img = $_POST['imgBase64'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    $shape = $_POST['shape'];

    if (isset($_SESSION['userName']) && !empty($_SESSION['userName'])) {
        $userSpecificFolder = UPLOAD_DIR . $_SESSION['userName'] . '/' . $shape;
        if (!file_exists($userSpecificFolder)) {
            mkdir($userSpecificFolder, 0777, true);
        }
        $fileName = uniqid() . '.png';
        $filePath = $userSpecificFolder . "/" . $fileName;
        $success = file_put_contents($filePath, $fileData);
        if ($success !== false) sendResult(true);
        else sendResult(false);
    } else sendResult(false);
}

function sendResult($success){
    echo json_encode(["success"=> $success, "count" => countFiles("../storage")]);
}

function storePixels()
{
    $filePath = UPLOAD_DIR . $_SESSION['userName'] . '/' . $_SESSION['userName'] . '_data.txt';
    $file = fopen($filePath, "a") or die("Unable to open file!");
    $touchlines = $_POST['touchlines'];
    if (count($touchlines) == 0) return;
    $touchlines[0]["shape"] = $_POST['shape'];
    $content = json_encode(array('touchline' => $touchlines));
    fwrite($file, $content . "\n");
    fclose($file);
}

storeImage();
storePixels();

