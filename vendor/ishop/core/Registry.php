<?php


namespace ishop;

/**
 * реалізація контейнеру для застосунку
 * Class Registry
 * @package ishop
 */
class Registry
{
    //використовуємо трейт
    use TSingltone;

    protected static $properties = []; // склад властивостей

    /**
     * покласти в контейнер властивість
     * @param $name ключ
     * @param $value значення
     */
    public function setProperty($name, $value){
        self::$properties[$name] = $value;
    }

    /**
     * дістати з контейнеру по ключу властивість
     * @param $name
     * @return mixed|null
     */
    public function getProperty($name){
        if(isset(self::$properties[$name])){
            return self::$properties[$name];
        }
        return null;
    }

    /**
     * отримати всі властивості з контейнеру
     * @return array
     */
    public function getProperties(){
        return self::$properties;
    }
}