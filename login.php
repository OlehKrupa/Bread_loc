<?php 
require_once "config.php";

$fields = ["user","password"];

if (!empty($_POST)){
	$error = [];

	if($_POST['user']!==DB_USER){
		$error["user"]="Неправильне ім'я користувача";
	}

	if($_POST['password']!==DB_USER_PASS){
		$error["password"]="Неправильний пароль!";
	}

	foreach ($_POST as $k => $v) {
		if (in_array($k, $fields) && empty($v)){
			$error[$k]="Поле має бути заповнене!";
		}
	}

	if (empty($error)){
		$_SESSION['user']=htmlspecialchars($_POST['user']);
		$_SESSION['logined']=1;
		
		header("location: /index.php");
		die();
	}
}

require_once TEMPLATES_PATH."login.html";
?>