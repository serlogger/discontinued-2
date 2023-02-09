<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$_SESSION['language'] = filter_var($_POST['language'], FILTER_SANITIZE_STRING);
