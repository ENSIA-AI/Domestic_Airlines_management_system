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
    <link rel="stylesheet" href="/static/css/check-in.css">

    <title>Flight Management</title>
</head>

<body>
    <?php
    include("internal/sidebar.php");
    ?>
    <main class="content">
        <div class="head_check-in">
            <h1 class="title">Flight Management</h1>
            <button class="btn add-btn">
                <i class="fa fa-plus"></i> Add New
            </button>
        </div>
        
          <div class="search-strip">
                    <h2 class="search-strip-title">Passengers</h2>
                    <div class="search-bar">
                        <select class="searchFilter" id="searchFilter">
                            <option value="id">Search by ID</option>
                            <option value="destination">Search by Destination</option>
                            <option value="date">Search by Date</option>
                            <option value="status">Search by Status</option>
                        </select>  
                        <input type="text" class="search" id="search" placeholder="Enter ID">
                        <button class="search-btn"><i class="fa fa-search"></i></button>
                      </div>
                   
        </div>
        

          <table class="flights-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Departure</th>
                        <th>Destination</th>
                        <th>Date</th>
                        <th>Aircraft</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>AH1432</td>
                        <td>Houari Boumedien, Algiers</td>
                        <td>Rabah Bitat Airport, Annaba</td>
                        <td>16 Oct 2024</td>
                        <td>AC3894</td>
                        <td><span class="checked-in">Done</span></td>
                        <td>
    
                            </div>
                        </td>
                    </tr>
    </main>

</body>

</html>