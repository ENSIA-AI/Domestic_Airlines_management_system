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
    <title>Users Management</title>
</head>

<body>
    <?php
    include("../internal/sidebar.php");
    ?>
    <main>
        <div class="content">
            <div class="dams-head">
                <h1>Users Management</h1>
                <button class="btn add-btn">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <div class="search-container">
                <h2 class="recent">System Users</h2>
                <div class="search-bar"><input type="text" class="search" id="search-bar" placeholder="Search">
                    <button class="search-btn"><i class="fa fa-search"></i></button>
                </div>
            </div>

            <div class="table-container">
                <table class="dams-table" id="search-table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Date Created</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id="tablebody">
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </main>
    <div class="form-overlay" id="overlay">
        <form class="dams-add-form">
            <h2 id="title">Add New User</h2>

            <input type="hidden" name="type" value="ADD">

            <label for="fullname">Full Name: </label>
            <input type="text" name="fullname" id="fullname" placeholder="FULL NAME" required>
            
            <label for="username">Username: </label>
            <input type="text" name="username" id="username" placeholder="USER name" required>
            
            <label for="email">Email: </label>
            <input type="email" name="email" id="email" placeholder="Email" required>
            
            <label for="role">Role: </label>
            <select id="role" name="role" required>
                <option value="Admin">Admin</option>
                <option value="Employee">Employee</option>
            </select>
            
            <label for="status">Status: </label>
            <select id="status" name="status" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>

            
            <label for="date-created">Date Created: </label>
            <input type="date" name="date-created" id="date-created" required>
            
            <label for="paasword">Password:</label>
            <input type="password" name="password" required>

            <div class="form-actions">
                <button type="button" class="submit-btn" id="submit-btn">Add User</button>
                <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>
    <script src="/static/js/form.js"></script>
    <script src="/static/js/users.js"></script>
    <button class="floating-button" id="menu-btn"><i class="fa fa-bars"></i> <i class="fa fa-close hidden"></i></button>
</body>

<script>
    const table = document.getElementById("search-table");
    const searchBar = document.getElementById("search-bar");
    searchBar.addEventListener("keyup", () => {
        search();
    }, false);
</script>


<script>
    function deleteUser(userId) {
        if (confirm(`Do you really want to delete user ${userId}?`)) {
            setTableToLoading();

            const formData = new FormData();
            formData.append('type', 'DEL');
            formData.append('userId', userId);

            fetch('backend/users.php', {
                method: 'POST',
                body: formData
            }).then((res) => {
                updateTable();
            }).catch((e) => {
                console.log(e);
                alert("Error while removing the user, please retry later.");
                updateTable();
            });
        }
    }

    function setTableToLoading() {
        document.getElementsByClassName("table-container")[0].innerHTML = `
            <table class="dams-table" id="search-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Date Created</th>
                        <th>Options</th>
                    </tr>
                </thead>
            </table>
            <div class="spinner-container">
                <div class="spinner"></div>
                Loading...
            </div>`;
    }

    function updateTable() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementsByClassName("table-container")[0].innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "backend/users.php", true);
        xmlhttp.send();
    }
    updateTable();

    document.getElementById('submit-btn').addEventListener('click', () => {
        setTableToLoading();
        const form = document.getElementsByClassName('dams-add-form')[0];
        const formData = new FormData(form);
        fetch('backend/users.php', {
            method: 'POST',
            body: formData
        }).then((res) => {
            updateTable();
            document.getElementById('overlay').classList.remove('active');
            form.reset();
        }).catch((e) => {
            console.log(e);
            alert("Error while adding the user, please retry later.");
            updateTable();
        });
    });
</script>
</html>