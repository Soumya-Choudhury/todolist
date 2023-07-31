<?php
session_start(); // Start or resume the PHP session

// Clear all session data to log the user out
session_unset();
session_destroy();

// Redirect the user to the login page after logout
header('Location: login.php'); // Replace 'login.html' with the actual login page
exit();
?>
