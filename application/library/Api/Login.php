<?php
class Api_Login extends Api_Abstract{
	const API_HOST = 'http://api.p2pbuy.net';
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
     * 验证邮箱密码是否正确并返回uid
     */
    public static function userpwd($info){
    	$params = array(
            'username' => $info['email'],
    		'passwd' => $info['passwd'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
        );
        return self::instance()->get(self::getApiUrl('api/userpwd'), $params);
    }
}