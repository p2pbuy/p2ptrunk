<?php
/**
 * 后台 管理用户
 */
class Managep2p_Member_MemberController extends Managep2p_AbstractController{
	public $tpl = 'managep2p/member/member.phtml';
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		

		
		$data = array();
		$this->renderPage($this->tpl,$data);
		return true;
	}
}