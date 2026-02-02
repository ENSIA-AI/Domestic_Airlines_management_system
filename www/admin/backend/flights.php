<?php
include("../../internal/session.php");
include "../../internal/db_config.php";

// insertion :
if (isset($_POST['request_type'])) {
    $request_type = mysqli_real_escape_string($conn, $_POST['request_type']);
    
    if ($request_type == 'insert') {
        $FNUM = mysqli_real_escape_string($conn, $_POST['flight_number']);
        $TIME = mysqli_real_escape_string($conn, $_POST['departure_time']);
        $DEP_AIRPORT = mysqli_real_escape_string($conn, $_POST['dep_airport']);
        $ARR_AIRPORT= mysqli_real_escape_string($conn, $_POST['arr_airport']);
        $STATUS = mysqli_real_escape_string($conn, $_POST['status']);
        $STATUS = ucwords(strtolower($STATUS));
        $AIRCRAFT = mysqli_real_escape_string($conn, $_POST['aircraft']);

        $insert_flight_query = "INSERT INTO FLIGHTS(FLIGHT_NUMBER, DEPARTURE_TIME,
        DEP_AIRPORT, ARR_AIRPORT, AIRCRAFT, `STATUS`)
        values('$FNUM', '$TIME', '$DEP_AIRPORT', '$ARR_AIRPORT', '$AIRCRAFT', '$STATUS')";

        if (mysqli_query($conn, $insert_flight_query)) {
            echo "        <tr>
                            <td>$FNUM</td>
                            <td>$DEP_AIRPORT</td>
                            <td>$ARR_AIRPORT</td>
                            <td>$TIME</td>
                            <td>$AIRCRAFT</td>
                            <td>
                                <span class=\"status $STATUS \">
                                    $STATUS  
                                </span>
                            </td>
                            <td>
                                <div class=\"options\">
                                    <button class=\"option\"><i class=\"fa fa-eye\"></i></button>
                                    <button class=\"option\"><i class=\"fa fa-edit\"></i></button>
                                    <button class=\"option\"><i class=\"fa fa-trash\"></i></button>
                                </div>
                            </td>
                          </tr>
                        ";
        } else {
            echo mysqli_error($conn);
        }
    } elseif ($request_type == 'update') {

    } elseif ($request_type == 'delete') {

    } else {
        echo 'invalid request type';
    }
}

?>