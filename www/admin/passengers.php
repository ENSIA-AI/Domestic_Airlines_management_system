<?php
include("../internal/session.php");
include("../internal/db_config.php");

$countries_query = "SELECT COUNTRY_CODE, COUNTRY_NAME, PHONE_CODE FROM COUNTRIES ORDER BY COUNTRY_NAME";
$countries_result = $conn->query($countries_query);
$countries = [];
while ($country = $countries_result->fetch_assoc()) {
    $countries[] = $country;
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

            <label for="id_type">ID Type</label>
            <select name="id_type" id="id_type" required>
                <option value="ID_CARD">ID Card</option>
                <option value="PASSPORT">Passport</option>
            </select>

            <label for="id_num">ID/Passport Number</label>
            <input type="text" name="id_num" id="id_num" placeholder="(ex: 123456789)" required>

            <div class="name-container">
                <div>
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" pattern="[A-Za-z\s\-']{2,50}" required>
                </div>
                <div>
                    <label for="middle_name">Middle Name</label>
                    <input type="text" name="middle_name" id="middle_name" pattern="[A-Za-z\s\-']{2,50}">
                </div>
            </div>

            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" pattern="[A-Za-z\s\-']{2,50}" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="(ex: example@email.com)" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" required>

            <label for="gender">Gender</label>
            <select name="gender" id="gender" required>
                <option value="MALE">Male</option>
                <option value="FEMALE">Female</option>
            </select>

            <label for="nationality">Nationality</label>
            <select name="nationality" id="nationality" required>
                <?php foreach ($countries as $country): ?>
                    <option value="<?= $country['COUNTRY_CODE'] ?>"
                        <?= $country['COUNTRY_CODE'] === 'DZ' ? 'selected' : '' ?>><?= $country['COUNTRY_NAME'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="date_of_birth">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" min="1905-01-01" max="<?= date('Y-m-d') ?>" required>

            <label for="phone_number">Phone Number</label>
            <div class="phone-group">
                <select name="phone_country" id="phone_country" required class="phone-country">
                    <?php foreach ($countries as $country): ?>
                        <option value="<?= $country['COUNTRY_CODE'] ?>"
                            data-code="<?= $country['PHONE_CODE'] ?>"
                            <?= $country['COUNTRY_CODE'] === 'DZ' ? 'selected' : '' ?>>
                            <?= $country['COUNTRY_NAME'] ?> (<?= $country['PHONE_CODE'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="tel" name="phone_number" id="phone_number" placeholder="(ex: 0555 123 456)" class="phone-input" required>
            </div>

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
    const phoneCountry = document.getElementById("phone_country");

    function updatePhoneCode() {
        const selected = phoneCountry.options[phoneCountry.selectedIndex];
    }
    phoneCountry.addEventListener("change", updatePhoneCode);
    updatePhoneCode();
</script>

</html>