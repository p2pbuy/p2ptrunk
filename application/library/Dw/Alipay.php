<?php
/**
 * 阿里支付类
 * @author liang
 * @version 2014-11-18
 */
class Dw_Alipay extends Dw_Abstract{
	/**
	 * 记录返回数据入库
	 */
	public static function insertResult($info){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['uid'].$info['boid'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Alipay::setPayInfo($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
}