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
        

          <table class="passengers-table">
                <thead >
                    <tr>
                        <th>Name</th>
                        <th>Flight</th>
                        <th>Date</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="passengers-table-body">
                    <tr>
                        <td>Ahmed Benbella</td>
                        <td>AH1432</td>
                        <td>20/12/20205</td>
                        <td>ALG-DAAG</td>
                        <td>ORN-DAOO</td>
                        <td><span class="check-in-status done">Done</span></td>
                        <td>
                            <button onclick="window.open('passenger-details.php', '_blank', 'width=800,height=700');" class="check-in-button">
                                <i class="fa fa-check"></i> Check In 
                            </button></td>
 
                            
                        
                    </tr>
                </tbody>
            </table>
    </main>

</body>

</html>

<!--
to implement in the future :
add button interactiveness
checki-in button interactivness
when status=Done Check in action appear in grey or disappear or change to UnCheck

-->