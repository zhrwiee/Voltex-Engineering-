<?php
include ('connect-server.php');

session_start();
if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}else{
  $user_id = 0;
}

if (isset($_POST['accept']) && isset($_POST['service_id'])) {
    $service_id_to_accept = mysqli_real_escape_string($conn, $_POST['service_id']);
    $electrician_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    
    // Update the user_id in services_record
    $update_query = "UPDATE `services_record` SET assigned_electricianId = '$user_id' WHERE service_id = '$service_id_to_accept'";

    $update_result = mysqli_query($conn, $update_query);
    
    if($update_result) {
        // Redirect or display a success message as needed
        header('Location: admin-manage-booking.php');
        exit;
    } else {
        // Handle the case where the update fails
        echo "Failed to update the service.";
    }

    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM `services_record` WHERE service_id = '$service_id_to_accept_id'" ;
    $result = mysqli_query($conn, $query);
}
?>

<html>
    <head>
        <link rel="stylesheet" href="admin-manage-booking.css">
        <link rel="stylesheet" href="font.css">
        <meta charset="UTF-8">
        <title>dashboard</title>
    </head>
    <body>
        <div class="dashboard">
        <div class="sidebar">
            <div class="empty"></div>
            <div class="company-name">
                Voltex Engineering
            </div>
            <div class="menu-tile">
                <div class="manage-booking-tile">
                    <span class="manage-booking-icon"><img src="img/manage-booking-icon.svg"></span>
                    <a href="admin-manage-booking.php">Manage Booking</a>
                </div>
            </div>
            <div class="logout-tile">
                <span class="logout-icon"><img src="img/logout-icon.svg"></span>
                <a href="log-out.php">Logout</a>
            </div>
        </div>
        <div class="manage-booking">
            <div class="space"></div>
            <table>
                <thead>
                    <tr>
                        <th style="width : 20%">Name</th>
                        <th style="width : 25%">Service</th>
                        <th style="width : 10%">Location</th>
                        <th style="width : 10%">Date</th>
                        <th style="width : 10%">Time</th>
                        <th style="width : 20%">Electrician</th>
                        <th style="width : 20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_service = mysqli_query($conn, "SELECT * FROM `services_record` ") or die('query failed');
                    if (mysqli_num_rows($select_service) > 0) {
                        while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                    ?>
                    <tr>
                        <td class="name">
                            <?php
                                $fname = mysqli_real_escape_string($conn, $fetch_row['user_id']);
                                $find_query = "SELECT * FROM `user_record` WHERE user_id = '$fname'";
                                $result = mysqli_query($conn, $find_query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $user_name = mysqli_fetch_assoc($result);
                                    echo $user_name['fname'];
                                } else {
                                    // Handle the case where electrician data is not found
                                    echo 'Not found';
                                }?>
                        </td>
                        <td class="status"><?php echo $fetch_row['service_type']; ?></td>
                        <td class="date"><?php echo $fetch_row['addressLine2']; ?></td>
                        <td class="date"><?php echo $fetch_row['request_date']; ?></td>
                        <td class="date"><?php echo $fetch_row['time']; ?></td>
                        <td>
                            <?php
                                $assigned_electrician_id = mysqli_real_escape_string($conn, $fetch_row['assigned_electricianId']);
                                $find_query = "SELECT * FROM `electrician` WHERE electrician_id = '$assigned_electrician_id'";
                                $result = mysqli_query($conn, $find_query);

                                // Check if the query was successful
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $electrician_data = mysqli_fetch_assoc($result);
                                    // Output the assigned electrician's first name
                                    echo $electrician_data['username'];
                                } else {
                                    // Handle the case where electrician data is not found
                                    echo 'Not found';
                                }
                                ?>
                        </td>
                        <td class="action">
                            <form action="admin-manage-booking.php" method="post">
                                <input type="hidden" name="service_id" value="<?php echo $fetch_row['service_id']; ?>">
                                <div class="assign-btn"><div><input type="submit" name="accept" value="Accept" <?php echo ($assigned_electrician_id ? 'disabled' : ''); ?>></div></div>
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
            <div class="top-right-col">
                <div class="profile">
                    <?php
                        if (isset($_SESSION['user_id'])) {
                            // User is logged in, display their username
                            $username = $_SESSION['username'];

                            $select_data = mysqli_query($conn, "SELECT * FROM `electrician` WHERE electrician_id = $_SESSION[user_id]") or die('query failed');
                            $row = mysqli_fetch_assoc($select_data);
                            $user_type = isset($row['user_type']);                       
                        } else {
                            // User is not logged in, display the login button
                            echo "<a class='request-service' href='log-in.php'>LOGIN</a>";
                        }
                    ?>
                    <div class="profile-pic"><img src="img/default-user-icon.png"></div>
                    <div class="name-role">
                        <div class="name"><?php echo $username?></div>
                    </div>
                </div>
                <div class="noti-icon"><img src="img/noti-icon.svg"></div>
            </div>
        </div>
    </body>
</html>