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
    <script src="/static/js/search.js"></script>
    <title>Passenger Management - Domestic Airlines</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main class="content">
        <div class="dams-head">
            <h1 class="title">Passenger Management</h1>
            <button class="btn add-btn">
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
                        <th>Passenger Name</th>
                        <th>National ID</th>
                        <th>Phone</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody class="Ptbody">
                    <tr>
                        <td>P001</td>
                        <td>Ahmed Benali</td>
                        <td>123456789012345678</td>
                        <td>0555123456</td>
                        <td>15/03/1985</td>
                        <td>Male</td>
                        <td>Algerian</td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-eye"></i></button>
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>P002</td>
                        <td>Fatima Khelifi</td>
                        <td>234567890123456789</td>
                        <td>0661234567</td>
                        <td>22/07/1990</td>
                        <td>Female</td>
                        <td>Algerian</td>
                        <td>
                            <div class="options">
                                <button class="option"><i class="fa fa-eye"></i></button>
                                <button class="option"><i class="fa fa-edit"></i></button>
                                <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>P003</td>
                        <td>Karim Meziani</td>
                        <td>345678901234567890</td>
                        <td>0770345678</td>
                        <td>08/11/1988</td>
                        <td>Male</td>
                        <td>Algerian</td>
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
    </main>
    <div class="form-overlay" id="overlay">
        <form class="dams-add-form" id="PassengerForm">
            <h2 id="title">Add New Passenger</h2>
            <div class="name-container">
                <label for="First_Name">First Name: </label>
                <input type="text" name="First_Name" id="fn" required>
                <label for="Last">Last Name: </label>
                <input type="text" name="Last" id="ln" required>
            </div>
            <label for="National_ID">National ID: </label>
            <input type="text" name="National_ID" id="national_id" pattern="[0-9]{18}" required>
            <label for="Phone">Phone Number: </label>
            <input type="tel" id="phone" name="phone" pattern="(0[0-9]8)|(0[567][0-9]{8})" required>
            <label for="date_of_birth">Date of Birth: </label>
            <input type="date" name="date_of_birth" id="dob" required>
            <label for="gender">Gender: </label>
            <select name="gender" id="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <label for="nationality">Nationality: </label>
            <select name="nationality" id="nationality" required>
                <option value="Algerian">Algerian</option>
                <option value="Foreign">Foreign / Other</option>
            </select>
            <label for="email">Email: </label>
            <input type="email" name="email" id="email">
            <div class="form-actions">
                <button type="submit" class="submit-btn" id="submit-btn">Add Passenger</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
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