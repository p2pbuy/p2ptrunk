<?php
/**
 * 订单类
 * @author liang
 * @version 2014-5-25
 */
class Dr_Order extends Dr_Abstract{
	public static function showOrderBuy($info = array()){
		$info['count'] = ($info['count']) ? intval($info['count']) : 20;
		$info['page'] = ($info['page']) ? intval($info['page']) : 1;
		$info['start'] = ($info['page'] - 1) * $info['count'];
		try{
			$db = new Db_Order();
			$orderBuyInfo = $db->getOrderBuyInfo($info);
		}catch(Exception $e){
			return false;
		}
		return $orderBuyInfo;
	}
}