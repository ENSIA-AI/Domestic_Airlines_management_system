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
    <link rel="stylesheet" href="/static/css/bookings.css">

    <title>Booking Management</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main class="content">
        <div class="head_booking">
            <h1 class="title">Booking Management</h1>
            <button class="btn add-btn">
                <i class="fa fa-plus"></i> Add New
            </button>
        </div>

        <div class="reservation">
            <h2 class="recent">Recent Reservations</h2>
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Passenger</th>
                        <th>Flight Number</th>
                        <th>Date</th>
                        <th>Seat</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>XJ9HE4</td>
                        <td>Test num1</td>
                        <td>AH1432</td>
                        <td>16 Oct 2024</td>
                        <td>12A</td>
                        <td><span class="status confirmed">Confirmed</span></td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-eye"></i></button>
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>XJ9HE4</td>
                        <td>Test num2</td>
                        <td>AH0453</td>
                        <td>16 Oct 2024</td>
                        <td>12A</td>
                        <td><span class="status pending">Pending</span></td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-eye"></i></button>
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>XJ9HE4</td>
                        <td>Test num3</td>
                        <td>AH0633</td>
                        <td>16 Oct 2024</td>
                        <td>12A</td>
                        <td><span class="status pending">Pending</span></td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-eye"></i></button>
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>XJ9HE4</td>
                        <td>Test num4</td>
                        <td>AH0443</td>
                        <td>16 Oct 2024</td>
                        <td>12A</td>
                        <td><span class="status cancelled">Cancelled</span></td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-eye"></i></button>
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>