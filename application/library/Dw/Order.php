<?php
/**
 * 订单类
 * @author liang
 * @version 2014-5-25
 */
class Dw_Order extends Dw_Abstract{
	//通过接口生成买家订单
	public static function createOrderBuyByApi($info){
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
	
	//将买家订单写入数据库
	public static function createOrderBuyByDb($info){
		try{
			$data = array();
			foreach($info as $value){
				$data[] = $value;
			}
			$db = new Db_Order();
			$re = $db->setOrderBuyInfo($data);
		}catch(Exception $e){
			return false;
		}
		return $re;
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
	
	//走私者认领订单写入数据库
	public static function smugglerTakeOrderByDb($info){
		try{
			$data = array();
			foreach($info as $value){
				$data[] = $value;
			}
			$db = new Db_Order();
			$re = $db->setTakeOrderInfo($data);
		}catch(Exception $e){
			return false;
		}
		return $re;
	}
}