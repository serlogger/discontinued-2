<!DOCTYPE html>
<html>
<head>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="style_screen_width.css">
	<link rel="stylesheet" href="style_tabs_and_content.css">
	<script>
	//Process tabs, language and colors
		window.addEventListener('popstate', e => {
			processUrl();
		});

		function processUrl() { // Splitting URL and checking if it contains "srv" or "tab" --> acting accordingly
			console.log('executing processUrl()...');
			urlParam = window.location.toString();
			console.log("processUrl() is now using string: " + urlParam);
			const urlArray = urlParam.split("/", 5);
			console.log("processUrl() urlArray[4] has value " + urlArray[4]);
			if(urlArray[4].substring(0,3) == "srv")
			{
				open_service_view_tab(urlArray[4], "popstate");
			}
			// if(urlArray[4].substring(0,3) == "upd")
			// {
			// 	open_service_update_tab(urlArray[4], "popstate");
			// }
			if(urlArray[4].substring(0,3) == "tab")
			{
				open_static_tab(urlArray[4], "popstate");
			}
		}

		processUrl();

		function set_language(language)
		{
			if (language == "fi")
			{
				var lang_array = {
					'lng_menu': "Valikko",
					'lng_car': "auto",
					'lng_cat': "kissa",
					'lng_airplane': "lentokone",
					'lng_ship': "laiva",
					'lng_barrier': "muuri",
					'lng_srv': 'palvelu'
					}
			} else { // English
				var lang_array = {
					'lng_menu': "Menu",
					'lng_car': "car",
					'lng_cat': "cat",
					'lng_airplane': "airplane",
					'lng_ship': "ship",
					'lng_barrier': "barrier",
					'lng_srv': 'service'
					}
			}

			for (key in lang_array) { //setting the language variables from JS array to localStorage
				localStorage.setItem(key, lang_array[key]);
				//localStorage.setItem('current_language', JSON.stringify(lang_array));
				d(key);
			}

			function d(key) //Translating the page: getting language variables from localStorage to HTML
			{
				var g = document.getElementsByClassName(key);
				if (g.length > 0)
				{
				var j;
				for (j=0; j<g.length; j++)
				{
					g[j].innerHTML = localStorage.getItem(key);
				}
				}
			}
			
			$.ajax({ // Setting PHP $_SESSION['language']
				url: "/test/db.php",
				method:"POST",
				data: {
			language:language
				}
			});
		}

		function toggleDisplayBlock(id) // Toggle between display block and none on any element id
		{
			if (document.getElementById(id).style.display == "none")
			{
				document.getElementById(id).style.display = "block";
			} else {
				document.getElementById(id).style.display = "none";
			}
		}

		function create(id)
		{
			document.getElementById(id).innerHTML = "<div class='lng_barrier box'></div>";
			document.getElementsByClassName('lng_barrier')[0].innerHTML = localStorage.getItem('lng_barrier');
		}

		function del(id)
		{
			if (document.getElementsByClassName(id).length > 0)
			{
				document.getElementsByClassName(id)[0].remove();
			}
		}

		// function openTabAppend(id) {
		// 	if (localStorage.getItem('openTab'))
		// 	{
		// 		localStorage.setItem("openTab", id + ',' + localStorage.getItem('openTab'));
		// 	} else {
		// 		localStorage.setItem("openTab", id);
		// 	}
		// }

		function open_static_tab(id, source)
		{
			if(document.getElementById(id+"_content"))
			{
				openGeneral(id, source, "static");
				document.getElementById(id+"_content").style.display = "block";
				document.getElementById(id).style.border = "7px solid lightblue";
				document.getElementById(id).style.borderBottom = "none";
				scrollToPos(id);
			} else {
				console.log('ID ' + id + ' not found');
			}
		}

		function open_service_view_tab(id, source) {
			openGeneral(id, source, "service");
			var name = "'name'";
			if(!document.getElementById("tab_"+id))
			{
				document.getElementById('tabs').innerHTML += '<div id="tab_'+id+'" class="tab" name="'+id+'" onclick="open_service_view_tab(this.attributes['+name+'].value)">'+id+'</div><button id="button_'+id+'" name="'+id+'" style="cursor:pointer; display:inline; padding:10px; border: 1px solid black;" onclick="close_service(this.attributes['+name+'].value)">X</button>';
			}
			if(!document.getElementById(id+'_content'))
			{
				document.getElementById('tabs_content').innerHTML += '<div id="'+id+'_content" class="tab_content" style="display:block;">'+id+' content</div>';
			} else {
				document.getElementById(id+'_content').style.display = "block";
			}
			scrollToPos(id);
			// setScrollPos(id);
			document.getElementById("tab_"+id).style.border = "7px solid lightblue";
			document.getElementById("tab_"+id).style.borderBottom = "none";
			
		}

		function openGeneral(id, source, type) {
			console.log(' ');
			console.log('Opening '+type+' tab: '+id);
			if (source !== "popstate") 
			{
				history.pushState(null, null, id);
			} else {
				history.replaceState(null, null, id);
			}
			if (localStorage.getItem("current_tab") && document.getElementsByClassName(localStorage.getItem("current_tab")).length !== 0 && document.getElementById(localStorage.getItem("current_tab"))) {
				var x = document.getElementsByClassName(localStorage.getItem("current_tab"))[0];
				var y = document.getElementById(localStorage.getItem("current_tab"));
				x.style.display = "none";
				y.style.border = "3px solid lightblue";
			} else {
				tab_content = document.getElementsByClassName('tab_content');
				var i;
				for (i = 0; i<tab_content.length; i++)
				{
					if(document.getElementsByClassName("tab_content"))
					{
						console.log('Tabcontent ' + i + ' found, making sure it is closed before showing the current one...')
						document.getElementsByClassName("tab_content")[i].style.display = "none";
						//document.getElementsByClassName(localStorage.getItem("current_tab")).style.display = "none";
						document.getElementsByClassName('tab')[i].style.border = "3px solid lightblue";
					}
				}
			}
			localStorage.setItem('current_tab', id);
			// openTabAppend(id);
		}

		function close_service(id) {
			// //Remove closed tab from opened tabs history by replacing id with ''
			// localStorage.setItem('openTab', localStorage.getItem('openTab').replaceAll(id+',',''));
			// //Remove duplicates so that user doesn't have to keep clicking the back button
			// let tabsString = localStorage.getItem('openTab');
			// const tabArray = tabsString.split(',');
			// duplicates = 1;
			// k = 0;
			// max_loops = 50;
			// while(duplicates > 0 && k < max_loops)
			// {
			// 	duplicates = 0;
			// 	console.log('Searching for duplicates...');
			// 	for(i=0; i<tabArray.length; i++)
			// 	{
			// 		j = i+1;
			// 		if(tabArray[i] == tabArray[j])
			// 		{
			// 			console.log('Duplicates found. '+tabArray[i]+' = '+tabArray[j]+' Table length before: '+tabArray.length);
			// 			tabArray.splice(i, 1);
			// 			console.log('Table length after: '+tabArray.length);
			// 			duplicates = 1;
			// 		}
			// 	}
			// 	k++;
			// }

			// localStorage.setItem('openTab', tabArray);

			document.getElementById('button_'+id).remove();
			document.getElementById("tab_"+id).remove();
			document.getElementById(id+"_content").remove();
		}

		function dark_mode() {
			var r = document.querySelector(':root');
			r.style.setProperty('--dark', '#000');
		}

		function light_mode_blue() {
			var r = document.querySelector(':root');
			r.style.setProperty('--dark', '#669');
		}

		function light_mode_rosa() {
			var r = document.querySelector(':root');
			r.style.setProperty('--dark', '#c07');
		}
	//EO Process tabs, language and colors
	</script>
