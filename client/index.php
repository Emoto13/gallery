<?php 
    require "header.php";
?>

<?php
    include_once("display_all_images.php");

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

    echo '<main class="container">';
    if (!isset($_SESSION['userId'])) {
        echo '<h1>Welcome to Image Gallery!</h1>
            <p>Please log into your profile or register to be able to upload pictures and generate galleries!</p>';
        return;
    }

    echo '<h1>Welcome to your own Image Gallery!</h1>
        <p>You can now upload new images or view your existing ones. :)</p>';
    echo '<form action="../server/upload.php" method="POST" enctype="multipart/form-data">
              <input type="file" name="file" required style="margin:20px 0px;"/>
              <div>
                  <button type="submit" name="submit" class="form-button">Upload your image</button>
                </div>
              </form>';
    echo '<hr />';
    echo '<h3>Upload awesome images like these:</h3>';  
    display_all_images(true);
    echo '</main>';
?>