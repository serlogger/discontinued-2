<?php if (session_status() === PHP_SESSION_NONE) { session_start(); }?>
<!DOCTYPE html>
<html>
<head>
<style>
	:root {
		--dark: #567;
	}

	.box {
		display:block;
		margin:20px;
		width:100px;
		height:120px;
		border:3px solid skyblue;
	}

	.box2 {
		display:block;
		margin:10px;
		width:80%;
		height:10%;
		border:3px solid var(--dark);
	}

	.tab {
		cursor:pointer;
		display:inline-block;
		margin-left:10px;
		width:100px;
		height:40px;
		border:3px solid skyblue;
	}

	.tab_content {
		display:none;
		margin-left:10px;
		width:500px;
		height:500px;
		border-left:3px solid skyblue;
		border-right:3px solid skyblue;
		border-bottom:3px solid skyblue;
		width: 90%;
	}
</style>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

window.addEventListener('popstate', e => {
	processUrl();
});

function processUrl() {
	console.log('processing URL');
	urlParam = window.location.toString();
	console.log(urlParam);
	const urlArray = urlParam.split("/", 5);
	console.log(urlArray[4]);
	if(urlArray[4].substring(0,3) == "srv")
	{
		open_service(urlArray[4], "popstate");
	}
	if(urlArray[4].substring(0,3) == "tab")
	{
		open_tab(urlArray[4], "popstate");
	}
}

processUrl();

