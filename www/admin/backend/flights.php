<?php
include("../../internal/session.php");
include "../../internal/db_config.php";

// loading all the rows

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $select_flights_query = 'SELECT * FROM FLIGHTS';
  $flights_result = mysqli_query($conn, $select_flights_query);
  $flights = mysqli_fetch_all($flights_result, MYSQLI_ASSOC);

  echo '<table class="dams-table" id="search-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Departure</th>
                            <th>Destination</th>
                            <th>Date</th>
                            <th>Aircraft</th>
                            <th>DGate</th>
                            <th>AGate</th>
                            <th>Status</th>
                            <th>Options</th>

                        </tr>
                    </thead>
                    <tbody  id="tablebody">';
  foreach($flights as $flight) {
    $flight['STATUS'] = ucwords(strtolower($flight['STATUS']));
      echo                   
        "<tr>
            <td>{$flight['FLIGHT_NUMBER']}</td>
            <td>{$flight['DEP_AIRPORT']} </td>
            <td>{$flight['ARR_AIRPORT'] }</td>
            <td>{$flight['DEPARTURE_TIME']}</td>
            <td>{$flight['AIRCRAFT']} </td>
            <td>{$flight['DEP_GATE']}</td>
            <td>{$flight['ARR_GATE']}</td>
            <td>
                <span class=\"status {$flight['STATUS']} \">
                    {$flight['STATUS']}
                </span>
            </td>
            <td>
                <div class=\"options\">
                    <button class=\"option\"><i class=\"fa fa-eye\"></i></button>
                    <button class=\"option\"><i class=\"fa fa-edit\"></i></button>
                    <button class=\"option\"><i class=\"fa fa-trash\"></i></button>
                </div>
            </td>
        </tr>";
        }

    echo '</tbody></table>';
                        
  
}


if (isset($_POST['request_type'])) {
    $request_type = mysqli_real_escape_string($conn, $_POST['request_type']);

    if ($request_type == 'insert') {

        $FNUM        = $_POST['flight_number'];
        $TIME        = $_POST['departure_time'];
        $DEP_AIRPORT = $_POST['dep_airport'];
        $ARR_AIRPORT = $_POST['arr_airport'];
        $AIRCRAFT    = $_POST['aircraft'];

        $STATUS = ucwords(strtolower($_POST['status']));

        $sql = "INSERT INTO FLIGHTS (FLIGHT_NUMBER, DEPARTURE_TIME, DEP_AIRPORT, ARR_AIRPORT, AIRCRAFT, `STATUS`) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssss", $FNUM, $TIME, $DEP_AIRPORT, $ARR_AIRPORT, $AIRCRAFT, $STATUS);
            if ($stmt->execute()) {
                echo "Flight $FNUM added successfully!";
            } else {
                echo "Execution failed: " . $stmt->error;
            }
            $stmt->close();
        } 

    } elseif ($request_type == 'edit') {
        $FNUM = mysqli_real_escape_string($conn, $_POST['flight_number']);
        $TIME = mysqli_real_escape_string($conn, $_POST['departure_time']);
        $DEP_AIRPORT = mysqli_real_escape_string($conn, $_POST['dep_airport']);
        $ARR_AIRPORT= mysqli_real_escape_string($conn, $_POST['arr_airport']);
        $STATUS = mysqli_real_escape_string($conn, $_POST['status']);
        $STATUS = ucwords(strtolower($STATUS));
        $AIRCRAFT = mysqli_real_escape_string($conn, $_POST['aircraft']);

       $stmt = $conn->prepare(
        "UPDATE FLIGHTS
        SET FLIGHT_NUMBER = ?,
            DEPARTURE_TIME = ?,
            DEP_AIRPORT = ?,
            ARR_AIRPORT = ?,
            STATUS = ?,
            AIRCRAFT = ?
        WHERE FLIGHT_NUMBER = ? AND DEPARTURE_TIME = ?"
      );

      $stmt->bind_param(
        "ssssssss",
        $FNUM,
        $TIME,
        $DEP_AIRPORT,
        $ARR_AIRPORT,
        $STATUS,
        $AIRCRAFT,
        $FNUM,
        $TIME
      );

      if (!$stmt->execute()) {
        echo $stmt->error;
      }
           
    } elseif ($request_type == 'delete') {
        if(isset($_POST['flight_number']) && isset($_POST['departure_time'])) {
            $FID = $_POST['flight_number'];
            $TIME = $_POST['departure_time'];
            $query = "DELETE FROM FLIGHTS WHERE `FLIGHT_NUMBER` = ? AND `DEPARTURE_TIME` = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ss', $FID, $TIME);
            
            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
            } else {
                echo "Flight deleted successfully.";
            }
        }
    }
}
?>