<?php
session_start();
if(isset($_GET["logout"])){
    unset($_SESSION['loggedin']);
}
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']):
    header("Location: /login.php");
    die();
endif;
