<?php
/**
 * 获得更多userinfo
 * @author liang
 * @version 2014-11-19
 */
class Managep2p_Aj_Member_GetmoreuserinfojsonController extends Managep2p_AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['page'] = Comm_Context::post('page','int');
		$info['count'] = Comm_Context::post('count','int');
		
		if(empty($info['page']) || empty($info['count'])){
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