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
      <link rel="stylesheet" href="contact-us.css">
      <link rel="stylesheet" href="font.css">
      <meta charset="UTF-8">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <title>Contact Us</title>
      <?php include 'header.php'; ?>
    </head>
  <body>    
    <div class="div-section">
        <div class="top-heading"> 
            <div class="layer"></div>
            <div class="title">Contact Us</div>
        </div>
        <div class="section-1">
            <div class="sect-1-pic">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d995.9772308805667!2d101.67319661954203!3d3.1187909498035573!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc49d6ac5bd58b%3A0x8a573213c3e5c225!2sKL%20Eco%20City%20-%20Menara%202%20%7C%20Management%20Office!5e0!3m2!1sen!2smy!4v1705324500239!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="message-sect">
                <div class="message-title">Send Us a Message!</div><br>
                <div class="message-text">Let's talk. Our Engineer expertise can guide you.</div>
                <div class="container">
                    <form action="contact-form.php" method="POST">
                        <label for="fname">Full Name</label>
                        <input type="text" id="fname" name="fullname">
                        
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">

                        <label for="number">Phone Number</label>
                        <input type="tel" id="number" name="number">

                        <label for="message">Message</label>
                        <textarea id="message" name="message" style="height:200px"></textarea>

                        <input type="submit" name="send" value="Submit">
                    </form>
                </div>             
            </div>
        </div>
        <div class="section-2">
            <div class="box">
                <i class="mail-icon"></i>
                <img src="img/mail.jpg" alt="Mail Address">
                <h3>Mail Address</h3>
                <p class="p">voltexengine@mailservice.com</a></p>
            </div>

            <div class="box">
                <i class="phone-icon"></i>
                <img src="img/phone.png" alt="Contact">
                <h3>Phone Number</h3>
                <p class="p">+60 12-560 7626</a></p>
            </div>
            
            <div class="box">
                <i class="location-icon"></i>
                <img src="img/location.png" alt="Office Address">
                <h3>Office Address</h3>
                <p class="p">BO1-A-9, Menara 2, KL Eco City, 3, Jalan Bangsar, 59200 Kuala Lumpur, Wilayah Perseketuan, Malaysia</p>
            </div>

        </div>
      
      <?php include 'footer.php'; ?>
    </div>
  </body>
</html>
