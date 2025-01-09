<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "voltexengineering";

$connection = new mysqli($host, $username, $password, $database);

$selectedDate = $_POST['selectedDate'];
$selectedTime = $_POST['selectedTime'];

$availabilityQuery = "SELECT COUNT(*) FROM bookings WHERE date = '$selectedDate' AND time = '$selectedTime'";
$result = mysqli_query($connection, $availabilityQuery);

$isAvailable = (mysqli_fetch_row($result)[0] == 0);

echo json_encode(array('isAvailable' => $isAvailable));

mysqli_close($connection);
?>
