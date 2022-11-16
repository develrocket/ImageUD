<?php
require "thumbimage.class.php";
session_start();

$message = '';

if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload Files') {
    $arrlength = count($_FILES['uploadedFiles']['name']);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "imageud";
    $conn = new mysqli($servername, $username, $password, $dbname);

    for ($i = 0; $i < $arrlength; $i++) {
        if (isset($_FILES['uploadedFiles']) && $_FILES['uploadedFiles']['error'][$i] === UPLOAD_ERR_OK) {
            // get details of the uploaded file
            $fileTmpPath = $_FILES['uploadedFiles']['tmp_name'][$i];
            $fileName = $_FILES['uploadedFiles']['name'][$i];
            $fileName = str_replace(' ', '', $fileName);
            $fileSize = $_FILES['uploadedFiles']['size'][$i];
            $fileType = $_FILES['uploadedFiles']['type'][$i];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $newFileName = $fileName;

            // check if file has one of the following extensions
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'bmp');

            if (in_array($fileExtension, $allowedfileExtensions)) {
                // directory in which the uploaded file will be moved
                $uploadFileDir = './upload/'.date("Y-m-d")."/";
                if (!file_exists($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }
                $dest_path = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $message = 'File is successfully uploaded.';

                    $sql = "INSERT INTO imagelist (image_name, upload_date, upload_time, size) value('".$fileName."','".date("Y-m-d")."','".date("H:i:s")."',".$fileSize.")";
                    $result = $conn->query($sql);

                    $sql = "select count from imagedate where upload_date = '".date("Y-m-d")."'";
                    $result = $conn->query($sql);
                    //file_put_contents("log.txt", print_r($result, 1));

                    // Get lower quality image file
                        $objThumbImage = new ThumbImage($dest_path);
                        $objThumbImage->createThumb($uploadFileDir.$fileNameCmps[0]."_thumbs.".$fileExtension, 125);
                        //$objThumbImage->createThumb("./upload/2022-11-15/background_thumbs.png", 125);

                    if($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $cnt = $row['count'];
                        $cnt ++;
                        $sql = "update imagedate set count = ".$cnt." where upload_date='".date("Y-m-d")."'";

                        $conn->query($sql);
                    }
                    else {
                        $sql = "insert into imagedate (upload_date, count) value ('".date("Y-m-d")."',1)";
                        $conn->query($sql);
                    }

                } else {
                    $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                }
            } else {
                $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
            }
        } else {
            $message = 'There is some error in the file upload. Please check the following error.<br>';
            $message .= 'Error:' . $_FILES['uploadedFile']['error'][$i];
        }
    }
    $conn->close();
}

$_SESSION['message'] = $message;
header("Location: index.php");