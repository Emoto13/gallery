<?php 
    require "header.php";
?>

<main class="container">
    <h1>Collection</h1>
    <div class="gallery">
    <?php
        include_once("get_images.php");
        include_once("display_gallery.php");
        
        $images = get_images(false);
        display_gallery($images);
    ?>
    </div>
</main>