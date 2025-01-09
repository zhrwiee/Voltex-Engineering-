<?php

include ('connect-server.php');

session_start();

$mesgErr = "";

if (isset($_POST['submit'])) {

  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

  $select_users = mysqli_query($conn, "SELECT * FROM `user_record` WHERE username = '$username' AND password = '$pass'") or die('query failed');
  $select_electrician = mysqli_query($conn, "SELECT * FROM `electrician` WHERE username = '$username' AND password = '$pass'") or die('query failed');

  if (mysqli_num_rows($select_users) > 0) {
    $row = mysqli_fetch_assoc($select_users);
    if ($row['user_type'] == 'Customer') {
      $_SESSION['username'] = $row['username'];
      $_SESSION['user_email'] = $row['email'];
      $_SESSION['user_id'] = $row['user_id'];
      header('location:index.php');
    }
  } elseif (mysqli_num_rows($select_electrician) > 0) {
    $row = mysqli_fetch_assoc($select_electrician);
    if ($row['user_type'] == 'Admin') {
      $_SESSION['username'] = $row['username'];
      $_SESSION['user_email'] = $row['email'];
      $_SESSION['user_id'] = $row['id'];
      header('location:dashboard-admin.php');
    } elseif ($row['user_type'] == 'Electrician') {
      $_SESSION['username'] = $row['username'];
      $_SESSION['user_email'] = $row['email'];
      $_SESSION['user_id'] = $row['id'];
      header('location:dashboard-electrician.php');
    }
  } else {
    $mesgErr = "[Incorrect username or password!]";
  }
}

if (isset($_POST['validate'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);

  $query = "SELECT * FROM `user_record` WHERE username = '$username' AND email = '$email'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
      header('Location: forgot-pw.php?username='.urlencode($username));
      exit();
  } else {
      echo "No matching account found. Please check your inputs.";
  }
}
?>

<html>
  <head>
      <link rel="stylesheet" href="log-in.css">
      <meta charset="UTF-8">
      <title>Login</title>
  </head>
  <body>
    <div class="log-in-page">
        <div class="deco-bg"></div>
        <div class="company-name">Voltex Engineering</div>
        <div class="log-in-part">
          <div class="welcome-back">Welcome Back</div>
          <div class="your-progress">Log in to continue your progress</div>
          <form method="post" action="">
            <div class="log-in-form">
                <label for="username">Username</label><br>
                <input type="text" id="username" name="username">
                <br><br>
                <label for="username">Password</label><br>
                <div class="input-pw">  
                    <div class="input"><input type="password" id="password" name="password"></div>
                    <div class="show-pw" onclick="togglePassword()">Show</div>
                </div><br>
                <span class="messageErr"><?php echo $mesgErr;?></span>
            </div>
            <a href="#" class="forget-pw" onclick="showForgotPasswordForm()">Forgot Password?</a><br>
            <div class="btn"><button type="submit" name="submit" id="log-in-btn" class="log-in-btn">Log In</button></div>
            <p class="no-acc">Don't have account? <a href="register.php" class="go-register">Register Here</a></p><br>
          </form>
      </div>
    </div>
    <div id="forgotPasswordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeForgotPasswordForm()">&times;</span>
            <div class="title-pw">Forgot Password</div>
            <div class="desc">Please validate your account first</div>
            <form method="POST" action="log-in.php"> 
              <label for="username">Username</label><br>
              <input type="text" id="username" name="username" required>
              <br><br>
              <label for="email">Email</label><br>
              <input type="email" id="email" name="email" required>
              <br>
              <div class="btn">
                <input type="submit" name="validate" value="Submit">
              </div>
            </form>
        </div>
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

    function showForgotPasswordForm() {
      document.getElementById("forgotPasswordModal").style.display = "block";
    }

    function closeForgotPasswordForm() {
      document.getElementById("forgotPasswordModal").style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == document.getElementById("forgotPasswordModal")) {
        closeForgotPasswordForm();
      }
    }
  </script>
</html>