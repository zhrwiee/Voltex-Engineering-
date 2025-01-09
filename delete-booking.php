<?php

include ('connect-server.php');

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
  }

?>

<html>
    <head>
        <link rel="stylesheet" href="delete-booking.css">
        <link rel="stylesheet" href="font.css">
        <meta charset="UTF-8">
        <?php include 'header.php'; ?>
    </head>
    <body>
    
    </body>
</html>