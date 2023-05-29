<?php
    if (!isset($_POST['register-submit'])){
        header("Location: ../client/register.php");
        return;
    }

    require 'dbhandler.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password-cnf'];

    if (empty($username) || empty($email) || empty($password) || empty($passwordConfirm)){
        header("Location: ../client/register.php?error=emptyfields&username=".$username."&email=".$email);
        return;
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../client/register.php?error=invalidemail&username=".$username);
        return;
    }
    else if ($password !== $passwordConfirm) {
        header("Location: ../client/register.php?error=passwordcheck&email=".$email."&username=".$username);
        return;
    }
        $sqlUsername = "SELECT username FROM users WHERE username=?";
        $statement = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($statement, $sqlUsername)) {
            header("Location: ../client/register.php?error=sqlerror");
            return;
        } 
        mysqli_stmt_bind_param($statement, "s", $username);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);
        $resultCheck = mysqli_stmt_num_rows($statement);

        if ($resultCheck > 0) {
            header("Location: ../client/register.php?error=usertaken");
            return;
        }
        
        # Check if user with such email already exists
        $sqlEmail = "SELECT email FROM users WHERE email=?";
        $emailStatement = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($emailStatement, $sqlEmail)) {
            header("Location: ../client/register.php?error=sqlerror");
            return;
        } 
        mysqli_stmt_bind_param($emailStatement, "s", $email);
        mysqli_stmt_execute($emailStatement);
        mysqli_stmt_store_result($emailStatement);
        $resultCheckEmail = mysqli_stmt_num_rows($emailStatement);
        
        if ($resultCheckEmail > 0) {
            header("Location: ../client/register.php?error=emailtaken&username=".$username);
            return;
        }
        
        # Otherwise create new record in the DB
        $sqlInsert = "INSERT INTO users (username, email, password, date_registered) VALUES (?, ?, ?, ?)";
        $insertStatement = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($insertStatement, $sqlInsert)) {
            header("Location: ../client/register.php?error=sqlerror");
            exit();
        } 
            # Everything went well. Creating the user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $date_registered = date("Y-m-d");

        mysqli_stmt_bind_param($insertStatement, "ssss", $username, $email, $hashedPassword, $date_registered);
        mysqli_stmt_execute($insertStatement);
        mysqli_stmt_store_result($insertStatement);
        header("Location: ../client/index.php?success=register");

        mysqli_stmt_close($statement);
        mysqli_stmt_close($emailStatement);
        mysqli_stmt_close($insertStatement);

        mysqli_close($conn);
?>