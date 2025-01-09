<?php
require_once 'connect-server.php';

if (isset($_GET['service'])) {
    $service = $_GET['service'];

    $query = "SELECT deposit FROM service_price WHERE services = '$service'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $price = $row['deposit'];

        echo json_encode(['price' => $price]);
    } else {
        echo json_encode(['price' => 0]);
    }
} else {
    echo json_encode(['price' => 0]);
}
?>
