<?php

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

function rowCount($file) {
    $linecount = 0;
    $handle = fopen($file, "r");
    while(!feof($handle)){
      $line = fgets($handle);
      $linecount++;
    }

    fclose($handle);

    echo $linecount;
}

//JMforms

//Iterate hashes
if (!function_exists('iterate_hashes')) {
	function iterate_hashes($str_to_iterate) {

		$str_salted = sprintf('%s%s', HASH_ITERATION_SALT, $str_to_iterate);

		$hash1 = hash('whirlpool', 	$str_salted);
		$hash2 = hash('ripemd320', 	$hash1);
		/*$hash3 = hash('sha512', 	$hash2);
		$hash4 = hash('ripemd320', 	$hash3);
		$hash5 = hash('whirlpool', 	$hash4);*/

		$result = hash('sha512', $hash2);

		return $result;
	}
}

//Hash of two strings
if (!function_exists('hash_of_two')){
	function hash_of_two($str1, $str2) {
		return iterate_hashes(sprintf('%s%s%s', $str1, TWO_SALT, $str2));
	}
}

//Create nonce
if (!function_exists('create_nonce') ) {
	function create_nonce($action, $time) {
		$str = sprintf('%s%s%s%s', NONCE_SALT_ADD_SRV1, $action, $time, NONCE_SALT_ADD_SRV2);

		$nonce = iterate_hashes($str);

        return $nonce;
	}
}

//Verify nonce
if (!function_exists('verify_nonce')) {
	function verify_nonce($nonce, $action, $time) {
		$check = create_nonce($action, $time);

		if ($nonce == $check) {
			return true;
		}
		return false;
	}
}



//Status messages
if ( ! function_exists ('do_messages')) {
	function do_messages($insert=NULL) {
		if ( is_null($insert)) {
			return;
		}

		$message = '<div class="message">';

		if ( $insert == true ) {
			$message .= '<p class="success">Data was inserted successfully.</p>';
		} else {
			$message .= '<p class="error">There was an error with the submission.</p>';
		}
		$message .= '</div>';

		return $message;
	}
}

