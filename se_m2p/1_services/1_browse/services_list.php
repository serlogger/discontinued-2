<?php require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'se_load.php'); ?>		
		<div id="tab_2_content" class="tab_2 grid_container_feed grid_container" style="display:none;">
			<?php
				$connect = new PDO("mysql:host=localhost;dbname=$se_db", $se_db_pass, "");

				require_once $_SESSION['rt'] .$ds. $inc .$ds. 'messages.php';

				echo "<pre>Session " . var_export($_SESSION, true) . "</pre>";
				// echo "<pre>Server " . var_export($_SERVER, true) . "</pre>";
				// echo "<pre>Post " . var_export($_POST, true) . "</pre>";
				// echo "<pre>Get " . var_export($_GET, true) . "</pre>";

			?>
			<div class="filter_data">
				<!--div style="margin-left:400px;">< ?=$_SERVER['DOCUMENT_ROOT']." ".__DIR__?></div-->
			</div>

			<!-- filters -->
			<div class="grid_container_filters_bar_max grid_container" style="" id="grid_container_filters_bar"> <!-- Filters size controller -->
				<!-- lng_minimize_filters_bar -->
				<button id="btnFilters" class="" onclick="filtersButtonclick();"><i class="fa fa-filter"></i> <i class="fas fa-angle-double-right"></i></button>
				<button id="btnFilters2" class="" onclick="filtersButtonclick();" style="display:none;"><i class="fas fa-angle-double-left"></i> <i class="fa fa-filter"></i></button>
				<div class="sidebar_container">
					<!-- Search & sort (prev. class:  filter-group)-->
					<div class="form-group">
						<div>
							<!--Search-->
							<div style="display:block;">
								<input class="form-control" type="text" id="search" placeholder="<?=$lang['search']?>" autofocus/>
								<!-- Suggestions will be displayed in below div. -->
								<div id="display_search_results" style="width:400px; margin-left:-200px;"></div>
								<!--EO Search -->

								<!--Sort-->
								<select id="sort" class="form-control common_selector selectpicker sdc_dropdown">
									<option value=""><?=$lang['sort_by']?>...</option>
									<option value="distance ASC"><?=$lang['distance']?>: nearest first</option>
									<option value="distance DESC"><?=$lang['distance']?>: furthest first</option>
									<option value="services.created_u DESC">Created: newest first</option>
									<option value="services.created_u ASC">Created: oldest first</option>
									<option value="services.edited_u DESC">Edited: newest first</option>
									<option value="services.edited_u ASC">Edited: oldest first</option>
									<option value="services.max_cp DESC">Price, biggest first</option>
									<option value="services.min_cp ASC">Price, smallest first</option>
									<option value="">Categorization</option>
								</select>
								<!--EO sort -->
							</div>
						</div>
						<!-- EO Search & sort -->

						<!-- Categorization -->
						<div>
							<div id="categorization"></div>
							<!-- Industry -->
							<div class="form-group">
								<i class="bi bi-tag"></i><?=$lang['categorization']?>
								<select style="height:var(--field-height-md);" class="form-control ind_id common_selector sdc_dropdown" id="industries_dropdown" onchange="//saveValue(this);" name="ind_id">
									<option value=''><?=$lang['choose_industry'];?></option>
									<?php
									$result = mysqli_query($conn, "SELECT DISTINCT services.ind_id, cat1_industries.ind_id, cat1_industries.industry_$current_lang FROM `services`, `cat1_industries` WHERE (services.ind_id = cat1_industries.ind_id) ORDER BY cat1_industries.industry_$current_lang ASC");
									while ($row = mysqli_fetch_array($result)) {
										?>
										<option value="<?php echo $row['ind_id']; ?>"><?php echo $row["industry_$current_lang"]; ?></option>
										<?php
									}
									?>
								</select>
							</div>

							<!-- Cat -->
							<div class="form-group" style="display:inline;">
								<select style="height:var(--field-height-md);" class="form-control cat_id common_selector abled sdc_dropdown" id="categories_dropdown" onchange="//saveValue(this);" name="cat_id">
									<option value=""><?=$lang['choose_category']?></option>
								</select>
							</div>

							<!-- Subcat -->
							<div class="form-group" style="">
								<select style="height:var(--field-height-md);" class="form-control sc_id common_selector abled sdc_dropdown" id="subcat_dropdown" onchange="//saveValue(this);" name="sc_id">
									<option value=""><?=$lang['choose_sub_category']?></option>
								</select>
							</div>
						</div>
						<!-- EO cat -->

						

						<div>
							<!-- Locality -->
							<div class="" style="display:block; margin-bottom:1em;">
								<i class="bi bi-geo-alt"></i><?=$lang['service_available']?><div class="m-checkbox" style="margin-top:0.5em; margin-bottom:1em;">
									<label class=""><input class="form-check-input" type="checkbox" id="locality_online" style="margin-right:3px;"><?=$lang['online']?></label>
									<label class=""><input class="form-check-input" type="checkbox" id="locality_locally" style="margin-right:3px; margin-left:7px;"><?=$lang['locally']?></label>
								</div>
								<div id="radiusDiv2"></div>
							</div>
							<!-- EO Locality -->

							<!-- Location -->

							
								<!-- <div style="display:flex; align-items:right; justify-content:right;"> -->
									<div id="button1_view" style="display:inline; float:left; max-width:60%;">
										<input type='text' id='myInput2' value='' hidden>
										<input type='text' id='myInput3' value='' hidden>
										<!-- <div class="tooltip"> -->
											<i class="bi bi-globe2"></i><?=$lang['location']?>
									</div>
									<div style="float:right; display:inline; max-width:40%; position:relative; right:3px; bottom:-35px;">
											<button class="btn btn-primary" id="button1" onclick='se_locate_me();' style="color:var(--whitest); background:var(--neutral); border:1px solid var(--dark); height:2em; padding-top:0; padding-bottom:3px; padding-left:10px; padding-right:10px;">
												<span id='myTooltip' style="color:white; font-size:12px;">Locate me</span>
											</button>
									</div>
									<span id="latitude_view" onchange='//saveValue(this);' style="color:green;"></span>
									<span id="longitude_view" onchange='//saveValue(this);' style="color:green;"></span>
								<!-- </div> -->
							<div class="col-sm-12">
								<input class="form-control" style="height:var(--field-height-md);" type="text" name="Glocation" id="search_input7" value="<?=isset($item_to_update['location'])?$item_to_update['location']:'';?>" placeholder="<?=$lang['enter_street']?>" title="" onkeyup='//saveValue(this);'>

								<input type="hidden" id="loc_lat" value="61.00" name="lon" onchange='//saveValue(this);'>
								<input type="hidden" id="loc_long" value="25.00" name="lat" onchange='//saveValue(this);'>
							</div>

							<script>
								function se_locate_me() {
									//Copy GPS
									// var copyText2 = document.getElementById("myInput2");
									// var copyText3 = document.getElementById("myInput3");
									// copyText2.select();
									// copyText2.setSelectionRange(0, 99999);
									// navigator.clipboard.writeText(copyText2.value);
									
									// var tooltip = document.getElementById("myTooltip");
									// tooltip.innerHTML = "Copied " + copyText3.value;
									// setTimeout(() => { tooltip.innerHTML = "Copy GPS"; }, 2000);
									
									//Use my location:
								}


							</script>
							<!-- EO Location -->

							<!-- Radius -->
							<div class="form-group">
								<label class="control-label" for="title"><?=$lang['show_within_radius']?></label>
								<div class="col-sm-12">
									<input class="form-control field_range" style="height:var(--field-height-md);" type="text" name="radius" placeholder="<?=$lang['enter_integer'];?>" title="<?=$lang['enter_radius_kilometers']?>" id="radiusDiv3">
								</div>
							</div>

							<!-- EO Radius -->
						</div>

						<!-- price -->
						<div>
							<?=$lang['price']?> (<?=$lang[$current_currency]?>)
							<div>
								<input class="form-control field_range" style="" type="text" id="min_price" placeholder="0"/> - 
								<input class="form-control field_range" style="" type="text" id="max_price" placeholder="999 999 ..."/>
							</div>
						</div>
						<!-- EO price -->

						
						<div>
							<!-- Created -->
							<?=$lang['created_between']?>
							<div>
								<input class="form-control common_selector field_range date_range" style="" type="date" id="created_from"> - 
								<input class="form-control common_selector field_range date_range" style="" type="date" id="created_to">
							</div>
							<!-- Edited -->
							<?=$lang['edited_between']?>
							<div>
								<input class="form-control common_selector field_range date_range" style="" type="date" id="edited_from"> - 
								<input class="form-control common_selector field_range date_range" style="" type="date" id="edited_to">
							</div>
						</div>
						<!-- EO Created and edited -->
					</div>
				</div> <!-- EO Filters container -->
			</div> <!-- EO Filters size controller -->
		</div>
			<script>

				// Create a new 'change' event
				// var event = new Event('change');
				// Dispatch it.
				//element.dispatchEvent(event);

				//Categorization: Make multi-level dropdowns work
				$(document).ready(function() {
					$('#industries_dropdown').on('change', function() {
						const usp = new URLSearchParams(window.location.search);
						let ind_id = this.value;
						if(ind_id > 0) {
							document.getElementById("categories_dropdown").disabled = false;
							document.getElementById("subcat_dropdown").disabled = true;
						}
						if(ind_id == "") {
							document.getElementById("categories_dropdown").disabled = true;
							document.getElementById("subcat_dropdown").disabled = true;
						}
						
						usp.set('industry', this.value); // USP = URL Search Parameter
						usp.delete('category');
						usp.delete('subcat');
						// if(usp.get('category'))    {usp.delete('category');}
						// if(usp.get('subcategory')) {usp.delete('subcategory');}
						history.pushState({},"","?"+usp);
						console.log('usp at ind: '+usp);
						$.ajax({
							url: "get_cats_in_use.php",
							type: "POST",
							data: {
								ind_id: ind_id
							},
							cache: false,
							success: function(result) {
								$("#categories_dropdown").html(result);
							}
						});
					});
						
					$('#categories_dropdown').on('change', function() {
						var cat_id = this.value;
						if(cat_id > 0) {document.getElementById("subcat_dropdown").disabled = false;}
						if(cat_id == "") {document.getElementById("subcat_dropdown").disabled = true;}
						const usp = new URLSearchParams(window.location.search);
						usp.set('category', this.value);
						usp.delete('subcat');
						history.pushState({},"","?"+usp);
						console.log('usp at cat: '+usp);
						$.ajax({
							url: "get_sub_cats_in_use.php",
							type: "POST",
							data: {
								cat_id: cat_id
							},
							cache: false,
							success: function(result) {
								$("#subcat_dropdown").html(result);
							}
						});
					});

					$('#subcat_dropdown').on('change', function() {
						var sc_id = this.value;
						const usp = new URLSearchParams(window.location.search);
						usp.set('subcat', this.value);
						history.pushState({},"","?"+usp);
						console.log('usp at sc: '+usp);
					});

					// $('#radiusDiv3').on('keyup', function () {
					//     filter_data();
					// });

					// Handling URL serach params (industry, etc.)
					const usp = new URLSearchParams(window.location.search);

					if(usp.get('industry'))
					{
						$('#industries_dropdown').val(usp.get('industry'));
						// In order for multi-level dropdown to work, we must manually trigger change in the upper element:
						//use_industry_from_URL();
						ind_id = usp.get('industry');
						$.ajax({
							url: "get_cats_in_use.php",
							type: "POST",
							data: {
								ind_id: ind_id
							},
							cache: false,
							success: function(result) {
								$("#categories_dropdown").html(result);
								$("#subcat_dropdown").html('<option value=""><?=$lang['choose_sub_category']?></option>');
								const usp = new URLSearchParams(window.location.search);
								if(usp.get('category'))
								{
									$('#categories_dropdown').val(usp.get('category'));
									//usp.set('category', $('#categories_dropdown').value);
								}
							}
						});
					}

				// Eventlisteners
				// function func0() 
				//         {
				//             alert("Function0 is called");
				//         }
				// function func1() 
				//         {
				//             alert("Function1 is called");
				//         }
				//         if(document.getElementById("thumbnail_1"))
				//         {
				//             document.getElementById("thumbnail_1").addEventListener("click", func0, true);
				//         }
						//document.getElementById("industries_dropdown").addEventListener("click", func1, true);
				// EO Eventlisteners

				// //     if (document.getElementById("locality_locally").checked == true) 
				// // {
				// // console.log('locality checked');
				// // }


				var start = 0;
				var limit = 10;
				var reachedMax = false;

				$(window).scroll(function() 
				{
					if($(window).scrollTop() > 0) {
						if($(window).scrollTop() == $(document).height() - $(window).height()) {
							console.log($(window).scrollTop());
							filter_data();
						}
					}
				});



				function filter_data()
				{
					if(reachedMax) {
						return;
					}
					if (document.getElementById('min_price').value) {
						var min_price = document.getElementById('min_price').value;
					} else {
						var min_price = 0;
					}
					
					if (document.getElementById('max_price').value) {
						var max_price = document.getElementById('max_price').value;
					} else {
						var max_price = 0;
					}

					var ind_id;
					var cat_id;
					var sc_id;
					
					var lat = document.getElementById('loc_lat').value;
					var lon = document.getElementById('loc_long').value;
					var radius;

					var ob = document.getElementById('sort').value;
					if(!document.getElementById('radiusDiv3').value) {
						radius = 21000;
					} else {
						radius = document.getElementById('radiusDiv3').value;
					}
					if(usp.get('industry')) {
						ind_id = [usp.get('industry')];
					} else {
						ind_id = [];
						document.getElementById("categories_dropdown").disabled = true;
						document.getElementById("subcat_dropdown").disabled = true;
					}

					if(usp.get('industry') && usp.get('category')) {
						cat_id = [usp.get('category')];
					} else {
						// cat_id = [document.getElementById('categories_dropdown').value];
						cat_id = [];
						document.getElementById("subcat_dropdown").disabled = true;
					}

					if(usp.get('industry') && usp.get('category') && usp.get('subcat')) {
						sc_id = [usp.get('subcat')];
					} else {
						// sc_id = [document.getElementById('subcat_dropdown').value];
						sc_id = [];
					}

					var created_from = "1970-01-01 00:00:00";
					if (document.getElementById('created_from')) {
						if(document.getElementById('created_from').value !== "")
						{
							created_from = document.getElementById('created_from').value;
						}
					}

					var created_to = "9999-12-31 23:59:59";
					if (document.getElementById('created_to')) {
						if(document.getElementById('created_to').value !== "") {
							created_to = document.getElementById('created_to').value;
						}
					}

					var edited_from = "1970-01-01 00:00:00";
					if (document.getElementById('edited_from')) {
						if(document.getElementById('edited_from').value !== "") {
							edited_from = document.getElementById('edited_from').value;
						}
					}

					var edited_to = "9999-12-31 23:59:59";
					if (document.getElementById('edited_to')) {
						if(document.getElementById('edited_to').value !== "") {
							edited_to = document.getElementById('edited_to').value;
						}
					}
					
					console.log("Filter data: ind_id: " + ind_id);
					console.log("Filter data: cat_id: " + cat_id);
					console.log("Filter data: sc_id: " + sc_id);

					var username = usp.get('username');
					$.ajax({
						url:"/fetch_data.php",
						method:"POST",
						data:{ind_id:ind_id, cat_id:cat_id, sc_id:sc_id, filter_data:1, start:start, limit:limit, username:username, lat:lat, lon:lon, radius:radius, ob:ob, min_price:min_price, max_price:max_price, created_from:created_from, created_to:created_to, edited_from:edited_from, edited_to:edited_to},
						cache: false,
						success:function(data){
							if (data == "reachedMax") {
									reachedMax = true;
								} else {
									start += limit;
									$('.filter_data').append(data);
								}
							// set_language(< ?=$_SESSION['language']?>);
						}
					});
				}

				function get_filter(id_name) {
					var filter = [];
					$('#'+id_name).each(function(){
						if($(this).val() !== "") {
							filter.push($(this).val());
						}
					});
					return filter;
				}

				$('#radiusDiv3').change(function(){
					$('.filter_data').html('');
					start = 0;
					reachedMax = false;
					console.log('Common selector keyup triggered, attempting to filter data...');
					filter_data();
				});


				// MAPS JS
				var autocomplete;
				autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
					types: ['geocode']
				});
				

				google.maps.event.addListener(autocomplete, 'place_changed', function () {
					var near_place = autocomplete.getPlace();
					if(document.getElementById('search_input7').value !== "") {
						$('#sort').val('distance ASC');
						document.getElementById('loc_lat').value = near_place.geometry.location.lat();
						document.getElementById('loc_long').value = near_place.geometry.location.lng();
						
						var latit = near_place.geometry.location.lat();
						var m = latit.toFixed(6);
						
						var longit = near_place.geometry.location.lng();
						var n = longit.toFixed(6);
					
						document.getElementById('myInput2').value = m+", "+n;
						document.getElementById('myInput3').value = latit.toFixed(1)+"…, "+longit.toFixed(1)+"…";

						document.getElementById('button1').title = m + ', ' + n;
						//document.getElementById('button1').disabled = false;
						document.getElementById('loc_lat').value = m;
						//document.getElementById('longitude_view').innerHTML = n;
						document.getElementById('loc_long').value = n;

						//document.getElementById('radiusDiv3').value = "";
						$('.filter_data').html('');
						start = 0;
						reachedMax = false;
						console.log('Search input changed, attempting to filter data...');
						filter_data();
					}
				});

				// EO MAPS JS


				$('.common_selector').change(function(){
					if(this.id == "industries_dropdown") {
						console.log("Common selector change: ind: " + usp.get('industry'));
						usp.set('industry', this.value);
						$('#categories_dropdown').val("");
						usp.delete('category');
						$('#subcat_dropdown').val("");
						usp.delete('subcat');
					}
					if(this.id == "categories_dropdown") {
						usp.set('category', this.value);
						$('#subcat_dropdown').val("");
					}
					if(this.id == "subcat_dropdown") {
						usp.set('subcat', this.value);
					}
					$('.filter_data').html('');
					start = 0;
					reachedMax = false;
					console.log('Common selector change triggered, attempting to filter data...');
					filter_data();
				});

				$('#min_price, #max_price').change(function(){
					// if($("#max_price").value !== "" && $('$min_price').value == "")
					// {
					//     $('#min_price').val("0");
					// }
					// if(document.getElementById('min_price').value > document.getElementById('max_price').value)
					// {
					//     console.log('min > max');
					//     var switch_price1 = document.getElementById('min_price').value;
					//     var switch_price2 = document.getElementById('max_price').value;
					//     $('#min_price').val(switch_price2);
					//     $('#max_price').val(switch_price1);
					// }
					if(this.id == "min_price" && document.getElementById('max_price').value == "") {
						console.log('waiting for max price');
					} else {
						$('.filter_data').html('');
						start = 0;
						reachedMax = false;
						filter_data();
					}
				});


				filter_data();

				// Fetching the right subcats
				if(usp.get('category')) {
					if(usp.get('category') !== "") {
						cat_id = usp.get('category');
						console.log('USP has category, fetching the right sub-categories');
							$.ajax({
								url: "get_sub_cats_in_use.php",
								type: "POST",
								data: {
									cat_id: cat_id
								},
								cache: false,
								success: function(result) {
									$("#subcat_dropdown").html(result);
									if(usp.get('subcat')) {
											console.log('Attempting to get sc value from usp to dropdown')
											$('#subcat_dropdown').val(usp.get('subcat'));
										}
										}
							});
					}
				}

			});


			</script>