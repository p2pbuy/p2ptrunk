<?php
/**
 * 根据email获得userinfo
 * @author liang
 * @version 2014-11-20
 */
class Managep2p_Aj_Member_GetuserinfobyemailjsonController extends Managep2p_AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['email'] = Comm_Context::get('email','str');
		
		if(empty($info['email'])){
			return false;
		}
		
		$user = Dr_User::getUserInfoByEamilByApi($info);
		$userInfo = Dr_User::show($user['uid']);
		
		if($userInfo == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'fail';
			$html = false;
		}else{
			
			$data = $userInfo[$user['uid']];
			$code = Tools_Conf::get('Show_Code.api.succ');
			$msg = 'succ';
		}
		
		$this->renderAjax($code,$msg,$data);
		return true;
	}
}