<?php


namespace ishop;

/**
 * Класс застосунку
 * головна точка входу ядра
 * Class App
 * @package ishop
 */
class App
{
    // для доступу до різних параметрів
    // контейнер для застосунку (класти, діставати на рівні застосунку)
    // реалізується через шаблон проектування "Реєстратор"
    public static $app;

    public function __construct()
    {
        //строка запросу
        // адреса сторінки що потрібна користувачеві
        $query = trim($_SERVER['QUERY_STRING'], '/');

        session_start(); // для логінки
        
        self::$app = Registry::instance(); // запис об'єкту реєстру

        $this->getParams(); // запис у контейнер налаштувань застосунку

        new ErrorHandler(); //ініціалізація обробнику помилок

        Router::dispatch($query); // обробляємо строку адреси
    }

    /**
     * заповнення контейнеру застосунку значеннями із файлу налаштувань
     */
    protected function getParams(){
        $params = require_once CONFIG . '/params.php';
        if(!empty($params)){
            foreach ($params as $key => $value){
                self::$app->setProperty($key, $value);
            }
        }
    }
}