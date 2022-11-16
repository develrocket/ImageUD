<?php
session_start();

$url = $_GET['img_src'];

// Use basename() function to return the base name of file

if(!isset($_SESSION['auth'])) {
    header("Location: index.php");
}
$file_name = basename($url);

if(!file_exists($url)){ // file does not exist
    die('file not found');
} else {
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$file_name");
//    header("Content-Type: image/jpeg");
    header("Content-Transfer-Encoding: binary");

    // read the file from disk
    readfile($url);
}
