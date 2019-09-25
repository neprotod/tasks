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

}