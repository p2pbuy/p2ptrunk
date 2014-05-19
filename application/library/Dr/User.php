<?php
class Dr_User extends Dr_Abstract{
	//生成uid
	public static function createUid(){
		return '1000000000000008';
	}
	
	//获得用户信息
	public static function show($uid){
		if(empty($uid)){
			return false;
		}
		try{
			$cache = new Cache_User();
			$re = $cache->getUserInfo($uid);
			
			if($re == false){
				$db = self::connectDB('main');
				$sql = "select * from `users` where `uid` = {$uid}";
				$re = $db->fetch_all ( $sql );
				if($re != false){
					$cache->setUserInfo($uid,$re);
				}
			}
		}catch(Exception $e){
			return false;
		}
		
		return $re;
	}
}