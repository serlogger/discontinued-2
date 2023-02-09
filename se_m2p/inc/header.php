<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?></title>

		<link rel="icon" type="image/png" href="/favicon.png">

		<link href="<?=$_SESSION['hm']?>3-settings/styles/scss/style.css" rel="stylesheet" type="text/css">
		<link href="<?=$_SESSION['hm']?>3-settings/styles/<?php echo san($_SESSION['theme'])?>.css" rel="stylesheet" type="text/css">
		<link href="<?=$_SESSION['hm']?>3-settings/styles/js/fade.css" rel="stylesheet" type="text/css">
		<link href="<?=$_SESSION['hm']?>3-settings/styles/scss/style2.css" rel="stylesheet" type="text/css">
		<link href="<?=$_SESSION['hm']?>3-settings/styles/scss/style3.css" rel="stylesheet" type="text/css">
		<link href="<?=$_SESSION['hm']?>3-settings/styles/scss/nav.css" rel="stylesheet" type="text/css">
		<link href="<?=$_SESSION['hm']?>3-settings/styles/scss/utilities.css" rel="stylesheet" type="text/css">
		<link href="<?=$_SESSION['hm']?>3-settings/styles/scss/gallery.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.css">
		
		<!-- JS, jQuery... -->
			
			<!-- Abbreviations -->	
				<script type="text/javascript" src="<?php echo $_SESSION['hm']; ?>3-settings/styles/js/short.js"></script>

			<!-- jQuery -->	
				<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
				
				
<?php if ($title == 'Create' || $title == 'Update' || $title == 'Browse') : ?>
		
			<!-- Recaptcha -->
				<script src="https://www.google.com/recaptcha/api.js?render=6Lf9_uoaAAAAAAN7Vj29VYkuqX6vS6b6L2ZyOBKA"></script>
	
		<!-- Styles -->
				
				<link rel="stylesheet" href="<?=$_SESSION['hm']?>inc/components/jqmsbs/docs/css/prettify.min.css" type="text/css">
				<link rel="stylesheet" href="<?=$_SESSION['hm']?>inc/components/jqmsbs/docs/css/fontawesome-5.15.1-web/all.css" type="text/css">

			<!-- Images - add multiple -->
				<!-- <link href="< ?=$_SESSION['hm']?>3-settings/styles/img_multi_upl_style.min.css" rel="stylesheet" type="text/css">
				<script src="< ?=$_SESSION['hm']?>3-settings/styles/js/img_multi_upl_HBR.min.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
				<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
				<script>
					$(document).ready(function () {
						uploadHBR.init({
							"target": "#uploads",
							"textNew": "ADD",
							"textTitle": "Click here or drag to upload an imagem",
							"textTitleRemove": "Click here remove the imagem"
						});
						$('#reset').click(function () {
							uploadHBR.reset('#uploads');
						});
					});
				</script> -->

			<!-- Font Awesome -->
				<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
			<!-- Google Fonts Roboto -->
				<link rel="preconnect" href="https://fonts.gstatic.com">
				<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;700&display=swap" rel="stylesheet">
				
			<!-- Payment options -->
				<link rel="stylesheet" href="<?=$_SESSION['hm']?>inc/components/jqmsbs/dist/css/bootstrap-multiselect.css" type="text/css">
				<script type="text/javascript" src="<?=$_SESSION['hm']?>inc/components/jqmsbs/docs/js/bootstrap.bundle-4.5.2.min.js"></script>
				<script type="text/javascript" src="<?=$_SESSION['hm']?>inc/components/jqmsbs/docs/js/prettify.min.js"></script>


				<script type="text/javascript" src="<?=$_SESSION['hm']?>inc/components/jqmsbs/dist/js/bootstrap-multiselect.js"></script>

				<script type="text/javascript">
					$(document).ready(function() {
						window.prettyPrint() && prettyPrint();
					});
				</script>
			
			<!-- Location header -->
				<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCB7IBmukn-y86roMi7lqICKpblqaHC1FE"></script><!--Restricted-->
				<script>
					var searchInput = 'search_input7';

					$(document).ready(function () {

						// var autocomplete;
						// autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
						// 	types: ['geocode']
						// });
						

						// google.maps.event.addListener(autocomplete, 'place_changed', function () {
						// 	var near_place = autocomplete.getPlace();
						// 	if(document.getElementById('search_input7').value !== "") 
						// 	{
						// 		document.getElementById('loc_lat').value = near_place.geometry.location.lat();
						// 		document.getElementById('loc_long').value = near_place.geometry.location.lng();
								
						// 		var latit = near_place.geometry.location.lat();
						// 		var m = latit.toFixed(4);
								
						// 		var longit = near_place.geometry.location.lng();
						// 		var n = longit.toFixed(4);
							
						// 		document.getElementById('latitude_view').innerHTML = 'Löydettiin sijainti '+ m + ', ';
						// 		document.getElementById('loc_lat').value = m;
						// 		document.getElementById('longitude_view').innerHTML = n;
						// 		document.getElementById('loc_long').value = n;
						// 	}
						// });

					});

					$(document).on('change', '#'+searchInput, function () {
						//alert('searchinput func executed ');
						document.getElementById('loc_lat').value = '';
						document.getElementById('loc_long').value = '';

						document.getElementById('latitude_view').innerHTML = "";
						document.getElementById('longitude_view').innerHTML = "";
					});
					
					
				</script>


			<!-- Search JS -->
                <script>
                    function fill(Value) {
                    //Assigning value to "search" div in "search.php" file.
                    $('#search').val(Value);
                    //Hiding "display" div in "search.php" file.
                    $('#display_search_results').hide();
                    }
                    $(document).ready(function() {
                    //On pressing a key on "Search box" in "search.php" file. This function will be called.
                    $("#search").keyup(function() {
                        //Assigning search box value to javascript variable named as "name".
                        var name = $('#search').val();
                        //Validating, if "name" is empty.
                        if (name == "") {
                            //Assigning empty value to "display" div in "search.php" file.
                            $("#display_search_results").html("");
                            document.getElementById("display_search_results").style.border = "0";
                        }
                        //If name is not empty.
                        else {
                            //AJAX is called.
                            $.ajax({
                                //AJAX type is "Post".
                                type: "POST",
                                //Data will be sent to "ajax.php".
                                url: "search_ajax.php",
                                //Data, that will be sent to "ajax.php".
                                data: {
                                    //Assigning value of "name" into "search" variable.
                                    search: name
                                },
                                //If result found, this funtion will be called.
                                success: function(html) {
                                    //Assigning result to "display" div in "search.php" file.
                                    $("#display_search_results").html(html).show();
                                    document.getElementById("display_search_results").style.background = "var(--lightest)";
                                    document.getElementById("display_search_results").style.border = "solid 1px black";
                                }
                            });
                        }
                    });
                    });
                </script>
			<!-- EO Search JS -->


<?php endif; ?>
	</head>
	<body id="wrapper">

	<div class="navmenu"></div>
		<!-- START Bootstrap-Cookie-Alert >
			<div class="alert text-center cookiealert" role="alert">
			<b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website. <a href="https://cookiesandyou.com/" target="_blank">Learn more</a>

			<button type="button" class="btn btn-success btn-sm acceptcookies">
			I agree
			</button>
			</div>
			<script src="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.js"></script>
		< END Bootstrap-Cookie-Alert -->