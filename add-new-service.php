<?php

$addNewErr = $emptyErr ="";
$service = $fee = $deposit = "";

include ('connect-server.php');

function function_alert($message) {
      
    // Display the alert box 
    echo "<script>alert('$message');</script>";
}

if(isset($_POST['submit'])){

    $service = mysqli_real_escape_string($conn, $_POST['new-service']);
    $fee = mysqli_real_escape_string($conn, $_POST['service-fee']);
    $deposit = mysqli_real_escape_string($conn, $_POST['deposit']);

    $select_service = mysqli_query($conn, "SELECT * FROM `service_price` WHERE services = '$service'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        $addNewErr = "[Service already existed in system!]";
    }else if(empty($_POST["new-service"])){
 	    $emptyErr = "[This field is required!]";
    }else if(empty($_POST["email"])){
        $emptyErr = "[This field is required!]";
 	}else{
        mysqli_query($conn, "INSERT INTO `service_price`(services, price, deposit) 
            VALUES('$service', '$fee', '$deposit')") or die('query failed');
        function_alert("The new service is successfully added into the system!");            
    }
}
?>

<html>
  <head>
        <link rel="stylesheet" href="add-new-service.css">
        <link rel="stylesheet" href="font.css">
        <meta charset="UTF-8">
        <title>Add New Service</title>
  </head>
  <body>
    <div class="add-new-service-page">
        <div class="deco-bg"></div>
        <div class="company-name">Voltex Engineering</div>
        <form class="add-part" method="post" action="">
            <div class="add-title">Add New Service</div>
            <div class="add-form">
                <label for="services">Service</label><br>
                <input type="text" name="new-service">
                <span class="messageErr"><?php echo $addNewErr;?></span>
                <div class="double-col">
                    <div class="service-fee">  
                        <label for="fee">Service Fee (RM)</label><br>
                        <input type="number" step="0.01" name="service-fee">
                        <span class="messageErr"><?php echo $emptyErr;?></span>
                    </div>
                    <div class="deposit">
                        <label for="deposit">Deposit (RM)</label><br>
                        <input type="number" step="0.01" name="deposit">
                        <span class="messageErr"><?php echo $emptyErr;?></span>
                    </div>
                </div>
                <br>
            </div>
            <div class="btn">
                <button type="submit" name="submit" id="submit">Add Service</button>
            </div>
        </form>
    </div>
  </body>
</html>

