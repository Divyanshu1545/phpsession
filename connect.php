<?php
// Replace these variables with your actual database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'php_session';

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
