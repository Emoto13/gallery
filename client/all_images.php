<?php 
    require "header.php";
?>

<main class="container">
    <h1>All Images</h1>
    <div class="gallery">
    <?php
        include_once("display_all_images.php");
        display_all_images();
    ?>
    </div>
</main>

<?php 
    require "footer.php";
?>