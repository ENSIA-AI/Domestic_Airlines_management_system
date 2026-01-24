<?php
session_start();
include __DIR__ . "/db_config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $statement = $conn->prepare("SELECT UID,PASSWORD,ROLE,STATUS FROM USERS WHERE EMAIL = ?");
    $statement->bind_param("s", $email);
    $statement->execute();
    $result = $statement->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($user["STATUS"] == 1 && $password === $user["PASSWORD"] || $user["STATUS"] == 1 && password_verify($password, $user["PASSWORD"])) {
            $_SESSION["loggedin"] = 'yes';
            $_SESSION["UID"] = $user["UID"];
            $_SESSION["ROLE"] = $user["ROLE"];
            header("Location: /");
            exit;
        } else {
            $_SESSION['login_error'] = 'Invalid credentials';
            header("Location: /login.php/#login");
            exit;
        }
    } else {
        $_SESSION['login_error'] = 'Invalid credentials';
        header("Location: /login.php/#login");
        exit;
    }
}
