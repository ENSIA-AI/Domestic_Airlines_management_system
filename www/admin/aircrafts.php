<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/aircraft.css">
    <script src="/static/js/search.js"></script>
    <title>Aircraft Management</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main class="content">
        <div class="dams-head">
            <h1 class="title">Aircraft Management</h1>
            <button class="btn add-btn">
                <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="search-container">
            <h2>Aircafts Table</h2>
            <div class="search-bar"><input type="text" class="search" id="search-bar" placeholder="Search">
                <button class="search-btn"><i class="fa fa-search"></i></button>
            </div>
        </div>

        <div class="table-container">
            <table class="dams-table" id="search-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Model</th>
                        <th>Registration Number</th>
                        <th>Service Entry Date</th>
                        <th>Capcity</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody class="aircraftsTbBody">
                    <tr>
                        <td>XJ9HE4</td>
                        <td>Test num1</td>
                        <td>AH1432</td>
                        <td>16 Oct 2024</td>
                        <td>12A</td>
                        <td><span class="status confirmed">Confirmed</span></td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>XJ9HE4</td>
                        <td>Test num2</td>
                        <td>AH0453</td>
                        <td>16 Oct 2024</td>
                        <td>12A</td>
                        <td><span class="status pending">Pending</span></td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>XJ9HE4</td>
                        <td>Test num3</td>
                        <td>AH0633</td>
                        <td>16 Oct 2024</td>
                        <td>12A</td>
                        <td><span class="status pending">Pending</span></td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>XJ9HE4</td>
                        <td>Test num4</td>
                        <td>AH0443</td>
                        <td>16 Oct 2024</td>
                        <td>12A</td>
                        <td><span class="status cancelled">Cancelled</span></td>
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
    searchBar.addEventListener("keyup", () => { search(); }, false);
</script>

</html>