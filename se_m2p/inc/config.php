<?php
//Auth config
// database hostname
define('DB_HOST','localhost');
// database username
define('DB_USER','root');
// database password
define('DB_PASS','');
// database name
define('DB_NAME','se_m1p');
// database charset - change this only if utf8 is unsupported by your language
define('DB_CHARSET','utf8');
/* Registration */
define('auto_login_after_register',false);
/* Account Activation */
// Email activation variables
// Change "Your Company Name" and "yourdomain.com" - do not remove the < and > characters
define('mail_from','Your Company Name <noreply@yourdomain.com>');
// Location variables
$domain = "localhost/se_m2p/";
$auth = "auth/";
$register = $auth . "register.php";
$auth_main = $auth . "main.php";

//EO Auth config

// Email activation variables
// account activation required?
define('account_activation',true);
// Link to activation file, update this
define('activation_link','localhost/phplogin/activate.php');
define('SERVICES_TABLE','services');
define("SUPPORT", "support@serlog.me");
define("ERRORS", "errors@serlog.me");
define("TWO_SALT", "Eink4lrvZ2IvtreA5OyfWPvBBpuWTWcf");

// "PayMeth"
define("cryptocurrencies", array(
    "Bitcoin" => "Bitcoin",
    "Ethereum" => "Ethereum",
    "Monero" => "Monero",
    "Litecoin" => "Litecoin"
));

