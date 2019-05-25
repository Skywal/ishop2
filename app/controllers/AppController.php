<?php
/// Контролер з спільними для всіх інших контролерів функціями

namespace app\controllers;


use app\models\AppModel;
use ishop\base\Controller;

class AppController extends Controller {
	public function __construct($route) {
		parent::__construct($route);

		new AppModel();
	}
}