<?php
class Dr_User extends Dr_Abstract{
	//生成uid
	public static function createUid(){
		return '1000000000000010';
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
	
	//账号密码是否正确
	public static function userpasswd($username,$passwd){
		if(empty($username) || empty($passwd)){
			return false;
		}
		try{
			$userpwd = $username.$passwd;
			$cache = new Cache_User();
			//$userPwdIsTure = $cache->getUserPwdIsTrue($userpwd);
			
			if($userPwdIsTure == false){
				$db = new Db_User();
				$userPwdIsTure = $db->getUserInfoByUserPasswd($username,$passwd);
				if($userPwdIsTure['uid'] != false){
					$cache->setUserPwdIsTrue($userpwd,$userPwdIsTure);
				}
			}
		}catch(Exception $e){
			return false;
		}
		
		return $userPwdIsTure;
	}
}