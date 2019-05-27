<?php

// TODO: Comment this

namespace app\controllers;

use ishop\base\Controller;
use ishop\Cache;

class MainController extends AppController
{

	public function indexAction(){

		$this->setMeta('Main page',
			'Page description',
			'Page keywords');
	}
}