<?php
/* Todo: 
- Make jsTree remember applicable values on filtering
- Question: checkbox_filter_groups_2d does not define fully the values to use. Why?
*/

//Query builder of js_tree for other filters:
$js_selected = "";
if(isset($_POST['js_tree_value'])) {
	if($_POST['js_tree_value'] !== "") {
		echo "js_tree checkboxes checked, filtering based on them should start";
		echo "<pre>\$_POST['js_tree_value'] = " . var_export($_POST['js_tree_value'], true) . "</pre>";

		$jst_query = "";
		foreach($_POST['js_tree_value'] as $index => $row) {
			$jst_query .= "js_tree_cat=".$row;
			if ($index !== array_key_last($_POST['js_tree_value'])) {
				$jst_query .= " OR ";
			}
		}
		echo "<br>\$jst_query = ".$jst_query."<br>";
		// Creating array for jst value preservation
		foreach($_POST['js_tree_value'] as $index_n => $js_value) {
			if($index_n == array_key_first($_POST['js_tree_value'])) {
				$js_selected .= "[";
			}
			$js_selected .= "'".$js_value."'";
			if($index_n !== array_key_last($_POST['js_tree_value'])) {
				$js_selected .= ", ";
			} else {
				$js_selected .= "]";
			}
		}
		echo "\$js_selected = ".$js_selected;
		// EO Creating array for jst value preservation
	} else {
	$jst_query = "";
	echo "No js_tree checkboxes checked (empty)";
	} 
} else {
	$jst_query = "";
	echo "No js_tree checkboxes checked (not set)";
}


// EO Query builder of js_tree for other filters:

$checkbox_filter_groups_2d = array();

// Store these into config?
$checkbox_filter_groups_2d['paym_opt_csv'] = array(
	'_iban_', 
	'_cash_', 
	'_btc_', 
	'_eth_', 
	'_doge_', 
	'_ltc_', 
	'_paypal_', 
	'_mobile_pay_', 
	'_more_available_', 
	'_stripe_onl_', 
	'_credit_debit_', 
	'_mobile_payments_', 
	'_btc_gold_loc_');
$checkbox_filter_groups_2d['locality_csv'] = array(
	'_locally_', 
	'_online_');
$checkbox_filter_groups_2d['brands'] = array(
	'_apple_', 
	'_huawei_', 
	'_nokia_', 
	'_samsung_', 
	'_xiaomi_');
$checkbox_filter_groups_2d['js_tree_cat'] = array(
	'1', 
	'2', 
	'3', 
	'4', 
	'5',
	'6',
	'7', 
	'8', 
	'9', 
	'10', 
	'11',
	'12');

//Creating helper arrays to manage $checkbox_filter_groups_2d
$checkbox_filter_groups_2d_removable = $checkbox_filter_groups_2d;

$checkbox_filter_group_names_1d = [];
foreach($checkbox_filter_groups_2d as $key=>$value)
{
	array_push($checkbox_filter_group_names_1d, $key);
}
//EO Creating checkboxes array

// Preparing variables for SQL query builder
$or = " OR ";
$and = " AND ";
$where = " WHERE ";
$opening = "(";
$like = " LIKE ";
$equals = " = ";
$wildcard = "%";
$single_quote = "'";
$closing = ")";
$text = "";



// SQL query builder - Checkboxes

