<?php
// login.php

// Include the database connection file
require_once('connect.php');

// Start the session
session_start();

// Check if the user is already logged in, redirect to the restricted page if so
if (isset($_SESSION['user_id'])) {
    header("Location: restricted_page.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform database query to get user data based on email
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password matches, login successful
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['name'];
            header("Location: restricted_page.php");
            exit();
        } else {
            // Password does not match
            $error_message = "Invalid password!";
        }
    } else {
        // User not found
        $error_message = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php if (isset($error_message)) { ?>
      <p class="error"><?php echo $error_message; ?></p>
    <?php } ?>
    <form method="post">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <input type="submit" value="Login">
      </div>
    </form>
  </div>
</body>
</html>
