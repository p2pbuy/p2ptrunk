<?php
class Dw_User extends Dw_Abstract{
	//注册用户
	public static function reg($info){
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
}