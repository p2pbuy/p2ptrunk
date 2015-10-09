<?php
/**
 * SKU类
 * @author liang
 * @version 2015-10-6
 */
class Dw_Sku extends Dw_Abstract{
	//通过接口创建SKU
	public static function addSkuByApi($info){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['code'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Sku::addSku($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
	
	//通过接口删除SKU
	public static function delSkuByApi($info){
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['id'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Sku::delSku($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
}