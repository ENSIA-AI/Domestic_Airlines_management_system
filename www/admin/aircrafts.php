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
    <title>Aircafts Management</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main>
        <div class="content">
            <div class="dams-head">
                <h1>Aircaft Management</h1>
                <button class="btn add-btn">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <div class="search-container">
                <h2 class="recent">Aircafts</h2>
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
                    <tbody id="tablebody">
                        <tr>
                            <td>XJ9HE4</td>
                            <td>Test num1</td>
                            <td>AH1432</td>
                            <td>16&nbsp;Oct&nbsp;2024</td>
                            <td>Business</td>
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
                            <td>EK7BE4</td>
                            <td>raouf Ould Ali</td>
                            <td>AH1332</td>
                            <td>16&nbsp;Oct&nbsp;2024</td>
                            <td>Business</td>
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
                            <td>KE44JD</td>
                            <td>name last</td>
                            <td>AH0443</td>
                            <td>16&nbsp;Oct&nbsp;2024</td>
                            <td>Business</td>
                            <td><span class="status Retired">Cancelled</span></td>
                            <td>
                                <div class="options">
                                    <button class="option"><i class="fa fa-eye"></i></button>
                                    <button class="option"><i class="fa fa-edit"></i></button>
                                    <button class="option"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>                        <tr>
                            <td>KE44JD</td>
                            <td>name last</td>
                            <td>AH0443</td>
                            <td>16&nbsp;Oct&nbsp;2024</td>
                            <td>Business</td>
                            <td><span class="status Out">Out of Service</span></td>
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
    <!--just from here-->
<!--just from here-->
<div class="form-overlay" id="overlay">
    <form class="dams-add-form" id="AddForm">
        <h2 id="title">Add New Aircraft</h2>

        <label for="Aircraft_Id">Aircraft ID: </label>
        <input type="text" name="Aircraft_Id" id="aircraft_id" required>

        <label for="Model">Model: </label>
        <input type="text" name="Model" id="model" required>

        <label for="Registration_Number">Registration Number: </label>
        <input type="text" name="Registration_Number" id="reg_num" required>

        <label for="Service_Entry_Date">Service Entry Date: </label>
        <input type="date" name="Service_Entry_Date" id="service_date" required>

        <label for="Capacity">Capacity: </label>
        <select name="Capacity" id="capacity" required>
            <option value="Economy">Economy</option>
            <option value="Business">Business</option>
            <option value="Premium">Premium</option>
        </select>

        <label for="Status">Status: </label>
        <select id="status" name="Status" required>
            <option value="Active">Active</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Cancelled">Cancelled</option>
            <option value="Out">Out of Service</option>
        </select>

        <div class="form-actions">
            <button type="submit" class="submit-btn" id="submit-btn">Add Aircraft</button>
            <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
        </div>
    </form>
</div>
<!--to here-->
    <!--to here-->
    <script src="/static/js/form.js"></script>
    <script src="/static/js/booking.js"></script>
    <button class="floating-button" id="menu-btn"><i class="fa fa-bars"></i> <i class="fa fa-close hidden"></i></button>
</body>

<script>
    const searchBar = document.getElementById("search-bar");
    searchBar.addEventListener("keyup", () => {
        search();
    }, false);
</script>

</html>