<?php

// Previous language selector
if(isset($_GET['lang'])) {
		$_SESSION['lang'] = $_GET['lang'];
	}
// End of previous language selector
	
if(!isset($_SESSION['lang'])) {
		$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		$acceptLang = ['fi', 'en'];
		$language = in_array($language, $acceptLang) ? $language : 'en';
		$_SESSION['lang'] = $language;
	}

	require_once $_SESSION['rt'] .$ds. $inc .$ds. $lng .$ds. $_SESSION['lang'] . ".php";
?>