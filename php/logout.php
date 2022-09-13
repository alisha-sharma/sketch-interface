<?php
session_start();
if (isset($_SESSION['userName'])) {
    unset($_SESSION['userName']);
}
if (isset($_SESSION['target'])) {
    unset($_SESSION['target']);
}
session_destroy();

