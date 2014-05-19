<?php
/**
 * 数据写入抽象类
 * Enter description here ...
 * @author liang
 *
 */
abstract class Dr_Abstract{
	//连接数据库
	public static function connectDB($pool){
		$db = Db_Db::pool($pool);
		return $db;
	}
	//连接缓存
	public static function connectMC($pool){
		$mc = Cache_Pool::pool($pool);
		return $mc;
	}
}