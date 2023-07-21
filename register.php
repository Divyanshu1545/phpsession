<?php

include ('connect.php');


$name = $email = $password = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 
$sql="Select * from users where email='$email'";
$result=mysqli_query($conn,$sql);
if (mysqli_num_rows($result)>=1) {
  echo '<script>alert("Email already exists");</script>';
 
}else{
    
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
        
      echo '<script>alert("Registration Successful");</script>';
      } else {
      $error=mysqli_error($conn);
      echo '<script>alert("An error occured");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
  <link rel="stylesheet" href="styleRegister.css">
</head>
<body>
  <div class="register-container">
    <h2>Register</h2>
    <form method="post">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
      <a href="login.php">Already Registered? Click here to login</a>
        <input type="submit" value="Register">
      </div>
    </form>
  </div>
</body>
</html>
