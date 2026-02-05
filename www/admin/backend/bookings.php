<?php
session_start();
include "../../internal/db_config.php";

function display($str)
{
    if (empty($str)) return '';
    return ucwords(strtolower(str_replace('_', ' ', $str)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["type"])) {
        if ($_POST["type"] == "DEL" && isset($_POST["booking_id"]) && is_numeric($_POST["booking_id"])) {
            $stmt = $conn->prepare("DELETE FROM BOOKINGS WHERE BOOKING_ID = ?");
            $stmt->bind_param("i", $_POST["booking_id"]);
            $stmt->execute();
        } else if ($_POST["type"] == "ADD") {
            $passenger_num = $_POST["PASSENGER_NUM"];
            list($flight_number, $departure_date_time) = explode('|', $_POST["flight"]);
            $class = strtoupper($_POST["class"]);
            $status = strtoupper($_POST["status"]);

            $check_stmt = $conn->prepare("SELECT BOOKING_ID FROM BOOKINGS WHERE PASSENGER_NUM = ? AND FLIGHT_NUMBER = ? AND DEPARTURE_TIME = ?");
            $check_stmt->bind_param("iss", $passenger_num, $flight_number, $departure_date_time);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                http_response_code(409);
                echo "Error: This passenger already has a booking for this flight.";
            } else {
                $stmt = $conn->prepare("INSERT INTO BOOKINGS (PASSENGER_NUM, FLIGHT_NUMBER, DEPARTURE_TIME, CLASS, STATUS) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $passenger_num, $flight_number, $departure_date_time, $class, $status);
                $stmt->execute();
            }
        } else if ($_POST["type"] == "UPDATE" && isset($_POST["booking_id"]) && is_numeric($_POST["booking_id"])) {
            $booking_id = $_POST["booking_id"];
            $passenger_num = $_POST["PASSENGER_NUM"];
            list($flight_number, $departure_date_time) = explode('|', $_POST["flight"]);
            $class = strtoupper($_POST["class"]);
            $status = strtoupper($_POST["status"]);

            $check_stmt = $conn->prepare("SELECT BOOKING_ID FROM BOOKINGS WHERE PASSENGER_NUM = ? AND FLIGHT_NUMBER = ? AND DEPARTURE_TIME = ? AND BOOKING_ID != ?");
            $check_stmt->bind_param("issi", $passenger_num, $flight_number, $departure_date_time, $booking_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                http_response_code(409);
                echo "Error: This passenger already has a booking for this flight.";
            } else {
                $stmt = $conn->prepare("UPDATE BOOKINGS SET PASSENGER_NUM=?, FLIGHT_NUMBER=?, DEPARTURE_TIME=?, CLASS=?, STATUS=? WHERE BOOKING_ID=?");
                $stmt->bind_param("issssi", $passenger_num, $flight_number, $departure_date_time, $class, $status, $booking_id);
                $stmt->execute();
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET'):
?>
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
        <tbody class="dams-table-body">
            <?php
            $sql = "SELECT b.BOOKING_ID, p.FIRST_NAME, p.LAST_NAME, p.PHONE_NUMBER, b.FLIGHT_NUMBER, b.DEPARTURE_TIME, b.CLASS, b.STATUS, b.PASSENGER_NUM FROM BOOKINGS b JOIN PASSENGERS p ON b.PASSENGER_NUM = p.PASSENGER_NUM ORDER BY b.BOOKING_ID DESC";
            $result_bookings = $conn->query($sql);
            while ($row = $result_bookings->fetch_assoc()):
                $departure_datetime = new DateTime($row['DEPARTURE_TIME']);
                $display_datetime = $departure_datetime->format('d M Y H:i');
                $status_display = display($row["STATUS"]);
            ?>
                <tr>
                    <td><?= htmlspecialchars($row["BOOKING_ID"]); ?></td>
                    <td><?= htmlspecialchars($row["FIRST_NAME"] . " " . $row["LAST_NAME"]); ?></td>
                    <td><?= htmlspecialchars($row["FLIGHT_NUMBER"]); ?></td>
                    <td><?= htmlspecialchars($display_datetime); ?></td>
                    <td><?= display($row["CLASS"]); ?></td>
                    <td><?= htmlspecialchars($row["PHONE_NUMBER"]); ?></td>
                    <td><span class="status <?= $status_display; ?>"><?= $status_display; ?></span></td>
                    <td>
                        <div class="options">
                            <button class="option" onclick='viewBooking(<?= json_encode($row) ?>, "<?= $display_datetime ?>")'><i class="fa fa-eye"></i></button>
                            <button class="option" onclick='editBooking(<?= json_encode($row) ?>)'><i class="fa fa-edit"></i></button>
                            <button class="option" onclick="deleteBooking('<?= htmlspecialchars($row['BOOKING_ID']) ?>')"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>