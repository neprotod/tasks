<?php

namespace Sys;

class Cookie{
	
	
	public static function isset(&$test,$default = null){
		if(isset($test)){
			return $test;
		}
		return $default;
	}

}