<?php

namespace Sys;

class Response{
	/**
	 * Получить post запрос
	 * 
	 * @param string ключ в массиве $_POST
	 * @return mixed
	 */
	public static function post($key){
		if(isset($_POST[$key])){
			return $_POST[$key];
		}
	}

	/**
	 * Проверить на существование и вернуть значение
	 * 
	 * @param mixed  проверяемая переменная
	 * @param string значение по умолчанию
	 * @return mixed
	 */
	public static function isset(&$test,$default = null){
		if(isset($test)){
			return $test;
		}
		return $default;
	}

	/**
	 * Привести к типу
	 * 
	 * @param mixed  проверяемая переменная
	 * @param string значение по умолчанию
	 * @return mixed
	 */
	public static function to_type($name = NULL, $type = NULL,$return = NULL){
    	$val = $return;
        
    	if(!empty($name) OR $name === 0)
    		$val = $name;

    	if($type == 'string'  || $type == 'str')
    		return strval(preg_replace('/[^\p{L}\p{Nd}\d\s_\-\.\%\s]/ui', '', $val));
    		
    	if($type == 'integer' || $type == 'int')
    		return intval($val);

    	if($type == 'boolean' || $type == 'bool')
    		return !empty($val);
        
    	if($type == 'array' || $type == 'arr')
    		return (is_array($val))?$val:array();
        
    	if($type == 'NULL')
    		return NULL;

    	return $val;
    }

}