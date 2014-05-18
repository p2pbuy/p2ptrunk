<?php
class Dw_User extends Dw_Abstract{
	//连接数据库
	public static function connectDB($pool){
		$db = Db_Db::pool($pool);
		return $db;
	}
	//注册用户
	public static function regByApi($info){
		try{
			//获得acl配置
			$aclConf = Tools_Conf::get('Api_ACL');
			
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['email'].$aclConf[$info['source']]['secret_key']);
			$re = Api_User::reg($info);
		}catch(Exception $e){
			return false;
		}
		return $re;
	}
	
	//注册用户入库
	public static function regByDb($info){
		try{
			$data = array();
			foreach($info as $value){
				$data[] = $value;
			}
			$db = self::connectDB('main');
			$sql = "insert into `users`(`passwd`,`nick`,`email`,`type`) values (?,?,?,?);";
			$re = $db->exec ( $sql, $data );
		}catch(Exception $e){
			return false;
		}
		return $re;
	}
}