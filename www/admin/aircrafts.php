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
    <script src="/static/js/search.js"></script>
    <title>Aircraft Management</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main>
        <div class="content">
            <div class="dams-head">
                <h1>Aircraft Management</h1>
                <button class="btn add-btn">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <div class="search-container">
                <h2 class="recent">Fleet Overview</h2>
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
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id="tablebody">
                        <tr>
                            <td>AC001</td>
                            <td>Boeing 737-800</td>
                            <td>7T-VKA</td>
                            <td>15&nbsp;Jan&nbsp;2018</td>
                            <td>189</td>
                            <td><span class="status Active">Active</span></td>
                            <td>
                                <div class="options">
                                    <button class="option"><i class="fa fa-eye"></i></button>
                                    <button class="option"><i class="fa fa-edit"></i></button>
                                    <button class="option"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>AC002</td>
                            <td>Airbus A330-200</td>
                            <td>7T-VJV</td>
                            <td>22&nbsp;Mar&nbsp;2019</td>
                            <td>260</td>
                            <td><span class="status Maintenance">Maintenance</span></td>
                            <td>
                                <div class="options">
                                    <button class="option"><i class="fa fa-eye"></i></button>
                                    <button class="option"><i class="fa fa-edit"></i></button>
                                    <button class="option"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>AC003</td>
                            <td>Boeing 787-9</td>
                            <td>7T-VKP</td>
                            <td>10&nbsp;Jun&nbsp;2020</td>
                            <td>290</td>
                            <td><span class="status Retired">Retired</span></td>
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
        </div>
    </main>
    <div class="form-overlay" id="overlay">
        <form class="dams-add-form" id="AddForm">
            <h2 id="title">Add New Aircraft</h2>
            
            <label for="model">Aircraft Model: </label>
            <input type="text" name="model" id="model" placeholder="e.g. Boeing 737-800" required>
            
            <label for="registration">Registration Number: </label>
            <input type="text" name="registration" id="registration" placeholder="e.g. 7T-VKA" required>
            
            <label for="service-date">Service Entry Date: </label>
            <input type="date" name="service-date" id="service-date" required>
            
            <label for="capacity">Capacity (Passengers): </label>
            <input type="number" name="capacity" id="capacity" min="1" placeholder="e.g. 189" required>
            
            <label for="status">Status: </label>
            <select id="status" name="status" required>
                <option value="Active">Active</option>
                <option value="Maintenance">Maintenance</option>
                <option value="Retired">Retired</option>
            </select>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn" id="submit-btn">Add Aircraft</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>
    <script src="/static/js/form.js"></script>
    <script src="/static/js/aircraft.js"></script>
    <button class="floating-button" id="menu-btn"><i class="fa fa-bars"></i> <i class="fa fa-close hidden"></i></button>
</body>

<script>
    const table = document.getElementById("search-table");
    const searchBar = document.getElementById("search-bar");
    searchBar.addEventListener("keyup", () => {
        search();
    }, false);
</script>

</html>