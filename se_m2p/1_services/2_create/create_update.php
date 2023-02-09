<div id="tab_3_content" class="tab_3 grid_container" style="display:none;">
<?php
update_last_seen($pdo);

if (se_login_filter() !== false) {
    echo "true";
} else {
    echo("Please login to create a service<br>");
}
$_SESSION['create_update'] = "create"; //Test only
?>

<!-- JS 
████████████████████████████████████████████████████████████████████████████████
-->
<script>
    
    function _(x){
        return document.getElementById(x);
    }

    function processStartOver(){


        if (confirm("Reset form?")){
            $("#multiphase").method = "post";
            $("#multiphase").action = "start_over.php";
            $("#multiphase").submit();
        } else {
            //cancel clicked
        }
    }
</script>

<!-- 
EO JS, FORM start
████████████████████████████████████████████████████████████████████████████████

████████████████████████████████████████████████████████████████████████████████
-->

<?php 
$_SESSION['8Kb7i7UGInstcL'] = hash_2(uniqid(rand(), true));
$_SESSION['fjr4f8dZq5itrV'] = hash_2($_SESSION['8Kb7i7UGInstcL']);
?>

<div class="content upload" style="width:calc(100% - var(--navtop_width) - 40px); margin-right:20px; margin-left:320px;">
	<form method="post" enctype="multipart/form-data" id="multiphase" action="insert.php">

        <?php set_csrf(); ?>
        <input type="hidden" name="<?=hash_2($_SESSION['8Kb7i7UGInstcL']."Xv02W9ygrLCMNNzElHzploxCsUpT")?>" value="<?=hash_2($_SESSION['8Kb7i7UGInstcL'].'sXT0DsUkYYYwilAde9KQnZraX74P')?>">

        <div style="margin-bottom:2em;">
            <div style="font-size:1.5em; display:inline;"><?=isset($item_to_update['title'])?$lang['update_service'].' "'.$item_to_update['title'].'"':$lang['add_service'];?></div>
            <div style="font-size:1.5em; float:right; display:inline;"><?php if(isset($id_to_update)){echo ' <a href="'.$_SESSION['hm'].'close/'.$id_to_update.'"><i class="bi bi-x-square"></i></a>';}?></div>
        </div>

        <!-- IMG upload -->
        <h5 class=""><?=$lang['upload_images']?></h5>
        <!--? //=isset($item_to_update['filepath'])?'<img id="tuhumb" src='.$_SESSION['hm'] . $media .$ds. $uploads .$ds. $images .$ds. $item_to_update['filepath'].' style="max-height:100%; max-width:100%;">':'<img id="tuhumb" src="" style="max-height:100%; max-width:100%;">';
        ?-->
        <div id="img_fields">
        <?php
        
        for ($i=0; $i<25; $i++)
        {
            if(isset($item_to_update2[$i]["filepath"]))
            {
                $current_fp = '/'.$media.'/'.$uploads.'/'.$images.'/'.$item_to_update2[$i]["filepath"];
            } else {
                $current_fp = "";
            }
            
            echo '
            <div id="thumb_div_'.$i.'" style="display:flex; border:2px solid var(--lighter); border-radius:var(--border-radius); margin:2px; float:left; width:260px;height:60px; flex-direction:row; justify-content:center; align-items:center;">
                <img style="margin:auto; max-width:50px;max-height:50px;" id="thumb'.$i.'" src="'.$current_fp.'">
                <input style="max-width:200px; margin:2px; background-color:var(--lightest); border:4px solid var(--lightest); border-radius:var(--border-radius); overflow:hidden;" type="file" name="myFile'.$i.'" onchange="preview('.$i.')">
            </div>';

        }
        ?>

        </div>
        <!-- EO IMG upload -->

        <!-- Handle image(s) addition -->
        <script>
            function preview(thumbx) {
                for (let i=0; i<25; i++)
                {
                    if (i==thumbx)
                    {
                        console.log(thumbx);
                        console.log("thumb"+i);
                        document.getElementById("thumb"+i).src=URL.createObjectURL(event.target.files[0]);
                    }
                }
            }
        </script>

        <div class="container" id="wrapper">
            <div class="">
                <!-- Categorization -->
                <h5 class=""></h5>

                <!-- Industry -->
                <div class="form-group mt2" style="max-width:400px;">
                    <label for="industries_dropdown"><?=$lang['industry']?></label>
                    <select class="form-control" id="industries_dropdown" onchange="" name="ind_id">
                        <option value="">Select industry</option>
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM `cat1_industries`");
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <option value="<?php echo $row['ind_id']; ?>"><?php echo $row["industry_$current_lang"]; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <!-- Cat -->
                <div class="form-group" style="max-width:400px;">
                    <label for="categories_dropdown"><?=$lang['category']?></label>
                    <select class="form-control" id="categories_dropdown" onchange="saveValue(this);" name="cat_id">
                        <option value="">Select category</option>
                    </select>
                </div>

                <!-- Subcat -->
                <div class="form-group" style="max-width:400px;">
                    <label for="subcat_dropdown"><?=$lang['sub_category']?></label>
                    <select class="form-control" id="subcat_dropdown" onchange="saveValue(this);" name="sc_id">
                        <option value="">Select sub-category</option>
                    </select>
                </div>

                <!-- Contact -->
                <h5 class="mt-5"><?=$lang['contact_information'];?></h5>

                <!-- Email -->
                <?php 
                    $update_email = "john.juan@mail.co";
                ?>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="private_email"><?php echo $lang['private_email'];?></label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="<?=isset($item_to_update['private_email'])?$item_to_update['private_email']:'';?>" name="private_email" placeholder="johndoe@example.com" id="private_email" onkeyup='saveValue(this);'>
                    </div>
                </div>

        <script>
            $("#industries_dropdown").on('change', function () {
                let ind_id = this.value;
                if(ind_id > 0) 
                {
                    document.getElementById("categories_dropdown").disabled = false;
                    document.getElementById("subcat_dropdown").disabled = true;
                }
                if(ind_id == "") 
                {
                    document.getElementById("categories_dropdown").disabled = true;
                    document.getElementById("subcat_dropdown").disabled = true;
                }
                $.ajax({
                    url: "/1-services/2-create/get_cat.php",
                    type: "POST",
                    data: {
                        ind_id:ind_id
                    },
                    cache: false,
                    success: function(result) {
                        $("#categories_dropdown").html(result);
                    }
                });

            });

            $("#categories_dropdown").on("change", function () {
                let cat_id = this.value;
                if(cat_id > 0) 
                {
                    document.getElementById("subcat_dropdown").disabled = false;
                }
                if(cat_id == "") 
                {
                    document.getElementById("subcat_dropdown").disabled = true;
                }
                $.ajax({
                    url: "/1-services/2-create/get_sub_cat.php",
                    type: "POST",
                    data: {
                        cat_id:cat_id
                    },
                    cache:false,
                    success: function(result) {
                        $("#subcat_dropdown").html(result);
                    }
                });
            });
        </script>

