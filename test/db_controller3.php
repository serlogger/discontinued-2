<?php
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$username = "root";
$servername = "localhost";
$password = "";
try {
  $conn = new PDO("mysql:host=$servername;dbname=se_m1p", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

if(!isset($_POST['se_function'])) { return false; }
if($_POST['se_function'] == "ajax_filter_items") { require_once "db/ajax_filter_items3.php"; }