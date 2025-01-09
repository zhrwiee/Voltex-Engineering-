<?php

include ('connect-server.php');

session_start();
if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}else{
  $user_id =0;
}

?>
<html>
    <head>
        <link rel="stylesheet" href="admin-dashboard.css">
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
                <div class="dashboard-tile">
                    <span class="dashboard-icon"><img src="img/dashboard-icon.svg"></span>
                    <a href="electrician-dashboard.php">Booking List</a>
                </div>
            </div>
            <div class="logout-tile">
                <span class="logout-icon"><img src="img/logout-icon.svg"></span>
                <a href="log-out.php">Logout</a>
            </div>
        </div>
        <div class="mid-section">
            <div class="search-bar">
                <div class="search-icon"><img src="img/search-icon.svg"></div>
                <input type="text" id="search-bar" name="valueToSearch" placeholder="Search artists, projects, ...">
            </div>
            <div class="analytics">
                <div class="title">In the last 30 days,</div>
                <div class="analytics-tile">
                    <div class="tile-1">
                        <?php
                            $select_service = mysqli_query($conn, "SELECT service_type, COUNT(service_id) AS total_bookings
                                FROM services_record
                                GROUP BY service_type
                                ORDER BY total_bookings DESC
                                LIMIT 1;") or die('query failed');
                                if (mysqli_num_rows($select_service) > 0) {
                                    while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                        ?>
                        <div class="group">
                            <div class="number"><?php echo $fetch_row['total_bookings']; ?></div>
                            <div class="text">Services</div>
                        </div>
                        <?php
                                }
                            }
                            ?>
                    </div>
                    <div class="tile-2">
                        <?php
                            $select_service = mysqli_query($conn, "SELECT user_id, COUNT(DISTINCT service_id) AS total_customer
                            FROM services_record
                            GROUP BY user_id
                            ORDER BY total_customer DESC
                            LIMIT 1;") or die('query failed');
                                if (mysqli_num_rows($select_service) > 0) {
                                    while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                        ?>
                        <div class="group">
                            <div class="number"><?php echo $fetch_row['total_customer']; ?></div>
                            <div class="text">Customer</div>
                        </div>
                        <?php
                                }
                            }
                            ?>
                    </div>
                    <div class="tile-3">
                        <?php
                            $select_service = mysqli_query($conn, "SELECT SUM(total_paid) AS total_payments
                            FROM payment_record") or die('query failed');
                                if (mysqli_num_rows($select_service) > 0) {
                                    while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                        ?>
                        <div class="group">
                            <div class="number">RM <?php echo $fetch_row['total_payments']; ?></div>
                            <div class="text">Total Services Expense</div>
                        </div>
                        <?php
                                }
                            }
                            ?>
                    </div>
                </div>
            </div>
            <div class="bottom-section">
                <div class="bot-title">Top Requested Services</div>
            </div>
            <div class="logged-in-history">
                <table>
                    <thead>
                        <tr>
                            <th style="width : 40%">Service</th>
                            <th style="width : 30%">Total Bookings</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                $select_service = mysqli_query($conn, "SELECT service_type, COUNT(service_id) AS total_bookings
                                    FROM services_record
                                    GROUP BY service_type
                                    ORDER BY total_bookings DESC
                                    LIMIT 5") or die('query failed');
                                if (mysqli_num_rows($select_service) > 0) {
                                    while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                            ?>
                            <tr>
                                <td><?php echo $fetch_row['service_type']; ?></td>
                                <td class="total-1"><?php echo $fetch_row['total_bookings']; ?></td>
                                </tr>
                            <?php
                                }
                            }
                            ?>           
                    </tbody>
                </table>
            </div>
        </div>
        <div class="right-col">
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
            <div class="best-rating">
                <div class="title">Most Services by Electrician</div>
                <div class="rating-rank-table">
                    <table>
                        <tbody>
                            <?php
                                $select_service = mysqli_query($conn, "SELECT e.electrician_id, e.fname, COUNT(sr.service_id) AS total_services
                                FROM electrician e
                                LEFT JOIN services_record sr ON e.electrician_id = sr.assigned_electricianId
                                GROUP BY e.electrician_id, e.fname
                                ORDER BY total_services DESC
                                LIMIT 5");
                                if (mysqli_num_rows($select_service) > 0) {
                                    while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                            ?>
                            <tr>
                                <td style="width=60%" class="first"><?php echo $fetch_row['fname']; ?></td>
                                <td style="width=40%" class="total"><?php echo $fetch_row['total_services']; ?></td>
                                <?php
                                }
                            }
                            ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>