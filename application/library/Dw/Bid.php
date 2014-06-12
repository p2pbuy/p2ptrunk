<?php
/**
 * 竞价类
 * @author liang
 * @version 2014-6-8
 */
class Dw_Bid extends Dw_Abstract{
	//通过接口竞价
	public static function getBidPriceByBoid($info){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['boids'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Bid::getBidPriceByBoid($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
	
	//通过接口竞价
	public static function bidBuyOrderByApi($info){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['boid'].$info['bidprice'].$info['uid'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Bid::bidBuyOrder($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
	
	//将竞价写入数据库
	public static function bidBuyOrderByDb($info){
		try{
			$data = array();
			foreach($info as $value){
				$data[] = $value;
			}
			$db = new Db_Bid();
			$re = $db->setBidBuyOrderInfo($data);
		}catch(Exception $e){
			return false;
		}
		return $re;
	}
}