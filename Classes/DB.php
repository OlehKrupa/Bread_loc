<?php

namespace Bread\classes;

use Bread\classes\traits\singleton;

class DB 
{
    use singleton;
    public \PDO $connect;

    protected function __construct() 
    {
        $this->connect = new \PDO('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_USER_PASS);
    }
}

?>