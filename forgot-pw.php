<?php
include('connect-server.php'); 

$message = "";
$username = ""; 

if (isset($_GET['username'])) {
    $username = mysqli_real_escape_string($conn, $_GET['username']);
} else {
    $message = "Invalid request. Please initiate the password reset process again.";
}

if (isset($_POST['reset'])) {
    $newPassword = md5($_POST['newPassword']);
    $confirmPassword = md5($_POST['confirmPassword']);

    if ($newPassword === $confirmPassword) {
        $stmt = $conn->prepare("UPDATE `user_record` SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $confirmPassword, $username);

        if ($stmt->execute()) {
            echo "<script>alert('Your password has been reset. Go to login page?');</script>";
            echo "<script>setTimeout(function(){ window.location.href = 'log-in.php'; }, 2000);</script>";
            exit;
        } else {
            $message = "Failed to update your password. Please try again.";
        }
        $stmt->close();
    } else {
        $message = "Passwords do not match. Please try again.";
    }
}
?>

<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="forgot-pw.css">
</head>
<body>
    <div class="reset-password-container">
        <div class="title">Reset Your Password</div>
        <?php if (!empty($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <?php if (!empty($username)): ?>
        <form action="" method="post">
            <label for="newPassword">New Password</label><br>
            <input type="password" id="newPassword" name="newPassword" required>
            <br><br>
            <label for="confirmPassword">Confirm Password</label><br>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            <br><br>
            <div class="btn">
                <input type="submit" name="reset" value="Reset Password">
            </div>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
