<?php
include("../internal/session.php");
include("../internal/db_config.php");
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
    <?php include("../internal/sidebar.php"); ?>
    <main>
        <div class="content">
            <div class="dams-head">
                <h1>Aircraft Management</h1>
                <button class="btn add-btn" id="add-aircraft-btn">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <div class="search-container">
                <h2 class="recent">Fleet Overview</h2>
                <div class="search-bar">
                    <input type="text" class="search" id="search-bar" placeholder="Search">
                    <button class="search-btn"><i class="fa fa-search"></i></button>
                </div>
            </div>

            <div class="table-container" id="table-wrapper">
                <table class="dams-table" id="search-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Model</th>
                            <th>Registration</th>
                            <th>Service Date</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id="tablebody">
                        <?php include "backend/aircrafts.php"; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="form-overlay" id="overlay">
        <form class="dams-add-form" id="AircraftForm">
            <input type="hidden" name="type" id="form_type" value="ADD">
            <input type="hidden" name="aircraft_id" id="aircraft_id">
            
            <h2 id="form-title">Add New Aircraft</h2>
            
            <label for="model">Aircraft Model:</label>
            <input type="text" name="model" id="model" required>
            
            <label for="registration">Registration Number:</label>
            <input type="text" name="registration" id="registration" required>
            
            <label for="service_date">Service Entry Date:</label>
            <input type="date" name="service_date" id="service_date" required>
            
            <label for="capacity">Capacity (Passengers):</label>
            <input type="number" name="capacity" id="capacity" min="1" required>
            
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Active">Active</option>
                <option value="Maintenance">Maintenance</option>
                <option value="Retired">Retired</option>
                <option value="Out of Service">Out of Service</option>
            </select>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn" id="submit-btn">Add Aircraft</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>

    <script src="/static/js/aircrafts.js"></script>
</body>
</html>