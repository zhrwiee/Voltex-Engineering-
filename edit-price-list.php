<?php
include 'connect-server.php';
session_start();

function function_alert($message) {
    echo "<script>alert('$message');</script>";
}

if(isset($_POST['submit']) && isset($_POST['services'])) {
    $service_to_update = mysqli_real_escape_string($conn, $_POST['services']);
    $service = mysqli_real_escape_string($conn, $_POST['new-service']);
    $fee = mysqli_real_escape_string($conn, $_POST['service-fee']);
    $deposit = mysqli_real_escape_string($conn, $_POST['deposit']);

    mysqli_query($conn, "UPDATE service_price SET services='$service', price='$fee', deposit='$deposit' WHERE services='$service_to_update'") or die('query failed');
    header('location: price-list.php');
}
?>

<html>
<head>
    <title>Edit Service</title>
    <link rel="stylesheet" href="edit-price-list.css">
    <link rel="stylesheet" href="font.css">
    <meta charset="UTF-8">
</head>
<body>
    <div class="edit-service-page">
        <div class="deco-bg"></div>
        <div class="company-name">Voltex Engineering</div>
        <form class="edit-part" method="post" action="">
            <?php
            if (isset($_POST['services'])) {
                $service = $_POST['services'];

                $select_service = mysqli_query($conn, "SELECT * FROM service_price WHERE services = '$service'") or die('query failed');
                if (mysqli_num_rows($select_service) > 0) {
                    while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                        ?>
                        <div class="edit-title">Update Service Details</div>
                        <div class="edit-form">
                            <label for="services">Service</label><br>
                            <input type="text" name="new-service" value="<?php echo $fetch_row['services']; ?>">
                            <div class="double-col">
                                <div class="service-fee">  
                                    <label for="fee">Service Fee (RM)</label><br>
                                    <input type="number" step="0.01" name="service-fee" value="<?php echo $fetch_row['price']; ?>">
                                </div>
                                <div class="deposit">
                                    <label for="deposit">Deposit (RM)</label><br>
                                    <input type="number" step="0.01" name="deposit" value="<?php echo $fetch_row['deposit']; ?>"> 
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="btn">
                            <input type="hidden" name="services" value="<?php echo $fetch_row['services']; ?>">
                            <button type="submit" name="submit">Update</button>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </form>
    </div>
</body>
</html>
