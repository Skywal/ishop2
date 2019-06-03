<?php


namespace ishop;

/**
 * Обробка запиту користувача
 * Class Router
 * @package ishop
 */
class Router
{
	// всі можливі маршрути по сайту, таблиця маршрутів
	protected static $routes = [];
	// поточний маршрут. Виділяємо префікс - адмінська частина та саму назву контролеру
	protected static $route = [];

	public static function getRoutes(){
		return self::$routes;
	}
	public static function  getRoute(){
		return self::$route;
	}

	/**
	 * додати новий можвий шлях на сайті
	 * @param $regexp регулярний вираз
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
	    //фільтрація GET
		$url = self::removeQueryString($url);

		if(self::matchRoute($url)){
			// пошук конкретного контролеру (із фільтурванням адмін частини і корисутвацької)
			$controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';

			// перевірка на існування відповідного контролеру
			if(class_exists($controller)){

				// Свторення об'єкту контролера у випадку успішного його знаходження
				$controllerObject = new $controller(self::$route);
				// перетворення того що потрапляє із сторінти у прийнятний вигляд назви Екшину
				$action = self::lowerCamelCase(self::$route['action']) . 'Action';

				if(method_exists($controllerObject, $action)){
					// виклик екшн методу у випадку його успішного знаходження
					$controllerObject->$action();
					// отрисовка сторінки
					$controllerObject->getView();
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
	 * Пошук маршутів із всіх можливих доступних
     * отримуємо запит з класу App
	 * @param $url
	 * @return bool
	 */
	public static function matchRoute($url){
	    //$pattern  шаблон регулярного виразу $route маршрут для нього
		foreach (self::$routes as $pattern => $route){
			if(preg_match("#{$pattern}#", $url, $matches)){

			    //прибираємо лишні елементи з числовим ідентифікатором з масиву $matches
				foreach ($matches as $key => $value){
					if(is_string($key)){
						$route[$key] = $value; // зберігаємо у тимчасовій змінній
					}
				}
				//дефолтний екшн контролера якщо екшина не вказали
				if(empty($route['action'])){
					$route['action'] = 'index';
				}
				//створення префіксу для користувацької частини
				if(!isset($route['prefix'])){
					$route['prefix'] = '';
				} else {
					$route['prefix'] .= '\\';
				}

				//перетворення назви контролеру у потрібний нам вигляд
				$route['controller'] = self::upperCamelCase($route['controller']);

				self::$route = $route; // зберігаємо у змінній з поточним маршрутом
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
	    // якщо в строці шляху є дефіс він видаляється
        // всі слова з великої букви

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

    /**
     * Фільтрація явного GET запиту, все що йде після знаку питання відсіється
     * у файлі htaccess уже прописано що рядок запиту є неявним GET параметром а флаг QSA дозволяє явні
     * @param $url
     * @return string
     */
	protected static function removeQueryString($url){
		if($url){
		    // розбиває строку по роздільнику на максимум 2 елемента масиву
			$params = explode('&', $url, 2);
			if(false === strpos($params[0], '=')){
				return rtrim($params[0], '/'); // якщо у першу частину відфільтрованого
			} else {
				return ''; // випадок коли працюємо із головною сторінкою і там є явні GET параметри
			}
		}
	}
}