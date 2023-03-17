<?php

namespace Bread\classes\traits;

trait Singleton
{
	private static $instance = null;

	public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}

?>