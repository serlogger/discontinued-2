
		<div id="tab_1_content" class="tab_content tab_1" style="display:none;">
			<?php

			// CSRF
			$_SESSION['csrf_token'] = md5(uniqid(rand(), true));
			// EO CSRF
			?>

			<div class="login">

				<h1>Login</h1>

				<div class="links">
					<a href="index.php" class="active">Login</a>
					<a href="<?=$register?>">Register</a>
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
			// AJAX code for login
			let loginForm = document.querySelector(".login form");
			loginForm.onsubmit = event => {
				event.preventDefault();
				fetch(loginForm.action, { method: 'POST', body: new FormData(loginForm) }).then(response => response.text()).then(result => {
					if (result.toLowerCase().includes("success")) {
						view_user_logged('in');
						open_static_tab(localStorage.getItem('cfg_services_tab'), 'html')
					} else if ((result.toLowerCase().includes("already logged in"))) {
						view_user_logged('in');
						open_static_tab(localStorage.getItem('cfg_services_tab'), 'html')
						//Turn login tab into "logout" tab
						//If logout is clicked, give a message "logged out successfully"
						//Location doesn't need to change
					} else {
						document.querySelector(".msg").innerHTML = result;
					}
				});
			};
			</script>
			
		</div>