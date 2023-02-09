<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        td {
            border: 1px solid forestgreen;
            width: 300px;
            /* height: 30px; */
        }

        .se_outer {
            border: 1px solid coral;
            width: 300px;
        }
    </style>
</head>
<body>
    <?php
    // function print_unique_filters($property) {
    //     $connect = new PDO('mysql:host=localhost;dbname=se_m1p;', 'root', '');
    //     $query = "SELECT DISTINCT (`$property`) FROM `services` ORDER BY `id`";
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
    //         echo '<label class="list_group_item checkbox"><input type="checkbox" class="filter brand '.$property.'" value="'.$opt.'">'.$opt.'</label><br>';
    //     }
    // }
    // print_unique_filters('paym_opt');
    // print_unique_filters('locality');
    ?>
    <div class="item_results" id="wrapper">
    </div>
    <script>
        $("document").ready(function() {

            function fetch_value(item) {
                console.log('fetch_value("'+item+'") executing...');
                var selections = new Array();
                if('.'+item) {console.log(1);} else {console.log(2);}
                $('.'+item+':checked').each(function(){
                    selections.push($(this).val());
                });
                console.log('...and returning '+selections);
                return selections;
            }

            // function ajax_filter_filters() {

            // }

            function ajax_filter_items() {
                console.log('"God function" A.K.A. ajax_filter_items() executing...');
                var paym_opt = fetch_value('paym_opt');
                var locality = fetch_value('locality');
                var se_function = 'ajax_filter_items';
                // $('.item_results').html('<div id="whl"></div>');
                $.ajax({
                    url:"/db_controller.py",
                    method:"POST",
                    data:{ se_function:se_function, paym_opt:paym_opt, locality:locality},
                    success: function(result) {
                        $('.item_results').html(result);
                    }

                });
            }

            function se_filter_click() {
                ajax_filter_items();
                // ajax_filter_filters();
            }
            
            $('#wrapper').click(function(){
                var se_time = new Date();
                console.log(' ');
                console.log(se_time);
                console.log('Wrapper clicked. There will be consequences...');
                se_filter_click();
            });
            $('.filter').click(function(){
                var se_time = new Date();
                console.log(' ');
                console.log(se_time);
                console.log('Filter clicked. There will be consequences...');
                se_filter_click();
            });

            ajax_filter_items();

        });
    </script>
</body>
</html>
