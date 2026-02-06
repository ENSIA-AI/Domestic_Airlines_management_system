<?php
include("../../internal/session.php");
include("../../internal/db_config.php");

// 1. VIEW logic (returns JSON)
if(isset($_GET['view'])){
    $reg = $_GET['view'];
    $stmt = $conn->prepare("SELECT * FROM AIRCRAFTS WHERE AIRCRAFT_REGISTRATION = ?");
    $stmt->bind_param("s", $reg);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}

// 2. FETCH Table logic (GET)
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $result = $conn->query("SELECT * FROM AIRCRAFTS ORDER BY AIRCRAFT_REGISTRATION");
    
    echo '<table class="dams-table" id="search-table">
            <thead>
                <tr>
                    <th>Registration</th>
                    <th>Constructor</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>';
    if ($result) {
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['AIRCRAFT_REGISTRATION']}</td>
                    <td>{$row['CONSTRUCTOR']}</td>
                    <td>{$row['MODEL']}</td>
                    <td>{$row['DELIVERY_YEAR']}</td>
                    <td>
                        <div class='options'>
                            <button class='option view-btn' data-reg='{$row['AIRCRAFT_REGISTRATION']}'><i class='fa fa-eye'></i></button>
                            <button class='option'><i class='fa fa-edit'></i></button>
                            <button class='option' onclick='deleteAircraft(\"{$row['AIRCRAFT_REGISTRATION']}\")'><i class='fa fa-trash'></i></button>
                        </div>
                    </td>
                  </tr>";
        }
    }
    echo '</tbody></table>';
    exit();
}

// 3. POST Logic (ADD/EDIT/DEL)
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    header('Content-Type: application/json');
    
    $type = $_POST['type'] ?? '';
    $reg  = $_POST['reg'] ?? '';
    $cons = $_POST['constructor'] ?? '';
    $mod  = $_POST['model'] ?? '';
    $year = $_POST['year'] ?? '';

    $stmt = null;

    if($type === "ADD"){
        $stmt = $conn->prepare("INSERT INTO AIRCRAFTS (AIRCRAFT_REGISTRATION, CONSTRUCTOR, MODEL, DELIVERY_YEAR) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $reg, $cons, $mod, $year);
        
    } elseif ($type === "EDIT") {
        $old_reg = $_POST['old_reg'] ?? '';
        $stmt = $conn->prepare("UPDATE AIRCRAFTS SET CONSTRUCTOR=?, MODEL=?, DELIVERY_YEAR=? WHERE AIRCRAFT_REGISTRATION=?");
        $stmt->bind_param("ssis", $cons, $mod, $year, $old_reg);

    } elseif ($type === "DEL") {
        $stmt = $conn->prepare("DELETE FROM AIRCRAFTS WHERE AIRCRAFT_REGISTRATION=?");
        $stmt->bind_param("s", $reg);
    }

    if($stmt && $stmt->execute()){
        if($type === "DEL" && $conn->affected_rows === 0) {
            echo json_encode(["success" => false, "message" => "Aircraft not found."]);
        } else {
            echo json_encode(["success" => true]);
        }
    } else {
        // This is where Foreign Key errors are caught
        echo json_encode(["success" => false, "message" => "Database Error: " . $conn->error]);
    }
    exit();
}