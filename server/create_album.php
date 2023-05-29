
<?php    
    session_start();   
    if (!isset($_SESSION['user_id'])){
        echo "No logged user found";
        return;
    }    


    include_once("create_album_helper.php");
    include_once("../config.php");

    $configs = new Config();
    $conn = mysqli_connect($configs->SERVER_NAME, $configs->DB_USERNAME, $configs->DB_PASSWORD, $configs->DB_NAME);

    $result = create_album($conn, $_POST['album-name'], $_POST['description'], $_SESSION["user_id"]);
    if (!$result) {
        header("Location: ../client/index.php?error=albumnotcreated");
        return;
    }

    header("Location: ../client/albums.php");
    mysqli_close($conn);
?>