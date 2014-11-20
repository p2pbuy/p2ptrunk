<?php
class Dw_User extends Dw_Abstract{
	//注册用户
	public static function regByApi($info = array()){
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
	
	//更新用户信息
	public static function updUserinfoByUid($info = array()){
		try{
			//获得acl配置
			$aclConf = Tools_Conf::get('Api_ACL');
			
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['uid'].$aclConf[$info['source']]['secret_key']);
			$re = Api_User::updUserInfoByUid($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
}