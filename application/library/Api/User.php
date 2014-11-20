<?php
class Api_User extends Api_Abstract{
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
     * 注册用户信息
     */
    public static function reg($info = array()){
    	$params = array(
            'email' => $info['email'],
            'nick' => $info['nick'],
    		'passwd' => $info['passwd'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
        );
        $option['timeout'] = 7000;
        $option['connect_timeout'] = 7000;
        return self::instance()->post(self::getApiUrl('api/reg'), $params, '', $option);
    }
    
    /**
     * 根据uids获取用户信息
     */
    public static function showUserInfoByUids($info = array()){
    	$params = array(
    		'uids' => $info['uids'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
    	);
    	return self::instance()->get(self::getApiUrl('api/user/showuserinfobyuids'), $params);
    }
    
    /**
     * 获得用户信息
     */
    public static function getUserInfos($info = array()){
    	$params = array(
    		'count' => $info['count'],
    		'page' => $info['page'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
    	);
    	return self::instance()->get(self::getApiUrl('api/user/showuser'), $params);
    }
    
    /**
     * 更新userinfo
     */
    public static function updUserInfoByUid($info = array()){
    	foreach($info as $key => $value){
    		$params[$key] = $value;
    	}
    	
    	return self::instance()->post(self::getApiUrl('api/user/updateuserinfobyuid'), $params);
    }
    
    /**
     * 根据email获得userinfo
     */
    public static function getUserInfoByEmail($info = array()){
    	$params = array(
    		'email' => $info['email'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
    	);
    	return self::instance()->get(self::getApiUrl('api/user/showuserinfobyemail'), $params);
    }
}