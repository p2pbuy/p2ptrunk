<?php
class Api_Upload extends Api_Abstract{
	const API_HOST = 'http://api.p2pbuy.net';
	public static $instance = null;
    public static function instance(){
    	if(self::$instance == null){
    		self::$instance = new Api_Httpclient();
    	}
    	return self::$instance;
    }
    public static function getApiUrl($url){
        return self::API_HOST.'/'.trim($url, '/');
    }
    
    /**
     * 上传图片
     */
    public static function uploadImg($info){
    	//读取临时文件
		$fileStr = file_get_contents($info['file']['tmp_name']);
		
    	$params = array(
    		'filename' => $info['filename'],
    		'filetype' => $info['filetype'],
    	    'sign' => $info['sign'],
    		'source' => $info['source'],
    	);
    	
    	$paramsQuery = http_build_query($params);
    	
    	$url = self::getApiUrl('api/upload/uploadimg').'?'.$paramsQuery;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');	
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fileStr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ret = curl_exec($ch);
		//$info = curl_getinfo($ch);
		//$errorMsg = curl_error ( $ch );
		//$errorNumber = curl_errno ( $ch );
		curl_close ( $ch );

		//清除临时文件
		exec('rm -rf '.$info['file']['tmp_name']);
    	return $ret;
    }
}