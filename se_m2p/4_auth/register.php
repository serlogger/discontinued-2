<?php
include 'main.php';
// No need for the user to see the login form if they're logged-in, so redirect them to the home page
if (isset($_SESSION['user_loggedin'])) {
	// If the user is not logged in, redirect to the home page.
    header('Location: home.php');
    exit;
}
// CSRF
$_SESSION['csrf_token'] = md5(uniqid(rand(), true));
// EO CSRF
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>Register</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="register">

			<h1>Register</h1>

			<div class="links">
				<a href="index.php">Login</a>
				<a href="register.php" class="active">Register</a>
			</div>

			<form action="register-process.php" method="post" autocomplete="off">

				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>

				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>

				<label for="cpassword">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="cpassword" placeholder="Confirm Password" id="cpassword" required>

				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="email" name="email" placeholder="Email" id="email" required>
				<div class="captcha">
					<img src="/se_m2p/auth/captcha.php" width="150" height="50">
					<input type="text" id="captcha" name="captcha" placeholder="Enter captcha code" title="Please enter the captcha code!" required>
				</div>
				<input type="hidden" name="token" value="<?=$_SESSION['csrf_token']?>">
				<div class="msg"></div>

				<input type="submit" value="Register">

			</form>

		</div>

		<script>
		// AJAX code
		let registrationForm = document.querySelector('.register form');
		registrationForm.onsubmit = event => {
			event.preventDefault();
			fetch(registrationForm.action, { method: 'POST', body: new FormData(registrationForm) }).then(response => response.text()).then(result => {
				if (result.toLowerCase().includes("autologin")) {
					window.location.href = "home.php";
				} else {
					document.querySelector(".msg").innerHTML = result;
				}
			});
		};
		</script>		
	</body>
</html>