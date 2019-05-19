<?php


namespace ishop;


use mysql_xdevapi\Exception;

class Router
{
	// всі можливі маршрути по сайту
	protected static $routes = [];
	// поточний маршрут
	protected static $route = [];

	public static function add($regexp, $route=[]){
		self::$routes[$regexp] = $route;
	}

	public static function getRoutes(){
		return self::$routes;
	}
	public static function  getRoute(){
		return self::$route;
	}

	public static function dispatch($url){
		if(self::matchRoute($url)){
			$controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';
			if(class_exists($controller)){
				$controllerObject = new $controller(self::$route);
				$action = self::lowerCamelCase(self::$route['action']) . 'Action';
				if(method_exists($controllerObject, $action)){
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

				$route['controller'] = self::upperCamelCase($route['controller']);

				self::$route = $route;
				return true;
			}
		}
		return false;
	}

	//CamelCase
	protected static function upperCamelCase($name){
		$name = ucwords(str_replace('-', ' ', $name));
		$name = str_replace(' ', '', $name);
		return $name;
	}

	//camelCase
	protected static function lowerCamelCase($name){
		return lcfirst(self::upperCamelCase($name));
	}
}