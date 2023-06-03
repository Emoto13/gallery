<?php
    function validate_upload($conn = NULL, $originalFilename = "", $fileTmpName = "") {
        if (!isset($_POST['submit'])){
            header("Location: ../client/index.php?error=sqlerror3");
            return false;
        }
    
        $file = $_FILES['file'];
        $originalFilename = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileError = $file['error'];
    
        if ($fileError !== 0) {
            echo "There was an error uploading your file.";
            return false;
        }
        return array($originalFilename, $fileTmpName);
    }

    function upload_image($conn = NULL, $originalFilename = "", $fileTmpName = "", $exists_on_server = false) {
        require_once('uuid.php');
        include_once("../config.php");
        $configs = new Config();
 
        $path = pathinfo($originalFilename);
	    $filename = $path['filename'];
	    $ext = $path['extension'];

        $uniqueFilename = uuid();

        $path_filename = $uniqueFilename.".".$ext;
        $full_path = $configs->IMAGE_DIR_PATH.$path_filename;
        if ($exists_on_server) {
            rename($fileTmpName, $full_path);
        } else {
            move_uploaded_file($fileTmpName, $full_path);
        }

        // Parse the meta and exif data from image
        $exif = exif_read_data($full_path);
        if (isset($meta['description'])) {
            $description = $meta['description'];
        } else {
            $description = '';
        }

        if (isset($meta['address'])) {
             $address = $meta['address'];
        } else {
             $address = '';
        }

        $sqlInsertImage = "INSERT INTO images (path, author_id, description, address) 
                           VALUES (?, ?, ?, ?)";

        $imageInsertStatement = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($imageInsertStatement, $sqlInsertImage)) {
            header("Location: ../client/index.php?error=sqlerror3");
            return;
        }

        // Insert image
        mysqli_stmt_bind_param(
             $imageInsertStatement, 
             "siss", 
             $path_filename, 
             $_SESSION['user_id'],
             $description,
             $address
        );

        // Store result
        mysqli_stmt_execute($imageInsertStatement);
        
        mysqli_stmt_store_result($imageInsertStatement);
        return mysqli_insert_id($conn);
    }
?>