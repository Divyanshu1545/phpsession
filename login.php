<?php



require_once('connect.php');


session_start();


if (isset($_SESSION['user_id'])) {
    header("Location: restricted_page.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $row['password'])) {
            
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['name'];
            $_SESSION['terms_and_conditions']=$row['terms_and_conditions'];
            header("Location: restricted_page.php");
            exit();
        } else {
            
            echo '<script>alert("Invalid password");</script>';
        }
    } else {
        
        echo '<script>alert("User not found");</script>';
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
        <input type="text" id="email" name="email" autocomplete="off"  required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" autocomplete="new-password" required>
      </div>
      <div class="form-group">
        <a href="register.php">Not registered? Register here.</a>
        <input type="submit" value="Login">
      </div>
    </form>
  </div>
</body>
</html>
