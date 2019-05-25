<?php


namespace ishop\base;


use ishop\App;

class View
{
	public $route;
	public $controller;
	public $view;
	public $model;
	public $prefix;
	public $layout;
	public $data = [];
	public $meta = [];

	public function __construct($route, $layout = '', $view = '', $meta) {
		$this->route = $route;
		$this->controller = $route['controller'];
		$this->view = $view;
		$this->model = $route['controller'];
		$this->prefix = $route['prefix'];
		$this->meta = $meta;

		if($layout === false){
			$this->layout = false;
		} else {
			$this->layout = $layout ?: LAYOUT;
		}
	}

	public function render($data){
		$viewFile = \APP . "/views/{$this->prefix}{$this->controller}/{$this->view}.php";
		if(is_file($viewFile)){
			ob_start(); // включення буферизації
			require_once $viewFile;
			$content = ob_get_clean(); // присвоєння змісту виду змінній і очистка буфера
		} else {
			throw new \Exception("View is not found {$viewFile}", 500);
		}
		if(false !== $this->layout){
			$layoutFile = \APP . "/views/layouts/{$this->layout}.php";
			if(is_file($layoutFile)){
				require_once $layoutFile;
			} else {
				throw new \Exception("Template is not found {$this->layout}", 500);
			}
		}
	}

	public function getMeta(){
		$output = '<title>' . $this->meta['title'] . '</title>' . PHP_EOL;
		$output .= '<meta name="description" content="' . $this->meta['desc'] . '">' . PHP_EOL;
		$output .= '<meta name="keywords" content="' . $this->meta['keywords'] . '">' . PHP_EOL;
		return $output;
	}
}