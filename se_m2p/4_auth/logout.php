<?php
session_start();
// Destroy the session associated with the user
session_destroy();
// Redirect to the login page:
header('Location: index.php');
?>