</head>
<body>

<div class="grid_container_page_nav_maximized grid_container" id="grid_container_page">

	<div style="font-size:36px;">Height: <span id="height"></span></div>
	<div style="font-size:36px;"><b>Width: <span id="width"></span></b></div>
	<button id="en" onclick="set_language(this.id)">En</button>
	<button id="fi" onclick="set_language(this.id)">Fi</button>
	<button id="dark" onclick="dark_mode();">Dark</button>
	<button id="rosa" onclick="light_mode_rosa();">Rosa</button>
	<button id="blue" onclick="light_mode_blue();">Blue</button>
	<div class="grid_container_nav_maximized grid_container" id="grid_container_nav">
		<button id="btnMenu" class="lng_menu" onclick="navButtonclick();">Toggle menu</button>
		<div id="tabs">
			<div id="tab_0" class="tab" onclick="open_static_tab(this.id), 'html'">Tab 0</div>
			<div id="tab_1" class="tab" onclick="open_static_tab(this.id), 'html'">Tab 1</div>
			<div id="tab_2" class="tab" onclick="open_static_tab(this.id), 'html'">Tab 2</div>
			<div id="tab_3" class="tab" onclick="open_static_tab(this.id), 'html'">Tab 3</div>
		</div>
	</div>
	<div class="grid_container_content_f_max grid_container" id="grid_container_content">
		<div class="grid_container grid_container_feed" id="grid_container_feed">
			<div id="tabs_content">	
				<div id="tab_0_content" class="tab_content tab_0">Tab 0 content:
		
					<!-- <div id="tab_0_content" class="tab_content">Tab 0 content:
						<div id="srv_0" class="box2" name="srv_0" onclick="open_service_view_tab(this.attributes['name'].value, 'html')">0<div class="lng_srv"></div></div>
						<div id="srv_1" class="box2" name="srv_1" onclick="open_service_view_tab(this.attributes['name'].value, 'html')">1<div class="lng_srv"></div></div>
						<div id="srv_2" class="box2" name="srv_2" onclick="open_service_view_tab(this.attributes['name'].value, 'html')">2<div class="lng_srv"></div></div>
						<div id="srv_3" class="box2" name="srv_3" onclick="open_service_view_tab(this.attributes['name'].value, 'html')">3<div class="lng_srv"></div></div>
						<div id="srv_4" class="box2" name="srv_4" onclick="open_service_view_tab(this.attributes['name'].value, 'html')">4<div class="lng_srv"></div></div>
						<div id="srv_5" class="box2" name="srv_5" onclick="open_service_view_tab(this.attributes['name'].value, 'html')">5<div class="lng_srv"></div></div>
					</div> -->
					<!-- <div id="tab_1_content" class="tab_content">Lorem ipsum </div>
					<div id="tab_2_content" class="tab_content">dolor sit amet, consectetur adipiscing elit,	id est laborum.</div>
					<div id="tab_3_content" class="tab_content">sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim</div> -->
					<?php 
					$name = "'name'";
					$html = "'html'";
					for ($i=1; $i<25; $i++)
					{
					echo '
								<div class="hdiv">
									<div class="grid_container_card_large grid_container_card grid_container">
										<div class="grid_container header">
											<div class="title">Title</div>
											<div class="user">User</div>
										</div>
										<div class="pic">Pic '.$i.'
											<div id="srv_'.$i.'" class="box2" name="srv_'.$i.'" onclick="open_service_view_tab(this.attributes['.$name.'].value, '.$html.')">0
												<div class="lng_srv">
												</div>
											</div>
										</div>
										<div class="desc">Description</div>
										<div class="cat">Categorization</div>
										<div class="details1">Details1</div>
										<div class="details2">Details2</div>
										<div class="grid_container thumbs_read">
											<div class="thumbnails">Thumbnails</div>
											<div class="call_to_action">Read</div>
										</div>
									</div>
								</div>
					';
					}
					?>		
				</div>
				<div id="tab_1_content" class="tab_content tab_1">Tab 1 content:
					<?php 

					for ($i=1; $i<125; $i++)
					{
					echo '<br>jee';
					}
					?>
					
				</div>
			</div>
		</div>
		<div class="grid_container_filters_bar_max grid_container" style="" id="grid_container_filters_bar">
			Filters bar
			<button id="btnFilters" onclick="filtersButtonclick();">Toggle filters</button>
		</div>
	</div>


