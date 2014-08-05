<?php
/**
 * 登录类
 * @author liang
 *
 */
class Dr_Login extends Dr_Abstract{
	
	//根据uid生成cookie PUCS加密 PUCE未加密
	public static function createCookieByUid($uid){
		if(empty($uid)){
			return false;
		}
		$cookies['PUCS'] = md5($uid.Tools_Conf::get('Cookie.cookie.secret'));
		$cookies['PUCE'] = $uid.','.time();
		return $cookies;
	}
	
	//cookie是否有效
	public static function cookieIsValid($cookie = array()){
		$PUCE = explode(',', $cookie['PUCE']);
		$uid = $PUCE[0];
		
		if($cookie['PUCS'] == md5($uid.Tools_Conf::get('Cookie.cookie.secret'))){
			return true;
		}
		return false;
	}
	
	//是否登录
	public static function isLogined(){
		if(empty($_COOKIE['PUCS']) || empty($_COOKIE['PUCE'])){
			return false;
		}
		
		return self::cookieIsValid($_COOKIE);
	}
	
	//验证账号密码是否正确
	public static function userpwdByApi($info = array()){
		try{
			//获得acl配置
			$aclConf = Tools_Conf::get('Api_ACL');
			
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['email'].$info['passwd'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Login::userpwd($info);
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