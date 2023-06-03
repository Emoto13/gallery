<?php
    session_start();
    
    include_once("../config.php");
    require_once('upload_image.php');
    require_once('add_image_to_album.php');
    include_once("create_album_helper.php");
    
    $configs = new Config();

    $zipFile = $_FILES['zip'];
    $album_name = pathinfo($zipFile["name"], PATHINFO_FILENAME);
    $source = $zipFile["tmp_name"];
    $type = $zipFile["type"];
    $zipError = $zipFile["error"];

    if ($zipError !== 0) {
        echo "There was an error uploading your archive.";
        return;
    }

    $tempZip = $configs->IMAGE_DIR_PATH.$configs->TEMP_ZIP;
    if (!move_uploaded_file($source, $tempZip)) {
        echo "There was an error uploading your archive. 2";
        return;
    }

    $tempDir = $configs->IMAGE_DIR_PATH.$configs->TEMP_DIR;
    $conn = mysqli_connect($configs->SERVER_NAME, $configs->DB_USERNAME, $configs->DB_PASSWORD, $configs->DB_NAME);

    $zip = new ZipArchive();
    $zip->open($tempZip);
    $zip->extractTo($tempDir);
    
    $album_id = create_album($conn, $album_name, "Created from bulk upload", $_SESSION["user_id"]);
    for($i = 0; $i < $zip->numFiles; $i++ ){ 
        $name = $zip->getNameIndex($i); 
        if (str_contains($name, "MACOSX")) { // skip autogenerated files
            continue;
        }

        $fileTmpName = $tempDir.$name;
        $image_id = upload_image($conn, $name, $fileTmpName, true);
        add_image_to_album($conn, $image_id, $album_id, $album_name);
    }
    
    $zip->close();
    mysqli_close($conn);
    header('Location: ../client/albums.php?id='.$album_id.'&name='.$album_name);
?>