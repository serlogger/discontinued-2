<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$admin = "admin"; $adm = $admin;
$auth = "5-auth";
$images = "images"; $img = $images;
$inc = "inc";
$includes = "includes";
$lng = "lang";
$load = "load";
$media = "media"; $med = $media;
$processors = "processors"; $proc = $processors;
$styles = "styles"; $styl = $styles;
$uploads = "uploads"; $upl = $uploads;
$view = "view";

$se_db = 'se_m1p';
$se_db_pass = 'root';
$ds = DIRECTORY_SEPARATOR;


// For mysqli, get rid of this:
    $servername = 'localhost';
    $username   = $se_db_pass;
    $password   = '';
    $dbname     = $se_db;
    $conn       = mysqli_connect($servername,$username,$password,"$dbname");
    
    if(!$conn){
        die('Could not Connect MySql Server:' .mysql_error());
    }

//Setting root for PHP
if (!isset($_SESSION['root']))
{
	//$_SESSION['root'] = dirname(__FILE__); for older php
	$_SESSION['root'] = $_SERVER['DOCUMENT_ROOT'] .$ds. 'public';
}

if (!isset($_SESSION['rt']))
{
	//$_SESSION['root'] = dirname(__FILE__); for older php
	$_SESSION['rt'] = $_SERVER['DOCUMENT_ROOT'];
}

//Setting home for HTML
if (!isset($_SESSION['home']))
{
	$_SESSION['home'] = '/public/';
}

//Setting home for HTML
if (!isset($_SESSION['hm']))
{
	$_SESSION['hm'] = '/';
}

require_once $_SESSION['rt'] .$ds. $inc .$ds. 'config.php';
require_once $_SESSION['rt'] .$ds. $inc .$ds. 'main_functions.php';
require_once $_SESSION['rt'] .$ds. $inc .$ds. $lng .$ds. 'lang_session.php';
$current_lang = $_SESSION['lang'];

$cid = isset($_SESSION['creator_id'])?$_SESSION['creator_id']:"";
$current_currency = "EUR";
$current_distance_unit = "km";