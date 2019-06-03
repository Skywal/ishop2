<?php


namespace ishop;

/**
 * Встановлення підключення до серверу бази данних
 * Class Db
 * @package ishop
 */

class Db
{
	use TSingltone;

	protected function __construct() {
	    // підключення файлу конфігурації бази данних
		$db = require_once CONFIG . '/config_db.php';

		class_alias('\RedBeanPHP\R', '\R');

		// установка з'єднання
		\R::setup($db['dsn'], $db['user'], $db['pass']);

		// перевірка чи встановлене з'єднання
		if(!\R::testConnection()){
			throw new \Exception('Can\'t connect to database.', 500);
		}

		// заборона автоматичної зміни бази данних
		\R::freeze(true);

		// увімкнення режиму відладки
		if(DEBUG){
			\R::debug(true, 1);
			// запроси збираються у html шаблоні
		}
	}
}