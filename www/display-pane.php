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
    <title>Departures - DAMS</title>
    <link rel="stylesheet" href="static/css/display-pane.css">
</head>

<body>
    <div id="container">
        <?php if (isset($_GET["type"])): ?>
            <div class="logo-grid">
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
                <div>

                </div>
                <a href="/">
                    <img class="logo" src="/static/images/logo.png">
                </a>
            </div>
            <p class="welcome-msg marquee">
                <span><?php
                $airport = $_GET["airport"];

                if ($airport == "BJA")
                    echo "WELCOME TO BEJAIA AIRPORT - ABANE RAMDANE [BJA]";
                if ($airport == "ALG")
                    echo "WELCOME TO ALGIERS AIRPORT - HOUARI BOUMEDIENE [ALG]";
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
                    <tr>
                        <td>06:00</td>
                        <td>Algiers</td>
                        <td>ALG</td>
                        <td>AH6001</td>
                        <td>A1</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>07:15</td>
                        <td>Oran</td>
                        <td>ORN</td>
                        <td>AH6023</td>
                        <td>B2</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>08:30</td>
                        <td>Constantine</td>
                        <td>CZL</td>
                        <td>AH6045</td>
                        <td>A2</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>09:00</td>
                        <td>Setif</td>
                        <td>QSF</td>
                        <td>AH6067</td>
                        <td>B1</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>09:45</td>
                        <td>Annaba</td>
                        <td>AAE</td>
                        <td>AH6089</td>
                        <td>A3</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>10:30</td>
                        <td>Algiers</td>
                        <td>ALG</td>
                        <td>AH6012</td>
                        <td>A1</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>11:15</td>
                        <td>Batna</td>
                        <td>BLJ</td>
                        <td>AH6101</td>
                        <td>B3</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>12:00</td>
                        <td>Oran</td>
                        <td>ORN</td>
                        <td>AH6024</td>
                        <td>B2</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>12:45</td>
                        <td>Algiers</td>
                        <td>ALG</td>
                        <td>AH6002</td>
                        <td>A1</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>13:30</td>
                        <td>Constantine</td>
                        <td>CZL</td>
                        <td>AH6046</td>
                        <td>A2</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>14:15</td>
                        <td>Setif</td>
                        <td>QSF</td>
                        <td>AH6068</td>
                        <td>B1</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>15:00</td>
                        <td>Annaba</td>
                        <td>AAE</td>
                        <td>AH6090</td>
                        <td>A3</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>15:45</td>
                        <td>Algiers</td>
                        <td>ALG</td>
                        <td>AH6013</td>
                        <td>A1</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>16:30</td>
                        <td>Batna</td>
                        <td>BLJ</td>
                        <td>AH6102</td>
                        <td>B3</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>17:15</td>
                        <td>Oran</td>
                        <td>ORN</td>
                        <td>AH6025</td>
                        <td>B2</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>18:00</td>
                        <td>Algiers</td>
                        <td>ALG</td>
                        <td>AH6003</td>
                        <td>A1</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>18:45</td>
                        <td>Constantine</td>
                        <td>CZL</td>
                        <td>AH6047</td>
                        <td>A2</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>19:30</td>
                        <td>Setif</td>
                        <td>QSF</td>
                        <td>AH6069</td>
                        <td>B1</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>20:15</td>
                        <td>Annaba</td>
                        <td>AAE</td>
                        <td>AH6091</td>
                        <td>A3</td>
                        <td>On Time</td>
                    </tr>
                    <tr>
                        <td>21:00</td>
                        <td>Algiers</td>
                        <td>ALG</td>
                        <td>AH6014</td>
                        <td>A1</td>
                        <td>On Time</td>
                    </tr>

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
                            <option value="ALG">Algiers</option>
                            <option value="BJA">Bejaia</option>
                        </select>
                        <br>
                        <input type="submit" name="type" value="Departures">
                        <input type="submit" name="type" value="Arrivals">
                    </form>
                </div>
            </div>
        <?php endif; ?>
        </div>
</body>

</html>