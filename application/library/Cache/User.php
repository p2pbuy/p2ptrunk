<?php
class Cache_User extends Cache_Abstract{
	private $poolName = 'P2P_MAIN';
	private $keyPrefix = 'user';
	private $config = array(
		'userinfo' => array('%s_0_0_%s',3600), //用户信息
		'userpwd' => array('%s_0_1_%s',3600), //账号密码是否正确
	);
	private $cacheObj;
	public function __construct($poolName = null){
		$poolName = $poolName ? $poolName : $this->poolName;
		$this->cacheObj = Cache_Pool::pool($poolName);
		return true;
	}
	/**
	 * 获得key
	 */
	public function getKey($name,$keyName){
		$key = sprintf($this->config[$name][0],$this->keyPrefix,$keyName);
		return $key;
	}
	/**
	 * 获得缓存失效时间
	 */
	public function getLiveTime($name){
		return $this->config[$name][1];
	}
	
	/**
	 * mc获取用户信息
	 */
	public function getUserInfo($uid){
		$key = $this->getKey('userinfo',$uid);
		return $this->cacheObj->get($key);
	}
	/**
	 * mc设置用户信息
	 */
	public function setUserInfo($uid,$value){
		$key = $this->getKey('userinfo',$uid);
		$liveTime = $this->getLiveTime('userinfo');
		return $this->cacheObj->set($key,$value,$liveTime);
	}
	/**
	 * mc获取用户账号密码是否正确
	 */
	public function getUserPwdIsTrue($userpwd){
		$key = $this->getKey('userpwd',$userpwd);
		return $this->cacheObj->get($key);
	}
	/**
	 * mc设置用户账号密码是否正确
	 */
	public function setUserPwdIsTrue($userpwd,$value){
		$key = $this->getKey('userpwd',$userpwd);
		$liveTime = $this->getLiveTime('userpwd');
		return $this->cacheObj->set($key,$value,$liveTime);
	}
}