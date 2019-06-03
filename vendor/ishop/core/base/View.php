<?php

// TODO: Comment this

namespace ishop\base;


use ishop\App;

class View
{
    // шлях до конкретної сторінки
	public $route;
	// контроллер для конкретної сторінки
	public $controller;
	// вид конкретної сторінки
	public $view;
	// модель конкретної сторінки
	public $model;
	// префікс для випадку адмінської частини
	public $prefix;
	// HTML сторінка яку потрібно відобразити, шаблон (незмінна частина сайту)
	public $layout;
	// дані для HTML
	public $data = [];
	// метадані для HTML
	public $meta = [];

    /**
     * Об'єкт виду буде створюватися в контроллері
     * View constructor.
     * @param $route
     * @param string $layout
     * @param string $view
     * @param $meta
     */
	public function __construct($route, $layout = '', $view = '', $meta) {
		$this->route = $route;
		$this->controller = $route['controller'];
		$this->view = $view;
		$this->model = $route['controller'];
		$this->prefix = $route['prefix'];
		$this->meta = $meta;

		if($layout === false){
			$this->layout = false; // не використовуємо шаблони якщо жорстко передаємо false
		} else {
		    // якщо пуста строка то використовуємо стандартний шаблон
			$this->layout = $layout ?: LAYOUT;
		}
	}

    /**
     * відобразити HTML шаблон
     * шаблон лежить по шляху у вигляді
     * views / { назва контролеру } / { назва екшину }
     * @param $data дані для відображення у шаблоні
     * @throws \Exception
     */
	public function render($data){
	    // для предачі даних з контролеру у вид
		if(is_array($data))
		    extract($data); // витягування даних з масиву для доступу до них в шаблоні

		$viewFile = \APP . "/views/{$this->prefix}{$this->controller}/{$this->view}.php";

		//якщо існує такий файл то підключаємо вид
		if(is_file($viewFile)){

			ob_start(); // включення буферизації виводу

			require_once $viewFile;

			$content = ob_get_clean(); // присвоєння змісту виду змінній і очистка буфера
		} else {
			throw new \Exception("View is not found {$viewFile}", 500);
		}
        // якщо шаблон дозволено підключати то підключаємо його
		if(false !== $this->layout){
			$layoutFile = \APP . "/views/layouts/{$this->layout}.php";
			//якщо існує то все ок
			if(is_file($layoutFile)){
				require_once $layoutFile;
			} else {
				throw new \Exception("Template is not found {$this->layout}", 500);
			}
		}
	}

    /**
     * вписування мета-даних у html код
     * @return string
     */
	public function getMeta(){
	    // вписування мета-даних у готову розмітку щоб було простіше його відразу викликати у шаблоні
		$output = '<title>' . $this->meta['title'] . '</title>' . PHP_EOL;
		$output .= '<meta name="description" content="' . $this->meta['desc'] . '">' . PHP_EOL;
		$output .= '<meta name="keywords" content="' . $this->meta['keywords'] . '">' . PHP_EOL;
		return $output;
	}
}