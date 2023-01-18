<?php 
require_once "config.php";

if(empty($_SESSION['user'])){
	require_once TEMPLATES_PATH."login.html";
	die();
}

require_once TEMPLATES_PATH."index.html";
?>