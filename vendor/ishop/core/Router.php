<?php


namespace ishop;


use mysql_xdevapi\Exception;

class Router
{
	// всі можливі маршрути по сайту
	protected static $routes = [];
	// поточний маршрут
	protected static $route = [];

	public static function getRoutes(){
		return self::$routes;
	}
	public static function  getRoute(){
		return self::$route;
	}

	/**
	 * додати новий можвий шлях на сайті
	 * @param $regexp
	 * @param array $route
	 */
	public static function add($regexp, $route=[]){
		self::$routes[$regexp] = $route;
	}

	/**
	 * Обробка URL і виклик відповідного Екшину певного контролеру для показу користувачеві
	 * @param $url
	 * @throws \Exception
	 */
	public static function dispatch($url){
		if(self::matchRoute($url)){
			// пошук конкретного контролеру (із фільтурванням адмін частини і корисутвацької)
			$controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';

			if(class_exists($controller)){

				// Свторення об'єкту контролера у випадку успішного його знаходження
				$controllerObject = new $controller(self::$route);
				// перетворення того що потрапляє із сторінти у прийнятний вигляд назви Екшину
				$action = self::lowerCamelCase(self::$route['action']) . 'Action';

				if(method_exists($controllerObject, $action)){
					// виклик екшн методу у випадку його успішного знаходження
					$controllerObject->$action();
				} else {
					throw new \Exception("Method $controller::$action not found", 404);
				}
			} else {
				throw new \Exception("Controller $controller not found", 404);
			}
		} else {
			throw  new \Exception("Page not found", 404);
		}
	}

	/**
	 * Пошук маршутів із можливих доступних
	 * @param $url
	 * @return bool
	 */
	public static function matchRoute($url){
		foreach (self::$routes as $pattern => $route){
			if(preg_match("#{$pattern}#", $url, $matches)){
				foreach ($matches as $key => $value){
					if(is_string($key)){
						$route[$key] = $value;
					}
				}
				if(empty($route['action'])){
					$route['action'] = 'index';
				}
				if(!isset($route['prefix'])){
					$route['prefix'] = '';
				} else {
					$route['prefix'] .= '\\';
				}

				//перетворення назви контролеру у потрібний нам вигляд
				$route['controller'] = self::upperCamelCase($route['controller']);

				self::$route = $route;
				return true;
			}
		}
		return false;
	}

	/**
	 * CamelCase
	 * @param $name
	 * @return mixed|string
	 */
	protected static function upperCamelCase($name){
//		$name = ucwords(str_replace('-', ' ', $name));
//		$name = str_replace(' ', '', $name);
//		return $name;
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
	}

	/**
	 * camelCase
	 * @param $name
	 * @return string
	 */
	protected static function lowerCamelCase($name){
		return lcfirst(self::upperCamelCase($name));
	}
}