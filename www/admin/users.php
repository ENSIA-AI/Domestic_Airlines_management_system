<?php
include("../internal/session.php");
include("../internal/db_config.php");

$ROLE = $_SESSION['ROLE'];
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
<?php include("../internal/sidebar.php"); ?>

<main>
    <div class="content">
        <div class="dams-head">
            <h1>Users Management</h1>

            <button class="btn add-btn" id="add-user-btn" <?php if($ROLE != "admin") echo "disabled"; ?>>
                <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="search-container">
            <h2 class="recent">System Users</h2>
            <div class="search-bar">
                <input type="text" class="search" id="search-bar" placeholder="Search">
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
</main>

<div class="form-overlay" id="overlay">
    <form class="dams-add-form" id="user-form">
        <h2 id="form-title">Add New User</h2>
        <input type="hidden" name="type" id="form-type" value="ADD">
        <input type="hidden" name="userId" id="userId">

        <label for="fullname">Full Name: </label>
        <input type="text" name="fullname" id="fullname" placeholder="FULL NAME" required>

        <label for="username">Username: </label>
        <input type="text" name="username" id="username" placeholder="Username" required>

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

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <div class="form-actions">
            <button type="button" class="submit-btn" id="submit-btn">Submit</button>
            <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
        </div>
    </form>
</div>

<div class="view-modal" id="view-modal">
    <div class="view-content">
        <h2>User Details</h2>
        <div class="view-row"><div class="view-label">User ID:</div><div class="view-value" id="view-user-id"></div></div>
        <div class="view-row"><div class="view-label">Full Name:</div><div class="view-value" id="view-full-name"></div></div>
        <div class="view-row"><div class="view-label">Username:</div><div class="view-value" id="view-username"></div></div>
        <div class="view-row"><div class="view-label">Email:</div><div class="view-value" id="view-email"></div></div>
        <div class="view-row"><div class="view-label">Role:</div><div class="view-value" id="view-role"></div></div>
        <div class="view-row"><div class="view-label">Status:</div><div class="view-value" id="view-status"></div></div>
        <div class="view-row"><div class="view-label">Date Created:</div><div class="view-value" id="view-date"></div></div>
        <button id="close-view-btn" class="close-view-btn">Close</button>
    </div>
</div>

<script src="/static/js/form.js"></script>
<script src="/static/js/users.js"></script>
<button class="floating-button" id="menu-btn"><i class="fa fa-bars"></i> <i class="fa fa-close hidden"></i></button>

<script>
const table = document.getElementById("search-table");
const searchBar = document.getElementById("search-bar");
searchBar.addEventListener("keyup", () => search(), false);

//fix problems
document.getElementById("add-user-btn").addEventListener("click", () => {
    const form = document.getElementById("user-form");
    form.reset();
    
    // Reset form state to ADD mode
    document.getElementById("form-title").textContent = "Add New User";
    document.getElementById("form-type").value = "ADD";
    document.getElementById("userId").value = "";
    document.getElementById("password").required = true; 
    
    // Open the overlay
    document.getElementById("overlay").classList.add("active");
});


document.getElementById("cancel-btn").addEventListener("click", () => {
    document.getElementById("overlay").classList.remove("active");
});

function deleteUser(userId){
    if("<?= $ROLE ?>" != "admin") return alert("You are not allowed!");
    if(confirm("Do you really want to delete user "+userId+"?")){
        const formData = new FormData();
        formData.append("type","DEL");
        formData.append("userId",userId);
        fetch("backend/users.php",{method:"POST",body:formData})
        .then(()=>updateTable())
        .catch(e=>{console.log(e); alert("Error deleting user");});
    }
}


function updateTable(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState==4 && this.status==200){
            document.getElementsByClassName("table-container")[0].innerHTML = this.responseText;
            setupViewButtons();
            setupEditButtons();
        }
    }
    xhr.open("GET","backend/users.php",true);
    xhr.send();
}
updateTable();

//  ADD / EDIT USER BUTTON
document.getElementById("submit-btn").addEventListener("click", ()=>{
    if("<?= $ROLE ?>" != "admin") return alert("You are not allowed!");
    const form = document.getElementById("user-form");
    const formData = new FormData(form);
    fetch("backend/users.php",{method:"POST",body:formData})
    .then(res=>res.json())
    .then(()=>{updateTable(); form.reset(); document.getElementById("overlay").classList.remove("active");})
    .catch(e=>{console.log(e); alert("Error adding/updating user");});
});

//  VIEW MODAL SETUP
function setupViewButtons(){
    const viewBtns = document.querySelectorAll(".view-btn");
    const modal = document.getElementById("view-modal");
    const closeBtn = document.getElementById("close-view-btn");
    viewBtns.forEach(btn=>{
        btn.onclick = function(){
            const uid = btn.dataset.userId;
            fetch("backend/users.php?view="+uid)
            .then(res=>res.json())
            .then(user=>{
                document.getElementById("view-user-id").textContent = user.UID;
                document.getElementById("view-full-name").textContent = user.FULL_NAME;
                document.getElementById("view-username").textContent = user.USER_NAME;
                document.getElementById("view-email").textContent = user.EMAIL;
                document.getElementById("view-role").textContent = user.ROLE;
                document.getElementById("view-status").textContent = user.STATUS==1?"Active":"Inactive";
                document.getElementById("view-date").textContent = user.DATE;
                modal.classList.add("active");
            });
        }
    });
    closeBtn.onclick = ()=>modal.classList.remove("active");
    modal.addEventListener("click", e=>{if(e.target===modal) modal.classList.remove("active");});
}

//  EDIT BUTTONS
function setupEditButtons() {
    const editBtns = document.querySelectorAll(".fa-edit");
    editBtns.forEach(icon => {
        const btn = icon.parentElement;
        if ("<?= $ROLE ?>" != "admin") {
            btn.style.display = "none";
        } else {
            btn.onclick = function() {
                const tr = btn.closest("tr");
                
                // 1. Change UI to Edit Mode
                document.getElementById("form-title").textContent = "Edit User: " + tr.children[1].textContent;
                document.getElementById("form-type").value = "EDIT";
                
                // 2. Fill Hidden ID
                document.getElementById("userId").value = tr.children[0].textContent;
                
                // 3. Fill Text Inputs
                document.getElementById("fullname").value = tr.children[1].textContent;
                document.getElementById("username").value = tr.children[2].textContent;
                document.getElementById("email").value = tr.children[3].textContent;
                
                // 4. Set Dropdowns (Role & Status)
                // This ensures the current value is selected by default
                document.getElementById("role").value = tr.children[4].textContent; 
                document.getElementById("status").value = (tr.children[5].textContent.trim() === "Active") ? "1" : "0";
                
                // 6. Make Password Optional for Edit
                document.getElementById("password").value = "";
                document.getElementById("password").required = false; 

                document.getElementById("overlay").classList.add("active");
            }
        }
    });
}

</script>
</html>
