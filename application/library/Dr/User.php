<?php
class Dr_User extends Dr_Abstract{
	//连接数据库
	public static function connectDB($pool){
		$db = Db_Db::pool($pool);
		return $db;
	}
	//生成uid
	public static function createUid(){
		return '1000000000000001';
	}
	
	//获得用户信息
	public static function show($uid){
		if(empty($uid)){
			return false;
		}
		try{
			$db = self::connectDB('main');
			$sql = "select * from `users` where `uid` = {$uid}";
			$re = $db->fetch_all ( $sql );
		}catch(Exception $e){
			return false;
		}
		return $re;
	}
}