<?php

class DB 
{
	private static $instances = [];
    public PDO $connect;

    protected function __construct() 
    {
        define("DB_NAME","bread.loc");
        define("DB_USER","grain_administrator");
        define("DB_USER_PASS","Crop1234@");

        $this->connect = new PDO('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_USER_PASS);
    }

    public static function getInstance(): Singleton
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /*
    В config.php
    
    define("CLASS_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR);

    require_once CLASS_PATH."DB.php";
    $dbConnect= DB::getInstance()->connect;

    */

}

?>