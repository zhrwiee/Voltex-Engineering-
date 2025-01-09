<?php

include ('connect-server.php');

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
  }else{
    $user_id = 0;
  }

if(isset($_POST['remove']) && isset($_POST['services'])) {
    $service_to_delete = mysqli_real_escape_string($conn, $_POST['services']);
    $delete_query = "DELETE FROM `service_price` WHERE services = '$service_to_delete'";
    
    $result = mysqli_query($conn, $delete_query);
    
    if($result) {
        header('Location: price-list.php');
        exit;
    } else {
        echo "Failed to delete.";
    }
}

?>
<html>
    <head>
        <link rel="stylesheet" href="price-list.css">
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
                <div class="add-new-service">
                    <form action="add-new-service.php" method="post">
                        <input type="submit" name="add-new-service" value="Add New Service">
                    </form>
                </div>
                <div class="list-table">
                    <table>
                        <thead>
                            <tr>
                                <th style="width : 10%">Service</th>
                                <th style="width : 20%">Price</th>
                                <th style="width : 10%">Deposit</th>
                                <th style="width : 15%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-content">
                                
                            <?php
                                $select_service = mysqli_query($conn, "SELECT * FROM `service_price`") or die('query failed');
                                if (mysqli_num_rows($select_service) > 0) {
                                    while ($fetch_row = mysqli_fetch_assoc($select_service)) {
                                    ?>
                            <tr>
                                <td><?php echo $fetch_row['services']; ?></td>
                                <td><?php echo $fetch_row['price']; ?> </td>
                                <td><?php echo $fetch_row['deposit']; ?> </td>
                                <td class="action">                              
                                    <form action="edit-price-list.php" method="post">
                                        <input type="hidden" name="services" value="<?php echo $fetch_row['services']; ?>">
                                        <input type="submit" name="edit" value="Edit">
                                    </form>
                                    <form action="price-list.php" method="post" onsubmit="return confirmDelete();">
                                        <input type="hidden" name="services" value="?php echo $fetch_row['services']; ?>">
                                        <input type="submit" name="remove" value="Remove">
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
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to remove this?');
        }
    </script>
</html>