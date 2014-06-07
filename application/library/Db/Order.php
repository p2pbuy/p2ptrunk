<?php
class Db_Order extends Db_Abstract{
	private $poolName = 'main';
	private $dbObj;
	
	public function __construct($poolName = null){
		$poolName = $poolName ? $poolName : $this->poolName;
		$this->dbObj = Db_Db::pool($poolName);
		return true;
	}
	
	/**
	 * 写入买家订单信息
	 * @param array $data
	 */
	public function setOrderBuyInfo($data = array()){
		$sql = "insert into `buyorder` (`uid`,`title`,`description`,`price`,`quantity`,`additional`) values (?,?,?,?,?,?);";
		$re = $this->dbObj->exec ( $sql, $data );
		if($re == true){
			$lastInsertId = $this->dbObj->__call('lastInsertId',array());
			$lastInsertId = str_pad($lastInsertId, 20, '0', STR_PAD_LEFT);
			$re = $lastInsertId;
		}
		return $re;
	}
	
	/**
	 * 读取买家订单信息
	 */
	public function getOrderBuyInfo($data = array()){
		$sql = "select * from `buyorder` order by createtime desc limit {$data['start']},{$data['count']}";
		return $this->dbObj->fetch_all ( $sql );
	}
	
	/**
	 * 写入走私者认领订单信息
	 */
	public function setTakeOrderInfo($data = array()){
		$sql = "insert into `smugglertakeorder` (`boid`,`uid`) values (?,?);";
		return  $this->dbObj->exec ( $sql, $data );
	}
}