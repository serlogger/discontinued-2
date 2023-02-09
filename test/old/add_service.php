<?php

/*    #    ###    ###  #  #  ###   #
   #      #   #   #  # #  #  #  #     #
#            #    ###  ####  ###         #
   #              #    #  #  #        #
      #     #     #    #  #  #     #       
	  
For phone number? --> preg_replace('/[^0-9]/', '', $_POST['phone'])
	  
	  */


require_once('load.php');
//echo $_SESSION['time_sess'];

//Nonce'n'stuff
define('TIMESTAMP', iterate_hashes(time()));
$form_action = hash_of_two('5bum1tf0mr', TIMESTAMP);
$nonce = create_nonce($form_action, TIMESTAMP);

if ( ! empty ($_POST)) {
	require('verify.php');
	$insert = process($_POST);
}


//PHP file upload

require_once('load.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

function upload_file() {
  // Setup
  $tmp_name = $_FILES['file']['tmp_name'];
  $target_dir = 'uploads/';
  $target_file = $target_dir . basename( $_FILES['file']['name'] );
  $max_file_size = 5000000; // 5MB
  $allowed_file_types = array( 'application/pdf; charset=binary' );
  $allowed_image_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);

  // Check if image type is allowed
  $image_check = getimagesize( $tmp_name );

  if ( ! in_array( $image_check[2], $allowed_image_types ) ) {
    // If not an allowed image, check if allowed file type
    exec( 'file -bi ' . $tmp_name, $file_check );

    if ( ! in_array( $file_check[0], $allowed_file_types )  ) {
      return 'This file type is not allowed';
    }
  }

  // Check if file already exists
  if ( file_exists( $target_file ) ) {
    return 'Sorry that file already exists';
  }

  // Check file size
  if ( filesize( $tmp_name ) > $max_file_size ) {
    return 'Sorry this file is too big.';
  }

  // Store the file
  if ( move_uploaded_file( $tmp_name, $target_file ) ) {
    chmod( $target_file, 0644 );
    return 'Your file was uploaded.';
  } else {
    return 'There was a problem storing your file. Try again?';
  }
}

if ( ! empty( $_FILES ) ) {
  echo upload_file();
}


/*   ###    #
    #   #      #
       #          #
               #
      #     #       */

?>

<!DOCTYPE html>
<html>

<!--         #   #  #  ####   ##  ###    #
           #     #  #  #     #  # #  #     #
         #       ####  ####  #  # #  #       #
           #     #  #  #     #### #  #     #
             #   #  #  ####  #  # ###   #      -->
<head>

<!-- Recaptcha -->
	<script src="https://www.google.com/recaptcha/api.js?render=6Lf9_uoaAAAAAAN7Vj29VYkuqX6vS6b6L2ZyOBKA"></script>
	
<!-- Styles -->

	<link rel="stylesheet" href="jqmsbs/docs/css/bootstrap-4.5.2.min.css" type="text/css">
	<link rel="stylesheet" href="jqmsbs/docs/css/prettify.min.css" type="text/css">
	<link rel="stylesheet" href="jqmsbs/docs/css/fontawesome-5.15.1-web/all.css" type="text/css">


<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
<!-- Google Fonts Roboto -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;700&display=swap" rel="stylesheet">
	

<!-- Custom BS css -->
	<link rel="stylesheet" href="styles/custom_bs.css">
<!-- Stock BS -->
	<!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"-->

<!-- Mage style -->
	<link rel="stylesheet" href="styles/landscape.css">
	<!--?php include_once('styles/portrait.html'); ?-->

<!-- JS, jQuery... -->
	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Payment options -->
	<link rel="stylesheet" href="jqmsbs/dist/css/bootstrap-multiselect.css" type="text/css">
	<script type="text/javascript" src="jqmsbs/docs/js/bootstrap.bundle-4.5.2.min.js"></script>
	<script type="text/javascript" src="jqmsbs/docs/js/prettify.min.js"></script>


	<script type="text/javascript" src="jqmsbs/dist/js/bootstrap-multiselect.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			window.prettyPrint() && prettyPrint();
		});
	</script>

