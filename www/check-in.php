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
    <script src="https://kit.fontawesome.com/d2ccabbb5f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/static/css/style.css">
    

    <title>Flight Management</title>
</head>

<body>
    <?php
    include("internal/sidebar.php");
    ?>
    <main class="content">
        <div class="dams-head">
            <h1 class="title">Check-Ins</h1>
            <button class="btn add-btn">
                <i class="fa fa-plus"></i> 
            </button>
        </div>
        
          <div class="search-container">
                    <h2 class="search-strip-title">Passengers</h2>
                    <div class="search-bar">
                        <input type="text" class="search" id="search" placeholder="Enter ID">
                        <button class="search-btn"><i class="fa fa-search"></i></button>
                      </div>
                   
        </div>
        <div class="table-container">
          <table class="dams-table">
                <thead class="dams-table-head">
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
                <tbody class="dams-table-body" id="dams-table-body">
                    <tr>
                        <td>Ahmed Benbella</td>
                        <td>AH1432</td>
                        <td>20/12/20205</td>
                        <td>ALG-DAAG</td>
                        <td>ORN-DAOO</td>
                        <td><span class="status confirmed">Done</span></td>
                        <td>
                            <button class="option">
                            <i class="fa-solid fa-user-check"></i>
                            </button>
                         </td>
 
                            
                        
                    </tr>
                    <tr>
                        <td>Ahmed Benbella</td>
                        <td>AH1432</td>
                        <td>20/12/20205</td>
                        <td>ALG-DAAG</td>
                        <td>ORN-DAOO</td>
                        <td><span class="status confirmed">Done</span></td>
                        <td>
                            <div class="options">
                            <button class="option">
                            <i class="fa-solid fa-user-check"></i>
                            </button>
                            </div>
                        </td>
 
                            
                        
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

     <div class="form-overlay" id="overlay">
        <form class="dams-add-form" id="BookingForm">
            <h2 id="title">Add A New Passenger For Check-In</h2>
            <div class="name-container">
                <label for="First_Name">First Name: </label>
                <input type="text" name="First_Name" id="fn" required>
                <label for="Last">Last Name: </label>
                <input type="text" name="Last" id="ln" required>
            </div>
            <label for="Flight-Num">Flight Number: </label>
            <input type="text" name="Flight-Num" id="flight_n" required>
            <label for="date">Departure Date: </label>
            <input type="date" name="date" id="date" required>
            <label for="deparature">Departure: </label>
            <input type="text" name="departure" id="departure" >
            <label for="destination">Destination: </label>
            <input type="text" name="destination" id="destination" required>
            <label for="status">Status: </label>
            <select id="status" name="status" value="Waiting" disabled>
                <option value="waiting">Waiting</option>
                <option value="done">Done</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <div class="form-actions">
                <button type="submit" class="submit-btn" id="submit-btn">Add Passenger</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>
    <script src="/static/js/form.js"></script>
    <script src="/static/js/check-in.js"></script>

</body>

</html>

<!--
to implement in the future :
add button interactiveness
checki-in button interactivness
when status=Done Check in action appear in grey or disappear or change to UnCheck

-->