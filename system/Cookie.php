<?php

namespace Sys;

class Cookie{
	/**
	 * Задает значение cookie.
	 *
	 * @param   string   имя cookie
	 * @param   string   значение
	 * @param   integer  время жизни в секундах
	 * @return  boolean
	 */
	public static function set($name, $value, $expiration = 0){
		return setcookie($name, $value, $expiration);
	}

	/**
	 * Удалить cookie
	 *
	 * @param   string   имя cookie
	 * @return  boolean
	 */
	public static function delete($name){
		// Удалить cookie
		unset($_COOKIE[$name]);

		// Удалить печеньку и поставить время в минус.
		return setcookie($name, NULL, -86400);
	}

	/**
	 * Получает значение  cookie. 

	 *
	 * @param   string  имя cookie
	 * @param   mixed   значение по умолчанию если cookie нет.
	 * @return  string
	 */
	public static function get($key, $default = NULL){
		if ( ! isset($_COOKIE[$key])){
			// Файл cookie не существует
			return $default;
		}

		// Получить cookie
		$cookie = $_COOKIE[$key];

		return $cookie;
	}
}