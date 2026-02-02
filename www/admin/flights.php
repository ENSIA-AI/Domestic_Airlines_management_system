<?php
include("../internal/session.php");
include "../internal/db_config.php";
$select_flights_query = 'SELECT * FROM FLIGHTS';
$flights_result = mysqli_query($conn, $select_flights_query);
$flights = mysqli_fetch_all($flights_result, MYSQLI_ASSOC);

$select_airports_query = 'SELECT * FROM AIRPORTS';
$airports_result = mysqli_query($conn, $select_airports_query);
$airports = mysqli_fetch_all($airports_result, MYSQLI_ASSOC);

$select_aircrafts_query = 'SELECT * FROM AIRCRAFTS';
$aircrafts_result = mysqli_query($conn, $select_aircrafts_query);
$aircrafts = mysqli_fetch_all($aircrafts_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    
    <script src="/static/js/search.js"></script>
    <title>Flight Management</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main class="content">
        <div class="dams-head">
            <h1 class="title">Flight Management</h1>
            <button class="btn add-btn">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <div class="flights-preview">
            <div class="search-container">
                <h2 class="recent">Flights Table</h2>
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
                            <th>Departure</th>
                            <th>Destination</th>
                            <th>Date</th>
                            <th>Aircraft</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody  id="tablebody">
                        <?php foreach ($flights as $flight): ?>
                        <tr>
                            <td><?php echo $flight['FLIGHT_NUMBER']  ?></td>
                            <td><?php echo $flight['DEP_AIRPORT'] ?></td>
                            <td><?php echo $flight['ARR_AIRPORT'] ?></td>
                            <td><?php echo $flight['DEPARTURE_TIME'] ?></td>
                            <td><?php echo $flight['AIRCRAFT'] ?></td>
                            <td>
                                <span class="status <?php echo ucwords(strtolower($flight['STATUS'])) ?> ">
                                    <?php echo ucwords(strtolower($flight['STATUS']))  ?>
                                </span>
                            </td>
                            <td>
                                <div class="options">
                                    <button class="option"><i class="fa fa-eye"></i></button>
                                    <button class="option"><i class="fa fa-edit"></i></button>
                                    <button class="option"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
    

                    </tbody>
                </table>
            </div>
        </div>

    </main>
    <div class="form-overlay" id="overlay">
        <form class="dams-add-form" id="AddForm">
            <h2 id="title">Add New Flight</h2>



            <label for="DEP">Departure: </label>
            <select name="DEP" id="DEP" required>
                <?php foreach($airports as $airport): ?>
                    <option value="<?php echo $airport['IATA_CODE']?>"><?php echo $airport['IATA_CODE'] ?></option>
                <?php endforeach?>
            </select>

            <label for="DEST">Destination: </label>
            <select name="DEST" id="DEST" required>
                <?php foreach($airports as $airport): ?>
                    <option value="<?php echo $airport['IATA_CODE']?>"><?php echo $airport['IATA_CODE'] ?></option>
                <?php endforeach?>
            </select>


            <label for="AC">Aircraft: </label>
            <select name="AC" id="AC">
                <?php foreach($aircrafts as $aircraft): ?>
                    <option value="<?php echo $aircraft['AIRCRAFT_REGISTRATION'] ?>"><?php echo $aircraft['AIRCRAFT_REGISTRATION'] ?></option>
                <?php endforeach ?>
            </select>

            <label for="DATE">Departure Date: </label>
            <input type="datetime-local" name="DATE" id="DATE" required>

            <label for="STATUS">Status: </label>
            <select id="STATUS" name="STATUS" required>
                <option value="scheduled">Scheduled</option>
                <option value="delayed">Delayed</option>
                <option value="canceled" disabled>Canceled</option>
                <option value="arrived" disabled>Arrived</option>
            </select>

            <div class="form-actions">
                <button type="submit" class="submit-btn" id="submit-btn">Add Flight</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </div>

        </form>
        </div>

        <button class="floating-button" id="menu-btn"><i class="fa fa-bars"></i> <i
                class="fa fa-close hidden"></i></button>

        <script src="/static/js/form.js"></script>
        <script src="/static/js/flights.js"></script>

</body>

<script>
    const table = document.getElementById("search-table");
    const searchBar = document.getElementById("search-bar");
    searchBar.addEventListener("keyup", () => {
        search();
    }, false);
</script>

</html>