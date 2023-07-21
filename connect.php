<?php

$host = 'localhost';
$username = 'pma';
$password = 'password';
$database = 'basic_crud';


$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