<!-- Location header -->
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyAh1VrZlMmz_yHpHCAbUPaWQ4EavsXRnpU">//Restricted</script>
	<script>
		var searchInput = 'search_input7';

		$(document).ready(function () {
			var autocomplete;
			autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
				types: ['geocode']
			});

			google.maps.event.addListener(autocomplete, 'place_changed', function () {
				var near_place = autocomplete.getPlace();
				document.getElementById('loc_lat').value = near_place.geometry.location.lat();
				document.getElementById('loc_long').value = near_place.geometry.location.lng();
				
				var latit = near_place.geometry.location.lat();
				var m = latit.toFixed(4);
				
				var longit = near_place.geometry.location.lng();
				var n = longit.toFixed(4);
				
				document.getElementById('latitude_view').innerHTML = '<?php echo $lang['location_found_at'];?> '+ m + ', ';
				document.getElementById('longitude_view').innerHTML = n;
			});
		});

		$(document).on('change', '#'+searchInput, function () {
			document.getElementById('loc_lat').value = '';
			document.getElementById('loc_long').value = '';

			document.getElementById('latitude_view').innerHTML = "";
			document.getElementById('longitude_view').innerHTML = "";
		});
		
		
	</script>

	<title>Add service</title>

<!--         #       #   #  #  ####   ##  ###    #
           #        #    #  #  #     #  # #  #     #
         #         #     ####  ####  #  # #  #       #
           #      #      #  #  #     #### #  #     #
             #   #       #  #  ####  #  # ###    #         -->

</head>
	

<!--         #   ###    ###   ###   #   #   #
           #     #  #  #   #  #  #   # #      #
         #       ###   #   #  #  #    #         #
           #     #  #  #   #  #  #    #       #
             #   ###    ###   ###     #     #         -->
