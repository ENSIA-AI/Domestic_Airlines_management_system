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

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

            <button class="btn add-btn" id="add-air-btn"
                <?php if($ROLE != "admin") echo "disabled"; ?>>
                <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="search-container">
            <h2 class="recent">Fleet Overview</h2>

            <div class="search-bar">
                <input type="text" class="search" id="search-bar"
                       placeholder="Search Registration/Model">
                <button class="search-btn"><i class="fa fa-search"></i></button>
            </div>
        </div>

        <div class="table-container">
            <div class="spinner-container">
                <div class="spinner"></div> Loading Fleet...
            </div>
        </div>

    </div>
</main>

<!-- ===================== FORM MODAL ===================== -->
<div class="form-overlay" id="overlay">

    <form class="dams-add-form" id="aircraft-form">

        <h2 id="form-title">Add New Aircraft</h2>

        <input type="hidden" name="type" id="form-type" value="ADD">
        <input type="hidden" name="old_reg" id="old_reg">

        <label>Registration:</label>
        <input type="text" name="reg" id="reg" required>

        <label>Constructor:</label>
        <input type="text" name="constructor" id="constructor" required>

        <label>Model:</label>
        <input type="text" name="model" id="model" required>

        <label>Delivery Year:</label>
        <input type="number" name="year" id="year"
               min="1950" max="<?=date('Y')?>"
               required>

        <label>Status:</label>
        <select name="status" id="status" required>
            <option value="active">Active</option>
            <option value="maintenance">Maintenance</option>
            <option value="out of service">Out of Service</option>
            <option value="retired">Retired</option>
        </select>

        <div class="form-actions">
            <button type="button" class="submit-btn" id="submit-btn">Submit</button>
            <button type="button" class="cancel-btn" id="cancel-btn">Cancel</button>
        </div>

    </form>
</div>


<!-- ===================== VIEW MODAL ===================== -->
<div class="view-modal" id="view-modal">
    <div class="view-content">

        <h2>Aircraft Details</h2>

        <p><b>Registration:</b> <span id="v-reg"></span></p>
        <p><b>Constructor:</b> <span id="v-cons"></span></p>
        <p><b>Model:</b> <span id="v-mod"></span></p>
        <p><b>Year:</b> <span id="v-year"></span></p>
        <p><b>Status:</b> <span id="v-status"></span></p>

        <button id="close-view-btn" class="close-view-btn">Close</button>
    </div>
</div>


<!-- ===================== JAVASCRIPT ===================== -->
<script>

const ROLE = "<?= $ROLE ?>";

// Search
document.getElementById("search-bar")
    .addEventListener("keyup", () => search("search-table"));


// Load Table
function updateTable() {
    fetch("backend/aircrafts.php")
        .then(res => res.text())
        .then(html => {
            document.querySelector(".table-container").innerHTML = html;
            setupEditButtons();
            setupViewButtons();
        });
}
updateTable();


// Open Add Form
document.getElementById("add-air-btn").onclick = () => {
    document.getElementById("aircraft-form").reset();
    document.getElementById("form-type").value = "ADD";
    document.getElementById("form-title").textContent = "Add New Aircraft";
    document.getElementById("reg").readOnly = false;
    document.getElementById("overlay").classList.add("active");
};


// Submit Form
document.getElementById("submit-btn").onclick = () => {

    if (ROLE !== "admin") return alert("Unauthorized");

    const form = document.getElementById("aircraft-form");
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const formData = new FormData(form);

    fetch("backend/aircrafts.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById("overlay").classList.remove("active");
            updateTable();
        }
    })
    .catch(err => alert("Error: " + err));
};


// Cancel Form
document.getElementById("cancel-btn").onclick = () => {
    document.getElementById("overlay").classList.remove("active");
};


// Setup Edit Buttons
function setupEditButtons() {
    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.onclick = function() {
            if (ROLE !== "admin") return alert("Unauthorized");

            const reg = this.getAttribute("data-reg");

            fetch("backend/aircrafts.php?view=" + reg)
                .then(res => res.json())
                .then(data => {
                    document.getElementById("form-type").value = "EDIT";
                    document.getElementById("form-title").textContent = "Edit Aircraft";
                    document.getElementById("old_reg").value = data.AIRCRAFT_REGISTRATION;
                    document.getElementById("reg").value = data.AIRCRAFT_REGISTRATION;
                    document.getElementById("reg").readOnly = true;
                    document.getElementById("constructor").value = data.CONSTRUCTOR;
                    document.getElementById("model").value = data.MODEL;
                    document.getElementById("year").value = data.DELIVERY_YEAR;
                    document.getElementById("status").value = data.STATUS;
                    document.getElementById("overlay").classList.add("active");
                });
        };
    });
}


// Setup View Buttons
function setupViewButtons() {
    document.querySelectorAll(".view-btn").forEach(btn => {
        btn.onclick = function() {
            const reg = this.getAttribute("data-reg");

            fetch("backend/aircrafts.php?view=" + reg)
                .then(res => res.json())
                .then(data => {
                    document.getElementById("v-reg").textContent = data.AIRCRAFT_REGISTRATION;
                    document.getElementById("v-cons").textContent = data.CONSTRUCTOR;
                    document.getElementById("v-mod").textContent = data.MODEL;
                    document.getElementById("v-year").textContent = data.DELIVERY_YEAR;
                    document.getElementById("v-status").textContent = data.STATUS;
                    document.getElementById("view-modal").classList.add("active");
                });
        };
    });
}


// Close View Modal
document.getElementById("close-view-btn").onclick = () => {
    document.getElementById("view-modal").classList.remove("active");
};


function deleteAircraft(reg) {
    if (ROLE !== "admin") return alert("Unauthorized");
    if (!confirm("Delete aircraft " + reg + "?")) return;
    const formData = new FormData();
    formData.append("type", "DEL");
    formData.append("reg", reg);
    fetch("backend/aircrafts.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            alert("Impossible to remove this plane as it has been used on a flight");
            return;
        }
        updateTable();
    })

    .catch(err => alert("Error: " + err));
}

</script>

</body>
</html>