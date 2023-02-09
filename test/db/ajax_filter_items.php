<?php
//Printing the filters

// $_POST['paym_opt'] = array('locally');

echo "<br>filter category that was just selected: ";
echo "<br>item that was just selected: ";
echo "<br>items that were previously selected";


echo "<pre>POST alussa: " . var_export($_POST, true) . "</pre>";

$printed = array();
$filters = array('paym_opt', 'locality');
$payment_options = array('iban', 'cash', 'btc', 'eth', 'doge', 'ltc', 'paypal', 'mobile_pay', 'more_available', 'stripe', 'credit_debit', 'mobile_payments', 'btc_gold');
$locality = array('locally', 'online');

function print_filters($based_on_property, $property_to_print) {
    if(isset($_POST[$based_on_property])){
        // $property_to_print = 'locality';
        $array = $_POST[$based_on_property];
        $connect = new PDO('mysql:host=localhost;dbname=se_m1p;', 'root', '');
        $query = "SELECT DISTINCT `$property_to_print` FROM `services` ";

        // If selecting e.g. multiple payment methods, generating the query based on them, including "WHERE" and "OR" when needed:
        foreach($array as $index => $opt) {
            if ($index === array_key_first($array)) {
                $query .= "WHERE ";
            }
            if ($index !== array_key_last($array)) {
                $query .= "$based_on_property LIKE '%$opt%' OR ";
            } else {
                $query .= "$based_on_property LIKE '%$opt%'";
            }
        }

        $stmt = $connect->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        $opts = "";
        // echo "<br>Results as they are: <br>";
        // print_r($result);
        // echo "<br><br><br>";
        $separator = ", ";
        foreach($result as $row) { 
            if ($row[$property_to_print]) {
                $opts .= implode($separator, unserialize($row[$property_to_print])).$separator;
                // echo "Building string of options: ".$opts."<br>";
            }
            //If inarray $all_options, stop... (no need to scan 10,000 objects for locality to find out both options are there)
        }
        $opts2 = rtrim($opts, $separator);
        $opts_array = explode($separator, $opts2);
        $unique_opts = array_unique($opts_array);
        // echo "Exploded array: <br>";
        // print_r($opts_array);
        // echo "<br><br><br>";
        // echo "Uniques only: <br>";
        // print_r($unique_opts);
        // echo "<br><br><br>";
        echo $query;
        foreach($unique_opts as $opt) {
            echo '<div class="se_outer"><label class="list_group_item checkbox"><input type="checkbox" class="filter brand '.$property_to_print.'" value="'.$opt.'">'.$opt.'</label></div><br>';
        }
    }
}

function print_empty_filters($property) {
    $connect = new PDO('mysql:host=localhost;dbname=se_m1p;', 'root', '');
    $query = "SELECT DISTINCT (`$property`) FROM `services` ORDER BY `id`";
    $stmt = $connect->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt->closeCursor();
    $opts = "";
    // echo "<br>Results as they are: <br>";
    // print_r($result);
    // echo "<br><br><br>";
    $separator = ", ";
    foreach($result as $row) { 
        if ($row[$property]) {
            $opts .= implode($separator, unserialize($row[$property])).$separator;
            // echo "Building string of options: ".$opts."<br>";
        }
        //If inarray $all_options, stop... (no need to scan 10,000 objects for locality to find out both options are there)
    }
    $opts2 = rtrim($opts, $separator);
    $opts_array = explode($separator, $opts2);
    $unique_opts = array_unique($opts_array);
    // echo "Exploded array: <br>";
    // print_r($opts_array);
    // echo "<br><br><br>";
    // echo "Uniques only: <br>";
    // print_r($unique_opts);
    // echo "<br><br><br>";
    foreach($unique_opts as $opt) {
        // echo '<label class="list_group_item checkbox"><input type="checkbox" class="filter brand '.$property.'" value="'.$opt.'">'.$opt.'</label><br>';
        echo '<div class="se_outer"><label class="list_group_item checkbox"><input type="checkbox" class="filter brand '.$property.'" value="'.$opt.'">'.$opt.'</label></div><br>';
    }
}

foreach($filters as $index => $filter_i) {
    foreach($filters as $index => $filter_j) {
        if ($filter_i === $filter_j) {
            if(in_array($filter_j, $printed)) {
                echo "<br>shouldn't print ".$filter_j;
            } else {
            echo "<br>$ filter_i === $ filter_j    (".$filter_i." === ".$filter_j.")    Won't search from ".$filter_j." based on ".$filter_i.", printing empty filters...";
            print_empty_filters($filter_j);
            array_push($printed, $filter_j);
            }
        } else {
            if(in_array($filter_j, $printed)) {
                echo "<br>shouldn't print ".$filter_j;
            } else {
            echo "<br>$ filter_i !== $ filter_j    (".$filter_i." !== ".$filter_j.")    Searching from ".$filter_j." based on ".$filter_i.", printing relevant filters...";
            print_filters($filter_i, $filter_j);
            array_push($printed, $filter_j);
            }
        }
    }
}
























// print_filters('locality', 'paym_opt');

// if(isset($_POST['paym_opt'])){
//     $property = 'locality';
//     $array = $_POST['paym_opt'];
//     $connect = new PDO('mysql:host=localhost;dbname=se_m1p;', 'root', '');
//     $query = "SELECT DISTINCT `$property` FROM `services` ";

//     foreach($array as $index => $opt) {
//         if ($index === array_key_first($array)) {
//             $query .= "WHERE ";
//         }
//         if ($index !== array_key_last($array)) {
//             $query .= "paym_opt LIKE '%$opt%' OR ";
//         } else {
//             $query .= "paym_opt LIKE '%$opt%'";
//         }
//     }

//     $stmt = $connect->prepare($query);
//     $stmt->execute();
//     $result = $stmt->fetchAll();
//     $stmt->closeCursor();
//     $opts = "";
//     // echo "<br>Results as they are: <br>";
//     // print_r($result);
//     // echo "<br><br><br>";
//     $separator = ", ";
//     foreach($result as $row) { 
//         if ($row[$property]) {
//             $opts .= implode($separator, unserialize($row[$property])).$separator;
//             // echo "Building string of options: ".$opts."<br>";
//         }
//         //If inarray $all_options, stop... (no need to scan 10,000 objects for locality to find out both options are there)
//     }
//     $opts2 = rtrim($opts, $separator);
//     $opts_array = explode($separator, $opts2);
//     $unique_opts = array_unique($opts_array);
//     // echo "Exploded array: <br>";
//     // print_r($opts_array);
//     // echo "<br><br><br>";
//     // echo "Uniques only: <br>";
//     // print_r($unique_opts);
//     // echo "<br><br><br>";
//     foreach($unique_opts as $opt) {
//         echo '<div class="se_outer"><label class="list_group_item checkbox"><input type="checkbox" class="filter brand '.$property.'" value="'.$opt.'">'.$opt.'</label></div><br>';
//     }
//     // echo $query;
// }


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
$connect = new PDO('mysql:host=localhost;dbname=se_m1p;', 'root', '');
$stmt = $connect->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll();
$stmt->closeCursor();
if($stmt->rowCount() > 0) {
    echo "<br><br><br><br><br><br><br><br><h2>Results:</h2><br>";
    foreach($result as $row) {
        echo '<table>';
        echo '<tr><td>'.$row['title'].'</td></tr>';
        echo '</table>';
    }
}