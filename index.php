<!DOCTYPE html>
<html>
<head>
    <title> Image Upload/Download</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <script type="text/javascript" src="assets/js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="assets/js/jquery-3.6.1.js"></script>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "imageud";
    $conn = new mysqli($servername, $username, $password, $dbname);

    session_start();
//    $_SESSION['auth'] = 'root';
    ?>
</head>

<style>
    .folder-card .img-open {
        display: none;
    }

    .folder-card:hover .img-open {
        display: block;
    }

    .folder-card:hover .img-close {
        display: none;
    }

    .footer{
        height: 50px;
    }

    .content-body{
        min-height: calc(100vh - 106px);
    }
</style>

<body>
<nav class="navbar navbar-expand bg-primary">
    <div class="container-fluid">
        <div>
            <a class="navbar-brand text-light">Image Upload/Download</a>
        </div>
        <form action="login.php" method="POST">
            <div class="navbar-nav">
                <a class="nav-link active text-light" aria-current="page" href="#">Home</a>
                <a class="nav-link text-light disabled" href="#">Features</a>

                <?php
                if (!isset($_SESSION['auth'])) {
                    echo '
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">LogIn</button>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">LogIn Dialog</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">UserName:</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Password:</label>
                                        <input type="password" class="form-control" name="password"></input>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">LogIn</button>
                            </div>
                        </div>
                    </div>
                </div>
                        ';
                } else {
                    echo '

                        <div class="nav-link dropdown">
                            <div class="text-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Welcome <b>' . $_SESSION['auth'] . '</b>
                            </div>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item">
                                    <a href="logout.php" class="text-decoration-none">Log Out</a>
                                </li>
                            </ul>
                        </div>';
                    }
                ?>

            </div>
        </form>
    </div>
</nav>

<div class="container-fluid content-body">
    <?php
    if (isset($_SESSION['message']) && $_SESSION['message']) {
        printf('<b>%s</b>', $_SESSION['message']);
        unset($_SESSION['message']);
    }
    ?>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <div class="row justify-content-center pt-3">
            <div class="mb-3 col-md-8">
                <input class="form-control" type="file" name="uploadedFiles[]" multiple>
            </div>
            <div class="col-md-2">
                <input type="submit" class="btn btn-outline-primary" name="uploadBtn" style="width: 100%"
                       value="Upload Files"/>
            </div>
        </div>
    </form>
    <div class="row justify-content-center">
        <?php
        // Create connection
        $sql = "SELECT * FROM imagedate";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {

                echo '<a class="card border-0 col-md-2 text-center folder-card m-2" href="selected_date.php?date=' . $row['upload_date'] . '">
                      <img src="assets/close_folder.png" class="card-img img-close" alt="...">
                      <img src="assets/open_folder.png" class="card-img img-open" alt="...">
                      <div class="card-img-overlay d-flex justify-content-center align-items-center flex-column">
                        <h5 class="card-title">Upload Date: ' . $row["upload_date"] . '</h5>
                        <p class="card-text">Count: ' . $row["count"] . '</p>
                      </div>
                    </a>';
            }
        } else {
            echo "0 results";
        }

        ?>
    </div>
</div>

<div class="bg-primary footer text-center text-light d-flex justify-content-center align-items-center">
    <h6 class="mb-0">Copyright © Image Upload/Download</h6>
</div>

</body>

<script type="text/javascript">
    $(document).ready(function () {
        // $(".btn-folder").click(function () {
        //     console.log($(this).attr("date"));
        // });
    });

    function selected_date_view(e) {
        $(e).attr("date");
    }
</script>

<?php
$conn->close();
?>
</html>