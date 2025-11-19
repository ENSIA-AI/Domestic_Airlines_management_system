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
    <title>Booking Management</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main>
        <div class="content">
            <div class="dams-head">
                <h1>Booking Management</h1>
                <button class="btn add-btn">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <div class="search-container">
                <h2 class="recent">Recent Bookings</h2>
                <div class="search-bar"><input type="text" class="search" id="search-bar" placeholder="Search">
                    <button class="search-btn"><i class="fa fa-search"></i></button>
                </div>
            </div>

            <div class="table-container">
                <table class="dams-table" id="search-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Passenger</th>
                            <th>Flight Number</th>
                            <th>Date</th>
                            <th>Class</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id="tablebody">
                        <tr>
                            <td>AB92LK</td>
                            <td>Samir Benkhelifa</td>
                            <td>AH2210</td>
                            <td>22&nbsp;Nov&nbsp;2024</td>
                            <td>Economy</td>
                            <td>0660123456</td>
                            <td><span class="status Confirmed">Confirmed</span></td>
                            <td>
                                <div class="options">
                                    <button class="option"><i class="fa fa-eye"></i></button>
                                    <button class="option"><i class="fa fa-edit"></i></button>
                                    <button class="option"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>ZL55QW</td>
                            <td>Linda Mokrane</td>
                            <td>AH0987</td>
                            <td>03&nbsp;Dec&nbsp;2024</td>
                            <td>Premium</td>
                            <td>0778456123</td>
                            <td><span class="status Pending">Pending</span></td>
                            <td>
                                <div class="options">
                                    <button class="option"><i class="fa fa-eye"></i></button>
                                    <button class="option"><i class="fa fa-edit"></i></button>
                                    <button class="option"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>TR8P21</td>
                            <td>Yacine Haddad</td>
                            <td>AH5561</td>
                            <td>11&nbsp;Jan&nbsp;2025</td>
                            <td>Business</td>
                            <td>0799023344</td>
                            <td><span class="status Cancelled">Cancelled</span></td>
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
            <h2 id="title">Add New Booking</h2>
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
            <label for="class">Class: </label>
            <select name="class" id="class" required>
                <option value="Economy">Economy</option>
                <option value="Business">Business</option>
                <option value="Premium">Premium</option>
            </select>
            <label for="Email">Email: </label>
            <input type="email" name="Email" id="email">
            <label for="Phone">Phone Number: </label>
            <input type="tel" id="phone" name="phone" pattern="(0[0-9]8)|(0[567][0-9]{8})">
            <label for="status">Status: </label>
            <select id="status" name="status" required>
                <option value="Confirmed">Confirmed</option>
                <option value="Pending">Pending</option>
                <option value="Cancelled">Cancelled</option>
            </select>
            <div class="form-actions">
                <button type="submit" class="submit-btn" id="submit-btn">Add Booking</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>
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