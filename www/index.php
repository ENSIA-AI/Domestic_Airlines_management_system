<?php
include("internal/session.php");
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
            . "(SELECT COUNT(*) FROM BOOKINGS WHERE CAST(DEPARTURE_TIME AS DATE) = CAST(CURRENT_TIMESTAMP AS DATE)) AS PASSENGERS_TODAY";

        $result = $conn->query(query: $sql)->fetch_assoc();
        ?>
        <div class="dashboard-grid">
            <div class="stat-card card-flights">
                <div class="stat-content">
                    <h3><?= $result["FLIGHTS_TODAY"] ?></h3>
                    <p>Flights Today</p>
                </div>
                <div class="stat-icon">
                    <i class="fa fa-plane"></i>
                </div>
            </div>

            <div class="stat-card card-pax">
                <div class="stat-content">
                    <h3><?= $result["PASSENGERS_TODAY"] ?></h3>
                    <p>Passengers Today</p>
                </div>
                <div class="stat-icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>

            <div class="stat-card card-fleet">
                <div class="stat-content">
                    <h3><?= $result["AIRCRAFTS_COUNT"] ?></h3>
                    <p>Active Aircraft</p>
                </div>
                <div class="stat-icon">
                    <i class="fa fa-fighter-jet"></i>
                </div>
            </div>

            <div class="stat-card card-airports">
                <div class="stat-content">
                    <h3><?= $result["AIRPORTS_COUNT"] ?></h3>
                    <p>Airports</p>
                </div>
                <div class="stat-icon">
                    <i class="fa fa-map-marker"></i>
                </div>
            </div>
        </div>

        <h2>Announcements</h2>
        <div id="announcements">
            <div class="spinner-container r-10 bg-transparent">
                <div class="spinner"></div>
                Loading...
            </div>
        </div>
    </main>
    <button class="floating-button" id="menu-btn"><i class="fa fa-bars"></i> <i class="fa fa-close hidden"></i></button>
</body>

</html>
<script>
    function updateAnnouncements() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("announcements").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "backend/announcements.php", true);
        xmlhttp.send();
    }
    updateAnnouncements();

    setInterval(updateAnnouncements(), 60000);
</script>

</html>