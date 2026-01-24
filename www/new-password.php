<?php
session_start();
include "internal/db_config.php";
if (!isset($_SESSION["reset_uid"])) {
    header("Location: forgot-password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uid = $_SESSION["reset_uid"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];

    if ($password !== $confirm) {
        $_SESSION["error"] = "Passwords do not match.";
        header("Location: new-password.php");
        exit();
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("
        UPDATE USERS 
        SET PASSWORD=?, RESET_TOKEN=NULL, TOKEN_EXPIRATION=NULL 
        WHERE UID=?
    ");
    $stmt->bind_param("si", $hash, $uid);
    $stmt->execute();
    $stmt->close();

    session_destroy();

    header("Location: success.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>New Password</title>
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/n-password.css">
</head>

<body>

    <div class="container">
        <h1>Create a New Password</h1>
        <form action="new-password.php" method="POST">
            <label>New Password</label>
            <input type="password" name="password" required minlength="8">
            <label>Confirm Password</label>
            <input type="password" name="confirm" required minlength="8">
            <button type="submit">Reset Password</button>
        </form>
    </div>

</body>

</html>