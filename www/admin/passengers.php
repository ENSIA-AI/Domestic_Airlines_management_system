<?php
include("../internal/session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <script src="/static/js/search.js"></script>
    <title>Passenger Management</title>
</head>

<body>
    <?php include("../internal/sidebar.php"); ?>
    <main class="content">
        <div class="dams-head">
            <h1 class="title">Passenger Management</h1>
            <button class="btn add-btn" id="add-passenger-btn">
                <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="search-container">
            <h2 class="recent">Passenger List</h2>
            <div class="search-bar">
                <input type="text" class="search" id="search-bar" placeholder="Search passengers">
                <button class="search-btn"><i class="fa fa-search"></i></button>
            </div>
        </div>
        <div class="table-container">
            <table class="dams-table" id="search-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID/Passport Number</th>
                        <th>Passenger Name</th>
                        <th>Phone</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>Options</th>
                    </tr>
                </thead>
            </table>
            <div class="spinner-container">
                <div class="spinner"></div>
                Loading...
            </div>
        </div>
    </main>
    <div class="form-overlay" id="overlay">
        <form class="dams-add-form" id="AddForm">
            <h2 id="form-title">Add New Passenger</h2>
            <input type="hidden" name="type" id="form-type" value="ADD">
            <input type="hidden" name="passenger_num" id="passenger_num" value="">

            <label for="id_type">ID Type: </label>
            <select name="id_type" id="id_type" required>
                <option value="ID_CARD">ID Card</option>
                <option value="PASSPORT">Passport</option>
            </select>

            <label for="id_num">ID/Passport Number (numbers only): </label>
            <input type="text" name="id_num" id="id_num" placeholder="e.g., 12345601 or 56789012" required>
            <div class="name-container">
                <div>
                    <label for="first_name">First Name: </label>
                    <input type="text" name="first_name" id="first_name" required>
                </div>
                <div>
                    <label for="middle_name">Middle Name: </label>
                    <input type="text" name="middle_name" id="middle_name">
                </div>
            </div>

            <label for="last_name">Last Name: </label>
            <input type="text" name="last_name" id="last_name" required>

            <label for="phone">Phone Number: </label>
            <input type="tel" name="phone" id="phone" pattern="[+]?[0-9]{10,15}" required>

            <label for="email">Email: </label>
            <input type="email" name="email" id="email" required>
            <label for="gender">Gender: </label>
            <select name="gender" id="gender" required>
                <option value="MALE">Male</option>
                <option value="FEMALE">Female</option>
            </select>
            <label for="nationality">Nationality: </label>
            <input type="text" name="nationality" id="nationality" value="Algeria" required>
            <label for="date_of_birth">Date of Birth: </label>
            <input type="date" name="date_of_birth" id="date_of_birth" required>
            <div class="form-actions">
                <button type="button" class="submit-btn" id="submit-btn">Add Passenger</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>
    <div class="view-modal" id="view-modal">
        <div class="view-content">
            <h2>Passenger Details</h2>
            <div class="view-row">
                <div class="view-label">Passenger ID:</div>
                <div class="view-value" id="view-passenger-id"></div>
            </div>
            <div class="view-row">
                <div class="view-label">ID Type:</div>
                <div class="view-value" id="view-id-type"></div>
            </div>
            <div class="view-row">
                <div class="view-label">ID/Passport Number:</div>
                <div class="view-value" id="view-id-num"></div>
            </div>
            <div class="view-row">
                <div class="view-label">Full Name:</div>
                <div class="view-value" id="view-full-name"></div>
            </div>
            <div class="view-row">
                <div class="view-label">Phone:</div>
                <div class="view-value" id="view-phone"></div>
            </div>
            <div class="view-row">
                <div class="view-label">Email:</div>
                <div class="view-value" id="view-email"></div>
            </div>
            <div class="view-row">
                <div class="view-label">Date of Birth:</div>
                <div class="view-value" id="view-dob"></div>
            </div>
            <div class="view-row">
                <div class="view-label">Gender:</div>
                <div class="view-value" id="view-gender"></div>
            </div>
            <div class="view-row">
                <div class="view-label">Nationality:</div>
                <div class="view-value" id="view-nationality"></div>
            </div>
            <button id="close-view-btn" class="close-view-btn">Close</button>
        </div>
    </div>
    <script src="/static/js/form.js"></script>
    <script src="/static/js/passenger.js"></script>
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