<?php 
    require "header.php";
    require "../server/dbhandler.php";
?>
<script defer src="js/validate_album_creation.js"></script>
<main class="container">
    <div class="flex">
        <h1 id="albums-title" class="inline-flex">Albums</h1>
        <div class="inline-flex">
            <button onclick="openModal()" class="form-button" id="create-album-btn">Create album</button>
            <button onclick="openMergeModal()" class="form-button" id="merge-album-btn">Merge albums</button>
        </div>
    </div>
    <div class="modal" id="create-modal">
        <div class="modal-header">
            <div class="title">Create new album</div>
            <span class="close" id="basic-modal" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="album-creation-form" method="post" action="../server/create_album.php" enctype="multipart/form-data">
                <label for="album-name">Album name:</label><br>
                <input class="modal-form" name="album-name" required type="text"><br>
                <label for="description">Description:</label><br>
                <textarea class="modal-form" id="description" name="description" type="text"></textarea><br>
                <input class="form-button" type="submit" value="Create">
            </form>
        </div>
    </div>
    <div class="modal" id="merge-modal">
        <div class="modal-header">
            <div class="title">Merge existing albums</div>
            <span class="close" id="basic-modal" onclick="closeMergeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="album-creation-form" method="post" action="../server/merge_albums.php"
                enctype="multipart/form-data">
                <label for="albums">Choose albums to merge:</label><br>
                <select class="modal-form" name="albums[]" id="albums" multiple>
                    <?php
                        
                        $query = "SELECT * FROM albums WHERE user_id=?";
                        $statement = mysqli_stmt_init($conn);

                        if (!mysqli_stmt_prepare($statement, $query)) {
                            header("Location: index.php?error=sqlerror");
                            exit();
                        }
                        else {
                            mysqli_stmt_bind_param($statement, "i", $_SESSION['user_id']);
                            mysqli_stmt_execute($statement);
                            $result = mysqli_stmt_get_result($statement);
                            while($row = mysqli_fetch_assoc($result)){
                                echo '<option value='.$row['id'].'>'.$row['name'].'</option>';
                            }
                        }
                      ?>
                </select></br>
                <label for="album-name">Album name:</label><br>
                <input class="modal-form" name="album-name" required type="text"><br>
                <label for="description">Description:</label><br>
                <textarea class="modal-form" id="description" name="description" type="text"></textarea><br>
                <input class="form-button" id="merge-button" type="submit" value="Merge albums">
            </form>
        </div>
    </div>
    <div id="overlay"></div>

    <?php
    if (!isset($_SESSION['user_id'])){
        echo "No user logged";
        exit();
    }
    
    if (!isset($_GET['id']) || $_GET['id']=="" || $_GET['name']=="") {
        if (isset($_GET['error']) && $_GET['error']=="dateerror" ) {
            echo '<p id="album-date-error"> You have no images from the date range you have selected!</p>';
        }
        if (isset($_GET['error']) && $_GET['error']=="albumnameerror" ) {
             echo '<p id="album-date-error"> You already have an album with the same name!</p>';
        }
        if (isset($_GET['error']) && $_GET['error']=="albumnotcreated" ) {
            echo '<p id="album-date-error"> Couldn\'t create album at this time. Please try again later!</p>';
        }
        // List all albums with their names
        $query = "SELECT * FROM albums WHERE user_id=?";
        $statement = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($statement, $query)) {
            header("Location: index.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($statement, "i", $_SESSION['user_id']);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            echo '<div style="display: grid; grid-template-columns: 20% 20% 20% 20%; grid-gap: 7%;">';
            while($row = mysqli_fetch_assoc($result)){
                echo '<flex style="text-align: center;"><a class="album-name" href="?id='.$row['id'].'&name='.$row['name'].'"><img
                class="folder" src="./images/folder.jpg" /><p>'.$row['name'].'</p></a></flex> ';
            }
            echo '</div>';
        }
        return;
    }

        $query = "
            SELECT * FROM (
                SELECT album_images.image_instance_id, albums.user_id
                FROM albums
                INNER JOIN album_images on album_images.album_id=albums.id
                WHERE albums.user_id=? 
                AND albums.id=?
            ) as album_images
            INNER JOIN images on images.id=album_images.image_instance_id;
        ";
            
        //"SELECT * FROM  albums INNER JOIN images on images.author_id=albums.user_id WHERE images.author_id=? AND albums.id=?";
        $statement = mysqli_stmt_init($conn);


        if (!mysqli_stmt_prepare($statement, $query)) {
            header("Location: index.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($statement, "ii", $_SESSION['user_id'], $_GET['id']);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);

        $album_id = $_GET['id'];
        $album_name = $_GET['name'];
        echo '<div id="upload-modal">
                <div class="modal-header">
                    <div class="title">Upload new image to album</div>
                    <span class="close" id="basic-modal" onclick="closeUploadModal()">&times;</span>
                </div>
                <div class="modal-body">
                    <form action="../server/upload_to_album.php?id='.$album_id.'&name='.$album_name.'"
                    method="POST" enctype="multipart/form-data">
                        <input type="file" name="file" required style="margin:20px 0px;"/>
                        <div>
                            <button type="submit" name="submit" class="form-button">Upload</button>
                        </div>
                    </form>
                </div>
             </div>';
        echo '<img class="add" onclick="openUploadModal()" src="./images/add.png"><br>';
        require "display_gallery.php";
        display_gallery($result);

    ?>
</main>
