<?php
    session_start();

    require_once('upload_image.php');
    require_once('add_image_to_album.php');

    include_once("../config.php");
    $configs = new Config();

    $conn = mysqli_connect($configs->SERVER_NAME, $configs->DB_USERNAME, $configs->DB_PASSWORD, $configs->DB_NAME);

    list($originalFilename, $fileTmpName) = validate_upload();
    $image_id = upload_image($conn, $originalFilename, $fileTmpName);
    
    $album_id = $_GET['id'];
    $album_name = $_GET['name'];
    add_image_to_album($conn, $image_id, $album_id, $album_name);
    header('Location: ../client/albums.php?id='.$album_id.'&name='.$album_name);

?>
