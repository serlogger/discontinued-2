	<div class="grid_container_nav_maximized grid_container" id="grid_container_nav">
		<div class="sidebar_container">
			<!-- <button id="se_test_button">Butt</button> -->
			<button id="btnMenu" class="lng_menu" onclick="navButtonclick();">Toggle menu</button>
			<button id="en" onclick="set_language(this.id)">En</button>
			<button id="fi" onclick="set_language(this.id)">Fi</button>
			<button id="dark" onclick="dark_mode();">Dark</button>
			<button id="rosa" onclick="light_mode_rosa();">Rosa</button>
			<button id="blue" onclick="light_mode_blue();">Blue</button>
			<div id="nav_username" class="display_block_if_logged_in"></div>
			<div id="tabs">
				<div id="tab_0" class="tab lng_services" onclick="open_static_tab(this.id, 'html')"></div>
				<div id="tab_1" class="display_block_if_logged_out tab" onclick="open_static_tab(this.id, 'html')">Login</div>
				<div id="tab_4" class="display_block_if_logged_in tab" onclick="view_user_logged('out')">Logout</div>
				<div id="tab_2" class="tab" onclick="open_static_tab(this.id, 'html')">Tab 2</div>
				<div id="tab_3" class="tab" onclick="open_static_tab(this.id, 'html')">Tab 3</div>
			</div>
			<div>Height: <span id="height"></span></div>
			<div>Width: <span id="width"></span></div>
			<!-- <div id="se_test_div">Heh</div> -->
		</div>
	</div>