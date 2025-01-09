<?php

include ('connect-server.php');

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    echo "<script>alert('You must be logged in to view this page. Go to login page?');</script>";
    echo "<script>setTimeout(function(){ window.location.href = 'log-in.php'; }, 2000);</script>";
    exit;
}

?>

<html>
    <head>
        <link rel="stylesheet" href="user-booking-list.css">
        <link rel="stylesheet" href="font.css">
        <meta charset="UTF-8">
        <title>My Booking</title>
        <?php include 'header.php'; ?>
    </head>
    <body>
        <div class="div-section">
            <div class="top-heading"> 
                <div class="layer"></div>
                <div class="title">My Booking List</div>
            </div>
            <div class="booking-table">
                <table class="mybooking">
                    <thead>
                        <tr>
                            <th style="width : 20%">Service</th>
                            <th style="width : 10%">Building Type</th>
                            <th style="width : 20%">Location</th>
                            <th style="width : 10%">Date</th>
                            <th style="width : 10%">Time</th>
                            <th style="width : 15%">Assigned Electrician</th>
                            <th style="width : 10%">Status</th>
                        </tr>
                    </thead>
                    <tbody id="table-content">
                        <?php

                        if (isset($_SESSION['user_id'])) {
                            $select_service = mysqli_query($conn, "SELECT * FROM `services_record` WHERE user_id = '$user_id'") or die('query failed');
                            if (mysqli_num_rows($select_service) > 0) {
                                while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                                    ?>
                        <tr>
                            <td><?php echo $fetch_row['service_type']; ?> </td>    
                            <td><?php echo $fetch_row['building_type']; ?></td>
                            <td><?php echo $fetch_row['addressLine1'].', '.$fetch_row['addressLine2'].', '.$fetch_row['postcode'].' '.$fetch_row['city'].', '.$fetch_row['state']; ?></td>
                            <td><?php echo $fetch_row['selected_time']; ?></td>
                            <td class="status">
                                <?php
                                $assigned_electrician_id = mysqli_real_escape_string($conn, $fetch_row['assigned_electricianId']);
                                $find_query = "SELECT * FROM `electrician` WHERE id = '$assigned_electrician_id'";
                                $result = mysqli_query($conn, $find_query);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $electrician_data = mysqli_fetch_assoc($result);
                                    echo $electrician_data['fname'];
                                } else {
                                    echo 'Not found';
                                }
                                ?>
                            </td>
                            <td class="status"><?php echo $fetch_row['completion_status']; ?></td>
                        </tr>
                        <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>