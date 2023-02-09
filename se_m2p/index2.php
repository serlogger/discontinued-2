<?php require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'se_m2p_load.php');?>
<!DOCTYPE html>
<html>
<head>

<title>Serlog.com</title>
		<meta charset="utf-8">

		<link rel="icon" type="image/png" href="/favicon.png">

		<link href="<?=$_SESSION['hm']?>styles/scss/style.css" rel="stylesheet" type="text/css">
		
		<!-- Session theme: -->
		<link href="<?=$_SESSION['hm']?>styles/blue.css" rel="stylesheet" type="text/css">

		<link href="<?=$_SESSION['hm']?>styles/js/fade.css" rel="stylesheet" type="text/css">
		<link href="<?=$_SESSION['hm']?>styles/scss/style2.css" rel="stylesheet" type="text/css">
		<link href="<?=$_SESSION['hm']?>styles/scss/style3.css" rel="stylesheet" type="text/css">
		<link href="<?=$_SESSION['hm']?>styles/scss/utilities.css" rel="stylesheet" type="text/css">
		<link href="<?=$_SESSION['hm']?>styles/scss/gallery.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.css">
		
		<!-- jQuery -->	
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>		
		<!-- Recaptcha -->
		<script src="https://www.google.com/recaptcha/api.js?render=6Lf9_uoaAAAAAAN7Vj29VYkuqX6vS6b6L2ZyOBKA"></script>
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<!-- Google Fonts Roboto -->
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;700&display=swap" rel="stylesheet">
		<!-- Payment options -->
			<link rel="stylesheet" href="<?=$_SESSION['hm']?>inc/components/jqmsbs/dist/css/bootstrap-multiselect.css" type="text/css">
			<script src="<?=$_SESSION['hm']?>inc/components/jqmsbs/docs/js/bootstrap.bundle-4.5.2.min.js"></script>
			<script src="<?=$_SESSION['hm']?>inc/components/jqmsbs/docs/js/prettify.min.js"></script>
			<script src="<?=$_SESSION['hm']?>inc/components/jqmsbs/dist/js/bootstrap-multiselect.js"></script>

			<script type="text/javascript">
				$(document).ready(function() {
					window.prettyPrint() && prettyPrint();
				});
			</script>

	<link rel="stylesheet" href="styles/scr_width.css">
	<link rel="stylesheet" href="styles/tabs.css">
	<link rel="stylesheet" href="styles/style.css">
	<script src="js/styles_header.js"></script>
	<script src="js/tabs_header.js"></script>
	<script src="js/lang_head.js"></script>
	<script src="js/config.js"></script>
	<script src="js/login.js"></script>
	<script src="js/search.js"></script>
	<!-- Location headers: -->
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCB7IBmukn-y86roMi7lqICKpblqaHC1FE"></script><!--Restricted-->
	<script src="js/location.js"></script>
    
	<!-- Set lang -->
    <?php
        if (!isset($_SESSION['language'])) {
        $_SESSION['language'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        }
    ?>

	<!-- <script>
		$(document).ready(function() {
			$('#se_test_button').click(function() {
				// $('#se_test_div').fadeOut();
				$('#se_test_div').fadeOut();
			});
		});
	</script> -->
</head>
<!-- ████████████████████████████████████████████████████████████████████████████████ -->
<body>

<div class="grid_container_page_nav_maximized grid_container" id="grid_container_page">
	<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'se_m2p_load.php');
	require_once('0_nav/0_main_nav.php');
	?>
	<div class="grid_container" id="grid_container_content">
		<!-- CALLING CONTENT FILES -->
		<?php 
		require_once('1_services/services_test.php');
		require_once('4_auth/login_view.php');
		require_once('1_services/1_browse/services_list.php');
		require_once('1_services/2_create/create_update.php');
		
		?>
		<!-- EO CALLING CONTENT FILES -->
	</div>


</div>
	<script>
		//Set lang
		$(document).ready(function() {
		var language = "<?=$_SESSION['language']?>";
		set_language(language);
		//EO Set lang
		});
	</script>
	<script src="js/styles_footer.js"></script>
	<script src="js/tabs_footer.js"></script>
	<script>
		<?php if (isset($_SESSION['user_loggedin'])) { ?>
			view_user_logged('in');
		<?php } else { ?>
			view_user_logged('out');
		<?php } ?>
	</script>
</body>
</html>