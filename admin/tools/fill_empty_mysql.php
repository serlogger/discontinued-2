<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'se_load.php');
$stmt = $pdo->prepare("UPDATE services SET sc_id ='0' WHERE sc_id ='';");
if ($stmt->execute())
{
    echo "success";
}
else
{
    echo "nay";
}