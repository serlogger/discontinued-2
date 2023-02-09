<?php 
session_start();
//echo $_SESSION['time_sess'] . "\n";
if (isset($_SESSION['time_sess'])) {unset($_SESSION['time_sess']);}
$_SESSION['time_sess'] = time();
//echo $_SESSION['time_sess'];
header("Location: add_service.php");
