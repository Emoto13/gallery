<?php 
    require "header.php";
?>

<?php
    include_once("get_images.php");
    include_once("display_gallery.php");


    if (isset($_GET['success'])) {
        if ($_GET['success'] == 'register') {
            echo '<div class="success-msg">You have successfully created your profile. Please login.</div>';
        } else if ($_GET['success'] == 'uploaded') {
            echo '<div class="success-msg">You have successfully uploaded your image.</div>';
        } else if ($_GET['success'] == 'modified') {
            echo '<div class="success-msg">You have successfully modified your image.</div>';
        } else if ($_GET['success'] == 'deleted') {
            echo '<div class="success-msg">You have successfully deleted your image.</div>';
        }
    }

    if (!isset($_SESSION['user_id'])) {
        echo '<main class="index-container">';
        echo '<h1 class="center">Welcome to Web Gallery!</h1>
            <p class="center">Please log into your profile or register to be able to upload pictures and create collections!</p>
            <img src="images/index.jpg" class="index-img" alt="Index photo" />
            <img src="images/index-phone.png" class="index-img" alt="Index phone photo" />
            ';
        return;
    }

    echo '<main class="container">';
    echo '<h1 class="center">Welcome to Web Gallery!</h1>';
    echo '<p>You can upload image here.</p>';
    echo '<form action="../server/upload.php" method="POST" enctype="multipart/form-data">
              <input type="file" name="file" required style="margin:20px 0px;"/>
              <div>
                  <button type="submit" name="submit" class="form-button">Upload</button>
                </div>
              </form>';

    $images = get_images(true);
    if ($images && $images->num_rows !== 0) {
        echo '<hr />';
        echo '<h3>Upload awesome images like these:</h3>';  
        display_gallery($images);
    }
    echo '</main>';
?>