<?php
/*
                <!-- Phone -->
                <div class="form-group">
                    <label for="phone"><?=$lang['phone'];?></label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="<?=isset($item_to_update['phone'])?$item_to_update['phone']:'';?>" name="phone" placeholder="<?=$lang['phone_optional'];?>" id="phone" onkeyup='saveValue(this);'>
                    </div>
                </div>
*/
?>

                <!-- Website -->
                <div class="form-group">
                    <label for="phone"><?=$lang['website'];?></label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="<?=isset($item_to_update['url'])?$item_to_update['url']:'';?>" name="url" placeholder="<?=$lang['website_optional'];?>" id="url" onkeyup='saveValue(this);'>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:block;">
    
            <!-- Locality -->

            <div class="form-group">
                <label class="control-label col-sm-2" for="locality"><?php echo $lang['service_available'];?></label>
                <div class="col-sm-offset-2 col-sm-5">
                    <div class="m-checkbox">
                        <label class="mr05"><input class="form-check-input mr05" type="checkbox" id="locality_online" name="locality[online]" value="1" onclick="dynInput_online(this);"><?php echo $lang['online'];?></label>
                        <label class="mr05"><input class="form-check-input mr05" type="checkbox" id="locality_locally" name="locality[locally]" value="1" onclick="dynInput_locally(this);"><?php echo $lang['locally'];?></label>
                    </div>
                    <div id="radiusDiv2"></div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title"><?php echo $lang['radius'];?></label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" name="radius" placeholder="<?=$lang['enter_integer'];?>" title="<?=$lang['enter_radius_kilometers'];?>" id="radiusDiv3" value="<?=isset($item_to_update['radius'])?$item_to_update['radius']:'';?>" disabled onkeyup='saveValue(this);'>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="form-group">
                <label class="control-label col-sm-2" for="location"><?php echo $lang['location'];?></label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" name="Glocation" id="search_input7" value="<?=isset($item_to_update['location'])?$item_to_update['location']:'';?>" placeholder="<?php echo $lang['enter_street'];?>" title="" onkeyup='saveValue(this);'>

                    <input type="hidden" id="loc_lat" name="lat" onchange='saveValue(this);'>
                    <input type="hidden" id="loc_long" name="lon" onchange='saveValue(this);'>

                    <div style="width:100%; display:flex; align-items:right; justify-content:right;">
                        <span id="latitude_view" onchange='saveValue(this);'></span><span id="longitude_view" onchange='saveValue(this);'></span>
                    </div>
                </div>
            </div>
            
            <!-- Radius becomes enabled if "Locally" cbox is selected. Also store values into localstorage.-->
            <script>
                var createUpdate = "<?=$_SESSION['create_update']?>";
                function dynInput_locally(cbox_locally) {
                    if (cbox_locally.checked) 
                    {
                        localStorage.setItem(createUpdate+'locality_locally', true)

                        var textInput = document.querySelector('input[id="radiusDiv3"]');
                        textInput.removeAttribute('disabled');

                    } 
                    else 
                    {
                        localStorage.setItem(createUpdate+'locality_locally', false)

                        var textInput = document.querySelector('input[id="radiusDiv3"]');
                        textInput.setAttribute('disabled', false);

                    }
                }
            // Set localstorage values also for locality_online cbox
                function dynInput_online(cbox_online) {
                    if (cbox_online.checked) 
                    {
                        localStorage.setItem(createUpdate+'locality_online', true)

                    } 
                    else 
                    {
                        localStorage.setItem(createUpdate+'locality_online', false)
                    }
                }
            // Check localstorage for "locally" checkbox value and based on it, check/uncheck the cbox and also mark radius disabled or enabled

                var checked_locally = JSON.parse(localStorage.getItem(createUpdate+'locality_locally'));
                if (checked_locally == true) {
                    document.getElementById("locality_locally").checked = true;
                    document.querySelector('input[id="radiusDiv3"]').removeAttribute('disabled');
                } 
                else 
                {
                    document.getElementById("locality_locally").checked = false;
                    document.querySelector('input[id="radiusDiv3"]').setAttribute('disabled', false);
                }
            // Check localstorage for "online" checkbox value and based on it, check/uncheck the online cbox
                var checked_online = JSON.parse(localStorage.getItem(createUpdate+'locality_online'));
                if (checked_online == true) {
                    document.getElementById("locality_online").checked = true;
                } 
                else 
                {
                    document.getElementById("locality_online").checked = false;
                }

            </script>

            <!-- Payment options -->
            <div class="form-group"> 
                <label class="control-label col-sm-2" for="payment_options"><?php echo $lang['payment_options'];?></label>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#enableClickableOptGroups').multiselect({
                            includeSelectAllOption: false,
                            enableClickableOptGroups: false,
                            enableCaseInsensitiveFiltering: true,
                            filterPlaceholder: '<?php echo $lang["search"];?>',
                            nonSelectedText: '<?php echo $lang["press_to_select"];?>',
                            buttonWidth: '100%',
                            maxHeight: '550',
                        });
                    });
                </script>
                <div class="col-sm-12">       
                    <select id="enableClickableOptGroups" style="" name="paym_opt[]" multiple="multiple">
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
                        <optgroup class="bold" label="<?php echo $lang['other_popular'];?>">
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
                    <script>
                        var createUpdate = "<?=$_SESSION['create_update']?>";
                        //case "payMeth"
                        const payMethSelect = document.querySelector('#enableClickableOptGroups');

                        // init
                        let opts = (JSON.parse( localStorage.getItem(createUpdate+'enableClickableOptGroups') || '[]' ))
                        Array.from( payMethSelect.options).forEach(opt => 
                        {
                        opt.selected = opts.includes(opt.value)
                        });

                        payMethSelect.onchange =_=>
                        {
                        opts = Array.from(payMethSelect.selectedOptions).map(opt=>opt.value)
                        localStorage.setItem(createUpdate+'enableClickableOptGroups', JSON.stringify(opts))
                        }
                    </script>
                </div>
            </div>
            <!-- Title -->
            <div class="form-group">
                <label class="control-label col-sm-2" for="title"><?php echo $lang['title'];?></label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" name="title" id="title" value="<?=isset($item_to_update['title'])?$item_to_update['title']:'';?>" placeholder="<?=$lang['title'];?>" id="title" onkeyup='saveValue(this);'>
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="control-label col-sm-2" for="description"><?php echo $lang['description'];?></label>
                <div class="col-sm-12">
                    <textarea class="form-control" style="height: 8rem;" type="textarea" name="description" placeholder="Description" id="description" onkeyup='saveValue(this);'><?=isset($item_to_update['description'])?$item_to_update['description']:'';?></textarea>
                </div>
            </div>

            <input type="hidden" name="created" value="<?=date('Y-m-d H:i')?>" id="created">
            <input type="hidden" name="edited" value="<?=date('Y-m-d H:i')?>" id="edited">
        </div>

        <div style="display:block;">
            <!-- Add items dynamically -->
            <br>
            <h5><?php echo $lang['add_items'];?></h5>
            <div>     
                <table id="dynamic_field" style="width:100%;"> 
                    <!-- <tr style="border-bottom:1px solid var(--light); border-radius: var(--border-radius);" id="row'+i+'">
                        <td></td>
                    </tr> -->
                </table>
            </div>
            <!-- Add object button -->
            <div>
                <button type="button" name="add" id="add"><?php echo $lang['add_object'];?></button>
            </div>
        <button onclick="processStartOver()">Reset</button>
        <input type="submit" value="Upload Media" name="submit" id="submit_btn">
        </div>
    </form>
