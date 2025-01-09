<?php

include ('connect-server.php');

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
  }

if(isset($_POST['delete']) && isset($_POST['service_id'])) {
    $service_id_to_delete = mysqli_real_escape_string($conn, $_POST['service_id']);
    $delete_query = "DELETE FROM `services_record` WHERE service_id = '$service_id_to_delete' AND user_id = '$user_id'";
    
    $result = mysqli_query($conn, $delete_query);
    
    if($result) {
        // Redirect or display a success message as needed
        header('Location: user-booking-list.php');
        exit;
    } else {
        // Handle the case where deletion fails
        echo "Failed to delete the service.";
    }
}

?>

<html>
    <head>
        <link rel="stylesheet" href="view-details.css">
        <link rel="stylesheet" href="font.css">
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="div-section">
            <div class="page-title">Your booking details</div><br>
            <?php
            if (isset($_POST['service_id'])) {
                $service_id = $_POST['service_id'];
                    $select_service = mysqli_query($conn, "SELECT * FROM `services_record` WHERE user_id = '$user_id' AND service_id = '$service_id'") or die('query failed');
                    if (mysqli_num_rows($select_service) > 0) {
                        while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                            ?>
            <div class="section-to-center">
                <div class="details">
                    <div class="double-col">
                        <div>Building Type : <?php echo $fetch_row['building_type']; ?> </div>
                        <div>Service : <?php echo $fetch_row['service_type']; ?></div>
                    </div>
                    <div class="double-col">
                        <div>Time : <?php echo $fetch_row['time']; ?></div>
                        <div>Date : <?php echo $fetch_row['request_date']; ?></div>
                    </div>
                    <div>Location : <?php echo $fetch_row['addressLine2']; ?></div>
                    <?php
                    // Assuming $fetch_row['assigned_electricianId'] contains the electrician ID
                    $assigned_electrician_id = mysqli_real_escape_string($conn, $fetch_row['assigned_electricianId']);
                    $find_query = "SELECT * FROM `electrician` WHERE electrician_id = '$assigned_electrician_id'";
                    $result = mysqli_query($conn, $find_query);

                    // Check if the query was successful
                    if ($result && mysqli_num_rows($result) > 0) {
                        $electrician_data = mysqli_fetch_assoc($result);
                        // Output the assigned electrician's first name
                        echo '<div>Assigned Electrician : ' . $electrician_data['fname'] . '</div>';
                    } else {
                        // Handle the case where electrician data is not found
                        echo '<div>Assigned Electrician : Not assigned yet</div>';
                    }
                    ?>
                    <div class="double-col">
                        <div>Status : <?php echo $fetch_row['status']; ?></div>
                        <div>Payment : PAID</div>
                    </div>
                    <div class="btn">
                        <div class="update-btn">
                            <form action="view-details.php" method="post">
                                <input type="hidden" name="service_id" value="<?php echo $fetch_row['service_id']; ?>">
                                <input type="submit" name="delete" value="Delete">
                            </form>
                        </div>
                        <div class="pay-btn">
                            <form action="make-payment.php" method="post">
                                <input type="hidden" name="service_id" value="<?php echo $fetch_row['service_id']; ?>">
                                <input type="submit" name="pay" value="Pay">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                }
            }
            ?>
        </div>
    </body>
</html>