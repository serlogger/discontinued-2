<?php
session_start();
$_SESSION['lang'] = 'fi';
header('Location: '.$_SESSION['hm'] . $_SESSION['redirect_to']);