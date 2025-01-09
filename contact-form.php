ss<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = isset($_POST["fullname"]) ? $_POST["fullname"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $number = isset($_POST["number"]) ? $_POST["number"] : "";
    $message = isset($_POST["message"]) ? $_POST["message"] : "";

        $to = "mfaizazli47@gmail.com";  
        $subject = "Voltex Engineering Contact Form Submission";

        $headers = "From: $email";
    

        $mailBody = "Name: $fullname\nEmail: $email\nPhone Number: $number\nMessage: $message";
    //add email features
    //add any ss

        if (mail($to, $subject, $mailBody, $headers)) {
            echo '<script>alert("Submission successful! Thank you.");</script>';
            echo '<script>window.location.href = "index.php";</script>';  
            exit();
        } else {
            echo '<script>alert("Oops! Something went wrong and we couldn\'t send your message. Please try again later.");</script>';
            echo '<script>window.location.href = "contact-us.php";</script>';  
        }
    } 
?>
