<?php

function sstart() {
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
}

function random_str(
    int $length = 32,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}


function san($string) {
	return filter_var($string, FILTER_SANITIZE_STRING);
}

function san_int($string) {
	return filter_var($string, FILTER_SANITIZE_INT);
}

function san_email($string) {
	return filter_var($string, FILTER_SANITIZE_EMAIL);
}

function san_url($string) {
	return filter_var($string, FILTER_SANITIZE_URL);
}



//JMforms + own

//Hash a (set of) string(s)
if (!function_exists('hash_2')){
	function hash_2($str) {
		$str_salted = sprintf('%s%s', $str, TWO_SALT);
		$result = hash('sha512', $str_salted);
		return $result;
	}
}

/*End of JM forms*/

//Validate sec_cookie
function validate_sec_cookie() {
	if(isset($_COOKIE[$_SESSION['sec_cookie_name']]))
	{
		if($_COOKIE[$_SESSION['sec_cookie_name']] == $_SESSION['sec_cookie_value'])
		{
			echo "Cookie matches session data";
		} else {
			echo "Cookie does not match session data";
		}
	} else {
		echo "No cookie found";
	}
}

// AUTH MAIN

// Check if the user is logged-in and update their last seen data
function update_last_seen($pdo, $redirect_file = 'index.php') {
	// If you want to update the "last seen" column on every page load, you can uncomment the below code
	if (isset($_SESSION['user_loggedin'])) {
		$date = date('Y-m-d\TH:i:s');
		$stmt = $pdo->prepare('UPDATE accounts SET last_seen = ? WHERE id = ?');
		$stmt->execute([ $date, $_SESSION['loggedin_user_id'] ]);
	}
}

// The main file contains the database connection, session initializing, and functions, other PHP files will depend on this file.
// // Include the configuration file
// include_once 'config.php';
// We need to use sessions, so you should always start sessions using the below code.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
// Connect to the MySQL database using the PDO interface
try {
	$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to database!');
}
// Send activation email function
function send_activation_email($email, $code) {
	// Email Subject
	$subject = 'Account Activation Required';
	// Email Headers
	$headers = 'From: ' . mail_from . "\r\n" . 'Reply-To: ' . mail_from . "\r\n" . 'Return-Path: ' . mail_from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
	// Activation link
	$activate_link = activation_link . '?email=' . $email . '&code=' . $code;
	// Read the template contents and replace the "%link" placeholder with the above variable
	// echo(__DIR__ . '/activation-email-template.html');
	$email_template = str_replace('%link%', $activate_link, file_get_contents(__DIR__ . '/activation-email-template.html'));
	// Send email to user
	mail($email, $subject, $email_template, $headers);
}
// Brute force protection
function login_attempts($pdo, $update = TRUE) {
	$ip = $_SERVER['REMOTE_ADDR'];
	$now = date('Y-m-d H:i:s');
	if ($update) {
		$stmt = $pdo->prepare('INSERT INTO login_attempts (ip_address, `date`) VALUES (?,?) ON DUPLICATE KEY UPDATE attempts_left = attempts_left - 1, `date` = VALUES(`date`)');
		$stmt->execute([ $ip, $now ]);
	}
	$stmt = $pdo->prepare('SELECT * FROM login_attempts WHERE ip_address = ?');
	$stmt->execute([ $ip ]);
	$login_attempts = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($login_attempts) {
		// The user can try to login after 1 day... change the "+1 day" if you want to increase/decrease this date.
		$expire = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($login_attempts['date'])));
		if ($now > $expire) {
			$stmt = $pdo->prepare('DELETE FROM login_attempts WHERE ip_address = ?');
			$stmt->execute([ $ip ]);
			$login_attempts = array();
		}
	}
	return $login_attempts;
}
// EO Brute force protection
//EO AUTH MAIN






//OLD main_functions, clean this up:

if (!function_exists('sstart')) {
	function sstart() {
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
		}
	}
}

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

function rowCount($file) {
    $linecount = 0;
    $handle = fopen($file, "r");
    while(!feof($handle)){
      $line = fgets($handle);
      $linecount++;
    }

    fclose($handle);

    echo $linecount;
}

