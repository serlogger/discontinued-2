<?php

require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'se_load.php');

//Insert form data
if (!empty($_POST)) {

	// Hidden form data
    $security_field_name = hash_2($_SESSION['8Kb7i7UGInstcL']."Xv02W9ygrLCMNNzElHzploxCsUpT");
	$security_field_value = hash_2($_SESSION['8Kb7i7UGInstcL'].'sXT0DsUkYYYwilAde9KQnZraX74P');

	// Hidden invisible PHP data
	hash_2(uniqid(rand(), true) . uniqid(rand(), true));

	if
	(	$_POST[$security_field_name] == $security_field_value &&
		$_SESSION['fjr4f8dZq5itrV'] == hash_2($_SESSION['8Kb7i7UGInstcL']))
	{
		echo "pass";
	} else {
		exit("no pass");
	}

	// Post data not empty insert a new record
	// Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
	//$id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
	$id = isset($_SESSION['srv_id']) ? $_SESSION['srv_id'] : '';
	// Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
	$creator_id = isset($_SESSION['creator_id']) ? $_SESSION['creator_id'] : '';
	
	// Make fu
	$email = filter_input(INPUT_POST, 'private_email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
	$url = isset($_POST['url']) ? $_POST['url'] : '';
	$title = isset($_POST['title']) ? $_POST['title'] : '';
	$description = isset($_POST['description']) ? $_POST['description'] : '';
	$created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
	$created_u = time();
	$edited = isset($_POST['edited']) ? $_POST['edited'] : date('Y-m-d H:i:s');
	$edited_u = time();
	// Do this after processing:
	unset($_POST);
	
	// echo $_POST
	echo '<pre>' . var_export($_POST, true) . '</pre>';
	// Filter locality
	if ( ! empty ( $_POST['locality'] ) ) {
		foreach ( array_keys( $_POST['locality'] ) as $local ) {
			$locality[] = filter_var($local, FILTER_SANITIZE_STRING);
		}
		
		$filter_locality = serialize($locality); 
	} else {
		$filter_locality = '';
	}

	// Moar vars
	$radius = isset($_POST['radius']) ? $_POST['radius'] : '';
	$location = isset($_POST['Glocation']) ? $_POST['Glocation'] : '';
	$ind_id = isset($_POST['ind_id']) ? $_POST['ind_id'] : '';
	$cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : '0';
	$sc_id = isset($_POST['sc_id']) ? $_POST['sc_id'] : '0';
	$lat = isset($_POST['lat']) ? $_POST['lat'] : '';
	$lon = isset($_POST['lon']) ? $_POST['lon'] : '';

	// Making multi-lang categorization items searchable
	$stmt = $pdo->prepare('SELECT industry_'.$current_lang.' FROM cat1_industries WHERE ind_id = '.$ind_id);
	$stmt->execute();
	$stmt->closeCursor();

	// Filter payment options
	if ( ! empty ( $_POST['paym_opt'] ) ) {
		foreach ( $_POST['paym_opt'] as $paym_op ) {
			$paym_opt[] = filter_var($paym_op, FILTER_SANITIZE_STRING);
		}
		
		$filter_paym_opt = serialize($paym_opt); 
	} else {
		$filter_paym_opt = '';
	}
	$srv_stat = 1; //all services are active unless otherwise stated
	// If the object is new:
	$stmt = $pdo->prepare('INSERT INTO `services` VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
	$stmt->execute(["", $creator_id, $email, '', $url, $title, $description, $created, $created_u, $edited, $edited_u, $location, $filter_paym_opt, $filter_locality, $radius, $ind_id, $cat_id, $sc_id, "", "", $srv_stat, $lat, $lon, "", "", "", ""]);
	$stmt->closeCursor();
	// Output message
	//$_SESSION['srv_id'] = $pdo->lastInsertId(); // let's not redefine this

	//if !isset $id ... pdo -> lastinsertid
	$id = $pdo->lastInsertId();
	echo '<pre>' . var_export('id: '.$id, true) . '</pre>';

	$msg = '';//Created Successfully!';
	//echo '<br><a href="upload_image.php">Upload image</a>';
	unset($_SESSION['details_filled']);



// Child-items:

// $connect = mysqli_connect("localhost", "root", "", "serlog");
$number = count($_POST["child_title"]);
$current_table = "$se_db.services_childs";

if($number > 0) {
	
	for($i=0; $i<$number; $i++) {

		if($i == 0)
		{
			$current_min_cp = $_POST["child_price"][$i];
			$current_max_cp = $_POST["child_price"][$i];
			$current_min_dt = $_POST["child_delivery_time_from"][$i];
			$current_max_dt = $_POST["child_delivery_time_to"][$i];
		} else {
			if ($_POST["child_price"][$i] < $current_min_cp)
			{
				$current_min_cp = $_POST["child_price"][$i];
			}
			if ($_POST["child_price"][$i] > $current_max_cp)
			{
				$current_max_cp = $_POST["child_price"][$i];
			}
			if ($_POST["child_delivery_time_from"][$i] < $current_min_dt)
			{
				$current_min_dt = $_POST["child_delivery_time_from"][$i];
			}
			if ($_POST["child_delivery_time_to"][$i] > $current_max_dt)
			{
				$current_max_dt = $_POST["child_delivery_time_to"][$i];
			}
		}
		
		if(trim($_POST["child_title"][$i] != '')) {
			$stmt = $pdo->prepare('INSERT INTO `services_childs` VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
			$stmt->execute(["", $id, "", $_POST["child_title"][$i], $_POST["child_desc"][$i], $_POST["child_delivery_time_from"][$i], $_POST["child_delivery_time_to"][$i], $_POST["child_price"][$i], $_POST["child_price_spec"][$i]]);
			$stmt->closeCursor();

			$stmt2 = $pdo->prepare('UPDATE services SET min_cp = '.$current_min_cp.', max_cp = '. $current_max_cp . ', min_dt = '. $current_min_dt . ', max_dt = '. $current_max_dt .' WHERE id = '.$id);
			$stmt2->execute();
			$stmt2->closeCursor();

		}
			
	}
	echo "<br>Data Inserted<br><br>";
	
} else {
	
	echo "Unfortunately, there was an error.  ";
	}

////////////////////
//UPLOAD IMAGE PHP//
////////////////////

/////////////
//VARIABLES//
/////////////

$max_file_size = 100000000; // 40 MB
$allowed_image_types = array(IMAGETYPE_JPEG, IMAGETYPE_PNG);
$min_pixels = 30;
$max_pixels = 20000;
$aspect_ratio = 25;

/////////////
//FUNCTIONS//
/////////////

function reset_session_variables() {
	$_SESSION['angle'] = 0; //Resets the image rotation angle
}

function check_dimensions($image_check, $min_pixels, $max_pixels, $aspect_ratio) {
	if ($image_check[0] < $min_pixels OR 
		$image_check[0] > $max_pixels OR 
		$image_check[1] < $min_pixels OR 
		$image_check[1] > $max_pixels OR 
		$image_check[0]/$image_check[1] > $aspect_ratio OR 
		$image_check[1]/$image_check[0] > $aspect_ratio ) {
	echo "Unfortunately, your image didn't meet the size requirements.<br><br>Limitations: Min size: " . $min_pixels . " x " . $min_pixels . " px. Max size: " . $max_pixels/1000 . ",000 x " . $max_pixels/1000 . ",000 px. Aspect ratio range: " . $aspect_ratio . ":1 - 1:" . $aspect_ratio . "<br><br>Please try with a differently sized image or kindly contact us at " . SUPPORT . "<br>";
	return false;
	} else{return true;}
}

function if_filetype($orig_extension, $tmp_name) 
{
	if ($orig_extension == "jpg" OR $orig_extension == "jpeg") 
	{
		$original = imagecreatefromjpeg($tmp_name);
	}
	if ($orig_extension == "png") 
	{
		$original = imagecreatefrompng($tmp_name);
		$bg = imagecreatetruecolor(imagesx($original), imagesy($original));
		imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
		imagealphablending($bg, TRUE);
		imagecopy($bg, $original, 0, 0, 0, 0, imagesx($original), imagesy($original));
		imagedestroy($original);
		//imagepng($bg, $tmp_name /* . ".jpg" , $quality*/);
		imagedestroy($bg);
	}
	return $original;
}

function orientation($exif_data, $orig_extension)
{
	foreach($exif_data as $key => $val)
	{
		if(strtolower($key) == "orientation")
		{
			return $val;
		}
	}
}

function allowed_type($extension)
{
	//Passing only if the extension is allowed
	if ($extension !== "jpg" AND 
		$extension !== "png" AND
		$extension !== "jpeg") 
	{
			
		echo "<br>No image found.<br>";

		// Using unlink() function to delete the file 
		$file_pointer = $_FILES['myFile'.$i]['tmp_name']; 
		if (is_file($file_pointer)) 
		{
			if (unlink($file_pointer)) 
			{
				echo "Deleted from server";
				return false;
			} 
			else 
			{
				echo "File not deleted from server.";
				return false;
			}
		}
		else{return false;}
	}
	else{return true;}
}

function check_filesize($tmp_name, $max_file_size)
{
	if ( filesize( $tmp_name ) > $max_file_size ) 
	{ 
		echo 'Sorry this file is too big. Please try sending a file smaller than ' . $max_file_size/1000000 . ' megabytes.';
		return false; 
	} 
	else{return true;}
}

function resize($new_width, $new_height, $original, $image_check){
	//Resizing
	$resized = imagecreatetruecolor($new_width, $new_height);
	imagecopyresampled(
		$resized, $original, 0, 0, 0, 0,
		$new_width, $new_height, $image_check[0], $image_check[1] 
	);
	if(!$resized) {
		echo "Sry, sth wnt wrg";
		return;
		}
	return $resized;
}

function getimagesize_return_text($tmp_name) 
{
	$image_check = getimagesize( $tmp_name );

if ($image_check == false) { 
	echo "<br>Unfortunately, the contents of this file weren't recognized as an image.<br>"; 
	return false;
	} else {
	return $image_check;	
	}
}

for ($i=0; $i<25; $i++)
{
	//////////
	//UPLOAD//
	//////////
	if(isset($_FILES['myFile'.$i]['name'])) {
		if ($_FILES['myFile'.$i]['name'] !== '')
		{
		echo '<pre>' . var_export('myFile'.$i, true) . '</pre>';
		echo '<pre>' . var_export($_FILES['myFile'.$i], true) . '</pre>';
		reset_session_variables();

		// Setup
		$orig_extension = pathinfo($_FILES['myFile'.$i]['name'], PATHINFO_EXTENSION);
		$_SESSION['orig_extension'] = $orig_extension;
		$extension = $orig_extension; //Variable for later naming
		
		if (allowed_type($extension) == false) { return false; }
		
		$name_var = 'img--' . gmdate('Y-m-d--H-i-s') . '--' . generateRandomString(8); 
		$_FILES['myFile'.$i]['name'] = $name_var . '-resized.jpg';
		$_FILES['myFile'.$i]['orig_name'] = $name_var . '-original.jpg';
		$_SESSION['file_name'] = $_FILES['myFile'.$i]['name'];
		$tmp_name = $_FILES['myFile'.$i]['tmp_name'];
		$target_dir = $_SESSION['rt'].'/media/uploads/images/';
		$target_file = $target_dir . basename( $_FILES['myFile'.$i]['name'] );
		$_SESSION['target_file'] = $target_file;

		// Check if the file exists (Shouldn't happen tho) 
		if ( file_exists( $target_file ) ) { return 'Sorry this file already exists. Please try again.'; }

		if (check_filesize($tmp_name, $max_file_size) == false) {return false;}

		if (getimagesize_return_text($tmp_name) == false) {return false;}
			else { $image_check = getimagesize_return_text($tmp_name); }

		if (!check_dimensions($image_check, $min_pixels, $max_pixels, $aspect_ratio)) { return false; }
			
	//Print exif data
		if($orig_extension == "jpg" OR $orig_extension == "jpeg")
		{
			$exif_data = exif_read_data($tmp_name);
			$orientation = orientation($exif_data, $orig_extension);
			//echo '<pre>Orientation: ' . var_export($orientation, true) . '</pre>';
		}	
	//Saving temporary full size images for later processing...	
		
		$fullsize_file_tmp = $_FILES['myFile'.$i]['tmp_name'];
		$fullsize_dest_clear = $target_dir . "2".$_FILES['myFile'.$i]['name'];
		$_SESSION['fullsize_dest_clear'] = $fullsize_dest_clear;
		$tmp_name_full = $target_dir . $_FILES['myFile'.$i]['orig_name'];
		$_SESSION['tmp_name_full'] = $tmp_name_full;
		if(!copy($fullsize_file_tmp, $tmp_name_full)) {echo "error text2"; return;}

		$original = if_filetype($orig_extension, $tmp_name);
		
	//Rotating based on EXIF YEAH!

		if (isset($orientation)) 
		{
			if($orientation == 1)
			{
				//No rotation
				$angle=0;
			}
			if($orientation == 3) //Rotate 180
			{
				$angle=180;
			}
			if($orientation == 6) //Rotate 90 clockwise
			{
				$tmp0 = $image_check[0];
				$tmp1 = $image_check[1];
				$image_check[0] = $tmp1;
				$image_check[1] = $tmp0;
				$angle=270;
			}
			if($orientation == 8) //Rotate 270 clockwise
			{
				$tmp0 = $image_check[0];
				$tmp1 = $image_check[1];
				$image_check[0] = $tmp1;
				$image_check[1] = $tmp0;
				$angle=90;
			}
			
		}
		else
		{ 
			$angle = 0; 
		}
		
			$_SESSION['angle'] = $angle;
			$size_ratio = 800/$image_check[1];
			$new_width = ceil($image_check[0]*$size_ratio);
			$new_height = ceil($image_check[1]*$size_ratio);
			$original = imagerotate($original, $angle, 0);
		

		$resized = resize($new_width, $new_height, $original, $image_check, $tmp_name);
		imagejpeg($resized, $tmp_name);
		// Store the file
		//echo 'tmp_name: ' . $tmp_name;
		//echo 'target_file: ' . $target_file;
		if ( move_uploaded_file( $tmp_name, $target_file ) ) 
		{
			$_SESSION['target_file'] == $target_file;
			chmod( $target_file, 0644 );

			// Create connection in PDO
				$stmt = $pdo->prepare('INSERT INTO media (filepath, srv_id) VALUES (?, ?)');
				if ($stmt->execute([$_FILES['myFile'.$i]['name'], $id])) //insert imagelink to db
				{
					$_SESSION['srv_id'] = $pdo->lastInsertId();
					$srv_id = $_SESSION['srv_id'];
					//echo "<img src=".$_SESSION['hm']."../media/images/uploads/".$_FILES['myFile'.$i]['name'].">";	
					echo '<pre>Session ID: ' . var_export($_SESSION['srv_id'], true) . '</pre>';
					echo "<br>New record created successfully<br>";
				} else {
				echo "<br>Error 10405 has been sent to support for investigation. We apologize the inconvenience.<br>";
				}
				$stmt->closeCursor();

				$stmt = $pdo->prepare('INSERT INTO `media_originals` (filepath, srv_id) VALUES (?, ?)');
				if ($stmt->execute([$_FILES['myFile'.$i]['orig_name'], $id])) //insert original imagelink to db
				{
					$_SESSION['srv_id'] = $pdo->lastInsertId();
					$srv_id = $_SESSION['srv_id'];	
					echo '<pre>Session ID: ' . var_export($_SESSION['srv_id'], true) . '</pre>';
					echo "<br>New record created successfully<br>";
				} else {
				echo "<br>Error 10406 has been sent to support for investigation. We apologize the inconvenience.<br>";
				}
				$stmt->closeCursor();

			//include($_SESSION['root'].'/includes/processors/cw1.php');
			//return;
		} 
		else 
		{
			return 'There was a problem storing your file. Please try again.';
		}
	//	exit;
		}
	}
}
}
echo "<br>current_min_cp: " . $current_min_cp . "<br>";
echo "<br>current_max_cp: " . $current_max_cp . "<br>";
echo "<br>current_min_dt: " . $current_min_dt . "<br>";
echo "<br>current_max_dt: " . $current_max_dt . "<br>";

////////////////////////
// EO UPLOAD IMAGE PHP//
////////////////////////


unset($_SESSION['srv_id']);
