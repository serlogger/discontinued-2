<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "se_m1p";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$distance = 50; // user input distance
$user_latitude = '26.826999'; // user input latitude
$user_longitude = '-158.265114'; // user input logtitude

$sql = "SELECT ROUND(6371 * acos (cos ( radians($user_latitude) ) * cos( radians( lat ) ) * cos( radians( lon ) - radians($user_longitude) ) + sin ( radians($user_latitude) ) * sin( radians( lat ) ))) AS distance,services.* FROM services HAVING distance <= $distance";

$result = $conn->query($sql);

echo '<pre>' . var_export($result, true) . '</pre>';