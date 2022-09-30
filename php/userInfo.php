<?php
const UPLOAD_DIR = '../storage/';
session_start();
function storeUserName()
{
    $_SESSION['userName']=$_POST['name'];
    // $_SESSION['target']=$_POST['target'];
    $name = $_POST['name'];
    if ($name) {
        if (!file_exists(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0777, true);
        }
        $userSpecificFolder = UPLOAD_DIR . '/' . $name;
        if (!file_exists($userSpecificFolder)) {
            mkdir($userSpecificFolder, 0777, true);
        }
    }
}

storeUserName();
