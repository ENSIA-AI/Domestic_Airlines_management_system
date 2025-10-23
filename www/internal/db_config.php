<?php
$servername = "127.0.0.1";
$username = "domestic_airlines_website";
$password = "jS8@j%n6nsj#q3";
$dbname = "domesticdb";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
