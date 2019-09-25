<?php

// Отображение ошибок
error_reporting(E_ALL | E_STRICT);

session_start();

// Расширение файла по умолчанию
define('EXT', '.php');

// Путь к корневому каталогу
define('ROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

/*
function __autoload($class){
    echo $class;
	//require_once($class.'.php');
}
*/

// Создаем пути
define('APPPATH', realpath(ROOT.'application').DIRECTORY_SEPARATOR);
define('MEDIAPATH', realpath(ROOT.'media').DIRECTORY_SEPARATOR);
define('SYSPATH', realpath(ROOT.'system').DIRECTORY_SEPARATOR);
define('CONFPATH', realpath(ROOT.'config').DIRECTORY_SEPARATOR);


// Загружаем ядро
require SYSPATH.'/Core'.EXT;

spl_autoload_register(array('Sys\Core', 'autoload'));

Sys\Core::init([CONFPATH.'config.php']);

//Подключаем роутер
$router = Sys\Router::init();

echo $router->route();

