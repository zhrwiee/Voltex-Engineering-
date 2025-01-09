<?php

include ('connect-server.php');

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
  }else{
    $user_id = 0;
  }

if(isset($_POST['remove']) && isset($_POST['electrician_id'])) {
    $electrician_id_to_delete = mysqli_real_escape_string($conn, $_POST['id']);
    $delete_query = "DELETE FROM `electrician` WHERE id = '$electrician_id_to_delete'";
    
    $result = mysqli_query($conn, $delete_query);
    
    if($result) {
        header('Location: electrician-list.php');
        exit;
    } else {
        echo "Failed to delete.";
    }
}

?>
<html>
    <head>
        <link rel="stylesheet" href="electrician-list.css">
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
                <div class="add-electrician">
                    <form action="register-electrician.php" method="post">
                        <input type="submit" name="register-electrician" value="Register New Electrician">
                    </form>
                </div>
                <div class="list-table">
                    <table>
                        <thead>
                            <tr>
                                <th style="width : 10%">Username</th>
                                <th style="width : 20%">First Name</th>
                                <th style="width : 10%">Last Name</th>
                                <th style="width : 5%">Email</th>
                                <th style="width : 15%">Registration Date</th>
                                <th style="width : 15%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-content">
                            
                            <?php
                                $select_electricians = mysqli_query($conn, "SELECT * FROM `electrician`") or die('query failed');
                                if (mysqli_num_rows($select_electricians) > 0) {
                                    while ($fetch_row = mysqli_fetch_assoc($select_electricians)) {
                                        ?>
                            <tr>
                                <td><?php echo $fetch_row['username']; ?></td>
                                <td><?php echo $fetch_row['fname']; ?> </td>
                                <td><?php echo $fetch_row['lname']; ?> </td>
                                <td><?php echo $fetch_row['email']; ?></td>
                                <td><?php echo $fetch_row['registration_date']; ?></td>
                                <td>
                                    <form action="electrician-list.php" method="post" onsubmit="return confirmDelete();">
                                        <input type="hidden" name="electrician_id" value="<?php echo $fetch_row['id']; ?>">
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
            return confirm('Are you sure you want to remove this electrician?');
        }
    </script>
</html>