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

$ds = DIRECTORY_SEPARATOR;


// For mysqli, get rid of this:
    $servername = 'localhost';
    $username   = 'root';
    $password   = '';
    $dbname     = "se_m1p";
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
	$_SESSION['rt'] = $_SERVER['DOCUMENT_ROOT'] . $ds . "se_m2p";
}

//Setting home for HTML
if (!isset($_SESSION['home']))
{
	$_SESSION['home'] = '/public/';
}

//Setting home for HTML
if (!isset($_SESSION['hm']))
{
	$_SESSION['hm'] = '/se_m2p/';
}

require_once $_SESSION['rt'] .$ds. $inc .$ds. 'config.php';
require_once $_SESSION['rt'] .$ds. $inc .$ds. 'main_functions.php';

//Lang, get rid of this
require_once $_SESSION['rt'] .$ds. $inc .$ds. $lng .$ds. 'lang_session.php';
$current_lang = $_SESSION['lang'];
//EO Lang, get rid of this

$cid = isset($_SESSION['creator_id'])?$_SESSION['creator_id']:"";
$current_currency = "EUR";
$current_distance_unit = "km";


//Setting some cookies for security
//Setting a security check cookies that change name and value on every page load
if(isset($_SESSION['sec_cookie_name']))
{
	if(isset($_COOKIE[$_SESSION['sec_cookie_name']]))
	{
		unset($_COOKIE[$_SESSION['sec_cookie_name']]);
		setcookie($_SESSION['sec_cookie_name'], "", time()-3600);
	}
}
$_SESSION['sec_cookie_name'] = random_str(32);
$_SESSION['sec_cookie_value'] = random_str(32);
setcookie($_SESSION['sec_cookie_name'], $_SESSION['sec_cookie_value'],
	[
	'secure' => true,
	'httponly' => true,
	'samesite' => 'Strict',
	]
	);

if(isset($_SESSION['sec_cookie_name_2']))
{
	if(isset($_COOKIE[$_SESSION['sec_cookie_name_2']]))
	{
		unset($_COOKIE[$_SESSION['sec_cookie_name_2']]);
		setcookie($_SESSION['sec_cookie_name_2'], "", time()-3600);
	}
}
//EO Setting a security check cookies that change name and value on every page load

$_SESSION['sec_cookie_name_2'] = "sessionid";
$_SESSION['sec_cookie_value_2'] = random_str(32);
setcookie($_SESSION['sec_cookie_name_2'], $_SESSION['sec_cookie_value_2'],
	[
	'secure' => true,
	'httponly' => true,
	'samesite' => 'Strict',
	]
	);

$_SESSION['sec_hidden'] = random_str(16); //kinda like cookie but session only
// EO Setting some cookies for security