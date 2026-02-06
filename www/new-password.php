<?php
session_start();
include "internal/db_config.php";

if (!isset($_SESSION["reset_uid"])) {
    header("Location: forgot-password.php");
    exit();
}
$error = "";
if (isset($_SESSION["error"])) {
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);
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

    unset($_SESSION["reset_uid"]);
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
        <?php if ($error): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="new-password.php" method="POST" id="passwordForm">
            <label>New Password</label>
            <input type="password" name="password" id="password" required minlength="8">

            <label>Confirm Password</label>
            <input type="password" name="confirm" id="confirm" required minlength="8">

            <div id="match-error">
                Passwords do not match
            </div>

            <button type="submit">Reset Password</button>
        </form>
    </div>

    <script>
        const password = document.getElementById('password');
        const confirm = document.getElementById('confirm');
        const matchError = document.getElementById('match-error');

        function checkPasswords() {
            if (confirm.value && password.value !== confirm.value) {
                matchError.style.display = 'block';
                confirm.setCustomValidity('Passwords do not match');
            } else {
                matchError.style.display = 'none';
                confirm.setCustomValidity('');
            }
        }
        password.addEventListener('input', checkPasswords);
        confirm.addEventListener('input', checkPasswords);
    </script>

</body>

</html>