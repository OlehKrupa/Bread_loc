<?php
session_start();
date_default_timezone_set('Europe/Kiev');
ini_set("display_errors", 1);
error_reporting(E_ALL);

define("ROOT_PATH", dirname(__FILE__));
define("TEMPLATES_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR);
define("TABLES_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR."tables".DIRECTORY_SEPARATOR);
define("CLASS_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR);

define("DB_NAME","bread.loc");
define("DB_USER","grain_administrator");
define("DB_USER_PASS","Crop1234@");

spl_autoload_register(function($class){
	$prefix = 'Bread\\';
	$base_dir = ROOT_PATH . DIRECTORY_SEPARATOR;
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0){
		return;
	}
	$relativeClass = substr($class, $len);
	$file = $base_dir.str_replace('\\', '/', $relativeClass).'.php';
	if (file_exists($file)){
		require $file;
	}
});

$dbConnect = \Bread\classes\DB::getInstance()->connect;

?>