<?php
class Dr_User extends Dr_Abstract{
	
	//获得用户信息
	public static function show($uid){
		if(empty($uid)){
			return false;
		}
		try{
			//获得acl配置
			$aclConf = Tools_Conf::get('Api_ACL');
			
			$info['uids'] = $uid;
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['uids'].$aclConf[$info['source']]['secret_key']);
			$re = Api_User::showUserInfoByUids($info);
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
	
	//根据cookie获得uid
	public static function getUidByCookie(){
		if(empty($_COOKIE['PUCE'])){
			return false;
		}
		$PUCE = explode(',', $_COOKIE['PUCE']);
		return $PUCE[0];
	}
	
	//获得用户基本信息
	public static function getUserInfos($info = array()){
		try{
			//获得acl配置
			$aclConf = Tools_Conf::get('Api_ACL');
			
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$aclConf[$info['source']]['secret_key']);
			$re = Api_User::getUserInfos($info);
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
}