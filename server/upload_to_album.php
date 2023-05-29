<?php
    session_start();

    require('upload_image.php');
    include_once("../config.php");
    $configs = new Config();

    $conn = mysqli_connect($configs->SERVER_NAME, $configs->DB_USERNAME, $configs->DB_PASSWORD, $configs->DB_NAME);
    $image_id = upload_image($conn);
    $query_add_image = "INSERT INTO album_images (image_instance_id, album_id) VALUES (?, ?)";
    $statement_add_image = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($statement_add_image, $query_add_image)) {
        header("Location: ../client/index.php?error=sqlerror");
        exit();

    }
    mysqli_stmt_bind_param($statement_add_image, "ii", $image_id, $_GET['id']);
    mysqli_stmt_execute($statement_add_image);

    $album_id = $_GET['id'];
    $album_name = $_GET['name'];

    header('Location: ../client/albums.php?id='.$album_id.'&name='.$album_name);
    mysqli_close($conn);
?>
