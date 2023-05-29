<?php
    function display_all_images($should_return_partial=false) {
        require "display_gallery.php";
        require "../server/dbhandler.php";

        if (!isset($_SESSION['user_id'])){
            echo "User should be logged to access this page";
            return;
        }

        $query = "SELECT * FROM images WHERE author_id=? ORDER BY timestamp DESC";
        if ($should_return_partial) {
            $query = "SELECT * FROM images WHERE author_id=? ORDER BY timestamp DESC LIMIT 9";
        }

        $statement = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($statement, $query)) {
            header("Location: index.php?error=sqlerror");
            echo $query;
            return;
        } 

        mysqli_stmt_bind_param($statement, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        display_gallery($result);
        mysqli_close($conn);
    }

?>