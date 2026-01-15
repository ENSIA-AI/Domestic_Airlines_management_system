<?php
include("../internal/session.php");
include "../internal/db_config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/bookings.css">
    <script src="/static/js/search.js"></script>
    <title>Airport Management</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main class="content">
        <div class="dams-head">
            <h1 class="title">Airport Management</h1>
            <button class="btn add-btn">
                <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="search-container">
            <h2 class="recent">Algeria's Airports</h2>
            <div class="search-bar"><input type="text" class="search" id="search-bar" placeholder="Search">
                <button class="search-btn"><i class="fa fa-search"></i></button>
            </div>
        </div>

        <div class="table-container">
            <table class="dams-table" id="search-table">
                <thead>
                    <tr>
                        <th>IATA Code</th>
                        <th>ICAO Code</th>
                        <th>Wilaya</th>
                        <th>Name</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Elevation</th>
                        <th>Options</th>
                    </tr>
                </thead>
            </table>
            <div class="spinner-container">
                <div class="spinner"></div>
                Loading...
            </div>
        </div>
    </main>

    <div class="form-overlay" id="overlay">
        <form class="dams-add-form">
            <h2 id="title">Add New Airport</h2>
            <input type="hidden" name="type" value="ADD">

            <label for="IATA_CODE">IATA Code</label>
            <input type="text" name="IATA_CODE" id="iataField" pattern="[A-Z]{3}" placeholder="(ex: ALG)" required>

            <label for="ICAO_CODE">ICAO Code</label>
            <input type="text" name="ICAO_CODE" id="icaoField" pattern="[A-Z]{4}" placeholder="(ex: DAAG)" required>

            <label for="WILAYA">Wilaya</label>
            <input type="text" name="WILAYA" id="wilayaField" required placeholder="(ex: Algiers)">

            <label for="DISPLAY_NAME">Airport Name</label>
            <input type="text" name="DISPLAY_NAME" id="nameField" required>

            <label for="LATITUDE">Latitude (North is positive)</label>
            <input type="text" name="LATITUDE" id="latitudeField" pattern="(-)?[0-9]+(.[0-9]+)?" required>

            <label for="LONGITUDE">Longitude (East is positive)</label>
            <input type="text" name="LONGITUDE" id="longitudeField" pattern="(-)?[0-9]+(.[0-9]+)?" required>

            <label for="ELEVATION">Elevation (In meters)</label>
            <input type="number" name="ELEVATION" id="elevationField" required>

            <div class="form-actions">
                <button type="button" class="submit-btn" id="submit-btn">Add Airport</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>
    <script src="/static/js/form.js"></script>

    <button class="floating-button" id="menu-btn"><i class="fa fa-bars"></i> <i class="fa fa-close hidden"></i></button>
</body>

<script>
    const searchBar = document.getElementById("search-bar");
    searchBar.addEventListener("keyup", () => {
        search("search-table");
    }, false);
</script>

<script>
    function deleteAirport(airport) {
        if (confirm(`Do you really wanna delete airport ${airport} ?`)) {
            setTableToLoading();

            const formData = new FormData();
            formData.append('type', 'DEL');
            formData.append('airport', airport);

            fetch('backend/airports.php', {
                method: 'POST',
                body: formData
            }).then((res) => {
                updateTable();
            }).catch((e) => {
                console.log(e);
                alert("Error while removing the airport, please retry later.");
                updateTable();

            });
        }
    }

    function setTableToLoading() {
        document.getElementsByClassName("table-container")[0].innerHTML = `
            <table class="dams-table" id="search-table">
                <thead>
                    <tr>
                        <th>IATA Code</th>
                        <th>ICAO Code</th>
                        <th>Wilaya</th>
                        <th>Name</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Elevation</th>
                        <th>Options</th>
                    </tr>
                </thead>
            </table>
            <div class="spinner-container">
                <div class="spinner"></div>
                Loading...
            </div>`;
    }

    function updateTable() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementsByClassName("table-container")[0].innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "backend/airports.php", true);
        xmlhttp.send();
    }
    updateTable();


    document.getElementById('submit-btn').addEventListener('click', () => {
        setTableToLoading();
        const form = document.getElementsByClassName('dams-add-form')[0];
        const formData = new FormData(form);
        fetch('backend/airports.php', {
            method: 'POST',
            body: formData
        }).then((res) => {
            updateTable();
            document.getElementById('overlay').classList.remove('active');
            form.reset();
        }).catch((e) => {
            console.log(e);
            alert("Error while adding the airport, please retry later.");
            updateTable();
        });


    });
</script>

</html>