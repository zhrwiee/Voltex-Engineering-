<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "voltexengineering";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$inputData = json_decode(file_get_contents('php://input'), true);

$selectedDate = $inputData['selectedDate'];
$selectedTime = $inputData['selectedTime'];
$buildingType = $inputData['buildingType'];
$serviceType = $inputData['serviceList']; 
$addressLine1 = $inputData['address1'];
$addressLine2 = $inputData['address2'];
$postcode = $inputData['postcode'];
$city = $inputData['city'];
$state = $inputData['state'];
$userId = $inputData['user_id']; 

$stmt = $conn->prepare("INSERT INTO services_record (user_id, building_type, service_type, addressLine1, addressLine2, postcode, city, state, selected_date, selected_time, completion_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'PENDING')");
$stmt->bind_param("ssssssssss", $userId, $buildingType, $serviceType, $addressLine1, $addressLine2, $postcode, $city, $state, $selectedDate, $selectedTime);

if ($stmt->execute()) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $stmt->error;
}

error_log("Received Date: " . $selectedDate);
error_log("Received Time: " . $selectedTime);

$stmt->close();
$conn->close();
?>
