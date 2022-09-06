<?php
const UPLOAD_DIR = '../storage/';
function store()
{
    $img = $_POST['imgBase64'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    $fileName = UPLOAD_DIR . uniqid() . '.png';
    if (!file_exists(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0777, true);
    }
    $success = file_put_contents($fileName, $fileData);
    echo (bool)$success;
}
store();

