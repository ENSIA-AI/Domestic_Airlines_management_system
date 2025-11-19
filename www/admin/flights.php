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
                    <!-- <select class="searchFilter" id="searchFilter">
                            old search filter code"
                            <option value="id">Search by ID</option>
                            <option value="destination">Search by Destination</option>
                            <option value="date">Search by Date</option>
                            <option value="status">Search by Status</option>
                        </select> -->
                    <input type="text" class="search" id="search-bar" placeholder="Enter ID">

                    <button class="search-btn"><i class="fa fa-search"></i></button>
                </div>
            </div>
            <div class="table-container">
                <table class="dams-table">
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
                        <tr>
                            <td>AH1432</td>
                            <td>Houari Boumedien, Algiers</td>
                            <td>Rabah Bitat Airport, Annaba</td>
                            <td>16 Sep 2025</td>
                            <td>AC3894</td>
                            <td>
                                <span class="status Confirmed">Confirmed</span>
                            </td>
                            <td>
                                <div class="options">
                                    <button class="option"><i class="fa fa-eye"></i></button>
                                    <button class="option"><i class="fa fa-edit"></i></button>
                                    <button class="option"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>AH1445</td>
                            <td>Mostefa Ben Boulaid, Batna</td>
                            <td>Rabah Bitat Airport, Annaba</td>
                            <td>16 Oct 2024</td>
                            <td>AC1233</td>
                            <td>
                                <span class="status Pending">Pending</span>
                            </td>
                            <td>
                                <div class="options">
                                    <button class="option"><i class="fa fa-eye"></i></button>
                                    <button class="option"><i class="fa fa-edit"></i></button>
                                    <button class="option"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>AH1082</td>
                            <td>Houari Boumedien, Algiers</td>
                            <td>Rabah Bitat Airport, Annaba</td>
                            <td>16 Oct 2024</td>
                            <td>AC3894</td>
                            <td><span class="status Pending">Pending</span></td>
                            <td>
                                <div class="options">
                                    <button class="option"><i class="fa fa-eye"></i></button>
                                    <button class="option"><i class="fa fa-edit"></i></button>
                                    <button class="option"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>AH14632</td>
                            <td>Ahmed Ben Bella Airport, Oran</td>
                            <td>Houari Boumedien, Algiers</td>
                            <td>16 Oct 2024</td>
                            <td>AC3894</td>
                            <td>
                                <span class="status Cancelled">Cancelled</span>
                            </td>
                            <td>
                                <div class="options">
                                    <button class="option"><i class="fa fa-eye"></i></button>
                                    <button class="option"><i class="fa fa-edit"></i></button>
                                    <button class="option"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>AH8962</td>
                            <td>Houari Boumedien, Algiers</td>
                            <td>Ahmed Ben Bella Airport,Oran</td>
                            <td>16 Oct 2024</td>
                            <td>AC3894</td>
                            <td>
                                <span class="status Cancelled">Cancelled</span>
                            </td>
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
        </div>

    </main>
    <div class="form-overlay" id="overlay">
        <form class="dams-add-form" id="AddForm">
            <h2 id="title">Add New Flight</h2>



            <label for="DEP">Departure: </label>
            <input type="text" name="DEP" id="DEP" required>

            <label for="DEST">Destination: </label>
            <input type="text" name="DEST" id="DEST" required>

            <label for="AC">Aircraft: </label>
            <input type="text" name="AC" id="AC" pattern="AC[0-9]{4}">

            <label for="DATE">Departure Date: </label>
            <input type="date" name="DATE" id="DATE" required>




            <label for="STATUS">Status: </label>
            <select id="STATUS" name="STATUS" required>
                <option value="confirmed">Confirmed</option>
                <option value="pending">Pending</option>
                <option value="cancelled" disabled>Cancelled</option>
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
    const searchBar = document.getElementById("search-bar");
    searchBar.addEventListener("keyup", () => { search(); }, false);
</script>

</html>