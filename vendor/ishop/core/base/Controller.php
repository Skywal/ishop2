<?php

// TODO: Comment this

namespace ishop\base;

/**
 * Базовий контролер
 * Class Controller
 * @package ishop\base
 */
abstract class Controller
{
	public $route; // масив з поточним маршрутом
	public $controller; //
	public $view; // вид який відповідає за промальовку відповідного View
	public $model; //
	public $prefix; //
	public $layout; // html шаблон який буде відображатися (незмінна або сдабозмінна частина відображення html)
	public $data = []; // дані які передаватимуться з контролеру у вид
	public $meta = [
		'title' => '',
		'desc' => '',
		'keywords' => ''
	];

	public function __construct($route) {
	    // заповнюємо всі необхідні дані
		$this->route = $route;
		$this->controller = $route['controller'];
		$this->view = $route['action'];
		$this->model = $route['controller'];
		$this->prefix = $route['prefix'];
	}

    /**
     * Промальовує потрібний шаблон
     * @throws \Exception
     */
	public function getView(){
		$viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
		$viewObject->render($this->data);
	}

    /**
     * помістити дані у масив data
     * @param $data
     */
	public function set($data){
		$this->data = $data;
	}

	public function setMeta($title = '', $desc = '', $keywords = ''){
		$this->meta['title'] = $title;
		$this->meta['desc'] = $desc;
		$this->meta['keywords'] = $keywords;
	}
}