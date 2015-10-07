<?php
class Api_Sku extends Api_Abstract{
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
     * 创建买家订单
     */
    public static function addSku($info){
    	$params = array(
            'code' => $info['code'],
    		'title' => $info['title'],
    		'imgurl' => $info['imgurl'],
    		'price_unit' => $info['price_unit'],
    		'attr' => $info['attr'],
    		'remark' => $info['remark'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
        );

        return self::instance()->post(self::getApiUrl('api/sku/addsku'), $params);
    }
}