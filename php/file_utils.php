<?php

function countFilesPerCategory($category, $storageDir = null)
{
    $userName = $_SESSION['userName'];
    if ($storageDir == null) $storageDir = "./storage";
    return count(glob("{$storageDir}/{$userName}/{$category}/" . "*.png"));
}

function countFiles($storageDir = null)
{
    $count = 0;
    $count += countFilesPerCategory("rectangle", $storageDir);
    $count += countFilesPerCategory('reference', $storageDir);
    $count += countFilesPerCategory('inheritance', $storageDir);
    $count += countFilesPerCategory('composition', $storageDir);
    $count += countFilesPerCategory('attribute', $storageDir);
    return $count;
}
