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
    <title>Home</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="font.css">
    <?php include 'header.php'; ?>       
  </head>
  <body>
    <div class="div-section">
      <div class="section-1">
        <div class="background">
          <img src="img/section-01.jpg" alt="Background">
        </div>
        <div class="layer">
          <div class="content">
            <div class="content-1">Wire you waiting?<br>Call us now for your electrical needs.</div>
            <div class="content-2">We are a Service You Can Trust</div>
            <div class="content-3" onclick="redirectToBookingPage()">Book With Us</div>
          </div>
        </div>
      </div>
      <div class="section-2">
        <div class="intro">
          <div class="logo">
            <img src="img/logo.png" alt="Logo" >
          </div>
          <div class="intro-company-name">
            Voltex Engineering
          </div>
          <div class="intro-company">
            Welcome to Voltex Engineer, where excellence in electrical services meets unmatched customer satisfaction. 
            With a commitment to delivering reliable, efficient, and safe electrical solutions, we are your go-to partner for all your electrical needs.
          </div>
          <div class="read-more-btn"><a href="about-us.php" class="read-more">Read More...</a></div>
        </div>
        <div class="deco-1">
          <img src="img/deco-index-1.jpg" alt="image"> 
        </div>
      </div>
      <div class="section-3">
        <div class="background-3"></div>
        <div class="layer-3">
          <div class="title-3">
            OUR SERVICES
          </div>
          <div class="residential-img" onclick="redirectToBookingPage()">
            <div class="box"></div>
            <div class="text"><span class="icon"><img src="img/residential-icon.svg"></span>RESIDENTIAL</div>
          </div>
          <div class="commercial-img"  onclick="redirectToBookingPage()">
            <div class="box"></div>
            <div class="text"><span class="icon"><img src="img/commercial-icon.svg"></span>COMMERCIAL</div>
          </div>
        </div>
      </div>
      <div class="section-4">
        <div class="title-4">
          WHAT WE <span class="offer">OFFER</span>
          <p class="desc-title">We offer a comprehensive range of cost effective services for residential and commercial properties.</p>
        </div>
        <div class="safety-maintenance">
          <div class="sect4-icon1"><img src="img/sect4-icon1.png" alt="icon"></div>
          <h1 class="sect4-head1">Safety Maintenance</h1>
          <p class="sect4-desc1">Safety maintenance involves measures and practices aimed at ensuring the safety and well-being of individuals, equipment, and the environment.</p>
        </div>
        <div class="electrical-installation">
          <div class="sect4-icon2"><img src="img/sect4-icon2.png" alt="icon"></div>
          <h1 class="sect4-head2">Electrical Installation</h1>
          <p class="sect4-desc2">From wiring installations to lighting upgrades, we ensure your home is powered safely and efficiently.</p>
        </div>
        <div class="service-maintenance">
          <div class="sect4-icon3"><img src="img/sect4-icon3.png" alt="icon"></div>
          <h1 class="sect4-head3">Service Maintenance</h1>
          <p class="sect4-desc3">We understand that electrical issues can arise at any time. That's why we offer prompt emergency services 
            and routine maintenance to keep your systems running smoothly.</p>
        </div>  
      </div>
      <div class="section-5">
        <div class="title-5">RECENT PROJECTS</div>
        <div class="project-img-1"><img src="img/deco-index-1.jpg"></div>
        <div class="project-img-2"><img src="img/deco-2.jpg"></div>
        <div class="project-img-3"><img src="img/deco-3.jpg"></div>
        <div class="project-img-4"><img src="img/deco-4.jpg"></div>
        <div class="project-img-5"><img src="img/deco-5.jpg"></div>
        <div class="project-img-6"><img src="img/deco-6.jpg"></div>
      </div>
      <?php include 'footer.php'; ?>  
    </div> 
  </body>
  <script>
    function redirectToBookingPage() {
        window.location.href = 'book.php';
    }
  </script>
</html>
