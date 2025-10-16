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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/flights.css">

    <title>Flight Management</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main class="content">
        <div class="head_flights">
            <h1 class="title">Flight Management</h1>
            <button class="btn add-btn">
                <i class="fa fa-plus"></i> Add New
            </button>
        </div>
        <div class="flights-preview">
            <h2 class>Flights</h2>
                <table class="flights-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Departure</th>
                            <th>Destination</th>
                            <th>Seats</th>
                            <th>Aircraft</th>
                            <th>Options</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ALG-7777</td>
                            <td>Test 1</td>
                            <td>ALG → ORN</td>
                            <td>16 Oct 2023</td>
                            <td>12A</td>
                            <td><span class="status confirmed">Confirmed</span></td>
                            <td>
                                <div class="action-buttons-bookings">
                                    <button class="btn-icon"><i class="fa fa-eye"></i></button>
                                    <button class="btn-icon"><i class="fa fa-edit"></i></button>
                                    <button class="btn-icon"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <h2 class>Flights</h2>
                <table class="flights-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Departure</th>
                            <th>Destination</th>
                            <th>Seats</th>
                            <th>Aircraft</th>
                            <th>Options</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ALG-7777</td>
                            <td>Test 1</td>
                            <td>ALG → ORN</td>
                            <td>16 Oct 2023</td>
                            <td>12A</td>
                            <td><span class="status confirmed">Confirmed</span></td>
                            <td>
                                <div class="action-buttons-bookings">
                                    <button class="btn-icon"><i class="fa fa-eye"></i></button>
                                    <button class="btn-icon"><i class="fa fa-edit"></i></button>
                                    <button class="btn-icon"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

    </main>

</body>

</html>