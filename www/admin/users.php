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
                        <tr>
                            <td>UA001</td>
                            <td>Anes Mechkak</td>
                            <td>anesa-2007</td>
                            <td>anes2007@gmail.com</td>
                            <td>Admin</td>
                            <td><span class="status Active">Active</span></td>
                            <td>15&nbsp;Jan&nbsp;2018</td>
                            <td>
                                <div class="options">
                                    <button class="option"><i class="fa fa-eye"></i></button>
                                    <button class="option"><i class="fa fa-edit"></i></button>
                                    <button class="option"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>UA002</td>
                            <td>Samir Benkhelifa</td>
                            <td>samir.b</td>
                            <td>samir.b@airalgerie.dz</td>
                            <td>Manager</td>
                            <td><span class="status Active">Active</span></td>
                            <td>22&nbsp;Mar&nbsp;2019</td>
                            <td>
                                <div class="options">
                                    <button class="option"><i class="fa fa-eye"></i></button>
                                    <button class="option"><i class="fa fa-edit"></i></button>
                                    <button class="option"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>UA003</td>
                            <td>Linda Mokrane</td>
                            <td>linda.m</td>
                            <td>linda.m@airalgerie.dz</td>
                            <td>Employee</td>
                            <td><span class="status Retired">Inactive</span></td>
                            <td>10&nbsp;Jun&nbsp;2020</td>
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
            <h2 id="title">Add New User</h2>
            
            <label for="fullname">Full Name: </label>
            <input type="text" name="fullname" id="fullname" placeholder="FULL NAME" required>
            
            <label for="username">Username: </label>
            <input type="text" name="username" id="username" placeholder="USER name" required>
            
            <label for="email">Email: </label>
            <input type="email" name="email" id="email" placeholder="Email" required>
            
            <label for="role">Role: </label>
            <select id="role" name="role" required>
                <option value="Admin">Admin</option>
                <option value="Manager">Manager</option>
                <option value="Employee">Employee</option>
                <optio value="viewer">viewer</option>
            </select>
            
            <label for="status">Status: </label>
            <select id="status" name="status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
            
            <label for="date-created">Date Created: </label>
            <input type="date" name="date-created" id="date-created" required>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn" id="submit-btn">Add User</button>
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

</html>