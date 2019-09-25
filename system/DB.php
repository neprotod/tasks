<?php

namespace Sys;

use Sys\Core;

class DB{

    /**
     * Образец класса
     * 
     * @var object
     */
    protected static $_init;

    /**
     * Настройки базы данных
     * 
     * @var array
     */
    protected $config;
    
    /**
     * Образец PDO
     * 
     * @var object
     */
    protected $connection;
    
    private function __construct(){
        $this->config = Core::config("db");
    }

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

    public function connect(){
        // Если соединение было создано, возвращаем его.
        if($this->connection){
            return $this->connection;
        }
        $dsn = sprintf("mysql:dbname=%s;host=%s",$this->config['database'],$this->config['host']);
        $username = $this->config['username'];
        $password = $this->config['pass'];


        // Создаем новое PDO соединение
		return $this->connection = new \PDO($dsn, $username, $password);
    }

    public function disconnect()
	{
		// Уничтожаем PDO object
		$this->connection = NULL;

		return TRUE;
	}

    /**
     * Запросы типа SELECT
     * 
     * @return array 
     */
    public static function select($sql,$params = array()){
        return self::init()->prepare($sql,$params)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Запросы типа INSERT|UPDATE|DELETE
     * 
     * @return array 
     */
    public static function query($sql,$params = array()){
        $driver = self::init()->connect();


        return self::init()->prepare($sql,$params)->exec();
    }

    /**
     * Подготовка данных
     * 
     * @return object
     */
     protected function prepare($sql, $params){
        $driver = self::init()->connect();

        $prepare = $driver->prepare($sql);
        $prepare->execute($params);

        return $prepare;
     }
    
}