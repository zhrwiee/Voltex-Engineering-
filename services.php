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
        <link rel="stylesheet" href="services.css">
        <link rel="stylesheet" href="font.css">
        <meta charset="UTF-8">
        <title>Services</title>
        <?php include 'header.php'; ?>
    </head>
    <body>
        <div class="div-section">
            <div class="top-heading">
                <div class="layer"></div>
                <div class="title">Services</div>
            </div>
            <div class="navi-bar"></div>
            <div class="section-1">
                <div class="background-1"></div>
                <div class="layer-1">
                    <div class="title-1">
                        <span class="services-russo">BOOKING</span> SERVICES
                    </div>
                    <div class="residential-img" onclick="redirectToBookingPage()">
                        <div class="box"></div>
                        <div class="text"><span class="icon"><img src="img/residential-icon.svg"></span>RESIDENTIAL</div>
                    </div>
                    <div class="commercial-img" onclick="redirectToBookingPage()">
                        <div class="box"></div>
                        <div class="text"><span class="icon"><img src="img/commercial-icon.svg"></span>COMMERCIAL</div>
                    </div>
                </div>
            </div>
            <div class="section-2">
                <div class="title-2">
                    WHAT WE <span class="offer">OFFER</span>
                    <p class="desc-title">We offer a comprehensive range of cost effective services for residential and commercial properties.</p>
                </div>
                <div class="safety-maintenance">
                    <div class="sect2-icon1"><img src="img/sect4-icon1.png" alt="icon"></div>
                    <h1 class="sect2-head1">Safety Maintenance</h1>
                    <p class="sect2-desc1">Safety maintenance involves measures and practices aimed at ensuring the safety and well-being of individuals, equipment, and the environment.</p>
                </div>
                <div class="electrical-installation">
                    <div class="sect2-icon2"><img src="img/sect4-icon2.png" alt="icon"></div>
                    <h1 class="sect2-head2">Electrical Installation</h1>
                    <p class="sect2-desc2">From wiring installations to lighting upgrades, we ensure your home is powered safely and efficiently.</p>
                </div>
                <div class="service-maintenance">
                    <div class="sect2-icon3"><img src="img/sect4-icon3.png" alt="icon"></div>
                    <h1 class="sect2-head3">Service Maintenance</h1>
                    <p class="sect2-desc3">We understand that electrical issues can arise at any time. That's why we offer prompt emergency services 
                        and routine maintenance to keep your systems running smoothly.</p>
                </div>  
            </div>
            <div class="section-3">
                <div class="brochure">
                    <div class="brochure-icon"><img src="img/brochure-icon.svg"></div>
                    <div class="title-desc">
                        <div class="title-3">
                            Our Brochure
                        </div>
                        <div class="desc">
                            Download our brochure to know more about our services
                        </div>
                    </div>
                    <div class="dw-btn">
                        <button onclick="window.open('files/Brochure.pdf')" id="dw-btn" class="dw-btn">Download</button>
                    </div>
                </div>
                <div class="price-list">
                    <div class="price-list-icon"><img src="img/price-list-icon.svg"></div>
                    <div class="title-desc">
                        <div class="title-3">
                            Price List
                        </div>
                        <div class="desc">
                            Download our list to know more about our affordable prices
                        </div>
                    </div>
                    <div class="dw-btn">
                        <button onclick="window.open('files/Price List.pdf')" id="dw-btn" class="dw-btn">Download</button>
                    </div>
                </div>
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