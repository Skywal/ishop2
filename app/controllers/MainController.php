<?php


namespace app\controllers;

use ishop\base\Controller;

class MainController extends AppController
{


	public function indexAction(){
		$posts = \R::findAll('test');

		$this->setMeta('Main page',
			'Page description',
			'Page keywords');
		$name = "Jofry";
		$age = 15;
		$names = ['Jostar', 'Biskit'];
		$this->set(compact('name', 'age', 'names', 'posts'));
	}
}