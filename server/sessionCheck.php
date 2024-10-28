<?php
// sessionCheck.php

session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['name'])) {
    // If not logged in, redirect to login page
    header("Location: ../public/login.php");
    exit();
}

// Optionally, you can add user role checks if necessary
// if ($_SESSION['user_role'] != 'admin') {
//     // Redirect to a different page if the user is not an admin
//     header("Location: index.php"); // Change as needed
//     exit();
// }
?>
