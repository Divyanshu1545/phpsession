<?php
// logout.php

// Start the session
session_start();

// Destroy the session and redirect to the login page or any other page you prefer
session_destroy();
header("Location: login.php");
exit();
?>
