<?php
require "../internal/session.php";
require "../internal/db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET['action']) && $_GET['action'] == 'loadFlights') {

        $sql = "SELECT f.FLIGHT_NUMBER, f.DEPARTURE_TIME, f.DEP_GATE, f.ARR_GATE, 
                       COUNT(DISTINCT b.BOOKING_ID) AS total_bookings,
                       p.FIRST_NAME, p.LAST_NAME, p.PHONE_COUNTRY_CODE, 
                       p.PHONE_NUMBER, p.GENDER, p.NATIONALITY,
                       b.PASSENGER_NUM
                FROM FLIGHTS f
                LEFT JOIN BOOKINGS b ON f.FLIGHT_NUMBER = b.FLIGHT_NUMBER
                LEFT JOIN PASSENGERS p ON b.PASSENGER_NUM = p.PASSENGER_NUM
                GROUP BY f.FLIGHT_NUMBER, p.PASSENGER_NUM
                ORDER BY f.FLIGHT_NUMBER";

        $result = mysqli_query($conn, $sql);
        $allData = mysqli_fetch_all($result, MYSQLI_ASSOC);

        echo ' 
            <table class="dams-table" id="search-table">
                <thead class="dams-table-head">
                    <tr>
                        <th>ID</th>
                        <th>Dep Gate</th>
                        <th>Arr Gate</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Countdown</th>
                        <th>Total</th>
                        <th>Show</th>
                    </tr>
                </thead>
                <tbody class="dams-table-body" id="dams-table-body">';


        $flightGroups = [];
        foreach ($allData as $row) {
            $flightNum = $row['FLIGHT_NUMBER'];
            if (!isset($flightGroups[$flightNum])) {
                $flightGroups[$flightNum] = [
                    'flight' => $row,
                    'passengers' => []
                ];
            }
            if ($row['PASSENGER_NUM'] !== null) {
                $flightGroups[$flightNum]['passengers'][] = $row;
            }
        }

        foreach ($flightGroups as $flight_data) {
            $flight = $flight_data['flight'];
            $passengers = $flight_data['passengers'];

            $flight_number = htmlspecialchars($flight['FLIGHT_NUMBER']);
            $departure_time = $flight['DEPARTURE_TIME'];
            $departure_gate = htmlspecialchars($flight['DEP_GATE']);
            $arrival_gate = htmlspecialchars($flight['ARR_GATE']);
            $total_bookings = $flight['total_bookings'];

            $parts = explode(' ', $departure_time);
            $date = $parts[0] ?? 'N/A';
            $time = $parts[1] ?? 'N/A';


            echo "
                <tr class='parent-row'>
                    <td>$flight_number</td>
                    <td>$departure_gate</td>
                    <td>$arrival_gate</td>
                    <td>$date</td>
                    <td>$time</td>
                    <td class='countdown'>Countdown</td>
                    <td>$total_bookings</td>
                    <td>
                        <button class='option'>
                            <i class='fa-solid fa-circle-chevron-down'></i>
                        </button>
                    </td>
                </tr>";


            echo "
                <tr class='childrow headchildrow' style='display: none;'>
                    <td class='dummy-td'></td>
                    <td>Name</td>
                    <td>Phone</td>
                    <td>Gender</td>
                    <td>Nationality</td>
                    <td>State</td>
                    <td colspan='2' class='dummy-td'></td>
                </tr>";


            if (!empty($passengers)) {
                foreach ($passengers as $p) {

                    $fullName = htmlspecialchars($p['FIRST_NAME'] . ' ' . $p['LAST_NAME']);
                    $phone = htmlspecialchars($p['PHONE_COUNTRY_CODE'] . ' ' . $p['PHONE_NUMBER']);
                    $gender = htmlspecialchars($p['GENDER']);
                    $nationality = htmlspecialchars($p['NATIONALITY']);


                    $state = "On Plane";

                    echo "
                    <tr class='childrow' style='display: none;'> 
                        <td class='dummy-td'></td>
                        <td>$fullName</td>
                        <td>$phone</td>
                        <td>$gender</td>
                        <td>$nationality</td>
                        <td><span class='arrival-state on-plane'>$state</span></td>
                        <td colspan='2' class='dummy-td'></td> 
                    </tr>";
                }
            } else {
                // Optional: Row to show if no passengers exist
                echo "
                <tr class='childrow' style='display: none;'> 
                    <td class='dummy-td'></td>
                    <td colspan='5' style='text-align:center; color:#888;'>No passengers found</td>
                    <td colspan='2' class='dummy-td'></td> 
                </tr>";
            }
        }
        echo '</tbody></table>';
    }
}
?>