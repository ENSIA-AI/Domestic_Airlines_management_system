<?php
include("../../internal/session.php");
include("../../internal/db_config.php");

// Handle GET request (fetch users)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Query database
    $result = $conn->query("SELECT * FROM USERS ORDER BY UID");
    
    // Generate HTML table
    echo '<table class="dams-table" id="search-table">';
    echo '<tbody>';
    
while ($user = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $user['UID'] . '</td>';
    echo '<td>' . $user['FULL_NAME'] . '</td>';
    echo '<td>' . $user['USER_NAME'] . '</td>';
    echo '<td>' . $user['EMAIL'] . '</td>';
    echo '<td>' . $user['ROLE'] . '</td>';

    if($user['STATUS'] == 1){
        echo '<td>Active</td>';
    } else {
        echo '<td>Inactive</td>';
    }

    echo '<td>' . $user['DATE'] . '</td>';
    echo '<td>';
    echo '<div class="options">';
    echo '<button class="option"><i class="fa fa-eye"></i></button>';
    echo '<button class="option"><i class="fa fa-edit"></i></button>';
    echo '<button class="option" onclick="deleteUser(\'' . $user['UID'] . '\')"><i class="fa fa-trash"></i></button>';
    echo '</div>';
    echo '</td>';

    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    
    if ($type === 'ADD') {
        // Add new user
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $status = $_POST['status'];
        $date = $_POST['date-created'];
        $password = $_POST['password'];

        $hash = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt = $conn->prepare("INSERT INTO USERS (FULL_NAME, USER_NAME, EMAIL, ROLE, STATUS, DATE,PASSWORD) VALUES (?, ?, ?, ?, ?, ?,?)");
        $stmt->bind_param("ssssiss", $fullname, $username, $email, $role, $status, $date,$hash);
        $stmt->execute();
        
    } elseif ($type === 'DEL') {
        // Delete user
        $userId = $_POST['userId'];
        
        $stmt = $conn->prepare("DELETE FROM USERS WHERE UID = ?");
        $stmt->bind_param("s", $userId);
        $stmt->execute();
    }
    
    echo json_encode(['success' => true]);
}
?>