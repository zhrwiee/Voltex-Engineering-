<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voltexengineering";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
global $conn;
?>