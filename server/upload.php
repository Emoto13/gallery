<?php
    session_start();

    require_once('upload_image.php');
    include_once("../config.php");
    $configs = new Config();

    $conn = mysqli_connect($configs->SERVER_NAME, $configs->DB_USERNAME, $configs->DB_PASSWORD, $configs->DB_NAME);
    upload_image($conn);
    mysqli_close($conn);
   
    header("Location: ../client/index.php?success=uploaded");
?>