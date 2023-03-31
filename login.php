<?php
require_once "config.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$logger = new Logger('login');

$fields = ["user","password"];

if (!empty($_POST)){
    $error = [];

    if($_POST['user']!==$_ENV['DB_USER']){
        $error["user"]="Неправильне ім'я користувача";
    }

    if($_POST['password']!==$_ENV['DB_USER_PASS']){
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

		//Обробник вдалого входу
        $successHandler = new StreamHandler(__DIR__.'/logs/login-success.log', Logger::INFO);
        $logger->pushHandler($successHandler);
        $logger->info('Користувач успішно увійшов в систему.');
        header("location: /index.php");
        die();

    } else {
    	
        //Обробник невдалого входу
        $errorHandler = new StreamHandler(__DIR__.'/logs/login-error.log', Logger::ERROR);
        $logger->pushHandler($errorHandler);
        // Логування помилок в формі
        foreach ($error as $key => $value) {
            $logger->error($key . ': ' . $value);
        }
    }
}

require_once TEMPLATES_PATH."login.html";
?>
