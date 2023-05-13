<?php
    // TO BE DEPRECATED. DON'T USE.

    include_once("../config.php");
    $configs = new Config();

    # create connection
    $conn = mysqli_connect($configs->SERVER_NAME, $configs->DB_USERNAME, $configs->DB_PASSWORD, $configs->DB_NAME);

    if(!$conn){
        die("Connection failed: ".mysqli_connect_error());
    }

?>