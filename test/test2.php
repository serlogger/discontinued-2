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
    <script>
        function fetch_value(item) {
            console.log('____________________________________');
            console.log('fetch_value("'+item+'") executing...');
            var selections = new Array();
            if('.'+item) {console.log('fetch_value(): .'+item+' found...');} else {console.log('fetch_value(): .'+item+' NOT found...');}
            $('.'+item+':checked').each(function(){
                selections.push($(this).val());
            });

            console.log('fetch_value(): returning '+selections);
            return selections;
        }

        function ajax_filter_items(current_filter_group) {
            console.log('____________________________________');
            console.log(new Date());
            console.log('"God function" A.K.A. ajax_filter_items() executing...');
            var paym_opt_csv = fetch_value('paym_opt_csv');
            var locality_csv = fetch_value('locality_csv');
            var brands = fetch_value('brands');
            var ind_id = fetch_value('ind_id');
            var cat_id = fetch_value('cat_id');
            var sc_id = fetch_value('sc_id');
            var se_function = 'ajax_filter_items';
            if (!current_filter_group) {
                var current_filter_group = "";
            }
            // $('.item_results').html('<div id="whl"></div>');
            $.ajax({
                url:"/db_controller2",
                method:"POST",
                data:{ se_function:se_function, paym_opt_csv:paym_opt_csv, locality_csv:locality_csv, brands:brands, ind_id:ind_id, cat_id:cat_id, sc_id:sc_id, current_filter_group:current_filter_group},
                success: function(result) {
                    $('.item_results').html(result);
                }

            });
        }

    </script>
</head>
<body id="tes">
    <div class="item_results" id="wrapper">
    </div>
    <script>
        $("document").ready(function() {
            ajax_filter_items();
        });
    </script>
</body>
</html>
