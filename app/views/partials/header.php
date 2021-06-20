<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />

    <script src="https://twemoji.maxcdn.com/v/latest/twemoji.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.1.1/dist/chart.min.js"></script>

    <link rel="stylesheet" type="text/css" href="app/assets/styles/mini-framework.css" />
    <title><?= htmlentities($title) ?></title>
</head>

<body>
    <header>
        <a href="home"><img id="logo" src="app/assets/dashmeteo_logo.png" alt="DashMeteo Logo" ></a>
        <?php
        if ($logged_in) {
            echo '<div class="email_display"><a href="do_logout" class="logout">Logout</a>' . htmlentities($email) . '<img style="height: 50px;" src="app/assets/portrait_icon.png"></div>';
        }
        else
            echo '<p><a href="login">Login</a> - <a href="signup">Sign Up</a></p>';
        ?>
    </header>
    <main class="<?= htmlentities($page_class) ?>">
        <div id="notification_area" class="<?= $_GET['notification_status'] ?? "no_notification" ?>"><button onload="" onclick='document.getElementById("notification_area").style.display = "none";'>X</button>
            <p id="notification_text"><?= $_GET['notification']; ?></p>
        </div>
