<!DOCTYPE html>
<html>
<head>
	<title>Mobile first layout</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
/* * {
	margin:0;
	padding:0;
} */

@media screen and (min-width: 1200px) {
	#c1 {
		display: block;
		width: 300px;
		float:left;
		border: 1px solid skyblue;
	}
	
	.c1-button {
		display: none;
	}

	.c2 {
		width: 54%;
		float:left;
		border: 1px solid coral;
	}

	#c3 {
		width: calc(46% - 310px);
		float: left;
		border: 1px solid darkolivegreen;
		
	}
	.c3-button {
		display: none;
	}
}

@media screen and (max-width: 1200px) {
	div {
		box-shadow: 0 0 10px #ccc;
	}
	
	#c1 {
		display:none;
		position: fixed;
		margin-top:20px;
		border: 1px solid skyblue;
		width:300px;
		z-index: 1;
	}
	
	.c1-button {
		position: fixed;
		background: white;
		display:block;
		top:0;
		left:0;
		padding: 5px;
	}

	.c2 {
		width: 100%;
		float:left;
		border: 1px solid coral;
	}

	#c3 {
		display:none;
		right:0;
		position: fixed;
		margin-top:20px;
		border: 1px solid skyblue;
		width:300px;
	}

	.c3-button {
		position: fixed;
		background: white;
		display:block;
		top:0;
		right:0;
		padding: 5px;
	}
}

</style>
</head>
<body>

  <div style="margin:auto;padding:0; max-width:1200px;">
	<div class="c1-button">
		<a href="javascript:void(0);" class="icon" onclick="clickToShowOrHide('c1')">
			<i class="fa fa-bars"> Menu</i>
		</a>
	</div>
    <div id="c1">
	  <div id="myLinks" style="background: white;">
		<a href="#news" 	onclick="clickToShowOrHide('c1')">News</a><br>
		<a href="#contact" 	onclick="clickToShowOrHide('c1')">Contact</a><br>
		<a href="#about" 	onclick="clickToShowOrHide('c1')">About</a><br>
		<a href="#news" 	onclick="clickToShowOrHide('c1')">News</a><br>
		<a href="#contact" 	onclick="clickToShowOrHide('c1')">Contact</a><br>
		<a href="#about" 	onclick="clickToShowOrHide('c1')">About</a><br>
		<a href="#news" 	onclick="clickToShowOrHide('c1')">News</a><br>
		<a href="#contact" 	onclick="clickToShowOrHide('c1')">Contact</a><br>
		<a href="#about" 	onclick="clickToShowOrHide('c1')">About</a><br>
		<a href="#news" 	onclick="clickToShowOrHide('c1')">News</a><br>
		<a href="#contact" 	onclick="clickToShowOrHide('c1')">Contact</a><br>
		<a href="#about" 	onclick="clickToShowOrHide('c1')">About</a><br>
	  </div>
    </div>
    <div class="c2" onclick="clicktoHideAll();">
      two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>two<br>
    </div>
	<div class="c3-button">
		<a href="javascript:void(0);" class="icon" onclick="clickToShowOrHide('c3')">
			<i class="fa fa-search"><i class="fa fa-sort"><i class="fa fa-filter"> Search</i></i></i>
		</a>
	</div>	
    <div id="c3">
		<div id="myLinks" style="background: white;">
			snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort<br>snort
		</div>
    </div>
  </div>

<script
  src="https://code.jquery.com/jquery-3.6.0.min.js">
</script>
<script>

function clickToShowOrHide($id) {
	if ($(window).width() < 1200)
	{
		var z = document.getElementById($id);
		if (z.style.display === "block") {
			z.style.display = "none";
		} else {
			z.style.display = "block";
		}
	}
}

function clicktoHide($id) {
	if ($(window).width() < 1200)
	{	
		document.getElementById($id).style.display = "none";
	}
}

function clicktoHideAll() {
	clicktoHide('c1');
	clicktoHide('c3');
}

function showOrHide13BasedOnWidth(x) {
var y = document.getElementById("c1");
var w = document.getElementById("c3");
  if (x.matches) { // If media query matches
	y.style.display = "none";
	w.style.display = "none";
  } else {
	y.style.display = "block";
	w.style.display = "block";
  }
}
var x = window.matchMedia("(max-width: 1200px)")
showOrHide13BasedOnWidth(x) // Call listener function at run time
x.addListener(showOrHide13BasedOnWidth) // Attach listener function on state changes
</script>

</body>
</html>