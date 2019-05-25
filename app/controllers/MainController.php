<?php


namespace app\controllers;

use ishop\base\Controller;
use ishop\Cache;

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

		$cache = Cache::instance();

//		$cache->delete('test');
		$data = $cache->get('test');
		if(!$data){
			$cache->set('test', $names);
		}
		debug($data);

		$this->set(compact('name', 'age', 'names', 'posts'));
	}
}