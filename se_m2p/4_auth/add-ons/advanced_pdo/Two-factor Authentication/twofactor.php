<?php
include 'main.php';
// Output message
$msg = '';
// Verify the ID and email provided
if (isset($_SESSION['tfa_code'], $_SESSION['tfa_email'], $_SESSION['tfa_id'])) {
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ? AND email = ?');
    $stmt->execute([ $_SESSION['tfa_id'], $_SESSION['tfa_email'] ]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    // If the account exists with the email & ID provided...
    if ($account) {
        // Account exist
        if (isset($_POST['code'])) {
            // Code submitted via the form
            if ($_POST['code'] == $account['tfa_code']) {
                // Code accepted, update the IP address
                $ip = $_SERVER['REMOTE_ADDR'];
                $stmt = $pdo->prepare('UPDATE accounts SET ip = ? WHERE id = ?');
                $stmt->execute([ $ip, $account['id'] ]);
                // Destroy tfa session variables
                unset($_SESSION['tfa_code']);
                unset($_SESSION['tfa_email']);
                unset($_SESSION['tfa_id']);
                // Authenticate the user
                session_regenerate_id();
                $_SESSION['user_loggedin'] = TRUE;
                $_SESSION['loggedin_username'] = $username;
                $_SESSION['loggedin_user_id'] = $id;
                $_SESSION['loggedin_user_role'] = $role;
                // Redirect to home page
                header('Location: home.php');
                exit;
            } else {
                $msg = 'Incorrect code provided!';
            }
        } else {
            // Send the access code email using the twofactor.html template
            $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
            $stmt = $pdo->prepare('UPDATE accounts SET tfa_code = ? WHERE id = ?');
            $stmt->execute([ $code, $account['id'] ]);
            $subject = 'Your Access Code';
        	$headers = 'From: ' . mail_from . "\r\n" . 'Reply-To: ' . mail_from . "\r\n" . 'Return-Path: ' . mail_from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        	$email_template = str_replace('%code%', $code, file_get_contents('twofactor.html'));
        	mail($account['email'], $subject, $email_template, $headers, mail_from);
        }
    } else {
        exit('No email and/or ID provided!');
    }
} else {
    exit('No email and/or ID provided!');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>Two-factor Authentication</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="login">
			<h1>Two-factor Authentication</h1>
            <p style="padding:15px;margin:0;">Please enter the code that was sent to your email address below.</p>
			<form action="" method="post">
                <label for="code">
					<i class="fas fa-lock"></i>
				</label>
				<input type="text" name="code" placeholder="Your Code" id="code" required>
				<div class="msg"><?=$msg?></div>
				<input type="submit" value="Submit">
			</form>
		</div>
	</body>
</html>