<?php

namespace Sys;

class Router{
	/**
     * Образец класса
     * 
     * @var object
     */
	protected static $_init;
	/**
     * Образец класса
     * 
     * @var array
     */
	protected static $request = [];

	/**
     * Массив с query string
     * 
     * @var array
     */
	protected static $query = [];
	
	/**
     * Текущий контроллер
     * 
     * @var string
     */
	protected $controller;

	/**
     * Текущий метод контроллера
     * 
     * @var string
     */
	protected $action;
	/**
     * параметры контроллера
     * 
     * @var string
     */
	protected $params = [];


	/**
     * Создаем singleton
     * 
     * @return void
     */
    public static function init(){
		if(!(self::$_init instanceof self)) 
			self::$_init = new self();
		return self::$_init;
    }
	
	/**
	 * Парсим запрос для определения контроллера
	 * 
	 * @return void
	 */
    private function __construct(){
		$parse_url = parse_url($_SERVER['REQUEST_URI']);

		self::$request["uri"] = $_SERVER['REQUEST_URI'];
		self::$request["path"] = $parse_url['path'];


		// Парсим строку запроса
		if(isset($parse_url['query'])){
			$query = $parse_url['query'];
			$query = explode('&',$query);

			foreach($query as $val){
				$val = explode("=",$val);
				self::$query[$val[0]] = $val[1];
			}
		}

		$request = self::$request["path"];

		if($request == '/')
			$request = '';
		

		$splits = explode('/', trim($request,'/'));
		//Controller
		$this->controller = "App\\Controllers\\";
		$this->controller .= !empty($splits[0]) ? ucfirst($splits[0]) : 'Front';
		//Action
        $this->action = !empty($splits[1]) ? $splits[1] : 'show';
		
		//Есть ли параметры и их значения?
		if(!empty($splits[2])){
			$values  = array();
			for($i=2, $cnt = count($splits); $i<$cnt; $i++){
				//Значение параметра;
				$this->params[] = $splits[$i];
			}
		}
	}


	/**
	 * Запускаем маршрутизацию 
	 * 
	 * @return string
	 */
	public function route(){
		try{
			if(class_exists($this->controller)) {
				$reflect = new \ReflectionClass($this->controller);

				if($reflect->hasMethod($this->action)) {
					$controller = $reflect->newInstance();
					$method = $reflect->getMethod($this->action);
					return $method->invokeArgs($controller, $this->params);
				} else {
					throw new \Exception("Action");
				}
			} else {
				
				throw new \Exception("Класса не существует");
			}	
		}catch(\Exception $e){
			// Ошибка 404
			exit("Ошибка 404");
		}
	}

	/**
	 * Получить весь адрес 
	 * 
	 * @return string
	 */
	public static function getURI(){
		return self::$request["uri"];
	}
	/**
	 * Получить значение query string
	 * @param string имя запроса
	 * @param string значение по умолчанию
	 * @return mixed
	 */
	public static function getQuery($key,$default = null){
		return isset(self::$query[$key]) 
			?self::$query[$key]
			:$default;
	}
	/**
	 * Получить значение query string
	 * @param string имя запроса
	 * @param string значение по умолчанию
	 * @return mixed
	 */
	public static function getQueryString(){
		if(empty($_GET))
			return '';
		$query = '?';
		foreach(self::$query as $key => $value){
			$query .= $key .'='.$value.'&';
		}
		return trim($query,"&");
	}
	/**
	 * Задать значение query string
	 * 
	 * @param  array ключ имя запроса
	 * @param string ссылка которая получит строку запроса, если не задать будет текущий адрес
	 * @return string
	 */
	public static function setQuery($params,$uri = false){
		if(!$uri){
			$uri = self::$request["path"];
		}
		$query = "";
		foreach($params as $key => $param){
			if($param)
				$query .= $key .'='.$param.'&';
		}
		if(!empty($query))
			$query = "?" . $query;
		return $uri.trim($query,"&");
	}

	/**
	 * Редирект
	 * 
	 * @param линк
	 * @param код перенаправления
	 * @param сообщение
	 * @return void
	 */

	public static function redirect($url = null,$code = 301, $message = null){
		if(!$url){
			$url = self::getURI();
		}
		if(!empty($message)){
			$_SESSION['message'] = $message;
		}
		header("Location: ".$url,$code);
        exit;
	}
	

}