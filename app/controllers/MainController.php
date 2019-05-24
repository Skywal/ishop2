<?php


namespace app\controllers;

use ishop\base\Controller;

class MainController extends AppController
{


	public function indexAction(){
		debug($this->route);
		debug($this->controller);

		echo __FUNCTION__;
	}
}