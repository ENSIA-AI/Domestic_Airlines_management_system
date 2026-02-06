<?php
ob_start(); 
session_start();
include_once __DIR__ . "/../../internal/db_config.php";

function jsonResponse($data){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit();
}

if (isset($_GET["view"])) {

    try {
        $reg = $_GET["view"];
        $stmt = $conn->prepare("SELECT * FROM AIRCRAFTS WHERE AIRCRAFT_REGISTRATION = ?");
        $stmt->bind_param("s", $reg);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        jsonResponse($result ?: []);
    } catch(Exception $e){
        jsonResponse(["success"=>false, "error"=>$e->getMessage()]);
    }
}



if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        $type   = $_POST["type"] ?? "";
        $reg    = $_POST["reg"] ?? "";
        $cons   = $_POST["constructor"] ?? "";
        $model  = $_POST["model"] ?? "";
        $year   = (int)($_POST["year"] ?? 0);
        $status = $_POST["status"] ?? "active";


        if ($type === "ADD") {
            
            if (!preg_match('/^[A-Z0-9]{1,2}-[A-Z0-9]{3,5}$/i', $reg)) {
                jsonResponse(["success" => false, "error" => "Registration format is invalid (Use XX-XXX)."]);
            }
            $stmt = $conn->prepare("INSERT INTO AIRCRAFTS (AIRCRAFT_REGISTRATION, CONSTRUCTOR, MODEL, DELIVERY_YEAR, STATUS) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssis", $reg, $cons, $model, $year, $status);
            if(!$stmt->execute()){
                throw new Exception($stmt->error);
            }
        }


        if ($type === "EDIT") {
            $old_reg = $_POST["old_reg"];
            $stmt = $conn->prepare("UPDATE AIRCRAFTS SET CONSTRUCTOR=?, MODEL=?, DELIVERY_YEAR=?, STATUS=? WHERE AIRCRAFT_REGISTRATION=?");
            $stmt->bind_param("ssiss", $cons, $model, $year, $status, $old_reg);
            if(!$stmt->execute()){
                throw new Exception($stmt->error);
            }
        }
    if ($type === "DEL") {

    $stmt = $conn->prepare("DELETE FROM AIRCRAFTS WHERE AIRCRAFT_REGISTRATION=?");
    $stmt->bind_param("s", $reg);
    $ok = $stmt->execute();
    if(!$ok){
        jsonResponse([
            "success"=>false,
            "error"=>"Cannot delete: aircraft is used in flights"
        ]);
    }
}
        jsonResponse(["success"=>true]);

    } catch(Exception $e){
        jsonResponse(["success"=>false, "error"=>$e->getMessage()]);
    }
}



header('Content-Type: text/html; charset=utf-8');
$result = $conn->query("SELECT * FROM AIRCRAFTS ORDER BY AIRCRAFT_REGISTRATION ASC");
echo '
<table class="dams-table" id="search-table">
<thead>
<tr>
    <th>Registration</th>
    <th>Constructor</th>
    <th>Model</th>
    <th>Year</th>
    <th>Status</th>
    <th>Options</th>
</tr>
</thead>
<tbody>
';

while ($row = $result->fetch_assoc()) {
    $reg = htmlspecialchars($row['AIRCRAFT_REGISTRATION']);
    echo "
    <tr>
        <td>{$reg}</td>
        <td>{$row['CONSTRUCTOR']}</td>
        <td>{$row['MODEL']}</td>
        <td>{$row['DELIVERY_YEAR']}</td>
        <td>{$row['STATUS']}</td>

        <td>
            <button class='option view-btn' data-reg='{$reg}'>
                <i class='fa fa-eye'></i>
            </button>

            <button class='option edit-btn' data-reg='{$reg}'>
                <i class='fa fa-edit'></i>
            </button>

            <button class='option'
                onclick='deleteAircraft(\"{$reg}\")'>
                <i class='fa fa-trash'></i>
            </button>
        </td>
    </tr>
    ";
}
echo "</tbody></table>";
