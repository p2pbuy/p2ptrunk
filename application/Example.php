<?php
/**
 * 代码示例 此类只提供一些代码的参考，不可直接访问，也不保证可以正确运行，请到实际代码中验证
 * Enter description here ...
 * @author liang
 *
 */
class Example {
	public function mcExample(){
		try{
			$mc = Cache_Pool::pool('P2P_MAIN');
			$mc->set('aaa','11',1800);
			$re = $mc->get('aaa');
		}catch(Exception $e){
			var_dump($e);exit;
		}
		return true;
	}
	
	public static function dbExample($uid, $gui_step) {
        try {
            //$db = Db_Db::pool('main');
			//$sql = "insert into `wininfo`(`uid`,`name`,`phone`,`area`,`addr`,`zcode`) values (?,?,?,?,?,?);";
			//$re = $db->exec ( $sql, array ('1111111111', '11', '13811374620', 'aaa', 'bbb', '100080' ) );
			//$sql = "replace into `wininfo`(`uid`,`name`,`phone`,`area`,`addr`,`zcode`) values (?,?,?,?,?,?);";
			//$re = $db->exec ( $sql, array ('1111111111', '11', '13811374620', 'aaa', 'bbb', '100080' ) );
			//$sql = "select * from `wininfo` where `uid` = ?";
			//$re = $db->fetch_row ( $sql, array ('1111111111' ) );
            return true;
        } catch ( Comm_Exception_Program $e ) { // var_dump($e);
            return false;
        }
    }
}