//Process form data
if (! function_exists('process')) {
	function process($post) {
		//Check nonce
		$verify = verify_nonce(
		$post[hash_of_two('nonce', $_SESSION['time_sess'])],
		$post[hash_of_two('form_action', $_SESSION['time_sess'])],
		$post[iterate_hashes($_SESSION['time_sess'])]
		);

		if ( false === $verify ) {
			return false;
		}

		//Checking session verify key
		if (!isset($_SESSION['verify'])) {
			return false;
		} else {
			if ($_SESSION['verify'] !== hash_of_two($_SESSION['time_sess'], VERIFY_SALT)) {
				return false;
			}
		}

		//Validate email
		$filter_email = filter_var($post['email'], FILTER_VALIDATE_EMAIL);

		if ( false === $filter_email ) {
			return false;
		}

		//Filter input
		$args = array(
		'phone' => 'FILTER_SANITIZE_STRING',
		'url' => 'FILTER_SANITIZE_STRING',
		'par_title' => 'FILTER_SANITIZE_STRING',
		'par_desc' => 'FILTER_SANITIZE_STRING'
		);

		$filter_post = filter_var_array($post, $args);

		//Filter interests
		if (!empty($post['interests'])){
			foreach ( array_keys($post['interests']) as $interest) {
				$interests[] = filter_var($interest, FILTER_SANITIZE_STRING);
			}
			$filter_interests = serialize($interests);
		} else {
			$filter_interests = '';
		}

		//Send to db
		$mysql = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		$stmt = $mysql->prepare("
		INSERT INTO  pb3_parent_services (phone,email,url,par_title,par_desc)
		VALUES (?,?,?,?,?)
		");

		$stmt->bind_param("sssss", $filter_post['phone'], $filter_email, $filter_post['url'], $filter_post['par_title'], $filter_post['par_desc']);

		$insert = $stmt->execute();

		//Close connections
		$stmt->close();
		$mysql->close();

		return $insert;
	}
}

if ( ! function_exists ('_e') ) {
	function _e($string) {
		echo htmlentities($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	}
}
//End of JMForms


if ( !function_exists("imagecreatefrombmp") ) {

		/**
		 * Credit goes to mgutt 
		 * http://www.programmierer-forum.de/function-imagecreatefrombmp-welche-variante-laeuft-t143137.htm
		 * Modified by Fabien Menager to support RGB555 BMP format
		 */
		function imagecreatefrombmp($filename) {
		  // version 1.1
		  if (!($fh = fopen($filename, 'rb'))) {
			trigger_error('imagecreatefrombmp: Can not open ' . $filename, E_USER_WARNING);
			return false;
		  }
		  
		  // read file header
		  $meta = unpack('vtype/Vfilesize/Vreserved/Voffset', fread($fh, 14));
		  
		  // check for bitmap
		  if ($meta['type'] != 19778) {
			trigger_error('imagecreatefrombmp: ' . $filename . ' is not a bitmap!', E_USER_WARNING);
			return false;
		  }
		  
		  // read image header
		  $meta += unpack('Vheadersize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vcolors/Vimportant', fread($fh, 40));
		  $bytes_read = 40;
		  
		  // read additional bitfield header
		  if ($meta['compression'] == 3) {
			$meta += unpack('VrMask/VgMask/VbMask', fread($fh, 12));
			$bytes_read += 12;
		  }
		  
		  // set bytes and padding
		  $meta['bytes'] = $meta['bits'] / 8;
		  $meta['decal'] = 4 - (4 * (($meta['width'] * $meta['bytes'] / 4)- floor($meta['width'] * $meta['bytes'] / 4)));
		  if ($meta['decal'] == 4) {
			$meta['decal'] = 0;
		  }
		  
		  // obtain imagesize
		  if ($meta['imagesize'] < 1) {
			$meta['imagesize'] = $meta['filesize'] - $meta['offset'];
			// in rare cases filesize is equal to offset so we need to read physical size
			if ($meta['imagesize'] < 1) {
			  $meta['imagesize'] = @filesize($filename) - $meta['offset'];
			  if ($meta['imagesize'] < 1) {
				trigger_error('imagecreatefrombmp: Can not obtain filesize of ' . $filename . '!', E_USER_WARNING);
				return false;
			  }
			}
		  }
		  
		  // calculate colors
		  $meta['colors'] = !$meta['colors'] ? pow(2, $meta['bits']) : $meta['colors'];
		  
		  // read color palette
		  $palette = array();
		  if ($meta['bits'] < 16) {
			$palette = unpack('l' . $meta['colors'], fread($fh, $meta['colors'] * 4));
			// in rare cases the color value is signed
			if ($palette[1] < 0) {
			  foreach ($palette as $i => $color) {
				$palette[$i] = $color + 16777216;
			  }
			}
		  }
		  
		  // ignore extra bitmap headers
		  if ($meta['headersize'] > $bytes_read) {
			fread($fh, $meta['headersize'] - $bytes_read);
		  }
		  
		  // create gd image
		  $im = imagecreatetruecolor($meta['width'], $meta['height']);
		  $data = fread($fh, $meta['imagesize']);
		  
		  // uncompress data
		  switch ($meta['compression']) {
			case 1: $data = rle8_decode($data, $meta['width']); break;
			case 2: $data = rle4_decode($data, $meta['width']); break;
		  }

		  $p = 0;
		  $vide = chr(0);
		  $y = $meta['height'] - 1;
		  $error = 'imagecreatefrombmp: ' . $filename . ' has not enough data!';

		  // loop through the image data beginning with the lower left corner
		  while ($y >= 0) {
			$x = 0;
			while ($x < $meta['width']) {
			  switch ($meta['bits']) {
				case 32:
				case 24:
				  if (!($part = substr($data, $p, 3 /*$meta['bytes']*/))) {
					trigger_error($error, E_USER_WARNING);
					return $im;
				  }
				  $color = unpack('V', $part . $vide);
				  break;
				case 16:
				  if (!($part = substr($data, $p, 2 /*$meta['bytes']*/))) {
					trigger_error($error, E_USER_WARNING);
					return $im;
				  }
				  $color = unpack('v', $part);

				  if (empty($meta['rMask']) || $meta['rMask'] != 0xf800) {
					$color[1] = (($color[1] & 0x7c00) >> 7) * 65536 + (($color[1] & 0x03e0) >> 2) * 256 + (($color[1] & 0x001f) << 3); // 555
				  }
				  else { 
					$color[1] = (($color[1] & 0xf800) >> 8) * 65536 + (($color[1] & 0x07e0) >> 3) * 256 + (($color[1] & 0x001f) << 3); // 565
				  }
				  break;
				case 8:
				  $color = unpack('n', $vide . substr($data, $p, 1));
				  $color[1] = $palette[ $color[1] + 1 ];
				  break;
				case 4:
				  $color = unpack('n', $vide . substr($data, floor($p), 1));
				  $color[1] = ($p * 2) % 2 == 0 ? $color[1] >> 4 : $color[1] & 0x0F;
				  $color[1] = $palette[ $color[1] + 1 ];
				  break;
				case 1:
				  $color = unpack('n', $vide . substr($data, floor($p), 1));
				  switch (($p * 8) % 8) {
					case 0: $color[1] =  $color[1] >> 7; break;
					case 1: $color[1] = ($color[1] & 0x40) >> 6; break;
					case 2: $color[1] = ($color[1] & 0x20) >> 5; break;
					case 3: $color[1] = ($color[1] & 0x10) >> 4; break;
					case 4: $color[1] = ($color[1] & 0x8 ) >> 3; break;
					case 5: $color[1] = ($color[1] & 0x4 ) >> 2; break;
					case 6: $color[1] = ($color[1] & 0x2 ) >> 1; break;
					case 7: $color[1] = ($color[1] & 0x1 );      break;
				  }
				  $color[1] = $palette[ $color[1] + 1 ];
				  break;
				default:
				  trigger_error('imagecreatefrombmp: ' . $filename . ' has ' . $meta['bits'] . ' bits and this is not supported!', E_USER_WARNING);
				  return false;
			  }
			  imagesetpixel($im, $x, $y, $color[1]);
			  $x++;
			  $p += $meta['bytes'];
			}
			$y--;
			$p += $meta['decal'];
		  }
		  fclose($fh);
		  return $im;
		}
		}
