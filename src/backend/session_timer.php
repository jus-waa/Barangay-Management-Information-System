<?php
$session_timeout = 3600; 
// Check if session start time exists, if not, set it
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();  // Set current time as session start
}
// Calculate the remaining time
$remaining_time = $session_timeout - (time() - $_SESSION['start_time']);

// If the session has expired, log out the user
if ($remaining_time <= 0) {
    session_unset();  // Clear session variables
    session_destroy(); // Destroy the session
    header("Location: login.php");  // Redirect to login page after session expiration
    exit();
}
?>
