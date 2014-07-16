<?php
/**
 * 竞价类
 * @author liang
 * @version 2014-6-8
 */
class Dr_Bid extends Dw_Abstract{
	//通过接口根据boid获得竞价
	public static function getBidPriceByBoidsByApi($info = array()){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['boids'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Bid::getBidPriceByBoid($info);
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
	
	//根据boid获得竞价
	public static function getBidPriceByBoidsByDb($boids){
		if(empty($boids)){
			return false;
		}
		
		$info['boids'] = $boids;
		try{
			$db = new Db_Bid();
			$bidPriceInfos = $db->getBidPriceByBoids($info);
		}catch(Exception $e){
			return false;
		}
		return $bidPriceInfos;
	}
	
	//通过接口根据uid获得竞价信息
	public static function getBidInfoByUidByApi($info = array()){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['uid'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Bid::getBidInfoByUid($info);
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
	
	//根据uid获得竞价信息
	public static function getBidInfoByUidByDb($uid){
		if(empty($uid)){
			return false;
		}
		
		$info['uid'] = $uid;
		try{
			$db = new Db_Bid();
			$bidInfo = $db->getBidInfoByUid($info);
		}catch(Exception $e){
			return false;
		}
		return $bidInfo;
	}
}