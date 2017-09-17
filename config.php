<?php
//home server info
/*
$servername = "localhost";
$username = "root";
$password = "";
$db = "cl";*/

//webserv
$servername = "localhost";
$username = "id2941356_root";
$password = "Root123";
$db = "id2941356_cl";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
