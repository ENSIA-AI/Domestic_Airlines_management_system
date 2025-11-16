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
                <tbody class="dams-table-body">
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
                            <button class="option">
                               <i class="fa-solid fa-user-check"></i>
                            </button>
                        </td>
 
                            
                        
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>

<!--
to implement in the future :
add button interactiveness
checki-in button interactivness
when status=Done Check in action appear in grey or disappear or change to UnCheck

-->