<?php
include "../../internal/db_config.php";

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["type"])) {
        if ($_POST["type"] == "DEL" and isset($_POST["airport"]) and strlen($_POST["airport"]) == 3) {
            $stmt = $conn->prepare("DELETE FROM AIRPORTS WHERE IATA_CODE = ?");
            $stmt->bind_param("s", $_POST["airport"]);
            $stmt->execute();
            echo "Airport removed successfully !";
        } else if ($_POST["type"] == "ADD") {
            $stmt = $conn->prepare("INSERT INTO AIRPORTS VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param(
                "ssssddi",
                $_POST["IATA_CODE"],
                $_POST["ICAO_CODE"],
                $_POST["WILAYA"],
                $_POST["DISPLAY_NAME"],
                $_POST["LATITUDE"],
                $_POST["LONGITUDE"],
                $_POST["ELEVATION"]
            );
            $stmt->execute();
            echo "Airport added successfully !";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET'):
    ?>
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
            <?php
            $sql = "SELECT * FROM AIRPORTS";
            $result_airports = $conn->query($sql);
            while ($row = $result_airports->fetch_assoc()):
                ?>
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
                                onclick="deleteAirport('<?= $row['IATA_CODE'] ?>')"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>