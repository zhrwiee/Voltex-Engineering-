<?php

include ('connect-server.php');

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}else{
  $user_id =0;
}

$current_page = basename($_SERVER['PHP_SELF']);

?>
<html>
    <head>
        <link rel="stylesheet" href="sidebar-admin.css">
        <link rel="stylesheet" href="font.css">
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="sidebar">
            <div class="empty"></div>
            <div class="company-name">
                Voltex Engineering
            </div>
            <div class="menu-tile">
                <div>
                    <span class="icon"><img src="img/dashboard.png"></span>
                    <a class="nav-link" <?php echo ($current_page == 'dashboard-admin.php') ? 'active' : ''; ?> href="dashboard-admin.php">Dashboard</a>
                </div>
                <div>
                    <span class="icon"><img src="img/list.png"></span>
                    <a class="nav-link" <?php echo ($current_page == 'electrician-list.php') ? 'active' : ''; ?> href="electrician-list.php">Electrician List</a>
                </div>
                <div>
                    <span class="icon"><img src="img/task.png"></span>
                    <a class="nav-link" <?php echo ($current_page == 'price-list.php') ? 'active' : ''; ?> href="price-list.php">Service List</a>
                </div>
            </div>
            <div class="logout-tile">
                <span class="logout-icon"><img src="img/logout.png"></span>
                <a href="log-out.php">Logout</a>
            </div>
        </div>
    </body>
    <script>
        const current_page = window.location.pathname.split('/').pop();

        document.querySelectorAll(".nav-link").forEach((link) => {
            const link_href = link.getAttribute("href");
            if (link_href === current_page) {
                link.classList.add("active");
            }
        });
    </script>
</html>