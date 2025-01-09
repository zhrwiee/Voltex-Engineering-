<?php 
include ('connect-server.php'); 

$current_page = basename($_SERVER['PHP_SELF']);
?>

<html>
<head>
    <link rel="stylesheet" href="header.css">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="company-name">
            <div class="logo">
                <img src="img/logo.png" alt="Logo">
            </div>
            <div class="name">
                <a href="#default" class="logo">Voltex Engineering</a>
            </div>
        </div>
        <div class="header-right">
            <div>
                <a class="nav-link"  <?php echo ($current_page == 'index.php') ? 'active' : ''; ?> href="index.php">Home</a>
            </div>
            <div>
                <a class="nav-link" <?php echo ($current_page == 'services.php') ? 'active' : ''; ?> href="services.php">Services</a>
            </div>
            <div>
                <a class="nav-link" <?php echo ($current_page == 'contact-us.php') ? 'active' : ''; ?> href="contact-us.php">Contact Us</a>
            </div>
            <div>
                <a class="nav-link" <?php echo ($current_page == 'about-us.php') ? 'active' : ''; ?> href="about-us.php">About Us</a>
            </div>
            <div class="login-btn">
                <div class="profile">
                    <?php
                    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        echo "<span class='display-username'>$username</span>";
                        echo "<img src='img/default-user-icon.png'>";
                    } else {
                        echo "<a class='log-in' href='log-in.php'>LOGIN</a>";
                    }
                    ?>
                </div>
                <div class="hidden-sidebar">
                    <span class="sidebar-icon" onclick="openNav()">
                        <i class="fa-solid fa-bars"></i>
                    </span>
                    <div class="sidebar">
                        <div><a href="user-profile.php">My profile</a></div>
                        <div><a href="user-booking-list.php">My Booking</a></div>
                        <div><a href="log-out.php">Log Out</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    
    const navi = document.querySelector(".hidden-sidebar")
    navi.addEventListener("click", () => {
        navi.classList.toggle("open");
    });

    const current_page = window.location.pathname.split('/').pop();

    document.querySelectorAll(".nav-link").forEach((link) => {
        const link_href = link.getAttribute("href");
        if (link_href === current_page) {
            link.classList.add("active");
        }
    });
</script>
</html>
