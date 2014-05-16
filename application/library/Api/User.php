<?php
class Api_User extends Api_Abstract{
	const API_HOST = 'http://127.0.0.1';
	public static $instance = null;
    public static function instance(){
    	if(self::$instance == null){
    		self::$instance = new Api_Httpclient();
    	}
    	return self::$instance;
    }
    public static function getApiUrl($url){
        return self::API_HOST.'/'.trim($url, '/');
    }
    
    /**
     * 注册用户信息
     */
    public static function reg($info){
    	$params = array(
            'email' => $info['email'],
            'nick' => $info['nick'],
    		'passwd' => $info['passwd'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
        );
        return self::instance()->get(self::getApiUrl('api/reg'), $params);
    }
}