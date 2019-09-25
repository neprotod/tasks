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
		$request = parse_url($_SERVER['REQUEST_URI'])['path'];
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

}