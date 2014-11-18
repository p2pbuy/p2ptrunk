<?php
class Api_Alipay extends Api_Abstract{
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
     * 竞价
     */
    public static function setPayInfo($info = array()){
    	$params = array(
    		'uid' => $info['uid'],
    		'boid' => $info['boid'],
            'resultinfo' => $info['resultinfo'],
    		'result' => $info['result'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
        );

        return self::instance()->post(self::getApiUrl('api/alipay/setpayinfo'), $params);
    }
}