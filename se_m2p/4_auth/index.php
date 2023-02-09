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
		<title>Login</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="login">

			<h1>Login</h1>

			<div class="links">
				<a href="index.php" class="active">Login</a>
				<a href="register.php">Register</a>
			</div>

			<form action="authenticate.php" method="post">

				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>

				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>

				<a href="forgotpassword.php">Forgot Password?</a>

				<input type="hidden" name="token" value="<?=$_SESSION['csrf_token']?>">
				<div class="msg"></div>

				<input type="submit" value="Login">

			</form>

		</div>

		<script>
		// AJAX code
		let loginForm = document.querySelector(".login form");
		loginForm.onsubmit = event => {
			event.preventDefault();
			fetch(loginForm.action, { method: 'POST', body: new FormData(loginForm) }).then(response => response.text()).then(result => {
				if (result.toLowerCase().includes("success")) {
					window.location.href = "home.php";
				} else {
					document.querySelector(".msg").innerHTML = result;
				}
			});
		};
		</script>
	</body>
</html>