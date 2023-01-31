<?php 
require_once "config.php";

$fields = ["user","password"];

if (!empty($_POST)){
	$error = [];
	foreach ($_POST as $k => $v) {
		if (in_array($k, $fields) && empty($v)){
			$error[$k]="Поле має бути заповнене!";
		}
	}

	if($_POST['user']!==DB_USER){
		$error["user"]="Неправильне ім'я користувача";
	}

	if($_POST['user']!==DB_USER_PASS){
		$error["password"]="Неправильний пароль!";
	}

	if (empty($error)){
		$_SESSION['user']=htmlspecialchars($_POST['user']);
		header("location: /index.php");
		die();
	}
}

require_once TEMPLATES_PATH."login.html";
?>