<?php
session_start();

$user = $_POST['username'];
$pwd = $_POST['password'];
$pwd = md5($pwd);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "imageud";
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "select * from users where username='".$user."'and password='".$pwd."'";
echo $sql;
$result = $conn->query($sql);
if($result->num_rows == 1){
    echo "success";
    $_SESSION['auth'] = $user;
}
else{
    echo $user;
    echo $pwd;
}

header("Location: index.php");