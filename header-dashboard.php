<?php

include ('connect-server.php');

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
  }else{
    $user_id = 0;
  }

?>
<html>
    <head>
        <link rel="stylesheet" href="header-dashboard.css">
        <link rel="stylesheet" href="font.css">
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="section-profile">
            <div class="float-right">
                <div class="profile">
                    <div class="profile-pic"><img src="img/default-user-icon.png"></div>
                    <div class="name-role">
                        <?php
                            if (isset($_SESSION['user_id'])) {
                                $user_name = $_SESSION['username'];

                                $select_data = mysqli_query($conn, "SELECT * FROM `electrician` WHERE id = $user_id") or die('query failed');
                                $row = mysqli_fetch_assoc($select_data);                       
                            } else {
                                echo "<a class='login-admin' href='log-in.php'>LOGIN</a>";
                            }
                        ?>
                        <div class="name"><?php echo $user_name?></div>
                        <div class="role"><?php echo $row['user_type']; ?></div>
                    </div>
                </div>
            </div>
            <div class="box"></div>
        </div>
    </body>
</html>