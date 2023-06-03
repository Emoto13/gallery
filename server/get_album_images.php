<?php
    function get_album_images($album_id = "", $album_name="") {
        require "../server/dbhandler.php";

        if (!isset($_SESSION['user_id'])){
            echo "User should be logged to access this page";
            return false;
        }

        $query = "SELECT images.path as path FROM images 
        JOIN album_images ON album_images.image_instance_id = images.id 
        WHERE images.author_id=?
        AND album_images.album_id=?;";

        $statement = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($statement, $query)) {
            header("Location: index.php?error=sqlerror");
            echo $query;
            return false;
        } 

        mysqli_stmt_bind_param($statement, "ii", $_SESSION['user_id'], $album_id);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        mysqli_close($conn);
        return $result;
    }

?>