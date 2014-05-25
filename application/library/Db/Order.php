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
		$sql = "insert into `buyorder`(`uid`,`title`,`description`,`price`,`quantity`,`additional`) values (?,?,?,?,?,?);";
		return  $this->dbObj->exec ( $sql, $data );
	}
	
	/**
	 * 读取买家订单信息
	 */
	public function getOrderBuyInfo($data = array()){
		$sql = "select * from `buyorder` order by createtime desc limit {$data['start']},{$data['count']}";
		return $this->dbObj->fetch_all ( $sql );
	}
}