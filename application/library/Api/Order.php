<?php
class Api_Order extends Api_Abstract{
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
    public static function createBuyOrder($info){
    	$params = array(
            'uid' => $info['uid'],
            'title' => $info['title'],
    		'description' => $info['description'],
    		'price' => $info['price'],
    		'quantity' => $info['quantity'],
    		'additional' => $info['additional'],
    		'img' => $info['img'],
    		'thirdurl' => $info['thirdurl'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
        );

        return self::instance()->post(self::getApiUrl('api/order/createbuyorder'), $params);
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
    
    /**
     * 获取订单列表信息
     */
    public static function showBuyOrder($info){
    	$params = array(
    		'count' => $info['count'],
    		'page' => $info['page'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
    		'isshow' => $info['isshow'],
    		'lock' => $info['lock'],
    	);
    	
    	return self::instance()->get(self::getApiUrl('api/order/showbuyorder'), $params);
    }
    
    /**
     * 根据boid获取订单信息
     */
    public static function showBuyOrderByBoids($info){
    	$params = array(
    		'boids' => $info['boids'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
    	);
    	
    	return self::instance()->get(self::getApiUrl('api/order/showbuyorderbyboids'), $params);
    }
    
    /**
     * 根据uid获取订单信息
     */
    public static function showBuyOrderByUid($info){
    	$params = array(
    		'uid' => $info['uid'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
    	);
    	
    	return self::instance()->get(self::getApiUrl('api/order/showbuyorderbyuid'), $params);
    }
    
    /**
     * 根据uid获取该uid接到的订单信息
     */
    public static function showTakeOrderByUid($info){
    	$params = array(
    		'uid' => $info['uid'],
    		'sign' => $info['sign'],
    		'source' => $info['source'],
    	);
    	
    	return self::instance()->get(self::getApiUrl('api/order/showtakeorderbyuid'), $params);
    }
    
    /**
     * 根据boid更新订单状态
     */
    public static function updateBuyOrderByBoid($info){
    	foreach($info as $key => $value){
    		$params[$key] = $value;
    	}
    	
    	return self::instance()->post(self::getApiUrl('api/order/updatebuyorderbyboid'), $params);
    }
    
    /**
     * 设置收获地址
     */
    public static function setAddress($info){
    	foreach($info as $key => $value){
    		$params[$key] = $value;
    	}
    	
    	return self::instance()->post(self::getApiUrl('api/order/setaddress'), $params);
    }
    
    /**
     * 根据uid获得收获地址
     */
    public static function getAddressByUid($info){
    	foreach($info as $key => $value){
    		$params[$key] = $value;
    	}
    	
    	return self::instance()->post(self::getApiUrl('api/order/getaddressbyuid'), $params);
    }
    
    /**
     * 根据boid删除订单
     */
    public static function delBuyOrderByBoid($info){
    	foreach($info as $key => $value){
    		$params[$key] = $value;
    	}
    	
    	return self::instance()->post(self::getApiUrl('api/order/delbuyorderbyboid'), $params);
    }
    
	/**
     * 根据ids获得收获地址
     */
    public static function getAddressByIds($info){
    	foreach($info as $key => $value){
    		$params[$key] = $value;
    	}
    	
    	return self::instance()->post(self::getApiUrl('api/order/getaddressbyids'), $params);
    }
    
    /**
     * 添加物流信息
     */
    public static function addLogisticsInfo($info){
    	foreach($info as $key => $value){
    		$params[$key] = $value;
    	}
    	
    	return self::instance()->post(self::getApiUrl('api/order/addlogisticsinfo'), $params);
    }
    
    /**
     * 根据boid获取物流信息
     */
    public static function getLogisticsInfoByBoid($info){
    	foreach($info as $key => $value){
    		$params[$key] = $value;
    	}
    	
    	return self::instance()->post(self::getApiUrl('api/order/getlogisticsinfobyboid'), $params);
    }
    
    /**
     * 根据id删除物流信息
     */
    public static function delLogisticsInfoById($info){
    	foreach($info as $key => $value){
    		$params[$key] = $value;
    	}
    	
    	return self::instance()->post(self::getApiUrl('api/order/dellogisticsinfobyid'), $params);
    }
}