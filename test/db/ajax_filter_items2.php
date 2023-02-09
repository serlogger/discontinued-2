<?php
//Printing the checkbox filters

// New dynamic cats printing
$query = "WITH RECURSIVE cats_path (id, name, path) AS ( SELECT id, name, name as path FROM cats WHERE parent_id = 0 UNION ALL SELECT c.id, c.name, CONCAT(cp.path, ' > ', c.name) FROM cats_path AS cp JOIN cats AS c ON cp.id = c.parent_id ) SELECT * FROM cats_path ORDER BY path;";
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll();
foreach($results as $result) {
    // if (isset($latest)) {
    //     if (stripos($result['path'], $latest) == 0) {
    //         echo str_replace($latest, "", $result['path'])."<br>";
    //     } else {
    //         echo $result['path']."<br>";
    //     }
    // } else {
        echo $result['path']."<br>";
    // }
    // $latest = $result['path'];
}
echo "<br>";
// EO New dynamic cats printing

//Creating checkboxes array

$checkbox_filter_groups_2d = array();

$cats = array('ind_id', 'cat_id', 'sc_id');
$parents = array();
foreach ($cats as $cat) {
    $query = "SELECT DISTINCT 
        services.$cat
        FROM services
        ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $stmt->closeCursor();
    $checkbox_filter_cats_2d[$cat] = array();
    foreach($results as $index_a => $result) {
        $checkbox_filter_groups_2d[$cat][$index_a] = $result[$cat];
    }

    if($cat == "ind_id") {
        $katti1 = "cat1_industries";
        $parent = "";
    } else if ($cat == "cat_id") {
        $katti1 = "cat2_categories";
        $parent = ", parent_id";
    } else if ($cat == "sc_id") {
        $katti1 = "cat3_subcat";
        $parent = ", parent_id";
    }

    $query4 = "SELECT $cat $parent FROM $katti1";
    $stmt = $conn->prepare($query4);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $stmt->closeCursor();
    foreach($results as $result) {
        if($cat!=="ind_id") {
            // echo "my id: ".$result[$cat]."<br>";
            // echo "parent id: ".$result['parent_id']."<br>";
        $parents[$cat][$result[$cat]] = $result['parent_id'];
        }
    }
}

// echo "SELECT FROM table WHERE ";
if(isset($_POST['ind_id']) && isset($_POST['cat_id'])) {
    foreach($_POST['ind_id'] as $ind_id) {
        foreach($_POST['cat_id'] as $cat_id) {
            // echo "Post ind id: ".$ind_id."<br>";
            // echo "Post cat id: ".$cat_id."<br>";
            if($parents['cat_id'][$cat_id] == $ind_id) {
                // echo "match found <br>";
                // echo "(ind_id = ".$ind_id." AND cat_id = ".$cat_id.")<br>";
                // if (($key = array_search($ind_id, $_POST['ind_id'])) !== false) {
                //     unset($_POST['ind_id'][$key]);
                // }
            }
        }
    }
}
if(isset($_POST['cat_id']) && isset($_POST['sc_id'])) {
    foreach($_POST['cat_id'] as $cat_id) {
        foreach($_POST['sc_id'] as $sc_id) {
            // echo "Post ind id: ".$cat_id."<br>";
            // echo "Post cat id: ".$sc_id."<br>";
            if($parents['sc_id'][$sc_id] == $cat_id) {
                // echo "mmmatch found <br>";
                // if (($key = array_search($ind_id, $_POST['ind_id'])) !== false) {
                //     unset($_POST['ind_id'][$key]);
                // }
            }
        }
    }
}


// // echo "<pre>Parents: " . var_export($parents, true) . "</pre>";
// echo "<pre>POST ind: " . var_export($_POST['ind_id'] ?? "", true) . "</pre>";
// echo "<pre>POST cat: " . var_export($_POST['cat_id'] ?? "", true) . "</pre>";
// echo "<pre>POST sc: " . var_export($_POST['sc_id'] ?? "", true) . "</pre>";

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
    $text2 = "";
    $modified = FALSE;
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
                if (in_array($current_filter_group, $cats) && in_array($filter, $cats)) {
                    $text = ' 1=1 ';
                } else if (in_array($filter, $cats)) {
                    $text = $filter . $equals . $single_quote . $opt . $single_quote;
                } else {
                    $text = $filter . $like . $single_quote . $wildcard . $opt . $wildcard . $single_quote;
                }
                if($index_j !== array_key_last($_POST[$filter])) {
                    $text .= $or;
                } else {
                    $text .= $closing;
                }
                $filter_query_conc .= $text;
            }
            $modified = TRUE;
        }
        if($index_i === array_key_last($checkbox_filter_group_names_1d)) {
            $starttime = microtime(true);
            print_filters($conn, $current_filter_group, $filter, $filter_query.$filter_query_conc, $checkbox_filter_groups_2d_removable, $cats);
            $endtime = microtime(true);
            $duration = $endtime - $starttime; //calculates total time taken
            echo 1000*$duration." ms<br>";
        }
    }
    //EO Regular checkboxes
}
//EO SQL query builder - Checkboxes

