<?php
/// Проміжний контролер з спільними для всіх інших контролерів функціями
/// в контроллерах наслідниках буде доступний не тільки код з базового контролеру
/// а і той код що тут напишемо

namespace app\controllers;

use app\models\AppModel;
use ishop\base\Controller;

class AppController extends Controller {

	public function __construct($route) {
		parent::__construct($route);

		new AppModel();
	}
}