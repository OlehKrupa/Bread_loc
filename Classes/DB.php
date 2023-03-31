<?php

namespace Bread\classes;

use Bread\classes\traits\singleton;

class DB 
{
    use singleton;
    public \PDO $connect;

    protected function __construct() 
    {
        $this->connect = new \PDO('mysql:host=localhost;dbname='.$_ENV['DB_NAME'],$_ENV['DB_USER'],$_ENV['DB_USER_PASS']);
    }
}

?>