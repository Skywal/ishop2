<?php

// TODO: Comment this

namespace app\controllers;

use ishop\App;
use ishop\base\Controller;
use ishop\Cache;

class MainController extends AppController
{

	public function indexAction(){

		$this->setMeta(App::$app->getProperty('shop_name'),
			'Page description',
			'Page keywords');
	}
}