</div>
<!-- SCRIPTS
████████████████████████████████████████████████████████████████████████████████
████████████████████████████████████████████████████████████████████████████████

████████████████████████████████████████████████████████████████████████████████

████████████████████████████████████████████████████████████████████████████████-->

<script>
    var createUpdate = "<?=$_SESSION['create_update']?>";
    var body = document.getElementById('wrapper');
    var except = document.getElementById('search_input7');

    body.addEventListener("click", function () {
        //alert("wrapper");
        localStorage.setItem(createUpdate+'search_input7', $( "#search_input7" ).val());
        //saveValue(0);
    }, false);
    except.addEventListener("click", function (ev) {
        ev.stopPropagation(); //this is important! If removed, you'll get both alerts
    }, false);

    except.addEventListener("change", function () {
        localStorage.setItem(createUpdate+'search_input7', $( "#search_input7" ).val());
    });

    //get the saved value function - return the value of "v" from localStorage. 
    function getSavedValue(v){
        if (!localStorage.getItem(createUpdate+v)) {
            return ""; //You can change this to your defualt value. 
        } else { 
            return localStorage.getItem(createUpdate+v);
        }
    }

    //Save the value function - save it to localStorage as (ID, VALUE)
    function saveValue(e){
        var id = e.id;  // get the sender's id so we know what to save
        var val = e.value; // get the value. 
        localStorage.setItem(createUpdate+id, val);// On each input, the localStorage's value will override
        if (id == 'industries_dropdown') {localStorage.removeItem('categories_dropdown');}
        if (id == 'industries_dropdown') {localStorage.removeItem('subcat_dropdown');}
        if (id == 'categories_dropdown') {localStorage.removeItem('subcat_dropdown');}
    }
</script>

<?php if (isset($id_to_update))
{
?>

<script type="text/javascript">
    var createUpdate = "<?=$_SESSION['create_update']?>";
    $("#industries_dropdown").value  = getSavedValue("industries_dropdown");
    $("#private_email").value        = getSavedValue("private_email");
    $("#phone").value                = getSavedValue("phone");
    $("#url").value                  = getSavedValue("url");
    $("#title").value                = getSavedValue("title");
    $("#description").value          = getSavedValue("description");
    $("#locality_locally").value     = getSavedValue("locality_locally");
    $("#locality_online").value      = getSavedValue("locality_online");
    $("#radiusDiv3").value           = getSavedValue("radiusDiv3");
    $("#search_input7").value        = getSavedValue("search_input7");
</script>

<?php
}
// Add, remove and retrieve service child items
require_once('create_u_childs.php');
?>

</div>