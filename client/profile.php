<?php
    require "header.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="css/profile.css">
</head>
<body>
    <main class="container">
        <?php
        
        if (!isset($_SESSION['user_id'])) {
            echo "You should log in to view this page";
            return;
        }

        include_once("../config.php");
        $configs = new Config();
        $conn = mysqli_connect($configs->SERVER_NAME, $configs->DB_USERNAME, $configs->DB_PASSWORD, $configs->DB_NAME);
       
        // Fetch user info
        $query_basic_details = "SELECT * FROM users WHERE id=?";
        $statement_basic_details = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($statement_basic_details, $query_basic_details)) {
            header("Location: index.php?error=sqlerror");
            return;
        }

        mysqli_stmt_bind_param($statement_basic_details, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($statement_basic_details);
        $result_basic_details = mysqli_stmt_get_result($statement_basic_details)->fetch_assoc();
        
        echo '<h1 class="profile-header">My Profile</h1>';

        echo '<img src="images/profile_picture.png" class="profile-picture" alt="Picture">';
        
        echo '<div class="profile-details">';
        echo '<p> <b>Username: </b>'.$result_basic_details['username'].'</p>';
        echo '<p> <b>Email: </b>'.$result_basic_details['email'].'</p>';
        echo '<p> <b>Member since: </b>'.date('F d, Y', strtotime($result_basic_details['date_registered'])).'</p>';
        echo '<p> <b>Last login: </b>'.date('F d, Y h:mA', $_SESSION['start_time']).'</p>';


        // Fetch uploaded images info
        $query_images_count = "SELECT COUNT(id) FROM images WHERE author_id=?";
        $statement_images_count = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($statement_images_count, $query_images_count)) {
            header("Location: index.php?error=sqlerror");
            return;
        }


        mysqli_stmt_bind_param($statement_images_count, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($statement_images_count);
        $result_images_count = mysqli_stmt_get_result($statement_images_count)->fetch_array();
        echo '<p> <b>Total image count: </b>'.$result_images_count[0].'</p>';


        // Fetch uploaded albums info
        $query_albums_count = "SELECT COUNT(id) FROM albums WHERE user_id=?";
        $statement_albums_count = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($statement_albums_count, $query_albums_count)) {
            header("Location: index.php?error=sqlerror");
            return;
        }
        
        mysqli_stmt_bind_param($statement_albums_count, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($statement_albums_count);
        $result_albums_count = mysqli_stmt_get_result($statement_albums_count)->fetch_array();
        echo '<p> <b>Total album count: </b>'.$result_albums_count[0].'</p>';
        echo '</div>';

        mysqli_close($conn);
        ?>
    </main>
</body>
