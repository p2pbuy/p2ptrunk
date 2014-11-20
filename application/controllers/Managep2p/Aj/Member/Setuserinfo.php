<?php
/**
 * 设置userinfo
 * @author liang
 * @version 2014-11-19
 */
class Managep2p_Aj_Member_SetuserinfoController extends Managep2p_AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['uid'] = Comm_Context::post('uid','int');
		$info['type'] = Comm_Context::post('type','int');
		$info['alipayusername'] = Comm_Context::post('alipayusername','str');
		
		if(empty($info['uid'])){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'params error';
			$this->renderAjax($code,$msg);
			return false;
		}
		
		if(!is_numeric($info['type'])){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'params error';
			$this->renderAjax($code,$msg);
			return false;
		}
		
		$re = Dw_User::updUserinfoByUid($info);
		
		if($re['code'] == 100000){
			$data = $userInfos;
			$code = Tools_Conf::get('Show_Code.api.succ');
			$msg = 'succ';
		}else{
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'fail';
			$html = false;
		}
		
		$this->renderAjax($code,$msg,$data);
		return true;
	}
}