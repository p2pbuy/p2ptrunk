<?php
class Dr_User extends Dr_Abstract{
	
	//获得用户信息
	public static function show($uid){
		if(empty($uid)){
			return false;
		}
		try{
			$cache = new Cache_User();
			$userInfo = $cache->getUserInfo($uid);
			$userInfo = false;
			if($userInfo == false){
				$db = new Db_User();
				$re = $db->getUserByUid($uid);
				$userInfo = $re[0];
				$re = $db->getUserInfoByUid($uid); 
				$userInfo['extends'] = $re[0];
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