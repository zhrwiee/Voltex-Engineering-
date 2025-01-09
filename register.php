<?php

$fnameErr = $user_nameErr = $emailErr = $phoneErr = $addressErr = $passwordErr = $cfpasswordErr ="";
$fname = $lname = $user_name = $email = $phone = $password = $cfpassword = "";

include ('connect-server.php');

function function_alert($message) {
      
    echo "<script>alert('$message');</script>";
}

if(isset($_POST['submit'])){

    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $user_name = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cfpassword']));
    $pass1 = mysqli_real_escape_string($conn, ($_POST['password']));
    $user_type = $_POST['user_type'];

    $select_users = mysqli_query($conn, "SELECT * FROM `user_record` WHERE username = '$user_name'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        $user_nameErr = "[Username is taken!]";
    }else if(empty($_POST["fname"])){
 	    $fnameErr = "[Name is required!]";
    }else if(empty($_POST["email"])){
        $emailErr = "[Email is required!]";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailErr = "[Email is in invalid format. Must contain '@'.]";
    }else if(empty($_POST["email"])){
        $emailErr = "[Email is required!]";
    }else if(empty($_POST["phone"])){
        $phoneErr = "[Phone number is required!]";
    }else if (!preg_match('/^(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{4,}$/', $pass1)){
        $passwordErr = '[4-length password that contain at least ONE uppercase, ONE numeric, ONE special character and has no space!]';
 	}else{
        if($pass != $cpass){
            $cfpasswordErr = "[Password does not match!]";
        }else{
            mysqli_query($conn, "INSERT INTO `user_record`(fname, lname, username, email, phone_no, password, user_type) 
                VALUES('$fname', '$lname', '$user_name', '$email', '$phone', '$cpass', '$user_type')") or die('query failed');
            function_alert("Registered Succesfully!");
            header("Location: log-in.php");            
        }
    }
}
?>

<html>
  <head>
        <link rel="stylesheet" href="register.css">
        <link rel="stylesheet" href="font.css">
        <title>Register</title>
        <meta charset="UTF-8">
        <script>
            function enable() {
                var checkboxTerm = document.getElementById("checkbox-term");
                var signUpButton = document.getElementById("submit");

                signUpButton.disabled = !checkboxTerm.checked;
            }
        </script>
  </head>
  <body>
    <div class="register-page">
        <div class="deco-bg"></div>
        <div class="company-name">Voltex Engineering</div>
        <form class="register-part" method="post" action="">
            <div class="register-yourself">Register Yourself</div>
            <div class="your-journey">Begin your journey with us today</div>
            <div class="register-form">
                <div class="double-col">
                    <div class="fname">  
                        <label for="fname">First Name<span class="error" style="color: red;"> *</span></label><br>
                        <input type="text" id="fname" name="fname">
                        <span class="messageErr"><?php echo $fnameErr;?></span>
                    </div>
                    <div class="lname">
                        <label for="fname">Last Name</label><br>
                        <input type="text" id="lname" name="lname">
                    </div>
                </div>
                <br>
                <div class="double-col">
                    <div class="username">  
                        <label for="username">Username<span class="error" style="color: red;"> *</span></label><br>
                        <input type="text" id="username" name="username">
                        <span class="messageErr"><?php echo $user_nameErr;?></span>
                    </div>
                    <div class="email">
                        <label for="email">Email<span class="error" style="color: red;"> *</span></label><br>
                        <input type="text" id="email" name="email">
                        <span class="messageErr"><?php echo $emailErr;?></span>
                    </div>
                </div>
                <br>
                <label for="phone">Phone No<span class="error" style="color: red;"> *</span></label><br>
                <input type="number" name="phone">
                <span class="messageErr"><?php echo $phoneErr;?></span>
                <br><br>
                <label for="password">Create a Password<span class="error" style="color: red;"> *</span></label><br>
                <div class="input-pw">  
                    <div class="input"><input type="password" id="password" name="password"></div>
                    <div class="show-pw" onclick="togglePassword()">Show</div>
                </div>
                <span class="messageErr"><?php echo $passwordErr;?></span>
                <br><br>
                <label for="cfpassword">Confirm Your Password<span class="error" style="color: red;"> *</span></label><br>
                <div class="input-pw">  
                    <div class="input"><input type="password" id="cfpassword" name="cfpassword"></div>
                    <div class="show-pw" onclick="togglePasswordcf()">Show</div>
                </div>
                <span class="messageErr"><?php echo $cfpasswordErr;?></span>
            </div>
            <div class="checkbox-term">
                <input type="checkbox" id="checkbox-term" onclick="enable()">
                <label for="checkbox-term">I agree to the terms & conditions<span class="error" style="color: red;"> *</span></label>
            </div>
            <div class="btn">
                <input type="hidden" name="user_type" value="Customer">
                <button disabled="true" type="submit" name="submit" id="submit" onclick="enable()">Sign up</button>
            </div>
            <p class="have-acc">Already have account? <a href="log-in.php" class="go-log-in">Log in here.</a></p>
        </form>
    </div>
  </body>
  <script>
    function togglePassword() {
      var passwordInput = document.getElementById('password');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
      } else {
        passwordInput.type = 'password';
      }
    }

    function togglePasswordcf() {
      var passwordInput = document.getElementById('cfpassword');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
      } else {
        passwordInput.type = 'password';
      }
    }
  </script>
</html>

