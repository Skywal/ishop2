<?php


namespace ishop;


class App
{
    //для доступу до різних параметрів
    //реалізується через шаблон проектування "Реєстратор"
    public static $app;

    public function __construct()
    {
        //строка із інфою що ми повинні показувати користувачеві
        $query = trim($_SERVER['QUERY_STRING'], '/');

        session_start();
        self::$app = Registry::instance();
        $this->getParams();

        new ErrorHandler();
    }

    protected function getParams(){
        $params = require_once CONFIG . '/params.php';
        if(!empty($params)){
            foreach ($params as $key => $value){
                self::$app->setProperty($key, $value);
            }
        }
    }
}