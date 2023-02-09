<!DOCTYPE html>
<!-- <html lang="en"> -->
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="test/dist/jstree.min.js"></script>
		<title>Test3.php</title>
		<!-- JS Tree -->
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css"> -->
		<!-- <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script> -->
		<link rel="stylesheet" href="test/dist/themes/default/style.css">
		<link rel="stylesheet" href="test/dist/themes/proton/style.css">
		<!-- <link rel="stylesheet" href="test/dist/themes/proton/style.css" /> -->
		<!-- EO JS Tree -->
		<style>
			* {
				/* font-family: Verdana, Arial; */
				/* line-height: 1.5; */
			}

			/* #test1{
				font-family: Verdana;
				font-size: 11.4px;
			}
			#test2{
				font-family: Arial;
				font-size: 13px;
			}

			#test3{
				font-family: Calibri;
				font-size: 14.1px;
			} */

			td {
			border: 1px solid forestgreen;
			width: 300px;
			/* height: 30px; */
			}
			.se_outer {
			border: 1px solid coral;
			width: 300px;
			}

			/*For jst_select_one function, these will change the look and behavior of parent folders, forcing the user to select one leaf node*/
			/* .no_checkbox > i.jstree-checkbox {
				display: none;
			} */

			/*Hides all checkboxes:*/
			#treeContainer3.jstree li.jstree-open > a.jstree-anchor > i.jstree-checkbox, 
			#treeContainer3.jstree li.jstree-closed > a.jstree-anchor > i.jstree-checkbox, 
			#treeContainer3.jstree li.jstree-open > a.jstree-anchor > i.jstree-themeicon, 
			#treeContainer3.jstree li.jstree-closed > a.jstree-anchor > i.jstree-themeicon { 
				display:none; 
				/* visibility: hidden; */
			}

			#treeContainer3.jstree li.jstree-open > a.jstree-anchor, #treeContainer3.jstree li.jstree-closed > a.jstree-anchor {
				color: black;
			}

			.jstree-wholerow, .jstree-clicked, .jstree-wholerow-clicked {
				background:transparent !important;
			}

			.jstree-wholerow-hovered {
				background:lightgray !important;
			}

			i.jstree-checkbox {
				margin-right:5px !important;
			}

			.jstree-clicked, .jstree-hovered {
				color:black !important;
			}
		</style>
		<script>
			function fetch_value(item) {
				// This function fetches and returns values of regular checkboxes (one at a time)
				// console.log('_______________fetch_value("'+item+'") executing...');
				var selections = new Array();
				// if('.'+item) {console.log('fetch_value(): .'+item+' found...');} else {console.log('fetch_value(): .'+item+' NOT found...');}
				$('.'+item+':checked').each(function(){
					selections.push($(this).val());
				});
			
				// console.log('fetch_value(): returning '+selections);
				return selections;
			}
			
			function ajax_filter_items(source_id, source_text, js_tree_value) {
				// This function fetches values of regular checkboxes using fetch_value() on each filter and using their values calls ajax_filter_items3.php (to draw [potentially checked] checkboxes)
				console.log('____________________________________________________________________');
				console.log(new Date());
				console.log("Executing: 'ajax_filter_items(source: "+source_text+");'");
				if(typeof js_tree_value == 'undefined') {
				   console.log('js_tree_value not set: '+js_tree_value);
				} else if (js_tree_value == '') {
					console.log('js_tree_value not set: ""');
				} else {
				   console.log('js_tree_value set: '+js_tree_value);
				}
				var paym_opt_csv = fetch_value('paym_opt_csv');
				var locality_csv = fetch_value('locality_csv');
				var brands = fetch_value('brands');
				var js_tree_cat = fetch_value('js_tree_cat');
				var se_function = 'ajax_filter_items';
				//   if (!current_filter_group) {
				//	   var current_filter_group = "";
				//   }
				// $('.item_results').html('<div id="whl"></div>');
				$.ajax({
					url:"/db_controller3",
					method:"POST",
					data:{ se_function:se_function, paym_opt_csv:paym_opt_csv, locality_csv:locality_csv, brands:brands, js_tree_cat:js_tree_cat, js_tree_value:js_tree_value},
					success: function(result) {
						$('.item_results').html(result);
					}
			
				});
			}
			
			function jst_draw(source_id, source_text, selected) {
				console.log("Executing 'jst_draw(source: "+source_text+");'");
				$('#treeContainer2').jstree({
				   'core' : {
						dblclick_toggle : false,
						'themes': {
							'name': 'proton',
							"icons": false,
							'responsive': true
						},
						'data' : {
							"url" : "/response3.php",
							"dataType" : "json" // needed only if you do not supply JSON headers
						}
				   },
				'plugins': ["themes", "wholerow", "checkbox"]
				});
				// $('#treeContainer2').click(function() {
					$('#treeContainer2').on("changed.jstree", function (e, data) {
						console.log("data selected: "+data.selected);
						console.log("jst changed, source id: "+source_id);
						ajax_filter_items("t", "jst filter clicked in test3.php", data.selected);
					});
				// });
				// Actions for pressing the button
				$('#button2').on('click', function () {
					// // Commands
					// $('#treeContainer2').jstree('select_node', ['2', '3']);
					// $('#treeContainer2').jstree('deselect_node', '2');
					// $('#treeContainer2').jstree().disable_node('2');
					// $('#treeContainer2').jstree().enable_node('2');
					// $('#treeContainer2').jstree().hide_node('1'); 

					// // Formats
					// $('#treeContainer2').jstree(true).select_node(['2', '3']);
					// $.jstree.reference('#treeContainer2').select_node('2');
				});


				// //Actions on selecting a node:
				// $('#treeContainer2').on("select_node.jstree", function(e, data) {
				// 	// var isParent = data.instance.is_parent(data);
				// 	// If you need to check if a node is a root node you can use:
				// 	var isParent = (data.node.children.length > 0);
				// 	// console.log(data.node);
				// 	// console.log(data.node.children);
				// 	console.log("Is parent: "+isParent);
				// 	// Disable adjacent node:
				// 	// $('#treeContainer2').jstree().disable_node(data.node);
				// //for each node, check if is_parent. If yes, please disable it.
				// });

				// // Select jst objects on load. This doesn't limit the size of jstree
				$("#treeContainer2").on('loaded.jstree', function() {
					// console.log('Executing: $("#treeContainer2").on("loaded.jstree", function()...);');
					$('#treeContainer2').jstree('select_node', selected);
				});
			}
			
		// // Creation form content
		// 	function jst_select_one() {

		// 		$('#treeContainer3').on('click', '.jstree-anchor', function (e) {
    	// 			$('#treeContainer3').jstree(true).toggle_node(e.target);
		// 		}).jstree({
		// 		   'core' : {
		// 				dblclick_toggle : false,
		// 				'themes': {
		// 					'name': 'default',
		// 					"icons": false,
		// 					'responsive': true
		// 				},
		// 				'multiple' : false,
		// 				'data' : {
		// 					"url" : "/response3.php",
		// 					"dataType" : "json" // needed only if you do not supply JSON headers
		// 				}
		// 		   },
		// 		   checkbox: { "three_state" : false },
		// 		   'plugins': ["themes", "wholerow", "checkbox"]
		// 		});
		// 		$('#treeContainer3').on("changed.jstree", function (e, data) {
		// 			console.log(data.selected);
		// 			ajax_filter_items("", data.selected);
		// 		});
				
		// 		//Iterating through all nodes and disabling the parents
		// 		$("#treeContainer3").bind('ready.jstree', function (event, data) {
		// 			$(this).jstree().open_all(); // open all nodes so they are visible in dom
		// 			$('#treeContainer3 li').each(function (index,value) {
		// 				var node = $("#treeContainer3").jstree().get_node(this.id);
		// 				// var lvl = node.parents.length;
		// 				// var idx = index;
		// 				// console.log('node index = ' + idx + ' level = ' + lvl);

		// 				var isParent = (node.children.length > 0);
		// 				if (isParent) {
		// 					$('#treeContainer3').jstree().disable_node(node);
		// 					console.log(node.id);
		// 					// document.getElementById(node.id+"_anchor").classList.add("no_checkbox");
		// 					document.getElementById(node.id+"_anchor").classList.add("color_black");
		// 				}

		// 			});
		// 			console.log("closing...");
		// 			$("#treeContainer3").jstree().close_all(); // close all again
		// 		});
		// 	}
		// // EO Creation form content
		</script>
	</head>
	<body id="tes">
		<div>Height: <span id="height"></span></div>
		<div>Width: <span id="width"></span></div>
		<!-- <div id="test1">qwertyuiopasdfghjklöäzxcvbnm,.1234567890</div>
		<div id="test2">qwertyuiopasdfghjklöäzxcvbnm,.1234567890</div>
		<div id="test3">qwertyuiopasdfghjklöäzxcvbnm,.1234567890</div> -->
		<h3>Filter results</h3>
		<!-- JS Tree -->
		<div id="treeWrapper">
			<div id="treeContainer2"></div>
		</div>
		<div id="treeWrapper3">
			<div id="treeContainer3"></div>
		</div>
		<button id="button2">Select a box</button>
		<button id="button3">Select a box</button>
		<script>
			$(document).ready(function(){ 
				ajax_filter_items('l', 'page load, test3.php', "");
				jst_draw('l', 'page load, test3.php');
			});
		// Report window size
			const heightOutput = document.querySelector('#height');
			const widthOutput = document.querySelector('#width');

			function reportWindowSize() {
			heightOutput.textContent = window.innerHeight;
			widthOutput.textContent = window.innerWidth;
			}

			window.onresize = reportWindowSize;
			reportWindowSize();
		// EO Report window size
		</script>
		<!-- EO JS Tree -->
		<div class="item_results" id="wrapper">
		</div>
	</body>
</html>