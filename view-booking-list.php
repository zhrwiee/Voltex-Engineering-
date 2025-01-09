<?php
include ('connect-server.php');

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = 0;
}

if (isset($_POST['accept']) && isset($_POST['service_id'])) {
    $service_id_to_accept = mysqli_real_escape_string($conn, $_POST['service_id']);
    $user_id = $_SESSION['user_id'];

    $update_query = "UPDATE `services_record` SET assigned_electricianId = '$user_id', completion_status = 'PENDING' WHERE service_id = '$service_id_to_accept'";

    $update_result = mysqli_query($conn, $update_query);
    
    if($update_result) {
        header('Location: view-booking-list.php');
        exit;
    } else {
        echo "Failed to update the service.";
    }
}

?>
<html>
    <head>
        <link rel="stylesheet" href="view-booking-list.css">
        <link rel="stylesheet" href="dashboard-electrician.css">
        <link rel="stylesheet" href="font.css">
        <meta charset="UTF-8">
        <title>Electrician Dashboard</title>
    </head>
    <body>
        <div class="dashboard">
            <div class="sidebar-div">
                <?php include 'sidebar-electrician.php' ?>
            </div>
            <div class="top-header">
                <?php include 'header-dashboard.php'?>
            </div>
            <div class="content">
                <div class="title">Upcoming Booking List</div>
                <div class="list-table">
                    <table>
                        <thead>
                            <tr>
                                <th style="width : 13%">Customer Name</th>
                                <th style="width : 20%">Address</th>
                                <th style="width : 10%">Phone No</th>
                                <th style="width : 10%">Building Type</th>
                                <th style="width : 10%">Service</th>
                                <th style="width : 5%">Time</th>
                                <th style="width : 10%">Date</th>
                                <th style="width : 15%">Electrician In-Charge</th>
                                <th style="width : 10%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-content">                           
                            <?php
                                $select_service = mysqli_query($conn, "SELECT * FROM `services_record` WHERE selected_date >= CURDATE()") or die('query failed');
                                if (mysqli_num_rows($select_service) > 0) {
                                    while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                            ?>
                            <tr>
                                <td class="name">
                                    <?php
                                        $user_name = mysqli_real_escape_string($conn, $fetch_row['user_id']);
                                        $find_query = "SELECT * FROM `user_record` WHERE user_id = '$user_name'";
                                        $result = mysqli_query($conn, $find_query);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            $user_name_data = mysqli_fetch_assoc($result);
                                            echo $user_name_data['fname'].' '. $user_name_data['lname'];
                                        } else {
                                            echo 'Not found';
                                        }
                                    ?>
                                </td>
                                <td class="address"><?php echo $fetch_row['addressLine1'].', '.$fetch_row['addressLine2'].', '.$fetch_row['postcode'].' '.$fetch_row['city'].', '.$fetch_row['state']; ?> </td>
                                <td>
                                    <?php
                                        $phone_no = mysqli_real_escape_string($conn, $fetch_row['user_id']);
                                        $find_query = "SELECT * FROM `user_record` WHERE user_id = '$phone_no'";
                                        $result = mysqli_query($conn, $find_query);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            $phone_no_data = mysqli_fetch_assoc($result);
                                            echo $phone_no_data['phone_no'];
                                        } else {
                                            echo 'Not found';
                                        }
                                    ?>
                                </td>
                                <td><?php echo $fetch_row['building_type']; ?></td>
                                <td><?php echo $fetch_row['service_type']; ?></td>
                                <td><?php echo $fetch_row['selected_time']; ?></td>
                                <td><?php echo $fetch_row['selected_date']; ?></td>
                                <td>
                                    <?php
                                        $assigned_electrician_id = mysqli_real_escape_string($conn, $fetch_row['assigned_electricianId']);
                                        $find_query = "SELECT * FROM `electrician` WHERE id = '$assigned_electrician_id'";
                                        $result = mysqli_query($conn, $find_query);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            $electrician_data = mysqli_fetch_assoc($result);
                                            echo $electrician_data['fname'].' '.$electrician_data['lname'];
                                        } else {
                                            echo 'Not assigned yet.';
                                        }
                                    ?>
                                </td>
                                <td class="action">
                                <form action="view-booking-list.php" method="post">
                                    <input type="hidden" name="service_id" value="<?php echo $fetch_row['service_id']; ?>">
                                    
                                    <?php if (empty($fetch_row['assigned_electricianId']) || $fetch_row['assigned_electricianId'] == '0'): ?>
                                        <input type="submit" name="accept" value="ACCEPT">
                                    <?php else: ?>
                                        <input type="submit" name="accept" value="ACCEPT" disabled>
                                    <?php endif; ?>
                                </form>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
