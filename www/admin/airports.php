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
    <script src="/static/js/search.js"></script>
    <title>Airport Management</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main class="content">
        <div class="head_booking">
            <h1 class="title">Airport Management</h1>
            <button class="btn add-btn">
                <i class="fa fa-plus"></i> Add New
            </button>
        </div>

        <div class="reservation">
            <div class="search-part">
                <h2 class="recent">Algeria's Airports</h2>
                <div class="search-bar"><input type="text" class="search" id="search-bar" placeholder="Search">
                    <button class="search-btn"><i class="fa fa-search"></i></button>
                </div>
            </div>

            <table class="booking-table" id="search-table">
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
                <tbody>
                    <tr>
                        <td>BJA</td>
                        <td>DAAE</td>
                        <td>Bejaia</td>
                        <td>Soummam - Abane Ramdane Airport</td>
                        <td>36°42′43.1″N </td>
                        <td>5°4′10.1″E</td>
                        <td>6 m</td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>ALG</td>
                        <td>DAAG</td>
                        <td>Algiers</td>
                        <td>Houari Boumediene Airport</td>
                        <td>36°41′28″N</td>
                        <td>3°12′52″E</td>
                        <td>25 m</td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>ORN</td>
                        <td>DAOO</td>
                        <td>Oran</td>
                        <td>Ahmed Ben Bella Airport</td>
                        <td>35°37′32″N</td>
                        <td>0°36′19″W</td>
                        <td>90 m</td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>CZL</td>
                        <td>DABC</td>
                        <td>Constantine</td>
                        <td>Mohamed Boudiaf International Airport</td>
                        <td>36°16′48″N</td>
                        <td>6°37′34″E</td>
                        <td>694 m</td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>TLM</td>
                        <td>DAON</td>
                        <td>Tlemcen</td>
                        <td>Zenata – Messali El Hadj Airport</td>
                        <td>35°0′41″N</td>
                        <td>1°27′48″W</td>
                        <td>247 m</td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>GHA</td>
                        <td>DAUG</td>
                        <td>Ghardaïa</td>
                        <td>Noumérat – Moufdi Zakaria Airport</td>
                        <td>32°23′57″N</td>
                        <td>3°47′51″E</td>
                        <td>463 m</td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>TEE</td>
                        <td>DABS</td>
                        <td>Tébessa</td>
                        <td>Cheikh Larbi Tébessa Airport</td>
                        <td>35°25′18″N</td>
                        <td>8°7′32″E</td>
                        <td>813 m</td>
                        <td>
                            <div class="options">
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

<script>
    const table = document.getElementById("search-table");
    const searchBar = document.getElementById("search-bar");
    searchBar.addEventListener("keyup", ()=>{search();}, false);
</script>

</html>