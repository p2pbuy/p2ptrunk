<?php
/**
 * 后台 管理用户
 */
class Managep2p_Member_MemberController extends Managep2p_AbstractController{
	public $tpl = 'managep2p/member/member.phtml';
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		
		$managerUid = Tools_Conf::get('Manager.uid');
		$userInfos = Dr_User::getUserInfos();
		$users = array();
		
		foreach($userInfos as $userInfo){
			$usersTmp = Dr_User::show($userInfo['uid']);
			$users[$userInfo['uid']] = $usersTmp[$userInfo['uid']];
		}
		
		$data = array();
		$data['users'] = $users;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}