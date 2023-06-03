<?php
    include_once("get_album_images.php");
    include_once("../config.php");
    session_start();

    $album_id = $_GET['id'];
    $album_name = $_GET['name'];

    $result = get_album_images($album_id, $album_name);

    $images = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($images, $row["path"]);
    }


    $configs = new Config();
    $zip = new ZipArchive();
    $tmp_file = $configs->IMAGE_DIR_PATH.'myzip.zip';

    if (!$zip->open($tmp_file, ZipArchive::CREATE)) {
        echo "Failed to create zip";
    }

    foreach ($images as &$path) {
        $zip->addFile($configs->IMAGE_DIR_PATH.$path, $path);
    }
    $zip->close();

    header("Content-type: application/zip"); 
    header("Content-Disposition: attachment; filename=$album_name.zip");
    header("Content-length: " . filesize($tmp_file));
    header("Pragma: no-cache"); 
    header("Expires: 0"); 

    readfile($tmp_file);

?>