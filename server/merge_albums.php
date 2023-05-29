<?php
    require "../client/header.php";

    if (!isset($_SESSION['user_id'])){
        header("Location: ../client/albums.php?error=dateerror");
        return;
    }
    
    // TODO: could check if album with the given name exits

    // create album
    include_once("create_album_helper.php");
    include_once("../config.php");

    $configs = new Config();
    $conn = mysqli_connect($configs->SERVER_NAME, $configs->DB_USERNAME, $configs->DB_PASSWORD, $configs->DB_NAME);

    $album_id = create_album($conn, $_POST['album-name'], $_POST['description'], $_SESSION["user_id"]);
    if (!$album_id) {
        header("Location: ../client/index.php?error=albumnotcreated");
        return;
    }

    // get images to put in the new album
    $albums_to_merge = implode(',', $_POST['albums']);
    $album_images_query = "SELECT image_instance_id FROM album_images
    INNER JOIN albums ON albums.id=album_images.album_id
    WHERE albums.user_id=?
    AND albums.id IN ($albums_to_merge);";


    $album_images_stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($album_images_stmt, $album_images_query)) {
        header("Location: ../client/index.php?error=sqlerror");
        return;
    }

    mysqli_stmt_bind_param($album_images_stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($album_images_stmt);
    $images_to_insert = mysqli_stmt_get_result($album_images_stmt);
    

    // insert images from the merged album into the new one
    $insert_images_query = "INSERT INTO album_images (image_instance_id, album_id) VALUES (?, ?)";
    $insert_images_stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($insert_images_stmt, $insert_images_query);
    if (!mysqli_stmt_prepare($insert_images_stmt, $insert_images_query)) {
        header("Location: ../client/index.php?error=sqlerror");
        return;
    }

    $conn->autocommit(false);
    while ($entry = $images_to_insert->fetch_assoc()) {    
        mysqli_stmt_bind_param($insert_images_stmt, "ii", $entry['image_instance_id'], $album_id);
        mysqli_stmt_execute($insert_images_stmt);
    }

    mysqli_commit($conn);
    header("Location: ../client/albums.php");
    mysqli_close($conn);
?>