<?php
class Api_Order extends Api_Abstract{
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
     * 创建买家订单
     */
    public static function createBuyOrder($info){
    	$params = array(
            'uid' => $info['uid'],
            'title' => $info['title'],
    		'description' => $info['description'],
    		'price' => $info['price'],
    		'quantity' => $info['quantity'],
    		'additional' => $info['additional'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
        );

        return self::instance()->post(self::getApiUrl('api/order/createorderbuy'), $params);
    }
    
    /**
     * 走私者认领订单
     */
	public static function smugglerTakeOrder($info){
    	$params = array(
    		'boid' => $info['boid'],
            'uid' => $info['uid'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
        );

        return self::instance()->post(self::getApiUrl('api/order/smugglertakeorder'), $params);
    }
}