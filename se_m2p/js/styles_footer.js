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
		var btnFilters = document.getElementById("btnFilters");
		var btnFilters2 = document.getElementById("btnFilters2");
		var tab_0_content = document.getElementById("tab_0_content");
		var feed = document.getElementById("tab_2_content");
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

		function filtersButtonclick() {	if (!filters.classList.contains("grid_container_filters_bar_max")) { maximizeFilters();	} else { minimizeFilters();	}}

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

			if ($("#tab_2_content").width() < largeCardLimit) 
			{
				cardClassName("grid_container_card_large grid_container_card grid_container");
			}

			if ($("#tab_2_content").width() < mediumLargeCardLimit) 
			{
				cardClassName("grid_container_card_medium_large grid_container_card grid_container");
			}
			
			if ($("#tab_2_content").width() < mediumSmallCardLimit) 
			{
				cardClassName("grid_container_card_medium_small grid_container_card grid_container");
			}

			if ($("#tab_2_content").width() < smallCardLimit) 
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
			filters.classList.remove("grid_container_filters_bar_max");
			filters.classList.add("grid_container_filters_bar_min");
			btnFilters.style.display ="none";
			btnFilters2.style.display = "block";
			// btnFilters.classList.remove("lng_minimize_filters_bar");
			// btnFilters.classList.add("lng_maximize_filters_bar");
			// se_translate_id_case_2('lng_maximize_filters_bar', 'btnFilters');
			feed.classList.remove("grid_container_mr_300");
			feed.classList.add("grid_container_mr_0");
		}

		function maximizeFilters() {
			filters.classList.remove("grid_container_filters_bar_min");
			filters.classList.add("grid_container_filters_bar_max");
			btnFilters2.style.display = "none";
			btnFilters.style.display = "block";
			// btnFilters.classList.remove("lng_maximize_filters_bar");
			// btnFilters.classList.add("lng_minimize_filters_bar");
			// se_translate_id_case_2('lng_minimize_filters_bar', 'btnFilters');
			feed.classList.remove("grid_container_mr_0");
			feed.classList.add("grid_container_mr_300");
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