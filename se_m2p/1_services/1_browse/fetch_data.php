<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'se_load.php');	

	if (isset($_POST['username']))
	{
		$post_username = $_POST['username'];
	} 

	if (isset($_POST['filter_data'])) {
		$conn = new PDO("mysql:host=localhost;dbname=$se_db", $se_db_pass, "");

		$start = $_POST['start'];
		$limit = $_POST['limit'];
		$default = 50;
		$latitude = $default; 
		$longitude = $default;
        $radius_km = isset($_POST['radius'])?$_POST['radius']:"21000";
		$post_min_price = isset($_POST['min_price'])?$_POST['min_price']:"";
		$post_max_price = isset($_POST['max_price'])?$_POST['max_price']:"";
		$post_created_from = strtotime($_POST['created_from'])-100000;
		$post_created_to = strtotime($_POST['created_to'])+100000;
		$post_edited_from = strtotime($_POST['edited_from'])-100000;
		$post_edited_to = strtotime($_POST['edited_to'])+100000;
		//? ><script>alert("<?=$post_created_from .",". $post_created_to? >");</script><?php
		
		if ($post_max_price < $post_min_price)
		{
			$price_switch = $post_max_price;
			$post_max_price = $post_min_price;
			$post_min_price = $price_switch;
		}

		if (isset($_POST['lat']))
		{
			if($_POST['lat'] !== "")
			{
				$latitude = $_POST['lat'];
			}
		}
		if (isset($_POST['lon']))
		{
			if($_POST['lon'] !== "")
			{
				$longitude = $_POST['lon'];
			}
		}
		$ob="id DESC";
		if (isset($_POST['ob']))
		{
			if($_POST['ob'] !== "")
			{
				$ob = $_POST['ob'];
			}
		}

        $sql_distance = " ,(((acos(sin((".$latitude."*pi()/180)) * sin((`services`.`lat`*pi()/180))+cos((".$latitude."*pi()/180)) * cos((`services`.`lat`*pi()/180)) * cos(((".$longitude."-`services`.`lon`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance ";

        $having = " HAVING (distance <= $radius_km) "; 

		$query = "
		SELECT DISTINCT
			services.*".$sql_distance.",
			media.filepath,
			media.mainpic,
			users.username,
			cat1_industries.ind_id,
			cat1_industries.industry_$current_lang,
			cat2_categories.cat_id,
			cat2_categories.category_$current_lang,
			cat3_subcat.sc_id,
			cat3_subcat.sub_category_$current_lang

			FROM users, media, cat1_industries, cat2_categories, cat3_subcat, services
			WHERE services.srv_stat = 1 AND users.id = services.creator_id AND media.srv_id = services.id AND media.mainpic = 1 AND cat1_industries.ind_id = services.ind_id AND cat2_categories.cat_id = services.cat_id AND cat3_subcat.sc_id = services.sc_id
			$having
			";
		
		if (isset($post_username))
		{
			$query .= "
			AND (users.username LIKE '%$post_username%')
			";
		}

		if (isset($_POST['ind_id']))
		{
			$ind_id_filter = implode("','", $_POST['ind_id']);
			$query .= "
			AND services.ind_id IN ('".$ind_id_filter."')
			";

			if (isset($_POST['cat_id']))
			{
				$cat_id_filter = implode("','", $_POST['cat_id']);
				$query .= "
				AND services.cat_id IN ('".$cat_id_filter."')
				";

				if (isset($_POST['sc_id']))
				{
					$sc_id_filter = implode("','", $_POST['sc_id']);
					$query .= "
					AND services.sc_id IN ('".$sc_id_filter."')
					";
				}

			}

		}

		if (isset($post_min_price) && isset($post_max_price))
		{
			if($post_min_price !== "" && $post_max_price !== "0" && $post_max_price !== "")
			{
				//? ><script>alert(<?=$post_min_price? >);</script><?php
				$query .= "
				AND 
				(
					(
					$post_min_price >= services.min_cp AND
					$post_min_price <= services.max_cp AND
					$post_max_price >= services.min_cp AND
					$post_max_price <= services.max_cp
					)
					OR
					(
					$post_min_price >= services.min_cp AND
					$post_min_price <= services.max_cp AND
					$post_max_price >= services.min_cp AND
					$post_max_price >= services.max_cp
					)
					OR
					(
					$post_min_price <= services.min_cp AND
					$post_min_price <= services.max_cp AND
					$post_max_price >= services.min_cp AND
					$post_max_price <= services.max_cp
					)
					OR
					(
					$post_min_price <= services.min_cp AND
					$post_min_price <= services.max_cp AND
					$post_max_price >= services.min_cp AND
					$post_max_price >= services.max_cp
					)
				)
				";
			}
		}

		$query .= "
		AND ($post_created_from <= services.created_u) 
		";

		$query .= "
		AND ($post_created_to >= services.created_u) 
		";

		$query .= "
		AND ($post_edited_from <= services.edited_u) 
		";

		$query .= "
		AND ($post_edited_to >= services.edited_u) 
		";
		
		$query .= "
		ORDER BY $ob
		LIMIT $start, $limit
		";		
		// ? ><script>console.log('<?=$query? >');</script><?php
		$statement = $conn->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$total_row = $statement->rowCount();
		if (isset($post_username) && $start == "0") 
		{
			if($post_username !== "")
			{
				$response =
				"<br>
				<div style='margin-left:320px;'>
					<pre>".$lang['srv_crtd_by']." <b>" . $post_username . "</b></pre>
				</div>";
			} else {
				$response = "";
			}
		} else {
			$response = "";
		}

		if (isset($post_min_price) && isset($post_max_price))
		{
			if($post_min_price !== "0" || $post_max_price !== "0")
			{
				$response .=
				"<br>
				<div style='margin-left:320px;'>
					<pre>Price range: <b>" . $post_min_price . " - " . $post_max_price . " USD</b></pre>
				</div>";
			} else {
				$response .= "";
			}
		} else {
			$response .= "";
		}

		$statement->closeCursor();

		if ($total_row > 0) {
			
	// Defining the property colorizer function before looping through the results
			if(!function_exists('se_colorize')) {
				function se_colorize($property, $service) {
					if($service[$property] === "") {
						return "color:var(--lighter);";
					} else {
						return "color:var(--dark);";
					}
				}
			}
	// Checking properties for empty values
			if(!function_exists('se_value')) {
				function se_value($property, $service, $empty_value) {
					if ($service[$property] === "") {
						return $empty_value;
					} else {
						return $service[$property];
					}
				}
			}

			foreach($result as $service) {
	// Defining empty value variable for replication
				$empty_value = '<div class="lng_no_entry" id="no_entry_'.$service['id'].'" style="color:var(--light);"></div><script>se_translate_class_after("item_'.$service['id'].'", "lng_no_entry");</script>';

				$servid = $service['id'];
				if (isset($_SESSION['loggedin_user_id']) && isset($_SESSION['user_loggedin']))
				{
					if ($service['creator_id'] == $_SESSION['loggedin_user_id'] || $_SESSION['loggedin_user_role'] == 'Admin')
					{
						$buttons = '
							<div class="buttons">
								<a class="edit" href="'.$_SESSION['hm'].'update/'.san($service['id']).'" style="text-decoration:none;"><i class="fas fa-pen fa-xs icon_margin"></i>'.$lang["update"].' </a>
								<a class="trash" href="'.$_SESSION['hm'].'delete/'.san($service['id']).'" style="text-decoration:none;"><i class="fas fa-trash fa-xs icon_margin"></i>'.$lang["delete"].'</a>
							</div>
						';
					} else {
						$buttons = '';
					}
				} else {
					$buttons = '';
				}
				$qry="SELECT MIN(child_delivery_time_from) as `min_dtf`, MAX(child_delivery_time_to) as `max_dtt`, MIN(child_price) as `min_cp`, MAX(child_price) as `max_cp` from `services_childs` where par_srv_id = $servid";
				$stmt = $conn->prepare($qry);
				$stmt->execute();
				$res = $stmt->fetch(PDO::FETCH_ASSOC);
				$stmt->closeCursor();
				
	// Preparing price, locality and other variables
		// Locality
				if(!empty($service['locality'])) {
					$locality_value = implode(', ', unserialize($service['locality']));
					if (implode(', ', unserialize($service['locality'])) == "locally" && $service['radius'] < $service['distance']) {
						$warning_red_radius = 'style="color:red;" title="This local service is farther than its operating radius."';
					} else {
						$warning_red_radius = '';
					}
				} else {
					$locality_value = "";
					$warning_red_radius = '';
				}


				$username2 = '<span style="color: var(--lighter);" title="'.ucfirst($service['username']);
					
					if (!isset($res['min_dtf']) && !isset($res['max_dtt']))
					{
						$dtime_name =     $username2 .' '. $lang['hasnt_provided_info'].'">'.$lang['dtime_name'].'</span>';
						$dtime_value[0] = $username2 .' '. $lang['hasnt_provided_info'].'">'.$lang['na'].'</span>';
						$dtime_separator = '';
						$dtime_value[1] = '';
						$dtime_unit = '';
						$dtime_color = "color:var(--lighter);";
					} 
					elseif ($res['min_dtf'] == "" && $res['max_dtt'] !== "")
					{
						$dtime_name = $lang['dtime_name'];
						$dtime_value[0] = '';
						$dtime_separator = '';
						$dtime_value[1] = $res['max_dtt'];
						$dtime_unit = $lang['days'];
						$dtime_color = "color:var(--dark);";
					} 
					elseif ($res['min_dtf'] !== "" && $res['max_dtt'] !== "")
					{
						$dtime_name = $lang['dtime_name'];
						$dtime_value[0] = $res['min_dtf'];
						$dtime_separator = ' – ';
						$dtime_value[1] = $res['max_dtt'];
						$dtime_unit = $lang['days'];
						$dtime_color = "color:var(--dark);";

						if ($res['min_dtf'] == $res['max_dtt'])
						{
							$dtime_name = $lang['dtime_name'];
							$dtime_value[0] = '';
							$dtime_separator = '';
							$dtime_value[1] = $res['max_dtt'];
							$dtime_unit = $lang['days'];
							$dtime_color = "color:var(--dark);";
						}
					}
				// For prices
					if (!isset($res['min_cp']) && !isset($res['max_cp']))
					{
						$price_name =     $username2 .' '. $lang['hasnt_provided_info'].'">'.$lang['price_name'].'</span>';
						$price_value[0] = $username2 .' '. $lang['hasnt_provided_info'].'">'.$lang['na'].'</span>';
						$price_separator = '';
						$price_value[1] = '';
						$price_unit = '';
						$price_color = "color:var(--lighter);";
					} 
					elseif ($res['min_cp'] == "" && $res['max_cp'] !== "")
					{
						$price_name = $lang['price_name'];
						$price_value[0] = '';
						$price_separator = '';
						$price_value[1] = $res['max_cp'];
						$price_unit = $lang[$current_currency];
						$price_color = "color:var(--dark);";
					} 
					elseif ($res['min_cp'] !== "" && $res['max_cp'] !== "")
					{
						$price_name = $lang['price_name'];
						$price_value[0] = $res['min_cp'];
						$price_separator = ' – ';
						$price_value[1] = $res['max_cp'];
						$price_unit = $lang[$current_currency];
						$price_color = "color:var(--dark);";

						if ($res['min_cp'] == $res['max_cp'])
						{
							$price_name = $lang['price_name'];
							$price_value[0] = '';
							$price_separator = '';
							$price_value[1] = $res['max_cp'];
							$price_unit = $lang[$current_currency];
							$price_color = "color:var(--dark);";
						}
					}

					

				if(isset($service["category_$current_lang"])){if($service["category_$current_lang"] !== '' AND $service["cat_id"] !== "0"){$cat_arrow = ' → ';}else {$cat_arrow = '';}} else {$cat_arrow = '';}
				if(isset($service["sub_category_$current_lang"])){if($service["category_$current_lang"] !== '' AND $service["sc_id"] !== "0"){$sc_arrow = ' → ';}else {$sc_arrow = '';}} else {$sc_arrow = '';}
				// style="cursor: pointer;"
				// Provide zoom option for pics

				//View counter
				$current_id = $service['id'];
				$statement_view_count_all = $conn->prepare('SELECT * FROM `view_counter` WHERE view_counter.srv_id = ?');
				$statement_view_count_all->execute([$current_id]);
				$result_view_count_all = $statement_view_count_all->fetchAll();
				$total_row_view_count_all = $statement_view_count_all->rowCount();
				$statement_view_count_all->closeCursor();
				// EO view counter

				// URL "simplifier"
				if(isset($service['url'])) {
					$url = $service['url'];
					$simple_url = $service['url']; //for now...
					if(preg_match("/http/", $url)) {
						$url = preg_replace('#^(http(s)?://)?w{3}\.#', '', $url);
						$simple_url = substr($url, 0, 23).'...';
					}
					if ($simple_url === "") {
						$simple_url = $empty_value;
					}
				}

				// EO URL "simplifier"

				// Affiliate
				$info = "";
				$user_object = '<i class="bi bi-person-fill"></i>
				<a style="text-decoration:none;" href="'.$_SESSION['hm'].'?username='.san($service["username"]).'">'.san($service['username']).'</a>';
				if(isset($service['username']))
				{
					if($service['username'] === 'serlog_referral')
					{
						$info = "<span title='".$lang['serlog_referral']."'><i class='bi bi-check-square icon_margin'></i>".$lang['referral']."</span>";
						$user_object = "";
					}
				}

				// EO Affiliate

				
			// Thumbnails
				$thumbs = "";
				$query2 = "SELECT 
				media.filepath,
				services.id
				FROM media, services
				WHERE media.srv_id = $servid AND services.id = $servid";
				$statement2 = $conn->prepare($query2);
				$statement2->execute();
				$result2 = $statement2->fetchAll();
				$total_row2 = $statement2->rowCount();
				$response2 = "";
				$statement2->closeCursor();
				$thumbs_count = 0;
				$thumb_id = 0;
				$thumb_alignment = '';
				foreach($result2 as $thumbnail)
				{
					// if($thumbs_count<8)
					// {
					// 	$thumbs_count++;
					// }
					$thumb_id++;
					$thumb_id_name1 = "thumbnail_".$servid."_".$thumb_id;
					$thumb_id_name2 = "'".$thumb_id_name1."'";
					$thumbs .= '
					<div class="self_div" id="self_div_'.$thumb_id_name1.'"; onmouseover="hover_thumb_'.$servid.'('.$thumb_id_name2.');" onmouseout="hover_out_thumb_'.$servid.'('.$thumb_id_name2.');">
						<img class="thumbnail_self srv_id_'.$servid.'" id="thumbnail_'.$servid.'_'.$thumb_id.'" src='.$_SESSION['hm'] . $media .$ds. $uploads .$ds. $images .$ds. san_url($thumbnail['filepath']).'>
					</div>
					<script>
						function hover_thumb_'.$servid.'(thumb_id) 
						{
							document.getElementById("self_div_" + thumb_id).style.boxShadow = "0 0 10px var(--whitest)";
							document.getElementById("preview_pic_'.$servid.'").src=document.getElementById(thumb_id).src;
							document.getElementById("preview_pic_'.$servid.'").style.overflowAnchor = "none";
						}

						function hover_out_thumb_'.$servid.'(thumb_id) 
						{
							document.getElementById("self_div_" + thumb_id).style.boxShadow = "1px 1px 4px rgba(0, 0, 0, 0.5)";
							//document.getElementById("preview_pic_'.$servid.'").src=document.getElementById(thumb_id).src;
							document.getElementById("preview_pic_'.$servid.'").style.overflowAnchor = "auto";
						}
					</script>
					';
					$thumb_alignment = 'align-items:end;';
				}

				unset($query2 , $statement2 , $result2 , $total_row2, $response2);
			// EO Thumbnails
				
				if($thumbs !== "") 
				{
					$thumbnails_div = '<div class="thumbnails_div">'.$thumbs.'</div>';
				} else {
					$thumbnails_div = '';
				}
				$response .= '
				<div class="m-row2" id="item_'.$service['id'].'" style="box-shadow: 2px 2px 9px rgba(0, 0, 0, 0.3);">
					<div class="column1">
						<div class="background">
							<img id="preview_pic_'.$servid.'" src="'.$_SESSION['hm'] . $media .$ds. $uploads .$ds. $images .$ds. san_url($service['filepath']).'" alt="'.$service['title'].'" title="'.$service['title'].'" class="column1_img">
						</div>
					</div>

					<div class="column2" style="min-height:100%;">

						<div class="column3" style="">
								<a class="" href="view/'.$service['id'].'">'. san($service['title']) .'</a><span style="float:right;">'.$info.' '.$buttons.'<b style="color: var(--dark);" title="'.$lang['service_provider'].'">'.$user_object.'</b></span>
							<div class="column3_description">	
								<p>'.san($service['description']). '</p>
							</div>
						</div>
						<div class="column3" style="border-radius:0; min-height:20px; max-height:40px;">
							<div style="width:20%; float:left;">
								<b style="color: var(--dark);">'.$lang['categorization'].'</b><br>
							</div>
							<div style="width:80%; float:left;">
								<a href="'.$_SESSION['hm'].'?industry='.$service['ind_id'].'&category='.$service['cat_id'].'&subcat='.$service['sc_id'].'">
								'.san($service["industry_$current_lang"]).$cat_arrow.san($service["category_$current_lang"]).$sc_arrow . $service["sub_category_$current_lang"].'</a>
							</div>
						</div>

							<div class="column4" style="">
<!--Properties-->
								<div class="feed_single_detail_name">
									<b style="'.$price_color.'" class="lng_price" id="price_'.$service['id'].'"></b>
								</div>
								<script>se_translate_id_case_1("price", "'.$service['id'].'")</script>
								<div class="feed_single_detail_value">
									'.$price_value[0] . $price_separator . $price_value[1] . ' ' . $price_unit .'
								</div><br>

								<div class="feed_single_detail_name">
									<b style="'.$dtime_color.'" class="lng_delivery_time" id="delivery_time_'.$service['id'].'"></b>
								</div>
								<script>se_translate_id_case_1("delivery_time", "'.$service['id'].'")</script>
								<div class="feed_single_detail_value">
									'.$dtime_value[0] . $dtime_separator . $dtime_value[1] . ' ' . $dtime_unit.'
								</div><br>

								<div class="feed_single_detail_name">
									<b style="'.se_colorize('locality', $service).'" class="lng_locality" id="locality_'.$service['id'].'"></b>
								</div>
								<script>se_translate_id_case_1("locality", "'.$service['id'].'")</script>
								<div class="feed_single_detail_value">
									'.$locality_value.'
								</div><br>

								<div class="feed_single_detail_name">
									<b style="'.se_colorize('location', $service).'" class="lng_location" id="location_'.$service['id'].'"></b>
								</div>
								<script>se_translate_id_case_1("location", "'.$service['id'].'")</script>
								<div class="feed_single_detail_value">
									'.se_value('location', $service, $empty_value).'
								</div><br>

								<div class="feed_single_detail_name">
									<b style="'.se_colorize('distance', $service).'" class="lng_distance" id="distance_'.$service['id'].'"></b>
								</div>
								<script>se_translate_id_case_1("distance", "'.$service['id'].'")</script>
								<div class="feed_single_detail_value">
									<span '.$warning_red_radius.'>'.round($service['distance'],1).' '.$current_distance_unit.'</span>
								</div><br>

								<div class="feed_single_detail_name">
									<b style="'.se_colorize('radius', $service).'" class="lng_operating_radius" id="operating_radius_'.$service['id'].'"></b>
								</div>
								<script>se_translate_id_case_1("operating_radius", "'.$service['id'].'")</script>
								<div class="feed_single_detail_value">
									'.$service['radius'].' '.$current_distance_unit.'
								</div><br>
							</div>

							<div class="column5" style="">
								<div class="feed_single_detail_name">
									<b title="'.$lang['service_email_long'].'" style="'.se_colorize('service_email', $service).'" class="lng_email" id="email_'.$service['id'].'"></b>
								</div>
								<script>se_translate_id_case_1("email", "'.$service['id'].'")</script>
								<div class="feed_single_detail_value">
									<span title="'.$lang['service_email_long'].'">'.se_value('service_email', $service, $empty_value).'</span>
								</div><br>

								<div class="feed_single_detail_name">
									<b style="'.se_colorize('url', $service).'" class="lng_website" id="website_'.$service['id'].'"></b>
								</div>
								<script>se_translate_id_case_1("website", "'.$service['id'].'")</script>
								<div class="feed_single_detail_value">
									<a title="'.$service['url'].'" href="'.$service['url'].'">'.$simple_url.'</a>
								</div><br>

								<div class="feed_single_detail_name">
									<b style="'.se_colorize('created', $service).'" class="lng_created" id="created_'.$service['id'].'"></b>
								</div>
								<script>se_translate_id_case_1("created", "'.$service['id'].'")</script>
								<div class="feed_single_detail_value">
									'.san($service['created']).'
								</div><br>

								<div class="feed_single_detail_name">
									<b style="'.se_colorize('edited', $service).'" class="lng_edited" id="edited_'.$service['id'].'"></b>
								</div>
								<script>se_translate_id_case_1("edited", "'.$service['id'].'")</script>
								<div class="feed_single_detail_value">
									'.san($service['edited']).'
								</div><br>

								<div class="feed_single_detail_name">
									<b style="'.se_colorize('id', $service).'" class="lng_id" id="id_'.$service['id'].'"></b>
								</div>
								<script>se_translate_id_case_1("id", "'.$service['id'].'")</script>
								<div class="feed_single_detail_value">
									'.san($service['id']).'
								</div><br>

								<div class="feed_single_detail_name">
									<b style="color:var(--dark);" title="'.$lang['unique_views'].'" class="lng_view_count" id="view_count_'.$service['id'].'"></b>
								</div>
								<script>se_translate_id_case_1("view_count", "'.$service['id'].'")</script>
								<div class="feed_single_detail_value">
									'.san($total_row_view_count_all).'
								</div><br>
							</div>
						'.$thumbnails_div.'

					</div>
				</div>
				';
			}
			// $_SESSION['imagelink'] = 0;
			exit($response);
		} else
			// $_SESSION['imagelink'] = 0;
			exit('reachedMax');
	}

// Notes:
// Online services shouldn't have operating radius. However, they can have distance and location - do the changes
// Create whole a element into variable and only print that variable when needed
?>