<?php
/**
 * 上传文件类
 * @author liang
 * @version 2014-7-11
 */
class Dw_Upload extends Dw_Abstract{
	// ["type"]=>string(9) "image/png"
	private static $allowFileType = array('image/gif','image/jpeg','image/png','image/pjpeg','image/x-png');
	//通过接口上传文件
	public static function uploadImg($info){
		if($info['file']['size'] > 1024000){
			$result = array('code'=>Tools_Conf::get('Show_Code.aj.upload.fail'),'msg'=>'file size must less than 1MB');
			return $result;
		}
		if(!in_array($info['file']['type'], self::$allowFileType)){
			$result = array('code'=>Tools_Conf::get('Show_Code.aj.upload.fail'),'msg'=>'file type must be gif or png or jpg');
			return $result;
		}

		
		//写入临时文件
    	@move_uploaded_file($info['file']['tmp_name'],$info['file']['tmp_name']);
		try{
			$aclConf = Tools_Conf::get('Api_ACL');
			$info['source'] = 'web';
			$info['sign'] = md5($aclConf[$info['source']]['name'].$info['filename'].$aclConf[$info['source']]['secret_key']);
			$re = Api_Upload::uploadImg($info);
			$result = json_decode($re,true);
		}catch(Exception $e){
			return false;
		}
		return $result;
	}
}