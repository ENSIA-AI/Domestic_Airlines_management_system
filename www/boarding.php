<?php
include("internal/session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/d2ccabbb5f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/boarding.css">
    <script src="/static/js/search.js"></script>
    

    <title>Boarding Management</title>
</head>

<body>
    <?php
    include("internal/sidebar.php");
    ?>
    <main class="content">
        <div class="dams-head">
            <h1 class="title">Boarding & Gates</h1>
      
        </div>
        
          <div class="search-container">
                    <h2 class="search-strip-title">Flights</h2>
                    <div class="search-bar">
                        <input type="text" class="search" id="search-bar" placeholder="Search">
                        <button class="search-btn"><i class="fa fa-search"></i></button>
                      </div>
                   
        </div>
        <div class="table-container">
          <table class="dams-table" id="search-table">
                <thead class="dams-table-head">
                    <tr>
                        <th>ID</th>
                        <th>Dep Gate</th>
                        <th>Arr Gate</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Countdown</th>
                        <th>Total</th>
                        <th>Show</th>
                    </tr>
                </thead>
                <tbody class="dams-table-body" id="dams-table-body">
                    <tr class="parent-row">
                        <td>AH0001</td>
                        <td>A1</td>
                        <td>B1</td>
                        <td>20 Dec 2025</td>
                        <td>18:00</td>
                        <td class="countdown">Countdown</td>
                        <td>66</td>
                        <td>
                            <button class="option">
                            <i class="fa-solid fa-circle-chevron-down"></i>
                            </button>
                         </td>
                    </tr>
                        <tr class="childrow headchildrow">
                          <td class="dummy-td"></td>
                          <td>Name</td>
                          <td>Phone</td>
                          <td>Gender</td>
                          <td>Nationality</td>
                          <td>State</td>
                          
                          <td class="dummy-td"></td>
                         
                        </tr>
                        <tr class="childrow"> 
                          <td class="dummy-td"></td>
                          <td>Ahmed Djoum</td>
                          <td>0609808480</td>
                          <td>Male</td>
                          <td>Algerian</td>
                          <td> <span class="arrival-state on-plane">On Plane</span></td>
                          <td class="dummy-td"></td> 
                        <tr>
                        <tr class="childrow"> 
                          <td class="dummy-td"></td>
                          <td>Ahmed Djoum</td>
                          <td>0609808480</td>
                          <td>Male</td>
                          <td>Algerian</td>
                          <td> <span class="arrival-state on-plane">On Plane</span></td>
                          <td class="dummy-td"></td>
                          
                        <tr>
                        <tr class="childrow"> 
                          <td class="dummy-td"></td>
                          <td>Ahmed Djoum</td>
                          <td>0609808480</td>
                          <td>Male</td>
                          <td>Algerian</td>
                          <td> <span class="arrival-state on-plane">On Plane</span></td>
                          <td class="dummy-td"></td>
                          
                        <tr>

                    <tr class="parent-row">
                        <td>AH0001</td>
                        <td>A1</td>
                        <td>A1</td>
                        <td>20 Dec 2025</td>
                        <td>18:00</td>
                        <td class="countdown">Countdown</td>
                        <td>66</td>
                        <td>
                            <button class="option">
                            <i class="fa-solid fa-circle-chevron-down"></i>
                            </button>
                         </td>
                    </tr>
                        <tr class="childrow headchildrow">
                          <td class="dummy-td"></td>
                          <td>Name</td>
                          <td>Phone</td>
                          <td>Gender</td>
                          <td>Nationality</td>
                          <td>State</td>
                          
                          <td class="dummy-td"></td>
                         
                        </tr>
                        <tr class="childrow"> 
                          <td class="dummy-td"></td>
                          <td>Ahmed Djoum</td>
                          <td>0609808480</td>
                          <td>Male</td>
                          <td>Algerian</td>
                          <td> <span class="arrival-state on-plane">On Plane</span></td>
                          <td class="dummy-td"></td> 
                        <tr>
                        <tr class="childrow"> 
                          <td class="dummy-td"></td>
                          <td>Ahmed Djoum</td>
                          <td>0609808480</td>
                          <td>Male</td>
                          <td>Algerian</td>
                          <td> <span class="arrival-state on-plane">On Plane</span></td>
                          <td class="dummy-td"></td>
                          
                        <tr>
                        <tr class="childrow"> 
                          <td class="dummy-td"></td>
                          <td>Ahmed Djoum</td>
                          <td>0609808480</td>
                          <td>Male</td>
                          <td>Algerian</td>
                          <td> <span class="arrival-state on-plane">On Plane</span></td>
                          <td class="dummy-td"></td>
                          
                        <tr>
       
                </tbody>
            </table>
        </div>
    </main>


    <script src="/static/js/boarding.js"></script>

</body>

<script>
    const table = document.getElementById("search-table");
    const searchBar = document.getElementById("search-bar");
    searchBar.addEventListener("keyup", () => {
        search("search-table");
    }, false);
</script>

</html>

