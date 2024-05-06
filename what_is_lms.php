<?php

// Start the session
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or any other desired page
header("Location: teacher-login.php");
exit;

?>


// Sample comment only
// Test for GitHub commands
// Test comment for dev2
// New comment for dev2