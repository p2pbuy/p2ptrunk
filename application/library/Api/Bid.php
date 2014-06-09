<?php
class Api_Bid extends Api_Abstract{
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
     * 竞价
     */
    public static function bidBuyOrder($info){
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
    public static function getBidPriceByBoid($info){
    	$params = array(
    		'boids' => $info['boids'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
        );

        return self::instance()->get(self::getApiUrl('api/bid/getbidpricebyboids'), $params);
    }
}