<?php
class Dr_User extends Dr_Abstract{
	//生成uid
	public static function createUid(){
		//mt_getrandmax() 最大2147483647共10位 这里取9位
		$rand = mt_rand(0, 999999999);
		$uid = '1000001'.str_pad($rand,9,'0',STR_PAD_LEFT);
		//$uid = '1000000000000001';
		$userInfo = self::show($uid);
		if(!empty($userInfo)){
			return self::createUid();
		}
		return $uid;
	}
	
	//获得用户信息
	public static function show($uid){
		if(empty($uid)){
			return false;
		}
		try{
			$cache = new Cache_User();
			$userInfo = $cache->getUserInfo($uid);
			
			if($userInfo == false){
				$db = new Db_User();
				$userInfo = $db->getUserInfoByUid($uid);
				if($re != false){
					$cache->setUserInfo($uid,$userInfo);
				}
			}
		}catch(Exception $e){
			return false;
		}
		
		return $userInfo;
	}
	
	//根据cookie获得uid
	public static function getUidByCookie(){
		if(empty($_COOKIE['PUCE'])){
			return false;
		}
		$PUCE = explode(',', $_COOKIE['PUCE']);
		return $PUCE[0];
	}
}