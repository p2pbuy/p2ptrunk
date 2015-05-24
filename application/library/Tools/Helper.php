<?php
class Tools_Helper{
	//种cookie
	public static function setCookie($params = array()){
		setcookie($params['name'],$params['value'],$params['expire'],$params['path'],$params['domain']);
		return true;
	}
	//根据数值取摩
	public static function getMoore($num,$divisor){
		return $num % $divisor;
	}
	//变短boid
	public static function shorterBoid($boid){
		return substr($boid,10);
	}
	//获得订单状态
	public static function getStatusById($statusId=20,$lock=0){
		switch ($statusId) {
			case 0:
				$re = '已取消';
				break;
			case 20:
				$re = '竞价中';
				break;
			case 30:
				$re = '锁定';
				break;
			case 40:
				$re = '已发货';
				break;
			default:
				$re = '已下单';
				break;
		}
		return $re;
	}
}