<?php
session_start();
date_default_timezone_set('Europe/Kyiv');
 
define("ROOT_PATH", dirname(__FILE__));
define("TEMPLATES_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR);
define("TABLES_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR."tables".DIRECTORY_SEPARATOR);
define("CLASS_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR);

define("DB_NAME","bread.loc");
define("DB_USER","grain_administrator");
define("DB_USER_PASS","Crop1234@");

$dbConnect = new PDO('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_USER_PASS);

?>