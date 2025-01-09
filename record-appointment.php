<?php
include('connect-server.php');

if (isset($_POST['selectedDay']) && isset($_POST['time'])) {
    $selectedDay = $_POST['selectedDay'];
    $time = $_POST['time'];

    // Convert the date format to YYYY-MM-DD
    $selectedDay = date('Y-m-d', strtotime($selectedDay));

    $query = "INSERT INTO appointments (date, time_slot, is_booked) VALUES ('$selectedDay', '$time', 1)";

    $result = $conn->query($query);

    if ($result) {
        echo 'Booking successful';
    } else {
        echo 'Booking failed: ' . $conn->error;
    }
} else {
    echo 'Error: Parameters not set';
}

$conn->close();
?>
