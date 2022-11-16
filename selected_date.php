<!DOCTYPE html>
<html>
<head>
    <title> Image Upload/Download</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-3.6.1.js"></script>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "imageud";
    $conn = new mysqli($servername, $username, $password, $dbname);
    $date = $_REQUEST['date'];

    $img_size = 15;
    session_start();
    ?>

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <a href="<?php echo $_SERVER['HTTP_REFERER']?>" class="btn btn-outline-secondary rounded-0">Back</a>
    </div>
    <div class="row justify-content-center">

        <?php
        // Create connection
        $sql = "SELECT * FROM imagelist where upload_date = '" . $date . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<div class='text-center p-3' style='width: ".$img_size."rem;'>";
                echo '<div class="card" style="width: 100%;">';
                echo '<img src="Upload/'.$date.'/'.explode(".", $row['image_name'])[0]."_thumbs.".explode(".", $row['image_name'])[1].'" class="card-img-top" alt="..." style="height: '.($img_size/4*3).'rem;">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">'.$row['image_name'].'</h5>';
                echo '<p class="card-text mb-0">'.$date. " ". $row['upload_time'] .'</p>';
                echo '<p class="card-text">'.number_format($row['size'])."bytes".'</p>';
                echo '<div class="btn btn-primary" img_src = ./upload/'.$date."/".$row['image_name'].' onclick="image_download(this)"> Download </div > ';
                echo '</div > ';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "0 results";
        }

        ?>
    </div>
</div>
</body>

<script type="text/javascript">
    $(document).ready(function () {

    })
    function image_download(e) {
        // alert(e.getAttribute("img_src"));
        let newlink = document.createElement('a');
        newlink.setAttribute('href', '/imageud/download.php?img_src=' + e.getAttribute("img_src"));
        newlink.click();

        // $.ajax({
        //     type: "GET",
        //     url: "download.php?",
        //     data: {
        //         img_src:e.getAttribute("img_src"),
        //     },
        //     success: function (data) {
        //         alert(data);
        //     }
        // });
    }
</script>

<?php
$conn->close();
?>
</html>