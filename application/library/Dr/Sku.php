<?php
/**
 * SKU类
 * @author liang
 * @version 2015-10-9
 */
class Dr_Sku extends Dw_Abstract{
	//通过接口获取SKU
	public static function getSkuByApi($info = array()){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Sku::getSku($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
	
}