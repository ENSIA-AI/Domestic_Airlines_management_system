<?php
session_start();

include "../internal/db_config.php";

function display($str)
{
    if (empty($str)) return '';
    return ucwords(strtolower(str_replace('_', ' ', $str)));
}

if (isset($_POST["type"])) {
    if ($_POST["type"] == "DEL" && isset($_POST["id"]) && is_numeric($_POST["id"])) {
        $stmt = $conn->prepare("DELETE FROM BOOKINGS WHERE BOOKING_ID = ?");
        $stmt->bind_param("i", $_POST["id"]);
        $stmt->execute();
    } else if ($_POST["type"] == "ADD") {
        $passenger_num = $_POST["PASSENGER_NUM"];
        list($flight_number, $departure_date_time) = explode('|', $_POST["flight"]);
        $class = strtoupper($_POST["class"]);
        $status = strtoupper($_POST["status"]);
        $stmt_booking = $conn->prepare("INSERT INTO BOOKINGS (PASSENGER_NUM, FLIGHT_NUMBER, DEPARTURE_TIME, CLASS, STATUS) VALUES (?, ?, ?, ?, ?)");
        $stmt_booking->bind_param(
            "issss",
            $passenger_num,
            $flight_number,
            $departure_date_time,
            $class,
            $status
        );
        $stmt_booking->execute();
    }
}

$sql_p = "SELECT PASSENGER_NUM, FIRST_NAME, LAST_NAME FROM PASSENGERS ORDER BY LAST_NAME, FIRST_NAME";
$result_passengers = $conn->query($sql_p);

$sql_ft = "SELECT FLIGHT_NUMBER, DEPARTURE_TIME FROM FLIGHTS WHERE DEPARTURE_TIME > NOW() ORDER BY DEPARTURE_TIME ASC";
$result_ft = $conn->query($sql_ft);

$sql = "SELECT b.BOOKING_ID,p.FIRST_NAME, p.LAST_NAME, p.PHONE, b.FLIGHT_NUMBER, b.DEPARTURE_TIME, b.CLASS, b.STATUS FROM BOOKINGS b JOIN PASSENGERS p ON b.PASSENGER_NUM = p.PASSENGER_NUM ORDER BY b.BOOKING_ID DESC";
$result_bookings = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <script src="/static/js/search.js"></script>
    <title>Booking Management</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main>
        <div class="content">
            <div class="dams-head">
                <h1>Booking Management</h1>
                <button class="btn add-btn">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <div class="search-container">
                <h2 class="recent">Recent Bookings</h2>
                <div class="search-bar"><input type="text" class="search" id="search-bar" placeholder="Search">
                    <button class="search-btn"><i class="fa fa-search"></i></button>
                </div>
            </div>

            <div class="table-container">
                <table class="dams-table" id="search-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Passenger</th>
                            <th>Flight Number</th>
                            <th>Date</th>
                            <th>Class</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id="tablebody">
                        <?php while ($row = $result_bookings->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row["BOOKING_ID"]; ?></td>
                                <td><?= $row["FIRST_NAME"] . " " . $row["LAST_NAME"]; ?></td>
                                <td><?= $row["FLIGHT_NUMBER"]; ?></td>
                                <?php
                                $departure_datetime = new DateTime($row['DEPARTURE_TIME']);
                                $display_datetime = $departure_datetime->format('d M Y H:i');
                                ?>
                                <td><?= $display_datetime; ?></td>
                                <td><?= display($row["CLASS"]); ?></td>
                                <td><?= $row["PHONE"]; ?></td>
                                <?php $status_display = display($row["STATUS"]); ?>
                                <td><span class="status <?= $status_display; ?>"><?= $status_display; ?></span></td>
                                <td>
                                    <div class="options">
                                        <button class="option"><i class="fa fa-eye"></i></button>
                                        <button class="option"><i class="fa fa-edit"></i></button>
                                        <button class="option" onclick="deletebooking('<?= $row['BOOKING_ID'] ?>')"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="form-overlay" id="overlay">
        <form class="dams-add-form" id="AddForm" method="POST">
            <h2 id="title">Add New Booking</h2>

            <input type="hidden" name="type" value="ADD">

            <label for="passenger">Passenger: </label>
            <select name="PASSENGER_NUM" id="passenger" required>
                <?php while ($p = $result_passengers->fetch_assoc()): ?>
                    <option value="<?= $p['PASSENGER_NUM'] ?>">
                        <?= "{$p['FIRST_NAME']} {$p['LAST_NAME']} (ID: {$p['PASSENGER_NUM']})" ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="flight">Flight and Departure Date: </label>
            <select name="flight" id="flight" required>
                <?php while ($f = $result_ft->fetch_assoc()):
                    $dt = new DateTime($f['DEPARTURE_TIME']);
                    $display_dt = $dt->format('d M Y H:i');
                    $value = "{$f['FLIGHT_NUMBER']}|{$f['DEPARTURE_TIME']}";
                    $display = "{$f['FLIGHT_NUMBER']} - {$display_dt}";
                ?>
                    <option value="<?= $value ?>"><?= $display ?></option>
                <?php endwhile; ?>
            </select>

            <label for="class">Class: </label>
            <select name="class" id="class" required>
                <option value="ECO_PROMO">Economy Promo</option>
                <option value="ECO_SMART">Economy Smart</option>
                <option value="ECO_FLEX">Economy Flex</option>
                <option value="ECO_PLUS">Economy Plus</option>
                <option value="BUSINESS_PLUS">Business Plus</option>
                <option value="PREMIERE_PLUS">Premiere Plus</option>
            </select>

            <label for="status">Status: </label>
            <select name="status" id="status" required>
                <option value="CONFIRMED">Confirmed</option>
                <option value="CANCELLED">Cancelled</option>
            </select>

            <div class="form-actions">
                <button type="submit" class="submit-btn" id="submit-btn">Add Booking</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>

    <script src="/static/js/form.js"></script>
    <button class="floating-button" id="menu-btn"><i class="fa fa-bars"></i> <i class="fa fa-close hidden"></i></button>

    <script>
        const table = document.getElementById("search-table");
        const searchBar = document.getElementById("search-bar");
        searchBar.addEventListener("keyup", () => {
            search();
        }, false);

        function deletebooking(id) {
            if (confirm(`Do you really wanna delete booking ${id}?`)) {
                postRedirect('', {
                    type: 'DEL',
                    id: id
                });
            }
        }
    </script>
</body>

</html>