<?php
//home server info

//webserv
$servername = "localhost";
$username = "x";
$password = "x";
$db = "x";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
