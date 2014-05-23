<?php
class Tools_Helper{
	//种cookie
	public static function setCookie($params = array()){
		setcookie($params['name'],$params['value'],$params['expire'],$params['path'],$params['domain']);
		return true;
	}
	//根据数值取摩
	public static function getMoore($num,$divisor){
		return $num % $divisor;
	}
}