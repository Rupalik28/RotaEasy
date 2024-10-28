<?php
session_start(); // Start the session

// Destroy the session and remove session variables
session_destroy();

// Redirect to login page or home page
header("Location: login.php");
exit();
?>
