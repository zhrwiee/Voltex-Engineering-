<?php

include ('connect-server.php');

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
  }else{
    $user_id = 0;
  }

?>
<html>
    <head>
        <link rel="stylesheet" href="dashboard-admin.css">
        <link rel="stylesheet" href="font.css">
        <meta charset="UTF-8">
        <title>Admin Dashboard</title>
    </head>
    <body>
    <div class="dashboard">
            <div class="sidebar-div">
                <?php include 'sidebar-admin.php' ?>
            </div>
            <div class="top-header">
                <?php include 'header-dashboard.php'?>
            </div>
            <div class="content">
                <div class="analytics">
                    <div class="title">In the last 30 days,</div>
                    <div class="analytics-tile">
                        <div class="tile-1">
                            <?php
                                $select_service = mysqli_query($conn, "SELECT COUNT(DISTINCT service_id) AS total_bookings
                                    FROM services_record
                                    ORDER BY total_bookings DESC
                                    LIMIT 1") or die('query failed');
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
                                $select_service = mysqli_query($conn, "SELECT COUNT(DISTINCT user_id) AS total_customer
                                FROM services_record
                                GROUP BY user_id
                                ORDER BY total_customer DESC
                                LIMIT 1;") or die('query failed');
                                    if (mysqli_num_rows($select_service) > 0) {
                                        while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                            ?>
                            <div class="group">
                                <div class="number"><?php echo $fetch_row['total_customer']; ?></div>
                                <div class="text">Customers</div>
                            </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                        <div class="tile-3">
                            <?php
                                $select_service = mysqli_query($conn, "SELECT sr.service_type, COUNT(sr.service_id) AS total_bookings, sp.price
                                FROM services_record sr
                                JOIN service_price sp ON sr.service_type = sp.services
                                GROUP BY sr.service_type
                                ORDER BY total_bookings") or die('query failed');
                            
                                if (mysqli_num_rows($select_service) > 0) {
                                    while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                                        $serviceType = $fetch_row['service_type'];
                                        $totalBookings = $fetch_row['total_bookings'];
                                        $price = $fetch_row['price'];
                                        $totalCost = $totalBookings * $price;
                                        $total =+ $totalCost;
                                    }
                            ?>
                            <div class="group">
                                <div class="number">RM <?php echo $total; ?></div>
                                <div class="text">Total Services Expense</div>
                            </div>
                            <?php
                                    }                              
                            ?>
                        </div>
                    </div>
                </div>
                <div class="bottom-section">
                    <div class="title">Top Requested Services</div>
                </div>
                <div class="service-list">
                    <table>
                        <thead>
                            <tr>
                                <th style="width : 50%">Service</th>
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
        </div>
    </body>
</html>