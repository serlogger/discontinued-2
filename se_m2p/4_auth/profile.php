<?php
include 'main.php';
// Check logged-in
update_last_seen($pdo);
// output message (errors, etc)
$msg = '';
// Retrieve additional account info from the database because we don't have them stored in sessions
$stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
// In this case, we can use the account ID to retrieve the account info.
$stmt->execute([ $_SESSION['loggedin_user_id'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
// Handle edit profile post data
if (isset($_POST['username'], $_POST['password'], $_POST['cpassword'], $_POST['email'])) {
	// Make sure the submitted registration values are not empty.
	if (empty($_POST['username']) || empty($_POST['email'])) {
		$msg = 'The input fields must not be empty!';
	} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$msg = 'Please provide a valid email address!';
	} else if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
	    $msg = 'Username must contain only letters and numbers!';
	} else if (!empty($_POST['password']) && (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5)) {
		$msg = 'Password must be between 5 and 20 characters long!';
	} else if ($_POST['cpassword'] != $_POST['password']) {
		$msg = 'Passwords do not match!';
	}
	// No validation errors... Process update
	if (empty($msg)) {
		// Check if new username or email already exists in database
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM accounts WHERE (username = ? OR email = ?) AND username != ? AND email != ?');
		$stmt->execute([ $_POST['username'], $_POST['email'], $_SESSION['loggedin_username'], $account['email'] ]);
		// Account exists? Output error...
		if ($result = $stmt->fetchColumn()) {
			$msg = 'Account already exists with that username and/or email!';
		} else {
			// No errors occured, update the account...
			// If email has changed, generate a new activation code
			$uniqid = account_activation && $account['email'] != $_POST['email'] ? uniqid() : $account['activation_code'];
			$stmt = $pdo->prepare('UPDATE accounts SET username = ?, password = ?, email = ?, activation_code = ? WHERE id = ?');
			// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
			$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $account['password'];
			$stmt->execute([ $_POST['username'], $password, $_POST['email'], $uniqid, $_SESSION['loggedin_user_id'] ]);
			// Update the session variables
			$_SESSION['loggedin_username'] = $_POST['username'];
			if (account_activation && $account['email'] != $_POST['email']) {
				// Account activation required, send the user the activation email with the "send_activation_email" function from the "main.php" file
				send_activation_email($_POST['email'], $uniqid);
				// Logout the user
				unset($_SESSION['user_loggedin']);
				$msg = 'You have changed your email address! You need to re-activate your account!';
			} else {
				// Profile updated successfully, redirect the user back to the profile page
				header('Location: profile.php');
				exit;
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Website Title</h1>
				<a href="home.php"><i class="fas fa-home"></i>Home</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<?php if ($_SESSION['loggedin_user_role'] == 'Admin'): ?>
				<a href="admin/index.php" target="_blank"><i class="fas fa-user-cog"></i>Admin</a>
				<?php endif; ?>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<?php if (!isset($_GET['action'])): ?>
		<div class="content profile">

			<h2>Profile Page</h2>

			<div class="block">

				<p>Your account details are below.</p>

				<div class="profile-detail">
					<strong>Username</strong>
					<?=$_SESSION['loggedin_username']?>
				</div>

				<div class="profile-detail">
					<strong>Email</strong>
					<?=$account['email']?>
				</div>

				<div class="profile-detail">
					<strong>Role</strong>
					<?=$account['role']?>
				</div>

				<div class="profile-detail">
					<strong>Registered</strong>
					<?=$account['registered']?>
				</div>

				<a class="profile-btn" href="profile.php?action=edit">Edit Details</a>

			</div>

		</div>
		<?php elseif ($_GET['action'] == 'edit'): ?>
		<div class="content profile">

			<h2>Edit Profile Page</h2>

			<div class="block">

				<form action="profile.php?action=edit" method="post">

					<label for="username">Username</label>
					<input type="text" value="<?=$_SESSION['loggedin_username']?>" name="username" id="username" placeholder="Username">

					<label for="password">New Password</label>
					<input type="password" name="password" id="password" placeholder="New Password">

					<label for="cpassword">Confirm Password</label>
					<input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password">

					<label for="email">Email</label>
					<input type="email" value="<?=$account['email']?>" name="email" id="email" placeholder="Email">

					<div>
						<input class="profile-btn" type="submit" value="Save">
					</div>

					<p><?=$msg?></p>

				</form>

			</div>

		</div>
		<?php endif; ?>
	</body>
</html>