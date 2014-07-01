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
	
	//将买家订单写入数据库
	public static function createBuyOrderByDb($info){
		try{
			$data = array();
			foreach($info as $value){
				$data[] = $value;
			}
			$db = new Db_Order();
			$re = $db->setBuyOrderInfo($data);
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
	
	//更新订单属性
	public static function updateBuyOrderByBoidByDb($info){
		try{
			$data['where'] = '`boid` = ?';
			foreach($info as $key => $value){
				if(!empty($value) && $key != 'boid'){
					$data['set'] .= "`{$key}` = ?,";
					$data['upddata'][] = $value;
				}
			}
			if(empty($data['set'])){
				return false;
			}
			$data['set'] = substr($data['set'], 0, -1);
			$data['upddata'][] = $info['boid'];
			$db = new Db_Order();
			$re = $db->updOrderInfo($data);
		}catch(Exception $e){
			return false;
		}
		return $re;
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
}