<?php


namespace ishop\base;

use ishop\Db;

/**
 * Відповідає за роботу з даними
 * Class Model
 * @package ishop\base
 */
abstract class Model {
	public $attributes = []; //масив властивостей моделей
	public $errors = [];
	public $rules = [];

	public function __construct() {
		Db::instance();
	}
}