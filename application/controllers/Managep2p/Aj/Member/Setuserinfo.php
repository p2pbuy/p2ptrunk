<?php
/**
 * 设置userinfo
 * @author liang
 * @version 2014-11-19
 */
class Managep2p_Aj_Member_GetmoreuserinfojsonController extends Managep2p_AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['uid'] = Comm_Context::post('uid','int');
		$info['type'] = Comm_Context::post('type','int');
		$info['alipayusername'] = Comm_Context::post('alipayusername','str');
		
		if(empty($info['uid'])){
			return false;
		}
		
		$userInfos = Dr_User::getUserInfos($info);
		foreach($userInfos as $key => $userInfo){
			$user = Dr_User::show($userInfo['uid']);
			$userInfos[$key]['extends'] = $user[$userInfo['uid']]['extends'];
		}
		
		if($userInfos == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'fail';
			$html = false;
		}else{
			
			$data = $userInfos;
			$code = Tools_Conf::get('Show_Code.api.succ');
			$msg = 'succ';
		}
		
		$this->renderAjax($code,$msg,$data);
		return true;
	}
}