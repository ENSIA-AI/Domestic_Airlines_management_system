<?php
session_start();
include __DIR__ . "/db_config.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["email"]) && isset($_POST["password"])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    
    $statement = $conn->prepare("SELECT UID,PASSWORD,ROLE,STATUS FROM USERS WHERE EMAIL = ?");
    $statement->bind_param("s", $email);
    $statement->execute();
    $result = $statement->get_result();
    
    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if ($user["STATUS"] == 1 && password_verify($password, $user["PASSWORD"]) {
            $_SESSION["loggedin"] = 'yes';
            $_SESSION["UID"] = $user["UID"];
            $_SESSION["ROLE"] = $user["ROLE"];
            
            $expire = 0;
            if (isset($_POST['remember_me']) && $_POST['remember_me'] == '1') {
                $expire = time() + (30 * 24 * 60 * 60);
            }
            
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                session_id(),
                $expire,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
            
            echo json_encode([
                'success' => true,
                'redirect' => '/'
            ]);
            exit;
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid email or password'
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email or password'
        ]);
        exit;
    }
} else {
    // Debug: show what was received
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request',
        'debug' => [
            'method' => $_SERVER['REQUEST_METHOD'],
            'email_set' => isset($_POST["email"]),
            'password_set' => isset($_POST["password"]),
            'post_data' => $_POST
        ]
    ]);
    exit;
}
?>