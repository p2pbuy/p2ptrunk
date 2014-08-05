<?php
/**
 * 订单类
 * @author liang
 * @version 2014-5-25
 */
class Dr_Order extends Dr_Abstract{
	public static function showBuyOrderByApi($info = array()){
		try{
			//获得acl配置
			$aclConf = Tools_Conf::get('Api_ACL');
			
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Order::showBuyOrder($info);
			$result = json_decode($re,true);
			if($result['code'] == 100000){
				$data = $result['data'];
			}else{
				return false;
			}
		}catch(Exception $e){
			return false;
		}
		return $data;
	}
	
	public static function showBuyOrderByBoidsByApi($info = array()){
		try{
			//获得acl配置
			$aclConf = Tools_Conf::get('Api_ACL');
			
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['boids'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Order::showBuyOrderByBoids($info);
			$result = json_decode($re,true);
			if($result['code'] == 100000){
				$data = $result['data'];
			}else{
				return false;
			}
		}catch(Exception $e){
			return false;
		}
		return $data;
	}
	
	public static function showBuyOrderByUidByApi($info = array()){
		try{
			//获得acl配置
			$aclConf = Tools_Conf::get('Api_ACL');
			
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['uid'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Order::showBuyOrderByUid($info);
			$result = json_decode($re,true);
			if($result['code'] == 100000){
				$data = $result['data'];
			}else{
				return false;
			}
		}catch(Exception $e){
			return false;
		}
		return $data;
	}
	
	public static function showTakeOrderByUidByApi($info = array()){
		try{
			//获得acl配置
			$aclConf = Tools_Conf::get('Api_ACL');
			
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['uid'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Order::showTakeOrderByUid($info);
			$result = json_decode($re,true);
			if($result['code'] == 100000){
				$data = $result['data'];
			}else{
				return false;
			}
		}catch(Exception $e){
			return false;
		}
		return $data;
	}
}