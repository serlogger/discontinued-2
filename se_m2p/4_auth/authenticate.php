<?php
include(__DIR__ . '/../inc/config.php');
include(__DIR__ . '/../inc/main_functions.php');
// CSRF
if (!isset($_POST['token']) || $_POST['token'] != $_SESSION['csrf_token']) {
	exit('Incorrect token provided!');
}
// EO CSRF
// Brute force protection
$login_attempts = login_attempts($pdo, FALSE);
if ($login_attempts && $login_attempts['attempts_left'] <= 0) {
	exit('You cannot login right now! Please try again later!');
}
// EO Brute force protection
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['password'])) {
	$login_attempts = login_attempts($pdo); // Brute force prot.
	// Could not retrieve the data that should have been sent
	exit('Please fill both the username and password field!');
}
// Prepare our SQL query and find the account associated with the login details
// Preparing the SQL statement will prevent SQL injection
$stmt = $pdo->prepare('SELECT * FROM accounts WHERE username = ?');
$stmt->execute([ $_POST['username'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_SESSION['user_loggedin']))
{
	if($_SESSION['user_loggedin'] == TRUE)
	{
		exit('Already logged in');
	}
}

// Check if the account exists
if ($account) {
	// Account exists... Verify the password
	if (password_verify($_POST['password'], $account['password'])) {
		// Check if the account is activated
		if (account_activation && $account['activation_code'] != 'activated') {
			// User has not activated their account, output the message
			echo 'Please activate your account to login! Click <a href="resendactivation.php">here</a> to resend the activation email.';
		} else {
			// Verification success! User has loggedin!
			// Declare the session variables, which will basically act like cookies, but will store the data on the server as opposed to the client
			session_regenerate_id();
			$_SESSION['user_loggedin'] = TRUE;
			$_SESSION['loggedin_username'] = $account['username'];
			$_SESSION['loggedin_user_id'] = $account['id'];
			$_SESSION['loggedin_user_role'] = $account['role'];

			// Update last seen date
			$date = date('Y-m-d\TH:i:s');
			$stmt = $pdo->prepare('UPDATE accounts SET last_seen = ? WHERE id = ?');
			$stmt->execute([ $date, $account['id'] ]);
			// Output msg; do not change this line as the AJAX code depends on it
			echo 'Success';
			// Brute
			$ip = $_SERVER['REMOTE_ADDR'];
			$stmt = $pdo->prepare('DELETE FROM login_attempts WHERE ip_address = ?');
			$stmt->execute([ $ip ]);
			// EO Brute
			
		}
	} else {
		// Incorrect password
		$login_attempts = login_attempts($pdo, TRUE); // Brute force prot.
		echo 'Incorrect username and/or password! You have ' . $login_attempts['attempts_left'] . ' attempts remaining!';
	}
} else {
	// Incorrect username
	$login_attempts = login_attempts($pdo, TRUE); // Brute force prot.
	echo 'Incorrect username and/or password! You have ' . $login_attempts['attempts_left'] . ' attempts remaining!';
}
?>