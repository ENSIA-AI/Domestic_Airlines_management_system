<?php
include("../../internal/session.php");
include("../../internal/db_config.php");

if(isset($_GET['view'])){
    $uid = $_GET['view'];
    $stmt = $conn->prepare("SELECT * FROM USERS WHERE UID=?");
    $stmt->bind_param("s",$uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    header("Content-Type: application/json");
    echo json_encode($user);
    exit();
}

if($_SERVER['REQUEST_METHOD']==='GET'){
    $result = $conn->query("SELECT * FROM USERS ORDER BY UID");
    echo '<table class="dams-table" id="search-table">';
    echo '<thead><tr><th>UID</th><th>Full Name</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Date</th><th>Options</th></tr></thead><tbody>';
    while($user=$result->fetch_assoc()){
        echo '<tr>';
        echo '<td>'.$user['UID'].'</td>';
        echo '<td>'.$user['FULL_NAME'].'</td>';
        echo '<td>'.$user['USER_NAME'].'</td>';
        echo '<td>'.$user['EMAIL'].'</td>';
        echo '<td>'.ucfirst(strtolower($user['ROLE'])).'</td>';
        echo '<td>'.($user['STATUS']==1?"Active":"Inactive").'</td>';
// strtotime converts the DB string to a timestamp, date() formats it to YYYY-MM-DD
        $cleanDate = date("Y-m-d", strtotime($user['DATE']));
        echo '<td>'.$cleanDate.'</td>';
        echo '<td><div class="options">';
        echo '<button type="button" class="option view-btn" data-user-id="'.$user['UID'].'"><i class="fa fa-eye"></i></button>';
        echo '<button class="option"><i class="fa fa-edit"></i></button>'; // ✅ Edit button placeholder
        echo '<button class="option" onclick="deleteUser(\''.$user['UID'].'\')"><i class="fa fa-trash"></i></button>';
        echo '</div></td></tr>';
    }
    echo '</tbody></table>';
}

if($_SERVER['REQUEST_METHOD']==='POST'){
    $type = $_POST['type'];
    $UID = $_POST['userId'] ?? null;

    if($type==="ADD" || $type==="EDIT"){
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $status = $_POST['status'];
        $password = $_POST['password'];
        $hash = password_hash($password,PASSWORD_BCRYPT);

        if($type==="ADD"){
            $stmt = $conn->prepare("INSERT INTO USERS(FULL_NAME,USER_NAME,EMAIL,ROLE,STATUS,DATE,PASSWORD) VALUES(?,?,?,?,?,CURRENT_TIMESTAMP(),?)");
            $stmt->bind_param("ssssis",$fullname,$username,$email,$role,$status,$hash);
            $stmt->execute();














} else if($type === "EDIT" && $UID) {
    // Collect all the fields from the form
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $role     = $_POST['role'];
    $status   = $_POST['status'];
    $password = $_POST['password'];

    if(!empty($password)) {
        // If admin typed a NEW password, hash it and update EVERYTHING
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE USERS SET FULL_NAME=?, USER_NAME=?, EMAIL=?, ROLE=?, STATUS=?, PASSWORD=? WHERE UID=?");
        $stmt->bind_param("ssssisss", $fullname, $username, $email, $role, $status, $date, $hash, $UID);
    } else {
        // If password field is EMPTY, update everything EXCEPT the password
        $stmt = $conn->prepare("UPDATE USERS SET FULL_NAME=?, USER_NAME=?, EMAIL=?, ROLE=?, STATUS=? WHERE UID=?");
        $stmt->bind_param("ssssis", $fullname, $username, $email, $role, $status, $UID);
    }
    $stmt->execute();
}











    } elseif($type==="DEL"){
        $userId = $_POST['userId'];
        $stmt = $conn->prepare("DELETE FROM USERS WHERE UID=?");
        $stmt->bind_param("s",$userId);
        $stmt->execute();
    }
    echo json_encode(["success"=>true]);
}
?>
