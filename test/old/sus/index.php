<?php
require_once('1_usr-view/1_1_usr-view-sec_functions.php');
require_once('1_usr-view/1_2_usr-view_functions.php');
require_once('2_usr-receive/2_1_usr-receive-sec_functions.php');
require_once('2_usr-receive/2_2_usr-receive_functions.php');
require_once('3_svr-fetch/3_1_svr-fetch-security_functions.php');
require_once('3_svr-fetch//3_2_svr-fetch_functions.php');
require_once('4_sec-exe/4_1_security_functions.php');
require_once('4_sec-exe/4_2_execution-and-decision_functions.php');

// 1_1 usr_view_sec PHP
sanitize_post($_POST);

// 1_2 usr_view PHP
show_default_or_fetched();

// 2_1 usr_receive_sec JS
sanitize_users_input();

// 2_2 usr_receive
store_users_input();

// 3_1 svr_fetch_sec
sanitize_data_to_fetch();

// 3_2 svr_fetch
fetch_data();

// 4_1 sec
escape_fetched_data();

// 4_2 execute
store_fetched_result();