function pdo_connect_mysql() {
    try {
    	return new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}

$pdo = pdo_connect_mysql();
//$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$con = pdo_connect_mysql();

if(!function_exists('connect')){
	function connect(){
		global $pdo;
		try { $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
		} catch (PDOException $exception) {
			// If there is an error with the connection, stop the script and display the error.
			exit('Failed to connect to database!');
		}
	}
}

// Send activation private_email function
if (!function_exists('send_activation_email')) {
	function send_activation_email($email, $code) {
		$subject = 'Account Activation Required';
		$headers = 'From: ' . mail_from . "\r\n" . 'Reply-To: ' . mail_from . "\r\n" . 'Return-Path: ' . mail_from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
		$activate_link = activation_link . '?email=' . $email . '&code=' . $code;
		$email_template = str_replace('%link%', $activate_link, file_get_contents('activation-email-template.html'));
		mail($email, $subject, $email_template, $headers);
	}
}

//Base for index & htaccess
if(!function_exists('base')) {
	function base(){
		echo dirname($_SERVER['PHP_SELF']) . DIRECTORY_SEPARATOR;
	}
}







function template_header($title) {
	$sh = $_SESSION['home'];
	if(!isset($_SESSION['theme']))
	{
		$_SESSION['theme'] = 'blue';
	}
	require_once('header.php');
//require_once $_SESSION['rt'].'/inc/navtop.php';
}


function template_footer($title) {
	require_once('footer.php');
}


//JMforms + own

//Hash of two strings
if (!function_exists('hash_2')){
	function hash_2($str) {
		$str_salted = sprintf('%s%s', $str, TWO_SALT);
		$result = hash('sha512', $str_salted);
		return $result;
	}
}

//Create nonce
if (!function_exists('create_nonce') ) {
	function create_nonce($action, $time) {
		$str = sprintf('%s%s%s%s', NONCE_SALT_ADD_SRV1, $action, $time, NONCE_SALT_ADD_SRV2);

		$nonce = hash_2($str);

        return $nonce;
	}
}

//Verify nonce
if (!function_exists('verify_nonce')) {
	function verify_nonce($nonce, $action, $time) {
		$check = create_nonce($action, $time);

		if ($nonce == $check) {
			return true;
		} else {
			return false;
		}
	}
}



//Status messages
if ( ! function_exists ('do_messages')) {
	function do_messages($insert=NULL) {
		if ( is_null($insert)) {
			return;
		}

		$message = '<div class="message">';

		if ( $insert == true ) {
			$message .= '<p class="success">Data was inserted successfully.</p>';
		} else {
			$message .= '<p class="error">There was an error with the submission.</p>';
		}
		$message .= '</div>';

		return $message;
	}
}

/*End of JM forms*/

//ROUTER
if (!function_exists('out'))
{
	function out($text){echo htmlspecialchars($text);}
}

if (!function_exists('set_csrf'))
{
	function set_csrf(){
	if( ! isset($_SESSION["csrf"]) ){ $_SESSION["csrf"] = bin2hex(random_bytes(50)); }
	echo '<input type="hidden" name="csrf" value="'.$_SESSION["csrf"].'">';
	}
}

if (!function_exists('is_csrf_valid'))
{
	function is_csrf_valid(){
	if( ! isset($_SESSION['csrf']) || ! isset($_POST['csrf'])){ return false; }
	if( $_SESSION['csrf'] != $_POST['csrf']){ return false; }
	return true;
	}
}
//EO ROUTER

//Login filter that returns true only if the user is logged in correctly
if (!function_exists("se_login_filter")) {
	function se_login_filter() {
		if(!isset($_SESSION['user_loggedin']) || !isset($_SESSION['loggedin_username']) || !isset($_SESSION['loggedin_user_id']) || !isset($_SESSION['loggedin_user_role'])) {
			return false;
		}
		if(!$_SESSION['user_loggedin'] === true) {
			return false;
		}
	}
}
//EO Login filter