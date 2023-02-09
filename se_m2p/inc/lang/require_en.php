<?php
session_start();
$_SESSION['lang'] = 'en';
header('Location: '.$_SESSION['hm'] . $_SESSION['redirect_to']);