<?php
ini_set('session.cookie_samesite', 'Strict');
require_once("router.php");

//se_m2p
post('/se_m2p/ajax.php',				'se_m2p/ajax.php');
get ('/se_m2p/db.php',					'se_m2p/db.php');
post('/se_m2p/db.php',					'se_m2p/db.php');
post('/db.php',							'se_m2p/db.php');
get ('/se_m2p/index.php',				'se_m2p/index.php');
get ('/se_m2p/tab_0',					'se_m2p/index2.php');
get ('/se_m2p/search.php',				'se_m2p/search.php');
get ('/se_m2p/search.html',				'se_m2p/search.html');
get ('/se_m2p/view/$tab_number',		'se_m2p/index2.php');
get ('/se_m2p/index2.php',				'se_m2p/index2.php');
get ('/se_m2p/tools/currency_conversion/index.php',		'se_m2p/tools/currency_conversion/index.php');
post('/se_m2p/tools/currency_conversion/convert.php',	'se_m2p/tools/currency_conversion/convert.php');
get ('/se_m2p/tools/detect_country_IP/index.php',		'se_m2p/tools/detect_country_IP/index.php');
post('/search_ajax.php',				'1-services/1-browse/search_ajax.php');
get ('/db.php',							'1-services/1-browse/db.php');
get ('/se_m2p/distance/distance.php',	'se_m2p/distance/distance.php');
get ('/se_m2p/distance/index.php',		'se_m2p/distance/index.php');
post('/se_m2p/distance/index.php',		'se_m2p/distance/index.php');
get ('/se_m2p/distance/index2.php',		'se_m2p/distance/index2.php');
post('/se_m2p/distance/index2.php',		'se_m2p/distance/index2.php');
get ('/se_m2p/distance/dbConfig.php',	'se_m2p/distance/dbConfig.php');
get ('/info',							'phpinfo.php');
get ('/se_m2p/$anything_else',			'se_m2p/index2.php');
post('/fetch_data.php',                 'se_m2p/1_services/1_browse/fetch_data.php');
post('/fetch_username.php',             'se_m2p/inc/ajax/fetch_username.php');

//Auth
get ('/se_m2p/4_auth/activate.php',		'/se_m2p/4_auth/activate.php');
post('/se_m2p/authenticate.php',		'/se_m2p/4_auth/authenticate.php');
get ('/se_m2p/4_auth/config.php',		'/se_m2p/4_auth/config.php');
get ('/se_m2p/home.php',				'/se_m2p/4_auth/home.php');
get ('/se_m2p/4_auth/home.php',			'/se_m2p/4_auth/home.php');
get ('/se_m2p/4_auth/index.php',		'/se_m2p/4_auth/index.php');
get ('/se_m2p/4_auth',					'/se_m2p/4_auth/index.php');
get ('/se_m2p/4_auth/logout.php',		'/se_m2p/4_auth/logout.php');
get ('/se_m2p/4_auth/main.php',			'/se_m2p/4_auth/main.php');
get ('/se_m2p/4_auth/profile.php',		'/se_m2p/4_auth/profile.php');
get ('/se_m2p/4_auth/register.php',		'/se_m2p/4_auth/register.php');
post('/se_m2p/4_auth/register-process.php','/se_m2p/4_auth/register-process.php');
get ('/se_m2p/4_auth/resendactivation.php','/se_m2p/4_auth/resendactivation.php');
post('/se_m2p/4_auth/resendactivation.php','/se_m2p/4_auth/resendactivation.php');
get ('/se_m2p/4_auth/captcha.php',		'/se_m2p/4_auth/captcha.php');
get ('/se_m2p/4_auth/forgotpassword.php','/se_m2p/4_auth/forgotpassword.php');
get ('/se_m2p/4_auth/resetpassword.php','/se_m2p/4_auth/resetpassword.php');
post('/se_m2p/4_auth/forgotpassword.php','/se_m2p/4_auth/forgotpassword.php');
post('/se_m2p/4_auth/resetpassword.php','/se_m2p/4_auth/resetpassword.php');

//Admin
get ('/admin/emailtemplate.php',		'admin/emailtemplate.php');
get ('/admin',							'admin/index.php');
get ('/admin/index.php',				'admin/index.php');
get ('/main.php',						'admin/main.php');
get ('/admin/settings.php',				'admin/settings.php');
post('/admin/settings.php',				'admin/settings.php');
post('/addcat',							'admin/add_categories.php');
get ('/addcat',							'admin/add_categories.php');

//Any
any('/404',								'inc/404.php');

//Test
get ('/test.php',				        'test/test.php');
post('/test_insert.php',				'test/test_insert.php');
get ('/advance_search.php',				'test/advance_search.php');
post('/advance_search.php',				'test/advance_search.php');
get ('/test2.php',				        'test/test2.php');
get ('/test3.php',				        'test/test3.php');
get ('/test4.php',				        'test/test4.php');
post('/db_controller.py',				'test/db_controller.php');
post('/db_controller2',				    'test/db_controller2.php');
post('/db_controller3',				    'test/db_controller3.php');
get('/ajax_filter_items.php',           'test/db/ajax_filter_items.php');
get('/ajax_filter_items2.php',          'test/db/ajax_filter_items2.php');
post('/test_insert3.php',				'test/test_insert3.php');
get ('/test/jstree/demo/basic/index.html',   'test/jstree/demo/basic/index.html');
get ('/test/jstree2/index.php',         'test/jstree2/index.php');
get('/test/jstree2/response.php',       'test/jstree2/response.php');
get('/response3.php',                   'test/response3.php');
post('/test4_response.php',			    'test/test4_response.php');
get ('/test5.php',				        'test/test.php');
post('/test_insert5.php',				'test/test_insert5.php');