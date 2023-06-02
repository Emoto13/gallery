<?php
    function add_image_to_album($conn = NULL, $image_id = "", $album_id = "", $album_name = "") {
        $query_add_image = "INSERT INTO album_images (image_instance_id, album_id) VALUES (?, ?)";
        $statement_add_image = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($statement_add_image, $query_add_image)) {
            header("Location: ../client/index.php?error=sqlerror");
            return;
        }
        mysqli_stmt_bind_param($statement_add_image, "ii", $image_id, $album_id);
        mysqli_stmt_execute($statement_add_image);
    }
?>