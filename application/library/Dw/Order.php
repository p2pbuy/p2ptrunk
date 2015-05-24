<?php
/**
 * 订单类
 * @author liang
 * @version 2014-5-25
 */
class Dw_Order extends Dw_Abstract{
	//通过接口生成买家订单
	public static function createBuyOrderByApi($info){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['uid'].$info['quantity'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Order::createBuyOrder($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
	
	//通过接口走私者认领订单
	public static function smugglerTakeOrderByApi($info){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['boid'].$info['uid'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Order::smugglerTakeOrder($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
	
	//通过接口更新订单属性
	public static function updateBuyOrderByBoidByApi($info){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['boid'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Order::updateBuyOrderByBoid($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
	
	//通过接口设置收获地址
	public static function setAddressByApi($info){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['uid'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Order::setAddress($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
	
	//通过接口删除订单
	public static function delBuyOrderByBoidByApi($info){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['boid'].$info['uid'].$aclConf[$info['source']]['secret_key']);
			Api_Order::delBuyOrderByBoid($info);
		}catch(Exception $e){
			return false;
		}
		return true;
	}
	
	//通过接口添加物流信息
	public static function addLogisticsInfoByApi($info){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['boid'].$aclConf[$info['source']]['secret_key']);
			Api_Order::addLogisticsInfo($info);
		}catch(Exception $e){
			return false;
		}
		return true;
	}
	
	//通过接口删除物流信息
	public static function delLogisticsInfoByIdByApi($info){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['id'].$info['boid'].$aclConf[$info['source']]['secret_key']);
			Api_Order::delLogisticsInfoById($info);
		}catch(Exception $e){
			return false;
		}
		return true;
	}
}