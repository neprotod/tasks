<?php

namespace Sys;

class View{
    /**
     * Путь к отображениям
     * 
     * @val string
     */
    protected static $path = APPPATH . 'views' . DIRECTORY_SEPARATOR;

    /**
     * Вывод содержимого
     * 
     * @param string путь от папки view
     * @param array  данный для шаблона
     */

     public static function render($path, $data = array()){
        try{
            $path = $name = str_replace(".",DIRECTORY_SEPARATOR,$path) . EXT;
            // Формируем путь
            $path = self::$path.$path;
            if(!is_file($path)){
                throw new \Exception("Не найден файл $name для отображения вида");
            }

            // Импорт представления переменных в локальное пространство имен
		    extract($data, EXTR_SKIP);

            // Захват выходные данные вида
            ob_start();
            include $path;
            // Получить захваченные выходные данные и закрыть буфер
		    return ob_get_clean();
            
        }catch(\Exception $e){
            echo $e->getMessage();
            exit();
        }
        
     }
}