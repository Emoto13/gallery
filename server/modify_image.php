<?php
    include_once("../config.php");
    session_start();

    function update_image($conn=null) {
        if (!isset($_SESSION['user_id'])){
            echo "No logged user found";
            return -1;
        }    


        $update_query = "UPDATE images
        SET description=?
        WHERE id=? AND author_id=?";
        $update_statement = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($update_statement, $update_query)) {
            header("Location: ../client/index.php?error=sqlerror");
            return -1;
        }

        mysqli_stmt_bind_param($update_statement, "sii",  $_POST['description'], $_POST['image-id'], $_SESSION['user_id']);
        mysqli_stmt_execute($update_statement);
        return mysqli_insert_id($conn);
    }



    $configs = new Config();
    $conn = mysqli_connect($configs->SERVER_NAME, $configs->DB_USERNAME, $configs->DB_PASSWORD, $configs->DB_NAME);

    update_image($conn);
    header("Location: ../client/index.php?success=modified");
    mysqli_close($conn);
?>