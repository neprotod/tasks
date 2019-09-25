<?php

namespace Sys;

class Core{

    /**
     * Образец класса
     * 
     * @var object
     */
    public static $_init;

    /**
     * Псевдономы для путей
     * 
     * @var array
     */
    protected static $path = [
        "App" => APPPATH,
        "Sys" => SYSPATH,
    ];
    /**
     * Конфигурации
     * 
     * @var array
     */
    protected static $config = [];

    /**
     * Создаем singleton
     * 
     * @return void
     */
    protected function __construct(){}
    /**
     * Создание объекта ярда
     * 
     * @param array config
     */
    public static function init($config_path = array()){
        if (self::$_init instanceof self){
			// Запрет повторного запуска
			return self::$_init;
        }
        self::$_init = new self();

        // Подключаем файлы кинфигурации
        foreach($config_path as $path){
            if(is_file($path)){
                self::$config += require $path;
            }
        }
        
    }
    /**
     * Получить конфигурацию
     * 
     * @param array config
     */
    public static function config($key){
        $tmp = self::$config;
        $keys = explode('.',$key);
        
        foreach($keys as $val){
            if(isset($tmp[$val])){
                $tmp = $tmp[$val];
            }else{
                return false;
            }
        }
        return $tmp;
    }

    /**
     * Автозагрузка классов
     * 
     * @param string class name
     */
    public static function autoload($class){
        // Разбираем на путь
        $explode = explode('\\', $class);
        
        $path = "";
        $class = array_pop($explode);

        // Проверяем на псевдоним
        if(isset(self::$path[$explode[0]])){
            $path .= self::$path[$explode[0]];
            unset($explode[0]);
        }

        // Переводим в нижний регистр
        foreach($explode as $var){
            $path .= strtolower($var) . DIRECTORY_SEPARATOR;
        }

        $path .= $class.EXT;

        // Подключаем файл класса
        try{
            if(is_file($path)){
                require $path;

                // Класс найден
				return TRUE;
            }else{
                throw new \Exception("Класс $class не найден, по пути $path");
            }
        }catch(\Exception $e){
            echo 'Не удалось подключить<pre>';
			echo $e->getMessage() . "<br /><br />";
			exit();
        }
    }
}