foreach($checkbox_filter_group_names_1d as $current_filter_group){
	$filter_query = "SELECT DISTINCT `$current_filter_group` FROM `services`";
	$filter_query_conc = "";
	$text = "";
	// $text2 = "";
	$modified = FALSE; // defines if the SQL query has been modified
	$jst_added = FALSE; // defines if JSTree filtering has been added to SQL query or not
	//Regular checkboxes
	foreach($checkbox_filter_group_names_1d as $index_i => $filter) {
		if($current_filter_group !== $filter && isset($_POST[$filter])) {
			if($index_i !== array_key_first($checkbox_filter_group_names_1d)) {
				if ($modified == TRUE) {
					$filter_query_conc .= $and;
				} else {
					$filter_query_conc .= $where;
				}
				$filter_query_conc .= $opening;
			} else {
				$filter_query_conc .= $where;
				$filter_query_conc .= $opening;
			}
			foreach($_POST[$filter] as $index_j => $opt) {
				$text = $filter . $like . $single_quote . $wildcard . $opt . $wildcard . $single_quote;
				if($index_j !== array_key_last($_POST[$filter])) {
					$text .= $or;
				} else {
					$text .= $closing;
				}
				$filter_query_conc .= $text;
			}
			$modified = TRUE;
		}
		// Adding JSTree filtering
		if($filter !== "js_tree_cat" && $jst_query !== "") {
			if($modified == TRUE && $jst_added == FALSE) {
				$filter_query_conc .= " AND (".$jst_query.")";
				$jst_added = TRUE;
			} elseif ($modified == FALSE && $jst_added == FALSE) {
				$filter_query_conc .= " WHERE (".$jst_query.")";
				$jst_added = TRUE;
				$modified = TRUE;
			}
		}
		// EO Adding JSTree filtering
		$whole_query = $filter_query.$filter_query_conc;
		if($current_filter_group == "js_tree_cat") {
			$_SESSION['stmt1'] = $whole_query;
		}
		if($index_i === array_key_last($checkbox_filter_group_names_1d)) {
			$starttime = microtime(true);
			print_filters($conn, $current_filter_group, $filter, $whole_query, $checkbox_filter_groups_2d_removable);
			$endtime = microtime(true);
			$duration = $endtime - $starttime; //calculates total time taken
			echo 1000*$duration." ms<br>";
		}
	}
	//EO Regular checkboxes
}
//EO SQL query builder - Checkboxes

function print_filters($conn, $property_to_print, $based_on_property, $query, $checkbox_filter_groups_2d_removable) {
	// if(isset($_POST[$based_on_property])){
		echo "<h3>".$query."</h3>";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$opts = "";
		// echo "<br>Results as they are: <br>";
		// print_r($result);
		// echo "<br><br><br>";
		$separator = ", ";

		foreach($result as $index_k => $row) {
			if(!empty($checkbox_filter_groups_2d_removable[$property_to_print])) {
				$opts .= $row[$property_to_print];
				$opts_array = explode($separator, $opts);

				// echo "<br>Checking if any of these ".$opts." is in... <br>";
				// echo "<pre>" . var_export($checkbox_filter_groups_2d_removable[$property_to_print], true) . "</pre>";

				foreach($checkbox_filter_groups_2d_removable as $index_l=>$group) {
					foreach ($group as $index_m => $value) {
						if ($index_l == $property_to_print) {
							if(in_array($value, $opts_array)) {
								// echo $value."<span style='color:forestgreen;'> in array, unsetting it... </span><br>";
								unset($checkbox_filter_groups_2d_removable[$index_l][$index_m]);
							} else {
								// echo $value." <span style='color:coral;'>was not in array so it won't be removed (nuttin to remove)</span><br>";
							}
						}
					}
				}
				// echo "<pre>After removal loop: " . var_export($checkbox_filter_groups_2d_removable[$property_to_print], true) . "</pre>";
				$opts .= $separator;
			} else {
				// Emptied the array, breaking the loop
				break;
			}
		}
		$opts = rtrim($opts, $separator); // As the above loop may break way before going thgough all options, removing the separator afterwards
		$opts_array = explode($separator, $opts);
		$unique_opts = array_unique($opts_array);
		// echo "Exploded array: <br>";
		// echo "<pre>" . var_export($opts_array, true) . "</pre>";
		// echo "<br><br><br>";
		// echo "Uniques only: <br>";
		// print_r($unique_opts);
		// echo "<br><br><br>";
		echo "<div id='".$property_to_print."' class='property_wrapper'>";
		foreach($unique_opts as $opt) {
			$checked = "";
			if (isset($_POST[$property_to_print])) {
				if(in_array($opt, $_POST[$property_to_print])) {
					$checked = "checked";
				}
			}
			echo '  <div class="se_outer">
						<label class="list_group_item checkbox">
							<input type="checkbox" '.$checked.' class="filter brand '.$property_to_print.'" name='.$property_to_print.' value="'.$opt.'">'.$opt.'
						</label>
					</div>';
			
		}
		echo "</div>";
	// }
}

// // Listing the services
// $query = "
// SELECT * FROM `services`
// ";

