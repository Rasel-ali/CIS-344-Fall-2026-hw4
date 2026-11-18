
<?php

// Start the session
session_start();

// Remove all session information
$_SESSION = [];

// Destroy the session
session_destroy();

// Return to homepage
header("Location: index.php");
exit();

?>
