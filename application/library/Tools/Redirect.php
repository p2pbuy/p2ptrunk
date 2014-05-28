<?php
/**
 * 重定向类
 * @author liang
 * @version 2014-5-22
 */
class Tools_Redirect{
	/**
	 * 跳转到登录入口
	 */
	public static function login_login(){
		$url = 'http://'.Tools_Conf::get('Domain.domain').'/login/login';
		self::response($url);
		return true;
	}
	
	/**
	 * 跳转到首页
	 */
	public static function index(){
		$url = 'http://'.Tools_Conf::get('Domain.domain');
		self::response($url);
		return true;
	}
	
	private static function response($url, $code = 0) {
        header('Location: ' . $url);
        exit;
    }
}