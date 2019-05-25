<?php


namespace app\controllers;

use ishop\base\Controller;

class MainController extends AppController
{


	public function indexAction(){
		$this->setMeta('Main page',
			'Page description',
			'Page keywords');
	}
}