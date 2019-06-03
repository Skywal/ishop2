<?php


namespace ishop\base;

use ishop\Db;

/**
 * Відповідає за роботу з даними
 * Class Model
 * @package ishop\base
 */
abstract class Model {
	public $attributes = []; //масив властивостей моделей, який буде ідентичний полям в базі данних
	public $errors = []; // для складування помилок
	public $rules = []; // правила валідації даних

	public function __construct() {
		Db::instance(); // об'єкт класу бази данних
	}
}