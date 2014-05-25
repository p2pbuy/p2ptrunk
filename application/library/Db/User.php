<?php
class Db_User extends Db_Abstract{
	private $poolName = 'main';
	private $dbObj;
	
	public function __construct($poolName = null){
		$poolName = $poolName ? $poolName : $this->poolName;
		$this->dbObj = Db_Db::pool($poolName);
		return true;
	}
	
	/**
	 * 获得用户信息
	 * @param bigint $uid
	 */
	public function getUserInfoByUid($uid){
		$sql = "select * from `users` where `uid` = {$uid}";
		return $this->dbObj->fetch_all ( $sql );
	}
	
	/**
	 * 写入用户信息
	 * @param array $data
	 */
	public function setUserInfo($data = array()){
		//$tableNum = Tools_Helper::getMoore($data[0], 32);
		//$tableName = 'users_'.$tableNum;
		$sql = "insert into `users`(`uid`,`passwd`,`nick`,`email`) values (?,?,?,?);";
		return  $this->dbObj->exec ( $sql, $data );
	}
	
	public function getUserInfoByUserPasswd($username,$passwd){
		$sql = "select uid from `users` where `email` = ? and `passwd` = ?";
		return $this->dbObj->fetch_row($sql , array($username,$passwd));
	}
}