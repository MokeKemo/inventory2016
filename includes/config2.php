<?php
	$_DB_CONFIG1 = array
	(
		'address'	=>	'localhost',
		'port'		=>	3306,
		'username'	=>	'inventory',
		'password'	=>	'Hki61JGDcv',
		'database'	=>	'inventory_db'
	);

	require_once('class.Database.php');
	$db = new Database($_DB_CONFIG1, true);
    $db->query("SET NAMES utf8",1);

	define("ROOT_PATH","/var/www/sites/devinfopoint.com/htdocs/inventory/");
	//define("ROOT_PATH","/var/www/sites/devinfopoint.com/htdocs/inventory/");

	define("BASE_URL", "" );

	define('IMG_PATH',  BASE_URL . 'images/');
	define('JS_PATH',  BASE_URL.'js/');
	define('CSS_PATH', BASE_URL.'css/');
	define('INC_PATH', BASE_URL . 'includes/');
	define('SET_PATH', BASE_URL . 'settings/');
	define('CLASS_PATH', BASE_URL . 'classes/');
