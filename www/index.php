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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="static/css/homepage.css">
</head>

<body>

    <?php
    include("internal/sidebar.php");
    ?>

    <main class="content">
        <h1 style="text-align: center">Domestic Airlines Management System</h1>

        <?php
        include("internal/db_config.php");
        $sql = "SELECT (SELECT COUNT(*) AS AIRPORT_COUNT FROM AIRPORTS) AS AIRPORTS_COUNT, "
            . "(SELECT COUNT(*) AS AIRCRAFT_COUNT FROM AIRCRAFTS) AS AIRCRAFTS_COUNT, "
            . "(SELECT COUNT(*) FROM FLIGHTS WHERE CAST(FLIGHTS.DEPARTURE_TIME AS DATE) = CAST(CURRENT_TIMESTAMP AS DATE)) AS FLIGHTS_TODAY, "
            . "(SELECT COUNT(*) FROM BOOKINGS NATURAL JOIN FLIGHTS WHERE CAST(FLIGHTS.DEPARTURE_TIME AS DATE) = CAST(CURRENT_TIMESTAMP AS DATE)) AS PASSENGERS_TODAY";

        $result = $conn->query(query: $sql)->fetch_assoc();
        ?>
        <div class="dashboard-grid">
            <div class="stat-card card-flights">
                <div class="stat-content">
                    <h3><?=$result["FLIGHTS_TODAY"]?></h3>
                    <p>Flights Today</p>
                </div>
                <div class="stat-icon">
                    <i class="fa fa-plane"></i>
                </div>
            </div>

            <div class="stat-card card-pax">
                <div class="stat-content">
                    <h3><?=$result["PASSENGERS_TODAY"]?></h3>
                    <p>Passengers Today</p>
                </div>
                <div class="stat-icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>

            <div class="stat-card card-fleet">
                <div class="stat-content">
                    <h3><?=$result["AIRCRAFTS_COUNT"]?></h3>
                    <p>Active Aircraft</p>
                </div>
                <div class="stat-icon">
                    <i class="fa fa-fighter-jet"></i>
                </div>
            </div>

            <div class="stat-card card-airports">
                <div class="stat-content">
                    <h3><?=$result["AIRPORTS_COUNT"]?></h3>
                    <p>Airports</p>
                </div>
                <div class="stat-icon">
                    <i class="fa fa-map-marker"></i>
                </div>
            </div>
        </div>

        <h2>Announcements</h2>
        <div>
            <div class="announcement danger-card">
                <h3>Diversion: Flight AH6180 to Hassi Messaoud</h3>
                <p>Flight AH6180 has been diverted back to Algiers due to a sudden sandstorm reducing visibility at Oued
                    Irara–Krim Belkacem Airport. Passengers will be updated on a new departure time shortly.</p>
                <span class="author">- Operations Control Center on 11/19/2025 07:30</span>
            </div>

            <div class="announcement warning-card">
                <h3>Morning Fog Alert: Constantine & Setif</h3>
                <p>Dense fog is currently affecting flight operations in the eastern highlands. Departures to
                    Constantine
                    (CZL) and Setif (QSF) may experience ground holds of up to 45 minutes this morning.</p>
                <span class="author">- Meteorological Watch on 11/19/2025 06:15</span>
            </div>

            <div class="announcement success-card">
                <h3>Additional Flights to Djanet</h3>
                <p>To support the desert tourism season, we are adding two weekly rotation flights to Djanet (DJG)
                    departing
                    every Friday and Sunday. Booking opens today at noon.</p>
                <span class="author">- Network Planning on 11/18/2025 16:45</span>
            </div>

            <div class="announcement info-card">
                <h3>Domestic Terminal Shuttle Bus</h3>
                <p>The inter-terminal shuttle bus (Blue Line) connecting the International arrivals to the Domestic
                    terminal
                    is undergoing maintenance. A replacement bus service is running every 20 minutes from Gate 2.</p>
                <span class="author">- Ground Transport on 11/18/2025 13:20</span>
            </div>

            <div class="announcement info-card">
                <h3>Carry-on Luggage on ATR Aircraft</h3>
                <p>Passengers travelling on our ATR-72 fleet to Tiaret and El Bayadh are reminded that carry-on luggage
                    must
                    not exceed 5kg due to overhead bin limitations. Larger bags must be checked in.</p>
                <span class="author">- Customer Service on 11/18/2025 09:00</span>
            </div>
        </div>
    </main>
    <button class="floating-button" id="menu-btn"><i class="fa fa-bars"></i> <i class="fa fa-close hidden"></i></button>
</body>

</html>