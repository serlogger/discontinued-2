<?php
    $from = $_POST["from"];
    $to = $_POST["to"];
    $amount = $_POST["amount"];

$string = $from . "_" . $to;
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://free.currconv.com/api/v7/convert?q=" . $string . "&compact=ultra&apiKey=22653035cde716a8e7f8",
    CURLOPT_RETURNTRANSFER => 1
));

$response = curl_exec($curl);
print_r($response);