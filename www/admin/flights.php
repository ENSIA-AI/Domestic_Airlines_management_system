<?php
include("../internal/session.php");
include "../internal/db_config.php";


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
            <button class="btn add-btn" id="add-flight-btn">
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
                            <th>DGate</th>
                            <th>AGate</th>
                        </tr>
                    </thead>
                    <tbody  id="tablebody">

                        

                    </tbody>
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
            <h2 id="form-title">Add New Flight</h2>
            <label for="FLIGHT_NUM">Flight Number</label>
            <input type="text" name="FLIGHT_NUM" id="FLIGHT_NUM" pattern="[A-Z]{2}[0-9]{3}">

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
            <input type="datetime-local" name="DATE" step="1" id="DATE" required>

            <label for="STATUS">Status: </label>
            <select id="STATUS" name="STATUS" required>
                <option value="scheduled">Scheduled</option>
                <option value="delayed">Delayed</option>
                <option value="canceled" >Canceled</option>
                <option value="arrived" >Arrived</option>
            </select>
            <div>

            </div class="two-inputs">
                <label style="display: inline-block; margin-right :40%;">DEP Gate</label> <label style="display: inline-block;">ARR Gate</label>
            <div class="two-inputs">
                <input type="text" name="DEP_GATE" id="DEP_GATE" pattern="[A-Z][0-9]{2}"><input type="text" name="ARR_GATE" id="ARR_GATE" pattern="[A-Z][0-9]{2}">
            </div>
            
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
        search("search-table");
    }, false);
</script>

</html>