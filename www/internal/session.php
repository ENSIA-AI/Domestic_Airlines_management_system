<?php
// If the user is logging out, handle it before starting the session logic
if (isset($_GET["logout"])) {
    session_start();
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
    header("Location: /login.php");
    exit();
}

// Start session
session_start();

// Security check
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== 'yes') {
    header("Location: /login.php");
    die();
}