function print_filters($conn, $property_to_print, $based_on_property, $query, $checkbox_filter_groups_2d_removable, $cats) {
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
            // if(in_array($property_to_print, $cats)) { 
            if($property_to_print == "ind_id") {
                $query3 = "SELECT ind FROM cat1_industries WHERE $property_to_print = $opt";
                $stmt = $conn->prepare($query3);
                $stmt->execute();
                $result = $stmt->fetch();
                echo '  <div class="se_outer">
                            <label class="list_group_item checkbox">
                                <input type="checkbox" '.$checked.' class="filter brand '.$property_to_print.'" name='.$property_to_print.' value="'.$opt.'">'.$result['ind'].'
                            </label>
                            <div data-for="inner_checkboxes" id="'.$property_to_print.'_'.$opt.'">
                            </div>
                        </div>';
                } else if (!in_array($property_to_print, $cats)) {
                echo '  <div class="se_outer">
                            <label class="list_group_item checkbox">
                                <input type="checkbox" '.$checked.' class="filter brand '.$property_to_print.'" name='.$property_to_print.' value="'.$opt.'">'.$opt.'
                            </label>
                        </div>';
            }

            if($property_to_print == "cat_id" || $property_to_print == "sc_id" ) {
                if($property_to_print == "cat_id") {
                    $par = "ind";
                    $cat = "cat";
                    $katti = "cat2_categories";
                    $indent = "style='margin-left:1rem;'";
                } else {
                    $par = "cat";
                    $cat = "sc"; 
                    $katti = "cat3_subcat";
                    $indent = "style='margin-left:2rem;'";
                }
                $query2 = "SELECT $cat, parent_id FROM $katti WHERE $property_to_print = $opt";
                $stmt = $conn->prepare($query2);
                $stmt->execute();
                $results = $stmt->fetchAll();
                // $potko = "";
                foreach($results as $index_c => $result) {
                    echo "<script>document.getElementById('".$par."_id_".$result['parent_id']."').innerHTML += \"<div ".$indent."><label class='list_group_item checkbox'><input type='checkbox' ".$checked." class='filter brand ".$property_to_print."' value='".$opt."'>".$result[$cat]."</label></div><div data-for='inner_checkboxes' id=".$property_to_print.'_'.$opt."></div>\"</script>";
                }
            }
            
        }
        echo "</div>";
    // }
}


$query = "
SELECT * FROM `services`
";

if(isset($_POST['paym_opt'])){
    // echo "<pre>" . var_export($_POST['paym_opt'], true) . "</pre>";
    $array = $_POST['paym_opt'];
    foreach($array as $index => $opt) {
        if ($index === array_key_first($array)) {
            $query .= "WHERE ";
        }
        if ($index !== array_key_last($array)) {
            $query .= "paym_opt LIKE '%$opt%' OR ";
        } else {
            $query .= "paym_opt LIKE '%$opt%'";
        }
    }
}

// echo $query;
$conn = new PDO('mysql:host=localhost;dbname=se_m1p;', 'root', '');
    // $query = "SELECT DISTINCT * FROM `services` WHERE (paym_opt LIKE '%btc_gold_loc%' OR paym_opt LIKE '%stripe_onl%') AND (locality LIKE '%locally%' OR locality LIKE '%online%')";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll();
$stmt->closeCursor();
if($stmt->rowCount() > 0) {
    echo "<br><h2>Results:</h2><br>";
    foreach($result as $row) {
        echo '<table>';
        echo '<tr><td>'.$row['title'].'</td></tr>';
        echo '</table>';
    }
}

// Echoing scripts so the above dynamic content will work
echo "<script>
        $('.filter').click(function(){
            console.log('________________Filter clicked, filtering items next...');
            ajax_filter_items(this.name);
        });
</script>";

// // Temp cat fix

// // $table = "cat1_industries";
// // $cat_id = "ind_id";
// // $new_column = "path";
// // $old_column = $cat_id;

// // $table = "cat2_categories";
// // $cat_id = "cat_id";
// // $new_column = "parent_path";
// // $old_column = $cat_id;
// // $parent = "cat1_industries";
// // $parent_id = "ind_id";

// // $table = "cat3_subcat";
// // $cat_id = "sc_id";
// // $new_column = "temp_path";
// // $old_column = $cat_id;
// // $parent = "cat2_categories";
// // $parent_id = "cat_id";

// $from_table = "cat3_subcat";
// $from_column = "sc";
// $to_table = "cats";
// $to_column = "name";

// // $query = "UPDATE services
// //     INNER JOIN $table ON services.$cat_id = $table.$cat_id
// //     SET services.$new_column = CONCAT(CONCAT('_', REPLACE(REPLACE(LOWER($table.$old_column), ' & ', '_'), ' ', '_')), '_'),
// //     ";

// // $query = "INSERT INTO $to_table (name, temp)
// //     SELECT $from_column, '$from_column'
// //     FROM $from_table
// //     ";

// // $query = "UPDATE cats 
// //         SET cats.path = CONCAT(cats.tenp, '_0', cats.id)
// //         WHERE cats.temp = 'sc'
// //         ";


// // SET $new_column = CONCAT('_', $table.parent_path)
// // SET $new_column = CONCAT($parent.path, $table.path)
// $stmt = $conn->prepare($query);
// $stmt->execute();
// $stmt->closeCursor();
// // EO Temp cat fix