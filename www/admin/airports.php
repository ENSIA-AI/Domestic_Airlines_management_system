<?php
session_start();
if (isset($_GET["log-in"]) and $_GET["log-in"] == "yes") {
    $_SESSION["loggedin"] = "yes";
} else if (isset($_GET["log-in"]) and $_GET["log-in"] == "no") {
    unset($_SESSION["loggedin"]);
}

include "../internal/db_config.php";

if (isset($_POST["type"])) {
    if ($_POST["type"] == "DEL" and isset($_POST["airport"]) and strlen($_POST["airport"]) == 3) {
        $stmt = $conn->prepare("DELETE FROM AIRPORTS WHERE IATA_CODE = ?");
        $stmt->bind_param("s", $_POST["airport"]);
        $stmt->execute();
    }
}

$sql = "SELECT * FROM AIRPORTS";
$result_airports = $conn->query($sql);

function display_degrees($nb, $s1, $s2)
{
    $sign = $nb >= 0 ? $s1 : $s2;
    $nb = abs($nb);
    $degs = floor($nb);
    $nb -= $degs;
    $nb *= 60;
    $mins = floor($nb);
    $nb -= $mins;
    $secs = floor($nb * 60);
    return $degs . "° " . sprintf("%02d", $mins) . "′ " . sprintf("%02d", $secs) . "′′ " . $sign;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/bookings.css">
    <script src="/static/js/search.js"></script>
    <title>Airport Management</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main class="content">
        <div class="dams-head">
            <h1 class="title">Airport Management</h1>
            <button class="btn add-btn">
                <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="search-container">
            <h2 class="recent">Algeria's Airports</h2>
            <div class="search-bar"><input type="text" class="search" id="search-bar" placeholder="Search">
                <button class="search-btn"><i class="fa fa-search"></i></button>
            </div>
        </div>

        <div class="table-container">
            <table class="dams-table" id="search-table">
                <thead>
                    <tr>
                        <th>IATA Code</th>
                        <th>ICAO Code</th>
                        <th>Wilaya</th>
                        <th>Name</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Elevation</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_airports->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row["IATA_CODE"]; ?></td>
                            <td><?= $row["ICAO_CODE"]; ?></td>
                            <td><?= $row["WILAYA"]; ?></td>
                            <td><?= $row["DISPLAY_NAME"]; ?></td>
                            <td><?= display_degrees($row["LATITUDE"], "N", "S"); ?></td>
                            <td><?= display_degrees($row["LONGITUDE"], "E", "W"); ?></td>
                            <td><?= $row["ELEVATION"]; ?> m</td>
                            <td>
                                <div class="options">
                                    <button class="option" name="<?= $row["IATA_CODE"] ?>"
                                        onclick="deleteAirport('<?= $row['IATA_CODE'] ?>')"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div class="form-overlay" id="overlay">
        <form class="dams-add-form" id="AddForm">
            <h2 id="title">Add New Booking</h2>
            <div class="name-container">
                <label for="First_Name">First Name: </label>
                <input type="text" name="First_Name" id="fn" required>
                <label for="Last">Last Name: </label>
                <input type="text" name="Last" id="ln" required>
            </div>
            <label for="Flight-Num">Flight Number: </label>
            <input type="text" name="Flight-Num" id="flight_n" required>
            <label for="date">Departure Date: </label>
            <input type="date" name="date" id="date" required>
            <label for="class">Class: </label>
            <select name="class" id="class" required>
                <option value="Economy">Economy</option>
                <option value="Business">Business</option>
                <option value="Premium">Premium</option>
            </select>
            <label for="Email">Email: </label>
            <input type="email" name="Email" id="email">
            <label for="Phone">Phone Number: </label>
            <input type="tel" id="phone" name="phone" pattern="(0[0-9]8)|(0[567][0-9]{8})">
            <label for="status">Status: </label>
            <select id="status" name="status" required>
                <option value="Confirmed">Confirmed</option>
                <option value="Pending">Pending</option>
                <option value="Cancelled">Cancelled</option>
            </select>
            <div class="form-actions">
                <button type="submit" class="submit-btn" id="submit-btn">Add Booking</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>
    <script src="/static/js/form.js"></script>

    <button class="floating-button" id="menu-btn"><i class="fa fa-bars"></i> <i class="fa fa-close hidden"></i></button>
</body>

<script>
    // searchBar
    const table = document.getElementById("search-table");
    const searchBar = document.getElementById("search-bar");
    searchBar.addEventListener("keyup", () => { search(); }, false);

    // Delete button
    function deleteAirport(airport) {
        if (confirm(`Do you really wanna delete airport ${airport} ?`)) {
            postRedirect('', {
                type: 'DEL',
                airport: airport
            });
        }
    }
</script>

</html>