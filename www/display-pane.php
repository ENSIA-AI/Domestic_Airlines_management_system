<?php
include("internal/session.php");
include "./internal/db_config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Departures - DAMS</title>
    <link rel="stylesheet" href="static/css/display-pane.css">
    <script src="static/js/display-pane.js"></script>
</head>

<body>
    <div id="container">
        <?php if (isset($_GET["type"])): ?>
            <div class="logo-grid">
                <?php
                $stmt = $conn->prepare("SELECT * FROM AIRPORTS WHERE IATA_CODE=?");
                $stmt->bind_param("s", $_GET["airport"]);
                $stmt->execute();
                $result_airports = $stmt->get_result();
                $airport = $result_airports->fetch_assoc();
                ?>

                <?php if (isset($_GET["type"]) and $_GET["type"] == "Departures"): ?>
                    <div>
                        <img class="logo" src="/static/images/dep.png">
                    </div>
                    <h1>DEPARTURES</h1>
                <?php else: ?>
                    <div>
                        <img class="logo" src="/static/images/arr.png">
                    </div>
                    <h1>ARRIVALS</h1>
                <?php endif; ?>
                <div style="font-size:40px;text-align:center; color:rgb(180, 247, 72)">
                    <span id="clock">00:00:00</span> <span id="temp"></span>
                </div>
                <a href="/">
                    <img class="logo" src="/static/images/logo.png">
                </a>
            </div>
            <p class="welcome-msg marquee">
                <span><?php
                echo "WELCOME TO " . $airport["WILAYA"] . " AIRPORT - " . $airport["DISPLAY_NAME"] . " [" . $airport["IATA_CODE"] . "]";
                ?></span>
            </p>
            <div class="pane">
                <table>
                    <tr>
                        <th>Time</th>
                        <th>Destination</th>
                        <th>IATA</th>
                        <th>Number</th>
                        <th>Gate</th>
                        <th>Remarks</th>
                    </tr>
                    <?php if ($_GET["type"] == 'Departures'): ?>

                        <?php
                        $sql = "SELECT FLIGHT_NUMBER, DEPARTURE_TIME, AIRPORTS.WILAYA AS ARR_WILAYA, ARR_AIRPORT, DEP_GATE, STATUS FROM FLIGHTS LEFT JOIN AIRPORTS ON FLIGHTS.ARR_AIRPORT = AIRPORTS.IATA_CODE WHERE DEP_AIRPORT = '" . $_GET["airport"] . "' AND (DEPARTURE_TIME >= NOW() OR REAL_DEPARTURE_TIME >= NOW()) ORDER BY DEPARTURE_TIME LIMIT 30";
                        $result_flights = $conn->query($sql);
                        while ($row = $result_flights->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?= (new DateTime($row["DEPARTURE_TIME"]))->format('H:i') ?></td>
                                <td><?= $row["ARR_WILAYA"] ?></td>
                                <td><?= $row["ARR_AIRPORT"] ?></td>
                                <td><?= $row["FLIGHT_NUMBER"] ?></td>
                                <td><?= $row["DEP_GATE"] ?></td>
                                <td><?= str_replace('_', ' ', $row["STATUS"]) ?></td>
                            </tr>
                        <?php endwhile; ?>

                    <?php else: ?>

                        Planes never arrive to this airport, sorry.

                    <?php endif; ?>
                </table>
            </div>
        <?php else: ?>
            <div class="form-container">
                <div class="centered-form">
                    <a href="/">
                        <img src="/static/images/logo.png" class="logo">
                    </a>
                    <br>
                    <br>
                    <form>
                        <label>Select Airport:</label>
                        <select name="airport" aria-label="Airport">
                            <?php
                            $sql = "SELECT IATA_CODE, WILAYA FROM AIRPORTS";
                            $result_airports = $conn->query($sql);
                            while ($row = $result_airports->fetch_assoc()):
                                ?>
                                <option value="<?= $row["IATA_CODE"] ?>"><?= $row["WILAYA"] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <br>
                        <input type="submit" name="type" value="Departures">
                        <input type="submit" name="type" value="Arrivals">
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div id="container-2">
        <a href="/">
            <img class="logo" src="/static/images/logo.png">
        </a>
        <br>
        Incompatible screen size. Please contact the Air Algérie Domestic Airlines technical support.
    </div>

    <script>
        function getCurrentTimeHHMMSS() {
            const now = new Date(); // Create a new Date object representing the current date and time

            // Get hours, minutes, and seconds
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();

            // Pad single-digit values with a leading zero to ensure HH:mm:ss format
            hours = String(hours).padStart(2, '0');
            minutes = String(minutes).padStart(2, '0');
            seconds = String(seconds).padStart(2, '0');

            // Concatenate the formatted parts with colons
            return `${hours}:${minutes}:${seconds}`;
        }

        const clockSpan = document.getElementById('clock');
        setInterval(() => {
            clockSpan.innerText = getCurrentTimeHHMMSS();
        }, 100);
        getWeather("<?= $airport["WILAYA"] ?>");
        setInterval(() => {
            getWeather("<?= $airport["WILAYA"] ?>");
        }, 2000000);
    </script>
</body>

</html>