<?php
// restricted_page.php

// Include the check_login.php file to verify if the user is logged in
require_once('check_login.php');

// Include the database connection file
require_once('connect.php');

// Fetch all users from the database
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

// Check if any users exist
if (mysqli_num_rows($result) > 0) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $users = array();
}

// Handle updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_id']) && !empty($_POST['update_id'])) {
        $update_id = $_POST['update_id'];
        $new_name = $_POST['new_name'];
        $new_email = $_POST['new_email'];

        $update_sql = "UPDATE users SET name='$new_name', email='$new_email' WHERE id='$update_id'";
        if (mysqli_query($conn, $update_sql)) {
            header("Location: restricted_page.php");
            exit();
        }
    }
}

// Handle deleting users
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $delete_sql = "DELETE FROM users WHERE id='$delete_id'";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: restricted_page.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restricted Page</title>
  <link rel="stylesheet" href="style2.css">
</head>
<body>
  <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
  <p>This is a restricted page that only logged-in users can access.</p>
  
  <h2>Users:</h2>
  <?php if (count($users) > 0) { ?>
    <table>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
      <?php foreach ($users as $user) { ?>
        <tr>
          <td><?php echo $user['name']; ?></td>
          <td><?php echo $user['email']; ?></td>
          <td>
            <form method="post">
              <input type="hidden" name="update_id" value="<?php echo $user['id']; ?>">
              <input type="text" name="new_name" required value="<?php echo $user['name']; ?>">
              <input type="text" name="new_email" required value="<?php echo $user['email']; ?>">
              <input type="submit" value="Save">
            </form>
          </td>
          <td>
            <a href="restricted_page.php?delete_id=<?php echo $user['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
          </td>
        </tr>
      <?php } ?>
    </table>
  <?php } else { ?>
    <p>No users found.</p>
  <?php } ?>

  <a href="logout.php">Logout</a>
</body>
</html>
