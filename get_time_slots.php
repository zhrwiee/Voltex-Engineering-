<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "voltexengineering";

$conn = new mysqli($host, $username, $password, $database);

$selectedDate = $_POST['selectedDate'];

$query = "SELECT selected_time FROM services_record WHERE selected_date = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $selectedDate);
$stmt->execute();
$result = $stmt->get_result();

$bookedSlots = [];
while($row = $result->fetch_assoc()) {
    $bookedSlots[] = $row['selected_time'];
}

echo json_encode($bookedSlots);
?>
