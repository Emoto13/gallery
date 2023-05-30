<?php 
    require "header.php";
?>

<main class="container">
    <h1>Collection</h1>
    <div class="gallery">
    <?php
        include_once("display_all_images.php");
        display_all_images();
    ?>
    </div>
</main>