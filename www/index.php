<?php
session_start();
if (isset($_GET["log-in"]) and $_GET["log-in"] == "yes") {
    $_SESSION["loggedin"] = "yes";
} else if (isset($_GET["log-in"]) and $_GET["log-in"] == "no") {
    unset($_SESSION["loggedin"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page - DAMS</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="static/css/homepage.css">
</head>

<body>

    <?php
        include ("internal/sidebar.php");
    ?>

    <main class="content">
        <center>
            <h1>Domestic Airlines Management System</h1>
            <img src="static/images/atr72.png">
        </center>
    </main>

</body>

</html>