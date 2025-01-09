<?php
include ('connect-server.php');

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = 0;
}

if(isset($_POST['submit']) && isset($_POST['user_id'])) {
    $id_to_update = mysqli_real_escape_string($conn, $_POST['user_id']);
    $user_name = mysqli_real_escape_string($conn, $_POST['username']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    if (mysqli_query($conn, "UPDATE user_record SET username = '$user_name', fname='$fname', lname='$lname', email = '$email', phone_no = '$phone' WHERE user_id='$id_to_update'")) {
        $_SESSION['username'] = $user_name; 
        header('location: index.php');
        exit;
    } else {
        die('query failed');
    }
}

?>
<html>
    <head>
        <link rel="stylesheet" href="user-profile.css">
        <link rel="stylesheet" href="font.css">
        <meta charset="UTF-8">
        <title>My profile</title>
        <?php include 'header.php'; ?>
    </head>
    <body>
        <div class="content">
            <div class="top-heading"> 
                <div class="layer"></div>
                <div class="title">My Profile</div>
            </div>
                <div class="profile-container">
                    <form class="edit-part" method="post" action="">
                        <?php
                            if (isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];

                                $select_data = mysqli_query($conn, "SELECT * FROM user_record WHERE user_id = '$user_id'") or die('query failed');
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
                                <br.+>
                                <label for="phone">Phone No</label><br>
                                <input type="number" name="phone" value="<?php echo $fetch_row['phone_no']; ?>">
                            </div>
                            <div class="btn">
                                <input type="hidden" name="user_id" value="<?php echo $fetch_row['user_id']; ?>">
                                <div class="btn">
                                    <button class="cancel" type ="button" onclick="window.location.href='index.php';">Cancel</button>
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
    </body>
</html>