<body>
	
	<script>
		$(document).ready(function(){
			$('.no-bbdiv').click(function(){
				$('.bbdiv').css('border', '2px solid var(--gblue100)');
				$('.bbdiv').css('margin-top', '2px');
				$('.bbdiv').css('margin-bottom', '2px');
				$('.bbdiv').css('margin-right', '2px');
				$('.bbdiv').css('margin-left', '2px');
				$('.bbdiv').css('box-shadow', '3px 3px 9px rgb(0,0,0,0.3)');
				
			});

			$('.bbdiv').click(function(){
				$('.bbdiv').css('border', '2px solid var(--gblue100)');
				$('.bbdiv').css('margin-top', '0');
				$('.bbdiv').css('margin-bottom', '0');
				$('.bbdiv').css('margin-right', '0');
				$('.bbdiv').css('margin-left', '0');
				$('.bbdiv').css('padding-left', '6');
				$(this).css('border', '3px solid var(--gblue100)');
				$('.bbdiv').css('box-shadow', '3px 3px 9px rgb(0,0,0,0.4)');
			});	
			

			
		});			
	</script>

	<?php if (isset($insert)) {echo do_messages($insert);} ?>
	<form action="" id="add_service" method="post" enctype="multipart/form-data">
	
	<div style="background-color:var(--gblue25); max-width:900px; margin:auto; padding:1%;">
		
		<div class="no-bbdiv">
			<input type="hidden" name="<?php echo iterate_hashes($_SESSION['time_sess']);?>" value="<?php echo TIMESTAMP; ?>">
			<input type="hidden" name="<?php echo hash_of_two('form_action', $_SESSION['time_sess']);?>" value="<?php echo $form_action; ?>">
			<input type="hidden" name="<?php echo hash_of_two('nonce', $_SESSION['time_sess']);?>" value="<?php echo $nonce; ?>">

		<!-- Upload image -->
		
			<label for="formFileMultiple" class="wc2"><?php echo $lang['upload_image'];?></label>
			<input class="m-form-field" style="height:auto; padding:15px; width:auto; display:block;" type="file" name="file" id="formFileMultiple" multiple />
			<br>
		</div>
		
		<!-- Locality -->
		<div style="display:block; height:100px;">
		<div class="" style="width:250px; margin-right:30px; display:inline-block;">
			<label class="wc2"><?php echo $lang['service_available'];?></label>
			
			<div class="form-field bbdiv" style="display:flex; justify-content:center; align-items:center; box-shadow:3px 3px 8px rgb(0,0,0,0.3);">
				<div style="margin:auto;">
						<input type="checkbox" id="available-online" name="available[online]" value="1">
						<label style="margin-right:25px;" for="available-online"><?php echo $lang['online'];?></label>
					
					<div style="display:inline-block;">
						<input type="checkbox" id="available-locally" name="available[locally]" value="1" onclick="dynInput_locally(this);">
						<label for="available-locally"><?php echo $lang['locally'];?></label>
					</div>
				</div>
			
			</div>
		</div>
		<br class="mop">
		<div id="radiusDiv2" class="no-bbdiv" style="position:relative; top:-9px; display:inline-block; width:250px;"></div>
		</div>
		<!-- Location -->
			
		<div class="no-bbdiv wm100" style="border:0;">	
			<br>
			<div style=""><div id="radiusDiv">
				<div>
					<div style="display:block; height:70;">
					<label class="wc2"><?php echo $lang['location'];?></label>

					<input type="text" name="Glocation" class="m-form-field wm100 no-bbdiv" id="search_input7" placeholder="<?php echo $lang['enter_street'];?>" title="" />
					</div>
					<div style="display:block;">
						<input type="hidden" id="loc_lat" />
						<input type="hidden" id="loc_long" />

						<p>
							<span id="latitude_view"></span><span id="longitude_view"></span>
						</p>
					</div>
				</div>
				
		<!-- Radius pops up if "Locally" is selected -->
					<script>
						function dynInput_locally(cbox) {
							if (cbox.checked) {
								var radiusDiv = document.getElementById('radiusDiv2');

								var divi = document.createElement('div');
								divi.setAttribute('class', '');
								divi.setAttribute('id', 'radius2');
								
								var label = document.createElement('label');
								label.setAttribute('class', 'wc2');
								label.setAttribute('for','radius4');
								label.setAttribute('id','radius3');
								// label.setAttribute('style', 'background-color: white; border-radius: 4px; margin-top:1px; padding-left:4px; padding-right:4px;');
								label.innerHTML = "<?php echo $lang['radius'];?>";

								var input = document.createElement('input');
								input.type = 'text';
								input.setAttribute('id','radius4');
								input.setAttribute('class', 'm-form-field wm100');
								input.setAttribute('name','radius');
								input.setAttribute('placeholder','<?php echo $lang['enter_integer'];?>');
								input.setAttribute('title','<?php echo $lang['enter_radius_kilometers'];?>');

								var textInput = document.querySelector('input[id="search_input7"]');
/*								textInput.setAttribute('required','required');*/
								textInput.setAttribute('placeholder','<?php echo $lang['enter_street_required'];?>');
								
								document.getElementById("radiusDiv2").appendChild(divi);
								document.getElementById("radius2").appendChild(label);
								document.getElementById("radius2").appendChild(input);
							} else {
									
								var textInput = document.querySelector('input[id="search_input7"]');
								textInput.removeAttribute('required');
								textInput.setAttribute('placeholder','<?php echo $lang['enter_street'];?>');
								
								document.getElementById("radius2").remove();
								document.getElementById("radius3").remove();
								document.getElementById("radius4").remove();
							}
						}
					</script>
				</div>
			</div>
		<!-- Payment options -->
			<div class="" style="width:100%;">
				<br>
				<div class="">
					<label class="wc2" style="z-index:1;"><?php echo $lang['payment_options'];?></label>
					<script type="text/javascript">
						$(document).ready(function() {
							$('#enableClickableOptGroups').multiselect({
								includeSelectAllOption: false,
								enableClickableOptGroups: false,
								enableCaseInsensitiveFiltering: true,
								filterPlaceholder: '<?php echo $lang["search"];?>',
								nonSelectedText: '<?php echo $lang["press_to_select"];?>',
								buttonWidth: '100%',
								maxHeight: '500'
							});
						});
				</script>
				<br class="mop">
				<div class="" style="margin-top: -1px; display:block;">
					<select id="enableClickableOptGroups" style="background-color:black; color:rgb(77, 255, 0); font-family: 'Roboto Mono'; font-size:12px;" multiple="multiple">
						<optgroup class="bold" label="<?php echo $lang['general'];?>">
							<option value="credit_debit"><?php echo $lang['credit_debit'];?></option>
							<option value="mobile_payments"><?php echo $lang['mobile_payments'];?></option>
							<option value="iban"><?php echo $lang['iban'];?> (IBAN)</option>
							<option value="cash"><?php echo $lang['cash'];?></option>
						</optgroup>
						<optgroup class="bold" label="<?php echo $lang['cryptocurrencies'];?>">
							<option value="btc">Bitcoin</option>
							<option value="eth">Ethereum</option>
							<option value="doge">Dogecoin</option>
							<option value="ltc">Litecoin</option>
						</optgroup>
						<optgroup class="bold" label="<?php echo $lang['other'];?>">
							<option value="paypal">PayPal</option>
							<option value="klarna">Klarna</option>
							<option value="skrill">Skrill</option>
							<option value="payeer">Payeer</option>
							<option value="siirto">Siirto</option>
							<option value="samsung_pay">Samsung Pay</option>
							<option value="google_pay">Google Pay</option>
							<option value="apple_pay">Apple Pay</option>
							<option value="mobile_pay">MobilePay</option>
							<option value="more_available"><?php echo $lang['more_available'];?></option>
						</optgroup>
					</select>
				</div>
			</div-->
		</div>
		<br>

		<!-- Contact info -->
			<h5><?php echo $lang['contact_information'];?></h5>
			<div class="" >
				<label class="wc2"><?php echo $lang['phone'];?></label>
				<input class="m-form-field" style="display:block; width:auto;" type="tel" id="mobile" name="tel">
				
				<label class="wc2" style="" for="email"><?php echo $lang['email'];?></label>
				<input class="m-form-field wm100" type="email" id="email" name="email">

				<label class="wc2" style="display:inline-block;" for="url"><?php echo $lang['website'];?></label>
				<input class="m-form-field wm100" style="display:block;" type="url" id="url" name="url">
			</div>

			
		<!-- Title, description, price and delivery time, no delete -->
			<br>
			<div class="">
				<label class="wc2" for="srv_title"><?php echo $lang['title'];?></label>
				<input name="name2[]" type="text" id="parent_title" style="" class="m-form-field wm100" name="service_title">
			</div>
			<div class="">
				<label class="wc2"><?php echo $lang['description'];?></label>
				<textarea name="description[]" class="m-form-textarea wm100" style="vertical-align:top; display:block;" ows="4" name="parent_description" placeholder="<?php echo $lang['enter_obj_desc'];?>"></textarea>
			</div>
			<br>
			<div class="">
				<label class="wc2" for="delivery_time"><?php echo $lang['delivery_time_from'];?><!--container style="float:right;"><?php echo $lang['from'];?></container--></label>
				<input class="m-form-field" style="display:block; width:250px;" name="delivery_time_from[]" placeholder="<?php echo $lang['from2'];?>" type="text" id="delivery_time_min" name="delivery_time_min" min="0" max="99999" title="Enter shortest delivery time in days.">
				<!--input class="form-control " name="delivery_time_to[]" placeholder="<?php echo $lang['to2'];?>" type="number" id="delivery_time_max" name="delivery_time_max" min="0" max="99999" title="Enter longest delivery time in days."> <?php echo $lang['days'];?> -->
			<!--div>
			
			<div class=""-->
				<label class="wc2" for="obj_price"><?php echo $lang['price'];?> (USD)</label>
				<input class="m-form-field wm100" name="price[]" placeholder="<?php echo $lang['obj_price'];?>" type="text" id="price" title="Use numbers like 100 or 99.99">
			</div>
		<!-- Add items dynamically -->
			
			<br>
			<h5><?php echo $lang['add_items'];?></h5>
			<div>  
				<div>  
					<div> 
						<table id="dynamic_field" style="width:100%;">  

						</table>  

					</div> 
				</div>  
			</div>

		<!-- Add object button -->
			<div>
				<button type="button" name="add" id="add"><?php echo $lang['add_object'];?>
				</button>
				<br>
			</div>

		<!-- Submit button -->
		
		<input type="submit" value="<?php echo $lang['upload_image'];?>">
		
			<div>
				<button type="submit" class="button g-recaptcha" 
				data-sitekey="6Lf9_uoaAAAAAAN7Vj29VYkuqX6vS6b6L2ZyOBKA" 
				data-callback='onSubmit' 
				data-action='submit'>Submit</button>
			</div>
		</div>
		</div>
		</div>
	</form>
	
	<!--script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script-->
	
	
<!--         #       #   ###    ###   ###   #   #   #
           #        #    #  #  #   #  #  #   # #      #
         #         #     ###   #   #  #  #    #         #
           #      #      #  #  #   #  #  #    #       #
             #   #       ###    ###   ###     #     #         -->

	</body>

<!-- 
      #   #            ###    ###  ###   #  ###   #####   ###           #
   #      #           #      #     #  #  #  #  #    #    #                 #
#         #  ### ###   ###   #     ###   #  ###     #     ###   ### ###       #
   #                      #  #     #  #  #  #       #        #             #
      #   #           ####    ###  #  #  #  #       #    ####           #    -->

<!-- Recaptcha stuff -->
 <!--script>
   function onSubmit(token) {
	 document.getElementById("add_service").submit();
   }
</script>
 
<!-- Prevent enter from submitting the form -->
	<script>
		$(document).ready(function() {
		  $(window).keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  return false;
			}
		  });
		});
	</script>
	

	<!-- Script for adding fields dynamically -->
	<?php include $scripts.'add_fields_dynamically.html';?>


</html>