<?php

namespace ishop;

/**
 * невеличкий кусок коду котрий можна копіпастити
 * Trait TSingltone
 * @package ishop
 */
trait TSingltone
{
    private static $instance;

    public static function instance(){
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }
}