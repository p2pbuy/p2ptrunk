<?php
class Dw_User extends Dw_Abstract{
	//注册用户
	public static function regByApi($info){
		try{
			//获得acl配置
			$aclConf = Tools_Conf::get('Api_ACL');
			
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['email'].$aclConf[$info['source']]['secret_key']);
			$re = Api_User::reg($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
	
	//注册用户入库
	public static function regByDb($info){
		try{
			$dataSetUser = array();
			$dataSetUserInfo = array();
			foreach($info as $value){
				$dataSetUser[] = $value;
			}
			$dataSetUserInfo[] = $info['uid'];
			$dataSetUserInfo[] = 1;
			$db = new Db_User();
			$reSetUser = $db->setUser($dataSetUser);
			$reSetUserInfo = $db->setUserInfo($dataSetUserInfo);
		}catch(Exception $e){
			return false;
		}
		return $reSetUser && $reSetUserInfo;
	}
}