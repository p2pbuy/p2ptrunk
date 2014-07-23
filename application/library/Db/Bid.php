<?php
class Db_Bid extends Db_Abstract{
	private $poolName = 'main';
	private $dbObj;
	
	public function __construct($poolName = null){
		$poolName = $poolName ? $poolName : $this->poolName;
		$this->dbObj = Db_Db::pool($poolName);
		return true;
	}
	
	/**
	 * 写入走私者竞价信息
	 */
	public function setBidBuyOrderInfo($data = array()){
		$sql = "insert into `bidbuyorder` (`boid`,`price`,`uid`) values (?,?,?);";
		return  $this->dbObj->exec ( $sql, $data );
	}
	
	/**
	 * 根据boid读取竞价信息
	 */
	public function getBidPriceByBoids($data = array()){
		$data = array_values($data);
		$sql = "select * from `bidbuyorder` where boid in (?)";
		return $this->dbObj->fetch_all ( $sql, $data );
	}
	
	/**
	 * 根据uid读取竞价信息
	 */
	public function getBidInfoByUid($data = array()){
		$data = array_values($data);
		$sql = "select * from `bidbuyorder` where uid = ?";
		return $this->dbObj->fetch_all ( $sql, $data);
	}
}