function set_language(language)
{
	if (language == "fi")
	{
		var lang_array = {
			'lng_shit': "paska",
			'lng_car': "auto",
			'lng_cat': "kissa",
			'lng_airplane': "lentokone",
			'lng_ship': "laiva",
			'lng_barrier': "muuri",
			'lng_srv': 'palvelu'
			}
	} else { // English
		var lang_array = {
			'lng_shit': "shit",
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

function toggleDisplayBlock(id) // Hide or show any element (by id)
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

function openTabAppend(id) {
	if (localStorage.getItem('openTab'))
	{
		localStorage.setItem("openTab", id + ',' + localStorage.getItem('openTab'));
	} else {
		localStorage.setItem("openTab", id);
	}
}

function open_tab(id, source)
{
	openGeneral(id, source, "static");
	document.getElementById(id+"_content").style.display = "block";
	document.getElementById(id).style.border = "7px solid lightblue";
	document.getElementById(id).style.borderBottom = "none";
}

function open_service(id, source) {
	openGeneral(id, source, "service");
	var name = "'name'";
	if(!document.getElementById("tab_"+id))
	{
		document.getElementById('tabs').innerHTML += '<div id="tab_'+id+'" class="tab" name="'+id+'" onclick="open_service(this.attributes['+name+'].value)">'+id+'</div><button id="button_'+id+'" name="'+id+'" style="cursor:pointer; display:inline; padding:10px; border: 1px solid black;" onclick="close_service(this.attributes['+name+'].value)">X</button>';
	}
	if(!document.getElementById(id+'_content'))
	{
		document.getElementById('tabs_content').innerHTML += '<div id="'+id+'_content" class="tab_content" style="display:block;">'+id+' content</div>';
	} else {
		document.getElementById(id+'_content').style.display = "block";
	}
	document.getElementById("tab_"+id).style.border = "7px solid lightblue";
	document.getElementById("tab_"+id).style.borderBottom = "none";
	
}

function openGeneral(id, source, type) {
	console.log('Opening '+type+' tab: '+id);
	if (source !== "popstate") 
	{
		history.pushState(null, null, id);
	} else {
		history.replaceState(null, null, id);
	}
	localStorage.setItem('current_tab', id);
	openTabAppend(id);
	tab_content = document.getElementsByClassName('tab_content');
	var i;
	for (i = 0; i<tab_content.length; i++)
	{
		if(document.getElementsByClassName("tab_content"))
		{
			console.log('Tabcontent ' + i + ' found, hiding things before showing the current one...')
			document.getElementsByClassName("tab_content")[i].style.display = "none";
			document.getElementsByClassName('tab')[i].style.border = "3px solid lightblue";
		}
	}
}

function close_service(id) {
	//Remove closed tab from opened tabs history by replacing id with ''
	localStorage.setItem('openTab', localStorage.getItem('openTab').replaceAll(id+',',''));
	//Remove duplicates so that user doesn't have to keep clicking the back button
	let tabsString = localStorage.getItem('openTab');
	const tabArray = tabsString.split(',');
	duplicates = 1;
	k = 0;
	max_loops = 50;
	while(duplicates > 0 && k < max_loops)
	{
		duplicates = 0;
		console.log('Searching for duplicates...');
		for(i=0; i<tabArray.length; i++)
		{
			j = i+1;
			if(tabArray[i] == tabArray[j])
			{
				console.log('Duplicates found. '+tabArray[i]+' = '+tabArray[j]+' Table length before: '+tabArray.length);
				tabArray.splice(i, 1);
				console.log('Table length after: '+tabArray.length);
				duplicates = 1;
			}
		}
		k++;
	}

	localStorage.setItem('openTab', tabArray);

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
</script>
</head>
<body>
	
<button id="en" onclick="set_language(this.id)">En</button>
<button id="fi" onclick="set_language(this.id)">Fi</button>
<button id="but" onclick="toggleDisplayBlock('block')">Toggle1</button>
<button id="non" onclick="toggleDisplayBlock('none')">Toggle2</button>
<button id="crt" onclick="create('create')">Crt</button>
<button id="del" onclick="del('lng_barrier')">Del</button>
<button id="dark" onclick="dark_mode();">Dark</button>
<button id="rosa" onclick="light_mode_rosa();">Rosa</button>
<button id="blue" onclick="light_mode_blue();">Blue</button>

<div class="lng_shit"></div>
<div class="lng_car"></div>
<div class="lng_cat"></div>
<div id="block" class="lng_airplane box" style="display:none;"></div>
<div id="none" class="lng_ship box" style="display:none;"></div>

<div id="create"></div>

<div id="tabs">
	<div id="tab_0" class="tab" onclick="open_tab(this.id), 'html'">Tab 0</div>
	<div id="tab_1" class="tab" onclick="open_tab(this.id), 'html'">Tab 1</div>
	<div id="tab_2" class="tab" onclick="open_tab(this.id), 'html'">Tab 2</div>
	<div id="tab_3" class="tab" onclick="open_tab(this.id), 'html'">Tab 3</div>
</div>

<div id="tabs_content">
	<div id="tab_0_content" class="tab_content">Tab 0 content:
		<div id="srv_0" class="box2" name="srv_0" onclick="open_service(this.attributes['name'].value, 'html')">0<div class="lng_srv"></div></div>
		<div id="srv_1" class="box2" name="srv_1" onclick="open_service(this.attributes['name'].value, 'html')">1<div class="lng_srv"></div></div>
		<div id="srv_2" class="box2" name="srv_2" onclick="open_service(this.attributes['name'].value, 'html')">2<div class="lng_srv"></div></div>
		<div id="srv_3" class="box2" name="srv_3" onclick="open_service(this.attributes['name'].value, 'html')">3<div class="lng_srv"></div></div>
		<div id="srv_4" class="box2" name="srv_4" onclick="open_service(this.attributes['name'].value, 'html')">4<div class="lng_srv"></div></div>
		<div id="srv_5" class="box2" name="srv_5" onclick="open_service(this.attributes['name'].value, 'html')">5<div class="lng_srv"></div></div>
	</div>
	<div id="tab_1_content" class="tab_content">Lorem ipsum </div>
	<div id="tab_2_content" class="tab_content">dolor sit amet, consectetur adipiscing elit,	id est laborum.</div>
	<div id="tab_3_content" class="tab_content">sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim</div>
</div>



<script>
	<?php
		if (!isset($_SESSION['language']))
		{
			$_SESSION['language'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}
	?>
	var language = "<?=$_SESSION['language']?>";
	set_language(language);
</script>

</body>
</html>