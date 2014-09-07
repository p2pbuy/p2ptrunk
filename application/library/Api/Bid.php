<?php
class Api_Bid extends Api_Abstract{
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
    public static function bidBuyOrder($info = array()){
    	$params = array(
    		'boid' => $info['boid'],
    		'bidprice' => $info['bidprice'],
            'uid' => $info['uid'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
        );

        return self::instance()->post(self::getApiUrl('api/bid/bidbuyorder'), $params);
    }
    
    /**
     * 根据boid获得竞价
     */
    public static function getBidPriceByBoid($info = array()){
    	$params = array(
    		'boids' => $info['boids'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
        );

        return self::instance()->get(self::getApiUrl('api/bid/getbidpricebyboids'), $params);
    }
    
    /**
     * 根据uid获得竞价信息
     */
    public static function getBidInfoByUid($info = array()){
    	$params = array(
    		'uid' => $info['uid'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
        );

        return self::instance()->get(self::getApiUrl('api/bid/getbidinfobyuid'), $params);
    }
}