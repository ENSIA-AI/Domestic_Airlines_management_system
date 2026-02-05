<?php
include("../internal/session.php");
include "../internal/db_config.php";

$sql_p = "SELECT PASSENGER_NUM, FIRST_NAME, LAST_NAME FROM PASSENGERS ORDER BY LAST_NAME, FIRST_NAME";
$result_passengers = $conn->query($sql_p);

$sql_ft = "SELECT FLIGHT_NUMBER, DEPARTURE_TIME FROM FLIGHTS WHERE DEPARTURE_TIME > NOW() ORDER BY DEPARTURE_TIME ASC";
$result_ft = $conn->query($sql_ft);
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
    <?php include("../internal/sidebar.php"); ?>

    <main>
        <div class="content">
            <div class="dams-head">
                <h1>Booking Management</h1>
                <button class="btn add-btn" id="add-booking-btn">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="search-container">
                <h2 class="recent">Recent Bookings</h2>
                <div class="search-bar">
                    <input type="text" class="search" id="search-bar" placeholder="Search">
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
                </table>
                <div class="spinner-container">
                    <div class="spinner"></div>
                    Loading...
                </div>
            </div>
        </div>
    </main>

    <div class="form-overlay" id="overlay">
        <form class="dams-add-form" id="AddForm">
            <h2 id="form-title">Add New Booking</h2>

            <input type="hidden" name="type" id="form-type" value="ADD">
            <input type="hidden" name="booking_id" id="booking_id" value="">

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
                <?php
                while ($f = $result_ft->fetch_assoc()):
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
                <option value="COMPLETED">Completed</option>
            </select>

            <div class="form-actions">
                <button type="button" class="submit-btn" id="submit-btn">Add Booking</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>

    <div class="view-modal" id="view-modal">
        <div class="view-content">
            <h2>Booking Details</h2>
            <div class="view-row">
                <div class="view-label">Booking ID:</div>
                <div class="view-value" id="view-booking-id"></div>
            </div>
            <div class="view-row">
                <div class="view-label">Passenger:</div>
                <div class="view-value" id="view-passenger"></div>
            </div>
            <div class="view-row">
                <div class="view-label">Flight Number:</div>
                <div class="view-value" id="view-flight"></div>
            </div>
            <div class="view-row">
                <div class="view-label">Departure:</div>
                <div class="view-value" id="view-departure"></div>
            </div>
            <div class="view-row">
                <div class="view-label">Class:</div>
                <div class="view-value" id="view-class"></div>
            </div>
            <div class="view-row">
                <div class="view-label">Phone:</div>
                <div class="view-value" id="view-phone"></div>
            </div>
            <div class="view-row">
                <div class="view-label">Status:</div>
                <div class="view-value" id="view-status"></div>
            </div>
            <button id="close-view-btn" class="close-view-btn">Close</button>
        </div>
    </div>

    <button class="floating-button" id="menu-btn"><i class="fa fa-bars"></i> <i class="fa fa-close hidden"></i></button>

    <script src="/static/js/form.js"></script>
    <script src="/static/js/booking.js"></script>
</body>
<script>
    const searchBar = document.getElementById("search-bar");
    searchBar.addEventListener("keyup", () => {
        search("search-table");
    }, false);
</script>

</html>