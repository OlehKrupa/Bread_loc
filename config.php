<?php
session_start();
date_default_timezone_set('Europe/Kiev');
ini_set("display_errors", 1);
error_reporting(E_ALL);

define("ROOT_PATH", dirname(__FILE__));
define("TEMPLATES_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR);
define("TABLES_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR."tables".DIRECTORY_SEPARATOR);
define("CLASS_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR);

//composer
require_once ROOT_PATH.DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbConnect = \Bread\classes\DB::getInstance()->connect;

?>