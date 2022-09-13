<?php
const UPLOAD_DIR = '../storage/';
function store()
{
    session_start();
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
        if ($success !== false) echo true;
        else echo false;
    } else echo false;
}

store();

