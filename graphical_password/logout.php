<!-- logout.php -->
<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php"); // Redirect to the homepage or login page after logout
exit;
?>
