<?php 

    function does_album_exist($conn) {
        $query_check_album_name = "SELECT * FROM albums WHERE name=? AND user_id=?";
        $statement_check_album_name = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($statement_check_album_name, $query_check_album_name)) {
            header("Location: ../client/index.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($statement_check_album_name, "si", $_POST['album-name'], $_SESSION['user_id']);
        mysqli_stmt_execute($statement_check_album_name);
        $result_albums = mysqli_stmt_get_result($statement_check_album_name);
        $number_of_albums = mysqli_num_rows($result_albums);
        return $number_of_albums > 0;
    }
 
    function create_album($conn, $album_name = "", $album_description = "", $user_id = "") {
        if ($album_name === "" || $album_name === NULL) {
            header("Location: ../client/albums.php?error=albumnameerror");
            return;
        } else if ($album_description === "" || $album_description === NULL) {
            header("Location: ../client/albums.php?error=albumnameerror");
            return;
        } else if ($user_id === "" || $user_id === NULL) {
            header("Location: ../client/albums.php?error=albumnameerror");
            return;
        }
         
        require "../client/header.php";
        if (does_album_exist($conn)) {
            header("Location: ../client/albums.php?error=albumnameerror");
            return;
        }
    
        $insert_album_query = "INSERT INTO albums (name, description, user_id) VALUES (?, ?, ?)";
        $insert_album_statement = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($insert_album_statement, $insert_album_query)) {
            header("Location: ../client/index.php?error=sqlerror");
            return;
        }
    
        mysqli_stmt_bind_param($insert_album_statement, "ssi", $album_name, $album_description, $user_id);
        mysqli_stmt_execute($insert_album_statement);
        return mysqli_insert_id($conn);
    }

?>