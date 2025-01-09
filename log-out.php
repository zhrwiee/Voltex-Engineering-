<?php

include 'connect_server.php';

session_start();
session_unset();
session_destroy();

header('location:log-in.php');

?>
