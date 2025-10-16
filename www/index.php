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
    <div class="sidebar">
        <div class="top">
            <h2>Menu</h2>
            <a href="/">Home</a>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                <span class="nav-title">AIRPORT CREW</span>
                <hr>
                <a href="/check-in.php">Check-in</a>
                <a href="/boarding.php">Boarding</a>
                <a href="/display-pane.php">Flights Schedule</a>
                <span class="nav-title">ADMINISTRATION</span>
                <hr>
                <a href="/admin/bookings.php">Booking Management</a>
                <a href="/admin/passengers.php">Passenger Management</a>
                <a href="/admin/users.php">User Management</a>
                <a href="/admin/airports.php">Airport Management</a>
                <a href="/admin/flights.php">Flight Management</a>
                <a href="/admin/aircrafts.php">Aircraft Management</a>
            <?php endif; ?>
        </div>
        <div>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                <a href="/admin/?log-in=no">Log out</a>
            <?php else: ?>
                <a href="/?log-in=yes">Log in</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="content">
        <center>
            <h1>Domestic Airlines Management System</h1>
            <img src="static/images/atr72.png">
        </center>
    </div>

</body>

</html>