<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'se_load.php');
$_SESSION['color_tab'] = 'settings';
$_SESSION['redirect_to'] = 'settings';
require_once $_SESSION['rt'] .$ds. $inc .$ds. 'messages.php';
update_last_seen($pdo);


if (isset($_SESSION['creator_id']) && isset($_SESSION['user_loggedin']))
{
	if(isset($_POST['rosa']))
	{
		$_SESSION['theme'] = 'rosa';
		$stmt = $pdo->prepare('UPDATE users SET theme = ? WHERE id = ?');
		$stmt->execute([$_SESSION['theme'], $_SESSION['creator_id']]);
		

	} elseif(isset($_POST['blue'])) {
		$_SESSION['theme'] = 'blue';
		$stmt = $pdo->prepare('UPDATE users SET theme = ? WHERE id = ?');
		$stmt->execute([$_SESSION['theme'], $_SESSION['creator_id']]);
	} 
	elseif(isset($_POST['dark'])) {
		$_SESSION['theme'] = 'dark';
		$stmt = $pdo->prepare('UPDATE users SET theme = ? WHERE id = ?');
		$stmt->execute([$_SESSION['theme'], $_SESSION['creator_id']]);
	}

	if(isset($_SESSION['lang']))
	{
		$stmt = $pdo->prepare('UPDATE users SET language = ? WHERE id = ?');
		$stmt->execute([$_SESSION['lang'], $_SESSION['creator_id']]);
	}
} else {
	if(isset($_POST['rosa']))
	{
		$_SESSION['theme'] = 'rosa';

	} elseif(isset($_POST['blue'])) {
		$_SESSION['theme'] = 'blue';
	} elseif(isset($_POST['dark'])) {
		$_SESSION['theme'] = 'dark';
	} elseif(isset($_POST['auto_blue'])) {
		$_SESSION['theme'] = 'auto_blue';
	} elseif(isset($_POST['auto_rosa'])) {
		$_SESSION['theme'] = 'auto_rosa';
	}
}


template_header('Settings');
	?>
		<div class="container" style="">
			<div class="row" style="margin-left:300px;">
				<h2><?php echo $lang['settings'];?></h2>
				<?php if (isset($_SESSION['user_loggedin']) && isset($_SESSION['creator_id'])) : ?>
				<div class="col-sm-12" style="border: 1px solid var(--light); margin-bottom:25px; border-radius:var(--br-default); padding:7px;">
					<h5><?php echo $lang['password'];?></h5>
					<a class="profile-btn" href="profile/edit"><?php echo $lang['change_password_profile'];?>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-left" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M7.364 3.5a.5.5 0 0 1 .5-.5H14.5A1.5 1.5 0 0 1 16 4.5v10a1.5 1.5 0 0 1-1.5 1.5h-10A1.5 1.5 0 0 1 3 14.5V7.864a.5.5 0 1 1 1 0V14.5a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5v-10a.5.5 0 0 0-.5-.5H7.864a.5.5 0 0 1-.5-.5z"/>
					<path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h5a.5.5 0 0 1 0 1H1.707l8.147 8.146a.5.5 0 0 1-.708.708L1 1.707V5.5a.5.5 0 0 1-1 0v-5z"/>
					</svg></a>
				</div>
				<?php endif; ?>
				<div class="col-sm-12" style="border: 1px solid var(--light); margin-bottom:25px; border-radius:var(--br-default); padding:7px;">
					<h5><?php echo $lang['language'];?></h5>
					<p><?php echo $lang['choose_language'];?></p>
					<a class="lang" href="<?php echo $_SESSION['hm'].'inc/lang/require_en.php'; ?>"><img class="lang" src="media/images/flags/US.svg" title="<?php echo $lang["flag_en"]; ?>"></a>
					<a class="lang" href="<?php echo $_SESSION['hm'].'inc/lang/require_fi.php'; ?>"><img class="lang" src="media/images/flags/FI.svg" title="<?php echo $lang["flag_fi"]; ?>"></a>
					<p>
						<details>
							<summary><?php echo $lang['more_info'];?></summary>
							<p><?php echo $lang['language_info'];?></p>
						</details>
					</p>
				</div>
				<div class="col-sm-12" style="border: 1px solid var(--light); margin-bottom:25px; border-radius:var(--br-default); padding:7px;">
					<h5><?php echo $lang['theme'];?></h5>
						<form action="" method="post">
							<input type="submit" class="btn btn-primary" name="blue" value="<?php echo $lang['blue'];?>">
							<input type="submit" class="btn btn-danger" name="rosa" value="<?php echo $lang['rosa'];?>">
							<input type="submit" class="btn btn-dark" name="dark" value="<?php echo $lang['dark'];?>">
							<input type="submit" class="btn btn-primary" name="auto_blue" value="<?php echo $lang['auto_blue'];?>">
							<input type="submit" class="btn btn-danger" name="auto_rosa" value="<?php echo $lang['auto_rosa'];?>">
							<input type="checkbox"><?=$lang['switch_auto'];?>
						</form>
				</div>
			</div>
		</div>

<?=template_footer('Settings')?>