// // if(isset($_POST['paym_opt'])){
// // 	// echo "<pre>" . var_export($_POST['paym_opt'], true) . "</pre>";
// // 	$array = $_POST['paym_opt'];
// // 	foreach($array as $index => $opt) {
// // 		if ($index === array_key_first($array)) {
// // 			$query .= "WHERE ";
// // 		}
// // 		if ($index !== array_key_last($array)) {
// // 			$query .= "paym_opt LIKE '%$opt%' OR ";
// // 		} else {
// // 			$query .= "paym_opt LIKE '%$opt%'";
// // 		}
// // 	}
// // }

// // echo $query;
// $conn = new PDO('mysql:host=localhost;dbname=se_m1p;', 'root', '');
// 	// $query = "SELECT DISTINCT * FROM `services` WHERE (paym_opt LIKE '%btc_gold_loc%' OR paym_opt LIKE '%stripe_onl%') AND (locality LIKE '%locally%' OR locality LIKE '%online%')";
// $stmt = $conn->prepare($query);
// $stmt->execute();
// $result = $stmt->fetchAll();
// $stmt->closeCursor();
// if($stmt->rowCount() > 0) {
// 	echo "<br><h2>Results:</h2><br>";
// 	foreach($result as $row) {
// 		echo '<table>';
// 		echo '<tr><td>'.$row['title'].'</td></tr>';
// 		echo '</table>';
// 	}
// }
// // EO Listing the services

// Querying parents of categories

$query = $_SESSION['stmt1'];
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll();
$stmt->closeCursor();

$all_ids_array = array();
foreach ($result as $row) {
	$id = $row['js_tree_cat'];
	$query = "SELECT * FROM `treeview_items` WHERE id=$id";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$result2 = $stmt->fetchAll();
	$stmt->closeCursor();
	foreach ($result2 as $row) {
		$var_to_loop = $row['id'];
		while ($var_to_loop !== FALSE) {
			$query = "SELECT * FROM `treeview_items` WHERE id=$var_to_loop";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			$result2 = $stmt->fetch();
			$stmt->closeCursor();
			if($result2['parent_id'] != 0) {
				echo "<pre>" . var_export($var_to_loop." has parent: ".$result2['parent_id'], true) . "</pre>";
				array_push($all_ids_array, $var_to_loop, $result2['parent_id']);
				$var_to_loop = $result2['parent_id'];
			} elseif ($result2['parent_id'] == 0) {
				echo "<pre>" . var_export($var_to_loop." is at the root level", true) . "</pre>";
				array_push($all_ids_array, $var_to_loop);
				$var_to_loop = FALSE;
				// break;
			} else {
				echo "<pre>" . var_export("no numeric parent id found for ". $var_to_loop, true) . "</pre>";
				$var_to_loop = FALSE;
				// break;
			}
		}   
	}
}
$all_unique_ids_array = array_unique($all_ids_array);
echo "<pre>" . var_export($all_unique_ids_array, true) . "</pre>";
// EO Querying parents of categories

// Query builder for jsTree
$_SESSION['stmt2'] = "WHERE (";
$jst_selected_array = "[";
foreach($all_unique_ids_array as $index => $row) {
	 $_SESSION['stmt2'] .= "id=".$row;
	 $jst_selected_array .= "'$row'";
	 if ($index !== array_key_last($all_unique_ids_array)) {
		  $_SESSION['stmt2'] .= " OR ";
		  $jst_selected_array .= ", ";
	 }
}
$_SESSION['stmt2'] .= ")";
$jst_selected_array .= "]";
echo $_SESSION['stmt2']."<br>";
echo "jst_selected_array: ".$jst_selected_array;
// EO Query builder for jsTree

// Echoing scripts so the above dynamic content will work
echo "<script>
		// alert('filtering items...');
		$('.filter').click(function(){
			ajax_filter_items('a', 'regular filter clicked in ajax_filter_items3.php', '');

			var element = document.createElement('div');
				element.id = 'treeContainer2';
				// document.getElementById('treeWrapper').removeChild(element);
				$('#treeWrapper').html('');
				document.getElementById('treeWrapper').appendChild(element);
			jst_draw('a', 'regular filter clicked in ajax_filter_items3.php', $js_selected);
			console.log(\"jst selected array: $jst_selected_array\");
		});
</script>";