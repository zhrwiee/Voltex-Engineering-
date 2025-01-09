<?php

include ('connect-server.php');

session_start();

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}

if (isset($_POST['submit'])) {
  // Check if the user is not logged in
  if (!isset($user_id)) {
      // User is not logged in, display the msg-box using JavaScript
      echo '<script>
              document.addEventListener("DOMContentLoaded", function() {
                  var msgBox = document.getElementById("msg-box");
                  if (msgBox) {
                      msgBox.style.display = "flex";
                      body.classList.add("no-scroll");
                  }
              });

              function closeMessageBox() {
                var msgBox = document.getElementById("msg-box");
                var body = document.body;
                if (msgBox) {
                    msgBox.style.display = "none";
                }
            }
           </script>';
  } else {

    $building_type = $service_type = $address1 = $address2 = $request_date = $request_time = "";
    
      $user_id = $_SESSION['user_id'];
      $building_type = mysqli_real_escape_string($conn, $_POST['building-type']);
      $service_type = mysqli_real_escape_string($conn, $_POST['service-list']);
      $address1 = mysqli_real_escape_string($conn, $_POST['address1']);
      $address2 = mysqli_real_escape_string($conn, $_POST['address2']);   
      $request_time = mysqli_real_escape_string($conn, $_POST['time-select']);
      $request_date = mysqli_real_escape_string($conn, $_POST['date']);

      mysqli_query($conn, "INSERT INTO `services_record` (user_id, building_type, service_type, addressLine1, addressLine2, time, request_date, status) 
        VALUES('$user_id', '$building_type', '$service_type', '$address1', '$address2', '$request_time', '$request_date', 'PENDING')") or die('query failed');
      header('location: index.php');
  }
}

?>

<html>
  <head>
      <link rel="stylesheet" href="booking.css">
      <link rel="stylesheet" href="font.css">
      <meta charset="UTF-8">
      <?php include 'header.php'; ?>
    </head>
  <body>
    <div class="div-section">
        <div class="top-heading">
            <div class="layer"></div>
            <div class="title">Booking</div>
        </div>
        <div class="section-2">
            <div class="layer-2"></div>
            <div class="title-2">
                ALL SERVICES AT VOLTEX
                <p class="desc-title">Here are the list of services we offer</p>       
            </div>
            <div class="residential-services">
                <div class="title-services">Residential Buildings</div>
                <div class="services-list">
                    <ul>
                        <li>Breakers and Fuses</li>
                        <li>Code Corrections</li>
                        <li>Outlet Circuits and Rewiring</li>
                        <li>Exhaust Fans</li>
                        <li>Smoke Detector</li>
                        <li>Home Theater Installation</li>
                        <li>Air Conditioner Installation</li>
                    </ul>
                </div>
            </div>
            <div class="commercial-services">
                <div class="title-services">Commercial Buildings</div>
                <div class="services-list">
                    <ul>
                        <li>Telecom Installation</li>
                        <li>Outdoor/Parking Lot Lighting</li>
                        <li>Outley\ts, Circuit and Rewiring</li>
                        <li>HID Lighting and Control</li>
                        <li>Motors and Transformer</li>
                        <li>Isolated Computer Circuits</li>
                        <li>Ballast/Lamp Replacing</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="section-3">
            <div class="booking-form">
                <form method="post" action="">
                    <div class="form-title">Booking With Us!</div>
                    <div class="form-input"> 
                        <div class="double-col">
                            <div class="select-building-type">        
                                <label for="building-type">Building Type<span class="error" style="color: red;"> *</span></label><br>
                                <select id="building-type" name="building-type" onchange="updateServiceListDropdown()">
                                    <option value disabled selected>--Select--</option>
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                </select>
                            </div>
                            <div class="select-service">
                                <label for="service-list">Service List<span class="error" style="color: red;"> *</span></label><br>
                                <select id="service-list" name="service-list">
                                    <option value disabled selected>--Select--</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="double-col">
                            <div class="date">  
                                <label for="date">Date<span class="error" style="color: red;"> *</span></label><br>
                                <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="time">
                                <label for="time">Time<span class="error" style="color: red;"> *</span></label><br>
                                <select id="time-select" name="time-select">
                                    <option value disabled selected>--Select--</option>
                                    <option value="0800">8.00 AM</option>
                                    <option value="1200">2.00 PM</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <label for="address1">Address Line 1<span class="error" style="color: red;"> *</span></label><br>
                        <input type="text" id="address1" name="address1" placeholder="House number, street name">
                        <br><br>
                        <label for="address2">Address Line 2</label><br>
                        <input type="text" id="address2" name="address2" placeholder="City, State">
                    </div>
                    <br>
                    <div class="btn">
                        <button type="submit" name="submit" id="submit">Book</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="msg-box" id="msg-box" name="msg-box">
          <div class="box">
            <div class="close-btn" onclick="closeMessageBox()"></div>
            <div class="msg">Please sign in or register<br> to continue.</div>
            <div class="go-login"><a href="log-in.php">Login</a></div>
            <div class="go-register"><a href="register.php">Register</a></div>
          </div>
        </div>
      <?php include 'footer.php'; ?>
    </div>
  </body>
  <script>
    function updateServiceListDropdown() {
        var buildingTypeDropdown = document.getElementById("building-type");
        var ServiceListDropdown = document.getElementById("service-list");

        // Clear existing options
        ServiceListDropdown.innerHTML = "";

        // Add options based on the selected building type
        if (buildingTypeDropdown.value === "Residential") {
            addOption(ServiceListDropdown, "Breakers and Fuses", "Breakers and Fuses");
            addOption(ServiceListDropdown, "Code Corrections", "Code Corrections");
            addOption(ServiceListDropdown, "Outlet Circuits and Rewiring", "Outlet Circuits and Rewiring");
            addOption(ServiceListDropdown, "Exhaust Fans", "Exhaust Fans");
            addOption(ServiceListDropdown, "Smoke Detector", "Smoke Detector");
            addOption(ServiceListDropdown, "Home Theater Installation", "Home Theater Installation");
            addOption(ServiceListDropdown, "Air Conditioner Installation", "Air Conditioner Installation");
        } else if (buildingTypeDropdown.value === "Commercial") {
            addOption(ServiceListDropdown, "Telecom Installation", "Telecom Installation");
            addOption(ServiceListDropdown, "Outdoor/Parking Lot Lighting", "Outdoor/Parking Lot Lighting");
            addOption(ServiceListDropdown, "Outlet, Circuit and Rewiring", "Outlet, Circuit and Rewiring");
            addOption(ServiceListDropdown, "HID Lighting and Control", "HID Lighting and Control");
            addOption(ServiceListDropdown, "Motors and Transformer", "Motors and Transformer");
            addOption(ServiceListDropdown, "Isolated Computer Circuits", "Isolated Computer Circuits");
            addOption(ServiceListDropdown, "Ballast/Lamp Replacing", "Ballast/Lamp Replacing");
        }
    }

    function addOption(selectElement, value, text) {
        var option = document.createElement("option");
        option.value = value;
        option.text = text;
        selectElement.add(option);
    }

    // Initial population on page load
    updateServiceListDropdown();


</script>
</html>