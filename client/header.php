<?php
    date_default_timezone_set('Europe/Sofia');
    session_start();
    if (!isset($_SESSION['start_time']))
    {
        $str_time = time();
        $_SESSION['start_time'] = $str_time;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title>Image gallery</title>
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <link rel="stylesheet" type="text/css" href="css/modals.css">
    <link rel="stylesheet" type="text/css" href="css/gallery.css">
    <link rel="stylesheet" type="text/css" href="css/other.css">
    <script type="text/javascript">
    const loadMessagesCss = () => {
        let newStyleSheet = document.createElement('link');
        newStyleSheet.rel = 'stylesheet';
        newStyleSheet.href = 'css/messages.css';
        document.getElementsByTagName("head")[0].appendChild(newStyleSheet);
    }
    window.addEventListener('load', loadMessagesCss);
    </script>
    <script defer src="js/manage_modals.js"></script>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php"><img src="images/home.png" class="icon" alt=Home></a></li>
                <?php
                    if (isset($_SESSION['user_id'])) {
                        echo '<li><a href="albums.php"><img src="images/album.png" class="icon" alt=Album></a></li>
                        <li><a href="all_images.php"><img src="images/all_images.jpg" class="icon" alt="All images"></a></li>
                        <li><a href="profile.php"><img src="images/profile_icon.png" class="icon"  alt=Profile></a></li>
                        <li id="inline-login">';
                        
                        echo "
                        <form action='../server/logout.php' method='post'>
                            <button type='submit' name='logout-submit' class='form-button bolded'><img src='images/log_out.png' class='icon' alt='Log out'></button>
                        </form>";
                    }
                    else {
                        echo "
                        <form action='../server/login.php' method='post'>
                            <input type='text' name='username' value='' placeholder='Username' class='form-input'>
                            <input type='password' name='password' value='' placeholder='Password' class='form-input'>
                            <button type='submit' name='login-submit' class='form-button bolded'>Login</button>
                            <a href='register.php' class='form-button bolded'>Register</a>
                        </form>";
                    }
                    ?>
                </li>
        </nav>
    </header>
</body>
    