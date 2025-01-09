<?php
include ('connect-server.php');

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = 0;
}

if(isset($_POST['submit']) && isset($_POST['electrician_id'])) {
    $id_to_update = mysqli_real_escape_string($conn, $_POST['electrician_id']);
    $user_name = mysqli_real_escape_string($conn, $_POST['username']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (mysqli_query($conn, "UPDATE electrician SET username = '$user_name', fname='$fname', lname='$lname', email = '$email' WHERE id='$id_to_update'")) {
        $_SESSION['username'] = $user_name; 
        header('location: dashboard-electrician.php');
        exit;
    } else {
        die('query failed');
    }
}

?>
<html>
    <head>
        <link rel="stylesheet" href="electrician-profile.css">
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
                <div class="title">My Profile</div>
                <div class="profile-container">
                    <form class="edit-part" method="post" action="">
                        <?php
                            if (isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];

                                $select_data = mysqli_query($conn, "SELECT * FROM electrician WHERE id = '$user_id'") or die('query failed');
                                if (mysqli_num_rows($select_data) > 0) {
                                    while ($fetch_row = mysqli_fetch_assoc($select_data)) {
                        ?>
                            <div class="edit-form">
                                <div class="username">  
                                    <label for="username">Username</label><br>
                                    <input type="text" name="username" value="<?php echo $fetch_row['username']; ?>">
                                </div>
                                <div class="double-col">
                                    <div class="fname">
                                        <label for="fname">First Name</label><br>
                                        <input type="text" name="fname" value="<?php echo $fetch_row['fname']; ?>"> 
                                    </div>
                                    <div class="lname">
                                        <label for="deposit">Last Name</label><br>
                                        <input type="text" name="lname" value="<?php echo $fetch_row['lname']; ?>"> 
                                    </div>
                                </div>
                                <br>
                                <label for="email">Email</label><br>
                                <input type="text" name="email" value="<?php echo $fetch_row['email']; ?>"> 
                            </div>
                            <div class="btn">
                                <input type="hidden" name="electrician_id" value="<?php echo $fetch_row['id']; ?>">
                                <div class="btn">
                                    <button class="cancel" type ="button" onclick="window.location.href='dashboard-electrician.php';">Cancel</button>
                                    <button type="submit" name="submit">Update</button>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
