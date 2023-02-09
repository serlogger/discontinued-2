<?php
if (isset($id_to_update))
{
    $query = "SELECT * FROM services_childs WHERE par_srv_id = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_to_update]);
    $results = $stmt->fetchAll();
    $row_count = $stmt->rowCount();
    $stmt->closeCursor();
    // foreach ($results as $result)
    // {
    //     echo $row_count;
    //     echo '<pre>' . var_export($result, true) . '</pre>';
    // }
}
?>
<script>
var createUpdate = "<?=$_SESSION['create_update']?>".replace('/', '_');

$(document).ready(function () {
    var i = 1;
    //var create_update = < ?=isset($id_to_update)?"'update_".$id_to_update."_'":"'create'";?>;
    //console.log("create_update variable value: " + create_update);

    $('#add').click(function () {
        add_child("", "click", "", "", "", "", "", "");
    });

    function add_child(j, source, title, description, dtf, dtt, price, price_spec) {
        if(j !== "")
        {
            i = j;
        }

        // if (localStorage.getItem(createUpdate + '_row' + i)) //making if-logic in case localStorage has value row+i that's been set to "removed". Then we're not going to add it: 
        // {
        //     if (localStorage.getItem(createUpdate + '_row' + i) == 'deleted') 
        //     {
        //         //console.log('not creating row '+i);
        //         // i++;
        //         //return;
        //     }
        // }
            //alert(createUpdate + '_row' + i);
            console.log('Creating row' + i);
            $('#dynamic_field').append(
                '<tr style="border-bottom:1px solid var(--light); border-radius: var(--border-radius);" id="'+createUpdate+'_row_' + i + '">' +
                '<td><b>' + i + ' source: ' + source + '</b>' +
                '<div class="container" style="">' +
                '<div class="row" style="">' +
                '<div style="">' +
                '</div>' +
                '<div class="row" style="">' +
                '<div class="col-md-10" style="">' +
                '<label for="pricing_obj_title" class="">' +
                '<?php echo $lang["title"];?>' +
                '</label>' +
                '<input name="child_title[]" type="text" id="pricing_obj_title' + i + '" class="form-control" name="service_title" placeholder="<?php echo $lang["enter_obj_title"];?>" value="'+title+'" onkeyup="saveValue(this);">' +
                '</div>' +
                '<div class="col-md-2" style="align-items:right; justify-content:right; display:flex;">' +
                '<span class="input-group-btn">' +
                '<button style="height:3rem; margin-top:1.5rem;" type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"><?php echo $lang["delete"];?></button>' +
                '</span>' +
                '</div>' +
                '</div>' +
                '<div class="row" style="">' +
                '<div class="col-md-12" style="">' +
                '<label class="">' +
                '<?php echo $lang["description"];?>' +
                '</label>' +
                '<textarea class="form-control" id="pricing_obj_desc' + i + '" style="height:4rem;" name="child_desc[]" rows="4" name="comment" placeholder="<?php echo $lang["enter_obj_desc"];?>" onkeyup="saveValue(this);" value="'+description+'"></textarea>' +
                '</div>' +
                '</div>' +
                '<div class="row" style="">' +
                '<div class="col-md-6" style="">' +
                '<label for="delivery_time_min" class="">' +
                '<?php echo $lang["delivery_time_from"];?>' +
                '</label>' +
                '<input name="child_delivery_time_from[]" placeholder="<?php echo $lang["from2"];?>" type="text" style="" class="form-control" id="delivery_time_min' + i + '" name="delivery_time_min" title="<?php echo $lang["enter_shortest_delivery_time"];?>" onkeyup="saveValue(this);" value="'+dtf+'">' +
                '</div>' +
                '<div class="col-md-6" style="">' +
                '<label for="delivery_time_max" class="">' +
                '<?php echo $lang["delivery_time_to"];?>' +
                '</label>' +
                '<input name="child_delivery_time_to[]" placeholder="<?php echo $lang["to2"];?>" type="text" class="form-control" style="" id="delivery_time_max' + i + '" name="delivery_time_max" title="<?php echo $lang["enter_longest_delivery_time"];?>" onkeyup="saveValue(this);" value="'+dtt+'">' +
                '</div>' +
                '</div>' +
                '<div class="input-group row" style="">' +
                '<div class="col-md-6" style="">' +
                '<label for="obj_price" class="">' +
                '<?php echo $lang["price"];?>' +
                '</label>' +
                '<input style="" type="text" class="form-control" name="child_price[]" placeholder="<?php echo $lang["enter_price"];?>" id="obj_price' + i + '" title="<?php echo $lang["enter_price"];?>" onkeyup="saveValue(this);" value="'+price+'">' +
                '</div>' +
                '<div class="col-md-6">' +
                '<label for="" class=""><?php echo $lang["additional_info"];?></label>' +
                '<input style="" type="text" class="form-control" name="child_price_spec[]" placeholder="<?php echo $lang["per_h_km"];?>" id="obj_specification' + i + '" title="<?php echo $lang["per_h_km"];?>" onkeyup="saveValue(this);" value="'+price_spec+'">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '</tr>'
                );
            if (source == "click") 
            {
                setTimeout
                    (function () {
                        document.getElementById(createUpdate + '_row_' + (i - 1)).scrollIntoView({ behavior: "smooth" });
                    }, 0
                    );
                console.log('attempted scrolling');
            }
            //Adding row existence to localStorage
            localStorage.setItem(createUpdate + '_row_' + i, 'source: ' + source);

            i++;

    }

    $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        //alert(button_id);
        removalId = createUpdate + '_row_' + button_id;
        //alert(removalId); //works ok with "removalId = '_row'+button_id;"
        if (localStorage.getItem(removalId) == "source: db")
        {
            localStorage.setItem(removalId, "source: db (deleted)");
        } else {
            localStorage.removeItem(removalId);
        }
        
        // localStorage.setItem(createUpdate + '_childItemCount', localStorage.getItem(createUpdate + '_childItemCount')-1)
        $('#' + removalId).fadeOut(150);
        setTimeout(function () { $('#row' + button_id).remove(); }, 150);

    });

    <?php
        if (isset($row_count))
        {
            $i = 1;
            foreach ($results as $result)
            {
                ?>
                if (localStorage.getItem(createUpdate + '_row_' + <?=$i?>))
                {
                    if (localStorage.getItem(createUpdate + '_row_' + <?=$i?>) !== "source: db (deleted)")
                    {
                        add_child(
                            "<?=$i?>", 
                            "db",
                            "<?=$result['child_title']?>", 
                            "<?=$result['child_desc']?>", 
                            "<?=$result['child_delivery_time_from']?>", 
                            "<?=$result['child_delivery_time_to']?>", 
                            "<?=$result['child_price']?>", 
                            "<?=$result['child_price_spec']?>"
                            );
                    }
                } else {
                        add_child(
                            "<?=$i?>", 
                            "db",
                            "<?=$result['child_title']?>", 
                            "<?=$result['child_desc']?>", 
                            "<?=$result['child_delivery_time_from']?>", 
                            "<?=$result['child_delivery_time_to']?>", 
                            "<?=$result['child_price']?>", 
                            "<?=$result['child_price_spec']?>"
                            );
                }
                
                <?php
                $i++;
            }
        }
    ?>

    var j = 1;
    while (j <= 25) {
        if (localStorage.getItem(createUpdate + '_row_' + j))
        {
            if (localStorage.getItem(createUpdate + '_row_' + j) !== "source: db" && localStorage.getItem(createUpdate + '_row_' + j) !== "source: db (deleted)")
            {
                console.log('Adding row from localStorage: ' + createUpdate + '_row_' + j);
                add_child(j, "localStorage", "", "", "", "", "", "");
            }
                var childTitleId = 'pricing_obj_title' + j;
                var childDescId = 'pricing_obj_desc' + j;
                var childDTMinId = 'delivery_time_min' + j;
                var childDTMaxId = 'delivery_time_max' + j;
                var childPriceId = 'obj_price' + j;
                var childPriceSpecId = 'price_spec' + j;

                if (localStorage.getItem(createUpdate + childTitleId)) { if (document.getElementById(childTitleId)) { document.getElementById(childTitleId).value = localStorage.getItem(createUpdate + childTitleId); } }
                if (localStorage.getItem(createUpdate + childDescId)) { if (document.getElementById(childDescId)) { document.getElementById(childDescId).value = localStorage.getItem(createUpdate + childDescId); } }
                if (localStorage.getItem(createUpdate + childDTMinId)) { if (document.getElementById(childDTMinId)) { document.getElementById(childDTMinId).value = localStorage.getItem(createUpdate + childDTMinId); } }
                if (localStorage.getItem(createUpdate + childDTMaxId)) { if (document.getElementById(childDTMaxId)) { document.getElementById(childDTMaxId).value = localStorage.getItem(createUpdate + childDTMaxId); } }
                if (localStorage.getItem(createUpdate + childPriceId)) { if (document.getElementById(childPriceId)) { document.getElementById(childPriceId).value = localStorage.getItem(createUpdate + childPriceId); } }
                if (localStorage.getItem(createUpdate + childPriceSpecId)) { if (document.getElementById(childPriceSpecId)) { document.getElementById(childPriceSpecId).value = localStorage.getItem(createUpdate + childPriceSpecId); } }
                if (localStorage.getItem(createUpdate + childDTMinId)) { if (document.getElementById(childDTMinId)) { document.getElementById(childDTMinId).value = localStorage.getItem(createUpdate + childDTMinId); } }
        }
        j++;
    }

});
</script>