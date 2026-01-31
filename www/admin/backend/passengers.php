<?php
session_start();
include "../../internal/db_config.php";

function display($str)
{
    if (empty($str)) return '';
    return ucwords(strtolower(str_replace('_', ' ', $str)));
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["type"])) {
    $id_type = isset($_POST["id_type"]) ? strtoupper($_POST["id_type"]) : null;
    $id_num = $_POST["id_num"];
    if ($id_type == "PASSPORT") {
        $id_num = "P" . $id_num;
    } else {
        $id_num = "ID" . $id_num;
    }
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"] ?? null;
    $last_name = $_POST["last_name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $gender = isset($_POST["gender"]) ? strtoupper($_POST["gender"]) : null;
    $nationality = $_POST["nationality"];
    $date_of_birth = $_POST["date_of_birth"];

    if ($_POST["type"] == "DEL" && isset($_POST["passenger_num"]) && is_numeric($_POST["passenger_num"])) {
        $stmt = $conn->prepare("DELETE FROM PASSENGERS WHERE PASSENGER_NUM = ?");
        $stmt->bind_param('i', $_POST["passenger_num"]);
        $stmt->execute();
    } else if ($_POST["type"] == "ADD") {
        $check = $conn->prepare("SELECT PASSENGER_NUM FROM PASSENGERS WHERE ID_NUM = ?");
        $check->bind_param("s", $id_num);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            echo "Error: A passenger with this ID already exists.";
        } else {
            $stmt = $conn->prepare("
                INSERT INTO PASSENGERS 
                (ID_TYPE, ID_NUM, FIRST_NAME, MIDDLE_NAME, LAST_NAME, PHONE, EMAIL, GENDER, NATIONALITY, DATE_OF_BIRTH)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("ssssssssss", $id_type, $id_num, $first_name, $middle_name, $last_name, $phone, $email, $gender, $nationality, $date_of_birth);
            $stmt->execute();
        }
    } else if ($_POST["type"] == "UPDATE" && isset($_POST["passenger_num"]) && is_numeric($_POST["passenger_num"])) {
        $passenger_num = $_POST["passenger_num"];
        $check = $conn->prepare("
        SELECT PASSENGER_NUM FROM PASSENGERS 
        WHERE ID_TYPE=? AND ID_NUM=? AND FIRST_NAME=? AND MIDDLE_NAME=? AND LAST_NAME=? 
        AND PHONE=? AND EMAIL=? AND GENDER=? AND NATIONALITY=? AND DATE_OF_BIRTH=?
    ");
        $check->bind_param("ssssssssss", $id_type, $id_num, $first_name, $middle_name, $last_name, $phone, $email, $gender, $nationality, $date_of_birth);
        $check->execute();
        $result = $check->get_result();
        if ($result->num_rows > 0) {
            $existing = $result->fetch_assoc();
            if ($existing["PASSENGER_NUM"] == $passenger_num) {
                echo "Error: No changes detected.";
                exit;
            }
            echo "Error: Another passenger already has identical information.";
            exit;
        }
        $stmt = $conn->prepare("
        UPDATE PASSENGERS 
        SET ID_TYPE=?, ID_NUM=?, FIRST_NAME=?, MIDDLE_NAME=?, LAST_NAME=?, 
            PHONE=?, EMAIL=?, GENDER=?, NATIONALITY=?, DATE_OF_BIRTH=?
        WHERE PASSENGER_NUM=?
    ");
        $stmt->bind_param("ssssssssssi", $id_type, $id_num, $first_name, $middle_name, $last_name, $phone, $email, $gender, $nationality, $date_of_birth, $passenger_num);
        if (!$stmt->execute()) {
            echo "Error updating passenger: " . $stmt->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET"):
?>
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
        <tbody class="dams-table-body">
            <?php
            $sql = "SELECT PASSENGER_NUM, ID_TYPE, ID_NUM, FIRST_NAME, MIDDLE_NAME, LAST_NAME, PHONE, EMAIL, GENDER, NATIONALITY, DATE_OF_BIRTH FROM PASSENGERS ORDER BY PASSENGER_NUM DESC";
            $r_passenger = $conn->query($sql);
            while ($r = $r_passenger->fetch_assoc()) {
                $dob = new DateTime($r["DATE_OF_BIRTH"]);
                $full_name = trim($r["FIRST_NAME"] . " " . $r["MIDDLE_NAME"] . " " . $r["LAST_NAME"]);
                $display_dob = $dob->format('d M Y');
                $id_display = $r["ID_TYPE"] == "PASSPORT" ?
                    str_replace("P", "P-", $r["ID_NUM"]) :
                    str_replace("ID", "ID-", $r["ID_NUM"]);
            ?>
                <tr>
                    <td><?= $r["PASSENGER_NUM"]; ?></td>
                    <td><?= $id_display; ?></td>
                    <td><?= $full_name; ?></td>
                    <td><?= $r["PHONE"] ?></td>
                    <td><?= $display_dob; ?></td>
                    <td><?= display($r["GENDER"]);  ?></td>
                    <td><?= $r["NATIONALITY"]; ?></td>
                    <td>
                        <div class="options">
                            <button class="option" onclick='viewPassenger(<?= htmlspecialchars(json_encode($r)) ?>, "<?= $display_dob ?>")'><i class="fa fa-eye"></i></button>
                            <button class="option" onclick='editPassenger(<?= json_encode($r) ?>)'><i class="fa fa-edit"></i></button>
                            <button class="option" onclick="deletePassenger(<?= $r['PASSENGER_NUM'] ?>)"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php endif; ?>