</div>
	<script>

		// Layout
		
		var timeout = 150; //ms
		var navVisibilityWindowLimit = 1300; //px
		var filtersVisibilityWindowLimit = 1000; //px
		var largeCardLimit = 1300; //px
		var mediumLargeCardLimit = 1000; //px
		var mediumSmallCardLimit = 650; //px
		var smallCardLimit = 500; //px
		var nav = document.getElementById("grid_container_nav");
		var page = document.getElementById("grid_container_page");
		var filters = document.getElementById("grid_container_filters_bar");
		var content = document.getElementById("grid_container_content");
		var cards = document.getElementsByClassName("grid_container_card");
		var details = document.getElementsByClassName("details_wrapper");
		const heightOutput = document.querySelector('#height');
		const widthOutput = document.querySelector('#width');

		function reportWindowSize() {
		heightOutput.textContent = window.innerHeight;
		widthOutput.textContent = window.innerWidth;
		}

		window.onresize = reportWindowSize;
		reportWindowSize();

		function navButtonclick() { if (nav.className !== "grid_container_nav_maximized grid_container") {maximizeMenu();} else {minimizeMenu();}}

		function filtersButtonclick() {	if (filters.className !== "grid_container_filters_bar_max grid_container") { maximizeFilters();	} else { minimizeFilters();	}}

		$(window).resize(function() { decidePageColumns(); });

		decidePageColumns();

		$(":button").click(function() {	setTimeout(() => { decideCardGrid(); }, timeout); });


		function decidePageColumns() {
			if ($(window).width() > navVisibilityWindowLimit)
				{
					maximizeMenu();
				} else {	
					minimizeMenu();
				}

			if ($(window).width() > 1000)
				{
					maximizeFilters();
				} else {	
					minimizeFilters();
				}

			setTimeout(() => {  decideCardGrid(); }, timeout);
		}


		function decideCardGrid() {

			if ($("#grid_container_feed").width() < largeCardLimit) 
			{
				cardClassName("grid_container_card_large grid_container_card grid_container");
			}

			if ($("#grid_container_feed").width() < mediumLargeCardLimit) 
			{
				cardClassName("grid_container_card_medium_large grid_container_card grid_container");
			}
			
			if ($("#grid_container_feed").width() < mediumSmallCardLimit) 
			{
				cardClassName("grid_container_card_medium_small grid_container_card grid_container");
			}

			if ($("#grid_container_feed").width() < smallCardLimit) 
			{
				cardClassName('grid_container_card_small grid_container_card grid_container');
			}
			
		}

		function cardClassName(x) {
			for(var i=0; i < cards.length; i++)
			{
				cards[i].className = x;
			}
		}

		function navMarginMin() {
			page.style.marginLeft = "0";
		}

		function navMarginMax() {
			page.style.marginLeft = "300px";
		}

		function minimizeMenu() {
			nav.className = "grid_container_nav_minimized grid_container";
			page.className = "grid_container_page_nav_minimized grid_container";

		}

		function maximizeMenu() {
			nav.className = "grid_container_nav_maximized grid_container";
			page.className = "grid_container_page_nav_maximized grid_container";
		}

		function minimizeFilters() {
			filters.className = "grid_container_filters_bar_min grid_container";
			content.className = "grid_container_content_f_min grid_container";
		}

		function maximizeFilters() {
			filters.className = "grid_container_filters_bar_max grid_container";
			content.className = "grid_container_content_f_max grid_container";
		}

		function followSystemTheme() { //light & dark mode auto switch
			if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
				console.log('dark mode');
			} else {
				console.log('light mode');
			}

			window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
				const newColorScheme = event.matches ? "dark" : "light";
				console.log(newColorScheme);
			});
		}

		followSystemTheme();

		// EO Layout

		//Set lang
		<?php
			if (!isset($_SESSION['language']))
			{
				$_SESSION['language'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			}
		?>
		var language = "<?=$_SESSION['language']?>";
		set_language(language);
		//EO Set lang

		//Set and retrieve scroll position
		function setScrollPos(id) { // id = tab id
			$(window).on("scroll", function() {
				console.log('Setting scroll value to localStorage: ' + $(window).scrollTop());
				if (!id) {
					var id = currentTab();
				}
				// console.log('Setting scroll position for tab ' + id + ' using scroll value ' + $(window).scrollTop());
				localStorage.setItem("scrollPos_"+id, $(window).scrollTop());
			});
		}

		function scrollToPos(id) { //get value from localStorage, if any (and scroll to it)
			console.log("Executing scrollToPos()");
			// $(window).on("scroll", function() {
				// if (!id) {
				// 	var id = currentTab();
				// 	console.log("Tab id: " + id);
				// }
				var scrollPositionValue;
				if (localStorage.getItem("scrollPos_"+id)) {
					scrollPositionValue = localStorage.getItem("scrollPos_"+id);
					console.log("scrollPositionValue: " + scrollPositionValue);
				}
				if (scrollPositionValue) { // If it has value...
					$(window).scrollTop(scrollPositionValue);
					console.log("Scrolling to position: " + scrollPositionValue);
				} else {
					console.log('No value to scroll to')
				}
			// });
		}

		function currentTab() {
			return localStorage.getItem("current_tab");
		}


		setScrollPos();

		//EO Set and retrieve scroll position
	</script>
</body>
</html>